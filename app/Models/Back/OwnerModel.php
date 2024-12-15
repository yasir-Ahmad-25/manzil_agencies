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

    public function get_type_data($table, $tableid, $id = null)
    {

 
        if ($id) {
            $sql = "SELECT * FROM $table  where $tableid =?";
            $query = $this->db->query($sql, array($id));
            return $query->getRowArray();
        }

        $sql = "SELECT * FROM $table ORDER BY $tableid ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function update_table($table, $data)
    {
        $this->db->table($table)->upsertBatch($data);
        return true;
    }

}