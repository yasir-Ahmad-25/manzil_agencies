<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class HRModel extends Model
{
    protected $table   = 'tbl_menus';



    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return true;
    }

    function get_id($custom_id, $table)
    {
        $db = DB_NAME;
        $query = $this->db->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db' AND TABLE_NAME = '$table' ");
        return $custom_id . '_0' . $query->getRow()->AUTO_INCREMENT;
    }

    //----------------Datatables lists---------\\
    public function get_employee()
    {
        $brid = session()->get('user')['branch_id'];

        $query = $this->db->query("SELECT * From tbl_employees emp, tbl_jobs jb where jb.job_id=emp.job_id and emp_status != 'Deleted' AND emp.branch_id='$brid'");
        return $query->getResultArray();
    }

    public function get_table_info($table)
    {
        $qry = $this->db->query("SELECT * FROM $table");
        return $qry->getResultArray();
    }

    public function update_emp($data)
    {
        //$this->db->where($id_field);
        //$this->db->update('tbl_employees', $data);
        $this->db->table('tbl_employees')->upsertBatch($data);
        //$this->db->update_batch($table, $data, $id);
        return true;
    }
    public function block_emp($recid)
    {
        $this->db->query("UPDATE tbl_employees set emp_status = 'Blocked' where emp_id = " . $recid);
    }
    public function activate_emp($recid)
    {
        $this->db->query("UPDATE tbl_employees set emp_status = 'Active' where emp_id = " . $recid);
    }

    public function update_job($data)
    {
        $this->db->table('tbl_jobs')->upsertBatch($data);
        return true;
    }
    public function update_salary($data)
    {
        $this->db->table('tbl_salary')->upsertBatch($data);
        return true;
    }

    public function get_salary_data()
    {
        $brid = session()->get('user')['branch_id'];

        $sql = "SELECT salary_id, sl.emp_id, sl.job_id, job_name, emp_name, comm, deduction, net_pay,salary_status, month, payment_date, sl.account_id, acc.acc_name, salary_id FROM 
        tbl_salary sl JOIN tbl_employees emp ON emp.emp_id=sl.emp_id
        JOIN tbl_jobs jb ON jb.job_id=emp.job_id
        JOIN tbl_cl_accounts acc ON acc.account_id=sl.account_id WHERE emp.branch_id='$brid'";

        $qry = $this->db->query($sql);

        return $qry->getResultArray();
    }


    public function get_base_salary($emp_id)
    {
        $sql = "SELECT job_name, job_salary FROM tbl_jobs jb JOIN tbl_employees emp ON emp.job_id=jb.job_id
        WHERE emp.emp_id='$emp_id'";
        $qry = $this->db->query($sql);
        return $qry->getRow();
    }

    public function get_expense_accounts()
    {

        $brid = session()->get('user')['branch_id'];
        $sql = "SELECT account_id,acc_name, acc_tag FROM tbl_cl_accounts 
                WHERE acc_grp_id='acc_grp_id_05' AND acc_status='Active'";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_cash_bank_accounts()
    {
        $brid = session()->get('user')['branch_id'];
        $sql = "SELECT account_id,acc_name, acc_tag FROM tbl_cl_accounts acc JOIN tbl_cl_account_types tb ON acc.acc_type_id=tb.acc_type_id
        WHERE tb.acc_type_tag='CB'";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }



    public function undo_transaction($trx_id, $amount)
    {
        $trx_details = $this->get_trx_details($trx_id);

        foreach ($trx_details as $trx_detail) {

            $account_id = $trx_detail['account_id'];

            $type = $this->get_account_nature($account_id);

            if ($type == 'CB') {
                $this->db->query("UPDATE tbl_cl_accounts SET acc_balance = acc_balance+$amount WHERE account_id='$account_id'");
            } else {
                $this->db->query("UPDATE tbl_cl_accounts SET acc_balance = acc_balance-$amount WHERE account_id='$account_id'");
            }
        }

        $this->db->query("delete from tbl_cl_trans_details where trx_id='$trx_id'");
        $this->db->query("delete from tbl_cl_transections where trx_id='$trx_id'");
    }

    public function get_trx_details($id)
    {

        $trx_det = $this->db->query("select * from tbl_cl_trans_details where trx_id='$id'");
        return $trx_det->getResultArray();
    }

    
    public function get_account_nature($account_id)
    {
        $account = $this->db->query("SELECT acc_type_tag FROM tbl_cl_accounts acc 
                JOIN tbl_cl_account_types actp ON actp.acc_type_id=acc.acc_type_id WHERE account_id='$account_id'");
        return $account->getRow()->acc_type_tag;
    }
}
