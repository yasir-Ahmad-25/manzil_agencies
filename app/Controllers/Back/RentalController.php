<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\PaymentModel;
use App\Models\Back\RentalModel;
use DateTime;

class RentalController extends BaseController
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

        $this->viewData['title'] = 'Rental';
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['customers'] = $this->get_table_info('tbl_customers');
        $this->viewData['apartments'] = $this->get_table_info('tbl_apartments');
        $this->viewData['all_apartment'] = $this->get_table_info('tbl_apartments');
        $this->viewData['accounts'] = $payment->get_cash_bank_accounts();
        return view('admin/rental/rental', $this->viewData);
    }

    function closed()
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

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['accounts'] = $payment->get_cash_bank_accounts();
        return view('admin/rental/closed_rental', $this->viewData);
    }

    public function fetch_rentals()
    {
        $rental = new RentalModel();

        $result = array('data' => array());
        $data = $rental->get_rental_info();
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

            $date_start = new DateTime($value['start_date']);
            $date_curr = new DateTime(date('Y-m-d'));
            $date_end  = new DateTime($value['end_date']);

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
                $buttons,
            );
            $i++;
        } // /foreach
        // print_r($result);
        echo json_encode($result);
    }

    public function record_rentals()
    {
        $rental = new RentalModel();

        $response = array();
        $response['success'] = false;
        $tag = $_POST['acc_tag_rec'];

        if (empty($_POST['ten_id'])) {
            $response['alert_inner'] = $this->alert('Choose Customer', 'danger');
        } else if (empty($_POST['ap_id'])) {
            $response['alert_inner'] = $this->alert('Choose Apartment', 'danger');
        } else if (empty($_POST['rental_date'])) {
            $response['alert_inner'] = $this->alert('Enter Rental Date', 'danger');
        } else if (empty($_POST['rent_price']) || $_POST['rent_price'] <= 0) {
            $response['alert_inner'] = $this->alert('Enter Rental Price', 'danger');
        } else if ((float)($_POST['deposit'] > 0) && ($tag == "")) {
            $response['alert_inner'] = $this->alert('Select Account name', 'danger');
        } else if (empty($_POST['btn_action'])) {
            $response['alert_inner'] = $this->alert('Error! Refresh The Page', 'danger');
        } else {
            if ($_POST['btn_action'] == 'btn_add') {

                if ($rental->apartment_exist($_POST['ap_id'], $_POST['ten_id'])) {
                    $response['alert_inner'] = $this->alert('This apartment is already rented to this customer', 'danger');
                } else {

                    $rentals = [
                        'profile_no' =>  '',
                        'customer_id' => $_POST['ten_id'],
                        'ap_id' => $_POST['ap_id'],
                        'start_date' => $_POST['start_date'],
                        'end_date' => $_POST['end_date'],
                        'rental_date' => $_POST['rental_date'],
                        'duration' => $_POST['duration'],
                        'rental_status' => 'Active',
                        'deposit' => $_POST['deposit'],
                    ];

                    $rental_created = $rental->create_rental( $_POST['ap_id'],$rentals, $_POST['rent_price'], $_POST['acc_tag_rec'], $_POST['acc_tag_dep']);

                    if ($rental_created) {

                        $response['success'] = true;
                        $response['alert_outer'] = $this->alert('Rental Has Been Created', 'success');
                    } else {
                        $response['alert_inner'] = $this->alert('Rental Creation Failed', 'danger');
                    }
                }
            } else if ($_POST['btn_action'] == 'btn_edit') {
                unset($_POST['btn_action']);
                // $response['success'] = $this->Admin_model->update('tbl_rentals', 'rental_id', $_POST['rental_id'], $this->input->post());
                // $response['alert_outer'] = $this->alert('Rental Has Been Updated.', 'success');
            }
        }
        echo json_encode($response);
    }

    public function fetch_closed_rentals()
    {
        $rental = new RentalModel();

        $result = array('data' => array());
        $data = $rental->get_closed_rentals();
        $i = 1;
        foreach ($data as $key => $value) {

            $btn = [
                'header' => '<div class="ml-auto">
                            <div class="dropdown sub-dropdown"><button class="btn btn-link text-dark" type="button"
                            id="dd1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fas fa-ellipsis-v mx-1"></i></button><div class="dropdown-menu dropdown-menu-right"
                            aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform;
                            top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                ',
                'mid_1' => '',
            ];
            $set = [
                'id' => $value["rental_id"],
                'rec_title' => $value["ten_name"],
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
                                 data-ten_id="' . $value["ten_id"] . '"
                                 data-ap_id="' . $value["ap_id"] . '"
                                 data-start_date="' . $value["start_date"] . '"
                                 data-end_date="' . $value["end_date"] . '"
                                 data-duration="' . $value["duration"] . '"
                                 data-rental_date="' . $value["rental_date"] . '"
                                 data-deposit="' . $value["deposit"] . '"
                                data-target="#rental_modal" class="dropdown-item" data-toggle="modal" >
                                <i class="fas fa-info-circle text-info mx-1"></i> View
                            </a>
                    </div>
                    </div>
            </div>';

            $date_start = new DateTime($value['start_date']);
            $date_end  = new DateTime($value['end_date']);
            $date_diff_dur = $date_start->diff($date_end);

            $result['data'][$key] = array(
                $i,
                $value['ten_name'],
                $value['ap_no'],
                $value['start_date'],
                $value['end_date'],
                $date_diff_dur->days . ' days',
                $stat_icon . ' ' . $value['rental_status'],
                $buttons,
            );
            $i++;
        } // /foreach
        // print_r($result);
        echo json_encode($result);
    }



    /***********************************************
     *             RENTAL EXTENSION  
     * ********************************************/

    public function extend_rental_duration()
    {
        $response = array();
        $response['success'] = false;
        $rental = new RentalModel();

        $db = \Config\Database::connect();


        $rentid = $_POST['extend_rental_id'];
        $edate = $_POST['new_end_date'];
        $charges = $_POST['extra_charges'];
        $ten_id = $_POST['extend_ten_id'];

        $date = date('Y-m-d');
        $dur_days = $_POST['extra_duration'];
        $dur_days = explode(' ', $dur_days);
        $duration = $dur_days[0];

        if (empty($edate)) {
            $response['alert_inner'] = $this->alert('Choose New Date', 'danger');
        } else if ($charges == "") {
            $response['alert_inner'] = $this->alert('Enter charges or 0 for no charge', 'danger');
        } else {

            $updated = $db->query("UPDATE tbl_rentals SET end_date='$edate' WHERE rental_id='$rentid'");

            # generate bills if charges are greater than 0

            if ($charges > 0) {

                $rental->generate_rental_bill($date, $duration, $ten_id, $rentid, $charges);
            }

            if ($updated) {
                $response['alert_outer'] = $this->alert('Rental Duration Has Been Extended', 'success');
                $response['success'] = true;
            } else {
                $response['alert_outer'] = $this->alert('Rental Duration Extension Failed', 'danger');
            }
        }

        echo json_encode($response);
    }


    /***********************************************
     *             RENTAL RELOCATION  
     * ********************************************/

    public function relocate_tenant()
    {
        $response = array();
        $response['success'] = false;

        $db = \Config\Database::connect();

        $rentid = $_POST['rental_id'];
        $cur_ap = $_POST['curr_apartment'];
        $new_ap = $_POST['new_apartment'] ?? null;

        if (empty($new_ap)) {
            $response['alert_inner'] = $this->alert('Choose New Apartment', 'danger');
        } else {

            $db->query("UPDATE tbl_apartments SET ap_status='Occupied' WHERE ap_id='$new_ap'");
            $db->query("UPDATE tbl_apartments SET ap_status='Active' WHERE ap_id='$cur_ap'");

            $updated = $db->query("UPDATE tbl_rentals SET ap_id='$new_ap' WHERE rental_id='$rentid'");

            if ($updated) {
                $response['alert_outer'] = $this->alert('Tenant has been relocated', 'success');
                $response['success'] = true;
            } else {
                $response['alert_outer'] = $this->alert('Tenant relocation failed.', 'danger');
            }
        }


        echo json_encode($response);
    }


    public function terminate_rental_agreement()
    {
        $response = array();
        $response['success'] = false;

        $db = \Config\Database::connect();

        $rentid = $_POST['term_rental_id'];
        $bal = $_POST['tbal'];
        $dep = $_POST['tdep'];
        $apid = $_POST['t_ap_id'];
        $edate = date('Y-m-d');

        if (($bal != 0) || ($dep != 0)) {
            $response['alert_inner'] = $this->alert('Please clear balance or deposit to terminate', 'danger');
        } else {

            $rentalUp = $db->query("UPDATE tbl_rentals SET rental_status='Closed' WHERE rental_id='$rentid'");
            $rentalUp = $db->query("UPDATE tbl_rentals SET end_date='$edate' WHERE rental_id='$rentid'");
            $apartUp = $db->query("UPDATE tbl_apartments SET ap_status='Active' WHERE ap_id='$apid'");

            $this->record_rental_termination($rentid);

            if ($rentalUp && $apartUp) {
                $response['alert_outer'] = $this->alert('Rental Has Been Terminated', 'success');
                $response['success'] = true;
            } else {
                $response['alert_inner'] = $this->alert('Rental Termination Failed', 'danger');
            }
        }

        echo json_encode($response);
    }

    public function record_rental_termination($rentid)
    {
        $rental = new RentalModel();

        $data = [
            'rental_id' => $rentid,
            'profile_no' =>  '',
            'term_date' => date('Y-m-d'),
            'reason' => $_POST['t_reason'],
        ];

        $rental->store('tbl_rental_termination', $data);
    }




    public function get_active_apartments()
    {
        $rental = new RentalModel();

        $aparts = $rental->get_active_apartments();
        $output = '';
        $output .= '<option selected disabled>Choose Apartment</option>';
        foreach ($aparts as $val) {
            $output .= '<option value="' . $val['ap_id'] . '"> ' . $val['ap_no'] . '</option>';
        }
        echo $output;
    }

    public function get_apartment_price()
    {
        $rental = new RentalModel();
        $apid = $_POST['ap_id'];
        echo $rental->get_apartment_price($apid);
    }
}
