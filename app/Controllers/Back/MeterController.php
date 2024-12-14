<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\MeterModel;
use App\Models\Back\ReadingModel;

class MeterController extends BaseController
{

    function list()
    {
        $auth = new AuthModel();
        $meter = new ReadingModel();

        

        $this->viewData['title'] = 'Rates';
        $this->viewData['apartments'] = $meter->get_apartments();
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());

        return view('admin/meter_reading/meters', $this->viewData);
    }


    public function fetch_meters()
    {
        $result = array('data' => array());
        $meter = new ReadingModel();

        $data = $meter->get_meters();
        $i = 1;
        foreach ($data as $key => $value) {

            $btn = [
                'header' => '<div class="ml-auto">
                            <div class="dropdown sub-dropdown"><button class="btn btn-link text-dark" type="button"
                            id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fas fa-ellipsis-v mx-1"></i></button><div class="dropdown-menu dropdown-menu-right" 
                            aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; 
                            top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                ',
                'mid_1' => '',
            ];
            $set = [
                'id' => $value["meter_id"],
                'rec_title' => $value["meter_name"],
                'status' => $value["meter_status"],
                'rec_tbl' => 'tbl_meters',
                'rec_tag_col' => 'meter_status',
                'rec_id_col' => 'meter_id',
            ];

            $buttons = $btn['header'] . '
            
                        
                           <a type="button" id="btn_edit"  data-meter_id="' . $set["id"] . '"
                                data-meter_name="' . $value["meter_name"] . '" 
                                data-type="' . $value["type"] . '" 
                                data-ap_id="' . $value["ap_id"] . '" 
                                data-reg_date="' . $value["reg_date"] . '" 
                                data-des="' . $value["des"] . '"
                                data-bs-target="#meter_modal" class="dropdown-item" data-bs-toggle="modal">
                                <i class="fas fa-pencil-alt text-warning mx-1"></i>Edit   
                           </a>
                                            
                            <a  type="button" data-rec_id="' . $set["id"] . '" 
                                data-rec_title="' . $set["rec_title"] . '" data-rec_tag="Active"  data-rec_tbl="' . $set["rec_tbl"] . '"
                                data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#status_modal">
                                <i class="fas fa-check text-success mx-1"></i>Deactivate  
                            </a>
                          
                    </div>
                    </div>
            </div>';


            $result['data'][$key] = array(
                $i,

                $value['meter_name'],
                $value['type'],
                $value['ap_no'],
                $value['des'],
                $value['reg_date'],
                $value['meter_status'],
                $buttons,
            );
            $i++;
        }
        echo json_encode($result);
    }


    public function create_meter()
    {
        $response = array();
        $response['success'] = false;
        $meter = new ReadingModel();

        if (empty($_POST['meter_name'])) $response['alert_inner'] = $this->alert('Enter Name', 'danger');
        else if (empty($_POST['btn_action'])) $response['alert_inner'] = $this->alert('Error! Refresh The Page', 'danger');
        else {
            if ($_POST['btn_action'] == 'btn_add') {

                if (empty($response['alert_inner'])) {
                    $data = [

                        'meter_name' => $this->request->getPost('meter_name'),
                        'type' => $this->request->getPost('type'),
                        'ap_id' => $this->request->getPost('ap_id'),
                        'reg_date' => $this->request->getPost('reg_date'),
                        'des' => $this->request->getPost('des'),
                        'profile_no' => '',
                        'meter_status' => 'Active'
                    ];
                    $meter->store('tbl_meters', $data);

                    $response['success'] = true;
                    $response['alert_outer'] = $this->alert('Meter Has Been Added', 'success');
                }
            } else if ($_POST['btn_action'] == 'btn_edit') {
                $data = [
                    'meter_id' => $this->request->getPost('meter_id'),
                    'meter_name' => $this->request->getPost('meter_name'),
                    'type' => $this->request->getPost('type'),
                    'ap_id' => $this->request->getPost('ap_id'),
                    'reg_date' => $this->request->getPost('reg_date'),
                    'des' => $this->request->getPost('des'),
                ];
                $response['success'] = $meter->update_table('tbl_meters', $data);
                $response['alert_outer'] = $this->alert('Meter Has Been Updated.', 'success');
            }
        }
        echo json_encode($response);
    }
}
