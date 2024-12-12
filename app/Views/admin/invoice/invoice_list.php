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
                            <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-12" style="text-align: end">
            <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#invoice_modal"><?= 'Add Bill' ?></button>
            </div>
        </div>
    </div> </br>
    <!-- Data Table  -->
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
                      
                        <div id="messages"></div>

                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Faahfaahin</th>
                                    <th>Supplier</th>
                                    <th>Amount </th>
                                    <th>bill Type </th>
                                    <!-- <th>Paid</th>
                                    <th>Balance</th> -->
                                    <th>Bill Date</th>
                                    <!-- <th>Invoice Status</th> -->
                                    <th><?= 'Action' ?></th>
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

    <!-- add modal content -->
    <div id="invoice_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Supplier Bill</h4>
                    <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="inner_add"></div>

                    <form id="data_form">

                        <div class="modal-body">

                            <input type="hidden" name="btn_action" id="btn_action">

                            <input type="hidden" name="inv_id" id="inv_id">
                            <input type="hidden" name="trx_id" id="trx_id">
                            <input type="hidden" name="prv_ttl" id="prv_ttl">
                            <input type="hidden" name="old_sup_id" id="old_sup_id">


                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="sup_id" class="control-label">Supplier</label>
                                    <select name="sup_id" id="sup_id" class="form-control" required>
                                        <option value="" selected disabled>Select Supplier</option>
                                        <?php
                                        foreach ($suppliers as $val) { ?>
                                            <option value="<?php echo $val['sup_id']; ?>"><?php echo $val['sup_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="account_id" class="control-label">Bill Type</label>
                                    <select name="account_id" id="account_id" class="form-control" required>
                                        <option value="" selected disabled>Select Account</option>
                                        <?php
                                        foreach ($accounts as $val) { ?>
                                            <option value="<?php echo $val['account_id']; ?>"><?php echo $val['acc_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="amount"> Amount </label>
                                    <input type="decimal" class="form-control" id="amount" name="amount" min="0">
                                </div>

                                <div class="col-6 form-group">
                                    <label for="inv_ref"> Invoice No </label>
                                    <input type="text" class="form-control" id="inv_ref" name="inv_ref">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inv_date">Faahfaahin</label>
                                <input type="text" class="form-control" id="inv_rem" name="inv_rem">
                            </div>

                            <div class="form-group">
                                <label for="inv_date">Date</label>
                                <input type="date" class="form-control" id="inv_date" name="inv_date" value="<?= date('Y-m-d') ?>">
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
<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/invoice/fetch_invoices',
            'order': []
        });

    });

    $('#invoice_modal').on('show.bs.modal', function(e) {

        $('#btn_submit').prop('disabled', false);

        // alert(event.target.id)
        $('#btn_action').val(event.target.id);

        $('#btn_submit').attr('disabled', false)
        $('#amount').attr('readonly', false)
        $('#inv_date').attr('readonly', false)


        if (event.target.id == 'btn_add') {

            $('#data_form')[0].reset();

            $('#btn_submit').show();
            $('#btn_submit').html('Save');

        } else if (event.target.id == 'btn_edit') {

            $('#sup_id').val($(e.relatedTarget).data('sup_id'));
            $('#amount').val($(e.relatedTarget).data('amount'));
            $('#inv_date').val($(e.relatedTarget).data('inv_date'));
            $('#inv_id').val($(e.relatedTarget).data('inv_id'));
            $('#ser_id').val($(e.relatedTarget).data('ser_id'));
            $('#inv_ref').val($(e.relatedTarget).data('inv_ref'));
            $('#account_id').val($(e.relatedTarget).data('account_id'));

            $('#trx_id').val($(e.relatedTarget).data('trx_id'));
            $('#prv_ttl').val($(e.relatedTarget).data('amount'));
            $('#inv_rem').val($(e.relatedTarget).data('remarks'));

            $('#old_sup_id').val($(e.relatedTarget).data('sup_id'));


            $('#btn_submit').show();
            $('#btn_submit').html('Save Changes');


        }

        // else if (event.target.id == 'btn_view') {

        //     $('#sup_id').val($(e.relatedTarget).data('sup_id'));
        //     $('#amount').val($(e.relatedTarget).data('amount'));
        //     $('#inv_date').val($(e.relatedTarget).data('exp_date'));
        //     $('#inv_id').val($(e.relatedTarget).data('inv_id'));
        //     $('#inv_ref').val($(e.relatedTarget).data('inv_ref'));
        //     $('#account_id').val($(e.relatedTarget).data('account_id'));
        //     $('#ser_id').val($(e.relatedTarget).data('ser_id'));

        //     $('#inv_rem').val($(e.relatedTarget).data('remarks'));

        //     $('#amount').attr('readonly', true)
        //     $('#inv_ref').attr('readonly', true)
        //     $('#account_id').attr('readonly', true)
        //     $('#ser_id').attr('readonly', true)
        //     $('#btn_submit').hide();
        // }


    });


    $(document).on('submit', '#data_form', function(event) {
        form(new FormData(this), '/invoice/create_invoice', '#data_form', '#invoice_modal', '#inner_add');
    });



    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), 'sites/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
        state_change('sub_users',
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
            url: base_url + 'sites/change_status',
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

        $('#btn_submit').prop('disabled', true);

        event.preventDefault();
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
<?= $this->endSection(); ?>