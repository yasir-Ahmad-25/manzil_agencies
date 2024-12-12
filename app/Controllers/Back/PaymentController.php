<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\PaymentModel;

class PaymentController extends BaseController
{

    public function list()
    {
        $auth = new AuthModel();
        $payment = new PaymentModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['title'] = 'Payments';
        $this->viewData['suppliers'] = $this->get_table_with_branch('tbl_suppliers');
        $this->viewData['accounts'] = $payment->get_cash_bank_accounts();
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/payment/payment_list', $this->viewData);
    }

    public function fetch_payments()
    {
        $payment = new PaymentModel();

        $result = array('data' => array());

        $data = $payment->get_payment_info();

        $i = 1;
        foreach ($data as $key => $value) {

            $buttons = '';

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">
                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                <a type="button" data-pay_id="' . $value["pay_id"] . '" data-trx_id="' . $value["trx_id"] . '" 
                data-amount="' . $value["pay_amount"] . '" data-sup_id="' . $value["sup_id"] . '"
                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal">
                <i class="fas fa-trash-alt text-danger mx-1"></i>Delete </a>
            </div>
            </div>
        </div>';

            $result['data'][$key] = array(
                $value['sup_name'],
                '$' . $value['pay_amount'],
                $value['acc_name'],
                $value['pay_date'],
                $buttons,
            );

            $i++;
        } // /foreach

        echo json_encode($result);
    }



    public function create_payment()
    {
        $payment = new PaymentModel();
        $response = array();
        $response['success'] = false;

        if (floatval($_POST['pay_amount']) > $payment->account_balance($_POST['account_id'])) {
            $response['alert_inner'] = $this->alert('Account balance is Insufficient!', 'danger');
            echo json_encode($response);
            exit;
        }

        if (empty($_POST['sup_id'])) {
            $response['alert_inner'] = $this->alert('Select Supplier', 'danger');
        } else if (empty($_POST['pay_amount'])) {
            $response['alert_inner'] = $this->alert('Enter Amount', 'danger');
        } else if (empty($_POST['account_id'])) {
            $response['alert_inner'] = $this->alert('Select Account', 'danger');
        } else 
            if ($_POST['btn_action'] == "btn_add") {

            $payment_done = $payment->record_payment($_POST['account_id'],  $_POST['pay_amount'], $_POST['sup_id'], $_POST['pay_date']);

            if ($payment_done) {
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Receipt Has Been Created', 'success');
            } else {
                $response['success'] = false;
                $response['alert_outer'] = $this->alert('Payment failed, please try again', 'warning');
            }
        } else if ($_POST['btn_action'] == "btn_edit") {

            $data = [
                'pay_id' => $_POST['pay_id'],
                'pay_amount' => $this->request->getVar('amount'),
                'inv_id' => $this->request->getVar('amount'),
                'account_id' =>  $this->request->getVar('sup_id'),
            ];
            $response['success'] = $payment->update_table('tbl_supplier_payments',  $data);
            
            $response['alert_outer'] = $this->alert('Payment Has Been Updated.', 'success');
        }


        echo json_encode($response);
    }

    public function delete_payment()
    {
        $response = array();
        $response['success'] = false;

        $payment = new PaymentModel();

        $result = $payment->delete_payment();

        if ($result) {

            $response['success'] = $result;
            $response['alert_outer'] = $this->alert('Payment has been deleted', 'success');
        } else {
            $response['success'] = $result;
            $response['alert_outer'] = $this->alert('Payment deletion failed', 'success');
        }

        echo json_encode($response);
    }
}
