<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <?= $this->extend("admin/layouts/base"); ?>

    <?= $this->section('content'); ?>
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
                            <li class="breadcrumb-item active" aria-current="page">Reading</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-12" style="text-align: end">
                <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#reading_modal">New
                    Reading</button>
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
                        <!-- <h4 class="card-title"> Manage Property </h4> -->

                        <br />
                        <div id="messages"></div>
                        <!-- <div class="table-responsive" id="badale"> -->
                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Meter Name</th>
                                    <th>Prev Reading</th>
                                    <th>Current Reading</th>
                                    <th>Consumption</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                    <th>Read Month</th>
                                    <th>Reading Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                        <!-- </div> -->


                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    <!-- add modal content -->
    <div id="reading_modal" class="modal fade" role="dialog" aria-hidden="true" data-bs-backdrop='static'
        data-bs-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Reading Form</h4>
                    <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="inner_add"></div>

                    <form id="data_form">

                        <div class="modal-body">

                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="reading_id" id="reading_id">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="floor_id"><?= 'Building' ?></label>
                                        <select class="form-control" id="site_id" name="site_id" required>
                                            <option selected disabled value="">Choose Building</option>
                                            <?php foreach ($buildings as $k => $v): ?>
                                                <option value="<?php echo $v['site_id'] ?>"><?php echo $v['site_name'] ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 form-group">
                                    <label for="ap_id" class="control-label">Apartment</label>
                                    <select name="ap_id" id="ap_id" class="form-control" required>
                                        <option value="" selected disabled>Select Ap#</option>
                                        <?php
                                        foreach ($apartments as $val) { ?>
                                            <option value="<?php echo $val['ap_id']; ?>"><?php echo $val['ap_no']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>


                                <div class="col-4 form-group">
                                    <label for="meter_id" class="control-label">Meters</label>
                                    <select name="meter_id" id="meter_id" class="form-control">

                                    </select>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-4 form-group">
                                    <label for="prev">Previous</label>
                                    <input type="decimal" class="form-control" id="prev" name="prev" min="0">
                                </div>
                                <div class="col-4 form-group">
                                    <label for="current">Current</label>
                                    <input type="decimal" class="form-control" id="current" name="current" min="0">
                                </div>
                                <div class="col-4 form-group">
                                    <label for="diff">Consumption</label>
                                    <input type="decimal" class="form-control" id="diff" name="diff" min="0">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4 form-group">
                                    <label for="total">Rate</label>
                                    <select name="rate_id" id="rate_id" class="form-control">
                                        <option value="0" selected disabled>Select Rate</option>
                                        <?php
                                        foreach ($rates as $val) { ?>
                                            <option value="<?php echo $val['rate_id']; ?>">
                                                <?php echo $val['base_name'] . '(' . $val['rate_value'] . ')'; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-4 form-group">
                                    <label for="total">Total Amount</label>
                                    <input type="text" class="form-control" id="total" name="total">
                                </div>
                                <div class="col-4 form-group">
                                    <label for="reading_date">Reading Date</label>
                                    <input type="date" class="form-control" id="reading_date" name="reading_date">
                                </div>

                                <?php
                                // Create an array of months
                                $months = [
                                    1 => "January",
                                    2 => "February",
                                    3 => "March",
                                    4 => "April",
                                    5 => "May",
                                    6 => "June",
                                    7 => "July",
                                    8 => "August",
                                    9 => "September",
                                    10 => "October",
                                    11 => "November",
                                    12 => "December"
                                ];

                                // Get the current month and calculate the previous month
                                $currentMonth = date('n'); // 'n' gives the month as a number without leading zeros
                                $previousMonth = $currentMonth == 1 ? 12 : $currentMonth - 1; // Handle December wrapping around to January
                                ?>

                                <div class="form-group col-md-6">
                                    <label for="reading_month">Month</label>
                                    <select name="month" class="form-control" id="reading_month">
                                        <?php foreach ($months as $value => $name): ?>
                                            <option value="<?php echo $value; ?>" <?php echo $value == $previousMonth ? 'selected' : ''; ?>>
                                                <?php echo $name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="customer_id" class="control-label">Tenant</label>
                                    <input type="text" class="form-control" name="customer_id" id="customer_id" readonly
                                        value="customer name">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btn_submit"
                                class="btn btn-rounded btn-outline-primary"><b><?= 'Save' ?></b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


</div>

<style>
    .select2 {
        width: 100% !important;
        font-size: medium;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>
<script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";

    $(document).ready(function () {


        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/reading/fetch_reading_data',
            'order': []

        });

        $('#reading_modal').on('show.bs.modal', function (e) {

            // alert(event.target.id)
            $('#btn_action').val(event.target.id);

            $('#btn_submit').prop('disabled', false);

            if (event.target.id == 'btn_add') {

                $('#data_form')[0].reset();

                $('#btn_submit').show();
                $('#btn_submit').html('Save');

            } else if (event.target.id == 'btn_edit') {

                $('#reading_id').val($(e.relatedTarget).data('reading_id'));
                $('#meter_id').val($(e.relatedTarget).data('meter_id'));
                $('#total').val($(e.relatedTarget).data('total'));
                $('#prev').val($(e.relatedTarget).data('prev'));
                $('#current').val($(e.relatedTarget).data('current'));
                $('#diff').val($(e.relatedTarget).data('diff'));
                $('#reading_date').val($(e.relatedTarget).data('reading_date'));

                $('#btn_submit').show();
                $('#btn_submit').html('Save Changes');

            }

        });

        $('#site_id').on('change', function () {
            $('#ap_id').html('<option value="">loading....</option> ');
            var site_id = $(this).val();
            $.ajax({
                url: base_url + '/apartment/get_apartments',
                type: "POST",
                data: {
                    site_id: site_id
                },
                success: function (response) {
                    $('#ap_id').html(response);
                },
                error: function () {
                    alert('error Occured');
                    $('#ap_id').html('<option value="">Error Occured</option>');
                }
            });
        })
        // ajax code to call fill_meters
        $('#ap_id').change(function () {
            var ap_id = $('#ap_id').val();
            $('#meter_id').html('<option value=""> loading... </option>');
            $('#customer_id').val("getting tenant.....");
            $.ajax({
                url: base_url + '/reading/fill_meters',
                method: "POST",
                dataType: 'json',
                data: {
                    ap_id: ap_id
                },
                success: function (data) {
                    $('#meter_id').html(data.meters);
                    $('#customer_id').val(data.cust);
                }
            });
        });

        $('#meter_id').change(function () {
            var m_id = $('#meter_id').val();
            $.ajax({
                url: base_url + '/reading/get_prev_reading',
                method: "POST",
                data: {
                    mid: m_id
                },
                success: function (data) {
                    $('#prev').val(data);
                }
            });
        });

        $('#current').on('keyup', function () {

            const curr = parseFloat($(this).val());
            let prev = parseFloat($('#prev').val());

            const diff = curr - prev;
            $('#diff').val(diff.toFixed(2));
        });


        $('#rate_id').change(function () {
            var rid = $('#rate_id').val();
            $.ajax({
                url: base_url + '/reading/get_rate_value',
                method: "POST",
                data: {
                    rid: rid
                },
                success: function (data) {
                    let total = parseFloat($('#diff').val()) * parseFloat(data);
                    $('#total').val(total.toFixed(2));
                }
            });
        });




        $('#print_inv').on('show.bs.modal', function (e) {

            $('#bill_no').text($(e.relatedTarget).data('bill_no'));
            $('#ten_name').text($(e.relatedTarget).data('ten_name'));
            $('#bill_amount').text('$' + $(e.relatedTarget).data('total'));
            $('#bill_date').text($(e.relatedTarget).data('bill_date'));
            $('#bill_due').text($(e.relatedTarget).data('bill_due'));
            $('#acc_name').text($(e.relatedTarget).data('acc_name'));

        });

    });

    $(document).on('submit', '#data_form', function (event) {
        form(new FormData(this), '/reading/create_reading', '#data_form', '#reading_modal', '#inner_add');
    });


    $('#advanced').click(function () {
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


    function form(data, controller_funtion, form, modal, inner) {
        event.preventDefault();

        $('#btn_submit').prop('disabled', true);

        $.ajax({
            url: base_url + controller_funtion,
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success === true) {
                    manageTable.ajax.reload(null, false);

                    $('#btn_submit').prop('disabled', false);


                    var width = 1;
                    var id = {};
                    $("#outer").html(response.alert_outer);
                    $("#alert").fadeTo(20200, 500).slideUp(500, function () {
                        $("#alert").slideUp(500);
                    });

                    function progressBar() {
                        id = setInterval(frame, 200);

                        function frame() {
                            if (width >= 100) clearInterval(id);
                            else {
                                width++;
                                $("#progress_bar").css("width", width + "%");
                            }
                        }
                    }
                    progressBar();
                    $(modal).modal('hide');
                    $(form)[0].reset();
                } else {

                    $('#btn_submit').prop('disabled', false);

                    var width = 1;
                    var id = {};
                    $(inner).html(response.alert_inner);
                    $("#alert").fadeTo(20200, 500).slideUp(500, function () {
                        $("#alert").slideUp(500);
                    });

                    function progressBar() {
                        id = setInterval(frame, 200);

                        function frame() {
                            if (width >= 100) clearInterval(id);
                            else {
                                width++;
                                $('#progress_bar').css('width', width + '%')
                            }
                        }
                    }
                    progressBar()
                }
            }
        });
        return false;
    }
</script>

<?= $this->endSection() ?>