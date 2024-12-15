<?= $this->extend('admin/layouts/base.php'); ?>


<?= $this->section('content');?>

     <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <!--                        <h4 class="page-title">Starter Page</h4>-->
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= 'sites' ?></li>
                         </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 align-self-center d-none d-md-block">
                <!--<button class="btn float-right btn-success"><i class="mdi mdi-plus-circle"></i> Create</button>-->
                <div class="dropdown float-right mr-2 hidden-sm-down">
                              
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
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="mt-3" id="outer"></div>
                    <div class="card-body">
                        <!-- <h4 class="card-title">  </h4> -->
                        <br/>

                        <form action="#" method="post">
                            <div class="form-group">
                                <label for="#">Status</label>
                                <select name="selected_status" id="selected_status" class="form-select mb-2">
                                    <option value="Active" selected> Active </option>
                                    <option value="De-Active"> De-Active </option>
                                </select>
                            </div>
                        </form>
                        <div id="messages"></div>

                        <table id="manageTable_site" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr> 
                                    <th>#</th>                                                                                                                                     
                                    <th><?= 'Site Name' ?></th> 
                                    <th><?= 'Site Owner' ?></th> 
                                    <th><?= 'Address'?></th> 
                                    <th><?= 'Built in'?></th> 
                                    <th><?= 'Floors' ?></th> 
                                    <th><?= 'Status' ?></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>

                        <button class="btn btn-primary" id="btn_rental_income" data-toggle="modal" data-target="#">Print</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->


    <script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>

    <script>
    
        // setting variables
            var base_url = "<?php echo base_url($locale); ?>";
            var manageTable;
            var lang = "<?php echo $locale; ?>";
    
         $(document).ready(function () {
    
            $('#tablesMainNav').addClass('active');
            // initialize the datatable 

            updateTable('Active');
            // Event listener to trigger table update when status is selected
            document.getElementById("selected_status").addEventListener("change", function() {
                const selectedStatus = this.value;
                updateTable(selectedStatus);
            });

            function updateTable(status) {
                let CI4_ROUTE;

                // Determine which route to use based on the selected status
                if (status === 'Active') {
                    CI4_ROUTE = base_url + '/report/fetch_buildings/Active';
                } else {
                    CI4_ROUTE = base_url + '/report/fetch_buildings/De-Active';
                }
                
                console.log("Selected status: " + status);
                console.log("Fetching data from: " + CI4_ROUTE);

                // Initialize the DataTable only if it hasn't been initialized yet
                if (!$.fn.dataTable.isDataTable('#manageTable_site')) {
                    manageTable_site = $('#manageTable_site').DataTable({
                        'ajax': CI4_ROUTE,  // Dynamic data source URL based on the selected status
                        'order': []         // Optionally specify your table ordering logic
                    });
                } else {
                    // If the DataTable is already initialized, just reload the data
                    manageTable_site.ajax.url(CI4_ROUTE).load();
                }
            }
         });

         $('#btn_rental_income').click(function () {

            $('#manageTable_site').printThis({
                debug: false, // show the iframe for debugging
                importCSS: true, // import parent page css
                importStyle: true, // import style tags
                printContainer: true, // path to additional css file - use an array [] for multiple
                pageTitle: "Report Of Buildings", // add title to print page
                removeInline: false, // remove inline styles from print elements
                printDelay: 333, // variable print delay
                header: null, // prefix to html
                footer: null, // postfix to html
                base: false, // preserve the BASE tag, or accept a string for the URL
                formValues: true, // preserve input/form values
                canvas: false, // copy canvas content
                doctypeString: '...', // enter a different doctype for older markup
                removeScripts: false, // remove script tags from print content
                copyTagClasses: false, // copy classes from the html & body tag
                beforePrintEvent: null, // function for printEvent in iframe
                beforePrint: null, // function called before iframe is filled
                afterPrint: null // function called before iframe is removed
            });

            console.log("Printing Right Away ....");
            
         });
         
    </script>

<?= $this->endSection('content');?>

