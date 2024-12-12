<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

use App\Models\Back\HRModel;
use App\Models\Back\AuthModel;
use App\Models\Back\FinancialModel;

class HRController extends BaseController
{


    /**
     * Employees Functions
     */

    public function employees()
    {
        $auth = new AuthModel();
        $hrmodel = new HRModel();
        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['title'] = lang('Site.hr.employees');
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['jobs'] = $hrmodel->get_table_info('tbl_jobs');
        return view('admin/hr/employees', $this->viewData);
    }

    public function fetch_list()
    {
        $hrmodel = new HRModel();

        $result = array('data' => array());

        $data = $hrmodel->get_employee();
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
                'id' => $value["emp_id"],
                'rec_title' => $value["emp_name"],
                'status' => $value["emp_status"],
                'rec_tbl' => 'tbl_employees',
                'rec_tag_col' => 'emp_status',
                'rec_id_col' => 'emp_id',
            ];

            $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
            $block = ($set["status"] == 'Active') ? '' : 'hidden';

            $stat_icon = $this->stat_icon($set["status"]);

            $buttons = $btn['header'] . '
                        
                           <a type="button" id="btn_edit"  data-emp_id="' . $value["emp_id"] . '"
                                data-emp_name="' . $value["emp_name"] . '" 
                                data-gender="' . $value["gender"] . '" 
                                data-dob="' . $value["dob"] . '" 
                                data-job_id="' . $value["job_id"] . '"
                                data-emp_phone="' . $value["emp_phone"] . '" 
                                data-emp_email="' . $value["emp_email"] . '"  
                                data-date_joining="' . $value["date_joining"] . '"
                                data-old_image="' . $value["image"] . '"
                                data-cat_image="' . $value["image"] . '"
                               data-bs-target="#emp_modal" class="dropdown-item" data-bs-toggle="modal">
                                <i class="fas fa-pencil-alt text-warning mx-1"></i>' . lang('Site.button.edit') . '   
                           </a>

                             <a ' . $act . '  type="button" data-rec_id="' . $set["id"] . '" 
                                data-rec_title="' . $set["rec_title"] . '" data-rec_tag="Active"  data-rec_tbl="' . $set["rec_tbl"] . '"
                                data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#status_modal">
                                <i class="fas fa-check text-success mx-1"></i>Activate 
                            </a>
                            <a ' . $block . '  type="button" data-rec_id="' . $set["id"] . '" 
                                data-rec_title="' . $set["rec_title"]  . '" data-rec_tag="Blocked" data-rec_tbl="' . $set["rec_tbl"] . '"  
                                data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#status_modal">
                                <i class="fas fa-ban text-danger mx-1"></i>Block  
                            </a>
                                            
                             
                    </div>
                    </div>
            </div>';

            $result['data'][$key] = array(
                $i,
                $value['emp_name'],
                $value['emp_phone'],
                $value['job_name'],
                $value['emp_email'],
                $value['date_joining'],
                $stat_icon . ' ' . $value['emp_status'],
                $buttons,
            );
            $i++;
        }
        echo json_encode($result);
    }

    public function stat_icon($status)
    {
        if ($status == 'Active') $stat_icon = '<i class="fas fa-check text-success mx-1"></i>';
        if ($status == 'Pending') $stat_icon = '<i class="fas fa-sync text-warning mx-1"></i>';
        if ($status == 'Recovered') $stat_icon = '<i class="fas fa-sync text-dark mx-1"></i>';
        if ($status == 'Blocked') $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
        if ($status == 'Cancelled') $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
        if ($status == 'Finished') $stat_icon = '<i class="fas fa-ban text-danger mx-1"></i>';
        if ($status != 'Active' && $status != 'Blocked' &&  $status != 'Finished' && $status != 'Pending' &&  $status != 'Cancelled' &&  $status != 'Recovered') $stat_icon = '<i class="fas fa-question text-danger mx-1"></i>';
        return $stat_icon;
    }

    public function block_emp()
    {
        $hrmodel = new HRModel();
        $recid = $this->request->getVar('rec_id');
        $hrmodel->block_emp($recid);
        $response = [
            'success' => true,
            'msg' => lang('Site.state.updated_successfully')
        ];
        echo json_encode($response);
    }
    public function activate_emp()
    {
        $hrmodel = new HRModel();
        $recid = $this->request->getVar('rec_id');
        $hrmodel->activate_emp($recid);
        $response = [
            'success' => true,
            'msg' => lang('Site.state.updated_successfully')
        ];
        echo json_encode($response);
    }
    public function manage_emp()
    {
        $hrmodel = new HRModel();

        $response = ['success' => false];

        switch ($_POST['btn_action']) {

            case "btn_add":
                $data = [
                    'emp_name' => $this->request->getVar('emp_name'),
                    'gender' => $this->request->getVar('gender'),
                    'job_id' => $this->request->getVar('job_id'),
                    'dob' => $this->request->getVar('dob'),
                    'emp_phone' => $this->request->getVar('emp_phone'),
                    'emp_email' => $this->request->getVar('emp_email'),
                    'date_joining' => $this->request->getVar('date_joining'),
                    'emp_status' => 'Active',
                    'branch_id' => session()->get('user')['branch_id'],
                ];
                $hrmodel->store('tbl_employees', $data);
                $response['success'] = true;
                $response['message'] = lang('Site.state.added_successfully');
                break;
            case "btn_edit":
                $data = [
                    'emp_id' => $_POST['emp_id'],
                    'emp_name' => $this->request->getVar('emp_name'),
                    'gender' => $this->request->getVar('gender'),
                    'job_id' => $this->request->getVar('job_id'),
                    'dob' => $this->request->getVar('dob'),
                    'emp_phone' => $this->request->getVar('emp_phone'),
                    'emp_email' => $this->request->getVar('emp_email'),
                    'date_joining' => $this->request->getVar('date_joining'),
                ];

                $hrmodel->update_emp($data);
                $response['success'] = true;
                $response['message'] = lang('Site.state.updated_successfully');
                break;
            case "btn_del":
                $data = ['acc_status' => 'Deleted',];
                $hrmodel->del_acc($_POST['account_id']);
                $response['success'] = true;
                $response['message'] = lang('Site.state.deleted_successfully');
                break;
            default:
                $response['message'] = lang('Site.state.error_occured');
        }


        echo json_encode($response);
    }

    /**
     * End of Employees Functions
     */
    /**
     * Jobs Functions
     */

    public function jobs()
    {
        $auth = new AuthModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['title'] = lang('Site.hr.jobs');
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/hr/jobs', $this->viewData);
    }

    public function fetch_job()
    {
        $hrmodel = new HRModel();
        $result = array('data' => array());

        $data = $hrmodel->get_table_info('tbl_jobs');
        $i = 1;
        foreach ($data as $key => $value) {
            $job = $this->viewData['locale'] == 'ar' ? $value["job_name_ar"] : $value["job_name"];
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
                'id' => $value["job_id"],
                'rec_title' => $value["job_name"],
                'status' => $value["job_status"],
                'job_salary' => $value["job_salary"],
                'rec_tbl' => 'tbl_jobs',
                'rec_tag_col' => 'job_status',
                'rec_id_col' => 'job_id',
            ];

            $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
            $block = ($set["status"] == 'Active') ? '' : 'hidden';

            $buttons = $btn['header'] . '
            
                           <a type="button" id="btn_edit"  
                                data-job_id="' . $value["job_id"] . '"
                                data-job_name="' . $value["job_name"] . '" 
                                 data-job_salary="' . $value["job_salary"] . '"
                                data-bs-target="#job_modal" class="dropdown-item" data-bs-toggle="modal">
                                <i class="fas fa-pencil-alt text-warning mx-1"></i>' . lang('Site.button.edit') . '   
                           </a>
                    </div>
                    </div>
            </div>';

            $result['data'][$key] = array(
                $i,
                $job,
                '$' . $value['job_salary'],
                $buttons,
            );
            $i++;
        } // /foreach
        echo json_encode($result);
    }

    public function manage_job()
    {
        $hrmodel = new HRModel();
        $response = array();
        $response['success'] = false;

        if ($_POST['btn_action'] == 'btn_add') {

            $data = [
                'job_name' => $this->request->getVar('job_name_en'),
                'job_salary' => $this->request->getVar('job_salary'),
                'Job_status' => 'Active'
            ];

            $response['success'] = $hrmodel->store('tbl_jobs', $data);
            $response['msg'] = lang('added successfully');
        } else if ($_POST['btn_action'] == 'btn_edit') {

            $data = [
                'job_id' => $_POST['job_id'],
                'job_name' => $this->request->getVar('job_name_en'),
                'job_salary' => $this->request->getVar('job_salary'),
            ];

            $response['success'] = $hrmodel->update_job($data);
            $response['msg'] = lang('updated successfully');
        }

        echo json_encode($response);
    }

    /**
     * End of Jobs Functions
     */

    /**
     * Payroll Functions
     */
    public function payroll()
    {
        $auth = new AuthModel();
        $hrmodel = new HRModel();

        if (!$this->page_authorized(
            $this->request->uri->getSegment(2),
            $this->request->uri->getSegment(3)
        )) {
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['title'] = lang('Site.hr.payroll');
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['employees'] = $hrmodel->get_employee();
        $this->viewData['jobs'] = $hrmodel->get_table_info('tbl_jobs');
        $this->viewData['accounts'] = $hrmodel->get_cash_bank_accounts();
        $this->viewData['exp_accounts'] = $hrmodel->get_expense_accounts();

        return view('admin/hr/payroll', $this->viewData);
    }
    public function fetch_salary()
    {
        $hrmodel = new HRModel();
        $result = array('data' => array());
        $data = $hrmodel->get_salary_data();
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
                'id' => $value["salary_id"],
                'rec_title' => $value["salary_id"],
                'status' => $value["salary_status"],
                'rec_tbl' => 'tbl_salary',
                'rec_tag_col' => 'salary_status',
                'rec_id_col' => 'salary_id',
            ];

            $buttons = $btn['header'] . '
                            <a type="button" id="btn_edit" data-salary_id="' . $value["salary_id"] . '"
                                data-emp_id="' . $value["emp_id"] . '" data-job_id="' . $value["job_id"] . '"
                                data-comm="' . $value["comm"] . '" data-deduction="' . $value["deduction"] . '"
                                data-net_pay="' . $value["net_pay"] . '" data-month="' . $value["month"] . '"
                                data-payment_date="' . $value["payment_date"] . '" data-account_id="' . $value["account_id"] . '"
                                data-bs-target="#salary_modal" class="dropdown-item" data-bs-toggle="modal" >
                                <i class="fas fa-pencil-alt text-info mx-1"></i> ' . lang('Site.button.edit') . ' 
                            </a>
                                            
                      </div>
                    </div>
            </div>';

            $result['data'][$key] = array(
                $i,
                $value['emp_name'],
                $value['job_name'],
                '$' . $value['comm'],
                '$' . $value['deduction'],
                '$' . $value['net_pay'],
                $value['month'],
                $value['acc_name'],
                $value['payment_date'],
                $buttons,
            );
            $i++;
        } // /foreach
        echo json_encode($result);
    }

    public function get_base_salary()
    {
        $hrmodel = new HRModel();
        $emp_id = $this->request->getVar('emp_id');
        $salary = $hrmodel->get_base_salary($emp_id);
        $result = [
            'job_name' => $salary->job_name,
            'job_salary' => $salary->job_salary,
        ];
        echo json_encode($result);
    }

    public function manage_salary()
    {
        $hrmodel = new HRModel();
        $response = array();
        $response['success'] = false;

       
        if ($_POST['btn_action'] == 'btn_add') {
            $cb_acc = $this->request->getVar('account_id');
            $date = $this->request->getVar('payment_date');

            ## record transaction ##
            $trid = $this->record_transactions('Salary', $this->request->getVar('net_pay'), $cb_acc, $date);

            $data = [
                'emp_id' => $this->request->getVar('emp_id'),
                'comm' => $this->request->getVar('comm'),
                'deduction' => $this->request->getVar('deduction'),
                'net_pay' => $this->request->getVar('net_pay'),
                'month' => $this->request->getVar('month'),
                'account_id' => $cb_acc,
                'salary_status' => 'Active',
                'payment_date' => $this->request->getVar('payment_date'),
                'trx_id' => $trid,
            ];

            $response['success'] = $hrmodel->store('tbl_salary', $data);
            $response['msg'] = lang('Site.state.added_successfully');
        
        } 
        else if ($_POST['btn_action'] == 'btn_edit') {

            ## delete transaction ##
            $old_trx = $this->request->getVar('old_trx_id');
            $amount = $this->request->getVar('old_amount');

            $hrmodel->undo_transaction($old_trx, $amount);

            ## record transaction ##
            $cb_acc = $this->request->getVar('account_id');
            $date = $this->request->getVar('payment_date');
            $trid = $this->record_transactions('Salary', $amount, $cb_acc, $date);

            $data = [
                'emp_id' => $this->request->getVar('emp_id'),
                'salary_id' => $this->request->getVar('salary_id'),
                'comm' => $this->request->getVar('comm'),
                'deduction' => $this->request->getVar('deduction'),
                'net_pay' => $this->request->getVar('net_pay'),
                'month' => $this->request->getVar('month'),
                'account_id' => $this->request->getVar('account_id'),
                'salary_status' => 'Active',
                'payment_date' => $this->request->getVar('payment_date'),
                'trx_id' => $trid,
            ];

            $response['success'] = $hrmodel->update_salary($data);
            $response['msg'] = lang('Site.state.updated_successfully');
        }

        echo json_encode($response);
    }

    public function record_transactions($source, $amount, $cb_acc, $date)
    {
        $finmodel = new FinancialModel();
        $fpid = $finmodel->financial_period()['fp_id'];

        $trx_id = $finmodel->record_trx($amount, $source, $fpid, $date);

        $dracc = $finmodel->get_account_tag('Payroll')['account_id'];;
        $cracc = $cb_acc;

        $finmodel->cr_trx_det((float) $amount, $cracc, $trx_id);
        $finmodel->update_accounnt_balance($cracc, -$amount);

        $finmodel->dr_trx_det((float) $amount, $dracc, $trx_id);
        $finmodel->update_accounnt_balance($dracc, $amount);

        return $trx_id;
    }

    /**
     * End of Payroll Functions
     */


    public function up_img($folder, $image)  // uploads images for apartment 
    {

        $target_folder = 'public/assets/images/' . $folder . '/' . $_FILES[$image]['name'];
        move_uploaded_file($_FILES[$image]['tmp_name'], $target_folder);
        return $_FILES[$image]['name'] == "" ? 'sample.jpg' : $_FILES[$image]['name'];
    }
}
