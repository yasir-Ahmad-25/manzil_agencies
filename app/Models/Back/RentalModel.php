<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class RentalModel extends Model
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
 
    public function get_rental_info($selected_site)
    {

        if($selected_site !== "All_Sites"){
            $sql = "SELECT rental_id, cu.customer_id,rental_status,duration, cust_name,r.profile_no, ap.ap_id, 
                    ap_no,ap.price, start_date, end_date, rental_date, deposit, s.site_address,s.site_name FROM tbl_rentals r
                    JOIN tbl_apartments ap ON r.ap_id=ap.ap_id
            
                    JOIN tbl_floors fl ON fl.floor_id=ap.floor_id
            
                    JOIN tbl_sites s ON s.site_id=fl.site_id

                    JOIN tbl_customers cu ON r.customer_id=cu.customer_id
                    WHERE r.rental_status = 'Active'  AND s.site_id = '$selected_site' ORDER BY rental_id DESC";
                    
                    
        }else{
            $sql = "SELECT rental_id, cu.customer_id,rental_status,duration, cust_name,r.profile_no, ap.ap_id, 
                ap_no,ap.price, start_date, end_date, rental_date, deposit, s.site_address,s.site_name FROM tbl_rentals r
                JOIN tbl_apartments ap ON r.ap_id=ap.ap_id
        
                JOIN tbl_floors fl ON fl.floor_id=ap.floor_id
        
                JOIN tbl_sites s ON s.site_id=fl.site_id

                JOIN tbl_customers cu ON r.customer_id=cu.customer_id
                WHERE r.rental_status = 'Active' ORDER BY rental_id DESC";
        }

        $query = $this->db->query($sql);
        return $query->getResultArray();    
    }

    public function get_closed_rentals()
    {
        $sql = "SELECT rental_id, ten.customer_id,rental_status,duration, cust_name,r.profile_no, ap.ap_id, 
                ap_no,ap.price, start_date, end_date, rental_date, deposit, s.site_address,s.site_name FROM tbl_rentals r
                JOIN tbl_apartments ap ON r.ap_id=ap.ap_id
                JOIN tbl_floors fl ON fl.floor_id=ap.floor_id
                JOIN tbl_sites s ON s.site_id=fl.site_id
                JOIN tbl_customers ten ON r.customer_id=ten.customer_id
                WHERE rental_status='Closed' ORDER BY rental_id DESC";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function get_active_apartments()
    {

        $sql = "SELECT * FROM tbl_apartments 
                WHERE ap_status = 'Active' ORDER BY ap_id ASC";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getAvailableSites(){
        $sql = 'SELECT * FROM tbl_sites WHERE No_of_Floors > 0';
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_apartment_price($apid)
    {
        $apart = $this->db->query("SELECT price FROM tbl_apartments WHERE ap_id='$apid'");
        echo $apart->getRow()->price;
    }

    public function apartment_exist($apid, $cid): bool
    {

        $sql = "SELECT * FROM tbl_rentals where ap_id='$apid' and customer_id='$cid' and rental_status='Active'";
        return $this->db->query($sql)->getNumRows() > 0;
    }


    public function create_rental($apid,$data, $price, $acc_cash, $acc_dep)
    {
        $this->db->transStart();
        $this->db->transException(true);
        
        // save posted data to db [tbl_rentals] and store the last insertion id to this variable
        $rentid = $this->store('tbl_rentals', $data); 

        // fetch passed data 
        $apid = $data['ap_id'];
        $rentalDate = $data['rental_date'];
        $customer_id = $data['customer_id'];
        $depositMoney = $data['deposit'];

        ## change apertment status
        $this->db->query("UPDATE tbl_apartments SET ap_status='Occupied' WHERE ap_id='$apid'");

        ## record bill ##
        $rental_id = $this->record_rental_bill($apid, $rentalDate, $customer_id, $rentid, $price, $acc_cash);

        ## record deposit ##

        // $price : refers to the price/month of the apartment
        $this->record_rental_deposit($price,$rental_id, $apid,$customer_id, $depositMoney, $rentalDate, $acc_dep);

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function record_rental_bill($apid,$date, $customer_id, $rentid, $price, $acc_cash)
    {
        $this->record_transaction($price, 'Bill', 'INC', $acc_cash, $date, $customer_id);
        $date2 = new \DateTime($date);
        $month = $date2->format('m');
        $data = [
            'rental_id' => $rentid,
            'tenant_id' => $customer_id,
            'total' => $price,
            'paid' => $price,
            'month' => $month,
            'created_date' => $date,
            'apartment_id' => $apid,
        ];

        // if ($dur_days <= 30) {
        //     $data['bill_due_date'] = date('Y-m-d', strtotime($date . '+' . $dur_days . ' days'));
        // } else {
        //     $data['bill_due_date'] = date('Y-m-d', strtotime($date . '+30 days'));
        // }

        return $this->store('tbl_rental_summary', $data);
    }

    public function record_rental_deposit($rental_amount,$rental_id, $ap_id,$customer_id, $deposit, $date, $acc_dep)
    {
        $finance = new FinancialModel();

        if ($deposit) {

            $data = [
                'customer_id' => $customer_id,
                'profile_no' => 'not-settled-yet',
                'amount' => $deposit,
                'amount_bal' => $deposit,
                'account_id' => $acc_dep,
                'des' => '',
            ];

            // save data to the database tbl_deposit
            $this->store('tbl_deposit', $data);
            
            $date2 = new \DateTime($date);
            $month = $date2->format('m');
            $ri = $this->rental_income_exists($month, $customer_id, $rental_id);
            $ap_id =$this->db->query("SELECT ap_id from tbl_rentals where rental_id=$rental_id")->getRow()->ap_id ??0 ;
            if ($ri == 0) {
             
                $ridata = [
                    'rental_id'=>$rental_id,
                    'tenant_id'=>$customer_id,
                    'ap_id'=>$ap_id,
                    'rent_amount'=>$rental_amount,
                    'paid_amount'=>$rental_amount,
                    'deposit_amount'=>$deposit,
                    'month'=>$month,
                 ];
                 $this->store('rental_income_report', $ridata);
             }else{
                 $this->db->query("UPDATE rental_income_report set deposit_amount=$deposit,rental_id=$rental_id, tenant_id=$customer_id, month=$month where id=$ri ");
             }
            ## start transaction ###

            $fpid = $finance->financial_period()['fp_id'];
            $trx_id = $finance->record_trans($deposit, 'Deposit', $fpid, $date, $customer_id);

            $dracc = $acc_dep;
            $cracc = $finance->get_account_tag('DP')['account_id'];

            $finance->dr_trx_det((float) $deposit, $dracc, $trx_id);
            $finance->cr_trx_det((float) $deposit, $cracc, $trx_id);

            $finance->update_accounnt_balance($dracc, (float) $deposit, 'dr');
            $finance->update_accounnt_balance($cracc, (float) $deposit, 'cr');
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
    public function record_transaction($amount, $source, $cr_tag, $acc_cash, $date, $customer_id): string
    {
        $finance = new FinancialModel();

        $fpid = $finance->financial_period()['fp_id'];

        $trx_id = $finance->record_trans($amount, $source, $fpid, $date, $customer_id);

        $dracc = $acc_cash;
        $cracc = $finance->get_account_tag($cr_tag)['account_id'];

        $finance->dr_trx_det((float) $amount, $dracc, $trx_id);
        $finance->cr_trx_det((float) $amount, $cracc, $trx_id);

        $finance->update_accounnt_balance($dracc, (float) $amount, 'dr');
        $finance->update_accounnt_balance($cracc, (float) $amount, 'cr');

        return $trx_id;
    }
}
