<?php

namespace App\Models\Back;

use App\Models\Back\FinancialModel;
use CodeIgniter\Model;

class ReadingModel extends Model
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

    public function get_all_rate()
    {
        $sql = "SELECT * FROM tbl_rates";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_meters()
    {
        $query = $this->db->query("SELECT meter_id, mt.ap_id, meter_name, type, des, ap_no, reg_date, meter_status FROM tbl_meters mt 
        JOIN tbl_apartments ap ON ap.ap_id=mt.ap_id where meter_status != 'Deleted'");
        return $query->getResultArray();
    }


    public function get_apartments()
    {
        $data = $this->db->query("SELECT * FROM tbl_apartments WHERE ap_status='Occupied' ");
        return $data->getResultArray();
    }

    // get rate value by rate id
    public function get_rate_value($rid)
    {
        $data = $this->db->query("SELECT rate_value FROM tbl_rates WHERE rate_id='$rid'");
        return $data->getRow()->rate_value ?? 0;
    }
    public function get_service_price($rid)
    {
        $data = $this->db->query("SELECT price FROM services WHERE id=$rid");
        return $data->getRow()->price ?? 0;
    }
    public function get_rates()
    {
        $data = $this->db->query("SELECT * FROM tbl_rates");
        return $data->getResultArray();
    }


    // get meters data
    public function get_meters_by_home($apid)
    {
        $data = $this->db->query("SELECT * FROM tbl_meters WHERE ap_id='$apid'");
        return $data->getResultArray();
    }
    public function get_tenant_name($apid)
    {
        $data = $this->db->query("SELECT cust_name as name FROM tbl_rentals re join tbl_customers cu on cu.customer_id=re.customer_id  WHERE re.ap_id='$apid'");
        return $data->getRow();
    }

    // ge prev reading by meter id
    public function get_prev_reading($mid)
    {
        $data = $this->db->query("SELECT current FROM tbl_reading WHERE meter_id='$mid' ORDER BY reading_id DESC LIMIT 1");
        return $data->getRow()->current ?? 0;
    }

    public function get_reading()
    {
        $sql = "SELECT reading_id, rd.meter_id, prev, current, diff, rd.rate_id,rate_value, total, mt.meter_name, reading_status, reading_date, read_month
        FROM tbl_reading rd JOIN tbl_meters mt ON mt.meter_id=rd.meter_id
        join tbl_rates rt on rt.rate_id=rd.rate_id ORDER BY reading_id DESC";
        $data = $this->db->query($sql);
        return $data->getResultArray();
    }

    public function get_services()
    {
        $sql = "SELECT * from services ";
        $data = $this->db->query($sql);
        return $data->getResultArray();
    }
    public function get_service_charge()
    {
        $sql = "SELECT * from service_charge sc join tbl_customers cu on cu.customer_id=sc.tenant_id join services s on s.id=sc.service_id ";
        $data = $this->db->query($sql);
        return $data->getResultArray();
    }
    # Record rental bills
    public function record_utility_bill($custid, $date, $apid, $price, $month, $meter_id, $prev = 0, $current = 0, $rate = 0): bool
    {
        $this->db->transStart();
        $this->db->transException(true);
        # record bill transactions
        $trx_id = $this->record_transaction($price, 'Utility Charges', $custid);

        $curr_date = $date;

        $meters = $this->db->query("SELECT * from tbl_meters where meter_id=$meter_id")->getRow()->type ?? 'Utility';

        $sid = $this->get_existing_summary($custid, $month);

        if ($sid == 0) {
            $summary_data = [
                'tenant_id' => $custid,
                'total' => $price,
                'month' => $month,
                'apartment_id' => $apid,
                'bill_type' => 1
            ];
            $this->db->table('tbl_rental_summary')->insert($summary_data);
            $sid = $this->db->insertID();
            
        } else {
            $this->db->query("UPDATE tbl_rental_summary set total= total+$price where id=$sid");
        }
        $data = [
            'bill_summary_id' => $sid,
            'Amount' => $price,
            'bill_date' => $curr_date,
            'bill_due_date' => date('Y-m-d', strtotime($curr_date . '+5 days')),
            'trx_id' => $trx_id,
            'bill_source' => $meters,
            'previous_reading' => $prev,
            'current_reading' => $current,
            'reading_rate' => $rate
        ];
        $this->store('tbl_rental_bills', $data);

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }
    public function record_service_bill($custid, $date, $apid, $price, $month, $service_id): bool
    {
        $this->db->transStart();
        $this->db->transException(true);
        # record bill transactions
        $trx_id = $this->record_transaction($price, 'Service Charges', $custid);

        $curr_date = $date;

        $meters = $this->db->query("SELECT * from services where id=$service_id")->getRow()->service_name ?? 'Service charges';

        $sid = $this->get_existing_summary($custid, $month);

        if ($sid == 0) {
            $summary_data = [
                'tenant_id' => $custid,
                'total' => $price,
                'month' => $month,
                'apartment_id' => $apid,
                'bill_type' => 1
            ];
            $this->db->table('tbl_rental_summary')->insert($summary_data);
            $sid = $this->db->insertID();

        } else {
            $this->db->query("UPDATE tbl_rental_summary set total= total+$price where id=$sid");
        }
        $data = [
            'bill_summary_id' => $sid,
            'Amount' => $price,
            'bill_date' => $curr_date,
            'bill_due_date' => date('Y-m-d', strtotime($curr_date . '+5 days')),
            'trx_id' => $trx_id,
            'bill_source' => $meters,
        ];
        $this->store('tbl_rental_bills', $data);

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }
    public function get_existing_summary(int $cid, int $month)
    {
        $sql = $this->db->query("SELECT * from tbl_rental_summary where tenant_id=$cid and month=$month and bill_type=1");
        if ($sql->getNumRows() > 0) {
            return $sql->getRow()->id;
        }
        return 0;
    }
    # Record Transaction information
    public function record_transaction($amount, $source, $custid): string
    {
        $finance = new FinancialModel();

        $fpid = $finance->financial_period()['fp_id'];

        $trx_id = $finance->record_trans(abs($amount), $source, $fpid, $custid);

        $dracc = $finance->get_account_tag_set($custid, 'Customer')['account_id'];
        $cracc = $finance->get_account_tag('INC')['account_id'];

        $finance->dr_trx_det(abs($amount), $dracc, $trx_id);
        $finance->cr_trx_det(abs($amount), $cracc, $trx_id);

        $finance->update_accounnt_balance($dracc, $amount, 'dr');
        $finance->update_accounnt_balance($cracc, $amount, 'cr');

        return $trx_id;
    }
}
