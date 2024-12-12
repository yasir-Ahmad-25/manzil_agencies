<?= $this->extend("admin/layouts/base");?>

<?= $this->section('content');?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center  p-2">
                <h2 class="page-title"><?= 'Sales List' ?></h2>
            </div>
            <!-- <div class="col-md-12 align-self-center">
                <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#branch_modal"> +
                    <?= lang('Site.button.add') ?></button> <br>
            </div> -->
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


                            <div class="col-md-3 align-right">

                                <label>Waiters</label>
                                <div class="form-group text-dark">
                                    <select class="form-control border-secondary  form-control-sm" name="waiter_id" id="waiter_id">
                                        <option value="All" selected>All</option>
                                        <?php foreach ($waiters as $waiter) : ?>
                                            <option value="<?= $waiter['waiter_id'] ?>">
                                                <?= $waiter['waiter_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>

                            <div class="col-2 form-group text-dark">
                                <label>Start </label>
                                <input type="date" class="form-control border-secondary" id="start">
                            </div>

                            <div class="col-md-2 form-group text-dark">
                                <label>End</label>
                                <input type="date" class="form-control border-secondary" id="end">
                            </div>



                        </div>

                        <br />
                        <div id="waiter_sales_section">
                            <h4> Waiter sales from <span id="from_d"></span>  to <span id="to_d"></span></h4>

                       
                        <div id="waiter_sales_rep">

                        </div>

                        </div>

                        <br />
                        <div id="waiter_sales_rep_dt"></div>


                    </div>

                    <div class="col-12 text-right" style="margin: 10px;">
                        <input type="button" value="Print" id="advanced">
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
<script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>
<script type="text/javascript">
    var manageTable_site;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 

        waiter_sales_rep('All', '', '');


        $('#waiter_id').on('change', function() {

            let wid = $(this).val();

            start = $('#start').val();
            end = $('#end').val();

            waiter_sales_rep(wid, start, end);

        });


        $('#end').on('change', function() {

            let wid = $('#waiter_id').val();

            start = $('#start').val();
            end = $('#end').val();

            waiter_sales_rep(wid, start, end);

        });

    });

    function waiter_sales_rep(wid, start, end) {

        $.ajax({
            type: 'POST',
            url: base_url + '/waiter/get_waiter_sales1',
            data: {
                waiter_id: wid,
                start: start,
                end: end
            },
            success: function(response) {


                $('#waiter_sales_rep').html(response);
            }
        });
        // $.ajax({
        //     type: 'POST',
        //     url: '<?= base_url() ?>waiter/get_waiter_sales',
        //     data: {
        //         waiter_id: wid,
        //         start: start,
        //         end: end
        //     },
        //     success: function(response) {


        //         $('#waiter_sales_rep_dt').html(response);
        //     }
        // });

    }

    $('#advanced').click(function() {

        $('#from_d').text($('#start').val());
        $('#to_d').text($('#end').val());

        $('#waiter_sales_section').printThis({
            debug: false, // show the iframe for debugging
            importCSS: true, // import parent page css
            importStyle: true, // import style tags
            printContainer: true, // print outer container/$.selector
            loadCSS: "<?php echo base_url() ?>public/assets/css/style.min.css", // path to additional css file - use an array [] for multiple
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
<?= $this->endSection();?>