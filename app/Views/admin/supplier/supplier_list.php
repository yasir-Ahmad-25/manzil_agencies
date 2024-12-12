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
            <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#supplier_modal"><?= 'Add Supplier' ?></button> 
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
                                    <th>Supplier Name</th>
                                    <th>Supplier Phone </th>
                                    <th>Supplier Email</th>
                                    <th>Supplier Balance </th>
                                    <th>Reg Date</th>
                                    <th>Status </th>
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
    <div id="supplier_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Supplier Form</h4>
                    <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="inner_add"></div>

                    <form id="data_form">

                        <div class="modal-body">

                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="sup_id" id="sup_id">

                            <div class="form-group">
                                <label for="sup_name">Supplier Name </label>
                                <input type="text" class="form-control" id="sup_name" name="sup_name" autocomplete="off">
                            </div>

                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="sup_phone" class="control-label">Supplier Phone</label>
                                    <input type="text" class="form-control" id="sup_phone" name="sup_phone" autocomplete="off">
                                </div>

                                <div class="col-6 form-group">
                                    <label for="sup_email" class="control-label">Supplier Email</label>
                                    <input type="text" class="form-control" id="sup_email" name="sup_email" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sup_bal"> Balance </label>
                                <input type="number" class="form-control" id="sup_bal" name="sup_bal" min="0" value="0">
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
            'ajax': base_url + '/supplier/fetch_suppliers',
            'order': []
        });

    });

    $('#supplier_modal').on('show.bs.modal', function(e) {

        // alert(event.target.id)
        $('#btn_action').val(event.target.id);

        $('#btn_submit').attr('disabled', false)
        $('#sup_name').attr('readonly', false)
        $('#sup_email').attr('readonly', false)
        $('#sup_phone').attr('readonly', false)
        $('#sup_bal').attr('readonly', false)

        if (event.target.id == 'btn_add') {

            $('#data_form')[0].reset();

            $('#btn_submit').show();
            $('#btn_submit').html('Save');

        } else if (event.target.id == 'btn_edit') {

            $('#sup_name').val($(e.relatedTarget).data('sup_name'));
            $('#sup_phone').val($(e.relatedTarget).data('sup_phone'));
            $('#sup_email').val($(e.relatedTarget).data('sup_email'));
            $('#sup_bal').val($(e.relatedTarget).data('sup_bal'));
            $('#sup_id').val($(e.relatedTarget).data('sup_id'));

            $('#btn_submit').show();
            $('#btn_submit').html('Save Changes');


        } else if (event.target.id == 'btn_view') {

            $('#sup_name').val($(e.relatedTarget).data('sup_name'));
            $('#sup_phone').val($(e.relatedTarget).data('sup_phone'));
            $('#sup_email').val($(e.relatedTarget).data('sup_email'));
            $('#sup_bal').val($(e.relatedTarget).data('sup_bal'));

            $('#btn_submit').attr('disabled', true)
            $('#sup_name').attr('readonly', true)
            $('#sup_email').attr('readonly', true)
            $('#sup_phone').attr('readonly', true)
            $('#sup_bal').attr('readonly', true)
            $('#btn_submit').hide();
        }


    });


    $(document).on('submit', '#data_form', function(event) {
        form(new FormData(this), '/supplier/create_supplier', '#data_form', '#supplier_modal', '#inner_add');
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
                    progressBar()
                }
            }
        });
        return false;
    }
</script>

<?= $this->endSection(); ?>