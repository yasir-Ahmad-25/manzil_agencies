<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ApartmentModel extends Model
{
    protected $table   = 'tbl_sites';


    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    public function get_type_data($table, $tableid, $status, $id = null)
    {

 
        if ($id) {
            $sql = "SELECT * FROM $table  where $status != 'Deleted' and $tableid =?";
            $query = $this->db->query($sql, array($id));
            return $query->getRowArray();
        }

        $sql = "SELECT * FROM $table where $status != 'Deleted' ORDER BY $tableid ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_apartments($site_id){
        return $this->db->query("SELECT * from tbl_apartments where ap_status='Occupied' and site_id='$site_id'")->getResultArray();
    }

    public function get_num_floors($id)
    {
         $sql = "select * from tbl_sites s , tbl_floors f  where f.site_id=s.site_id 
        and s.site_name='$id' and f.floor_status !='Deleted'  and s.status !='Deleted'";
        $query = $this->db->query($sql);
        return $query->getNumRows();
    }
    public function update_table($table, $data)
    {
        $this->db->table($table)->upsertBatch($data);
        return true;
    }


    public function get_floors_list()
    {
        // $profile_no = $this->session->userdata("profile")['profile_no'];

        $sql = "SELECT * FROM tbl_floors f 
                JOIN tbl_sites s ON f.site_id = s.site_id 
                where f.floor_status !='Deleted' ";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }


    public function get_how_many_apartment_in_floor($floor, $site)
    {
        // $profile_no = $this->session->userdata("profile")['profile_no'];
        $query = $this->db->query("select * from tbl_apartments ap,tbl_floors f , tbl_sites s where s.site_id=f.site_id 
        and s.site_name='" . $site . "' and ap.floor_id=f.floor_id and
        f.floor_name='$floor' and ap.ap_status !='Deleted'");
        return $query->getNumRows();
    }



    public function fill_floor_site()
    {
        // $profile_no = $this->session->userdata("profile")['profile_no'];
        $query = $this->db->query("select * from tbl_sites WHERE status !='Deleted' AND No_of_Floors >= 1;");
        return $query->getResultArray();
    }
    public function get_ap_type_in_apartment($id)
    {
        $query = $this->db->query("select * from tbl_apartment_types ap_type where ap_type.ap_type_name='$id' and 
        ap_type.ap_type_id not IN(select ap_type_id from tbl_apartments)");

        return $query->getNumRows() > 0 ? true : false;
    }




    public function get_apartments_list()
    {
        // $profile_no = $this->session->userdata("profile")['profile_no'];

        $sql = "SELECT *
                FROM tbl_apartments ap 
                JOIN tbl_apartment_types tp ON tp.ap_type_id=ap.ap_type_id 
                JOIN tbl_floors fl ON fl.floor_id=ap.floor_id
                WHERE   ap.ap_status !='Deleted'";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }
    public function get_sites()
    {

        $sql = "SELECT *
                FROM tbl_sites
                WHERE   status ='Active'";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function get_floors_for($site_id){
        return $this->db->query("SELECT * from tbl_floors where site_id='$site_id' and floor_status='Active'")->getResultArray();
    }

    
    public function get_site_id($floor_id)
    {

        // $profile = $this->session->userdata("profile")['profile_no'];


        $sql = "SELECT s.site_id FROM tbl_sites s , tbl_floors f where f.site_id=s.site_id and 
            status != 'Deleted'   and floor_id ='$floor_id'";
        $query = $this->db->query($sql, array($floor_id));
        return $query->getRow()->site_id;
    }
}