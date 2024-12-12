<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class FinancialModel extends Model
{
    protected $table   = 'tbl_menus';

    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return true;
    }


    function get_tag1($custom_id)
    {
        $query = $this->db->query("select t.acc_type_tag from tbl_cl_accounts a join tbl_cl_account_types t
         on t.acc_type_id=a.acc_type_id where a.account_id='$custom_id'");
        return $query->getRow();
    }
    public function get_tag($custom_id)
    {
        $sql = "SELECT t.acc_type_tag FROM tbl_cl_accounts a JOIN tbl_cl_account_types t
                ON t.acc_type_id = a.acc_type_id WHERE a.acc_type_id = '$custom_id' LIMIT 1";
        $query = $this->db->query($sql);

        // Check if the query was successful
        if ($query->getNumRows() > 0) {
            // Fetch the result as an object
            $result = $query->getRow();

            // Extract the acc_type_tag value
            $accTypeTag = $result->acc_type_tag;

            // Return the extracted value
            return $accTypeTag;
        } else {
            // Handle the case when no rows are found
            return null;
        }
    }



    public function update_account_balance($acc_id, $bal)
    {
        $this->db->query("UPDATE tbl_cl_accounts SET acc_balance=acc_balance+$bal WHERE account_id='$acc_id' ");
    }

    public function get_all_accounts()
    {
        $row = $this->db->query("SELECT acc.account_id,acc_name,`acc_type_name_ar` FROM tbl_cl_accounts acc
        JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id WHERE tp.`acc_type_tag`!='CB'")->getResultArray();
        return $row;
    }

    public function get_cash_accounts()
    {
        $sql = "SELECT acc.account_id,acc_name,acc_type_name_ar FROM tbl_cl_accounts acc
        JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id WHERE tp.acc_type_tag='CB'";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }



    public function get_total_income($from, $to)
    {
        $brid = session()->get('user')['branch_id'];

        $sql = "SELECT SUM(cr_amount - dr_amount) total FROM tbl_cl_trans_details dt 
        JOIN tbl_cl_accounts acc ON acc.account_id=dt.account_id JOIN tbl_cl_transections tr on tr.trx_id=dt.trx_id
        JOIN tbl_cl_account_groups grp ON acc.acc_grp_id=grp.acc_grp_id WHERE (tr.trx_date >= '$from' and tr.trx_date <= '$to')
        AND grp.acc_grp_name='Revenue'";
        $query = $this->db->query($sql);
        return $query->getRow()->total;
    }
    public function get_total_exp($from, $to)
    {
        $brid = session()->get('user')['branch_id'];

        $sql = "SELECT SUM(dr_amount - cr_amount) total FROM tbl_cl_trans_details dt 
        JOIN tbl_cl_accounts acc ON acc.account_id=dt.account_id JOIN tbl_cl_transections tr on tr.trx_id=dt.trx_id
        JOIN tbl_cl_account_groups grp ON acc.acc_grp_id=grp.acc_grp_id WHERE (tr.trx_date >= '$from' and tr.trx_date <= '$to')
        and grp.acc_grp_name='Expenses'";
        $query = $this->db->query($sql);
        return $query->getRow()->total;
    }



    # ACCOUNT STATEMENTS #


    public function get_bank_accounts()
    {
        $brid = session()->get('user')['branch_id'];
        $query = $this->db->query("SELECT * From tbl_cl_accounts where acc_status = 'Active' AND acc_type_id = '1'");

        return $query->getResultArray();
    }
    public function get_other_accounts()
    {
        $brid = session()->get('user')['branch_id'];

        $query = $this->db->query("SELECT * From tbl_cl_accounts where acc_status = 'Active' AND acc_type_id != '1'");
        return $query->getResultArray();
    }
    /**
     * Account Functions
     */

    public function update_acc($accid, $data)
    {
        $this->db->query("update tbl_cl_accounts set acc_name = '" . $data['acc_name'] . "',acc_name_ar = '" . $data['acc_name_ar'] . "', acc_des = '" . $data['acc_des'] . "' where account_id = '" . $accid . "'");
        return true;
    }
    public function del_acc($accid)
    {
        ## chcek if accounts has transactions

        $account_has_trxs = $this->db->query("SELECT * FROM tbl_cl_trans_details WHERE account_id='$accid' ")->getNumRows() > 0;
        if (! $account_has_trxs) {
            $this->db->query("update tbl_cl_accounts set acc_status = 'Deleted' where account_id = '" . $accid . "'");
            return true;
        } else return false;
    }
    /**
     * End of Account Functions
     */

    public function financial_period()
    {
        $brid = session()->get('user')['branch_id'];
        $data = $this->db->query("SELECT * From tbl_cl_financial_period where fp_status = 'Active'")->getResultArray();

        if (count($data) == 0) $state = 'None';
        else if (count($data) > 1)  $state = 'Multiple';
        else [$fp_id = $data[0]['fp_id'], $state = 'Ok'];
        return ['state' => $state, 'fp_id' => $fp_id ?? null];
    }
    public function get_account_tag($tag) # Get Account By tag
    {
        $brid = session()->get('user')['branch_id'];
        $data = $this->db->query("SELECT * From tbl_cl_accounts where acc_status = 'Active' AND acc_tag = '$tag'")->getResultArray();
        if (count($data) == 0) $state = 'None';
        else if (count($data) > 1) $state = 'Multiple';
        else [$account_id = $data[0]['account_id'], $state = 'Ok'];
        return ['state' => $state, 'account_id' => $account_id  ?? null];
        // return $data;
    }

    public function get_account_tag_set($tag, $set) # Get Account By tag
    {
        $data = $this->db->query("SELECT * From tbl_cl_accounts where acc_status = 'Active' AND acc_tag = '$tag' AND acc_set='$set'")->getResultArray();
        if (count($data) == 0) $state = 'None';
        else if (count($data) > 1) $state = 'Multiple';
        else [$account_id = $data[0]['account_id'], $state = 'Ok'];
        return ['state' => $state, 'account_id' => $account_id  ?? null];
        // return $data;
    }

    public function record_trans($trx_amount, $trx_source, $fp_id, $date, $custid = '', $des = '') # Record trx = transections
    {
        $data = [
            //'trx_cust'  =>  $custid,
            'trx_source' => $trx_source, # var
            'trx_date' => $date,
            'trx_amount' => $trx_amount, # var
            'fp_id' => $fp_id, # var
            'trx_status' => 'Posted',
            'trx_des' => $des,
            'branch_id' => session()->get('user')['branch_id'],
        ];
        $this->store('tbl_cl_transections', $data);
        return  $this->db->insertID();
    }
    public function get_custom_account_tag($tag, $accset) # Get Account By tag
    {
        $data = $this->db->query("SELECT * From tbl_cl_accounts where acc_status = 'Active' AND acc_tag = '$tag' and acc_set='$accset'")->getResultArray();
        if (count($data) == 0)
            $state = 'None';
        else if (count($data) > 1)
            $state = 'Multiple';
        else
            [$account_id = $data[0]['account_id'], $state = 'Ok'];
        return ['state' => $state, 'account_id' => $account_id ?? null];
        // return $data;
    }
    public function update_accounnt_balance($account_id, $amount, $value_type) # Record trx = transections
    {
        // $amount=abs($amount);
        $data = $this->db->query("SELECT * From tbl_cl_accounts where account_id = '" . $account_id . "'")->getResultArray();
        if (count($data) == 0)
            $state = 'None';
        else {
            if ($this->get_accgrp_nature($account_id) == $value_type) {
                if (is_null($amount) || empty($amount)) {
                    $amount = 0;
                }
                $this->db->query("UPDATE `tbl_cl_accounts` SET acc_balance = acc_balance + " . $amount . " WHERE account_id='" . $account_id . "'");
            } else {
                $this->db->query("UPDATE `tbl_cl_accounts` SET acc_balance = acc_balance - " . $amount . " WHERE account_id='" . $account_id . "'");
            }
            // ['state' => $state ?? 'Ok', 'account_id' => $data[0]['account_id']  ?? null];
            $state = true;
        }
        return ['state' => $state ?? 'Ok', 'account_id' => $data[0]['account_id'] ?? null];
    }

    public function trx_det($dr_cr, $amount, $account_id, $trx_id, $trx_des) # Record trans_details
    {
        $data = [
            'trx_id'  =>  $trx_id, #var
            'account_id' =>  $account_id, #var
        ];
        switch ($dr_cr) {
            case 'dr':
                $data['dr_amount'] = $amount;
                $data['cr_amount'] = 0;
                break;
            case 'cr':
                $data['dr_amount'] = 0;
                $data['cr_amount'] = $amount;
                break;
            default:

                break;
        }
        return $this->store('tbl_cl_trans_details', $data);
    }

    public function dr_trx_det($dr_amount, $account_id, $trx_id) # Record dr account
    {
        $data = [ #dr for queue pay 
            'trx_id'  =>  $trx_id, #var
            'account_id' =>  $account_id, #var
            'dr_amount' => $dr_amount, #var
            'cr_amount' => 0,
        ];
        return $this->store('tbl_cl_trans_details', $data);
    }
    public function cr_trx_det($cr_amount, $account_id, $trx_id) # Record cr account
    {
        $data = [ #dr for queue pay 
            'trx_id'  =>  $trx_id, #var
            'account_id' =>  $account_id, #var
            'dr_amount' => 0, #var
            'cr_amount' =>  $cr_amount, #var
        ];
        return $this->store('tbl_cl_trans_details', $data);
    }
    public function record_trx($trx_amount, $trx_source, $fp_id, $date, $des = '') # Record trx = transactions
    {
        $data = [
            'profile_no' => '',
            'trx_date' => $date,
            'trx_source' => $trx_source, # var
            'trx_timestamp' => time(),
            'trx_amount' => $trx_amount, # var
            'fp_id' => $fp_id, # var
            'trx_status' => 'Posted',
            'trx_des' => $des,
            'branch_id' => session()->get('user')['branch_id'],
        ];
        $this->store('tbl_cl_transections', $data);
        return  $this->db->insertID();
    }

    public function increase_account_balance($account_id, $amount) # Update account balance
    {

        $data = $this->db->query("SELECT * From tbl_cl_accounts where account_id = '$account_id' ")->getResultArray();
        if (count($data) == 0) $state = 'None';
        else {
            $this->db->query("UPDATE `tbl_cl_accounts` SET acc_balance = acc_balance+$amount WHERE account_id='$account_id'");
            $state = true;
        }
        return ['state' => $state ?? 'Ok', 'account_id' => $data[0]['account_id']  ?? null];
    }
    // Decrease Account Balance
    public function decrease_account_balance($account_id, $amount) # Update account balance
    {

        $data = $this->db->query("SELECT * From tbl_cl_accounts where account_id ='$account_id'")->getResultArray();
        if (count($data) == 0) $state = 'None';
        else {
            $this->db->query("UPDATE `tbl_cl_accounts` SET acc_balance = acc_balance-$amount WHERE account_id='$account_id'");
            $state = true;
        }
        return ['state' => $state ?? 'Ok', 'account_id' => $data[0]['account_id']  ?? null];
    }

    public function get_account_groups()
    {
        $data = $this->db->query("SELECT * From tbl_cl_account_groups ")->getResultArray();
        return $data;
    }

    public function get_spcl_account_groups()
    {
        $data = $this->db->query("SELECT * From tbl_cl_account_groups where acc_grp_name IN('Assets','Liabilities','Equity') ")->getResultArray();
        return $data;
    }
    // get list of get_acc_account_types by group
    public function get_cl_account_types($acc_grp_id)
    {

        $data = $this->db->query("SELECT * From tbl_cl_account_types where acc_grp_id = '$acc_grp_id'")->getResultArray();
        return $data;
    }
    // get No of acc_account_types by group
    public function no_cl_account_types($acc_grp_id)
    {
        $data = $this->db->query("SELECT count(acc_type_id) as acc_type_no From tbl_cl_account_types where acc_grp_id = '$acc_grp_id'")->getResultArray()[0]['acc_type_no'];
        return $data;
    }
    // get list of get_acc_account_types by group
    public function sum_cl_account_types($acc_type_id, $currid = 1)
    {
        $brid = session()->get('user')['branch_id'];

        $data = $this->db->query("SELECT SUM(acc_balance) AS type_balance FROM tbl_cl_accounts 
        WHERE acc_type_id = '$acc_type_id' AND acc_status = 'Active'")->getRow()->type_balance;
        return $data ?? ' 0.00';
    }
    // get list of acc_accounts by type
    public function get_cl_accounts_by_type($acc_type_id)
    {
        $brid = session()->get('user')['branch_id'];

        $data = $this->db->query("SELECT * From tbl_cl_accounts WHERE acc_status = 'Active' 
        AND acc_type_id = '$acc_type_id '")->getResultArray();
        return $data;
    }
    // get No of acc_accounts by type
    public function no_cl_accounts($acc_type_id)
    {
        $brid = session()->get('user')['branch_id'];
        $data = $this->db->query("SELECT count(account_id) as acc_no From tbl_cl_accounts 
        where acc_status = 'Active' AND acc_type_id = '$acc_type_id'")->getResultArray()[0]['acc_no'];
        return $data;
    }
    // get list of get_acc_accounts by group
    public function get_cl_accounts($acc_grp_id)
    {
        $data = $this->db->query("SELECT * From tbl_cl_accounts WHERE acc_status = 'Active' AND acc_grp_id = '$acc_grp_id'")->getResultArray();
        return $data;
    }
    // get get_acc_all_accounts
    public function get_cl_all_accounts()
    {
        $brid = session()->get('user')['branch_id'];
        $data = $this->db->query("SELECT * From tbl_cl_accounts where acc_status = 'Active'")->getResultArray();
        return $data;
    }


    public function fp_initiate()
    {

        if (!$this->fp_started()) {
            $data = array(
                'fp_start_date' => date('Y-m-d'),
                'fp_end_date' => date('Y-m-d', strtotime('+12 months')),
                'fp_status' => 'Active',
                'fp_des' => 'New Financial Period',
            );
            $this->db->table('tbl_cl_financial_period')->insert($data);
            //$this->db->insert('tbl_cl_financial_period', $data);
        }
    }

    public function fp_started()
    {
        $dt = date('Y-m-d');
        $fp =  $this->db->query("SELECT * FROM tbl_cl_financial_period where fp_status ='Active'");
        return $fp->getNumRows() > 0 ? true : false;
    }
    public function fp_info()
    {
        $fp =  $this->db->query("SELECT * FROM tbl_cl_financial_period where fp_status ='Active'");
        return $fp->getRow();
    }

    public function fp_end()
    {
        $date = date('Y-m-d');
        $this->db->query("UPDATE tbl_cl_financial_period SET fp_end_date='$date' WHERE fp_status='Active'");
        $this->db->query("UPDATE tbl_cl_financial_period SET fp_status='InActive' WHERE fp_status='Active'");

        # start new financial period
        $this->fp_initiate();
    }

    public function get_inc_exp_total()
    {
        $query = $this->db->query("SELECT SUM(acc_balance) as total FROM tbl_cl_accounts a 
        JOIN tbl_cl_account_types t on a.acc_type_id = t.acc_type_id and t.acc_type_tag ='INC' OR a.acc_tag = 'EXP'");
        return $query->getRow()->total;
    }


    public function get_trx_sources()
    {
        $query = $this->db->query("SELECT trx_source FROM tbl_cl_transections GROUP BY trx_source ");
        return $query->getResultArray();
    }

    public function getDatesBetween($startDate, $endDate)
    {
        try {
            $sql = "SELECT * FROM tbl_cl_transections WHERE trx_date >= ? AND trx_date <= ?";
            $query = $this->db->query($sql, [$startDate, $endDate]);

            return $query->getResult();
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }




    public function trxtotal($src)
    {
        // $row = $this->db->query("SELECT tr.trx_id,trx_source,trx_timestamp,trx_amount from tbl_cl_transections tr 
        //                         WHERE $src LIMIT 250")->getResultArray();
        $row = $this->db->query("SELECT SUM(trx_amount) 
        FROM tbl_cl_transections
        WHERE  $src LIMIT 250
        ")->getResultArray();



        return $row;
    }

    public function trx_details($trid)
    {

        $sql = "SELECT trx_id,acc.account_id, acc_name,dr_amount,cr_amount 
                FROM tbl_cl_trans_details td 
                JOIN tbl_cl_accounts acc on td.account_id = acc.account_id 
                WHERE trx_id = '$trid' ";

        $row = $this->db->query($sql)->getResultArray();
        return $row;
    }

    public function get_acc_nature($id)
    {
        $account = $this->db->query("SELECT acc_grp_nature FROM tbl_cl_account_groups WHERE acc_grp_id='$id'");
        return $account->getRow()->acc_grp_nature;
    }

    public function get_accounts_data($id)
    {

        $results = $this->db->query("SELECT acc.acc_grp_id,acc_type_name,acc.acc_name, SUM(dr_amount) debit , SUM(cr_amount) credit FROM tbl_cl_trans_details det 
           JOIN tbl_cl_transections tr ON tr.trx_id=det.trx_id
           JOIN tbl_cl_financial_period fp ON fp.fp_id=tr.fp_id
           JOIN tbl_cl_accounts acc ON acc.account_id=det.account_id 
           JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id
        WHERE acc.acc_type_id='$id' AND fp.fp_status='Active'
        GROUP BY acc.account_id");

        return $results->getResultArray();
    }

    public function getAccountsByGrp($grpid)
    {
        $row = $this->db->query("SELECT * from tbl_cl_accounts where acc_grp_id ='$grpid'")->getResultArray();
        return $row;
    }

    public function getAccTypes($grpid)
    {

        $row = $this->db->query("SELECT * FROM tbl_cl_account_types WHERE acc_grp_id = '$grpid'")->getResultArray();

        return $row;
    }


    public function getAccounts($tid)
    {
        $row = $this->db->query("SELECT * FROM tbl_cl_accounts WHERE acc_type_id ='$tid'")->getResultArray();

        return $row;
    }

    public function getTypeBal($tid)
    {

        return $this->db->query("SELECT sum(acc_balance) as ttl FROM tbl_cl_accounts WHERE acc_type_id = " . $tid)->getRow()->ttl;
    }

    public function get_rev_expenses()
    {
        $query = $this->db->query("SELECT * FROM tbl_cl_account_groups WHERE acc_grp_name='Revenue' OR acc_grp_name='Expenses'");
        return $query->getResultArray();
    }


    public function get_accTyps()
    {

        $results = $this->db->query("SELECT tp.acc_grp_id,tp.acc_type_id,acc_type_name, SUM(dr_amount) debit , SUM(cr_amount) credit FROM tbl_cl_trans_details det 
            JOIN tbl_cl_accounts acc ON acc.account_id=det.account_id 
            JOIN tbl_cl_account_groups grp ON acc.acc_grp_id=grp.acc_grp_id 
            JOIN tbl_cl_transections tr ON tr.trx_id=det.trx_id
            JOIN tbl_cl_financial_period fp ON fp.fp_id=tr.fp_id
            JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id WHERE fp.fp_status='Active'
            GROUP BY tp.acc_type_id");

        return $results->getResultArray();
    }

    public function get_total_liability_equity($from, $to)
    {
        $brid = session()->get('user')['branch_id'];

        $sql = "SELECT SUM(cr_amount - dr_amount) total FROM tbl_cl_trans_details dt 
        JOIN tbl_cl_accounts acc ON acc.account_id=dt.account_id JOIN tbl_cl_transections tr on tr.trx_id=dt.trx_id
        JOIN tbl_cl_account_groups grp ON acc.acc_grp_id=grp.acc_grp_id WHERE (tr.trx_date >= '$from' and tr.trx_date <= '$to')
        AND grp.acc_grp_name IN ('Liabilities','Equity')";

        $results = $this->db->query($sql);

        return $results->getRow()->total;
    }

    public function get_acc_info($id)
    {
        $account = $this->db->query("SELECT acc_name, acc_balance FROM tbl_cl_accounts WHERE account_id='$id'");
        return $account->getResult()[0] ?? null;
    }

    public function get_acc_history($id)
    {
        $history = $this->db->query("SELECT trx_date,trx_source,trx_des,dr_amount, cr_amount
            FROM tbl_cl_trans_details det
            JOIN tbl_cl_transections trx ON trx.trx_id=det.trx_id 
            JOIN tbl_cl_financial_period fp ON fp.fp_id=trx.fp_id
            WHERE det.account_id='$id'");

        return $history->getResultArray();
    }

    public function get_sales_fliter($startDate, $endDate)
    {
        $sql = "SELECT 
                    tr.trx_id, 
                    trx_source, 
                    trx_date, 
                    trx_amount 
                FROM 
                    tbl_cl_transections tr 
                WHERE 
                    trx_date BETWEEN ? AND ?";

        // Prepare and execute the query
        $query = $this->db->query($sql, [$startDate, $endDate]);

        // Return the result as an array
        return $query->getResultArray();
    }

    // get transaction details for a specific
    public function get_trx_details($id)
    {
        $trx_det = $this->db->query("select * from tbl_cl_trans_details where trx_id='$id'");
        return $trx_det->getResultArray();
    }

    public function get_acc_history_date($id, $sdate, $edate)
    {
        $sdater = strtotime($sdate);
        $edater = strtotime($edate);

        $history = $this->db->query("SELECT trx_timestamp,trx_source,trx_des, trx_date, dr_amount, cr_amount
            FROM tbl_cl_trans_details det
            JOIN tbl_cl_transections trx ON trx.trx_id=det.trx_id 
            JOIN tbl_cl_financial_period fp ON fp.fp_id=trx.fp_id
            JOIN tbl_cl_accounts acc ON acc.account_id=det.account_id
            WHERE acc.account_id='$id' AND (trx_timestamp >='$sdater' AND trx_timestamp <= '$edater')");

        return $history->getResultArray();
    }
    public function get_accgrp_nature($id)
    {
        $account = $this->db->query("SELECT acc_grp_nature FROM tbl_cl_account_groups grp 
        JOIN tbl_cl_accounts acc ON acc.acc_grp_id=grp.acc_grp_id WHERE acc.account_id='$id'");
        return $account->getRow()->acc_grp_nature;
    }
    public function get_trans()
    {
        $brid = session()->get('user')['branch_id'];
        $query = $this->db->query("select * from tbl_cl_transections where branch_id='$brid'");

        return $query->getResultArray();
    }


    public function trx($src)
    {
        $brid = session()->get('user')['branch_id'];

        $src = ($src == '0') ? "branch_id='$brid' ORDER BY trx_id DESC" : "trx_source='$src' AND branch_id='$brid' ORDER BY trx_id DESC";

        $row = $this->db->query("SELECT tr.trx_id,trx_source,trx_date,trx_amount from tbl_cl_transections tr WHERE $src LIMIT 250")->getResultArray();

        return $row;
    }

    ### new methods ###
    public function get_income_statements($grid, $from, $to)
    {
        $brid = session()->get('user')['branch_id'];

        if ($from == 'all' || $to == 'all') {
            $query = $this->db->query("SELECT acc.account_id, acc.acc_name, SUM(dt.cr_amount) cramount, SUM(dt.dr_amount) dramount FROM tbl_cl_accounts acc 
        JOIN tbl_cl_trans_details dt ON dt.account_id=acc.account_id WHERE acc.acc_grp_id='$grid' GROUP BY acc.account_id ");
        } else {

            $query = $this->db->query("SELECT acc.account_id, acc.acc_name, SUM(dt.cr_amount) cramount, SUM(dt.dr_amount) dramount FROM tbl_cl_accounts acc 
        JOIN tbl_cl_trans_details dt ON dt.account_id=acc.account_id JOIN tbl_cl_transections tr ON tr.trx_id=dt.trx_id 
        WHERE acc.acc_grp_id='$grid' AND (tr.trx_date >= '$from' and tr.trx_date <= '$to') GROUP BY acc.account_id ");
        }


        return $query->getResultArray();
    }
    public function get_balance_sheet_table($tid, $from, $to)
    {
        $brid = session()->get('user')['branch_id'];

        if ($from == 'all' || $to == 'all') {
            $query = $this->db->query("SELECT acc.account_id, acc.acc_name, SUM(dt.cr_amount) cramount, SUM(dt.dr_amount) dramount FROM tbl_cl_accounts acc 
        JOIN tbl_cl_trans_details dt ON dt.account_id=acc.account_id WHERE acc.acc_type_id='$tid' GROUP BY acc.account_id");
        } else {

            $query = $this->db->query("SELECT acc.account_id, acc.acc_name, SUM(dt.cr_amount) cramount, SUM(dt.dr_amount) dramount FROM tbl_cl_accounts acc 
        JOIN tbl_cl_trans_details dt ON dt.account_id=acc.account_id JOIN tbl_cl_transections tr ON tr.trx_id=dt.trx_id 
        WHERE acc.acc_type_id='$tid' AND (tr.trx_date >= '$from' and tr.trx_date <= '$to') GROUP BY acc.account_id");
        }
        return $query->getResultArray();
    }
}
