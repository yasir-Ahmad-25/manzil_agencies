<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>


<?php

use App\Models\Back\FinancialModel;

$financial = new FinancialModel();
?>

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
                        <li class="breadcrumb-item active" aria-current="page">Income Statement</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 align-self-center d-none d-md-block">
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

                <div class="card-body">
                    <br />
                    <div id="messages"></div>


                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="startdate" class="control-label">From</label>
                                <input type="date" class="form-control" id="startdate" name="startdate" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="enddate" class="control-label">To</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="enddate" name="enddate" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-rounded btn-outline-primary" id="search_btn"><b><?= 'Search' ?></b></button>
                        </div>

                        </br>

                        <div class="col-12" id="display_income_stmt">
                        </div>

                        <div class="col-12 text-right">
                            <input type="button" value="Print" id="display_print_modal">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->

    </div>

    <div id="print_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <form id="print_form">
                <div class="modal-content" id="change_state">

                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">Income Statement</h4>
                        <button type="button" class="btn-close border-0 p-2" id="resetButton" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="print_area">

                        <h2 class="text-center"> <?=session()->get('branch_name')?> </h2>
                        <h3 class="text-center"> Income Statements</h3>
                        <h4 class="text-center"> For <?= date('d/M/Y') ?></h4>
                        <hr> <br/>

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
        var base_url = "<?php echo base_url($locale); ?>";
        var lang = "<?php echo $locale; ?>";
        var manageTable;
        var base_url = "<?php echo base_url($locale); ?>";

        let first_date = "<?= date('Y-m-d', strtotime('first day of january this year'));?>";
        let to_day = "<?= date('Y-m-d')?>";

        $(document).ready(function() {

            print_income_statement(first_date, to_day);
        });

        $('#search_btn').on('click', function() {

            let from_date = $('#startdate').val();
            let to_date = $('#enddate').val();

            print_income_statement(from_date, to_date)
        });



        $('#display_print_modal').on('click', function() {

            $('#print_modal').modal('show');

        });


        function print_income_statement(from_date, to_date) {

            $('#search_btn').attr('disabled', true)

            $.ajax({
                url: base_url + '/report/print_income_statement',
                type: "POST",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                },
                success: function(response) {

                    $("#display_income_stmt").html(response);
                    $("#dispaly_income_stmt_modal").html(response);

                    $('#search_btn').attr('disabled', false)

                }
            });
        }



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