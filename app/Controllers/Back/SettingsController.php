<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

use App\Models\Back\SettingsModel;
use App\Models\Back\AuthModel;

class SettingsController extends BaseController
{
    public function index(): string
    {
        return view('login', $this->viewData);
    }

    public function menus()
    {
        $auth = new AuthModel();
        $stmodel = new SettingsModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['menus'] = $stmodel->menus();

        return view('admin/menus', $this->viewData);
    }

    public function menu_list()
    {

        $stmodel = new SettingsModel();

        $result = array('data' => array());
        $data = $stmodel->menus();
        $i = 1;
        foreach ($data as $key => $value) {
            $buttons = '';
            if ($value["tab_status"] == 'Active')
                $stat_icon = '<i class="fas fa-check text-success mx-1"></i>';
            if ($value["tab_status"] == 'Pending')
                $stat_icon = '<i class="fas fa-sync text-warning mx-1"></i>';
            if ($value["tab_status"] == 'Blocked')
                $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
            if ($value["tab_status"] != 'Blocked' && $value["tab_status"] != 'Active' && $value["tab_status"] != 'Pending')
                $stat_icon = '<i class="fas fa-question text-danger mx-1"></i>';

            $act = ($value["tab_status"] == 'Pending' || $value["tab_status"] == 'Blocked') ? '' : 'hidden';
            $ban = ($value["tab_status"] == 'Active') ? '' : 'hidden';
            if ($value["tab_tag"] == 'single') {
                $tab_parent = 'single';
            } else if ($value["tab_tag"] == 'multiple') {
                $tab_parent = $value["tab_parent"];
            } else {
            }

            $buttons = '<div class="ml-auto">
                       <div class="dropdown sub-dropdown">
                           <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                               <i class="fas fa-ellipsis-v mx-1"></i>
                           </button>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                           
                               <a type="button"  data-tab_id="' . $value["tab_id"] . '" data-tab_name_ar="' . $value["tab_name_ar"] . '"
                                   data-tab_name_en="' . $value["tab_name_en"] . '" data-tab_parent="' . $value["tab_parent"] . '"
                                   data-tab_icon="' . $value["tab_icon"] . '" data-tab_order="' . $value["tab_order"] . '"
                                   data-tab_url="' . $value["tab_url"] . '"
                                   class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add_modal">
                                   <i class="fas fa-pencil-alt text-warning mx-1"></i>' . lang("Site.button.edit") . ' </a>
                               
                               <a  type="button" data-tab_id_act="' . $value["tab_id"] . '"
                                   data-tab_name_en_act="' . $value["tab_name_en"] . '"
                                   class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate">
                                   <i class="fas fa-check text-success mx-1"></i>' . lang("Site.button.activate") . ' </a>
   
                               <a  type="button" data-tab_id_block="' . $value["tab_id"] . '"
                                   data-tab_name_en_block="' . $value["tab_name_en"] . '"
                                   class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block">
                                   <i class="fas fa-ban text-danger mx-1"></i>' . lang("Site.button.block") . ' </a>
   
                               <a type="button" data-tab_id_del="' . $value["tab_id"] . '"
                                   data-tab_name_en_del="' . $value["tab_name_en"] . '"
                                   class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete">
                                   <i class="fas fa-trash-alt text-danger mx-1"></i>' . lang("Site.button.delete") . ' </a>
   
                         </div>
                       </div>
                   </div>';

            $result['data'][$key] = array(
                $i,
                $value['tab_name_en'],
                $value['tab_name_ar'],
                $value['tab_url'],
                $value['tab_icon'],
                $value['tab_tag'],
                $value['tab_order'],
                $stat_icon . ' ' . $value['tab_status'],
                $buttons,
            );
            $i++;
        } // /foreach
        // print_r($result);
        echo json_encode($result);
    }

    public function add_menu()
    {
        $response = array();
        $response['success'] = false;

        $stmodel = new SettingsModel();

        $tab_parent = ($this->request->getVar('tab_type') == 'parent') ? 0 : $this->request->getVar('tab_type');
        $tab_tag = ($this->request->getVar('tab_type') != 'parent') ? 'single' : 'multiple';
        $data = [
            'tab_name_en' => $this->request->getVar('tab_name_en'),
            'tab_name_ar' => $this->request->getVar('tab_name_ar'),
            'tab_parent' => $tab_parent,
            'tab_tag' => $tab_tag,
            'tab_icon' => $this->request->getVar('tab_icon'),
            'tab_order' => $this->request->getVar('tab_order'),
            'tab_url' => $this->request->getVar('tab_url'),
        ];

        $stmodel->store('tbl_menu', $data);

        $response['success'] = true;
        $response['message'] = lang('Site.state.added_successfully');

        echo json_encode($response);
    }

    /** 
     * User Access Control
     */

    public function roles()
    {
        $auth = new AuthModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/user/roles', $this->viewData);
    }

    public function roles_list()
    {

        $result = array('data' => array());
        $stmodel = new SettingsModel();
        $data = $stmodel->get_roles_list();
        $i = 1;
        foreach ($data as $key => $value) {
            $buttons = '';


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
                    
                           <a type="button"  id="btn_edit" data-ut_id="' . $value["ut_id"] . '" data-ut_name_ar="' . $value["ut_name_ar"] . '"
                                data-ut_name="' . $value["ut_name_en"] . '" data-ut_des="' . $value["ut_des"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#user_type_modal">
                                <i class="fas fa-pencil-alt text-warning mx-1"></i>' . lang("Site.button.edit") . '  </a>
                            
                    </div>
                    </div>
                </div>';

            $result['data'][$key] = array(
                $i,
                $value['ut_name_en'],
                $value['ut_name_ar'],
                //  $stat_icon . ' ' . $value['ut_status'],
                $buttons,
            );
            $i++;
        } // /foreach
        // print_r($result);
        echo json_encode($result);
    }

    public function add_user_role()
    {
        $setting = new SettingsModel();
        $response = array();
        $response['success'] = false;

        $action = $this->request->getPost('btn_action');
        if ($action == "btn_add") {

            $user_data = [
                'ut_name_en' => $this->request->getPost('ut_name_en'),
                'ut_name_ar' => $this->request->getPost('ut_name_ar'),
                'ut_des' => $this->request->getPost('ut_des'),
                'ut_timestamp' => time(),
                'ut_status' => 'Active',
            ];
            $setting->store('tbl_user_type', $user_data);
            $response['success'] = true;
            $response['alert_outer'] = $this->alert(lang('Site.state.added_successfully'), 'success');
        } else {
            $data = [
                'ut_name_en' => $this->request->getPost('ut_name_en'),
                'ut_name_ar' => $this->request->getPost('ut_name_ar'),
                'ut_des' => $this->request->getPost('ut_des'),
            ];

            $setting->updatedata('tbl_user_type', 'ut_id', $_POST['ut_id'], $data);
            $response['success'] = true;
            $response['alert_outer'] = $this->alert('Roles Updated', 'success');
        }


        echo json_encode($response);
    }

    public function uac()
    {
        $auth = new AuthModel();
        $stmodel = new SettingsModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['users'] = $stmodel->get_users();

        return view('admin/user/uac', $this->viewData);
    }
    public function get_menus()
    {

        $stmodel = new SettingsModel();
        $ut_id = $this->request->getVar('ut_id');
        $menus = $stmodel->get_main_menus();

        $output = '<table class="table table-bordered table-hover"
        <thead>
        <tr>
        <th>Selection</th>
        <th>Menu Name</th>
        <th>Sub Menus</th>
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
                <td> <input type="checkbox" name="menu_parents[]" class="checkbox ckall" data-id="' . $tab_id . '" value=' . $menu['tab_id'] . ' checked> </td>
                <td><a>' . $menu['tab_name_en'] . '</a></td>
                <td> <a href="javascript:;" class="sendmsg"><i class="fa fa-list" aria-hidden="true"></i> </a> </d>
                </tr>
            ';
            } else {
                $output .= '
                <tr>
                <td> <input type="checkbox" name="menu_parents[]" class="checkbox ckall" data-id="' . $tab_id . '" value=' . $menu['tab_id'] . '> </td>
                <td><a>' . $menu['tab_name_en'] . '</a></td>
                <td> <a href="javascript:;" class="sendmsg"><i class="fa fa-list" aria-hidden="true"></i> </a> </d>
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
        $stmodel = new SettingsModel();
        $ut_id = $this->request->getVar('ut_id');
        $inner = '';
        $inner = '<tr style="display:none;">
        <td colspan="3">
                <table class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>Selection</th>
                <th>Sub Menu</th>
                </tr>
                </thead>
                <tbody>';

        $j = 1;
        $menus = $stmodel->get_sub_menus($id);

        foreach ($menus as $menu) {

            $result = $stmodel->has_access($ut_id, $menu['tab_id']);

            if ($result) {

                $inner .= '<tr>
                <td> <input type="checkbox" name="menu_children[]" class="checkbox chchild-' . $id . '" value=' . $menu['tab_id'] . ' checked></td>
                <td>' . $menu['tab_name_en'] . ' </td></tr>';
            } else {
                $inner .= '<tr>
                <td> <input type="checkbox" name="menu_children[]" class="checkbox chchild-' . $id . '" value=' . $menu['tab_id'] . '>
                </td>
                <td>' . $menu['tab_name_en'] . ' </td></tr>';
            }

            //$j++;
        }

        $inner .= '</tbody></table>';

        return $inner;
    }

    public function update_access()
    {
        $stmodel = new SettingsModel();

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

    /**
     * Units
     */
    public function branches()
    {
        $auth = new AuthModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['title'] = 'Branches';
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());

        return view('admin/branch', $this->viewData);
    }

    public function get_branches()
    {

        $result = array('data' => array());
        $stmodel = new SettingsModel();
        $data = $stmodel->get_branches();
        $i = 1;
        foreach ($data as $key => $value) {
            $buttons = '';


            $buttons = '<div class="ml-auto">
                    <div class="dropdown sub-dropdown">
                        <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fas fa-ellipsis-v mx-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                    
                           <a type="button"  id="btn_edit" data-br_id="' . $value["branch_id"] . '"
                                data-br_name="' . $value["br_name"] . '"
                                data-br_address="' . $value["br_address"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#branch_modal">
                                <i class="fas fa-pencil-alt text-warning mx-1"></i>' . lang("Site.button.edit") . '  </a>

                    </div>
                    </div>
                </div>';

            $result['data'][$key] = array(
                $i,
                $value['br_name'],
                $value['br_address'],
                // $stat_icon . ' ' . $value['status'],
                $buttons,
            );
            $i++;
        } // /foreach

        echo json_encode($result);
    }
    public function record_branch()
    {
        $stmodel = new SettingsModel();

        $response = ['success' => false];

        switch ($_POST['btn_action']) {

            case "btn_add":
                $data = [
                    'br_name' => $this->request->getVar('br_name'),
                    'br_address' => $this->request->getVar('br_address'),
                    'br_status' => 'Active',
                    'br_tag' => 'sub',
                    'br_timestamp' => time(),
                ];
                $brid = $stmodel->store('tbl_branches', $data);

                $response['success'] = true;
                $response['msg'] = lang('Site.state.added_successfully');
                break;
            case "btn_edit":

                $data = [
                    'branch_id' => $_POST['br_id'],
                    'br_name' => $this->request->getVar('br_name'),
                    'br_address' => $this->request->getVar('br_address'),
                ];

                $stmodel->update_branch($data);
                $response['success'] = true;
                $response['msg'] = lang('Site.state.updated_successfully');

                break;

            default:
                $response['msg'] = lang('Site.state.error_occured');
        }

        echo json_encode($response);
    }
}
