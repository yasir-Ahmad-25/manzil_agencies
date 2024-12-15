<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\DashboardModel;
use App\Models\Back\OwnerModel;

class OwnerController extends BaseController
{


    public function index(){
        $auth = new AuthModel();
        $dashoard = new DashboardModel();


        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/owner/owners', $this->viewData);
    }

    public function fetch_owners()
    {

        $owner = new OwnerModel();
        $result = array('data' => array());

        $data = $owner->get_type_data('tbl_owners', 'owner_id');

        $i = 1;
        foreach ($data as $key => $value) {

            $set = [
                'id' => $value["owner_id"],
                'rec_title' => $value["fullname"],
                // 'status' => $value["status"],
                'rec_tbl' => 'tbl_owners',
                // 'rec_tag_col' => 'status',
                'rec_id_col' => 'owner_id',
            ];


            
            $result['data'][$key] = array(
                $i,
                $value['fullname'],
                $value['phone'],
                $value['email'],
                $value['owner_type'],
                $value['companyName'] == "" ? "personal" : $value['companyName'],
            );

            // $this->display(  $this->Property_model->get_num_floors($value['site_name']).' Floors');
            $i++;
        } // /foreach

        echo json_encode($result);
    }
    public function crud_owners()
    {
        $owner = new OwnerModel();

        
        $response = array();
        $response['success'] = false;
        if (empty($_POST['fullname'])) {
            echo $_POST['fullname'];
            $response['alert_inner'] = $this->alert('Enter Owner Name', 'danger');
        } else if ($_POST['btn_action'] == "btn_add") { // SAVE DATA TO DB


                // Added some validations

                if(!$_POST['fullname']){

                    $response['alert_inner'] = $this->alert('please Provide Fullname', 'danger');
                    echo json_encode($response);
                    exit();
                }else if(!$_POST['Phone']){

                    $response['alert_inner'] = $this->alert('please Provide Phone-number', 'danger');
                    echo json_encode($response);
                    exit();
                }else if(!$_POST['Email']){

                    $response['alert_inner'] = $this->alert('please Provide Email Address', 'danger');
                    echo json_encode($response);
                    exit();
                } else if (!$_POST['OwnerType']){

                    $response['alert_inner'] = $this->alert('please Provide OwnerType', 'danger');
                    echo json_encode($response);
                    exit();
                }

                if($_POST['OwnerType'] != "individual"){
                    if (!$_POST['companyName']){

                        $response['alert_inner'] = $this->alert('please Provide the name of the company', 'danger');
                        echo json_encode($response);
                        exit();
                    }else{
                        // check if the provided site is already exist in the database
                        $sql = "SELECT * FROM tbl_owners WHERE companyName	='" . $_POST['companyName'] . "'";
                        if ($owner->query($sql)->getNumRows() > 0) {
                            $response['alert_inner'] = $this->alert('Company Name Already Exist', 'danger');
                            echo json_encode($response);
                            exit();
                        }

                    }
                }



                // collect data
                $data = [
                    'fullname' => $_POST['fullname'],
                    'phone' => $_POST['Phone'],
                    'email' => $_POST['Email'],
                    'owner_type' => $_POST['OwnerType'],
                    'companyName' => $_POST['companyName'],
                ];

                $owner_id = $owner->store('tbl_owners', $data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Owner Has Been Added', 'success');

        } else if ($_POST['btn_action'] == "btn_edit") { // SAVE THE UPDATED DATA

                // collect the updated  Data
                $data = [
                    'fullname' => $_POST['fullname'],
                    'phone' => $_POST['Phone'],
                    'email' => $_POST['Email'],
                    'owner_type' => $_POST['OwnerType'],
                    'companyName' => $_POST['companyName'],
                ];
                $owner->update_table('tbl_owners', $data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Owner Has Been Updated.', 'success');
        } 


        echo json_encode($response);
    }
}