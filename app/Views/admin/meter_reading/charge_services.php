<!-- Page wrapper  -->
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
                            <li class="breadcrumb-item active" aria-current="page">Charge Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-12" style="text-align: end">
            <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#reading_modal">
                            <?= 'Charge service'; ?>
                        </button>
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

                        <br />
                        <div id="messages"></div>

                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Month</th>
                                    <th>Service Name</th>
                                    <th>Tenant Name</th>
                                    <th>QTY</th>
                                    <th>Total</th>
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





    <!-- delete modal content -->
    <!-- Status Modal -->
    <div id="status_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-dialog-centered">
            <form id="status_form" enctype="multipart/form-data">
                <div class="modal-content" id="change_state">

                </div>
            </form>
        </div>
    </div>

<!-- add modal content -->
<div id="reading_modal" class="modal fade" role="dialog" aria-hidden="true" data-bs-backdrop='static'
        data-bs-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Charge Service Form</h4>
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
                                    <label for="meter_id" class="control-label">Service</label>
                                    <select name="service_id" id="service_id" class="form-control" required>
                                        <option value="" selected disabled>Select Service</option>
                                        <?php
                                        foreach ($services as $val) { ?>
                                            <option value="<?php echo $val['id']; ?>"><?php echo $val['service_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-4 form-group">
                                    <label for="prev">QTY</label>
                                    <input type="number" class="form-control" id="qty" name="qty" min="1">
                                </div>
                                <div class="col-4 form-group">
                                    <label for="current">Price</label>
                                    <input type="decimal" class="form-control" id="price" name="price" min="0">
                                </div>
                                <div class="col-4 form-group">
                                    <label for="diff">Total</label>
                                    <input type="decimal" class="form-control" id="total" name="total" min="0.001">
                                </div>
                            </div>

                            <div class="row">
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
    </div>

</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 

        meal();

        function meal() {

            manageTable = $('#manageTable').DataTable({
                'ajax': base_url + '/reading/fetch_charging_service',
                'order': [],
                destroy: true,
                searching: false
            });

        }

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

        $('#qty').change(function () {
            var qty = $(this).val()
            var price = $('#price').val();

            $('#total').val(parseFloat(qty).toFixed(2) * parseFloat(price))
        })

        $('#service_id').change(function () {
            var s_id = $(this).val();
            $.ajax({
                url: base_url + '/reading/get_service_price',
                method: "POST",
                dataType: 'json',
                data: {
                    s_id: s_id
                },
                success: function (data) {
                    $('#price').val(data.price)
                }
            });
        });
        // ------------ Data Passing To Modals ------------ \\
        $('#reading_modal').on('show.bs.modal', function(e) {
            console.log(event.target.id)

            $('#btn_submit').attr('disabled', false)
            if (event.target.id == 'btn_add') {

                $('#data_form')[0].reset();
                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('Save');
            } else {

                $('#rate_id').val($(e.relatedTarget).data('rate_id'));
                $('#base_name').val($(e.relatedTarget).data('base_name'));
                $('#rate_percentage').val($(e.relatedTarget).data('rate_percentage'));

                if (event.target.id == 'btn_edit') {
                    $('#btn_action').val(event.target.id);
                    $('#btn_submit').show();
                    $('#btn_submit').html('Save Changes');

                }
            }
        });
        $('#rate_modal').on('show.bs.modal', function(e) {
            console.log(event.target.id)

            $('#btn_submit').attr('disabled', false)
            if (event.target.id == 'btn_add') {

                $('#data_form')[0].reset();
                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('Save');
            } else {

                $('#rate_id').val($(e.relatedTarget).data('rate_id'));
                $('#base_name').val($(e.relatedTarget).data('base_name'));
                $('#rate_percentage').val($(e.relatedTarget).data('rate_percentage'));

                if (event.target.id == 'btn_edit') {
                    $('#btn_action').val(event.target.id);
                    $('#btn_submit').show();
                    $('#btn_submit').html('Save Changes');

                }
            }
        });




        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/reading/create_charge_services', '#data_form', '#reading_modal', '#inner_add');
        });

    });

    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), 'tenant/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
        state_change('Rate',
            $(e.relatedTarget).data('rec_tbl'),
            $(e.relatedTarget).data('rec_tag'),
            $(e.relatedTarget).data('rec_tag_col'),
            $(e.relatedTarget).data('rec_id'),
            $(e.relatedTarget).data('rec_id_col'),
            $(e.relatedTarget).data('rec_title'));
    });



    function state_change(rec_page, rec_tbl, rec_tag, rec_tag_col, rec_id, rec_id_col, rec_title) {
        // alert('')
        $.ajax({
            url: base_url + 'tenant/change_status',
            type: "POST",
            dataType: 'json',
            data: {
                rec_id: rec_id,
                rec_id_col: rec_id_col,
                rec_title: rec_title,
                rec_tag: rec_tag,
                rec_tag_col: rec_tag_col,
                rec_tbl: rec_tbl,
                rec_page: rec_page
            },
            success: function(response) {
                $("#change_state").html(response.status);
            }
        });
    }

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

</script>

<?=$this->endSection()?>