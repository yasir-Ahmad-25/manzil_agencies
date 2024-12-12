<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class SupplierModel extends Model
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

    public function get_suppliers_info()
    {
        $brid = session()->get('user')['branch_id'];

        $sql = "SELECT su.*, acc.acc_balance FROM `tbl_suppliers` su JOIN `tbl_cl_accounts` acc 
        ON su.sup_id=acc.acc_tag WHERE acc.acc_set='Supplier' AND su.branch_id='$brid'";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function get_supp_history($sid)
    {
        $sql = "select * from tbl_supplier_balances where sup_id='$sid'";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_sup_info($sid)
    {
        $sql = "select * from tbl_suppliers where sup_id='$sid'";
        $query = $this->db->query($sql);
        return $query->getRow();
    }

    
    public function payables_report()
    {
        $brid = session()->get('user')['branch_id'];

        $sql = "SELECT sp.sup_name, sp.sup_phone, acc_balance FROM tbl_suppliers sp 
        JOIN tbl_cl_accounts acc ON sp.sup_id=acc.acc_tag AND acc.acc_set='Supplier' and sp.branch_id='$brid'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
}
