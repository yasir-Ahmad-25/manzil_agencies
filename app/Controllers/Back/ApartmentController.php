<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\ApartmentModel;
use App\Models\Back\AuthModel;
use App\Models\Back\DashboardModel;

class ApartmentController extends BaseController
{

    public function building(): string
    {
        $auth = new AuthModel();
        $dashoard = new DashboardModel();


        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/apartment/building', $this->viewData);
    }



    public function fetch_sites()
    {

        $apartment = new ApartmentModel();
        $result = array('data' => array());

        $data = $apartment->get_type_data('tbl_sites', 'site_id', 'status');

        $i = 1;
        foreach ($data as $key => $value) {

            $set = [
                'id' => $value["site_id"],
                'rec_title' => $value["site_name"],
                'status' => $value["status"],
                'rec_tbl' => 'tbl_sites',
                'rec_tag_col' => 'status',
                'rec_id_col' => 'site_id',
            ];


            $buttons = '';
            $stat_icon = $this->stat_icon($set["status"]);
            $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
            $block = ($set["status"] == 'Active') ? '' : 'hidden';



            // menu button

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">

                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                    <a type="button" id="btn_view" data-site_id="' . $value["site_id"] . '" 
                         data-site_build_year="' . $value["SiteYearBuild"] .' "
                         data-site_owner="' . $value["site_owner"] .'"
                        data-site_name="' . $value["site_name"] . '" data-site_address="' . $value["site_address"] . '"
                        data-floor="' . $apartment->get_num_floors($value['site_name']) . '" data-Prefix="' . 'Floor' . '"
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sitemodel">
                        <i class="fas fa-info-circle text-info mx-1"></i> View </a>

                   <a type="button" id="btn_edit"  data-site_id="' . $value["site_id"] . '"  
                   data-site_name="' . $value["site_name"] . '" data-site_owner="' . $value["site_owner"] .'" data-site_build_year="' . $value["SiteYearBuild"] .'" data-site_address="' . $value["site_address"] . '"
                   data-floor="' . $apartment->get_num_floors($value['site_name']) . '" data-Prefix="' . 'Floor' . '"
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sitemodel">
                        <i class="fas fa-pencil-alt text-warning mx-1"></i> Edit </a>
                    
                   ';


                   if($value['status'] == "Active"){
                    $buttons .= 
                     '<a type="button" id="btn_delete"  data-site_id="' . $value["site_id"] . '"  
                   data-site_name="' . $value["site_name"] . '" data-site_owner="' . $value["site_owner"] .'" data-site_build_year="' . $value["SiteYearBuild"] .'" data-site_address="' . $value["site_address"] . '"
                   data-floor="' . $apartment->get_num_floors($value['site_name']) . '" data-Prefix="' . 'Floor' . '"
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sitemodel">
                        <i class="fa fa-trash text-danger mx-1"></i>  De-Activate </a>
                        </div>
                        </div>
                </div>';
            }else{
                $buttons .= 
                       '<a type="button" id="btn_Activate"  data-site_id="' . $value["site_id"] . '"  
                     data-site_name="' . $value["site_name"] . '" data-site_owner="' . $value["site_owner"] .'" data-site_build_year="' . $value["SiteYearBuild"] .'" data-site_address="' . $value["site_address"] . '"
                     data-floor="' . $apartment->get_num_floors($value['site_name']) . '" data-Prefix="' . 'Floor' . '"
                          class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sitemodel">
                          <i class="fa fa-check text-success mx-1"></i>  Activate </a>
                          </div>
                          </div>
                  </div>';

                   }

            // end menu button

            $result['data'][$key] = array(
                $i,
                $value['site_name'],
                $value['site_owner'],
                $value['site_address'],
                $value['SiteYearBuild'],
                $apartment->get_num_floors($value['site_name']) . ' Floors',
                $stat_icon . ' ' . $value['status'],
                $buttons,
            );

            // $this->display(  $this->Property_model->get_num_floors($value['site_name']).' Floors');
            $i++;
        } // /foreach

        echo json_encode($result);
    }

    public function generate_floorbynum($num_of_floor, $prefix, $site_id)
    {

        $apartment = new ApartmentModel();

        for ($i = 1; $i <= $num_of_floor; $i++) {
            $floorname = $prefix . ' ' . $i;
            $data = [
                // 'profile_no' => $this->session->userdata('profile')['profile_no'],
                'floor_name' => $floorname,
                'site_id' => $site_id,
                'floor_status' => 'Active'
            ];
            $apartment->store('tbl_floors', $data);
        }
        // $floorname = implode(',', $floorname); 

    }

    public function generate_floorbyalpha($num_of_floor, $prefix, $site_id)
    {
        $apartment = new ApartmentModel();
        $floorname = array();
        for ($i = 1; $i <= $num_of_floor; $i++) {
            $floorname = $prefix . ' ' . chr($i + 64);
            $data = [
                // 'profile_no' => $this->session->userdata('profile')['profile_no'],
                'floor_name' => $floorname,
                'site_id' => $site_id,
                'floor_status' => 'Active'
            ];

            $apartment->store('tbl_floors', $data);
        }
        // $floorname = implode(',', $floorname);   
    }

    public function crud_sites()
    {
        $apartment = new ApartmentModel();

        $default_status = 'Active';
        $response = array();
        $response['success'] = false;
        if (empty($_POST['sitename'])) {
            echo $_POST['sitename'];
            $response['alert_inner'] = $this->alert('Enter Site Name', 'danger');
        } else if ($_POST['btn_action'] == "btn_add") { // SAVE DATA TO DB


                // Added some validations

                if(!$_POST['floor']){

                    $response['alert_inner'] = $this->alert('please No of Floors That Builing contains', 'danger');
                    echo json_encode($response);
                    exit();
                }


                // check if the provided site is already exist in the database
                $sql = "SELECT * FROM tbl_sites WHERE site_name='" . $_POST['sitename'] . "'";
                if ($apartment->query($sql)->getNumRows() > 0) {
                    $response['alert_inner'] = $this->alert('Site Name Already Exist', 'danger');
                    echo json_encode($response);
                    exit();
                }

                // collect data
                $data = [
                    'site_name' => $_POST['sitename'],
                    'site_address' => $_POST['siteaddress'],
                    'site_owner' => $_POST['siteOwner'],
                    'SiteYearBuild' => $_POST['SiteYearBuild'],
                    'No_of_Floors' => $_POST['floor'],
                    // 'profile_no' => $this->session->userdata('profile')['profile_no'],
                    'status' => $default_status
                ];
                $site_id = $apartment->store('tbl_sites', $data);
                $response['success'] = true;
                if ($_POST['floors'] == 'bynum') {
                    $this->generate_floorbynum($_POST['floor'], $_POST['Prefix'], $site_id);
                } else {
                    $this->generate_floorbyalpha($_POST['floor'], $_POST['Prefix'], $site_id);
                }

                $response['alert_outer'] = $this->alert('Site Has Been Added', 'success');
        } else if ($_POST['btn_action'] == "btn_edit") { // SAVE THE UPDATED DATA

                // collect the updated  Data
                $data = [
                    'site_id' => $_POST['site_id'],
                    'site_name' => $_POST['sitename'],
                    'site_address' => $_POST['siteaddress'],
                    'site_owner' => $_POST['siteOwner'],
                    'SiteYearBuild' => $_POST['SiteYearBuild'],
                    'No_of_Floors' => $_POST['floor'],
                ];
                $apartment->update_table('tbl_sites', $data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Site Has Been Updated.', 'success');
        } else if ($_POST['btn_action'] == "btn_delete") { // DE-ACTIVATES SITE OR BUILDING

                $data = [
                    'site_id' => $_POST['site_id'],
                    'site_name' => $_POST['sitename'],
                    'site_address' => $_POST['siteaddress'],
                    'site_owner' => $_POST['siteOwner'],
                    'SiteYearBuild' => $_POST['SiteYearBuild'],
                    'No_of_Floors' => $_POST['floor'],
                    'status' => 'De-Active'
                ];

                $apartment->delete_table('tbl_sites', $data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Site Has Been De-Activated Successfully.', 'success');

        } else if ($_POST['btn_action'] == "btn_Activate") { // ACTIVATES SITE OR BUILDING

                $data = [
                    'site_id' => $_POST['site_id'],
                    'site_name' => $_POST['sitename'],
                    'site_address' => $_POST['siteaddress'],
                    'site_owner' => $_POST['siteOwner'],
                    'SiteYearBuild' => $_POST['SiteYearBuild'],
                    'No_of_Floors' => $_POST['floor'],
                    'status' => 'Active'
                ];

                $apartment->update_table('tbl_sites', $data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Site Has Been Activated Successfully.', 'success');
        }


        echo json_encode($response);
    }


    public function floors(): string
    {
        $auth = new AuthModel();
        $dashoard = new DashboardModel();
        $apartment = new ApartmentModel();

        $this->viewData['site_type'] = $apartment->fill_floor_site();

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/apartment/floors', $this->viewData);
    }



    public function fetch_floors()
    {
        $apartment = new ApartmentModel();
        $result = array('data' => array());

        $data = $apartment->get_floors_list();

        $i = 1;
        foreach ($data as $key => $value) {

            $set = [
                'id' => $value["floor_id"],
                'rec_title' => $value["floor_name"],
                'status' => $value["floor_status"],
                'rec_tbl' => 'tbl_floors',
                'rec_tag_col' => 'floor_status',
                'rec_id_col' => 'floor_id',
            ];


            $buttons = '';
            $stat_icon = $this->stat_icon($set["status"]);
            $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
            $block = ($set["status"] == 'Active') ? '' : 'hidden';


            // menu button

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">
                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                    <a type="button" id="btn_view" data-floor_id="' . $value["floor_id"] . '"  
                        data-floor_name="' . $value["floor_name"] . '" data-site_id="' . $value["site_id"] . '"
                        class="dropdown-item" data-toggle="modal" data-target="#floormodel">
                        <i class="fas fa-info-circle text-info mx-1"></i>View </a>

                   <a type="button" id="btn_edit"  data-floor_id="' . $value["floor_id"] . '"  
                   data-floor_name="' . $value["floor_name"] . '" data-site_id="' . $value["site_id"] . '"
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#floormodel">
                        <i class="fas fa-pencil-alt text-warning mx-1"></i>Edit </a>

                        

              </div>
            </div>
    </div>';

            // end menu button

            $result['data'][$key] = array(
                $i,
                $value['floor_name'],
                $value['site_name'],
                $apartment->get_how_many_apartment_in_floor($value['floor_name'], $value['site_name']) . ' Apartments',
                $stat_icon . ' ' . $value['floor_status'],
                $buttons,
            );

            $i++;
        } // /foreach

        echo json_encode($result);
    }


    public function fetch_floors_byid($id = null)
    {
        if ($id) {
            $data = $this->Property_model->get_type_data('tbl_floors', 'floor_id', 'floor_status', $id);
            echo json_encode($data);
        }
    }


    public function crud_floors()
    {

        $apartment = new ApartmentModel();
        $default_status = 'Active';
        $response = array();
        $response['success'] = true;
        // $response['alert_inner'] = $this->alert(json_encode($_POST), 'danger');
        // echo json_encode($response);
        // exit();
        if (empty($_POST['floor_name'])) {
            // echo $_POST['name'];
            $response['alert_inner'] = $this->alert('Enter Floor Name', 'danger');
        } else
            if ($_POST['btn_action'] == "btn_add") {
                // $profile = $this->session->userdata('profile')['profile_no'];
                $sql = "SELECT * FROM tbl_floors f,  tbl_sites s WHERE s.site_id=f.site_id and f.floor_name='" . $_POST['floor_name'] . "'
                 and s.site_id='" . $_POST['site_id'] . "' ";
                if ($apartment->query($sql)->getNumRows() > 0) {
                    $response['alert_inner'] = $this->alert('Floor Name Already Exist', 'danger');
                    echo json_encode($response);
                    exit();
                }

                $data = [
                    'floor_name' => $_POST['floor_name'],
                    'site_id' => $_POST['site_id'],
                    // 'profile_no' => $this->session->userdata('profile')['profile_no'],
                    'floor_status' => $default_status
                ];
                $apartment->store('tbl_floors', $data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Floors Has Been Added', 'success');
            } else if ($_POST['btn_action'] == "btn_edit") {
                $data = [
                    'floor_id' => $_POST['floor_id'],
                    'floor_name' => $_POST['floor_name'],
                    'site_id' => $_POST['site_id']
                ];
                $response['success'] = $apartment->update_table('tbl_floors', $data);
                $response['alert_outer'] = $this->alert('Floors Has Been Updated.', 'success');
            }


        echo json_encode($response);
    }





    public function apartment_types(): string
    {
        $auth = new AuthModel();
        $dashoard = new DashboardModel();


        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/apartment/apartment_types', $this->viewData);
    }



    public function fetch_apart_types()
    {


        $apartment = new ApartmentModel();

        /*
         $('#btn_main').html('<button <?= $state = ($this->session->userdata("profile")["sub_users"] <= $this->Admin_model->no_users($this->session->userdata("profile")["profile_no"])) ? "disabled" : ""  ?> class="btn btn-primary " id="btn_add" data-toggle="modal" data-target="#form_modal"> + <?= lang("btn")["user"] . " " . $this->Admin_model->no_users($this->session->userdata("profile")["profile_no"]) . "/" . $this->session->userdata("profile")["sub_users"]; ?></button> <br>');
         */

        $result = array('data' => array());

        $data = $apartment->get_type_data('tbl_apartment_types', 'ap_type_id', 'ap_type_status');
        $i = 1;
        foreach ($data as $key => $value) {
            $set = [
                'id' => $value["ap_type_id"],
                'rec_title' => $value["ap_type_name"],
                'status' => $value["ap_type_status"],
                'rec_tbl' => 'tbl_apartment_types',
                'rec_tag_col' => 'ap_type_status',
                'rec_id_col' => 'ap_type_id',
            ];

            if ($apartment->get_ap_type_in_apartment($value["ap_type_name"]) == true) {
                $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
                $block = ($set["status"] == 'Active') ? '' : 'hidden';
                $delete = '';
            } else {
                $act = 'hidden';
                $block = 'hidden';
                $delete = 'hidden';
            }


            $buttons = '';
            $stat_icon = $this->stat_icon($set["status"]);
            // $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
            // $block = ($set["status"] == 'Active') ? '' : 'hidden';

            // menu button

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">
                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                    <a type="button" id="btn_view"- dataap_type_id="' . $value["ap_type_id"] . '" 
                        data-site_build_year="' . $value["SiteYearBuild"] .'"  
                        data-ap_type_name="' . $value["ap_type_name"] . '"
                        data-des="' . $value["des"] . '"
                        class="dropdown-item" data-toggle="modal" data-target="#form_modal">
                        <i class="fas fa-info-circle text-info mx-1"></i>View </a>

                   <a type="button"  id="btn_edit" data-ap_type_id="' . $value["ap_type_id"] . '"  
                   data-ap_type_name="' . $value["ap_type_name"] . '"
                   data-des="' . $value["des"] . '"
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#form_modal">
                        <i class="fas fa-pencil-alt text-warning mx-1"></i>Edit </a>
 

                        <a ' . $delete . ' type="button" data-rec_id="' . $set["id"] . '"
                        data-rec_title="' . $set["rec_title"] . '" data-rec_tag="Deleted" data-rec_tbl="' . $set["rec_tbl"] . '" 
                        data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                        class="dropdown-item" data-toggle="modal" data-target="#status_modal">
                        <i class="fas fa-trash-alt text-danger mx-1"></i>' . 'delete' . '  
                    </a>
                        
              </div>
            </div>
    </div>';

            // end menu button

            $result['data'][$key] = array(
                $i,
                $value['ap_type_name'],
                $value['des'],
                $stat_icon . ' ' . $value['ap_type_status'],
                $buttons,
            );
            $i++;
        } // /foreach

        echo json_encode($result);
    }



    public function crud_apart_type()
    {
        $apartment = new ApartmentModel();
        $response = array();
        $response['success'] = true;
        if (empty($_POST['type_name']))
            $response['alert_inner'] = $this->alert('Enter Apartment Type', 'danger');
        else
            if ($_POST['btn_action'] == "btn_add") {
                $sql = "SELECT * FROM tbl_apartment_types WHERE ap_type_name='" . $_POST['type_name'] . "'";
                if ($apartment->query($sql)->getNumRows() > 0) {
                    $response['alert_inner'] = $this->alert('Type Name Already Exist', 'danger');
                    echo json_encode($response);
                    exit();
                }

                $data = [
                    'ap_type_name' => $_POST['type_name'],
                    'des' => $_POST['des'],
                    'ap_type_status' => 'Active',
                    // 'profile_no' => $this->session->userdata('profile')['profile_no'],
                ];
                $apartment->store('tbl_apartment_types', $data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Apartment Type Has Been Added', 'success');
            } else if ($_POST['btn_action'] == "btn_edit") {
                $data = [
                    'ap_type_id' => $_POST['ap_type_id'],

                    'ap_type_name' => $_POST['type_name'],

                    'des' => $_POST['des'],
                ];
                $response['success'] = $apartment->update_table('tbl_apartment_types', $data);
                $response['alert_outer'] = $this->alert('Apartment Type Has Been Updated.', 'success');
            }


        echo json_encode($response);
    }


    public function apartments(): string
    {
        $auth = new AuthModel();
        $dashoard = new DashboardModel();
        $apartment = new ApartmentModel();

        $this->viewData['types'] = $apartment->get_type_data('tbl_apartment_types', 'ap_type_id', 'ap_type_status');
        $this->viewData['floors'] = $apartment->get_type_data('tbl_floors', 'floor_id', 'floor_status');
        $this->viewData['buildings'] = $apartment->get_sites();
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/apartment/apartments', $this->viewData);
    }


    public function get_floors()
    {
        $site_id = $this->request->getVar('site_id');
        $model = new ApartmentModel();

        $floors = $model->get_floors_for($site_id);
        $html = "";
        foreach ($floors as $floor) {
            $flor_id = $floor['floor_id'];
            $floor_name = $floor['floor_name'];
            $html .="<option value='$flor_id'> $floor_name </option>";
        }

        return $html;

    }
    public function get_apartments()
    {
        $site_id = $this->request->getVar('site_id');
        $model = new ApartmentModel();

        $floors = $model->get_apartments($site_id);
        $html = "";
        
        if(count($floors) == 0){
            $html = '<option value="" selected disabled>No Occupied Apartment </option>';
        }
        if(count($floors) > 0){
            $html = '<option value="" selected disabled>Select Apartment </option>';
        }

        foreach ($floors as $floor) {
            $flor_id = $floor['ap_id'];
            $floor_name = $floor['ap_no'];
            $html .="<option value='$flor_id'> $floor_name </option>";
        }

        return $html;

    }
    public function fetch_apartments()
    {

        $apartment = new ApartmentModel();

        $result = array('data' => array());

        $data = $apartment->get_apartments_list();
        $i = 1;
        foreach ($data as $key => $value) {

            $set = [
                'id' => $value["ap_id"],
                'rec_title' => $value["ap_no"],
                'status' => $value["ap_status"],
                'rec_tbl' => 'tbl_apartments',
                'rec_tag_col' => 'ap_status',
                'rec_id_col' => 'ap_id',
            ];





            $buttons = '';
            $stat_icon = $this->stat_icon($set["status"]);
            $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
            $block = ($set["status"] == 'Active') ? '' : 'hidden';



            // menu button

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">
                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                <a type="button" id="btn_view"  data-ap_id="' . $value["ap_id"] . '"  
                data-ap_no="' . $value["ap_no"] . '" data-floor_id="' . $value["floor_id"] . '" data-ap_type_id="' . $value["ap_type_id"] .
                '" data-price="' . $value["price"] . '" data-bedrooms="' . $value["bedrooms"] . '" data-pathrooms="' . $value["pathrooms"] . '"data-kitchen="' . $value["kitchen"] . '"data-ap_des="' . $value["ap_des"] . '"   
                     class="dropdown-item" data-bs-toggle="modal" data-bs-target="#apartment_model">
                        <i class="fas fa-info-circle text-info mx-1"></i>View </a>

                   <a type="button" id="btn_edit"  data-ap_id="' . $value["ap_id"] . '"  
                   data-ap_no="' . $value["ap_no"] . '" data-floor_id="' . $value["floor_id"] . '" data-ap_type_id="' . $value["ap_type_id"] .
                '" data-price="' . $value["price"] . '" data-bedrooms="' . $value["bedrooms"] . '" data-pathrooms="' . $value["pathrooms"] . '"data-kitchen="' . $value["kitchen"] . '"data-ap_des="' . $value["ap_des"] . '"   
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#apartment_model">
                        <i class="fas fa-pencil-alt text-warning mx-1"></i>Edit </a>

                      


                        


              </div>
            </div>
    </div>';

            // end menu button


            $result['data'][$key] = array(
                $i,
                $value['ap_no'],
                $value['floor_name'],
                $value['ap_type_name'],
                '$' . $value['price'],
                $value['bedrooms'],
                $value['pathrooms'],
                $value['kitchen'],
                $stat_icon . ' ' . $value['ap_status'],
                $buttons
            );

            $i++;
        } // /foreach

        echo json_encode($result);
    }


    public function crud_apartments()
    {

        $apartment = new ApartmentModel();
        $default_status = 'Active';
        $response = array();
        $response['success'] = true;
        if (empty($_POST['ap_no'])) {
            // echo $_POST['sitename'];
            $response['alert_inner'] = $this->alert('Enter Apartment Name', 'danger');
        } else
            if ($_POST['btn_action'] == "btn_add") {
                $site_id = $apartment->get_site_id($_POST['floor_id']); // get site id
                // $profile_no=$this->session->userdata('profile')['profile_no'];
                $sql = "select a.ap_no from tbl_floors f , tbl_apartments a , tbl_sites s where f.floor_id=a.floor_id
                and s.site_id=f.site_id and a.ap_no='" . $_POST['ap_no'] . "' and s.site_id='" . $site_id . "' 
                ";
                if ($apartment->query($sql)->getNumRows() > 0) {
                    $response['alert_inner'] = $this->alert('Apartment No Already Exist', 'danger');
                    echo json_encode($response);
                    exit();
                }


                $data = [
                    'ap_no' => $_POST['ap_no'],
                    'floor_id' => $_POST['floor_id'],
                    'ap_type_id' => $_POST['ap_type_id'],
                    'price' => $_POST['price'],
                    'site_id'=>$_POST['site_id'],
                    'bedrooms' => $_POST['bedrooms'],
                    'pathrooms' => $_POST['pathrooms'],
                    'kitchen' => $_POST['kitchen'],
                    'ap_des' => $_POST['ap_des'],
                    // 'profile_no' => $this->session->userdata('profile')['profile_no'],
                    'ap_status' => $default_status
                ];
                $apartment->store('tbl_apartments', $data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Apartment Has Been Added', 'success');
            } else if ($_POST['btn_action'] == "btn_edit") {
                $data = [

                    'ap_id' => $_POST['ap_id'],
                    'ap_no' => $_POST['ap_no'],
                    'floor_id' => $_POST['floor_id'],
                    'ap_type_id' => $_POST['ap_type_id'],
                    'price' => $_POST['price'],
                    'bedrooms' => $_POST['bedrooms'],
                    'pathrooms' => $_POST['pathrooms'],
                    'kitchen' => $_POST['kitchen']
                ];
                $response['success'] = $apartment->update_table('tbl_apartments', $data);
                $response['alert_outer'] = $this->alert('Apartment Has Been Updated.', 'success');
            }

        echo json_encode($response);
    }

}