<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

use App\Models\Back\FinancialModel;
use App\Models\Back\AuthModel;
use App\Models\Back\ticket_model;

class FinancialController extends BaseController
{


    public function chart_accounts()
    {
        $auth = new AuthModel();

        $this->viewData['title'] = lang('Site.financial.chaccounts');
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/financial/chaccounts', $this->viewData);
    }
    
    public function payment_voucher()
    {
        $auth = new AuthModel();
        $finmodel = new FinancialModel();

        $this->viewData['title'] = "Payment Voucher";
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['allacc'] = $finmodel->get_cl_all_accounts();
        $this->viewData['bank_accounts'] = $finmodel->get_bank_accounts();
        $this->viewData['other_accounts'] = $finmodel->get_other_accounts();
        return view('admin/financial/payment_voucher', $this->viewData);
    }

    # VOURCHERS #
    public function receipt_voucher()
    {
        $auth = new AuthModel();
        $finmodel = new FinancialModel();


        $this->viewData['title'] = "Receipt Voucher";
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['accounts'] = $finmodel->get_other_accounts();
        $this->viewData['cash_accounts'] = $finmodel->get_bank_accounts();

        return view('admin/financial/receipt_voucher', $this->viewData);
    }

    public function get_acc_nature($id)
    {
        $db = \Config\Database::connect();
        $account = $db->query("SELECT acc_grp_nature FROM tbl_cl_accounts acc 
                JOIN tbl_cl_account_groups grp ON grp.acc_grp_id=acc.acc_grp_id
                WHERE acc.account_id='$id'");
        return $account->getRow()->acc_grp_nature;
    }


    public function record_vouchers()
    {
        $db = \Config\Database::connect();
        $session = session();
        $refnum = $this->request->getVar('refnum');
        $paid_f = $this->request->getVar('paid_from');
        $p_amount = $this->request->getVar('amount');
        $paid_to = $this->request->getVar('paid_to');
        $descr = $this->request->getVar('des');
        $source = $this->request->getVar('voucher_type');

        // Validate input data
        $validationRules = [
            'refnum' => 'required',
            'paid_from' => 'required',
            'amount' => 'required|numeric',
            'paid_to' => 'required',
            'des' => 'required',
            'voucher_type' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            // Validation failed, return error response
            $response['status'] = FALSE;
            $response['message'] = 'Fill All FIELDS';
            return $this->response->setJSON($response);
        }

        //$usermodel = new ticket_model();
        $finmodel = new FinancialModel();

        $fp_id1 = $this->getActivePeriod()->fp_id;

        $user_data = [
            'paid_from' => $paid_f,
            'amount' => $p_amount,
            'paid_to' => $paid_to,
            'refnum' => $refnum,
            'des' => $descr,
            'voucher_status' => $this->request->getVar('voucher_status'),
            'staff' => $session->get('user')['fullname'],
            'date' => $this->request->getVar('date'),
            'voucher_type' => $source,
            'branch_id' => session()->get('user')['branch_id'],
            'staff' => session()->get('user')['fullname'],
        ];

        $finmodel->store('vouchers', $user_data);
        $this->record_transactions($source, $p_amount, $refnum, $user_data['date']);

        $response['status'] = TRUE;
        $response['message'] = 'Voucher Added';
        return $this->response->setJSON($response);
    }

    public function getActivePeriod()
    {
        $finmodel = new FinancialModel();
        $session = session();

        return $finmodel->query("SELECT * FROM tbl_cl_financial_period WHERE fp_status = 'Active' limit 1")->getRow();
    }

    public function record_transactions($source, $amount, $refnum, $date)
    {
        $descr = $this->request->getPost('des');
        $finmodel = new FinancialModel();

        $trx_id = $finmodel->record_trans($amount, $source, $this->getActivePeriod()->fp_id, $date, '', $descr);

        if ($source == "PaymentVoucher") {

            $cracc = $_POST['paid_from']; # cash account
            $finmodel->trx_det('cr', $amount, $cracc, $trx_id, $descr); # credit
            $finmodel->update_account_balance($cracc, -$amount);

            $dracc = $_POST['paid_to']; # other account
            // echo $dracc;
            // exit;
            $finmodel->trx_det('dr', $amount, $dracc, $trx_id, $descr); # debit

            if ($this->get_acc_nature($dracc) == 'cr')
                $amount = - ($amount);

            $finmodel->update_account_balance($dracc, $amount);
        } else {

            $dracc = $_POST['paid_to']; # cash account
            $finmodel->trx_det('dr', $amount, $dracc, $trx_id, $descr); # debit
            $finmodel->update_account_balance($dracc, $amount);

            $cracc = $_POST['paid_from']; # cash account
            $finmodel->trx_det('cr', $amount, $cracc, $trx_id, $descr); # credit

            if ($this->get_acc_nature($cracc) == 'dr')
                $amount = - ($amount);

            $finmodel->update_account_balance($cracc, $amount);
        }
    }


 
    public function get_ledger($id)
    {
        $Financial_model = new FinancialModel();

        $sdate = $this->request->getVar('startdate');

        $edate = $this->request->getVar('enddate');
        if ($sdate == "")
            $history = $Financial_model->get_acc_history($id);
        else
            $history = $Financial_model->get_acc_history_date($id, $sdate, $edate);

        $table = '<table id="manageTable" class="table table-striped table-bordered display no-wrap">
        <thead class="bg-info text-white">
            <tr>
                <th>' . lang('Site.common.date') . ' </th>
                <th>' . lang('Site.financial.source') . ' </th>
                <th>' . lang('Site.common.remarks') . ' </th>
                <th>' . lang('Site.financial.debit') . '  </th>
                <th>' . lang('Site.financial.credit') . ' </th>
                <th>Balance </th>
            </tr>

            </tr>
        </thead>
        <tbody>';

        $i = 1;
        $totalCr = 0; // total depit
        $totalDr = 0; // total credit
        $bal = 0;
        $ttl = 0;
        $nature = $Financial_model->get_accgrp_nature($id);

        foreach ($history as $val) {
            $debit = $val['dr_amount'] == 0 ? "" : '$' . $val['dr_amount'];
            $credit = $val['cr_amount'] == 0 ? "" : '$' . $val['cr_amount'];
            $totalDr += $val['dr_amount'];
            $totalCr += $val['cr_amount'];

            $bal = $nature == "dr" ? ($val['dr_amount'] + $bal) - $val['cr_amount'] : ($val['cr_amount'] + $bal) - $val['dr_amount'];

            $table .= '<tr>
                    <td>' . date("d/m/Y H:i", strtotime($val['trx_date'])) . '</td>
                    <td>' . strtoupper($val['trx_source']) . '</td>
                    <td>' . $val['trx_des'] . '</td>
                    <td>' . $debit . '</td>
                    <td>' . $credit . '</td>
                    <td>$' . number_format($bal,2) . '</td>
                </tr>';
        }

        $ttl = $nature == "dr" ? $totalDr - $totalCr : $totalCr - $totalDr;

        $table .= '<tr>
                <td colspan="3"><b>Total </b></td>
                <td> <b>$' . number_format($totalDr, 2) . '</b></td>
                <td> <b>$' . number_format($totalCr, 2) . '</b></td>
                <td> <b>$' . number_format($ttl, 2) . '</b></td>
            </tr>
        </tbody>

        </table>';

        echo $table;
    }
    public function acchistory($id)
    {
        $auth = new AuthModel();
        $finance = new FinancialModel();
        helper('url');

        $acc_statement = $finance->get_acc_info($id);
        if($acc_statement == null){
            return view('admin/page_404', $this->viewData);
            exit;
        }

        $this->viewData['account'] =  $acc_statement;
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['accid'] = $id;
        return view('admin/financial/acchistory', $this->viewData);
    }

    public function fetch_accounts()
    {
        // $usermodel = new UserModel();
        $finmodel = new FinancialModel();
        $result = array();
        $account_groups = $finmodel->get_account_groups();
        $locale = $this->request->getLocale();
        $res = '<ul class="nav nav-tabs" id="myTab" role="tablist">';
        $i = 0;
        foreach ($account_groups as $acc_group) :
            $retVal = ($i < 1) ? 'active' : '';
            $retVal2 = ($i < 1) ? 'true' : 'false';
            $grpname = $locale == 'ar' ? $acc_group['acc_grp_name_ar'] : $acc_group['acc_grp_name'];
            $res .= '           <li class="nav-item">
                                <a class="nav-link ' . $retVal . '" id="home-tab" data-bs-toggle="tab" href="#_' . $acc_group['acc_grp_id'] . '" role="tab" aria-selected="' . $retVal2 . '">
                                    ' . $grpname . '
                                    <span class="badge bg-info text-white">' . $finmodel->no_cl_account_types($acc_group['acc_grp_id']) . '</span>
                                </a>
                            </li>';
            $i++;
        endforeach;
        $res .= '   </ul>
                    <div class="tab-content" id="myTabContent">';
        $i = 0;
        foreach ($account_groups as $acc_group) :
            $grpname = $locale == 'ar' ? $acc_group['acc_grp_name_ar'] : $acc_group['acc_grp_name'];
            $retVal = ($i < 1) ? 'active show' : '';
            $res .= '           <div class="tab-pane fade ' . $retVal . ' " id="_' . $acc_group['acc_grp_id'] . '" role="tabpanel" aria-labelledby="t1-tab">
                                <h3 class="p-2">' . $grpname . '</h3>
                                <hr>
                                <div id="accordion">';
            $i = 0;
            foreach ($finmodel->get_cl_account_types($acc_group['acc_grp_id']) as $account_type) :
                $typename = $locale == 'ar' ? $account_type['acc_type_name_ar'] : $account_type['acc_type_name'];
                $res .= '                           <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0 row">
                                                    <div class="col-md-9">
                                                        <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#' . $account_type['acc_type_id'] . '" aria-expanded="true" aria-controls="' . $account_type['acc_type_id'] . '">
                                                            ' . $typename . '
                                                            <span class="badge bg-primary text-white">' . $finmodel->no_cl_accounts($account_type['acc_type_id']) . '</span>
                                                        </button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button class="btn  text-dark" data-bs-toggle="collapse" data-bs-target="#' . $account_type['acc_type_id'] . '" aria-expanded="true" aria-controls="' . $account_type['acc_type_id'] . '">
                                                            ' . '$ ' . $finmodel->sum_cl_account_types($account_type['acc_type_id']) . '
                                                        </button>
                                                    </div>

                                                </h5>
                                            </div>

                                            <div id="' . $account_type['acc_type_id'] . '" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body row">';
                $i = 0;
                foreach ($finmodel->get_cl_accounts_by_type($account_type['acc_type_id']) as $accounts) :
                    $accname = $locale == 'ar' ? $accounts['acc_name_ar'] : $accounts['acc_name'];

                    $res .= '<div class="col-md-4 my-1"><a href="' . base_url($locale) . '/financial/acchistory/' . $accounts['account_id'] . ' ">' . $accname . '</a></div>
                                                        <div class="col-md-5 my-1">' . $accounts['acc_des'] . '</div>
                                                        <div class="col-md-2 my-1">$ ' . $accounts['acc_balance'] . '</div>
                                                        <div class="col-md-1 my-1">
                                                            <div class="ml-auto">
                                                                <div class="dropdown sub-dropdown">
                                                                    <button class="btn btn-link text-dark " type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                        <i class="fas fa-ellipsis-v mx-1"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">

                                                                        <a type="button" class="dropdown-item" id="btn_edit" data-account_id="' . $accounts['account_id'] . '" data-acc_name="' . $accounts['acc_name'] . '" data-acc_name_ar="' . $accounts['acc_name_ar'] . '" data-acc_des="' . $accounts['acc_des'] . '" data-bs-toggle="modal" data-bs-target="#form_modal">
                                                                            <i class="fas fa-edit text-warning mx-1"></i>' . lang('Site.button.edit') . '
                                                                        </a>

                                                                        <a type="button" class="dropdown-item" id="btn_del" data-account_id="' . $accounts['account_id'] . '" data-acc_name="' . $accounts['acc_name'] . '"  data-acc_des="' . $accounts['acc_des'] . '" data-acc_balance="' . $accounts['acc_balance'] . '" data-bs-toggle="modal" data-bs-target="#form_modal">
                                                                            <i class="fas fa-trash-alt text-danger mx-1"></i>' . lang('Site.button.delete') . '
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>';
                    $i++;
                endforeach;

                $res .= '                                       <div class="col-md-12">
                                                        <hr>
                                                        <button class="btn btn-link " id="btn_add" data-acc_grp_id="' . $acc_group['acc_grp_id'] . '" data-acc_grp_name="' . $acc_group['acc_grp_name'] . '" data-acc_type_id="' . $account_type['acc_type_id'] . '" data-acc_type_name="' . $typename . '" id="addrole" data-bs-toggle="modal" data-bs-target="#form_modal">
                                                            <i class="fas fa-plus-circle mx-1"></i> ' . lang('Site.financial.newacc') . '
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                $i++;
            endforeach;
            $res .= '                                </div>

                            </div>';
            $i++;
        endforeach;

        $res .= '               </div>


        ';

        $result['data'] = $res;

        // echo json_encode($result);
        echo ($res);
    }

    public function manage_account()
    {
        $finmodel = new FinancialModel();

        $response = ['success' => false];

        switch ($_POST['form_tag']) {

            case "btn_add":
                //$accid1 =  $finmodel->get_tag(htmlspecialchars($_POST['acc_type_id']));

                if (empty($_POST['acc_name'])) {
                    $response['success'] = false;
                    $response['message'] = 'Please, account name is required';
                    echo json_encode($response);
                    exit;
                }
                $data = [
                    'acc_name' => htmlspecialchars($_POST['acc_name']),
                    'acc_name_ar' => htmlspecialchars($_POST['acc_name_ar']),
                    'acc_des' => htmlspecialchars($_POST['acc_des']),
                    'acc_grp_id' => htmlspecialchars($_POST['acc_grp_id']),
                    'acc_type_id' => htmlspecialchars($_POST['acc_type_id']),
                    'acc_status' => 'Active',
                    'acc_tag' => htmlspecialchars($_POST['acc_name']),
                ];
                $finmodel->store('tbl_cl_accounts', $data);
                $response['success'] = true;
                $response['message'] = lang('Site.state.added_successfully');

            case "btn_edit":
                $data = [
                    'acc_name' => htmlspecialchars($_POST['acc_name']),
                    'acc_name_ar' => htmlspecialchars($_POST['acc_name_ar']),
                    'acc_des' => htmlspecialchars($_POST['acc_des']),
                ];
                $finmodel->update_acc($_POST['account_id'], $data);
                $response['success'] = true;
                $response['message'] = lang('Site.state.updated_successfully');
                break;
            case "btn_del":
                $data = ['acc_status' => 'Deleted',];
                $deleted = $finmodel->del_acc($_POST['account_id']);
                if ($deleted) {
                    $response['success'] = true;
                    $response['message'] = lang('Site.state.deleted_successfully');
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to delete this active account';
                }
                break;
            default:
                $response['message'] = lang('Site.state.error_occured');
        }


        echo json_encode($response);
    }



    /**
     * Financial Period
     */
    public function finperiod()
    {
        $auth = new AuthModel();
        $finmodel = new FinancialModel();

        

        $this->viewData['title'] = lang('Site.financial.finperiod');
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['inc_exps'] = $finmodel->get_inc_exp_total();

        $this->viewData['fp'] = $finmodel->fp_started();
        if ($this->viewData['fp'] == true) {
            $this->viewData['finfo'] = $finmodel->fp_info();
        }
        return view('admin/financial/fin_period', $this->viewData);
    }

    public function start_fin_period()
    {
        $finmodel = new FinancialModel();
        $response = $finmodel->fp_initiate();
        return redirect()->to(base_url($this->viewData['locale']) . '/financial/finperiod');
    }

    public function end_fin_period()
    {
        $finmodel = new FinancialModel();
        $finmodel->fp_end();
        echo 'financial period closed, and new period initiated';
    }
    /**
     * End of Financial Period
     */

    public function journal_entry()
    {
        $auth = new AuthModel();
        $finmodel = new FinancialModel();

        

        $this->viewData['title'] = lang('Site.financial.journal');
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['allacc'] = $finmodel->get_cl_all_accounts();
        return view('admin/financial/journal_entry', $this->viewData);
    }

    public function journal_entry_posting()
    {
        $auth = new AuthModel();
        $finmodel = new FinancialModel();
        // $this->display($_POST);
        $response = ['success' => false];
        // Validate input
        if (count($_POST['dr_account_id']) != count($_POST['dr_amount'])) $response['msg'] = ('Error in Debited Accounts');
        else if (count($_POST['dr_account_id']) != count($_POST['dr_amount'])) $response['msg'] = ('Error in Credited Accounts');
        else {

            #start transaction
            $finmodel->db->transBegin();
            $date = date('Y-m-d');

            $trx_id =  $finmodel->record_trx($_POST['trx_amount'], $_POST['trx_source'], $finmodel->financial_period()['fp_id'], $date, $_POST['trx_source']);

            for ($i = 0; $i < count($_POST['dr_account_id']); $i++) {

                    if ($this->get_acc_nature($_POST['dr_account_id'][$i]) == 'dr')
                    $amount = $_POST['dr_amount'][$i];
                else $amount = - ($_POST['dr_amount'][$i]);

                $finmodel->trx_det('dr', $_POST['dr_amount'][$i], $_POST['dr_account_id'][$i], $trx_id, $_POST['trx_det_des_dr'][$i]);
                $finmodel->update_accounnt_balance($_POST['dr_account_id'][$i], $amount , 'dr');
            }
            for ($i = 0; $i < count($_POST['cr_account_id']); $i++) {

                    if ($this->get_acc_nature($_POST['cr_account_id'][$i]) == 'cr')
                    $amount = $_POST['cr_amount'][$i];
                else $amount = - ($_POST['cr_amount'][$i]);

                $finmodel->trx_det('cr', $_POST['cr_amount'][$i], $_POST['cr_account_id'][$i], $trx_id, $_POST['trx_det_des_cr'][$i]);

                $finmodel->update_accounnt_balance($_POST['cr_account_id'][$i], $amount , 'cr');
            }

            #commit/rollback transaction
            if ($finmodel->db->transStatus() === FALSE) {
                $finmodel->db->transRollback();

                $response = ['success' => false];
                $response['msg'] = ('Operation Failed');
            } else {
                $finmodel->db->transCommit();

                $response = ['success' => true];
                $response['msg'] = ('Operation Success');
            }
        }

        echo json_encode($response);
    }

    /**
     * Transactions
     */
    public function transactions()
    {
        $auth = new AuthModel();
        $finmodel = new FinancialModel();

        $this->viewData['title'] = lang('Site.financial.trxhistory');
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['sources'] = $finmodel->get_trx_sources();

        return view('admin/financial/transactions', $this->viewData);
    }
    public function fetch_transactions()
    {
        $usermodel = new FinancialModel();
        $result = array('data' => array());
        $data = $usermodel->get_trans();
        // print_r($data);
        // exit;
        $i = 1;
        foreach ($data as $key => $value) {

            $buttons = '';

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
                'id' => $value["id"],
                'rec_title' => $value["trx_id"],
                'status' => $value["trx_id"],
                'rec_tbl' => 'tbl_cl_transections',
                'rec_tag_col' => 'trx_id',
                'rec_id_col' => 'id',
            ];

            $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
            $block = ($set["status"] == 'Active') ? '' : 'hidden';
            $delete = '';


            // $stat_icon = $this->stat_icon($set["status"]);
            $ui = $value["id"];
            $um = $value["id"];
            $buttons = $btn['header'] . '
                        
           
            <a href="umrah/edit_umra/' . $ui . '"
                         
            
                         
            class="dropdown-item">
            <i class="fas fa-pencil-alt text-warning mx-1"></i>' . lang("Site.button.edit") . ' </a>
                                            
                            <a ' . $act . '  type="button" data-rec_id="' . $set["id"] . '" 
                                data-rec_title="' . $set["rec_title"] . '" data-rec_tag="Active"  data-rec_tbl="' . $set["rec_tbl"] . '"
                                data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#status_modal">
                                <i class="fas fa-check text-success mx-1"></i>' . lang('Site.button.activate') . '  
                            </a>
                            <a ' . $act . '  type="button" data-rec_id="' . $set["id"] . '" 
                                data-rec_title="' . $set["rec_title"] . '" data-rec_tag="Active"  data-rec_tbl="' . $set["rec_tbl"] . '"   
                                
                                data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#passenger_modal">
                                <i class="fas fa-users text-primary mx-1"></i>' . lang('Site.ticket.passengers') . '  
                            </a>
                            <a ' . $block . '  type="button" data-rec_id="' . $set["id"] . '" 
                                data-rec_title="' . $set["rec_title"]  . '" data-rec_tag="Blocked" data-rec_tbl="' . $set["rec_tbl"] . '"  
                                data-rec_tag_col="' . $set["rec_tag_col"] . '" data-rec_id_col="' . $set["rec_id_col"] . '"
                                class="dropdown-item" data-bs-toggle="modal" data-bs-target="#status_modal">
                                <i class="fas fa-ban text-danger mx-1"></i>' . lang('Site.button.block') . '  
                            </a>

                        
                      </div>
                    </div>
            </div>';

            $result['data'][$key] = array(
                $i,
                // $value['id'],
                $value['trx_source'],


                // $stat_icon . ' ' . $value['status'],
                $buttons,
            );
            $i++;
        } // /foreach
        echo json_encode($result);
    }

    public function fetch_trx()
    {
        $finmodel = new FinancialModel();


        $src = $this->request->getVar('query');
        $data = $finmodel->trx($src);
        $datacnt = count($data);

        $data_sum = 0;
        $output = '';

        $output .= '
            <table id="manageTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>' . lang('Site.financial.source') . '</th>
                <th>' . lang('Site.financial.amount') . '</th> 
                <th>' . lang('Site.financial.doneby') . '</th> 
                <th>' . lang('Site.common.date') . '</th>   
                <th>' . lang('Site.common.action') . '</th> 
            </tr>
        </thead>
        <tbody>
        
                ';
        if ($datacnt > 0) {

            $i = 1;
            foreach ($data as $val) {

                $var =     $val['trx_source'] == "journal" ?
                    '<a href="' . base_url() . 'financial/editjentry/' . $val['trx_id'] . '" class="">
                           <i class="fa fa-edit" aria-hidden="true"></i>
                         </a>| 
                          <a href="#" class="">
                           <i class="fa fa-trash" aria-hidden="true" onclick="removeJournal(' . $val['trx_id'] . ')"></i>
                         </a>' :
                    '<a href="#">
                           <i class="fa fa-edit" aria-hidden="true" disabled></i>
                         </a>';

                $data_sum += $val['trx_amount'];
                $output .= '
                       <tr>
                       <td>' . $i . '</td>
                        <td>' . $val['trx_source'] . '</td>
                        
                     
                        
                        <td>' . $val['trx_amount'] . '</td>                  
                        <td>' . 'N/A' . '</td>                  
                        <td>' . date('m/d/Y', strtotime($val['trx_date'])) . '</td>
                       <td>
                       <a href="#" class="view">
                           <i class="fa fa-eye" aria-hidden="true"></i>
                        </a> | 
                        ' . $var . '
                          
                      </tr>
 
                       <tr style="display: none;"> 
                       <td colspan="6">
                      <table class="table table-bordered table-hover">
                          <thead>
                              <tr>
                              <th>#</th>
                              <th>' . lang('Site.financial.acc') . '</th>
                              <th>' . lang('Site.financial.debit') . '</th>   
                              <th>' . lang('Site.financial.credit') . '</th>                                            
                              </tr>
                          </thead>
                          <tbody>';
                $detail = $j = 1;
                $details = $finmodel->trx_details($val['trx_id']);
                foreach ($details as $val) {
                    $output .= '<tr>
                                      <td>' . $j . '</td>
                                      <td>' . $val['acc_name'] . '</td>    
                                      <td>' . $val['dr_amount'] . '</td>    
                                      <td>' . $val['cr_amount'] . '</td>   
                                                                                                       
                                  </tr>';
                    $j++;
                }

                $output .= '</tbody>
                           </table> 
                           </td>
                           </tr>';
                $i++;
            }
        } else {
            $this->fetch_trx1();
        }
        $output .= '</tbody></table>';
        $output .= '
       <b> <label style="margin-left:360px;">' . lang('Site.financial.transactions') . ': ' . $datacnt . '.</label></b>
        <b><label style="margin-left:160px;">' . lang('Site.financial.sum') . ': $' . $data_sum . '.00' . '.</label></b>

        ';
        echo $output;
    }


    public function fetch_trx1()
    {
        $finmodel = new FinancialModel();


        $src = $this->request->getVar('query');
        $data = $finmodel->trx($src);
        $datacnt = count($data);

        $output = '';

        $output .= '
            <table id="manageTable" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>' . lang('Site.financial.source') . '</th>
                <th>' . lang('Site.common.date') . '</th>   
                <th>' . lang('Site.financial.amount') . '</th> 
                <th>' . lang('Site.financial.doneby') . '</th> 
                <th>' . lang('Site.common.action') . '</th> 
            </tr>
        </thead>
        <tbody>
        
                ';
        if ($datacnt > 0) {

            $i = 1;
            foreach ($data as $val) {

                $var =     $val['trx_source'] == "journal" ?
                    '<a href="' . base_url() . 'financial/editjentry/' . $val['trx_id'] . '" class="">
                           <i class="fa fa-edit" aria-hidden="true"></i>
                         </a>| 
                          <a href="#" class="">
                           <i class="fa fa-trash" aria-hidden="true" onclick="removeJournal(' . $val['trx_id'] . ')"></i>
                         </a>' :
                    '<a href="#">
                           <i class="fa fa-edit" aria-hidden="true" disabled></i>
                         </a>';

                $output .= '
                       <tr>
                       <td>' . $i . '</td>
                        <td>' . $val['trx_source'] . '</td>
                        
                       <td>' . date('m/d/Y', $val['trx_date']) . '</td>
                        <td>' . $val['trx_amount'] . '</td>                  
                        <td>' . 'N/A' . '</td>                  
                       <td>
                       <a href="#" class="view">
                           <i class="fa fa-eye" aria-hidden="true"></i>
                        </a> | 
                        ' . $var . '
                          
                      </tr>
 
                       <tr style="display: none;"> 
                       <td colspan="6">
                      <table class="table table-bordered table-hover">
                          <thead>
                              <tr>
                              <th>#</th>
                              <th>' . lang('Site.financial.acc') . '</th>
                              <th>' . lang('Site.financial.debit') . '</th>   
                              <th>' . lang('Site.financial.credit') . '</th>                                            
                              </tr>
                          </thead>
                          <tbody>';
                $detail = $j = 1;
                $details = $finmodel->trx_details($val['trx_id']);
                foreach ($details as $val) {
                    $output .= '<tr>
                                      <td>' . $j . '</td>
                                      <td>' . $val['acc_name'] . '</td>    
                                      <td>' . $val['dr_amount'] . '</td>    
                                      <td>' . $val['cr_amount'] . '</td>                                                                           
                                  </tr>';
                    $j++;
                }

                $output .= '</tbody>
                           </table> 
                           </td>
                           </tr>';
                $i++;
            }
            $output .= '<tr>
              <td colspan = "5"> ' . lang('Site.financial.transactions') . ': ' . $datacnt . ' </td> 
              </tr>';
        } else {
            $output .= '<tr>
                 <td colspan = "5"> No Data Found </td> 
                 </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
    }
    /**
     * End of Transactions
     */

    public function upload_img($folder, $image)  // uploads images for setup 
    {
        $_FILES[$image]['name'] = time() . '-RAED-' . $_FILES[$image]['name'];
        $target_folder = 'public/assets/images/' . $folder . '/' . $_FILES[$image]['name'];
        move_uploaded_file($_FILES[$image]['tmp_name'], $target_folder);
        return $_FILES[$image]['name'];
    }
}
