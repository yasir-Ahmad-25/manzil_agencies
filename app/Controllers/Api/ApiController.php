<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Back\SettingsModel;
use App\Models\Back\UserModel;
use \Firebase\JWT\JWT;

class ApiController extends BaseController
{

    public $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    use ResponseTrait;
    public function verify_token()
    {
        // $key = getenv('JWT_SECRET');
        $header = $this->request->header("Authorization");
        $token = null;

        // extract the token from the header
        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }
        if (is_null($token) || empty($token)) {
            return false;
        }
        // $decoded = JWT::decode($token, new Key($key, 'HS256'));
        $users = new UserModel();
        $user = $users->where('jwt_token', $token)->first();
        if (is_null($user)) {
            return $this->respond(['message' => 'token is not valid'], 406);
        }
        if ($user['status'] !== 'Active') {
            return false;
        } else {
            return true;
        }
    }

    public function register()
    {
        $this->db->transStart();

        ## create company profile ##
        $company_info_data = [
            'name' => $this->request->getVar('full_name'),
            'logo' => '',
            'subscription_id' => $this->request->getVar('subscription_id'),
        ];
        $this->db->table('company_info')->insert($company_info_data);

        ## create default branch ##

        $branch_data = [
            'br_name' => $this->request->getVar('full_name').' (HQ)',
            'br_address' => $this->request->getVar('br_address'),
            'br_status' => 'Active',
            'profile_no' => $this->request->getVar('profile_no'),
            'br_tag' => $this->request->getVar('br_tag'),
        ];
        $this->db->table('tbl_branches')->insert($branch_data);
        $br_id = $this->db->insertID();

      ## create default user or owner ##
        $password = $this->request->getVar('password');
        $hpwd = password_hash($password, PASSWORD_DEFAULT);

        $user_data = [
            'fullname' => $this->request->getVar('full_name'),
            'user_name' => $this->request->getVar('user_name'),
            'passwd' => $hpwd,
            'role_id' => $this->request->getVar('role_id'),
            'user_tell' => $this->request->getVar('user_tell'),
            'user_email' => $this->request->getVar('user_email'),
            'ut_id' => $this->request->getVar('ut_id'),
            'branch_id' => $br_id,
            'user_img' => '',
            'user_timestamp' => time(),
            'user_status' => 'Active',
            'role' => 'SuperAdmin',
        ];
        $this->db->table('tbl_users')->insert($user_data);
        $user_id = $this->db->insertID();

        # generate menus to the user
        $menus = $this->db->query("select * from tbl_menu where tab_status='Active'")->getResultArray();
        foreach ($menus as $menu) {
            $data = array(
                'user_id' => $user_id,
                'tab_id' => $menu['tab_id']
            );
            $this->db->table('tbl_menu_access')->insert($data);
        }

        
        if ($this->db->transStatus() == false) {
            $this->db->transRollback();
            return $this->respond(['status' => false, 'message' => 'Error occured while inserting'], 400);
        } else {
            $this->db->transCommit();
        }
        return $this->respond(['status' => true, 'message' => 'Registered Successfully'], 200);
    }
}
