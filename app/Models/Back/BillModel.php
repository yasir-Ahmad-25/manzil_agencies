<?php

namespace App\Models\Back;

use App\Models\Back\FinancialModel;
use CodeIgniter\Model;

class BillModel extends Model
{
    public function store($table, $data)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    public function update_table($table, $data)
    {
        $this->db->table($table)->upsertBatch($data);
        return true;
    }
    public function get_print_bills($summary_id)
    {
        $sql = "SELECT rs.*,cu.cust_name, cu.cust_tell, cu.cust_email from tbl_rental_summary rs join tbl_customers cu on cu.customer_id=rs.tenant_id where rs.id=$summary_id";
        $query = $this->db->query($sql);
        return $query->getRow();
    }
    public function get_all_bills($status)
    {
        // if ($status == 'all') $st = '';
        // else $st = " WHERE bill_status='$status' ";
        // $details = ($value['rental_id'] != 0) ? "Rental" : '<a href="javascript:void(0)" data-bs-target="#print_inv" data-bill_id="'. $value['id'] .'" class="dropdown-item" data-bs-toggle="modal"><i data-feather="eye" class="feather-icon"></i>Details</a>';

        $sql = "SELECT rs.*,cu.cust_name, rs.tenant_id as customer_id from tbl_rental_summary rs join tbl_customers cu on cu.customer_id=rs.tenant_id order by rs.id desc";
        if($status == 'rent'){
            $sql = "SELECT rs.*,cu.cust_name, rs.tenant_id as customer_id from tbl_rental_summary rs join tbl_customers cu on cu.customer_id=rs.tenant_id where rental_id !=0 order by rs.id desc";
        }elseif($status == 'bill'){
            $sql = "SELECT rs.*,cu.cust_name, rs.tenant_id as customer_id from tbl_rental_summary rs join tbl_customers cu on cu.customer_id=rs.tenant_id where rental_id =0  order by rs.id desc";
        }elseif($status=='unpaid_bill'){
            $sql = "SELECT rs.*,cu.cust_name, rs.tenant_id as customer_id from tbl_rental_summary rs join tbl_customers cu on cu.customer_id=rs.tenant_id where paid =0  order by rs.id desc";
        }elseif($status=='paid_bill'){
            $sql = "SELECT rs.*,cu.cust_name, rs.tenant_id as customer_id from tbl_rental_summary rs join tbl_customers cu on cu.customer_id=rs.tenant_id where total=paid+discount  order by rs.id desc";
        }elseif($status=='partial_bill'){
            $sql = "SELECT rs.*,cu.cust_name, rs.tenant_id as customer_id from tbl_rental_summary rs join tbl_customers cu on cu.customer_id=rs.tenant_id where paid!=0 and total<paid+discount  order by rs.id desc";
        }
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    public function get_billing_details($sid)
    {
        $summary_id = $this->db->query("SELECT * from tbl_rental_summary where id=$sid");
        if ($summary_id->getNumRows() == 0) {
            return [];
        }
        $sid = $summary_id->getRow()->id;
        $sql = "SELECT SUM(Amount) as Amount, bill_source from tbl_rental_bills where bill_summary_id=$sid group by bill_source";

        return $this->db->query($sql)->getResultArray();
    }
 
    public function get_chargable_bills()
    {
        $sql = "SELECT MAX(created_date) as created_date,MAX(created_date) as bill_due_date, rental_id FROM tbl_rental_summary
        GROUP by rental_id ORDER BY created_date DESC";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function get_chargable_tenants($rid)
    {
        $sql = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp_tenant_bills AS (SELECT r.rental_id, r.customer_id, cust_name, r.ap_id, ap_no,ap.price, end_date FROM tbl_rentals r 
                JOIN tbl_customers tn ON tn.customer_id=r.customer_id JOIN tbl_apartments ap ON ap.ap_id=r.ap_id WHERE r.rental_id IN($rid)) ";
        $this->db->query($sql);

        $sql = "select * from tmp_tenant_bills";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }


    public function update_bill($amount, $dis, $date, $trx_id, $bill_id, $bill_type): void
    {

        $this->db->query("UPDATE tbl_rental_summary SET paid=paid + $amount, discount= discount+$dis 
         WHERE id='$bill_id'");

        $sum = $this->db->query("SELECT rental_id, apartment_id, tenant_id from tbl_rental_summary WHERE id='$bill_id'")->getRow();
        $rental_id = $sum->rental_id ?? '';
        $ap_id = $sum->apartment_id ?? '';
        $tenant_id = $sum->tenant_id ?? '';

        $date2 = new \DateTime($date);
        $month = $date2->format('m');
        if ($bill_type != 'bill') {
            $ri = $this->rental_income_exists($month, $tenant_id, $rental_id);
            $ap_id = $this->db->query("SELECT ap_id from tbl_rentals where rental_id=$rental_id")->getRow()->ap_id ?? 0;

            if ($ri == 0) {
                $ridata = [
                    'rental_id' => $rental_id,
                    'tenant_id' => $tenant_id,
                    'ap_id' => $ap_id,
                    'paid_amount' => $amount,
                    'month' => $month,
                ];
                $this->store('rental_income_report', $ridata);
            } else {
                $this->db->query("UPDATE rental_income_report set paid_amount=paid_amount+$amount,rental_id=$rental_id, tenant_id=$tenant_id, month=$month where id=$ri ");
            }
        }
    }

    public function record_rental_bill($tenid, $rentid, $amount, $end_date, $bill_type)
    {
        $finance = new FinancialModel();
        $date = $end_date;
        $discount = 0;
        $source = 'Bill';

        $fpid = $finance->financial_period()['fp_id'];

        $trx_id = $finance->record_trans(($amount + $discount), $source, $fpid, $date, $tenid);

        $dracc = $finance->get_account_tag_set($tenid, 'Customer')['account_id'];
        $cracc = $finance->get_account_tag('INC')['account_id'];

        $finance->dr_trx_det($amount, $dracc, $trx_id);
        $finance->cr_trx_det($amount, $cracc, $trx_id);

        $finance->update_accounnt_balance($dracc, $amount, 'dr');
        $finance->update_accounnt_balance($cracc, $amount + $discount, 'cr');
        $date2 = new \DateTime($end_date);
        $month = $date2->format('m');
        $data = [
            'rental_id' => $rentid,
            'tenant_id' => $tenid,
            'month' => $month,
            'total' => $amount,
            'apartment_id' => ''
        ];
        $this->store('tbl_rental_summary', $data);

        $ri = $this->rental_income_exists($month, $tenid, $rentid);
        $ap_id = $this->db->query("SELECT ap_id from tbl_rentals where rental_id=$rentid")->getRow()->ap_id ?? 0;
        if ($bill_type != 'bill') {
            if ($ri == 0) {
                $ridata = [
                    'rental_id' => $rentid,
                    'tenant_id' => $tenid,
                    'ap_id' => $ap_id,
                    'rent_amount' => $amount,
                    'month' => $month,
                ];
                $this->store('rental_income_report', $ridata);
            } else {
                $this->db->query("UPDATE rental_income_report set rent_amount=$amount,rental_id=$rentid, tenant_id=$tenid, month=$month where id=$ri ");
            }
        }
    }

    public function rental_income_exists($month, $tenant_id, $rental_id)
    {
        $sql = "SELECT * from rental_income_report where month=$month and tenant_id=$tenant_id";
        $res = $this->db->query($sql);
        $num = $res->getNumRows();
        if ($num > 0) {
            if ($res->getRow()->rental_id == 0) {
                $this->db->query("UPDATE rental_income_report set rental_id=$rental_id where month=$month and tenant_id=$tenant_id");
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
    public function record_transaction($amount, $source, $dr_tag, $tenid, $discount = 0)
    {
        $finance = new FinancialModel();
        $date = $_POST['date'];

        $fpid = $finance->financial_period()['fp_id'];

        $trx_id = $finance->record_trans(($amount + $discount), $source, $fpid, $date, $tenid);

        $dracc = $dr_tag;
        $cracc = $finance->get_account_tag_set($tenid, 'Customer')['account_id'];

        $finance->dr_trx_det($amount, $dracc, $trx_id);
        $finance->cr_trx_det($amount, $cracc, $trx_id);

        $finance->update_accounnt_balance($dracc, $amount, 'dr');
        $finance->update_accounnt_balance($cracc, -($amount + $discount), 'cr');

        # if there is discount
        if ((int) $discount > 0) {

            $dracc2 = $finance->get_account_tag('RED')['account_id'];
            $finance->dr_trx_det($discount, $dracc2, $trx_id);
            $finance->update_accounnt_balance($dracc2, $discount, 'dr');
        }

        return $trx_id;
    }
}