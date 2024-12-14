<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\ReadingModel;

class RateController extends BaseController
{

    function list()
    {
        $auth = new AuthModel();
        

        $this->viewData['title'] = 'Rates';
        $this->viewData['sites'] = $this->get_table_info('tbl_sites');
        $this->viewData['accounts'] = $this->get_cash_bank_accounts();
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());

        return view('admin/meter_reading/rates', $this->viewData);
    }


    public function fetch_rate()
    {
        $rate = new ReadingModel();

        $result = array('data' => array());

        $data = $rate->get_all_rate();
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
                'id' => $value["rate_id"],
                'rec_title' => $value["base_name"],
                'status' => $value["rate_status"],
                'rec_tbl' => 'tbl_rates',
                'rec_tag_col' => 'rate_status',
                'rec_id_col' => 'rate_id',
            ];

            $buttons = $btn['header'] . '
            
                           <a type="button" id="btn_edit"  
                                data-rate_id="' . $value["rate_id"] . '"
                                data-base_name="' . $value["base_name"] . '" 
                                data-rate_percentage="' . $value["rate_value"] . '"
                                data-bs-target="#rate_modal" class="dropdown-item" data-bs-toggle="modal">
                                <i class="fas fa-pencil-alt text-warning mx-1"></i>Edit   
                           </a>
                                            
                    </div>
                    </div>
            </div>';


            $result['data'][$key] = array(
                $i,
                $value['base_name'],
                $value['rate_value'],
                $buttons,
            );
            $i++;
        } // /foreach
        // print_r($result);
        echo json_encode($result);
    }

    public function create_rate()
    {
        $rate = new ReadingModel();

        $response = array();
        $response['success'] = false;

        if (empty($_POST['base_name'])) $response['alert_inner'] = $this->alert('Enter Name', 'danger');
        else if (empty($_POST['btn_action'])) $response['alert_inner'] = $this->alert('Error! Refresh The Page', 'danger');
        else {
            if ($_POST['btn_action'] == 'btn_add') {

                if (empty($response['alert_inner'])) {
                    $data = [
                        'base_name' => $this->request->getPost('base_name'),
                        'rate_value' => $this->request->getPost('rate_percentage'),
                        'rate_status' => 'Active'
                    ];
                    $rate->store('tbl_rates', $data);

                    $response['success'] = true;
                    $response['alert_outer'] = $this->alert('Rate Has Been Added', 'success');
                }
            } else if ($_POST['btn_action'] == 'btn_edit') {

                $data = [

                    'rate_id' => $this->request->getPost('rate_id'),
                    'base_name' => $this->request->getPost('base_name'),
                    'rate_value' => $this->request->getPost('rate_percentage'),
                ];

                $response['success'] = $rate->update_table('tbl_rates', $data);
                $response['alert_outer'] = $this->alert('Rate Has Been Updated.', 'success');
            }
        }
        echo json_encode($response);
    }
}
