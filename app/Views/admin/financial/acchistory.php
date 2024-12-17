<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>
<!-- ============================================================== -->
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

                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 align-self-center d-none d-md-block">
            <!--<button class="btn float-right btn-success"><i class="mdi mdi-plus-circle"></i> Create</button>-->
            <div class="dropdown float-right mr-2 hidden-sm-down">
                <!--                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> January 2020 </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> <a class="dropdown-item" href="#">February 2020</a> <a class="dropdown-item" href="#">March 2020</a> <a class="dropdown-item" href="#">April 2020</a> </div>-->
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

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start_date" class="control-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="startdate" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="end_date" class="control-label">End Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="end_date" name="end_date" autocomplete="off">
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-rounded btn-outline-primary" id="search_btn"><b><?= 'Search' ?></b></button>
                        </div>
                    </div>

                    <br /><br />

                    <div class="row">

                        <h4 class="card-title"> <?= strtoupper($account->acc_name) ?> STATEMENTS </h4>

                        <div id="messages"></div>


                        <div class="col-12">

                            <br>
                            <div id="ledger_table"></div>

                        </div>
                    </div>

                    <div class="col-12 text-right">
                        <input type="button" value="Print" id="display_print_modal">
                    </div>


                </div>
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->

    </div>

    <div id="print_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-xl">
            <form id="print_form">
                <div class="modal-content" id="change_state">

                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">Account Statement</h4>
                        <button type="button" class="btn-close border-0 p-2" id="resetButton" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="print_area">

                        <h2 class="text-center"> <?= session()->get('branch_name') ?> </h2>
                        <h3 class="text-center"> Account Statements</h3>
                        <h4 class="text-center"> For <?= date('d/M/Y') ?></h4>
                        <hr> <br />

                        <div class="row col-12" id="dispaly_income_stmt_modal" style="margin: 10px;">


                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-rounded btn-outline-primary" id="print_from_modal"><b><?= 'Print' ?></b></button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>
    <script type="text/javascript">
        var manageTable;
        var base_url = "<?php echo base_url($locale); ?>";
        var lang = "<?php echo $locale; ?>";

        let first_date = "<?= date('Y-m-d', strtotime('first day of this month')); ?>";
        let to_day = "<?= date('Y-m-d') ?>";

        $('#start_date').val(first_date);
        $('#end_date').val(to_day);

        get_ledger('<?= $accid ?>', first_date, to_day);

        $('#search_btn').on('click', function() {

            var enddate = $('#enddate').val();
            var startdate = $('#startdate').val();

            if (startdate == "" || enddate == "") {
                alert("Please select both dates");
            } else {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/financial/get_ledger/' + '<?= $accid ?>',
                    data: {
                        startdate: startdate,
                        enddate: enddate
                    },
                    // dataType: 'json',
                    success: function(response) {
                        $('#ledger_table').html(response);

                        $("#dispaly_income_stmt_modal").html(response);

                        $('#search_btn').attr('disabled', false)
                    }
                });
            }
        }); 


        function get_ledger(id, startdate, enddate) {
            $.ajax({
                type: 'POST',
                url: base_url + '/financial/get_ledger/' + id,
                data: {
                    startdate: startdate,
                    enddate: enddate
                },
                success: function(response) {
                    $('#ledger_table').html(response);
                    $("#dispaly_income_stmt_modal").html(response);
                }
            });
        }


        $('#display_print_modal').on('click', function() {

            $('#print_modal').modal('show');

        });


        $('#print_from_modal').click(function() {
            $('#print_area').printThis({
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

    <?= $this->endSection('content'); ?>