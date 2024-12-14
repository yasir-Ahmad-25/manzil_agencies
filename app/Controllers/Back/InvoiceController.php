<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\InvoiceModel;
use App\Models\Back\SupplierModel;

class InvoiceController extends BaseController
{

    public function list()
    {
        $auth = new AuthModel();
        $invoice = new InvoiceModel();


        $this->viewData['title'] = 'Bills';
        $this->viewData['accounts'] = $invoice->get_expense_accounts();
        $this->viewData['suppliers'] = $this->get_table_with_branch('tbl_suppliers');

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/invoice/invoice_list', $this->viewData);
    }

    public function fetch_invoices()
    {
        $invoice = new InvoiceModel();

        $result = array('data' => array());

        $data = $invoice->get_invoice_info();

        $i = 1;
        foreach ($data as $key => $value) {

            $buttons = '';

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">
                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                ';

            if ($value['inv_status'] == "UNPAID") {

                $buttons .= '<a type="button" id="btn_edit" data-amount="' . $value["amount"] . '" data-inv_ref="' . $value["inv_ref"] . '"   
                data-amount="' . $value["amount"] . '" data-inv_date="' . $value["inv_date"] . '" data-account_id="' . $value["account_exp_id"] . '" 
                data-sup_id="' . $value["sup_id"] . '" data-inv_id="' . $value["inv_id"] . '" data-trx_id="' . $value["trx_id"] . '" 
                data-remarks="' . $value["remarks"] . '"
                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#invoice_modal">
                <i class="fas fa-pencil-alt text-warning mx-1"></i>Edit </a>';
            }

            $buttons .= '</div>
            </div>
            </div>';
            $result['data'][$key] = array(
                $value['inv_ref'],
                $value['remarks'],
                $value['sup_name'],
                '$' . $value['amount'],
                $value['acc_name'],
                $value['inv_date'],
                $buttons,
            );

            $i++;
        } // /foreach

        echo json_encode($result);
    }

    public function create_invoice()
    {
        $invoice = new InvoiceModel();
        $response = array();
        $response['success'] = false;

        if (empty($_POST['sup_id'])) {
            $response['alert_inner'] = $this->alert('Select Supplier', 'danger');
        } else if (empty($_POST['amount'])) {
            $response['alert_inner'] = $this->alert('Enter Amount', 'danger');
        } else if (empty($_POST['account_id'])) {
            $response['alert_inner'] = $this->alert('Select Account', 'danger');
        } else if (empty($_POST['inv_rem'])) {
            $response['alert_inner'] = $this->alert('Enter Faahfaahin', 'danger');
        } else  
            if ($_POST['btn_action'] == "btn_add") {

            $exp_acc = $this->request->getVar('account_id');
            //  $cb = $this->request->getVar('account_id');

            $trid = $invoice->record_transactions('Invoice', $_POST['amount'], $_POST['sup_id'], $exp_acc, $_POST['inv_rem']);

            $data = [
                'inv_no' => $invoice->generate_invoice_no(),
                'amount' => $this->request->getVar('amount'),
                'balance' => $this->request->getVar('amount'),
                'sup_id' =>  $this->request->getVar('sup_id'),
                'inv_ref' =>  $this->request->getVar('inv_ref'),
                'inv_date' => $this->request->getVar('inv_date'),
                'account_exp_id' => $this->request->getVar('account_id'),
                'remarks' => $this->request->getVar('inv_rem'),
                'trx_id' => $trid,
                'inv_status' => 'UNPAID',
            ];
            $invoice->store('tbl_supplier_invoices', $data);
            $invoice->update_bal($_POST['amount'], $_POST['sup_id'], $trid);

            $response['success'] = true;
            $response['alert_outer'] = $this->alert('Invoice Has Been Added', 'success');
        } else if ($_POST['btn_action'] == "btn_edit") {

            $trx_id = $this->request->getVar('trx_id');
            $ttl = $this->request->getVar('prv_ttl');

            // delete previous invoice trx
            $invoice->redo_account_trx($trx_id, $ttl);

            $trid = $invoice->record_transactions('Invoice', $_POST['amount'], $_POST['sup_id'], $_POST['account_id'], $_POST['inv_rem']);

            $data = [
                'inv_id' => $_POST['inv_id'],
                'amount' => $this->request->getVar('amount'),
                'balance' => $this->request->getVar('amount'),
                'sup_id' =>  $this->request->getVar('sup_id'),
                'inv_ref' =>  $this->request->getVar('inv_ref'),
                'inv_date' => $this->request->getVar('inv_date'),
                'account_exp_id' => $this->request->getVar('account_id'),
                'trx_id' => $trid,
            ];
            
            $invoice->update_table('tbl_supplier_invoices',  $data);
            $invoice->update_sup_bal($_POST['sup_id'], $data['amount'], $trx_id, $data['trx_id']);

            $response['success'] = true;
            $response['alert_outer'] = $this->alert('Invoice Has Been Updated.', 'success');
        }


        echo json_encode($response);
    }


    public function get_outstanding_invoices()
    {
        $invoice = new InvoiceModel();
        $sid = $_POST['sup_id'];
        echo $invoice->get_outstanding_invoices($sid);
    }
}
