<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

use App\Models\Back\SettingsModel;
use App\Models\Back\UserModel;
use App\Models\Back\AuthModel;

class UserController extends BaseController
{

    public function list()
    {
        $auth = new AuthModel();
        $usermodel = new UserModel();
        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
        }

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['user_types'] = $usermodel->get_user_types();
        $this->viewData['branches'] = $this->get_table_info('tbl_branches');
        log_message('debug', 'returned data: ' . $this->fetch_users());
        return view('admin/user/users', $this->viewData);
    }

    public function fetch_users()
    {
        $usermodel = new UserModel();
        $result = array('data' => array());
        $data = $usermodel->get_user_list();

        
        $sample_img = 'sample.jpg';
        
        foreach ($data as $key => $value) {

            $sample_img = $value["user_img"] ;

            $buttons = '';
            $img_path = base_url() . 'public/assets/images/users/' . $sample_img;
            $image = '<img src="' . $img_path . '" class="img-thumbnail" width="50" height="35" />';

            $btn = [
                'header' => '<div class="ml-auto">
                            <div class="dropdown sub-dropdown">
                            <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fas fa-ellipsis-v mx-1"></i>
                            </button><div class="dropdown-menu dropdown-menu-right" 
                            aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; 
                            top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                ',
                'mid_1' => '',
            ];
            $set = [
                'id' => $value["user_id"],
                'rec_title' => $value["fullname"],
                'status' => $value["user_status"],
                'rec_tbl' => 'tbl_users',
                'rec_tag_col' => 'user_status',
                'rec_id_col' => 'user_id',
            ];

            $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
            $block = ($set["status"] == 'Active') ? '' : 'hidden';
            $delete = '';

            $stat_icon = $this->stat_icon($set["status"]);

            $buttons = $btn['header'] . '
                        
                            <a type="button" id="btn_edit"  data-user_id="' . $value["user_id"] . '"
                            data-full_name="' . $value["fullname"] . '" data-user_tell="' . $value["user_tell"] . '" data-user_address="' . $value["userAddress"] . '"
                            data-user_email="' . $value["user_email"] . '" data-u_name="' . $value["user_name"] . '"
                            data-user_status="' . $value["user_status"] . '" data-user_img="' . $img_path . '"
                            data-ut_id="' . $value["ut_id"] . '" data-user_name="' . $value["user_name"] . '"
                            data-password="' . $value["passwd"] . '" data-old_img="' . $value['user_img'] . '"
                            class="dropdown-item" data-bs-toggle="modal" data-bs-target="#user_modal">
                            <i class="fas fa-pencil-alt text-warning mx-1"></i>' . lang("Site.button.edit") . ' </a>
                                            
                            <a ' . $act . '  type="button" data-rec_id="' . $set["id"] . '" 
                                data-rec_title="' . $set["rec_title"] . '" data-rec_tag="Active"  data-rec_tbl="' . $set["rec_tbl"] . '"
                                data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#status_modal">
                                <i class="fas fa-check text-success mx-1"></i>' . lang('Site.button.activate') . '  
                            </a>
                            <a ' . $block . '  type="button" data-rec_id="' . $set["id"] . '" 
                                data-rec_title="' . $set["rec_title"] . '" data-rec_tag="Blocked" data-rec_tbl="' . $set["rec_tbl"] . '"  
                                data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#status_modal">
                                <i class="fas fa-ban text-danger mx-1"></i>' . lang('Site.button.block') . '  
                            </a>
                      </div>
                    </div>
            </div>';

            $result['data'][$key] = array(
                $key + 1,
                $image . ' ' . ucfirst($value['fullname']),
                $value['userAddress'],
                $value['user_tell'],
                $value['ut_name_en'],
                $value['br_name'],
                $stat_icon . ' ' . $value['user_status'],
                $buttons,
            );
            // $i++;
        } // /foreach
        // print_r($result);
        log_message('debug' , 'returned data is: ',$result);
        return json_encode($result);
    }

    public function stat_icon($status)
    {
        if ($status == 'Active')
            $stat_icon = '<i class="fas fa-check text-success mx-1"></i>';
        if ($status == 'Pending')
            $stat_icon = '<i class="fas fa-sync text-warning mx-1"></i>';
        if ($status == 'Recovered')
            $stat_icon = '<i class="fas fa-sync text-dark mx-1"></i>';
        if ($status == 'Blocked')
            $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
        if ($status == 'Cancelled')
            $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
        if ($status == 'Finished')
            $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
        if ($status != 'Active' && $status != 'Blocked' && $status != 'Finished' && $status != 'Pending' && $status != 'Cancelled' && $status != 'Recovered')
            $stat_icon = '<i class="fas fa-question text-danger mx-1"></i>';
        return $stat_icon;
    }
    public function crud_user()
    {
        $response = array();
        $response['success'] = false;
        $response['message'] = 'Going to Submit';
        $img_Types = array('image/jpg', 'image/png', 'image/jpeg');
        $setting = new SettingsModel();

        if ($_POST['btn_action'] == 'btn_add') {

            $response['success'] = $this->add_user();
            $response['message'] = lang('Site.state.added_successfully');
        } else if ($_POST['btn_action'] == 'btn_edit') {

            // update user data
            $data = [
                'fullname' => $this->request->getVar('full_name'),
                'userAddress' => $this->request->getVar('user_address'),
                'user_tell' => $this->request->getVar('user_tell'),
                'user_email' => $this->request->getVar('user_email'),
                'ut_id' => $this->request->getVar('ut_id'),
                'user_name' => $this->request->getVar('username'),
                'user_img' => $this->upload_img('users', 'user_img'),
            ];

            $setting->updatedata('tbl_users', 'user_id', $_POST['user_id'], $data);
            $response['success'] = true;
            $response['message'] = $this->alert('User Has Been Updated', 'success');
        }
        echo json_encode($response);
    }

    public function add_user()
    {
        $usermodel = new UserModel();

        // changing plain-text password to hashed password
        $password = $this->request->getVar('password');
        $hpwd = password_hash($password, PASSWORD_DEFAULT);

        $user_data = [
            'fullname' => $this->request->getVar('full_name'),
            'userAddress' => $this->request->getVar('user_address'),
            'user_name' => $this->request->getVar('username'),
            'passwd' => $hpwd,
            'user_tell' => $this->request->getVar('user_tell'),
            'user_email' => $this->request->getVar('user_email'),
            'ut_id' => $this->request->getVar('ut_id'),
            'branch_id' => $this->request->getVar('br_id'),
            'user_img' => $this->upload_img('users', 'user_img'),
            'user_timestamp' => time(),
            'user_status' => 'Active',
            'role' => 'Admin',
        ];

        $usermodel->store('tbl_users', $user_data);
        return true;
    }

    public function upload_img($folder, $image)  // uploads images for setup 
    {
        $_FILES[$image]['name'] = time() . '-RAED-' . $_FILES[$image]['name'];
        $target_folder = 'public/assets/images/users' .  '/' . $_FILES[$image]['name'];
        move_uploaded_file($_FILES[$image]['tmp_name'], $target_folder);
        return $_FILES[$image]['name'];
    }


    /** 
     ** User Access Control
     **/

    public function roles()
    {
        $auth = new AuthModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
        }

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());

        return view('admin/user/roles', $this->viewData);
    }

    public function roles_list()
    {

        $result = array('data' => array());
        $stmodel = new UserModel();
        $data = $stmodel->get_roles_list();
        $i = 1;
        foreach ($data as $key => $value) {
            $buttons = '';

            if ($value["ut_status"] == 'Active')
                $stat_icon = '<i class="fas fa-check text-success mx-1"></i>';
            if ($value["ut_status"] == 'Pending')
                $stat_icon = '<i class="fas fa-sync text-warning mx-1"></i>';
            if ($value["ut_status"] == 'Blocked')
                $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
            if ($value["ut_status"] != 'Active' && $value["ut_status"] != 'Blocked' && $value["ut_status"] != 'Pending')
                $stat_icon = '<i class="fas fa-question text-danger mx-1"></i>';
            // else $stat_icon = '<i class="fas fa-question text-danger mx-1"></i>';

            $set = [
                'id' => $value["ut_id"],
                'rec_title' => $value["ut_name_en"],
                'status' => $value["ut_status"],
                'rec_tbl' => 'tbl_user_type',
                'rec_tag_col' => 'ut_status',
                'rec_id_col' => 'ut_id',
            ];

            $act = ($value["ut_status"] == 'Pending' || $value["ut_status"] == 'Blocked') ? '' : 'hidden';
            $block = ($value["ut_status"] == 'Active') ? '' : 'hidden';
            $buttons = '<div class="ml-auto">
                    <div class="dropdown sub-dropdown">
                        <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fas fa-ellipsis-v mx-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                    
                           <a type="button"  id="btn_edit" data-ut_id="' . $value["ut_id"] . '"
                            data-ut_name="' . $value["ut_name_en"] . '" data-ut_des="' . $value["ut_des"] . '"
                            class="dropdown-item" data-bs-toggle="modal" data-bs-target="#user_type_modal">
                            <i class="fas fa-pencil-alt text-warning mx-1"></i>' . lang("Site.button.edit") . '  </a>
                            
                            <a ' . $act . ' type="button" data-rec_id="' . $value["ut_id"] . '" 
                            data-rec_title="' . $set["rec_title"] . '" data-rec_tag="Active" data-rec_tbl="' . $set["rec_tbl"] . '"  
                            data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                            class="dropdown-item" data-bs-toggle="modal" data-bs-target="#status_modal">
                            <i class="fas fa-check text-success mx-1"></i>' . lang("Site.button.activate") . '  </a>

                            <a ' . $block . ' type="button" data-rec_id="' . $value["ut_id"] . '"
                            data-rec_title="' . $set["rec_title"] . '" data-rec_tag="Blocked" data-rec_tbl="' . $set["rec_tbl"] . '"  
                            data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                            class="dropdown-item" data-bs-toggle="modal" data-bs-target="#status_modal">
                            <i class="fas fa-ban text-danger mx-1"></i>' . lang("Site.button.block") . '  </a>

                    </div>
                    </div>
                </div>';

            $result['data'][$key] = array(
                $i,
                $value['ut_name_en'],
                $value['ut_name_ar'],
                $stat_icon . ' ' . $value['ut_status'],
                $buttons,
            );
            $i++;
        } // /foreach

        echo json_encode($result);
    }

    public function uac()
    {
        $auth = new AuthModel();
        $stmodel = new UserModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
        }

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['roles'] = $stmodel->get_user_types();

        return view('admin/user/uac', $this->viewData);
    }
    public function get_menus()
    {

        $stmodel = new UserModel();
        $ut_id = $this->request->getVar('ut_id');
        $menus = $stmodel->get_main_menus();

        $output = '<table class="table table-striped table-bordered no-wrap" style="width:100%">
        <thead>
        <tr>
        <th colspan="6">Menu</th>
        </tr>
        </thead>
        <tbody>';
        $i = 1;
        foreach ($menus as $menu) {

            $tab_id = $menu['tab_id'];
            $result = $stmodel->has_access($ut_id, $tab_id);

            if ($result) {
                $output .= '
            <tr>
            <td colspan="6"> <input type="checkbox" name="menu_parents[]" class="checkbox ckall" data-id="' . $tab_id . '" value=' . $menu['tab_id'] . ' checked> 
            <a><b>' . $menu['tab_name_en'] . '</b></a></td>
            </tr>
            ';
            } else {
                $output .= '
            <tr>
            <td class="td-parent" colspan="6"> <input type="checkbox" name="menu_parents[]" class="checkbox ckall" data-id="' . $tab_id . '" value=' . $menu['tab_id'] . '> 
            <a><b>' . $menu['tab_name_en'] . '</b></a></td>
            </tr>
            ';
            }

            $output .= $this->draw_sub_menus($tab_id);
            // $i++;
        }
        $output .= '</tbody></table>';
        echo $output;
    }

    public function draw_sub_menus($id)
    {
        $stmodel = new UserModel();
        $ut_id = $this->request->getVar('ut_id');
        $inner = '';
        $inner = '<tr style="width:100%">';

        $j = 1;
        $menus = $stmodel->get_sub_menus($id);

        foreach ($menus as $menu) {

            $result = $stmodel->has_access($ut_id, $menu['tab_id']);

            if ($result) {

                $inner .= '
                        <td> <input type="checkbox" name="menu_children[]" class="checkbox chchild-' . $id . '" value=' . $menu['tab_id'] . ' checked> 
                        ' . $menu['tab_name_en'] . '</td>
                        ';
            } else {
                $inner .= '
                        <td> <input type="checkbox" name="menu_children[]" class="checkbox chchild-' . $id . '" value=' . $menu['tab_id'] . '> 
                        ' . $menu['tab_name_en'] . '</td>
                        ';
            }

            //$j++;
        }

        $inner .= '</tr>';

        return $inner;
    }

    public function update_access()
    {
        $stmodel = new UserModel();

        $ut_id = $this->request->getVar('ut_id');
        // array of checked permisions
        $menu_parents = $this->request->getVar('menu_parents');

        $menu_children = $this->request->getVar('menu_children');

        $result = $stmodel->delete_user_access($ut_id);

        if ($result) {

            // update roles for parents level
            $stmodel->update_user_access($menu_parents, $ut_id);
            // update roles for childs level
            $stmodel->update_user_access($menu_children, $ut_id);

            return redirect()->to(base_url($this->viewData['locale'] . '/settings/uac'));
        } else {
            return redirect()->to(base_url($this->viewData['locale'] . '/settings/uac'));
        }
    }
    /*
    // End User Access Control
    */

    public function change_status() // change status activate/block/delete
    {
        $response = array();
        if ($_POST['rec_tag'] == 'Blocked') {
            $color = 'danger';
            $icon = 'ban';
            $title = 'block_modal';
            $btn = 'Block';
        } else if ($_POST['rec_tag'] == 'Deleted') {
            $color = 'danger';
            $icon = 'trash-alt';
            $title = 'delete_modal';
            $btn = 'Delete';
        } else if ($_POST['rec_tag'] == 'Active') {
            $color = 'success';
            $icon = 'check-circle';
            $title = 'activate_modal';
            $btn = 'Activate';
        } else {
            $color = 'dark';
            $icon = 'question';
            $title = 'delete_modal';
            $btn = 'Delete';
        }

        $response['status'] = '<div class="modal-body">
                        <h3 class="text-center"><i class="fas fa-' . $icon . ' text-' . $color . ' m-2 fa-2x"></i><br>' . ($_POST['rec_page']) . '</h3>
                        <div class="row">
                        <div class="col-md-12">
                        <div id="inner_status"></div>
                                <div class="form-group text-dark" style="margin:5px">
                                    <input readonly type="text" class="form-control " value="' . $_POST['rec_title'] . '" name="rec_title">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_id'] . '" name="rec_id">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_tag'] . '" name="rec_tag">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_tbl'] . '" name="rec_tbl">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_tag_col'] . '" name="rec_tag_col">
                                    <input type="hidden" class="form-control border-secondary" value="' . $_POST['rec_id_col'] . '" name="rec_id_col">
                                </div>
                            </div>

                            <div class="col-md-9">
                                <button type="button" class="btn btn-block btn-rounded btn-outline-secondary" data-bs-dismiss="modal">
                                    <b>Cancel</b></button>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-block btn-rounded btn-outline-' . $color . '">
                                    <b>' . $btn . '</b></button>
                            </div>
                        </div>
        </div>';
        echo json_encode($response);
    }

    public function status_changer() // change status activate/block/delete
    {
        $setting = new SettingsModel();
        $response = array();
        $response['success'] = false;
        $response['message'] = $this->alert('Enter Tenant Name', 'danger');
        if (empty($_POST['rec_id'])) $response['alert_inner'] = $this->alert('Error, Record is not Available', 'danger');
        else {
            $response['success'] = $setting->updatedata($_POST['rec_tbl'], $_POST['rec_id_col'], $_POST['rec_id'], [$_POST['rec_tag_col'] => $_POST['rec_tag']]);
            $response['message'] = $this->alert('Process Completed Successfully', 'success');
        }
        echo json_encode($response);
    }



    #### USER PROFILE ###

    public function profile()
    {
        $auth = new AuthModel();

        $this->viewData['title'] = 'User Profile';
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());

        return view('admin/profile', $this->viewData);
    }

    public function change_password()
    {
        $response = array();
        $response['success'] = false;
        $user = new UserModel();


        if (empty($_POST['old_pass'])) $response['alert_inner'] = $this->alert('Enter old Password', 'danger');
        else if (empty($_POST['new_pass'])) $response['alert_inner'] = $this->alert('Enter New Password', 'danger');
        else if (empty($_POST['confirm_new_pass'])) $response['alert_inner'] = $this->alert('Enter Confirm Password', 'danger');
        else if ($_POST['confirm_new_pass'] != $_POST['new_pass']) $response['alert_inner'] = $this->alert('Mismatch in New Password & Confirm Password', 'danger');
        else {

            $log_res =  $user->change_password($_POST['old_pass'], $_POST['new_pass']);

            if ($log_res == 'wrong_pass') $response['alert_inner'] = $this->alert('Wrong Old Password', 'danger');
            else if ($log_res == 'changed') {
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Password changed Successfully', 'success');
            } else $response['alert_inner'] = $this->alert('Password change Failed, Contact Administrators', 'danger');
        }
        echo json_encode($response);
    }

    public function update_profile()
    {
        $response = array();
        $response['success'] = false;
        $user = new UserModel();

        if (empty($_POST['user_nm'])) $response['alert_inner'] = $this->alert('Enter username', 'danger');
        else if (empty($_POST['user_tl'])) $response['alert_inner'] = $this->alert('Enter user tell', 'danger');
        else if (empty($_POST['user_em'])) $response['alert_inner'] = $this->alert('Enter email', 'danger');
        else {

            $result =  $user->update_profile($_POST['user_nm'], $_POST['user_tl'], $_POST['user_em']);

            if ($result == 'failed') $response['alert_inner'] = $this->alert('Profile update failed', 'danger');
            else if ($result == 'changed') {
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Profile changed Successfully', 'success');
            }
        }
        echo json_encode($response);
    }
}
