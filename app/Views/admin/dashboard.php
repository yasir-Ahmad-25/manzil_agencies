<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>
<!-- <h2>Welcome...</h2> -->

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-md-5 align-self-center">
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              Dashboard
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
      <div class="d-flex">
        <div class="dropdown me-2">
          <button class="btn btn-secondary " type="button">
            <?= date('M Y') ?>
          </button>

        </div>

      </div>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body pb-0" style="height:33vh">
          <div class="d-md-flex align-items-center">
            <h4 class="card-title"><?= lang('Site.labels.due_rentals') ?></h4>
            
          </div>
          <table class="table table-responsive" id="manage_due_rentals">
            <!-- <tr>
                <th>#</th>
                <th>Tenant</th>
                <th>Apartment</th>
                <th>Months</th>
                <th>Amounts</th>
            </tr> -->
              <thead>
                  <tr> 
                      <th>#</th>                                                                                                                                     
                      <th><?= 'Month' ?></th> 
                      <th><?= 'Tenant' ?></th> 
                      <th><?= 'Remaining'?></th> 
                  </tr>
              </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <!-- Row -->
      <div class="row">
        <div class="col-sm-6">
          <div class="card card-body">
            <!-- Row -->
            <div class="row align-items-center">
              <div class="col-6">
                <h1 class="fw-light"><?= $total_tenants ?></h1>
                <h6 class="text-muted mb-0"><?= lang('Site.labels.tenants') ?></h6>
              </div>
              <div class="col-6 text-end align-self-center">
              <i data-feather="users" style="width:100px; height:100px;" class="feather-icon"></i>

              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card card-body">
            <!-- Row -->
            <div class="row align-items-center">
              <div class="col-6">
                <h3 class="fw-light"><?= $Apartments ?></h3>
                <h6 class="text-muted mb-0"><?= lang('Site.labels.apartments') ?></h6>
              </div>
              <div class="col-6 text-end align-self-center">
              <i data-feather="hash" style="width:100px; height:100px;" class="feather-icon"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card card-body">
            <!-- Row -->
            <div class="row align-items-center">
              <div class="col-6">
                <h1 class="fw-light"><?= $buildings ?></h1>
                <h6 class="text-muted mb-0"><?= lang('Site.labels.buildings') ?></h6>
              </div>
              <div class="col-6 text-end align-self-center">
              <i data-feather="home" style="width:100px; height:100px;" class="feather-icon"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <!-- Row -->
            <div class="card card-body" style="height:14vh">
              <!-- Row --> 
              <div class="row align-items-center">
                <div class="col-6">
                  <h1 class="fw-light">
                  <i class="fas fa-exclamation-triangle"
                        style="margin-right: 8px; animation: bounce 1.5s infinite;color:red;"></i>
                      <span style="color:black; font-size: 1rem; display:block;">Unpaid Invoices</span>
                  </h1>
                 
                </div>
                <div class="col-6 text-end align-self-center">
                    <h2><?= $unpaid_people ?> Unpaid</h2>
                </div>
              </div>
            </div>
        </div>

      </div>
    </div>
    <div class="col-lg-12">
      <div class="card w-100 overflow-hidden">
        <div class="card-body pb-8">
          <div class="d-md-flex no-block align-items-center">
            <h4 class="card-title mb-0"><?= 'Last 5 Rents' ?></h4>
          </div>
        </div>
        <div class="table-responsive" >
          <table class="table stylish-table align-middle text-nowrap" id="manageTable_Last_5_Rents">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Apartment No</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration</th>
                    <th>Left Period</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="crad-header">
          <h4 class="card-title"><?= 'Expense' ?></h4>
        </div>
        <div class="card-body">
          <div class="d-md-flex align-items-center">
                <canvas id="ExpenseChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-header">
          <h4 class="card-title"><?= 'Income' ?></h4>
        </div>
        <div class="card-body">
          <div class="d-md-flex align-items-center">
              <canvas id="IncomeChart"></canvas>
          </div>
          <!-- <div id="income-of-the-year" class="mx-n2"></div> -->
        </div>
      </div>
    </div>
  </div>

</div>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

  $(document).ready(function () {
    // sales_per_month(0, <?//= json_encode($month_sales['labels']) ?>)


    // fetch due rentals people
    var base_url = "<?php echo base_url($locale); ?>/admin/";
    branch_id = <?= session()->get('user')['branch_id'] ?>;
    fetchTable(branch_id);
    fetchLastFiveRentTable();
    console.log("Base Url: " + base_url);
    


    function fetchTable(branch_id) {
        let CI4_ROUTE;

        // Determine which route to use based on the selected site
        CI4_ROUTE = base_url + 'fetch_unpaid_bills';
      
        

        // Initialize the DataTable only if it hasn't been initialized yet
        if (!$.fn.dataTable.isDataTable('#manage_due_rentals')) {
          manage_due_rentals = $('#manage_due_rentals').DataTable({
                'ajax': CI4_ROUTE,  // Dynamic data source URL based on the selected status
                'order': []         // Optionally specify your table ordering logic
            });
        } else {
            // If the DataTable is already initialized, just reload the data
            manage_due_rentals.ajax.url(CI4_ROUTE).load();
        }
    }
          
    function fetchLastFiveRentTable() {
          let CI4_ROUTE;

          // Determine which route to use based on the selected site
          CI4_ROUTE = base_url + 'fetch_last_five_rentals';

          console.log("After metho called LAstFice :" + CI4_ROUTE);
          
          // Initialize the DataTable only if it hasn't been initialized yet
          if (!$.fn.dataTable.isDataTable('#manageTable_Last_5_Rents')) {
              manageTable_Last_5_Rents = $('#manageTable_Last_5_Rents').DataTable({
                  'ajax': CI4_ROUTE,  // Dynamic data source URL based on the selected status
                  'order': []         // Optionally specify your table ordering logic
              });
          } else {
              // If the DataTable is already initialized, just reload the data
              manageTable_Last_5_Rents.ajax.url(CI4_ROUTE).load();
          }
      }


      const income_ctx = document.getElementById('IncomeChart');
      const expense_ctx = document.getElementById('ExpenseChart');

      new Chart(income_ctx, {
        type: 'bar',
        data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });


      new Chart(expense_ctx, {
        type: 'bar',
        data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

  
  });
</script>


<script src="<?php echo base_url() ?>public/assets/js/apexcharts.min.js"></script>
<!-- <script src="<?php echo base_url() ?>public/assets/js/dashboard2.js"></script> -->
<?= $this->endSection(); ?>