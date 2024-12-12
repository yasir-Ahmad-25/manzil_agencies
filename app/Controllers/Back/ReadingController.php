<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\BillModel;
use App\Models\Back\FinancialModel;
use App\Models\Back\ReadingModel;
use App\Models\Back\ApartmentModel;
use CodeIgniter\Database\Database;
use DateTime;

class ReadingController extends BaseController
{

    function list()
    {
        $auth = new AuthModel();
        if (
            !$this->page_authorized(
                $this->request->uri->getSegment(2),
                $this->request->uri->getSegment(3)
            )
        ) {
            return view('admin/page_404', $this->viewData);
            exit;
        }
        $apartment = new ApartmentModel();

        $this->viewData['title'] = 'Bills';
        $this->viewData['rates'] = $this->get_table_info('tbl_rates');
        $this->viewData['customers'] = $this->get_table_info('tbl_customers');
        $this->viewData['meters'] = $this->get_table_info('tbl_meters');
        $this->viewData['apartments'] = $this->get_table_info('tbl_apartments');
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        $this->viewData['buildings'] = $apartment->get_sites();
        return view('admin/meter_reading/reading', $this->viewData);
    }
    function services()
    {
        $auth = new AuthModel();

        // if (
        //     $this->page_authorized(
        //         $this->request->uri->getSegment(2),
        //         $this->request->uri->getSegment(3)
        //     )
        // ) {
        //     return view('admin/page_404', $this->viewData);
        // }
        $apartment = new ApartmentModel();
        $this->viewData['title'] = 'Services';
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/meter_reading/services', $this->viewData);
    }
    function charge_services()
    {
        $auth = new AuthModel();
        // if (
        //     $this->page_authorized(
        //         $this->request->uri->getSegment(2),
        //         $this->request->uri->getSegment(3)
        //     )
        // ) {
        //     return view('admin/page_404', $this->viewData);
        // }
        $apartment = new ApartmentModel();
        $reading = new ReadingModel();

        $this->viewData['rates'] = $this->get_table_info('tbl_rates');
        $this->viewData['customers'] = $this->get_table_info('tbl_customers');
        $this->viewData['services'] = $reading->get_services();
        $this->viewData['apartments'] = $this->get_table_info('tbl_apartments');
        $this->viewData['buildings'] = $apartment->get_sites();

        $this->viewData['title'] = 'Services';
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/meter_reading/charge_services', $this->viewData);
    }

    public function fetch_services()
    {
        $reading = new ReadingModel();

        $result = array('data' => array());

        $data = $reading->get_services();

        $i = 1;
        foreach ($data as $key => $value) {

            $buttons = '';

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">
                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                    <a type="button" id="btn_edit" data-service_id="' . $value["id"] . '"  data-service_name="' . $value["service_name"] . '"
                        data-price="' . $value["price"] . '"
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reading_modal">
                        <i class="fas fa-pencil-alt text-info mx-1"></i>Edit </a>
            </div>
            </div>
        </div>';

            $result['data'][$key] = array(
                $i,
                $value['service_name'],
                $value['price'],
                $buttons,
            );

            $i++;
        } // /foreach

        echo json_encode($result);
    }
    public function fetch_charging_service()
    {
        $reading = new ReadingModel();

        $result = array('data' => array());

        $data = $reading->get_service_charge();

        $i = 1;
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
        foreach ($data as $key => $value) {

            $buttons = '';

            //     $buttons = '<div class="ml-auto">
            //     <div class="dropdown sub-dropdown">
            //         <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            //             <i class="fas fa-ellipsis-v mx-1"></i>
            //         </button>
            //         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
            //             <a type="button" id="btn_edit" data-service_id="' . $value["id"] . '"  data-service_name="' . $value["service_name"] . '"
            //                 data-price="' . $value["price"] . '"
            //                 class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reading_modal">
            //                 <i class="fas fa-pencil-alt text-info mx-1"></i>Edit </a>
            //     </div>
            //     </div>
            // </div>';

            $result['data'][$key] = array(
                $i,
                $value['date'],
                $months[$value['month']],
                $value['service_name'],
                $value['cust_name'],
                $value['qty'],
                $value['total'],
                $buttons,
            );

            $i++;
        } // /foreach

        echo json_encode($result);
    }
    public function fetch_reading_data()
    {
        $reading = new ReadingModel();

        $result = array('data' => array());

        $data = $reading->get_reading();

        $i = 1;
        foreach ($data as $key => $value) {

            $buttons = '';

            $buttons = '<div class="ml-auto">
            <div class="dropdown sub-dropdown">
                <button class="btn btn-link text-dark" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v mx-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-110px, 39px, 0px);">
                    <a type="button" id="btn_edit" data-reading_id="' . $value["reading_id"] . '"  data-rate="' . $value["rate_id"] . '"
                        data-prev="' . $value["prev"] . '" data-current="' . $value["current"] . '" data-reading_date="' . $value["reading_date"] . '"
                        data-diff="' . $value["diff"] . '" data-meter_id="' . $value["meter_id"] . '" 
                        class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reading_modal">
                        <i class="fas fa-pencil-alt text-info mx-1"></i>Edit </a>
            </div>
            </div>
        </div>';

            $result['data'][$key] = array(
                $value['meter_name'],
                $value['prev'],
                $value['current'],
                $value['diff'],
                $value['rate_value'],
                $value['total'],
                $value['read_month'],
                $value['reading_date'],
                $buttons,
            );

            $i++;
        } // /foreach

        echo json_encode($result);
    }
    public function crud_services()
    {
        $reading = new ReadingModel();
        $reading->db->transStart();
        $reading->db->transException(true);
        $response = array();
        $response['success'] = false;

        if (empty($_POST['service_name']))
            $response['alert_inner'] = $this->alert('Enter Service Name', 'danger');
        else if (empty($_POST['price']))
            $response['alert_inner'] = $this->alert('Enter Price', 'danger');
        else
            if ($_POST['btn_action'] == "btn_add") {

                $data = [
                    'service_name' => $this->request->getPost('service_name'),
                    'price' => $this->request->getPost('price'),
                    'status' => 'Active'

                ];
                $reading->store('services', $data);

                if ($reading->db->transStatus() == false) {
                    $reading->db->transRollback();
                    $response['success'] = false;
                    $response['alert_outer'] = $this->alert('Service Has Not Added', 'danger');
                } else {
                    $reading->db->transCommit();
                    $response['success'] = true;
                    $response['alert_outer'] = $this->alert('Service Has Been Added', 'success');
                }
            } else if ($_POST['btn_action'] == "btn_edit") {

                $data = [
                    'id' => $this->request->getPost('service_id'),
                    'service_name' => $this->request->getPost('service_name'),
                    'price' => $this->request->getPost('price'),

                ];
                $response['success'] = $reading->update_table('services', $data);
                if ($reading->db->transStatus() == false) {
                    $reading->db->transRollback();
                    $response['success'] = false;
                    $response['alert_outer'] = $this->alert('Service Has Not Updated', 'danger');
                } else {
                    $reading->db->transCommit();
                    $response['success'] = true;
                    $response['alert_outer'] = $this->alert('Service Has Been Updated', 'success');
                }
                // $response['alert_outer'] = $this->alert('Service Has Been Updated.', 'success');
            }


        echo json_encode($response);
    }
    public function create_reading()
    {
        $reading = new ReadingModel();

        $response = array();
        $response['success'] = false;

        if (empty($_POST['ap_id']))
            $response['alert_inner'] = $this->alert('Choose Apartment', 'danger');
        else if (empty($_POST['meter_id']))
            $response['alert_inner'] = $this->alert('Choose meter', 'danger');
        else if (empty($_POST['current']))
            $response['alert_inner'] = $this->alert('Enter current reading', 'danger');
        else if (empty($_POST['rate_id']))
            $response['alert_inner'] = $this->alert('Choose rate', 'danger');
        else
            if ($_POST['btn_action'] == "btn_add") {

                $month = date('F', strtotime($_POST['reading_date']));
                $prev = $this->request->getPost('prev') ?? '';
                $current = $this->request->getPost('current') ?? '';
                $rate_id = $this->request->getPost('rate_id');
                $rate = $reading->db->query("SELECT * from tbl_rates where rate_id=$rate_id")->getRow()->rate_value??0;
                $data = [
                    'prev' => $this->request->getPost('prev'),
                    'current' => $this->request->getPost('current'),
                    'diff' => $this->request->getPost('diff'),
                    'rate_id' => $this->request->getPost('rate_id'),
                    'total' => $this->request->getPost('total'),
                    'profile_no' => '',
                    'meter_id' => $this->request->getPost('meter_id'),
                    'reading_date' => $this->request->getPost('reading_date'),
                    'read_month' => $month

                ];
                $reading->store('tbl_reading', $data);

                ## record bills ##
                $custname = $_POST['customer_id'];
                $cid = $reading->db->query("SELECT * from tbl_customers where cust_name='$custname'")->getRow()->customer_id ?? '';
                $completed = $reading->record_utility_bill($cid, $_POST['reading_date'], $_POST['ap_id'], $_POST['total'], $_POST['month'], $_POST['meter_id'], $prev, $current,$rate);

                if (!$completed) {
                    $response['success'] = false;
                    $response['alert_outer'] = $this->alert('Reading Has Been Added', 'danger');
                } else {
                    $response['success'] = true;
                    $response['alert_outer'] = $this->alert('Reading Has Been Added', 'success');
                }
            } else if ($_POST['btn_action'] == "btn_edit") {

                $data = [
                    'reading_id' => $this->request->getPost('reading_id'),
                    'prev' => $this->request->getPost('prev'),
                    'current' => $this->request->getPost('current'),
                    'diff' => $this->request->getPost('diff'),
                    'rate_id' => $this->request->getPost('rate_id'),
                    'total' => $this->request->getPost('total'),
                    'profile_no' => '',
                    'meter_id' => $this->request->getPost('meter_id'),
                ];
                $response['success'] = $reading->update_table('tbl_reading', $data);
                $response['alert_outer'] = $this->alert('Reading Has Been Updated.', 'success');
            }


        echo json_encode($response);
    }


    public function create_charge_services()
    {
        $reading = new ReadingModel();

        $response = array();
        $response['success'] = false;

        if (empty($_POST['ap_id']))
            $response['alert_inner'] = $this->alert('Choose Apartment', 'danger');
        else if (empty($_POST['service_id']))
            $response['alert_inner'] = $this->alert('Choose meter', 'danger');
        else if (empty($_POST['price']))
            $response['alert_inner'] = $this->alert('Enter current reading', 'danger');
        else if (empty($_POST['qty']))
            $response['alert_inner'] = $this->alert('Choose rate', 'danger');
        else if (empty($_POST['total']))
            $response['alert_inner'] = $this->alert('Choose rate', 'danger');
        else
            if ($_POST['btn_action'] == "btn_add") {

                // $month = date('F', strtotime(date()));
                $site_id = $_POST['site_id'];
                $ap_id = $_POST['ap_id'];
                $service_id = $_POST['service_id'];
                $qty = $_POST['qty'];
                $price = $_POST['price'];
                $total = $_POST['total'];
                $month = $_POST['month'];
                $custname = $_POST['customer_id'];

                $cid = $reading->db->query("SELECT * from tbl_customers where cust_name='$custname'")->getRow()->customer_id ?? '';

                $data = [
                    'tenant_id' => $cid,
                    'service_id' => $service_id,
                    'qty' => $qty,
                    'total' => $total,
                    'month' => $month,
                    'price' => $price,
                    'date' => date('Y-m-d H:i:s')
                ];
                $reading->store('service_charge', $data);

                ## record bills #
                $completed = $reading->record_service_bill($cid, date('Y-m-d H:i:s'), $ap_id, $total, $month, $service_id);

                if (!$completed) {
                    $response['success'] = false;
                    $response['alert_outer'] = $this->alert('Service Has Not Added', 'danger');
                } else {
                    $response['success'] = true;
                    $response['alert_outer'] = $this->alert('Service Has Been Added', 'success');
                }
            } else if ($_POST['btn_action'] == "btn_edit") {

                $data = [
                    'reading_id' => $this->request->getPost('reading_id'),
                    'prev' => $this->request->getPost('prev'),
                    'current' => $this->request->getPost('current'),
                    'diff' => $this->request->getPost('diff'),
                    'rate_id' => $this->request->getPost('rate_id'),
                    'total' => $this->request->getPost('total'),
                    'profile_no' => '',
                    'meter_id' => $this->request->getPost('meter_id'),
                ];
                $response['success'] = $reading->update_table('tbl_reading', $data);
                $response['alert_outer'] = $this->alert('Reading Has Been Updated.', 'success');
            }


        echo json_encode($response);
    }
    public function fill_meters()
    {
        $reading = new ReadingModel();

        $apid = $this->request->getPost('ap_id');
        $meters = $reading->get_meters_by_home($apid);
        $custname = $reading->get_tenant_name($apid)->name ?? 'No Tenant';
        $output = '<option value="">Select Meter</option>';
        foreach ($meters as $meter) {
            $output .= '<option value="' . $meter['meter_id'] . '">' . $meter['meter_name'] . '</option>';
        }
        return json_encode(['meters' => $output, 'cust' => $custname]);
    }

    // get prev reading by meter id
    public function get_prev_reading()
    {
        $reading = new ReadingModel();

        $mid = $this->request->getPost('mid');
        $prev = $reading->get_prev_reading($mid);
        echo $prev;
    }

    // getting rate value
    public function get_service_price()
    {
        $reading = new ReadingModel();

        $rid = $this->request->getPost('s_id');
        $val = $reading->get_service_price($rid);
        echo json_encode(["price" => $val]);
    }
    public function get_rate_value()
    {
        $reading = new ReadingModel();

        $rid = $this->request->getPost('rid');
        $val = $reading->get_rate_value($rid);
        echo $val;
    }
}
