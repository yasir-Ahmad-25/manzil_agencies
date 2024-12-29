<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $owner_table = 'tbl_owners';

    public function getOwnerById($owner_id){
        $owner = $this->db->query("SELECT fullname FROM tbl_owners WHERE owner_id=$owner_id");
        return $owner->getRow()->fullname;
    }
}