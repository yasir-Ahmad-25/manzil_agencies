<?php

namespace App\Models\Back;
use CodeIgniter\Model;

class DashboardModel extends Model
{
    public function get_table_data($table)
    { 

        $query = $this->db->query("SELECT * FROM $table WHERE 1");

        return $query->getNumRows();
    }
    public function get_total_tenants(){
        return $this->db->query("SELECT count(*) as total_tenants from tbl_customers where cust_status='Active'")->getRow();
    }
    public function get_avialable_units(){
        return $this->db->query("SELECT count(*) as totals from tbl_apartments where ap_status != 'Occupied' and ap_status != 'Deleted'")->getRow();
    }

    public function get_income_exp($table, $tag)
    {
        // $profile = $this->session->userdata("profile")['profile_no'];
        $query = $this->db->query("SELECT acc_balance FROM $table WHERE acc_tag='$tag'");
        return $query->getRow()->acc_balance ?? 0;
    }
    public function get_daily_expenses()
    {
        //$pno = $this->session->userdata("profile")['profile_no'];
        // $query = $this->db->query("SELECT sum(acc_balance) total FROM tbl_cl_accounts acc
        // JOIN tbl_cl_account_groups grp ON grp.acc_grp_id=acc.acc_grp_id WHERE grp.acc_grp_name='Expenses'");

        $exp = $this->db->query("SELECT sum(exp_cost) total FROM tbl_expenses WHERE exp_date = CURDATE() ")->getRow()->total ?? 0;
        $inv = $this->db->query("SELECT sum(amount) total FROM tbl_supplier_invoices WHERE inv_date =CURDATE() ")->getRow()->total ?? 0;

        return ($exp + $inv);
    }

    public function get_monthly_expenses()
    {

        $exp = $this->db->query("SELECT sum(exp_cost) total FROM tbl_expenses WHERE exp_date >= CURDATE() - INTERVAL 30 DAY")->getRow()->total ?? 0;
        $inv = $this->db->query("SELECT sum(amount) total FROM `tbl_supplier_invoices` WHERE inv_date >= CURDATE() - INTERVAL 30 DAY")->getRow()->total ?? 0;

        return ($exp + $inv);
    }

    public function get_booking_count($st)
    {
        //  bookings 
        $brid = session()->get('user')['branch_id'];
        $booking = $this->db->query("SELECT COUNT(booking_id) book_count FROM tbl_hall_booking WHERE booking_status='$st' and branch_id='$brid'")->getRow()->book_count ?? 0;
        return ($booking);
    }

    public function get_pos_income()
    {
        $brid = session()->get('user')['branch_id'];
        $date = date('Y-m-d');
        $charges = $this->db->query("SELECT SUM(price * qty) total FROM tbl_order_details dt JOIN tbl_orders b ON dt.order_id=b.order_id
        WHERE b.order_date='$date' and b.status='Completed' and branch_id='$brid'")->getRow()->total ?? 0;
        return ($charges);
    }

    public function total_cash()
    {
        $query = $this->db->query("SELECT sum(acc_balance) total FROM tbl_cl_accounts acc JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id
        WHERE tp.acc_type_tag='CB'");
        return $query->getRow()->total;
    }

    public function get_cash_accounts()
    {

        $query = $this->db->query("SELECT acc_balance, acc_name FROM tbl_cl_accounts acc JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id
        WHERE tp.acc_type_tag='CB'");
        return $query->getResultArray();
    }

    public function get_pos_income_monthly()
    {
        //  bookings 
        $brid = session()->get('user')['branch_id'];
        $charges = $this->db->query("SELECT SUM(price * qty) total FROM tbl_order_details dt JOIN tbl_orders b ON dt.order_id=b.order_id
        WHERE b.status='Completed' and branch_id='$brid' AND order_date >= CURDATE() - INTERVAL 30 DAY")->getRow()->total ?? 0;
        return $charges;
    }

    public function get_bookings()
    {
        //  bookings 
        $booking = $this->db->query("SELECT count(booking_id) cnt FROM `tbl_hall_booking`")->getRow()->cnt;
        return $booking;
    }


    public function getNumberOf_Unpaid_People()
    {
        //  bookings 
        $unpaid = $this->db->query("SELECT COUNT(rs.id) as Total_Unpaid_People from tbl_rental_summary rs join tbl_customers cu on cu.customer_id=rs.tenant_id where paid =0 AND rs.branch_id = 1 order by rs.id desc;")->getRow()->Total_Unpaid_People;
        return $unpaid;
    }

    public function get_rentings()
    {
        $renting = $this->db->query("SELECT count(rent_id) cnt FROM `tbl_rent_booking`")->getRow()->cnt;
        return $renting;
    }


    public function get_total_receivables()
    {
        $brid = session()->get('user')['branch_id'];

        $query = $this->db->query("SELECT sum(acc_balance) total FROM tbl_cl_accounts acc
         JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id join tbl_customers cu on cu.customer_id=acc.acc_tag
         WHERE tp.acc_type_tag='AR' and cu.branch_id='$brid' and acc.acc_set='Customer'");
        return $query->getRow()->total;
    }

    public function get_total_payables()
    {
        $brid = session()->get('user')['branch_id'];
        // $total = $this->db->query("SELECT SUM(balance) total FROM tbl_supplier_invoices inv 
        // join tbl_suppliers sp on sp.sup_id=inv.sup_id WHERE sp.branch_id='$brid' ")->getRow()->total;
        $query = $this->db->query("SELECT sum(acc_balance) total FROM tbl_cl_accounts acc
        JOIN tbl_cl_account_types tp ON tp.acc_type_id=acc.acc_type_id join tbl_suppliers cu on cu.sup_id=acc.acc_tag
        WHERE tp.acc_type_tag='EXP' and cu.branch_id='$brid' and acc.acc_set='Customer'");
       return $query->getRow()->total;
        return $total;
    }

    public function get_order_counts($status)
    {
        $order = $this->db->query("SELECT count(id) cnt FROM tbl_baskets WHERE basket_status='$status'")->getRow()->cnt;
        return $order;
    }

    public function get_monthly_revenue()
    {
        $sql = "SELECT SUM(total) + SUM(total_charges) as ttl FROM `tbl_hall_booking`
                WHERE year(booking_date) = '2024' GROUP BY month(booking_date)";

        $array = $this->db->query($sql)->getResultArray();
        $revenues = [];
        foreach ($array as $arr) {

            $revenues[] = $arr['ttl'];
        }

        return $revenues;
    }

    public function get_all_Unpaid_bills()
    {
        
        $branch_id = session()->get('user')['branch_id'];
        $sql = "SELECT COUNT(rs.id) as Total, rs.*,cu.cust_name, rs.tenant_id as customer_id from tbl_rental_summary rs join tbl_customers cu on cu.customer_id=rs.tenant_id where paid =0  AND rs.branch_id = $branch_id order by rs.id desc";
        $query = $this->db->query($sql);
        return $query->getResultArray();    
    }

}
