<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

use App\Models\Back\AuthModel;
use App\Models\Back\DashboardModel;

class Dashboard extends BaseController
{
    
    public function index(): string
    {
        $auth = new AuthModel();
        $dashboard = new DashboardModel();
        

        $this->viewData['halls'] = 0;
        $this->viewData['customers'] = count($this->get_table_info('tbl_customers'));
        
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
        $this->viewData['monthly_rev'] =  0;

        $this->viewData['access'] = $auth->get_user_access(session()->get('ut_id'),$this->request->getLocale());
        return view('admin/dashboard', $this->viewData);

    }


   


  







}
