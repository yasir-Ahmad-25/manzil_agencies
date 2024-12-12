<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'tbl_menus';

    public function menus()
    {
        $qry = $this->db->query("SELECT * FROM tbl_menu m order by tab_order asc");

        return $qry->getResultArray();
    }
    public function get_branches()
    {
        $qry = $this->db->query("SELECT * FROM tbl_branches where br_tag != 'store' ");

        return $qry->getResultArray();
    }
    public function rep_rental_report($year, $month)
    {
        //$site_id = $this->session->userdata('user_data')['site'];
        // $holder = $this->session->userdata('user_data')['holder'];

        // $yr = date('Y');
        // $mon = date('m');
        // if ($year == '' || $month == '')
        //     $condition = "";
        // else
        //     $condition = " and)='$mon' and YEAR(bill_date)='$yr'";
        $sql = "SELECT cust_name AS Tenant, a.ap_no AS Apartment, ri.* 
                FROM rental_income_report ri 
                LEFT JOIN tbl_rentals r ON r.rental_id = ri.rental_id 
                LEFT JOIN tbl_customers t ON t.customer_id = ri.tenant_id 
                LEFT JOIN tbl_apartments a ON a.ap_id = ri.ap_id and ri.month=$month";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    public function updatedata($table, $id_field, $id_no, $data)
    {
        return $this->db->table($table)->where($id_field, $id_no)->update($data);
    }

    function get_id($custom_id, $table)
    {

        $cnt = $this->db->query("SELECT count(*) as cnt from " . $table)->getRow()->cnt;
        $id = 1;
        if ($cnt > 0) {
            $id = $this->db->query("SELECT MAX(id) as maxid from " . $table)->getRow()->maxid;
            $id += 1;
        }
        return $custom_id . '_0' . $id;
    }


    public function get_users()
    {
        $qry = $this->db->query('SELECT * FROM tbl_users');
        return $qry->getResultArray();
    }
    public function get_user_types()
    {
        $qry = $this->db->query('SELECT * FROM tbl_user_type');
        return $qry->getResultArray();
    }
    public function get_roles_list()
    {
        $query = $this->db->query("SELECT * FROM tbl_user_type ut where 1");
        return $query->getResultArray();
    }
    public function get_main_menus()
    {
        $query = $this->db->query("SELECT * FROM tbl_menu WHERE tab_parent='0'");
        return $query->getResultArray();
    }
    public function get_sub_menus($id)
    {
        $query = $this->db->query("SELECT * FROM tbl_menu WHERE tab_parent='$id'");
        return $query->getResultArray();
    }

    public function has_access($id, $tab_id)
    {
        $query = $this->db->query("SELECT count(id) as cnt FROM tbl_menu_access WHERE tab_id ='" . $tab_id . "' AND user_id='" . $id . "'")->getRow();
        $count = $query->cnt;

        return $count > 0;
    }


    public function delete_user_access($id)
    {
        $deleted = $this->db->query("DELETE FROM tbl_menu_access WHERE user_id='$id'");
        return $deleted;
    }

    public function update_user_access($menus, $id)
    {

        foreach ($menus as $val) {

            $data = array(
                'user_id' => $id,
                'tab_id' => $val
            );

            $this->db->table('tbl_menu_access')->insert($data);
        }
    }

    public function update_users_access_api($menus, $id)
    {
        $data = array(
            'user_id' => $id,
            'tab_id' => $menus
        );

        $this->db->table('tbl_menu_access')->insert($data);
    }

    public function update_branch($data)
    {

        $this->db->table('tbl_branches')->upsertBatch($data);
        return true;
    }


}
