<?php

namespace App\Models\Back;

use App\Models\Back\FinancialModel;
use CodeIgniter\Model;

class InvoiceModel extends Model
{

    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    public function update_table($table, $data)
    {
        $this->db->table($table)->upsertBatch($data);
        return true;
    }

    public function generate_invoice_no()
    {
        $sql = "SELECT inv_no FROM tbl_supplier_invoices ORDER BY inv_no desc limit 1";
        $query = $this->db->query($sql);
        $bill_no = $query->getRowArray();

        if ($bill_no) {
            $bill_no = $bill_no['inv_no'];
            $bill_no = substr($bill_no, 3);
            $bill_no = (int) $bill_no;
            $bill_no = $bill_no + 1;
            $bill_no = 'INV' . str_pad($bill_no, 1, '0', STR_PAD_LEFT);
        } else {
            $bill_no = 'INV1';
        }

        return $bill_no;
    }


    public function get_expense_accounts()
    {
        $brid = session()->get('user')['branch_id'];

        $sql = "SELECT account_id,acc_name, acc_tag FROM tbl_cl_accounts 
                WHERE acc_grp_id='5' AND acc_status='Active'";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_invoice_info()
    {
        $brid = session()->get('user')['branch_id'];
        $sql = "SELECT inv_id, inv_no,sup.sup_id,inv.account_exp_id,inv_ref,inv.trx_id, amount,inv_date,inv_status,remarks,
                balance, acc_name, sup_name FROM tbl_supplier_invoices inv
                JOIN tbl_suppliers sup ON sup.sup_id=inv.sup_id
                JOIN tbl_cl_accounts acc ON acc.account_id=inv.account_exp_id WHERE sup.branch_id='$brid' order by inv_id desc";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }


    public function record_transactions($source, $amount, $suppid, $exp_acc, $remarks): string
    {
        $finance = new FinancialModel();

        $fpid = $finance->financial_period()['fp_id'];
        $date = date('Y-m-d');

        $sup_name = $this->db->query("SELECT sup_name FROM tbl_suppliers WHERE sup_id='$suppid'")->getRow()->sup_name;
        $trx_id = $finance->record_trans($amount, $source, $fpid, $date, $sup_name, $remarks);

        $dracc = $exp_acc;
        $cracc = $finance->get_account_tag_set($suppid, 'Supplier')['account_id'];

        $finance->cr_trx_det((float) $amount, $cracc, $trx_id);
        $finance->update_accounnt_balance($cracc, $amount);

        $finance->dr_trx_det((float) $amount, $dracc, $trx_id);
        $finance->update_accounnt_balance($dracc, $amount);

        return $trx_id;
    }

    public function redo_account_trx($trx_id, $ttl)
    {
        $finance = new FinancialModel();

        $trx_details = $finance->get_trx_details($trx_id);

        foreach ($trx_details as $trx_detail) {

            $account_id = $trx_detail['account_id'];
            $amount = $ttl;

            $this->db->query("UPDATE tbl_cl_accounts SET acc_balance = acc_balance-$amount WHERE account_id='$account_id'");
        }

        $this->db->query("delete from tbl_cl_trans_details where trx_id='$trx_id'");
        $this->db->query("delete from tbl_cl_transections where trx_id='$trx_id'");

        $sid = $_POST['old_sup_id'];
    }


    public function get_total_invoice()
    {
        $inv = $this->input->post('inv_id');
        $inv = $this->db->query("SELECT balance FROM tbl_supplier_invoices WHERE inv_id='$inv'");
        echo $inv->getRow()->balance;
    }

    public function update_bal($amount, $sid, $trid)
    {
        $data = [
            'sup_id' => $sid,
            'created_date' => $_POST['inv_date'],
            'remarks' => 'Bill(' . $_POST['inv_ref'].'),'. $_POST['inv_rem'],
            'amount' =>  $amount,
            'balance' => $this->db->query("SELECT acc_balance FROM tbl_cl_accounts WHERE acc_tag='$sid' and acc_set='Supplier'")->getRow()->acc_balance,
            'trx_id' =>  $trid,
        ];

        $this->store('tbl_supplier_balances', $data);
    }

    public function update_sup_bal($sid, $amount, $old_trid, $new_trid)
    {
        $this->db->query("update tbl_supplier_balances set sup_id='$sid', amount=$amount where trx_id='$old_trid'");
        $this->db->query("update tbl_supplier_balances set trx_id='$new_trid' where trx_id='$old_trid'");
    }


    public function get_outstanding_invoices($sid): string
    {
        $output = [];
        $output['bill'] = '';
        $sql = "SELECT sum(acc_balance) total FROM tbl_cl_accounts WHERE acc_tag='$sid' and acc_set='Supplier'";
        $output['total'] = $this->db->query($sql)->getRow()->total ?? 0;
        return json_encode($output);
    }
}
