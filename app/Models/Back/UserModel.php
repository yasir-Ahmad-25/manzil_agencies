<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tbl_menus';

    public function menus()
    {
        $qry = $this->db->query("SELECT * FROM tbl_menu m order by tab_order asc");

        return $qry->getResultArray();
    }

    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return true;
    }
    public function updatedata($table, $id_field, $id_no, $data)
    {
        return $this->db->table($table)->where($id_field, $id_no)->update($data);
    }

    function get_id($custom_id, $table)
    {
        $db = DB_NAME;
        $query = $this->db->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db' AND TABLE_NAME = '$table' ");
        return $custom_id . '_0' . $query->getRow()->AUTO_INCREMENT;
    }

    public function get_user_list()
    {
        $brid = session()->get('user')['branch_id'];
        $user_role = session()->get('user')['role'];

        $role_cond = $user_role == "SuperAdmin" ? "" : "AND u.branch_id='$brid'";
        $sql = "SELECT user_id, u.ut_id, user_img,userAddress, fullname, user_name,passwd, user_tell, user_email, user_status, ut.ut_name_en,br.br_name 
        FROM tbl_users u JOIN tbl_user_type ut ON ut.ut_id=u.ut_id
        JOIN tbl_branches br ON br.branch_id=u.branch_id $role_cond";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    /**
     * User Access Models
     */

    public function get_user_types()
    {
        $qry = $this->db->query('SELECT * FROM tbl_user_type');
        return $qry->getResultArray();
    }
    public function get_roles_list()
    {
        $query = $this->db->query("SELECT * FROM tbl_user_type ut where ut.ut_status != 'Deleted'");
        return $query->getResultArray();
    }
    public function get_main_menus()
    {
        $query = $this->db->query("SELECT * FROM tbl_menu WHERE tab_parent='0'");
        return $query->getResultArray();
    }
    public function get_sub_menus($id)
    {
        // $accessId = $this->input->post('id');
        $query = $this->db->query("SELECT * FROM tbl_menu WHERE tab_parent='$id'");
        return $query->getResultArray();
    }

    public function has_access($ut_id, $tab_id)
    {
        $query = $this->db->query("SELECT count(id) as cnt FROM tbl_menu_access WHERE tab_id ='" . $tab_id . "' AND ut_id='" . $ut_id . "'")->getRow();
        $count = $query->cnt;
        //if ($query->getRow()) $count = $query->getRow()->cnt;
        //else $count = 0;
        return $count > 0;
    }


    public function delete_user_access($ut_id)
    {
        $deleted = $this->db->query("DELETE FROM tbl_menu_access WHERE ut_id='$ut_id'");
        return $deleted;
    }

    public function update_user_access($menus, $ut_id)
    {

        foreach ($menus as $val) {

            $data = array(
                'ut_id' => $ut_id,
                'tab_id' => $val
            );

            $this->db->table('tbl_menu_access')->insert($data);
            //$this->db->insert('tbl_menu_access', $data);
        }
    }



    public function get_user_profile()
    {

        $userid = session()->get('user')['user_id'];
        $data = $this->db->query("SELECT `fullname` cl_name, `user_tell` cl_tell, `user_email` cl_email 
        FROM `tbl_users` WHERE `user_id`='$userid'")->getResultArray()[0];

        return $data;
    }


    public function change_password($old_pass, $new_pass)
    {

        $userid = session()->get('user')['user_id'];

        $login_data = $this->db->query("SELECT * FROM  tbl_users WHERE user_id='$userid'");
        $data = $login_data->getResultArray()[0];

        $db_pwd = $data['passwd'];

        if (password_verify($old_pass, $db_pwd)) {
            $new_hash_password = password_hash($new_pass, PASSWORD_DEFAULT);
            $this->updatedata('tbl_users', 'user_id', $userid, ['passwd' => $new_hash_password]);
            return 'changed';
        } else return 'wrong_pass';
    }

    public function update_profile($user_nm, $user_tl, $user_em)
    {

        $userid = session()->get('user')['user_id'];
        $data = [
            'fullname' => $user_nm,
            'user_tell' => $user_tl,
            'user_email' => $user_em,
        ];
        $this->updatedata('tbl_users', 'user_id', $userid, $data);
        return 'changed';
    }
}
