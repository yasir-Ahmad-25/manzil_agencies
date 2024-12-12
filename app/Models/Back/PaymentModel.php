<?php

namespace App\Models\Back;

use App\Models\Back\FinancialModel;
use CodeIgniter\Model;

class PaymentModel extends Model
{

    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }
    public function get_deposits(){
        return $this->db->query('SELECT cu.cust_name, d.amount,d.created_at,acc.acc_name from tbl_deposit d join tbl_customers cu on cu.customer_id=d.customer_id join tbl_cl_accounts acc on acc.account_id=d.account_id where d.amount < 0')->getResultArray();
    }
    public function update_table($table, $data)
    {
        $this->db->table($table)->upsertBatch($data);
        return true;
    }


    public function get_cash_bank_accounts()
    {
        $brid = session()->get('user')['branch_id'];
        $sql = "SELECT account_id, acc_name FROM tbl_cl_accounts acc 
        JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id WHERE tp.acc_type_tag='CB'";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_payment_info()
    {
        $brid = session()->get('user')['branch_id'];

        $sql = "SELECT pay_id, p.sup_id, s.sup_name, pay_amount, pay_date, pay_status, p.account_id, acc_name, trx_id FROM tbl_supplier_payments p 
            JOIN tbl_cl_accounts acc ON acc.account_id=p.account_id
            JOIN tbl_suppliers s ON s.sup_id=p.sup_id WHERE s.branch_id='$brid' order by pay_id desc";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function update_bal($amount, $sid, $trid)
    {
        $data = [
            'sup_id' => $sid,
            'created_date' => date('Y-m-d'),
            'remarks' => 'Payment',
            'amount' =>  $amount,
            'balance' => $this->db->query("SELECT acc_balance FROM tbl_cl_accounts WHERE acc_tag='$sid' and acc_set='Supplier'")->getRow()->acc_balance,
            'trx_id' =>  $trid,
        ];

        $this->store('tbl_supplier_balances', $data);
    }

    public function delete_payment(): bool
    {

        $pay_id = $this->request->getVar('_pay_id');
        $trx_id = $this->request->getVar('_trx_id');
        $amount = $this->request->getVar('_amount');
        $supid = $this->request->getVar('_sup_id');

        $this->db->transStart();

        # delete payment
        $this->db->query("DELETE FROM `tbl_supplier_payments` WHERE pay_id='$pay_id'");

        # delete supplier_balance 
        $this->db->query("DELETE FROM `tbl_supplier_balances` WHERE trx_id='$trx_id'");

        # rollback trx
        $this->delete_account_trx($trx_id, $amount);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function delete_account_trx($trx_id, $amount)
    {
        $trx_details = $this->get_trx_details($trx_id);

        foreach ($trx_details as $trx_detail) {

            $account_id = $trx_detail['account_id'];
            $this->db->query("UPDATE tbl_cl_accounts SET acc_balance = acc_balance+$amount WHERE account_id='$account_id'");
        }

        $this->db->query("delete from tbl_cl_trans_details where trx_id='$trx_id'");
        $this->db->query("delete from tbl_cl_transections where trx_id='$trx_id'");
    }

    public function get_trx_details($trx_id)
    {
        $account = $this->db->query("SELECT * from tbl_cl_trans_details WHERE trx_id='$trx_id'");
        return $account->getResultArray();
    }


    public function account_balance($account_id)
    {
        $account = $this->db->query("SELECT acc_balance FROM `tbl_cl_accounts` WHERE account_id='$account_id'");
        return $account->getRow()->acc_balance;
    }

    public function record_payment($accid, $amount, $suppid, $date): bool
    {
        #start transaction
        $dis = 0;

        $this->db->transBegin();

        $trid =  $this->record_transactions('Payment', $amount, $suppid, $accid, $date);

        $data = [
            'pay_amount' => $amount,
            'sup_id' => $suppid,
            'account_id' =>  $accid,
            'pay_date' => $date,
            'trx_id' => $trid,
        ];
        $pay_id = $this->store('tbl_supplier_payments', $data);

        $this->update_bal(($amount + $dis), $suppid, $trid);

        #commit/rollback transaction
        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }
    public function deposit_payment($accid, $amount, $custid, $date): bool
    {
        #start transaction
        $dis = 0;

        $this->db->transBegin();

        $trid =  $this->record_deposit_transaction('Deposit Payment', $amount, $custid, $accid, $date);

        $data = [
            'amount' => -$amount,
            'amount_bal' => -$amount,
            'customer_id' => $custid,
            'account_id' =>  $accid,
        ];
        $pay_id = $this->store('tbl_deposit', $data);

        // $this->update_bal(($amount + $dis), $suppid, $trid);

        #commit/rollback transaction
        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function record_transactions($source, $amount, $suppid, $cb_acc, $date): string
    {
        $finance = new FinancialModel();

        $fpid = $finance->financial_period()['fp_id'];

        $trx_id = $finance->record_trans($amount, $source, $fpid, $date, '');

        $dracc = $finance->get_account_tag_set($suppid, 'Supplier')['account_id'];
        $cracc = $cb_acc;

        $finance->cr_trx_det((int) $amount, $cracc, $trx_id);
        $finance->update_accounnt_balance($cracc, $amount, 'cr');

        $finance->dr_trx_det((int) $amount, $dracc, $trx_id);
        $finance->update_accounnt_balance($dracc, $amount, 'dr');

        return $trx_id;
    }
    public function record_deposit_transaction($source, $amount, $custid, $cb_acc, $date): string
    {
        $finance = new FinancialModel();

        $fpid = $finance->financial_period()['fp_id'];

        $trx_id = $finance->record_trans($amount, $source, $fpid, $date, '');

        $dracc = $finance->get_account_tag('DP')['account_id'];
        $cracc = $cb_acc;

        $finance->cr_trx_det((int) $amount, $cracc, $trx_id);
        $finance->update_accounnt_balance($cracc, $amount,'cr');

        $finance->dr_trx_det((int) $amount, $dracc, $trx_id);
        $finance->update_accounnt_balance($dracc, $amount,'dr');

        return $trx_id;
    }
}
