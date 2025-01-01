<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <?= $this->extend("admin/layouts/base"); ?>

    <?= $this->section('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-4 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url($locale) ?>/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Charge Bills</li>
                        </ol>
                    </nav>
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

                        <h3 class="card-title"> Charge Bills </h3>

                        <br />
                        <div id="messages"></div>

                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tenant Name</th>
                                    <th>Apartment No</th>
                                    <th>Apartment Price</th>
                                    <th>Rent End Date</th>
                                    <th>Bill Duration</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>

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
    <!-- add modal -->
    <div id="invoice_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Invoice Rasing</h4>
                    <button type="button" class="btn-close border-0 p-2" id="resetButton" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">

                    <div id="inner_add"></div>

                    <form id="data_form" method="post">

                        <div class="modal-body">

                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="rental_id" id="rental_id">
                            <input type="hidden" name="owner_id" id="owner_id">

                            <input type="hidden" id="end_date" name="end_date">
                            <input type="hidden" id="ten_id" name="ten_id">


                            <div class="row">

                                <div class="form-group col-12 text-dark">
                                    <label for="inv_price">Invoice Price</label>
                                    <input type="text" class="form-control" id="inv_price" name="inv_price" value="">
                                </div>

                                <div class="form-group col-12 text-dark">
                                    <label for="inv_date">Invoice Date/Month</label>
                                    <input type="date" value="<?= date('Y-m-d') ?>" class="form-control" id="inv_date" name="inv_date" value="">
                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btn_submit" class="btn btn-rounded btn-outline-primary"><b><?= 'Save' ?></b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


 
 
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>
<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/bill/fetch_charging_tenants',
            'order': []
        });


        $('#resetButton').click(function() {
            $('#data_form')[0].reset();
            manageTable.ajax.reload(null, false);
        });

        $('#invoice_modal').on('show.bs.modal', function(e) {
 
            $('#btn_submit').prop('disabled', false);

            //    alert(event.target.id)
            $('#btn_action').val(event.target.id);


            if (event.target.id == 'btn_add') {

                $('#btn_submit').html('Save');

            } else if (event.target.id == 'btn_edit') {

                $('#inv_price').val($(e.relatedTarget).data('price'));
                $('#rental_id').val($(e.relatedTarget).data('rental_id'));
                $('#owner_id').val($(e.relatedTarget).data('owner_id'));

                // $('#end_date').val($(e.relatedTarget).data('end_date'));

                $('#ten_id').val($(e.relatedTarget).data('ten_id'));


                $('#btn_submit').html('Confirm Raising');

            }

        });


        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/bill/raise_rent_invoice', '#data_form', '#invoice_modal', '#inner_add');
        });

    });



    function form(data, controller_function, form, modal, inner) {
        event.preventDefault();

        $('#btn_submit').prop('disabled', true);

        $.ajax({
            url: base_url + controller_function,
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {
                    manageTable.ajax.reload(null, false);

                    $('#btn_submit').prop('disabled', false);

                    var width = 1;
                    var id = {};
                    $("#outer").html(response.alert_outer);
                    $("#alert").fadeTo(20200, 500).slideUp(500, function() {
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

                    // alert(response.alert_inner)
                    var width = 1;
                    var id = {};
                    $(inner).html(response.alert_inner);
                    $("#alert").fadeTo(20200, 500).slideUp(500, function() {
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

    $('#btn_generate_bill').click(function() {

        $(this).attr('disabled', true);

        $.ajax({
            url: base_url + 'bill/generate_bill',
            type: "POST",
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {
                    manageTable.ajax.reload(null, false);

                    $('#btn_generate_bill').hide();

                    $('#btn_submit').prop('disabled', false);

                    var width = 1;
                    var id = {};
                    $("#outer").html(response.alert_outer);
                    $("#alert").fadeTo(20200, 500).slideUp(500, function() {
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
                    var width = 1;
                    var id = {};
                    $(inner).html(response.alert_inner);
                    $("#alert").fadeTo(20200, 500).slideUp(500, function() {
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
                    progressBar();
                }
            }
        });


    });


    function check_bill(month) {

        $.ajax({
            url: base_url + 'bill/check_bill_time',
            type: "POST",
            success: function(response) {

                if (month > response) {

                    $('#btn_generate_bill').show();
                }
            }
        });
    }
</script>

<?= $this->endSection() ?>