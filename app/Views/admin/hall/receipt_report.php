<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= $title ?></h2>
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

                        <div class="row">


                            <div class="col-3 form-group text-dark">
                                <label>Start </label>
                                <input type="date" class="form-control border-secondary" id="start">
                            </div>

                            <div class="col-md-3 form-group text-dark">
                                <label>End</label>
                                <input type="date" class="form-control border-secondary" id="end">
                            </div>
                            <div class="col-md-3 form-group text-dark" >
                                <button class="btn btn-primary" type="button" id="searchBtn" value="Search" style="margin-top: 30px;">
                                   Search
                                </button>
                            </div>



                        </div>
  
                        <br />
                        <div id="waiter_sales_rep">
                            
                             <h3> Receipt Report on <?=date('d M, Y')?></h3>
                            
                            <div id="receipt_report"></div>
                            
                            
                        </div>

                        <br />
                     
                        <div id="waiter_sales_rep_dt"></div>
                        
                        <div class="col-12 text-right">
                                <input type="button" value="Print" id="advanced">
                            </div>


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


</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
    <script src="<?php echo base_url() ?>js/printThis.js"></script>
<script type="text/javascript">
    var manageTable_site;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');

        hall_booking_rep('All', '', '');


        $('#hall_id').on('change', function() {

            let hid = $(this).val();

            start = $('#start').val();
            end = $('#end').val();

            hall_booking_rep(hid, start, end);

        });


        $('#searchBtn').on('click', function() {

            let span = ' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Searching...'
            $('#searchBtn').html(span).prop('disabled', true);

          //  let hid = $('#hall_id').val();

            start = $('#start').val();
            end = $('#end').val();

            hall_booking_rep(start, end);

        });

    });

    function hall_booking_rep(start, end) {

        $.ajax({
            type: 'POST',
            url: base_url + '//booking/get_receipt_report',
            data: {
                start: start,
                end: end
            },
            success: function(response) {


            $('#receipt_report').html(response);

            $('#searchBtn').html('Search').prop('disabled', false);
            }
        });
    

    }
    
    
            $('#advanced').click(function() {

                // $('#print_area').prepend('<h2 class="text-center"> Muqdisho Mall & Apartments</h2><h3 class="text-center"> Income Statements</h3>');
                $('#waiter_sales_rep').printThis({
                    debug: false, // show the iframe for debugging
                    importCSS: true, // import parent page css
                    importStyle: true, // import style tags
                    printContainer: true, // print outer container/$.selector
                    loadCSS: "<?php echo base_url() ?>assets/css/style.min.css", // path to additional css file - use an array [] for multiple
                    pageTitle: "Report", // add title to print page
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
            });
</script>

<?= $this->endSection(); ?>