<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class OwnerModel extends Model
{
    protected $table = 'tbl_owners';

    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    public function get_owners_data($table, $tableid, $id = null, $branch_id)
    {

        if ($branch_id !== 1) {
            if ($id) {
                $sql = "SELECT * FROM $table  where $tableid =? AND branch_id = ?";
                $query = $this->db->query($sql, array($id, $branch_id));
                return $query->getRowArray();
            } else {
                $sql = "SELECT * FROM $table WHERE branch_id = $branch_id ORDER BY $tableid ASC";
                $query = $this->db->query($sql);
                return $query->getResultArray();
            }
        } else {
            if ($id) {
                $sql = "SELECT * FROM $table  where $tableid =?";
                $query = $this->db->query($sql, array($id));
                return $query->getRowArray();
            } else {
                $sql = "SELECT * FROM $table ORDER BY $tableid ASC";
                $query = $this->db->query($sql);
                return $query->getResultArray();
            }
        }


    }

    public function get_owners_settlement_data($branch_id)
    {

        // SELECT OW.*,ac.acc_balance FROM tbl_owners as OW JOIN tbl_cl_accounts as ac ON ac.acc_tag = OW.owner_id WHERE ac.acc_balance > 0 ORDER BY OW.owner_id ASC;
        if ($branch_id !== 1) {
            // SELECT * FROM tbl_owners_settlement os JOIN tbl_owners o ON o.owner_id = os.owner_id ORDER BY os.settlement_id ASC;
            // showing data along with owners account balance
            // $sql = "SELECT os.*, o.* , ac.acc_balance FROM tbl_owners_settlement os JOIN tbl_owners o ON o.owner_id = os.owner_id JOIN tbl_cl_accounts ac ON ac.acc_tag = os.owner_id WHERE os.branch_id = $branch_id ORDER BY os.settlement_id ASC";
            $sql = "SELECT os.*, o.*,ac.acc_name FROM tbl_owners_settlement os JOIN tbl_owners o ON o.owner_id = os.owner_id JOIN tbl_cl_accounts ac ON ac.account_id = os.acc_type_id WHERE os.branch_id = $branch_id ORDER BY os.settlement_id ASC";
            $query = $this->db->query($sql);
            return $query->getResultArray();
        } else {
            // showing data along with owners account balance
            // $sql = "SELECT os.*, o.* , ac.acc_balance FROM tbl_owners_settlement os JOIN tbl_owners o ON o.owner_id = os.owner_id JOIN tbl_cl_accounts ac ON ac.acc_tag = os.owner_id ORDER BY os.settlement_id ASC";

            // showing data without owner's account balance
            // $sql = "SELECT os.*, o.* FROM tbl_owners_settlement os JOIN tbl_owners o ON o.owner_id = os.owner_id ORDER BY os.settlement_id ASC";
            $sql = "SELECT os.*, o.*,ac.acc_name FROM tbl_owners_settlement os JOIN tbl_owners o ON o.owner_id = os.owner_id JOIN tbl_cl_accounts ac ON ac.account_id = os.acc_type_id ORDER BY os.settlement_id ASC;";
            $query = $this->db->query($sql);
            return $query->getResultArray();
        }


    }

    public function update_table($table, $data)
    {
        $this->db->table($table)->upsertBatch($data);
        return true;
    }

    // this is for the selection box
    public function getsiteowners()
    {
        $branch_id = (int) session()->get('user')['branch_id'];
        if ($branch_id !== 1) {
            $sql = 'SELECT * FROM tbl_owners WHERE branch_id =' . $branch_id;
            $query = $this->db->query($sql);
            return $query->getResultArray();
        } else {
            $sql = 'SELECT * FROM tbl_owners';
            $query = $this->db->query($sql);
            return $query->getResultArray();
        }
    }


    // this function reads owners that has account in tbl_accounts
    public function getsiteOwnerFrom_accounts(){
        $branch_id = (int) session()->get('user')['branch_id'];
        if ($branch_id !== 1) {
            $sql = 'SELECT ow.*,ac.acc_balance FROM tbl_owners as ow JOIN tbl_cl_accounts as ac ON ac.acc_tag = ow.owner_id WHERE ac.acc_balance > 0 AND branch_id =' . $branch_id;
            $query = $this->db->query($sql);
            return $query->getResultArray();
        } else {
            $sql = 'SELECT ow.*,ac.acc_balance FROM tbl_owners as ow JOIN tbl_cl_accounts as ac ON ac.acc_tag = ow.owner_id WHERE ac.acc_balance > 0';
            $query = $this->db->query($sql);
            return $query->getResultArray();
        }
    }

    // this method returns owner account
    public function get_accountNumber($owner_id)
    {
        $apart = $this->db->query("SELECT AccountNumber FROM tbl_owners WHERE owner_id=$owner_id");
        return $apart->getRow()->AccountNumber;
    }

    public function update_owners_account_balance($owner_id, $amount_paid)
    {
        // get account_id
        $sql = "SELECT account_id FROM tbl_accounts WHERE acc_tag='$owner_id'";
        $query = $this->db->query($sql);
        $id = $query->getRow()->account_id;
        $this->db->query("UPDATE tbl_cl_accounts SET acc_balance=acc_balance-$amount_paid WHERE account_id='$id'");
    }
    public function record_transaction($amount, $source, $cr_tag, $acc_cash, $date, $customer_id): string
    {
        $finance = new FinancialModel();

        $fpid = $finance->financial_period()['fp_id']; // getting the financial period id [ soo hel xisaab xirka sanadlaha ]

        // create summary of the transaction that occured and get the id
        // trx_amount = transaction ka dhacay meeqay ahayd lacagta
        // trx_source = xagee ka timid lacagta ama transaction ka dhacaaya [ HADDA WAANA-QAANAA OO WAA KIRO ]
        // fp_id = id ga xisaab xirka sanadlaha
        $trx_id = $finance->record_trans($amount, $source, $fpid, $date, $customer_id);

        // account cash = which account does he send the money to is it cash,wallet or merchant
        $dracc = $acc_cash; // we are storing this to debit-account since i rent an apartment and i collected a money 
        $cracc = $finance->get_account_tag($cr_tag)['account_id'];

        // save the details of the transactions that occur
        $finance->dr_trx_det((float) $amount, $dracc, $trx_id);
        $finance->cr_trx_det((float) $amount, $cracc, $trx_id);

        // update my account's balance
        $finance->update_accounnt_balance($dracc, (float) $amount, 'dr');
        $finance->update_accounnt_balance($cracc, (float) $amount, 'cr');

        return $trx_id;
    }
    public function create_owner_settlement($data, $acc_cash)
    {
        $this->db->transStart();
        $this->db->transException(true);




        // fetch passed data 
        $owner_id = $data['owner_id'];
        $Paying_Amount = $data['paid_amount'];
        // $customer_id = $data['customer_id'];
        // $depositMoney = $data['deposit'];
        $date = date("Y-m-d");


        # ===============================================  RECORD THE TRANSACTION THAT OCCURED ================================================ #
        $finance = new FinancialModel();

        $fpid = $finance->financial_period()['fp_id']; // getting the financial period id [ soo hel xisaab xirka sanadlaha ]

        // create summary of the transaction that occured and get the id
        // trx_amount = transaction ka dhacay meeqay ahayd lacagta
        // trx_source = xagee ka timid lacagta ama transaction ka dhacaaya [ HADDA WAANA-QAANAA OO WAA KIRO ]
        // fp_id = id ga xisaab xirka sanadlaha
        $trx_id = $finance->record_trans($Paying_Amount, "Settlement Owner", $fpid, $date, $owner_id);

        // account cash = which account does he send the money to is it cash,wallet or merchant
        // $dracc = $finance->get_custom_account_tag($owner_id, "OWNER")['account_id'];
        $dracc = $finance->get_custom_account_tag($owner_id, "OWNER")['account_id'];
        $cracc = $acc_cash;

        // dd($owner_id,$dracc,$cracc,$Paying_Amount);
        // save the details of the transactions that occur
        $finance->dr_trx_det((float) $Paying_Amount, $dracc, $trx_id);
        $finance->cr_trx_det((float) $Paying_Amount, $cracc, $trx_id);

        // update my account's balance
        $finance->update_accounnt_balance($dracc, (float) $Paying_Amount, 'dr');
        $finance->update_accounnt_balance($cracc, (float) $Paying_Amount, 'cr');

        $data['trx_id'] = $trx_id;
        $settlement_id = $this->store('tbl_owners_settlement', $data);

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return $trx_id;
        }
    }





















































}