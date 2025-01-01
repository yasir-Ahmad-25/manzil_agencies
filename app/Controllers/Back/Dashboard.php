<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

use App\Models\Back\AuthModel;
use App\Models\Back\BillModel;
use App\Models\Back\DashboardModel;
use App\Models\Back\RentalModel;

class Dashboard extends BaseController
{
    
    public function index(): string
    {
        $auth = new AuthModel(); 
        $dashboard = new DashboardModel();
         

        $this->viewData['halls'] = 0;
        $this->viewData['customers'] = count($this->get_table_info('tbl_customers'));
        
        $this->viewData['buildings'] = count($this->get_table_info('tbl_sites'));;
        $this->viewData['Apartments'] = count($this->get_table_info('tbl_apartments'));;

        $this->viewData['suppliers'] = count($this->get_table_info('tbl_suppliers'));;
        $this->viewData['users'] =count($this->get_table_info('tbl_users'));;
        
        $this->viewData['apartments'] = count($this->get_table_info('tbl_apartments'));;
        $this->viewData['rentals'] = count($this->get_table_info('tbl_rentals'));;
        $this->viewData['cancel_booking'] = 0;;
                
        $this->viewData['expense'] = 0;
        $this->viewData['expense_month'] = 0;
        
        $this->viewData['payables'] =  0;
        $this->viewData['receivables'] = 0;
    
        $this->viewData['total_tenants'] = $dashboard->get_total_tenants()->total_tenants;
        $this->viewData['unit_avialable'] = $dashboard->get_avialable_units()->totals;
        $this->viewData['unpaid_people'] = $dashboard->getNumberOf_Unpaid_People();
        $this->viewData['monthly_rev'] =  0;


        // ************************************* CHARTS ********************************************
        // Get the current month and year
        $currentYear = date('Y');

        // $this->viewData['income_data'] = $this->getIncomeData_chart(1);

        //  ut_id means user id
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'),$this->request->getLocale());
        return view('admin/dashboard', $this->viewData);

    }


    public function fetch_due_rentals()
    {
        $billmodel = new BillModel();

        $result = array('data' => array());

        $data = $billmodel->get_all_unpaid_bills();
        // dd($data);
        // log_message("debug","This is Debug message",$data);

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
            // $cancel = ((($value["total"]+$value['discount']) - $value['paid']) > 0) ? '' : 'hidden';
            $pay = ( (( $value["total"]+$value['discount']) - $value['paid']) > 0) ? '' : 'hidden';
            // 700 + 0.00 - 700
            $rem =  ($value['total'] + $value['discount']) - $value['paid'];
            // '<a ' . $cancel . ' type="button" id="btn_payment" data-total="' . $value['total'] . '" data-dis="' . $value["discount"] . '"
            //                     data-bill_id="' . $value["id"] . '" data-ten_id="' . $value["customer_id"] . '"
            //                     data-bill_date="' . $value["created_date"] . '" 
            //                     data-bs-target="#cancel_modal" class="dropdown-item" data-bs-toggle="modal">
            //                     <i class="fas fa-times text-danger mx-1"></i>Cancel Payment 
            //                 </a>';
            $type = ($value['rental_id'] != 0) ? "rent" : 'bill';
            $buttons = $btn['header'] . '
                            <a type="button" id="btn_view" target="_blank" href="'. base_url('en') .'/bill/invoice_print/'. $value['id']  .'"  class="dropdown-item"  >
                                <i class="fas fa-print te x t-info mx"></i> Print
                            </a>  
                            
                            <a ' . $pay . ' type="button" id="btn_payment" data-total="' . $rem . '"
                            data-bill_id="' . $value["id"] . '" data-dis="' . $value["discount"] . '"
                            data-bill_type="'. $type .'"
                            data-bill_date="' . $value["created_date"] . '" data-ten_id="' . $value["customer_id"] . '"
                            data-bs-target="#form_modal" class="dropdown-item" data-bs-toggle="modal">
                            <i class="fas fa-pencil-alt text-warning mx-1"></i>Payment 
                        </a>
                        ';


            $buttons .= '</div>
                    </div>
            </div>';

            // $bill_status = $value['bill_status'] == "PAID" ? '<span class="badge badge-success">' . $value['bill_status'] . '</span>'
            //     : '<span class="badge badge-danger">' . $value['bill_status'] . '</span>';

            $paid = ($value['total']);
            $months = [
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 =>  ' August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December'
            ];

            // Fomrat date
            $created_date = new \DateTime($value['created_date']);
            $created_date_Format = $created_date->format('Y-m-d');
            // $type = ($value['rental_id'] != 0) ? "Rental":"Utility"  ;
            $details = ($value['rental_id'] != 0) ? "Rental" : '<a href="javascript:void(0)" data-bs-target="#print_inv" data-bill_id="'. $value['id'] .'" class="dropdown-item" data-bs-toggle="modal"><i data-feather="eye" class="feather-icon"></i>Details</a>';
            $result['data'][$key] = array(
                $i,
                $months[$value['month']],
                $value['cust_name'],
                '$' . $value['total'],
                '$' . $value['discount'],
                '$' . $value['paid'],
                '$' . ($value['total'] + $value['discount']) - $value['paid'],
                $created_date_Format,
                $details,
                $pay != 'hidden' ? '<i class="fas fa-ban text-danger mx-1"></i> Unpaid' : '<i class="fas fa-check text-success mx-1"></i> Paid',
                // $buttons,
            );
            $i++;
        } // /foreach
        // print_r($result);
        // dd($pay);
        echo json_encode($result);
    }


    public function fetch_las_five_rentals()
    {
        $rental = new RentalModel();

        $result = array('data' => array());

        $branch_id =  (int) session()->get('user')['branch_id'];
        // search rental information based on selected site 
        $data = $rental->get_last_five_rental_info( $branch_id);
       
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
                'id' => $value["rental_id"],
                'rec_title' => $value["cust_name"],
                'status' => $value["rental_status"],
                'rec_tbl' => 'tbl_rentals',
                'rec_tag_col' => 'rental_status',
                'rec_id_col' => 'rental_id',
            ];

            $stat_icon = $this->stat_icon($set["status"]);
            $act = ($set["status"] == 'Pending' || $set["status"] == 'Blocked') ? '' : 'hidden';
            $block = ($set["status"] == 'Active') ? '' : 'hidden';


            $buttons = $btn['header'] . '
                            <a type="button" id="btn_view" data-rental_id="' . $value["rental_id"] . '"
                                 data-ten_id="' . $value["customer_id"] . '"
                                 data-ap_id="' . $value["ap_id"] . '"
                                 data-start_date="' . $value["start_date"] . '"
                                 data-end_date="' . $value["end_date"] . '"
                                 data-duration="' . $value["duration"] . '"
                                 data-rental_date="' . $value["rental_date"] . '"
                                 data-deposit="' . $value["deposit"] . '"
                                data-bs-target="#rental_modal" class="dropdown-item" data-bs-toggle="modal" >
                                <i class="fas fa-info-circle text-info mx-1"></i> View
                            </a>';
            if ($set["status"] == 'Active') {

                $buttons .= '<a type="button" id="btn_edit"  data-rental_id="' . $value["rental_id"] . '"
                        data-ten_id="' . $value["customer_id"] . '"
                            data-ap_id="' . $value["ap_id"] . '"
                            data-start_date="' . $value["start_date"] . '"
                            data-end_date="' . $value["end_date"] . '"
                            data-duration="' . $value["duration"] . '"
                           data-bs-target="#extend_modal" class="dropdown-item" data-bs-toggle="modal" >
                           <i class="fas fa-pencil-alt text-warning mx-1"></i> Extend
                         </a>
                    <a type="button" id="btn_edit"  data-rental_id="' . $value["rental_id"] . '"
                        data-ten_name="' . $value["cust_name"] . '"
                            data-ap_no="' . $value["ap_no"] . '"
                            data-ap_id="' . $value["ap_id"] . '"
                            data-start_date="' . $value["start_date"] . '"
                            data-end_date="' . $value["end_date"] . '"
                            data-duration="' . $value["duration"] . '"
                            data-rental_date="' . $value["rental_date"] . '"
                            data-deposit="' . $value["deposit"] . '"
                            data-balance="' . $value["deposit"] . '"
                        data-bs-target="#terminate_modal" class="dropdown-item" data-bs-toggle="modal" >
                        <i class="fas fa-ban text-danger mx-1"></i> Terminate
                    </a>
                    <a type="button" id="btn_edit"  data-rental_id="' . $value["rental_id"] . '"
                    data-ten_name="' . $value["cust_name"] . '"
                        data-ap_no="' . $value["ap_no"] . '"
                        data-ap_id="' . $value["ap_id"] . '"
                    data-bs-target="#relocate_modal" class="dropdown-item" data-bs-toggle="modal" >
                    <i class="fas fa-pencil-alt text-warning mx-1"></i> Relocation
                </a>';
            }

            $buttons .= '<a type="button" id="btn_print"  data-rental_id="' . $value["rental_id"] . '"
                        data-ten_id="' . $value["customer_id"] . '"
                        data-ten_name="' . $value["cust_name"] . '"
                        data-ap_id="' . $value["ap_id"] . '"
                        data-site_address="' . $value["site_address"] . '"
                        data-site_name="' . $value["site_name"] . '"
                        data-ap_no="' . $value["ap_no"] . '"
                        data-price="' . $value["price"] . '"
                        data-start_date="' . $value["start_date"] . '"
                        data-end_date="' . $value["end_date"] . '"
                        data-dur="' . $value["duration"] . '"
                        data-rental_date="' . $value["rental_date"] . '"
                        data-deposit="' . $value["deposit"] . '"
                        data-bs-target="#print_modal" class="dropdown-item" data-bs-toggle="modal" >
                        <i class="fas fa-print text-primary mx-1"></i> Print
                    </a>
                    
                    </div>
                    </div>
            </div>';

            $date_start = new \DateTime($value['start_date']);
            $date_curr = new \DateTime(date('Y-m-d'));
            $date_end  = new \DateTime($value['end_date']);

            $date_diff_dur = $date_start->diff($date_end);
            $diff = $date_diff_dur->days > 30
                ? (int)($date_diff_dur->days / 30) . ' month'
                : $date_diff_dur->days  . ' days';

            $date_diff_rest = $date_curr->diff($date_end);
            // if ($date_curr > $date_end) $date_diff_rest = 0;

            $remain = $date_diff_rest->days > 30
                ? (int)($date_diff_rest->days / 30) . ' month'
                : $date_diff_rest->days  . ' days';

            $result['data'][$key] = array(
                $i,
                $value['cust_name'],
                $value['ap_no'],
                $value['start_date'],
                $value['end_date'],
                $diff,
                $remain,
                $stat_icon . ' ' . $value['rental_status'],
                // $buttons,
            );
            $i++;
        } // /foreach
        // print_r($result);
        echo json_encode($result);
    }



    // ********************************************* CHARTS ************************************************



}
