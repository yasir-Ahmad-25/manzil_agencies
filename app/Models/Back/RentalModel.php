<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class RentalModel extends Model
{

    protected $database_table = 'tbl_apartments'; // Table name
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
 
    public function get_rental_info($selected_site , $branch_id)
    { 
        if($branch_id !== 1){ /// if it's not superAdmin 
            return $this->fetchBasedOnSelectedSite($selected_site , $branch_id);
        }else{
            $sql = "SELECT rental_id, cu.customer_id,rental_status,duration, cust_name,r.profile_no, ap.ap_id, 
                ap_no,ap.price, start_date, end_date, rental_date, deposit, s.site_address,s.site_name FROM tbl_rentals r
                JOIN tbl_apartments ap ON r.ap_id=ap.ap_id
        
                JOIN tbl_floors fl ON fl.floor_id=ap.floor_id
        
                JOIN tbl_sites s ON s.site_id=fl.site_id

                JOIN tbl_customers cu ON r.customer_id=cu.customer_id
                WHERE r.rental_status = 'Active' ORDER BY rental_id DESC";

            $query = $this->db->query($sql);
            return $query->getResultArray();

        }
            
    }

    public function fetchBasedOnSelectedSite($selected_site , $branch){
        if($selected_site !== "All_Sites"){ // if he didn't select All sites fetch data based on selected site
            $sql = "SELECT rental_id, cu.customer_id,rental_status,duration, cust_name,r.profile_no, ap.ap_id, 
                    ap_no,ap.price, start_date, end_date, rental_date, deposit, s.site_address,s.site_name FROM tbl_rentals r
                    JOIN tbl_apartments ap ON r.ap_id=ap.ap_id
            
                    JOIN tbl_floors fl ON fl.floor_id=ap.floor_id
            
                    JOIN tbl_sites s ON s.site_id=fl.site_id

                    JOIN tbl_customers cu ON r.customer_id=cu.customer_id
                    WHERE r.rental_status = 'Active'  AND s.site_id = '$selected_site' AND r.branch_id = $branch ORDER BY rental_id DESC";
                    
                    
        }else{
            $sql = "SELECT rental_id, cu.customer_id,rental_status,duration, cust_name,r.profile_no, ap.ap_id, 
                ap_no,ap.price, start_date, end_date, rental_date, deposit, s.site_address,s.site_name FROM tbl_rentals r
                JOIN tbl_apartments ap ON r.ap_id=ap.ap_id
        
                JOIN tbl_floors fl ON fl.floor_id=ap.floor_id
        
                JOIN tbl_sites s ON s.site_id=fl.site_id

                JOIN tbl_customers cu ON r.customer_id=cu.customer_id
                WHERE r.rental_status = 'Active' AND r.branch_id = $branch ORDER BY rental_id DESC";
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
        // getting active apartments based on branch
        $branch_id = session()->get('user')['branch_id'];
        $builder = $this->db->table($this->database_table); // Ensures the correct table

        if ($branch_id !== 1) {
            $builder->where('ap_status', 'Active')
                    ->where('branch_id', $branch_id)
                    ->orderBy('ap_id', 'ASC');
        } else {
            $builder->where('ap_status', 'Active')
                    ->orderBy('ap_id', 'ASC');
        }

        // Check the query if needed for debugging
        // echo $this->db->getLastQuery(); // Uncomment to check the last query

        $query = $builder->get();
        return $query->getResultArray(); // Return result as array
    }

    public function getAvailableSites(){
        $branch_id = (int) session()->get('user')['branch_id']; 
        if($branch_id !== 1){
            $sql = 'SELECT * FROM tbl_sites WHERE No_of_Floors > 0 AND branch_id ='.$branch_id;
            $query = $this->db->query($sql);
            return $query->getResultArray();
        }else{
            $sql = 'SELECT * FROM tbl_sites WHERE No_of_Floors > 0';
            $query = $this->db->query($sql);
            return $query->getResultArray();
        }
    }
    

    public function get_apartment_price($apid)
    {
        $apart = $this->db->query("SELECT price FROM tbl_apartments WHERE ap_id='$apid'");
        return $apart->getRow()->price;
    }
    public function get_apartments_site_owner($apid)
    {
        $getSite_id = $this->db->query("SELECT site_id FROM tbl_apartments WHERE ap_id='$apid'");

        // $getSite_ownerid = $this->db->query("SELECT owner_id FROM tbl_sites WHERE site_id=$getSite_id");
        return $getSite_id->getRow()->site_id;
    }

    public function apartment_exist($apid, $cid): bool
    {

        $sql = "SELECT * FROM tbl_rentals where ap_id='$apid' and customer_id='$cid' and rental_status='Active'";
        return $this->db->query($sql)->getNumRows() > 0;
    }


    public function create_rental($apid,$ownerId,$data, $price, $acc_cash, $acc_dep)
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

        ## record bill that he paid for the first time ##
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
        // account cash = which account does he send the money to is it cash,wallet or merchant
        // source = the money we received or saving it what is it ? like is it for renting that stands for Bill or it's for something else
        // customer-id = the customer that paid the money
        // price = the price customer payed or send 
        // INC stands for income
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
            'branch_id' => session()->get('user')['branch_id'],
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

        $fpid = $finance->financial_period()['fp_id']; // getting the financial period id [ soo hel xisaab xirka sanadlaha ]

        // create summary of the transaction that occured and get the id
        // trx_amount = transaction ka dhacay meeqay ahayd lacagta
        // trx_source = xagee ka timid lacagta ama transaction ka dhacaaya [ HADDA WAANA-QAANAA OO WAA KIRO ]
        // fp_id = id ga xisaab xirka sanadlaha
        $trx_id = $finance->record_trans($amount, $source, $fpid, $date, $customer_id);

        // account cash = which account does he send the money to is it cash,wallet or merchant
        $dracc = $acc_cash; // we are storing this to debit-account since i rent an apartment and i collected a money 
        $cracc = $finance->get_account_tag($cr_tag)['account_id'];

        // save the details of the transactions that occur
        $finance->dr_trx_det((float) $amount, $dracc, $trx_id);
        $finance->cr_trx_det((float) $amount, $cracc, $trx_id);

        // update my account's balance
        $finance->update_accounnt_balance($dracc, (float) $amount, 'dr');
        $finance->update_accounnt_balance($cracc, (float) $amount, 'cr');

        return $trx_id;
    }
}
