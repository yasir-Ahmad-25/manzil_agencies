<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\ApartmentModel;
use App\Models\Back\AuthModel;
use App\Models\Back\CustomerModel;
use App\Models\Back\FinancialModel;
use App\Models\Back\ReportModel;
use App\Models\Back\SettingsModel;
use App\Models\Back\SupplierModel;

class ReportController extends BaseController
{

    public function income()
    {
        $auth = new AuthModel();

        


        $this->viewData['access'] = $auth->get_user_access(
            session()->get('ut_id'),
            $this->request->getLocale()
        );
        return view('admin/report/income_statement', $this->viewData);
    }
    public function rental_income()
    {
        $auth = new AuthModel();

      

        $this->viewData['access'] = $auth->get_user_access(
            session()->get('ut_id'),
            $this->request->getLocale()
        );
        return view('admin/report/rental_income', $this->viewData);
    }
    public function fetch_rep_rental()
    {
        $result = array('data' => array());
        $moth = $_POST['month'] ?? date('m');
        //  $site_id = $this->session->userdata('pr')['site'];
        // $holder = $this->session->userdata('user_data')['holder'];
        $model = new SettingsModel();
        $data = $model->rep_rental_report('', $moth);

        $i = 1;
        $total = 0;
        $table = '';

        $table .= '<table id="manageTable3" class="table table-striped table-bordered no-wrap" style="width:100%">
                <thead>
                <tr style="background:#eee">
                    <th>#</th>
                    <th>Tenant Name</th>
                    <th>Apartment</th>      
                    <th>Rent Amount</th>      
                    <th>Deposit</th>      
                    <th>Rent Paid</th>      
                    <th>A/Receivable</th>      
                    <th>Advance</th>      
                    <th>Cash In</th>
                </tr>
                </thead><tbody>';

        if (count($data) > 0) {
            $deposits = 0;
            $rent_amount = 0;
            $advances = 0;
            $paid = 0;
            $total_cashin = 0;
            foreach ($data as $val) {

                $cashin = $val['deposit_amount'] + $val['paid_amount'] + $val['advances'];
                $total_cashin += $cashin;
                $deposits = $deposits +$val['deposit_amount'];
                $rent_amount = $rent_amount +$val['rent_amount'];
                $paid = $paid +$val['paid_amount'];
                $advances = $advances +$val['advances'];
                $table .= '
                <tr>
                    <td> ' . $i . ' </td>
                    <td> ' . $val["Tenant"] . '</td>
                    <td> ' . $val['Apartment'] . '</td>
                    <td> ' . $val['rent_amount'] . '</td>
                    <td> ' . $val['deposit_amount'] . '</td>
                    <td> ' . $val['paid_amount'] . '</td>
                    <td> </td>
                    <td> ' . $val['advances'] . '</td>
                    <td>$' . $cashin  . ' </td>
                </tr>';
                $i++;
            }
            $account_recivable = (($rent_amount - $paid) < 0)?'':$rent_amount - $paid;
            $table .= '<tr>
                    <td colspan="3"><b>Total</b></td>
                    <td><b>$' . $rent_amount  . '</b></td>
                    <td><b>$' . $deposits  . '</b></td>
                    <td><b>$' . $paid  . '</b></td>
                    <td><b>$' . $account_recivable  . '</b></td>
                    <td><b>$' . $advances  . '</b></td>
                    <td><b>$' . $total_cashin  . '</b></td>
                    
                    </tr>
            </tbody>
            </table>';
        } else {
            $table .= '<tr>
                            <td colspan="9">No Data Found</td>
                        </tr>';
        }


        echo $table;
    }

    public function blance_sheet()
    {
        $auth = new AuthModel();

        $this->viewData['access'] = $auth->get_user_access(
            session()->get('ut_id'),
            $this->request->getLocale()
        );

        return view('admin/report/bal_sheet', $this->viewData);
    }


    public function print_income_statement(): void
    {

        $financial = new FinancialModel();
        $locale = $this->request->getLocale();

        $from = $_POST['from_date'];
        $to = $_POST['to_date'];

        $accgrp = $financial->get_rev_expenses();

        $output = '<table id="manageTable" class="table display no-wrap">
                    <thead class="bg-info text-white">
                        <tr>
                        </tr>
                    </thead>
                    <tbody>';

        $rev = 0;
        $exp = 0;
        $total = 0;
        foreach ($accgrp as $grp) {
            $bal = 0;
            $output .= '     
                    <tr>
                        <td colspan="2"> <b>' . $grp['acc_grp_name'] . '</b></td>
                    </tr>';

            $accounts = $financial->get_income_statements($grp['acc_grp_id'], $from, $to);
            foreach ($accounts as $acc) {
                if ($grp['acc_grp_name'] == "Revenue") {
                    $rev += $acc['cramount'];

                    $bal = $acc['cramount'] - $acc['dramount'];

                    $total += $bal;
                } else {
                    $exp += $acc['dramount'];

                    $bal = $acc['dramount'] - $acc['cramount'];

                    $total -= $bal;
                }


                $output .= '<tr>
                            <td> &nbsp;&nbsp;&nbsp;<a href="
                            ' . base_url($locale . '/financial/acchistory/' . $acc['account_id']) . '">' . $acc['acc_name'] . '</a>
                            </td>
                            <td>$' . number_format(($bal), 2) . ' </td>
                        </tr>';
            }

            $output .= '<tr>
                        <td><b>Total ' . $grp['acc_grp_name'] . '</b></td>
                        <td> <b>$' . number_format($bal, 2) . '</b> </td>
                    </tr>';
        }

        $output .= '<tr>
                        <td> <b>Net Income </b></td>
                        <td> <b>$' . number_format($total, 2) . '</b></td>
                    </tr>
                </tbody>

            </table>';

        echo $output;
    }

    public function print_balance_sheet(): void
    {

        $financial = new FinancialModel();
        $locale = $this->request->getLocale();

        $accgrp = $financial->get_spcl_account_groups();

        $from = $_POST['from_date'];
        $to = $_POST['to_date'];

        $output = '<table id="manageTable" class="table">
                    <thead class="bg-info text-white">
                    <tr>
                    </tr>
                </thead>
                <tbody>';

        $exp = 0;
        $eq = 0;
        $total = 0;
        foreach ($accgrp as $grp) {

            $output .= '<tr>
                        <td colspan="2"> <b>' . strtoupper($grp['acc_grp_name']) . '</b></td>
                    </tr>';

            $acc_tps = $financial->get_cl_account_types($grp['acc_grp_id']);
            $grp_total = 0;
            foreach ($acc_tps as $tp) {

                $output .= '<tr>
                            <td><b>' . $tp['acc_type_name'] . '</b></td>
                            <td> </td>
                        </tr>';

                $accounts = $financial->get_balance_sheet_table($tp['acc_type_id'], $from, $to);
                $balance = 0;
                foreach ($accounts as $acc) {

                    if ($grp['acc_grp_nature'] == 'dr') {
                        $balance = ($acc['dramount'] - $acc['cramount']);
                        $total += $balance;

                    } else {
                        // $grp_total += ($acc['cramount'] - $acc['dramount']);
                        $balance = ($acc['cramount'] - $acc['dramount']);
                        $total -= $balance;
                    }

                    $output .= '<tr style="margin:10px;">
                                <td> <a href="' . base_url($locale . '/financial/acchistory/' . $acc['account_id']) . '">' . $acc['acc_name'] . '</a></td>
                                <td> $' . $balance . '</td>
                            </tr>';
                }
            }

            if ($grp['acc_grp_name'] == "Equity") {
                $inc = $financial->get_total_income($from, $to);
                $exp = $financial->get_total_exp($from, $to);
                $eq = $inc - $exp;

                $output .= '<tr>
                                <td>Net Income</td>
                                <td> <b>$ ' . number_format($eq, 2) . '</b></td>
                            </tr>';
            }

            $output .= '<tr>
                            <td><b>Total ' . $grp['acc_grp_name'] . '</b></td>
                            <td> <b>$
                                ' . number_format($total + $eq, 2) . '</b> </td>
                        </tr>';
        }

        $ttl = $financial->get_total_liability_equity($from, $to);
        $output .= '<tr>
                        <td> <b>Total Liability and Equity </b></td>
                        <td> <b>$' . number_format($ttl + $eq, 2) . '</b></td>
                    </tr>
                </tbody>

            </table>';

        echo $output;
    }


    public function payables()
    {
        $auth = new AuthModel();

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['company'] = $this->get_table_info('`company_info`');
        return view('admin/report/payables', $this->viewData);
    }

    public function payables_report(): void
    {

        $supplier = new SupplierModel();

        $report = $supplier->payables_report();
        $output = '';
        $i = 1;
        foreach ($report as $value) {

            $output .= '<tr>
            <td><b>' . $i . '</b></td>
            <td><b>' . $value['sup_name'] . '</b></td>
            <td><b>' . $value['sup_phone'] . '</b></td>
            <td><b>$' . $value['acc_balance'] . '</b></td>
        </tr>';

            $i++;
        }

        echo $output;
    }


    public function receivables()
    {
        $auth = new AuthModel();

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['company'] = $this->get_table_info('`company_info`');
        return view('admin/report/receivables', $this->viewData);
    }

    public function receivables_report(): void
    {

        $customer = new CustomerModel();

        $report = $customer->receivables_report();
        $output = '';
        $i = 1;
        foreach ($report as $value) {

            $output .= '<tr>
            <td><b>' . $i . '</b></td>
            <td><b>' . $value['cust_name'] . '</b></td>
            <td><b>' . $value['cust_tell'] . '</b></td>
            <td><b>$' . $value['acc_balance'] . '</b></td>
        </tr>';

            $i++;
        }

        echo $output;
    }

    public function getAll_Buildings(){

        $auth = new AuthModel();

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'),$this->request->getLocale());
        return view('admin/report/buildings.php', $this->viewData);
    }

    public function fetch_buildings($status){
 

        $apartment = new ApartmentModel();
        $report = new ReportModel();
        $result = array('data' => array()); // initialize empty result array

        // fetch Apartments
        $data = $apartment->get_Buildings('tbl_sites', 'site_id', $status); 

        $i = 1;
        foreach ($data as $key => $value) {


            $set = [
                'id' => $value["site_id"],
                'rec_title' => $value["site_name"],
                'status' => $value["status"],
                'rec_tbl' => 'tbl_sites',
                'rec_tag_col' => 'status',
                'rec_id_col' => 'site_id',
            ];

            $stat_icon = $this->stat_icon($set["status"]);

            $owner_name = $report->getOwnerById($value['owner_id']);
            $result['data'][$key] = array(
                $i,
                $value['site_name'],
                $owner_name,
                $value['site_address'],
                $value['SiteYearBuild'],
                $apartment->get_num_floors($value['site_name']) . ' Floors',
                $stat_icon . ' ' . $value['status'],
            );

            $i++;
        }

        //  return the result as JSON
        echo json_encode($result);

    }
}
