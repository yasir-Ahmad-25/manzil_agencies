<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\DashboardModel;
use App\Models\Back\FinancialModel;
use App\Models\Back\OwnerModel;
use App\Models\Back\PaymentModel;

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
        
        $branch_id = (int) session()->get('user')['branch_id'];
        
        $data = $owner->get_owners_data('tbl_owners', 'owner_id' , null , $branch_id);

        $i = 1;
        foreach ($data as $key => $value) {

            $set = [
                'id' => $value["owner_id"],
                'rec_title' => $value["fullname"],
                'status' => $value["status"],
                'rec_tbl' => 'tbl_owners',
                // 'rec_tag_col' => 'status',
                'rec_id_col' => 'owner_id',
            ];

            $stat_icon = $this->stat_icon($set["status"]);

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">

                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                    <a type="button" id="btn_view" 
                                    data-owner_id="' . $value["owner_id"] . '"
                                    data-ownerfullname="' . $value["fullname"] .' "
                                    data-ownerphone="' . $value["phone"] .'"
                                    data-owneremail="' . $value["email"] . '" 
                                    data-ownertype="' . $value["owner_type"] . '"
                                    data-ownercompanyname="' . $value["companyName"] . '"
                                    data-owner_account_number="' . $value["AccountNumber"] . '"

                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ownermodel">
                        <i class="fas fa-info-circle text-info mx-1"></i> View </a>

                   <a type="button" id="btn_edit"  
                                    data-owner_id="' . $value["owner_id"] . '"
                                    data-ownerfullname="' . $value["fullname"] .' "
                                    data-ownerphone="' . $value["phone"] .'"
                                    data-owneremail="' . $value["email"] . '" 
                                    data-ownertype="' . $value["owner_type"] . '"
                                    data-ownercompanyname="' . $value["companyName"] . '"
                                    data-owner_account_number="' . $value["AccountNumber"] . '"
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ownermodel">
                        <i class="fas fa-pencil-alt text-warning mx-1"></i> Edit </a>
                    
                   ';


                   if($value['status'] == "Active"){
                    $buttons .= 
                     '<a type="button" id="btn_de_activate"
                        data-owner_id="' . $value["owner_id"] . '"
                        data-ownerfullname="' . $value["fullname"] .' "
                        data-ownerphone="' . $value["phone"] .'"
                        data-owneremail="' . $value["email"] . '" 
                        data-ownertype="' . $value["owner_type"] . '"
                        data-ownercompanyname="' . $value["companyName"] . '"
                        data-owner_account_number="' . $value["AccountNumber"] . '"

                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ownermodel">
                        <i class="fa fa-trash text-danger mx-1"></i>  De-Activate </a>
                        </div>
                        </div>
                </div>';
            }else{
                $buttons .= 
                       '<a type="button" id="btn_Activate"
                                    data-owner_id="' . $value["owner_id"] . '"
                                    data-ownerfullname="' . $value["fullname"] .' "
                                    data-ownerphone="' . $value["phone"] .'"
                                    data-owneremail="' . $value["email"] . '" 
                                    data-ownertype="' . $value["owner_type"] . '"
                                    data-ownercompanyname="' . $value["companyName"] . '"
                                    data-owner_account_number="' . $value["AccountNumber"] . '"

                          class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ownermodel">
                          <i class="fa fa-check text-success mx-1"></i>  Activate </a>
                          </div>
                          </div>
                  </div>';

                   }

            
            $result['data'][$key] = array(
                $i,
                $value['fullname'],
                $value['phone'],
                $value['email'],
                $value['owner_type'],
                $value['companyName'] == "" ? "personal" : $value['companyName'],
                $stat_icon . ' ' . $value['status'],
                $buttons,
            );

            // $this->display(  $this->Property_model->get_num_floors($value['site_name']).' Floors');
            $i++;
        } // /foreach

        echo json_encode($result);
    }
    public function crud_owners()
    {
        $owner = new OwnerModel();
        $finmodel = new FinancialModel();
       

        
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
                } else if(!$_POST['Account_Number']){

                    $response['alert_inner'] = $this->alert('please Provide Account Number', 'danger');
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
                    'AccountNumber' => $_POST['Account_Number'],
                    'branch_id' => session()->get('user')['branch_id'],
                    'status' => 'Active',
                ];
                $owner_id = $owner->store('tbl_owners', $data);
                // create new account for this owner
                $acc_data = [
                    // acc_name  , acc_name_ar , acc_balance , acc_tag , acc_des , acc_status , acc_set
                    'acc_name' => htmlspecialchars($_POST['fullname']),
                    'acc_name_ar' => htmlspecialchars($_POST['fullname']),
                    'acc_des' => 'THIS ACCOUNT BELONGS TO '.$_POST['fullname'],
                    'acc_grp_id' => 2,
                    'acc_type_id' => 3,
                    'acc_status' => 'Active',
                    'acc_tag' => $owner_id,
                    'acc_set' => 'OWNER'
                ];
                $finmodel->store('tbl_cl_accounts', $acc_data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Owner Has Been Added', 'success');

        } else if ($_POST['btn_action'] == "btn_edit") { // SAVE THE UPDATED DATA

                // collect the updated  Data
                $data = [
                    'owner_id' => $_POST['owner_id'],
                    'fullname' => $_POST['fullname'],
                    'phone' => $_POST['Phone'],
                    'email' => $_POST['Email'],
                    'owner_type' => $_POST['OwnerType'],
                    'companyName' => $_POST['OwnerType'] !== "individual" ? $_POST['companyName'] : "",
                    'AccountNumber' => $_POST['Account_Number'],
                ];
                $owner->update_table('tbl_owners', $data);
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Owner Has Been Updated.', 'success');
        } else if ($_POST['btn_action'] == "btn_de_activate") { // DE-ACTIVATES SITE OR BUILDING
                
            $data = [
                'owner_id' => $_POST['owner_id'],
                'status' => 'De-Active'
            ];
            
            $owner->update_table('tbl_owners', $data);
            $response['success'] = true;
            $response['alert_outer'] = $this->alert('Owner Has Been De-Activated Successfully.', 'success');
            
        } else if ($_POST['btn_action'] == "btn_Activate") { // ACTIVATES SITE OR BUILDING
            
            $data = [
                'owner_id' => $_POST['owner_id'],
                'status' => 'Active'
            ];
            
            $owner->update_table('tbl_owners', $data);
            $response['success'] = true;
            $response['alert_outer'] = $this->alert('Owner Has Been Activated Successfully.', 'success');
    } 


        echo json_encode($response);
    }

    
    
    // ============================================================== OWNERS SETTLEMENT ======================================================
    
    // SETTLEMENT PAGE FUNCTION
    public function Owner_Payout(){
        $auth = new AuthModel();
        $dashoard = new DashboardModel();
        $payment = new PaymentModel();

        $this->viewData['site_owners'] = $this->getOwners();
        $this->viewData['accounts'] = $payment->get_cash_bank_accounts();
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/owner/payout', $this->viewData);
    }

    // THIS FUNCTOIN FETCHES THE TABLE
    public function fetch_owners_settlement(){
        $owner = new OwnerModel();
        $result = array('data' => array());
        
        $branch_id = (int) session()->get('user')['branch_id'];
        
        $data = $owner->get_owners_settlement_data($branch_id);

        $i = 1;
        foreach ($data as $key => $value) {

            $set = [
                'id' => $value["owner_id"],
                'rec_title' => $value["fullname"],
                'status' => $value["status"],
                'rec_tbl' => 'tbl_owners',
                // 'rec_tag_col' => 'status',
                'rec_id_col' => 'owner_id',
            ];

            $stat_icon = $this->stat_icon($set["status"]);

            $button = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">

                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                
                   <a type="button" id="btn_view"  
                                    data-owner_id="' . $value["owner_id"] . '"
                                    data-owner_fullname="' . $value["fullname"] .' "
                                    data-owner_paid_date="' . $value["paid_date"] .' "
                                    data-owner_account_number="' . $value["AccountNumber"] . '"

                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#owner_paid_model">
                        <i class="fas fa-pay text-warning mx-1"></i> Pay </a>
                    
                   ';
            
            $paid_date = new \DateTime($value['paid_date']);
            $paid_date_format = $paid_date->format('Y-m-d');

            $result['data'][$key] = array(
                $i,
                $value['fullname'],
                $value['AccountNumber'],
                '$ '.$value['paid_amount'],
                $value['acc_name'],
                $value['paid_date'],
                // $paid_date_format,
            );

            // $this->display(  $this->Property_model->get_num_floors($value['site_name']).' Floors');
            $i++;
        } // /foreach

        echo json_encode($result);
    }

    public function owner_settlement(){
        $owner = new OwnerModel();
        $finmodel = new FinancialModel();
        $response = array();
        $response['success'] = false;
        if (empty($_POST['selectedOwner'])) {
            $response['alert_inner'] = $this->alert('choose one of the available owners first', 'danger');
        } else if ($_POST['btn_action'] == "btn_pay"){  
            // SAVE DATA TO DB = tbl_owner_settlement

            // Added some validations
            if(!$_POST['Paying_Amount'] && $_POST['Paying_Amount'] <= 0){

                $response['alert_inner'] = $this->alert('please provide the amount you are paying', 'danger');
                echo json_encode($response);
                exit();
            }

            // fetch this owner balance
            $owner_balance = $_POST['total_amount'];
            $Amount_Agency_Paying = $_POST['Paying_Amount'];


            // compare the balance and the amount is agency is going to paid
            if($Amount_Agency_Paying > $owner_balance){
                $response['alert_inner'] = $this->alert('you are paying in sufficient amount', 'danger');
                echo json_encode($response);
                exit();
            }

            // fiiri account ka uu lacagta kasoo bixinaayo agency ga balance sigiisa maka yaryahay inta laga bixin rabo 
            $agency_selected_Account_Balance = $finmodel->getAgency_Balance($_POST['acc_tag_rec']);

            // agency = $0
            // owner = $550
            // For Example: if agency < owner ? insufficient fund : proceed
            if($agency_selected_Account_Balance < $Amount_Agency_Paying){
                $response['alert_inner'] = $this->alert('you don\'t have that amount you are paying', 'danger');
                echo json_encode($response);
                exit();
            }

            // collect posted data
            $data = [
                'owner_id' => $_POST['selectedOwner'],
                'paid_amount' => $_POST['Paying_Amount'],
                'branch_id' => session()->get('user')['branch_id'],
                'acc_type_id' => $_POST['acc_tag_rec'],
            ];

            
            $owner_settled = $owner->create_owner_settlement($data, $_POST['acc_tag_rec']);
          
            if ($owner_settled) {
                
                $response['success'] = true;
                $response['alert_outer'] = $this->alert('Owner settled successfully', 'success');
            } else {
                $response['alert_inner'] = $this->alert('Owner setlement Failed', 'danger');
            }


        }
        
    }

    public function getOwners(){
        $owner = new OwnerModel();
        $sites = $owner->getsiteOwnerFrom_accounts();
        $output = '';

        if($sites){
            foreach ($sites as $key => $site) {
                $output .= '<option value="'.$site['owner_id'].'">'. $site['fullname'].'</option>';
            }
        }else{
            $output .= '<option value="NONE" disabled> THERE\'S NO OWNER CURRENTLY</option>';
        }

        return $output;
    }

    public function get_Balance_And_Account(){
        $owner = new OwnerModel();
        $financeModel = new FinancialModel();
        $owner_id = $_POST['owner_id'];


        // Call the model methods
        $AccountNumber = $owner->get_accountNumber($owner_id);
        $balance = $financeModel->get_owner_Balance($owner_id);
        
        // Prepare the response array
        $response = array(
            'amount' => $balance,
            'accountNumber' => $AccountNumber
        );
        
        // Return the response as JSON
        return json_encode($response);
    }
}