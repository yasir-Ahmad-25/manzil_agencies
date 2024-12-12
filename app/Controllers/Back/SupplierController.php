<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\SupplierModel;

class SupplierController extends BaseController
{


    public function list()
    {
        $auth = new AuthModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['title'] = 'Suppliers';
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/supplier/supplier_list', $this->viewData);
    }

    public function services()
    {
        $auth = new AuthModel();

        $this->viewData['title'] = 'Services';

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/supplier/service_list', $this->viewData);
    }

    public function fetch_suppliers()
    {
        $supplier = new SupplierModel();
        $locale = $this->request->getLocale();

        $result = array('data' => array());

        $data = $supplier->get_suppliers_info();

        $i = 1;
        foreach ($data as $key => $value) {

            $buttons = '';

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">
                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                    <a type="button" id="btn_view" data-sup_id="' . $value["sup_id"] . '"  
                        data-sup_name="' . $value["sup_name"] . '" data-sup_phone="' . $value["sup_phone"] . '"
                        data-sup_balance="' . $value["acc_balance"] . '" data-sup_email="' . $value["sup_email"] . '"
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#supplier_modal">
                        <i class="fas fa-info-circle text-info mx-1"></i>View </a>

                <a type="button" id="btn_edit"  data-sup_id="' . $value["sup_id"] . '"  
                data-sup_name="' . $value["sup_name"] . '" data-sup_phone="' . $value["sup_phone"] . '"
                data-sup_balance="' . $value["acc_balance"] . '" data-sup_email="' . $value["sup_email"] . '"
                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#supplier_modal">
                <i class="fas fa-pencil-alt text-warning mx-1"></i>Edit </a>
            </div>
            </div>
    </div>';

            $result['data'][$key] = [
                // $i,
                '<a href=' . base_url($locale) . '/supplier/trx_list?sup_code=' . $value['sup_id'] . '>' . $value['sup_name'] . '<a/>',
                $value['sup_phone'],
                $value['sup_email'],
                '$'.$value['acc_balance'],
                $value['reg_date'],
                $value['sup_status'],
                $buttons,
            ];

            $i++;
        }

        echo json_encode($result);
    }


    public function create_supplier()
    {
        $supplier = new SupplierModel();

        $response = array();
        $response['success'] = false;

        if (empty($_POST['sup_name'])) {
            $response['alert_inner'] = $this->alert('Enter name', 'danger');
        } else if (empty($_POST['sup_phone'])) {
            $response['alert_inner'] = $this->alert('Enter phone', 'danger');
        } else if (empty($_POST['sup_email'])) {
            $response['alert_inner'] = $this->alert('Enter email', 'danger');
        } else 
            if ($_POST['btn_action'] == "btn_add") {

            $data = [
                'sup_name' => $this->request->getVar('sup_name'),
                'sup_phone' => $this->request->getVar('sup_phone'),
                'sup_email' => $this->request->getVar('sup_email'),
                'reg_date' => date('Y-m-d'),
                'sup_status' => 'Active',
                'branch_id' => session()->get('user')['branch_id'],
            ];
            $suppid = $supplier->store('tbl_suppliers', $data);

            $accdata = [
                'acc_name' => htmlspecialchars($_POST['sup_name']),
                'acc_name_ar' => htmlspecialchars($_POST['sup_name']),
                'acc_des' => htmlspecialchars($_POST['sup_name']),
                'acc_grp_id' => '2',
                'acc_type_id' => '3',
                'acc_status' => 'Active',
                'acc_tag' => $suppid,
                'acc_set' => 'Supplier',
            ];
            $supplier->store('tbl_cl_accounts', $accdata);

            $response['success'] = true;
            $response['alert_outer'] = $this->alert('Supplier Has Been Added', 'success');
            
        } else if ($_POST['btn_action'] == "btn_edit") {

            $data = [
                'sup_id' => $this->request->getVar('sup_id'),
                'sup_name' => $this->request->getVar('sup_name'),
                'sup_phone' => $this->request->getVar('sup_phone'),
                'sup_email' => $this->request->getVar('sup_email'),
            ];
            $supplier->update_table('tbl_suppliers', $data);

            $response['success'] = true;
            $response['alert_outer'] = $this->alert('Supplier Has Been Updated.', 'success');
        }


        echo json_encode($response);
    }

    public function trx_list()
    {
        $auth = new AuthModel();
        $supplier = new SupplierModel();
        $sid = $_GET['sup_code'];

        $acc_statement =  $supplier->get_sup_info($sid);
        if($acc_statement == null){
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['title'] = 'Supplier history';
        $this->viewData['sup'] = $acc_statement;
        $this->viewData['history'] = $supplier->get_supp_history($sid);
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/supplier/supplier_trx', $this->viewData);
    }
}
