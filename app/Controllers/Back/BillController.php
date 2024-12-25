<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Models\Back\BillModel;
use App\Models\Back\FinancialModel;
use CodeIgniter\Database\Database;
use DateTime;

class BillController extends BaseController
{
    function list()
    {
        $auth = new AuthModel();

        $this->viewData['title'] = 'Bills';
        $this->viewData['sites'] = $this->get_table_info('tbl_sites');
        $this->viewData['accounts'] = $this->get_cash_bank_accounts();
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());

        return view('admin/rental/bills', $this->viewData);
    }
 

    function charges()
    {
        $auth = new AuthModel();
    

        $this->viewData['title'] = 'Bill charges';
        $this->viewData['accounts'] = $this->get_cash_bank_accounts();
        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'), $this->request->getLocale());
        return view('admin/rental/charges', $this->viewData);
    }

    public function invoice_print($num)
    {

        $mpdf = new \Mpdf\Mpdf();
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
            12 => 'December'  
        ];  
        
        $this->viewData['title'] = 'invoice page';
        $model = new BillModel();
        // $auth = new AuthModel();
        $summary_data = $model->get_print_bills($num);
        $this->viewData['bill_month'] = $months[$summary_data->month];
        // $order_type = substr($invoice_data->orderId, 0, 1); // Get the first character
        // $order_id = substr($invoice_data->orderId, 1);    // Get the number part
        // dd($order_type, $order_id);
        if($summary_data->bill_type == 0){
            $bills = [[

                'source'=>"Rent",
                'bill_date'=>$summary_data->created_date,
                'amount'=>$summary_data->total
                ]
            ];
        }else{
            $ri = $summary_data->id;
            $b = $model->db->query("SELECT * from tbl_rental_bills where bill_summary_id=$ri")->getResultArray();
            $bills = [];
            foreach($b as $bi){
                $prev = $bi['previous_reading']??0;
                $curr = $bi['current_reading']??0;
                $read_date = $bi['reading_rate']??0;
                $data = [
                    'source'=>$bi['bill_source'],
                    'bill_date'=>$bi['bill_date'],
                    'previous_reading'=>$prev,
                    'current_reading'=>$curr,
                    'usage'=>$curr-$prev,
                    'reading_rate'=>$read_date,
                    'amount'=>$bi['Amount']
                ];
                array_push($bills, $data);
            }
        }
        $this->viewData['paid_amount'] = $summary_data->paid;
        $this->viewData['bill_type'] = $summary_data->bill_type;
        $this->viewData['bills'] = $bills;
        $this->viewData['data'] = $summary_data;
        $html = view('admin/bill_print', $this->viewData);
        // $passe = (isset($this->viewData['passengers'])) ? $this->viewData['passengers'] : [];
        
        // foreach ($passe as $pass) {
        //     if (isset($pass['payment_type'])) {

        //         if ($pass['payment_type'] == 'Murabaha') {
        //             $html = view('custom e r/invoice_murabaha', $this->viewData);
  
        //         } else {
        //             $html = view('customer/invoice_print', $this->viewData);
        //         }
        //     }
        // }
  
        // if ($order_type == 'V') {  
        //     $this->viewData['passengers'] = null;
        //     $html = view('customer/invoice_visa', $this->viewData);
        // }
        $mpdf->WriteHTML($html);
        $filePath = $summary_data->cust_name . "_invoice.pdf";
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->SetDisplayMode('fullpage');
        $this->response->setContentType('application/pdf');
        $mpdf->Output($filePath, \Mpdf\Output\Destination::INLINE);

    }
    public function fetch_bills($status)
    {
        $bill = new BillModel();

        $result = array('data' => array());

        $data = $bill->get_all_bills($status);
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
            $cancel = ((($value["total"]+$value['discount']) - $value['paid']) > 0) ? '' : 'hidden';
            $pay = ( (( $value["total"]+$value['discount']) - $value['paid']) > 0) ? '' : 'hidden';
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
                $value['created_date'],
                $details,
                $buttons,
            );
            $i++;
        } // /foreach
        // print_r($result);
        echo json_encode($result);
    }
    function print_bill()
    {
        $sid = $_POST['sid'];
        $billing = new BillModel();

        $daily_test_det = $billing->get_billing_details($sid);

        $i = 0;
        $response = '';
        foreach ($daily_test_det as $val) {
            $i++;
            $response .= '
             <tr>
             <td>' .$i. '</td> 
             <td>' . $val["bill_source"] . '</td> 
             <td>' . '$' . $val["Amount"] . '</td>
             </tr>
             ';
        }

        echo json_encode($response);
    }
    public function fetch_charging_tenants()
    {
        $bill = new BillModel();
        $result = array('data' => array());
        $i = 1;
        $arr = [];
        $data = $bill->get_chargable_bills();

        foreach ($data as $val) {
            if ($val['bill_due_date'] <= date('Y-m-d'))
                $arr[] = $val['rental_id'];
        }

        $str = implode(',', $arr);

        if ($arr != []) {

            $tenants = $bill->get_chargable_tenants($str);

            foreach ($tenants as $key => $ten) {

                $date1 = new DateTime(date('Y-m-d'));
                $date2 = new DateTime($ten['end_date']);

                $interval = $date2->diff($date1);
                $dt = $interval->d . " days ";

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


                $buttons = $btn['header'] . '
                            <a type="button" id="btn_edit" data-end_date="' . $ten["end_date"] . '"
                                data-ten_id="' . $ten["customer_id"] . '" data-ten_name="' . $ten["cust_name"] . '"
                                data-ap_no="' . $ten["ap_no"] . '" data-price="' . $ten["price"] . '" 
                                data-rental_id="' . $ten["rental_id"] . '"
                                data-owner_id="' . $ten["owner_id"] . '"
                                data-bs-target="#invoice_modal" class="dropdown-item" data-bs-toggle="modal" >
                                <i class="fas fa-edit text-info mx-1"></i> Raise Invoice
                            </a>
                        
                    </div>
                    </div>
            </div>';

                $result['data'][$key] = array(
                    $i,
                    $ten['cust_name'],
                    $ten['ap_no'],
                    $ten['price'],
                    $ten['end_date'],
                    $dt,
                    $buttons,
                );
                $i++;
            } // /foreach
        }
        echo json_encode($result);
    }

    public function raise_rent_invoice()
    {
        $response = array();
        $response['success'] = true;
        $bill = new BillModel();

        $rentid = $_POST['rental_id'];
        $owner_id = $_POST['owner_id'];
        $price = $_POST['inv_price'];
        $end_date = $_POST['inv_date'];
        $tenid = $_POST['ten_id'];
        $bill_type = 'rent';

        $bill->record_rental_bill($owner_id,$tenid, $rentid, $price, $end_date, $bill_type);

        $response['alert_outer'] = $this->alert('Bill has been Raised', 'success');

        echo json_encode($response);
    }

    ## BILL PAYMENT ## 
    public function record_receipt()
    {
        $bill = new BillModel();

        $response = array();
        $response['success'] = true;

        $bill_id = $_POST['bill_id'];
        $amount = $_POST['pay_amount'];
        $date = $_POST['date'];
        $dis = $_POST['discount'];

        $tenid = $_POST['ten_id'];
        $bill_type = $_POST['bill_type'];

        # record  receipt transactions
        $trx_id = $bill->record_transaction($amount, 'Receipt', $_POST['account_id'], $tenid, $dis);

        # update bill status
        $bill->update_bill($amount, $dis, $date, $trx_id, $bill_id,$bill_type);

        $response['success'] = true;
        $response['alert_inner'] = $this->alert('Bill Paid Successfully', 'success');

        echo json_encode($response);
    }

    ## CANCEL PAYMENT ##
    public function cancel_receipt()
    {
        $db = db_connect();

        $response = array();
        $response['success'] = true;

        $bill_id = $_POST['cancel_bill_id'];
        $amount = $_POST['cancel_amount'];
        $ten_id = $_POST['cancel_ten_id'];
        $trx_id = $_POST['trx_id'];
        $dis = $_POST['cancel_dis'];

        $amt = $amount + $dis;

        # update bill status
        $db->query("UPDATE tbl_rental_bills SET bill_status='UNPAID', total=$amt, balance=$amt, discount=0, rec_trx_id='' WHERE bill_id='$bill_id'");

        # update tenant balance 
        // $db->query("UPDATE tbl_tenants SET balance=balance+$amt WHERE ten_id=$ten_id");

        # record  receipt transactions
        $this->redo_account_trx($trx_id, $dis);

        $response['success'] = true;
        $response['alert_inner'] = $this->alert('Payment cancelled', 'success');

        echo json_encode($response);
    }

    public function redo_account_trx($trx_id, $dis)
    {
        $finance = new FinancialModel();
        $db = db_connect();

        $trx_details = $finance->get_trx_details($trx_id);

        foreach ($trx_details as $trx_detail) {

            $account_id = $trx_detail['account_id'];
            $tr_amt = ($trx_detail['dr_amount'] + $trx_detail['cr_amount']);

            $type = $this->get_account_nature($account_id);

            if ($type == 'AR') {
                $db->query("UPDATE tbl_cl_accounts SET acc_balance = acc_balance+($tr_amt+$dis) WHERE account_id='$account_id'");
            } else {
                $db->query("UPDATE tbl_cl_accounts SET acc_balance = acc_balance-$tr_amt WHERE account_id='$account_id'");
            }
        }

        $db->query("delete from tbl_cl_trans_details where trx_id='$trx_id'");
        $db->query("delete from tbl_cl_transections where trx_id='$trx_id'");
    }
    public function get_account_nature($account_id)
    {
        $db = db_connect();

        $account = $db->query("SELECT acc_type_tag FROM tbl_cl_accounts acc 
                JOIN tbl_cl_account_types actp ON actp.acc_type_id=acc.acc_type_id WHERE account_id='$account_id'");
        return $account->getRow()->acc_type_tag;
    }
}
