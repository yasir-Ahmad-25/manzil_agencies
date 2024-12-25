<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class OwnerModel extends Model
{
    protected $table   = 'tbl_owners';

    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    public function get_owners_data($table, $tableid, $id = null, $branch_id)
    {

        if($branch_id !== 1){
            if ($id) {
                $sql = "SELECT * FROM $table  where $tableid =? AND branch_id = ?";
                $query = $this->db->query($sql, array($id , $branch_id));
                return $query->getRowArray();
            }else{
                $sql = "SELECT * FROM $table WHERE branch_id = $branch_id ORDER BY $tableid ASC";
                $query = $this->db->query($sql);
                return $query->getResultArray();
            }
        }else{
            if ($id) {
                $sql = "SELECT * FROM $table  where $tableid =?";
                $query = $this->db->query($sql, array($id));
                return $query->getRowArray();
            }else{
                $sql = "SELECT * FROM $table ORDER BY $tableid ASC";
                $query = $this->db->query($sql);
                return $query->getResultArray();
            }
        }
 

    }

    public function update_table($table, $data)
    {
        $this->db->table($table)->upsertBatch($data);
        return true;
    }

    
}