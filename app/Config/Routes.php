<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Back\AuthController::index');
// $routes->get('/{locale}', 'Front\Home::index');
// $routes->get('/{locale}', 'Front\Home::register');


$routes->group("api", ['namespace' => 'App\Controllers\Api'],  function ($routes) {
   //  $routes->post("register", "AuthController::register");
   $routes->post("login", "AuthController::login");
   //  $routes->post("operation", "ApiController::index", ['filter' => 'authFilter']);   
   $routes->post("register", "ApiController::register", ['filter' => 'authFilter']);
});

$routes->get('admin/page_404', 'Back\ErrorController::page_404');

$routes->group('{locale}', function ($routes) {

   $routes->group('front', ['namespace' => 'App\Controllers\Front'], function ($routes) {});


   $routes->group('admin', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('/', 'Dashboard::index', ['filter' => 'restrict']);

      $routes->get('auth', 'AuthController::index'); 
      $routes->post('login', 'AuthController::check_login');
      $routes->get('logout', 'AuthController::signout');
   });

   $routes->group('settings', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('/', 'SettingsController::index');
      $routes->get('menus', 'SettingsController::menus', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('menu_list', 'SettingsController::menu_list', ['filter' => 'restrict']);
      $routes->post('add_menu', 'SettingsController::add_menu', ['filter' => 'restrict']);
      $routes->get('uac', 'SettingsController::uac', ['filter' => 'restrict']);
      $routes->post('get_menus', 'SettingsController::get_menus', ['filter' => 'restrict']);
      $routes->post('update_access', 'SettingsController::update_access', ['filter' => 'restrict']);
      $routes->get('roles', 'SettingsController::roles', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('roles_list', 'SettingsController::roles_list', ['filter' => 'restrict']);
      $routes->get('branches', 'SettingsController::branches', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('get_branches', 'SettingsController::get_branches', ['filter' => 'restrict']);
      $routes->post('manage_units', 'SettingsController::manage_units', ['filter' => 'restrict']);

      $routes->post('add_user_role', 'SettingsController::add_user_role', ['filter' => 'restrict']);
      $routes->post('record_branch', 'SettingsController::record_branch', ['filter' => 'restrict']);
   });


   $routes->group('user', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      // pages
      $routes->get('list', 'UserController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);

      // These are the Ajax requests: fetching user data and handling user actions
      $routes->get('users_list', 'UserController::fetch_users', ['filter' => 'restrict']);
      $routes->post('crud', 'UserController::crud_user', ['filter' => 'restrict']);
      $routes->post('change_status', 'UserController::change_status', ['filter' => 'restrict']);
      $routes->post('status_changer', 'UserController::status_changer', ['filter' => 'restrict']);
      $routes->get('profile', 'UserController::profile', ['filter' => 'restrict']);
      $routes->post('change_password', 'UserController::change_password', ['filter' => 'restrict']);
      $routes->post('update_profile', 'UserController::update_profile', ['filter' => 'restrict']);
   });
   
   $routes->group('financial', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      // pages
      $routes->get('chart_accounts', 'FinancialController::chart_accounts', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('payment_voucher', 'FinancialController::payment_voucher', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('receipt_voucher', 'FinancialController::receipt_voucher', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->post('get_ledger/(:any)', 'FinancialController::get_ledger/$1', ['filter' => ['restrict']]);

      $routes->get('acchistory/(:any)', 'FinancialController::acchistory/$1', ['filter' => ['restrict']]);
      $routes->get('finperiod', 'FinancialController::finperiod', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('journal', 'FinancialController::journal_entry', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('trx', 'FinancialController::transactions', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      
      // These are the Ajax requests: fetching user data and handling user actions
      $routes->get('acc_list', 'FinancialController::fetch_accounts', ['filter' => 'restrict']);
      $routes->post('manage_acc', 'FinancialController::manage_account', ['filter' => 'restrict']);
      $routes->post('start-period', 'FinancialController::start_fin_period', ['filter' => 'restrict']);
      $routes->post('post-journal', 'FinancialController::journal_entry_posting', ['filter' => 'restrict']);
      $routes->post('record_vouchers', 'FinancialController::record_vouchers', ['filter' => 'restrict']);
      $routes->post('trxlist', 'FinancialController::fetch_trx', ['filter' => 'restrict']);
   });

   //  items start

   

   $routes->group('apartment', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      // pages
      $routes->get('building', 'ApartmentController::building',['filter' => 'restrict']);
      $routes->get('floors', 'ApartmentController::floors', ['filter' => 'restrict']);
      $routes->get('apartment_types', 'ApartmentController::apartment_types', ['filter' => 'restrict']);
      $routes->get('apartments', 'ApartmentController::apartments', ['filter' => 'restrict']);
      $routes->get('owners', 'OwnerController::index',['filter' => ['restrict', 'pageAuthorizedFilter']]);

      // These are the Ajax requests: fetching user data and handling user actions
         $routes->get('fetch_sites/(:any)', 'ApartmentController::fetch_sites/$1', ['filter' => 'restrict']);
         $routes->post('crud_sites', 'ApartmentController::crud_sites', ['filter' => 'restrict']);
         $routes->post('crud_sites', 'ApartmentController::crud_sites', ['filter' => 'restrict']);
         $routes->get('owner_list', 'ApartmentController::fetch_owners',['filter' => 'restrict']);

         $routes->get('fetch_floors', 'ApartmentController::fetch_floors', ['filter' => 'restrict']);

         $routes->post('crud_floors', 'ApartmentController::crud_floors', ['filter' => 'restrict']);

         $routes->get('fetch_apart_types', 'ApartmentController::fetch_apart_types', ['filter' => 'restrict']);
         $routes->post('crud_apart_type', 'ApartmentController::crud_apart_type', ['filter' => 'restrict']);
         $routes->post('get_floors', 'ApartmentController::get_floors', ['filter' => 'restrict']);
         $routes->post('get_apartments', 'ApartmentController::get_apartments', ['filter' => 'restrict']);

         $routes->get('fetch_apartments', 'ApartmentController::fetch_apartments', ['filter' => 'restrict']);
         $routes->post('crud_apartments', 'ApartmentController::crud_apartments', ['filter' => 'restrict']);


      // $routes->post('create_hall', 'HallController::create_hall', ['filter' => ['restrict']);
   });

   $routes->group('owner', ['namespace' => 'App\Controllers\Back'], function ($routes) {
         // pages
         $routes->get('/', 'OwnerController::index',['filter' => 'restrict']);
         $routes->get('list', 'OwnerController::fetch_owners',['filter' => ['restrict', 'pageAuthorizedFilter']]);
     

         // These are the Ajax requests: fetching user data and handling user actions
         $routes->post('crud_owners', 'OwnerController::crud_owners', ['filter' => 'restrict']);
        
   });

   $routes->group('hr', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('employees', 'HRController::employees', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('jobs', 'HRController::jobs', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('payroll', 'HRController::payroll', ['filter' => ['restrict', 'pageAuthorizedFilter']]);

      // These are the Ajax requests: fetching user data and handling user actions
      $routes->get('emp_list', 'HRController::fetch_list', ['filter' => 'restrict']);
      $routes->post('manage_emp', 'HRController::manage_emp', ['filter' => 'restrict']);
      $routes->post('block_emp', 'HRController::block_emp', ['filter' => 'restrict']);
      $routes->post('activate_emp', 'HRController::activate_emp', ['filter' => 'restrict']);
      $routes->get('get_jobs', 'HRController::fetch_job', ['filter' => 'restrict']);
      $routes->post('manage_job', 'HRController::manage_job', ['filter' => 'restrict']);
      $routes->get('get_payroll', 'HRController::fetch_salary', ['filter' => 'restrict']);
      $routes->post('get_base_salary', 'HRController::get_base_salary', ['filter' => 'restrict']);
      $routes->post('manage_salary', 'HRController::manage_salary', ['filter' => 'restrict']);
   });
   
   $routes->group('supplier', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      // pages
      $routes->get('list', 'SupplierController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('payments', 'SupplierController::payments', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('bills', 'SupplierController::bills',['filter' => ['restrict', 'pageAuthorizedFilter']]);

      // These are the Ajax requests: fetching user data and handling user actions
      $routes->get('fetch_suppliers', 'SupplierController::fetch_suppliers', ['filter' => 'restrict']);
      $routes->get('fetch_bills', 'SupplierController::fetch_bills', ['filter' => 'restrict']);
      $routes->get('fetch_payments', 'SupplierController::fetch_payments', ['filter' => 'restrict']);
      $routes->post('create_supplier', 'SupplierController::create_supplier', ['filter' => 'restrict']);
      $routes->post('open_balance_form', 'SupplierController::open_balance_form', ['filter' => 'restrict']);
      $routes->post('payment_form', 'SupplierController::payment_form', ['filter' => 'restrict']);
      $routes->post('get_total_bills', 'SupplierController::get_total_bills', ['filter' => 'restrict']);
      $routes->post('get_supplier_bal', 'SupplierController::get_supplier_bal', ['filter' => 'restrict']);
      $routes->get('trx_list(:any)', 'SupplierController::trx_list/$1', ['filter' => 'restrict']);
   });

   $routes->group('purchases', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('list', 'PurchaseController::list', ['filter' => 'restrict']);
      $routes->get('fetch_purchases', 'PurchaseController::fetch_purchases', ['filter' => 'restrict']);
      $routes->get('purchase_details_list(:any)', 'PurchaseController::purchase_details_list/$1', ['filter' => 'restrict']);
      $routes->post('purchase_form', 'PurchaseController::purchase_form', ['filter' => 'restrict']);
      $routes->post('get_purchase_details', 'PurchaseController::get_purchase_details', ['filter' => 'restrict']);
   });


   $routes->group('customer', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      // pages
      $routes->get('list', 'CustomerController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('advances', 'CustomerController::advances', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('deposits_payable', 'CustomerController::deposits_payable', ['filter' => ['restrict', 'pageAuthorizedFilter']]);


      // These are the Ajax requests: fetching user data and handling user actions

      $routes->post('customer_advances', 'CustomerController::customer_advances', ['filter' => 'restrict']);
      $routes->get('get_advances', 'CustomerController::get_advances', ['filter' => 'restrict']);
      $routes->get('fetch_customers', 'CustomerController::fetch_customers', ['filter' => 'restrict']);
      $routes->post('customer_form', 'CustomerController::customer_form', ['filter' => 'restrict']);
      $routes->post('customer_open_balance', 'CustomerController::customer_open_balance', ['filter' => 'restrict']);

      $routes->get('invoices', 'CustomerController::invoices', ['filter' => 'restrict']);
      $routes->get('fetch_invoices', 'CustomerController::fetch_invoices', ['filter' => 'restrict']);
      $routes->get('receipts', 'CustomerController::receipts', ['filter' => 'restrict']);
      $routes->get('fetch_receipts', 'CustomerController::fetch_receipts', ['filter' => 'restrict']);
      $routes->get('fetch_deposits', 'CustomerController::fetch_deposits', ['filter' => 'restrict']);
      $routes->post('get_outstanding_deposits', 'CustomerController::get_outstanding_deposits', ['filter' => 'restrict']);
      $routes->post('create_deposit_payment', 'CustomerController::create_deposit_payment', ['filter' => 'restrict']);

      $routes->post('get_total_bills', 'CustomerController::get_total_bills', ['filter' => 'restrict']);
      $routes->post('receipt_form', 'CustomerController::receipt_form', ['filter' => 'restrict']);

      $routes->post('get_customer_bal', 'CustomerController::get_customer_bal', ['filter' => 'restrict']);

      $routes->post('open_balance_form', 'CustomerController::open_balance_form', ['filter' => 'restrict']);
   });




   $routes->group('meals', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      //  $routes->get('/', 'MealsController::meals_category', ['filter' => 'restrict']);
      $routes->get('meals_category', 'MealsController::meals_category',);
      $routes->get('fetch_category', 'MealsController::fetch_category', ['filter' => 'restrict']);
      $routes->post('product_cat', 'MealsController::product_cat', ['filter' => 'restrict']);
      $routes->get('meals_type', 'MealsController::meals_type',);
      $routes->get('product_type_list', 'MealsController::product_type_list', ['filter' => 'restrict']);
      $routes->post('product_type_form', 'MealsController::product_type_form', ['filter' => 'restrict']);
      $routes->get('meal', 'MealsController::meal',);
      $routes->get('products_list', 'MealsController::products_list', ['filter' => 'restrict']);
      $routes->post('products_form', 'MealsController::products_form', ['filter' => 'restrict']);
   });

   $routes->group('orders', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('empty', 'OrderController::empty', ['filter' => 'restrict']);
      $routes->post('get_empty_orders', 'OrderController::get_empty_orders', ['filter' => 'restrict']);
   });

   $routes->group('pos', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('/', 'PosController::point_of_sale', ['filter' => 'restrict']);
      $routes->get('point_of_sale', 'PosController::point_of_sale',);
      $routes->get('login', 'PosController::login');

      $routes->get('fetch_customers', 'CustomerController::fetch_customers', ['filter' => 'restrict']);
      $routes->post('list_baskets', 'PosController::list_baskets', ['filter' => 'restrict']);
      $routes->post('product_types', 'PosController::product_types', ['filter' => 'restrict']);
      $routes->post('products_by_product_types', 'PosController::products_by_product_types', ['filter' => 'restrict']);
      $routes->post('last_basket', 'PosController::last_basket', ['filter' => 'restrict']);
      $routes->post('basket_det', 'PosController::basket_det', ['filter' => 'restrict']);
      $routes->post('add_item', 'PosController::add_item', ['filter' => 'restrict']);
      $routes->post('change_qty', 'PosController::change_qty', ['filter' => 'restrict']);
      $routes->post('discard_item', 'PosController::discard_item', ['filter' => 'restrict']);
      $routes->post('new_basket', 'PosController::new_basket', ['filter' => 'restrict']);
      $routes->post('printable_basket', 'PosController::printable_basket', ['filter' => 'restrict']);
      $routes->post('discard_basket', 'PosController::discard_basket', ['filter' => 'restrict']);
      $routes->post('sales_form', 'PosController::sales_form', ['filter' => 'restrict']);
      $routes->get('sales(:any)', 'PosController::sales/$1', ['filter' => 'restrict']);
      $routes->get('fetch_sales', 'PosController::fetch_sales', ['filter' => 'restrict']);

      $routes->post('clear_orders', 'PosController::clear_orders', ['filter' => 'restrict']);
      $routes->post('get_basket_orders', 'PosController::get_basket_orders', ['filter' => 'restrict']);
      $routes->post('logout', 'PosController::logout', ['filter' => 'restrict']);

      $routes->post('waiter_login', 'WaiterController::waiter_login');
      $routes->post('printable_bill', 'PosController::printable_bill', ['filter' => 'restrict']);
   });

   $routes->group('sales', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('sales_return', 'sales_return::index');
      $routes->get('fetch_sales_return', 'sales_return::fetch_sales_return', ['filter' => 'restrict']);
      $routes->post('sales_return_form', 'sales_return::sales_return_form', ['filter' => 'restrict']);
      $routes->post('get_item_details_for_returns', 'sales_return::get_item_details_for_returns', ['filter' => 'restrict']);
   });

   $routes->group('waiter', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('/', 'WaiterController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('list', 'WaiterController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      
      $routes->get('orders', 'WaiterController::orders', ['filter' => 'restrict']);
      $routes->get('sales', 'WaiterController::sales', ['filter' => 'restrict']);
      $routes->get('fetch_waiters', 'WaiterController::fetch_waiters', ['filter' => 'restrict']);
      $routes->post('create_waiter', 'WaiterController::create_waiter', ['filter' => 'restrict']);
      $routes->post('get_basket_orders', 'WaiterController::get_basket_orders', ['filter' => 'restrict']);
      $routes->post('get_waiter_sales1', 'WaiterController::get_waiter_sales1', ['filter' => 'restrict']);
      $routes->post('pay_order', 'WaiterController::pay_order', ['filter' => 'restrict']);
   });

   $routes->group('invoice', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('/', 'InvoiceController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('list', 'InvoiceController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);

      // These are the Ajax requests: fetching user data and handling user actions
      $routes->get('fetch_invoices', 'InvoiceController::fetch_invoices', ['filter' => 'restrict']);
      $routes->post('create_invoice', 'InvoiceController::create_invoice', ['filter' => 'restrict']);
      $routes->post('get_outstanding_invoices', 'InvoiceController::get_outstanding_invoices', ['filter' => 'restrict']);
   });
 
   $routes->group('payment', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('/', 'PaymentController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('list', 'PaymentController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);


      $routes->get('fetch_payments', 'PaymentController::fetch_payments', ['filter' => 'restrict']);
      $routes->post('create_payment', 'PaymentController::create_payment', ['filter' => 'restrict']);
   });

   $routes->group('customer', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('/', 'CustomerController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('list', 'CustomerController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);


      $routes->get('fetch_customers', 'CustomerController::fetch_customers', ['filter' => 'restrict']);
      $routes->post('create_customer', 'CustomerController::create_customer', ['filter' => 'restrict']);
      $routes->post('get_customer_bal', 'CustomerController::get_customer_bal', ['filter' => 'restrict']);
      $routes->get('trx_list(:any)', 'CustomerController::trx_list/$1', ['filter' => 'restrict']);
   });

   $routes->group('receipt', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('/', 'ReceiptController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('list', 'ReceiptController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);

      $routes->get('fetch_receipts', 'ReceiptController::fetch_receipts', ['filter' => 'restrict']);
      $routes->post('create_receipt', 'ReceiptController::create_receipt', ['filter' => 'restrict']);
      $routes->post('get_total_bills', 'ReceiptController::get_total_bills', ['filter' => 'restrict']);
   });

   $routes->group('report', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      // pages
      $routes->get('rental_income', 'ReportController::rental_income', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('income_statemant', 'ReportController::income', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('blance_sheet', 'ReportController::blance_sheet', ['filter' => ['restrict', 'pageAuthorizedFilter']]);

      $routes->get('buildings', 'ReportController::getAll_Buildings', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      $routes->get('fetch_buildings/(:any)', 'ReportController::fetch_buildings/$1', ['filter' => 'restrict']);


      // These are the Ajax requests: fetching user data and handling user actions
      $routes->get('payables_report', 'ReportController::payables_report', ['filter' => 'restrict']);
      $routes->get('receivables', 'ReportController::receivables', ['filter' => 'restrict']);
      $routes->get('receivables_report', 'ReportController::receivables_report', ['filter' => 'restrict']);
      $routes->get('payables', 'ReportController::payables', ['filter' => 'restrict']);
      $routes->post('fetch_rep_rental', 'ReportController::fetch_rep_rental', ['filter' => 'restrict']);
      $routes->post('print_income_statement', 'ReportController::print_income_statement', ['filter' => 'restrict']);
      $routes->post('print_balance_sheet', 'ReportController::print_balance_sheet', ['filter' => 'restrict']);
   });

   $routes->group('util', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->post('status_changer', 'UtilController::status_changer', ['filter' => 'restrict']);
      $routes->post('change_status', 'UtilController::change_status', ['filter' => 'restrict']);
   });

   $routes->group('rental', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('list', 'RentalController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);

      $routes->get('fetch_rentals/(:any)', 'RentalController::fetch_rentals/$1', ['filter' => 'restrict']);
      $routes->get('closed', 'RentalController::closed', ['filter' => 'restrict']);
      $routes->get('fetch_closed_rentals', 'RentalController::fetch_closed_rentals', ['filter' => 'restrict']);

      $routes->post('get_active_apartments', 'RentalController::get_active_apartments', ['filter' => 'restrict']);
      $routes->post('get_apartment_price', 'RentalController::get_apartment_price', ['filter' => 'restrict']);

      $routes->post('record_rentals', 'RentalController::record_rentals', ['filter' => 'restrict']);
      $routes->post('extend_rental_duration', 'RentalController::extend_rental_duration', ['filter' => 'restrict']);
      $routes->post('terminate_rental_agreement', 'RentalController::terminate_rental_agreement', ['filter' => 'restrict']);
      $routes->post('relocate_tenant', 'RentalController::relocate_tenant', ['filter' => 'restrict']);
   });

   $routes->group('bill', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('list', 'BillController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);

      $routes->post('print_bill', 'BillController::print_bill', ['filter' => 'restrict']);
      $routes->get('fetch_bills/(:any)', 'BillController::fetch_bills/$1', ['filter' => 'restrict']);
      $routes->get('charges', 'BillController::charges', ['filter' => 'restrict']);
      $routes->get('fetch_charging_tenants', 'BillController::fetch_charging_tenants', ['filter' => 'restrict']);
      $routes->get('invoice_print/(:num)', 'BillController::invoice_print/$1',['filter'=>'restrict']);

      $routes->post('raise_rent_invoice', 'BillController::raise_rent_invoice', ['filter' => 'restrict']);
      $routes->post('record_receipt', 'BillController::record_receipt', ['filter' => 'restrict']);
      $routes->post('cancel_receipt', 'BillController::cancel_receipt', ['filter' => 'restrict']);
   });

   $routes->group('rate', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('list', 'RateController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);

      $routes->get('fetch_rate', 'RateController::fetch_rate', ['filter' => 'restrict']);
      $routes->post('create_rate', 'RateController::create_rate', ['filter' => 'restrict']);
    
   });

   $routes->group('meter', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('list', 'MeterController::list', ['restrict', 'pageAuthorizedFilter']);

      $routes->get('fetch_meters', 'MeterController::fetch_meters', ['filter' => 'restrict']);
      $routes->post('create_meter', 'MeterController::create_meter', ['filter' => 'restrict']);
    
   });

   $routes->group('reading', ['namespace' => 'App\Controllers\Back'], function ($routes) {
      $routes->get('list', 'ReadingController::list', ['filter' => ['restrict', 'pageAuthorizedFilter']]);
      
      $routes->get('fetch_reading_data', 'ReadingController::fetch_reading_data', ['filter' => 'restrict']);
      $routes->post('create_reading', 'ReadingController::create_reading', ['filter' => 'restrict']);
      
      $routes->get('services', 'ReadingController::services', ['filter' => 'restrict']);
      $routes->get('fetch_services', 'ReadingController::fetch_services', ['filter' => 'restrict']);
      $routes->post('crud_services', 'ReadingController::crud_services', ['filter' => 'restrict']);
      
      $routes->get('charge_services', 'ReadingController::charge_services', ['filter' => 'restrict']);
      $routes->get('fetch_charging_service', 'ReadingController::fetch_charging_service', ['filter' => 'restrict']);
      $routes->post('crud_charging_service', 'ReadingController::crud_charging_service', ['filter' => 'restrict']);
      $routes->post('get_service_price', 'ReadingController::get_service_price', ['filter' => 'restrict']);
      $routes->post('create_charge_services', 'ReadingController::create_charge_services', ['filter' => 'restrict']);

      $routes->post('fill_meters', 'ReadingController::fill_meters', ['filter' => 'restrict']);
      $routes->post('get_prev_reading', 'ReadingController::get_prev_reading', ['filter' => 'restrict']);
      $routes->post('get_rate_value', 'ReadingController::get_rate_value', ['filter' => 'restrict']);
    
   });


   $routes->group('tester' , ['namespace' => 'App\Controllers\Back'], function ($routes){

      $routes->get('/' , "TesterController::index" , ['restrict', 'pageAuthorizedFilter']);

   });


});

// $routes->get('lang/{locale}', 'Language::index');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
   require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
