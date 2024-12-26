<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\CustomerModel;
use App\Models\Back\PaymentModel;
use App\Models\Back\FinancialModel;
use App\Models\Back\RentalModel;

class CustomerController extends BaseController
{

    public function deposits_payable()
    {
        $auth = new AuthModel();
        $payment = new PaymentModel();

        

        $this->viewData['title'] = 'Deposit Payable';
        $this->viewData['customers'] = $this->get_table_with_branch('tbl_customers');
        $this->viewData['accounts'] = $payment->get_cash_bank_accounts();
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/customer/deposit_payment', $this->viewData);
    }
    public function get_outstanding_deposits()
    {
        $invoice = new CustomerModel();
        $sid = $_POST['sup_id'];
        echo $invoice->get_outstanding_deposits($sid)->total_deposit;
    }

    public function fetch_deposits()
    {
        $payment = new PaymentModel();

        $result = array('data' => array());

        $data = $payment->get_deposits();

        $i = 1;
        foreach ($data as $key => $value) {

            $buttons = '';

            //     $buttons = '<div class="ml-auto">
            //     <div class="dropdown sub-dropdown">
            //         <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            //             <i class="fas fa-ellipsis-v mx-1"></i>
            //         </button>
            //         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
            //         <a type="button" data-pay_id="' . $value["pay_id"] . '" data-trx_id="' . $value["trx_id"] . '" 
            //         data-amount="' . $value["pay_amount"] . '" data-sup_id="' . $value["sup_id"] . '"
            //         class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_modal">
            //         <i class="fas fa-trash-alt text-danger mx-1"></i>Delete </a>
            //     </div>
            //     </div>
            // </div>';

            $result['data'][$key] = array(
                $value['cust_name'],
                '$' . abs($value['amount']),
                $value['acc_name'],
                date('d-m-Y H:i:s', strtotime($value['created_at'])),
                '',
            );

            $i++;
        } // /foreach

        echo json_encode($result);
    }
    public function create_deposit_payment()
    {
        $payment = new PaymentModel();
        $response = array();
        $response['success'] = false;

        // if (floatval($_POST['pay_amount']) > $payment->account_balance($_POST['account_id'])) {
        //     $response['alert_inner'] = $this->alert('Account balance is Insufficient!', 'danger');
        //     echo json_encode($response);
        //     exit;
        // }

        if (empty($_POST['sup_id'])) {
            $response['alert_inner'] = $this->alert('Select Customer', 'danger');
        } else if (empty($_POST['pay_amount'])) {
            $response['alert_inner'] = $this->alert('Enter Amount', 'danger');
        } else if (empty($_POST['account_id'])) {
            $response['alert_inner'] = $this->alert('Select Account', 'danger');
        } else
            if ($_POST['btn_action'] == "btn_add") {

                $payment_done = $payment->deposit_payment($_POST['account_id'], $_POST['pay_amount'], $_POST['sup_id'], $_POST['pay_date'] , $_POST['pay_amount']);

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
                    'account_id' => $this->request->getVar('sup_id'),
                ];
                $response['success'] = $payment->update_table('tbl_supplier_payments', $data);

                $response['alert_outer'] = $this->alert('Payment Has Been Updated.', 'success');
            }
        echo json_encode($response);
    }
    public function list()
    {
        $auth = new AuthModel();
         
 
        $this->viewData['title'] = 'Customers';
        $this->viewData['customers'] = $this->get_table_info('tbl_customers');
        $this->viewData['sites'] = $this->get_sites();

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/customer/customer_list', $this->viewData);
    }
    public function advances()
    {
        $auth = new AuthModel();
        $payment = new PaymentModel();


        $this->viewData['title'] = 'Customers Advances';
        $this->viewData['customers'] = $this->get_table_with_branch('tbl_customers');
        // $this->viewData['customers'] = '';
        $this->viewData['accounts'] = $payment->get_cash_bank_accounts();

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/customer/advance', $this->viewData);
    }

    public function customer_open_balance()
    {
        $customer = new CustomerModel();
        $finance = new FinancialModel();

        $response = ['success' => false];
        $date = date('Y-m-d H:i:s');

        if (empty($this->request->getVar('cust_id')))
            $response['alert_inner'] = $this->alert('Select Customer', 'danger');
        else if (empty($this->request->getVar('cust_op_bal')))
            $response['alert_inner'] = $this->alert('Enter balance', 'danger');
        else {

            $cust_id = $this->request->getVar('cust_id');
            $total = $this->request->getVar('cust_op_bal');

            $dracc = $finance->get_custom_account_tag($cust_id, 'Customer')['account_id'] ?? null;
            $cracc = $finance->get_account_tag('OPB')['account_id'];
            if (is_null($dracc)) {
                $response['alert_inner'] = $this->alert('This customer Does not have an account', 'danger');
                echo json_encode($response);
                return;
            }
            $fpid = $finance->financial_period()['fp_id'];
            $trx_id = $finance->record_trx($total, 'Open Balance', $fpid, $date, "Opening Balance for customer id of $cust_id");

            $finance->cr_trx_det($total, $cracc, $trx_id);
            $finance->update_accounnt_balance($cracc, $total, 'cr');

            $finance->dr_trx_det($total, $dracc, $trx_id);
            $finance->update_accounnt_balance($dracc, $total, 'dr');
            // $newBill = [
            //     'customer_id' => $cust_id,
            //     'tran_tag' => 'Bill',
            //     'tran_amount' => $total,
            //     'trx_id' => $trx_id,
            //     'profile_no' => '',
            //     'tran_status' => 'Active',
            //     'tran_date' => date('Y-m-d H:i:s')
            // ];
            // $customer->store('tbl_customer_transactions', $newBill);

            // $customer->db->query("UPDATE tbl_customers set ");

            $response['success'] = true;
            $response['alert_outer'] = $this->alert('Customer balance recorded', 'success');
        }

        echo json_encode($response);
    }
    public function customer_advances()
    {
        $customer = new CustomerModel();
        $customer->db->transStart();
        $customer->db->transException(true);
        $finance = new FinancialModel();

        $response = ['success' => false];
        $date = date('Y-m-d H:i:s');

        if (empty($this->request->getVar('cust_id')))
            $response['alert_inner'] = $this->alert('Select Customer', 'danger');
        else if (empty($this->request->getVar('amount')))
            $response['alert_inner'] = $this->alert('Enter balance', 'danger');
        else {

            $cust_id = $this->request->getVar('cust_id');
            $total = $this->request->getVar('amount');

            $dracc = $_POST['account_id'];
            $cracc = $finance->get_account_tag('ADP')['account_id'];
            if (is_null($dracc)) {
                $response['alert_inner'] = $this->alert('This customer Does not have an account', 'danger');
                echo json_encode($response);
                return;
            }
            $fpid = $finance->financial_period()['fp_id'];
            $trx_id = $finance->record_trx($total, 'Advance Payment', $fpid, $date, "Advance payment for customer id of $cust_id");

            $finance->cr_trx_det($total, $cracc, $trx_id);
            $finance->update_accounnt_balance($cracc, $total, 'cr');

            $finance->dr_trx_det($total, $dracc, $trx_id);
            $finance->update_accounnt_balance($dracc, $total, 'dr');
            $newBill = [
                'tenant_id' => $cust_id,
                'amount' => $total,
                'date' => date('Y-m-d H:i:s'),
            ];
            $customer->store('tbl_clients_advance', $newBill);

            $model = new CustomerModel();

            $date2 = new \DateTime();
            $month = $date2->format('m');
            $ri = $this->rental_income_exists($month, $cust_id, '');
            $rentid = $model->db->query("SELECT * from tbl_rentals where customer_id=$cust_id and end_date > curdate()")->getRow()->rental_id ?? 0;
            $ap_id = $model->db->query("SELECT ap_id from tbl_rentals where rental_id=$rentid")->getRow()->ap_id ?? 0;
            if ($ri == 0) {

                $ridata = [
                    'rental_id' => $rentid,
                    'tenant_id' => $cust_id,
                    'ap_id' => $ap_id,
                    'advances' => $total,
                    'month' => $month,
                ];
                $model->store('rental_income_report', $ridata);
            } else {
                $model->db->query("UPDATE rental_income_report set advances=$total,rental_id=$rentid, tenant_id=$cust_id, month=$month where id=$ri ");
            }
            // $customer->db->query("UPDATE tbl_customers set ");
            if ($customer->db->transStatus() == false) {
                $customer->db->transRollback();
                $response['success'] = false;
                $response['alert_inner'] = $this->alert('Error Occured nothing was recorded', 'danger');
            }
            $response['success'] = true;
            $response['alert_outer'] = $this->alert('Successfuly Paid Advancment', 'success');
            $customer->db->transCommit();
        }

        echo json_encode($response);
    }
    public function rental_income_exists($month, $tenant_id, $rental_id)
    {
        $model = new CustomerModel();
        $sql = "SELECT * from rental_income_report where month=$month and tenant_id=$tenant_id";
        $res = $model->db->query($sql);
        $num = $res->getNumRows();
        if ($num > 0) {
            if ($res->getRow()->rental_id == 0) {
                $model->db->query("UPDATE rental_income_report set rental_id=$rental_id where month=$month and tenant_id=$tenant_id");
                return $res->getRow()->id;
            } elseif ($res->getRow()->rental_id == $rental_id) {
                return $res->getRow()->id;
            } else {
                return $res->getRow()->id;
            }
        } else {
            return 0;
        }
    }

    public function get_advances()
    {
        $customer = new CustomerModel();
        $locale = $this->request->getLocale();

        $result = array('data' => array());

        $data = $customer->get_advances();
        $i = 1;
        foreach ($data as $key => $value) {
            // $set = [
            //     'id' => $value["customer_id"],
            //     'rec_title' => $value["cust_name"],
            //     'status' => $value["cust_status"],
            //     'rec_tbl' => 'tbl_customers',
            //     'rec_tag_col' => 'cust_status',
            //     'rec_id_col' => 'customer_id',
            // ];
            $buttons = '
                     <div class="ml-auto"><div class="dropdown sub-dropdown"><button class="btn btn-link text-dark" type="button"
                         id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                         <i class="fas fa-ellipsis-v mx-1"></i></button><div class="dropdown-menu dropdown-menu-right" 
                         aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; 
                         top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);
                     ">
                 
                     <a  type="button" id="btn_det" data-customer_id="' . $value["id"] . '"
                           data-cust_id="' . $value["tenant_id"] . '" data-amount="' . $value["amount"] . '" 
                            
                           data-date="' . $value["date"] . '" 
                         data-bs-target="#form_modal" class="dropdown-item" data-bs-toggle="modal" >
                         <i class="fas fa-info-circle text-info mx-1"></i>
                         Details 
                     </a>
                     </div>
         </div></div>';
            $result['data'][$key] = array(
                $i,
                $value['date'],
                '<a style="text-decoration:none; color:black;" href="' . base_url($locale) . '/customer/trx_list?cust_code=' . $value['tenant_id'] . '">' . $value['cust_name'] . '</a>',
                '$' . $value['amount'],
                $buttons,
            );
            $i++;
        }
        echo json_encode($result);
    }
    // public function fetch_customers($selected_site)
    public function fetch_customers()
    {
        $customer = new CustomerModel();
        $locale = $this->request->getLocale();

        $result = array('data' => array());

        $branch_id =  (int) session()->get('user')['branch_id'];
        $data = $customer->get_customers($branch_id);
        // $data = $customer->get_customers_based_on_site($selected_site, $branch_id);

        $i = 1;
        foreach ($data as $key => $value) {
            $set = [
                'id' => $value["customer_id"],
                'rec_title' => $value["cust_name"],
                'status' => $value["cust_status"],
                'rec_tbl' => 'tbl_customers',
                'rec_tag_col' => 'cust_status',
                'rec_id_col' => 'customer_id',
            ];
            $buttons = '
                     <div class="ml-auto"><div class="dropdown sub-dropdown"><button class="btn btn-link text-dark" type="button"
                         id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                         <i class="fas fa-ellipsis-v mx-1"></i></button><div class="dropdown-menu dropdown-menu-right" 
                         aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; 
                         top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);
                     ">
                 
                     <a  type="button" id="btn_det" data-customer_id="' . $set["id"] . '"
                           data-cust_name="' . $value["cust_name"] . '" data-identification="' . $value["identification"] . '" 
                           data-sex="' . $value["sex"] . '" data-ref_name="' . $value["ref_name"] . '" 
                           data-cust_tell="' . $value["cust_tell"] . '" data-ref_phone="' . $value["ref_phone"] . '" 
                           data-cust_email="' . $value["cust_email"] . '" 
                           data-balance="' . $value["acc_balance"] . '" 
                         data-bs-target="#form_modal" class="dropdown-item" data-bs-toggle="modal" >
                         <i class="fas fa-info-circle text-info mx-1"></i>
                         Details 
                     </a>
                     
                <a   type="button" id="btn_edit"  data-customer_id="' . $set["id"] . '"
                     data-cust_name="' . $value["cust_name"] . '" data-ref_phone="' . $value["ref_phone"] . '" 
                     data-sex="' . $value["sex"] . '" data-ref_name="' . $value["ref_name"] . '" 
                     data-cust_tell="' . $value["cust_tell"] . '"  data-identification="' . $value["identification"] . '"
                     data-cust_email="' . $value["cust_email"] . '" 
                     data-balance="' . $value["acc_balance"] . '"
                     data-bs-target="#form_modal" class="dropdown-item" data-bs-toggle="modal">
                     <i class="fas fa-pencil-alt text-warning mx-1"></i>Edit  
                     </a>
                     
                     
                     </div>
                     </div></div>';

                     // IN CASE LOO BAAHDO SITE KA UU DAGAN YAHAY CUSTOMER KA
                    //  data-selectedsite="' . $value["site_id"]  . '"
            $result['data'][$key] = array(
                $i,
                '<a href="' . base_url($locale) . '/customer/trx_list?cust_code=' . $value['customer_id'] . '">' . $value['cust_name'] . '</a>',
                $value['cust_tell'],
                $value['cust_email'],
                $value['identification'],
                $value['ref_name'],
                '$' . $value['acc_balance'],
                '$' . $value['total_deposit'],
                $buttons,
            );
            $i++;
        }
        // log_message('debug', print_r($result, true));  // CodeIgniter specific
        echo json_encode($result);
    }

    # Customer Registration
    public function customer_form()
    {
        $customer = new CustomerModel();
        $session = session();

        $name = $this->request->getVar('cust_name');
        $tell = $this->request->getVar('cust_tell');

        if (empty($name))
            $response['alert_inner'] = $this->alert('Enter Name', 'danger');
        else if (empty($tell))
            $response['alert_inner'] = $this->alert('Enter Customer Tell', 'danger');
        else {

            $data = [
                'cust_name' => $name,
                'sex' => $this->request->getVar('sex'),
                'cust_tell' => $tell,
                'cust_email' => $this->request->getVar('cust_email'),
                'identification' => $this->request->getVar('identification'),
                'ref_name' => $this->request->getVar('ref_name'),
                'ref_phone' => $this->request->getVar('ref_phone'),
                'cust_status' => 'Active',
                'branch_id' => $this->request->getVar('branch_id'),
                // 'site_id' => $this->request->getVar('selected_site'),
            ];
            switch ($_POST['form_tag']) {

                case "btn_add":
                    $data['profile_no'] = '';
                    $data['branch_id'] = $session->get('user')['branch_id'];

                    if ($customer->customer_exists($_POST['cust_name'])) {
                        $response['alert_inner'] = $this->alert('This Customer Already Exists', 'danger');
                        echo json_encode($response);
                        exit;
                    }
                    $custid = $customer->store('tbl_customers', $data);

                    $accdata = [
                        'acc_name' => htmlspecialchars($_POST['cust_name']),
                        'acc_name_ar' => htmlspecialchars($_POST['cust_name']),
                        'acc_des' => htmlspecialchars($_POST['cust_name']),
                        'acc_grp_id' => '1',
                        'acc_type_id' => '5',
                        'acc_status' => 'Active',
                        'acc_tag' => $custid,
                        'acc_set' => 'Customer',
                    ];
                    $customer->store('tbl_cl_accounts', $accdata);

                    $response['success'] = true;
                    $response['alert_outer'] = $this->alert('Customer Recorded', 'success');
                    break;

                case "btn_edit":
                    $data = [
                        'customer_id' => $_POST['customer_id'],
                        'cust_name' => $name,
                        'sex' => $this->request->getVar('sex'),
                        'cust_tell' => $tell,
                        'cust_email' => $this->request->getVar('cust_email'),
                        'identification' => $this->request->getVar('identification'),
                        'ref_name' => $this->request->getVar('ref_name'),
                        'ref_phone' => $this->request->getVar('ref_phone'),
                        'cust_status' => 'Active',
                        'branch_id' => (int) session()->get('user')['branch_id'],
                        // 'site_id' => $this->request->getVar('selected_site'),
                    ];

                    $customer->update_table('tbl_customers', $data);
                    $response['success'] = true;
                    $response['alert_outer'] = $this->alert('Customer Updated', 'success');
                    break;
                default:
                    $response['alert_inner'] = $this->alert('Unknown operation', 'danger');
            }
        }

        echo json_encode($response);
    }

    public function trx_list()
    {
        $auth = new AuthModel();
        $customer = new CustomerModel();
        $cid = $_GET['cust_code'];

        $acc_statement = $customer->get_cust_info($cid);
        if ($acc_statement == null) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['title'] = 'Customer Transaction';
        $this->viewData['cust'] = $acc_statement;
        $this->viewData['history'] = $customer->get_cust_history($cid);
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/customer/customer_trx', $this->viewData);
    }

    public function get_customer_bal()
    {
        $customer = new CustomerModel();

        $sid = $this->request->getVar('cid');
        $result = $customer->get_customer_bal($sid);

        echo $result;
    }

    public function get_sites(){
        $rental = new RentalModel();
        $sites = $rental->getAvailableSites();
        $output = '';

        foreach ($sites as $key => $site) {
            $output .= '<option value="'.$site['site_id'].'">'. $site['site_name'].'</option>';
        }

        return $output;
    }

    public function getSite_Based_on_Id($site_id) {
        $customerModel = new CustomerModel();
        $fetchedSite = $customerModel->getsiteFromDB($site_id);
        
        // Check if the result is not empty and contains 'site_name' key
        if (!empty($fetchedSite) && isset($fetchedSite[0]['site_name'])) {
            return $fetchedSite[0]['site_name']; // Return the 'site_name' of the first row
        } else {
            return "unknown site";  // Return a default value if not found
        }
    }
    

}
