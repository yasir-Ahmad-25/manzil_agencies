<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= 'Advance Payment' ?></h2>
        </div>
        <div class="col-md-12 align-self-center">
            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#branch_modal"> +
                <?= lang('Site.button.add') ?></button> <br>
        </div>
    </div>
</div>
<!-- Data Table  -->

<div class="container-fluid">
    <div class="card col-md-12">
        <div id="outer"></div>
        <div id="msg" class="alert alert-success alert-dismissible" role="alert" style="display:none;"></div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= 'Date' ?></th>
                            <th><?= 'Tenant Name' ?></th>
                            <th><?= 'Advance Amount' ?></th>
                            <th><?= lang('Site.common.action') ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- add modal -->
<div id="branch_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static'
    data-bs-keyboard='false'>
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"><?= 'Customer Advance Payment' ?></h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="data_form">
                    <div class="row">
                        <div class="row">
                            <div class="form-group col-12 text-dark">
                                <label for="sup_id">Customer Name </label>
                                <select class="form-control border-secondary " id="cust_id" name="cust_id">
                                    <option selected disabled>Choose Customer</option>
                                    <?php foreach ($customers as $val): ?>
                                        <option value="<?= $val['customer_id'] ?>"><?= $val['cust_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <div class="col-12 form-group">
                                <label for="">Amount</label>
                                <input type="number" step="0.01" min="0" name="amount" class="form-control">
                            </div>
                            <div class="form-group col-6 text-dark">
                                    <label for="account_id">Payment Account</label>
                                    <select class="form-control border-secondary " id="account_id" name="account_id">
                                        <option selected disabled>Choose Account</option>
                                        <?php foreach ($accounts as $val) : ?>
                                            <option value="<?= $val['account_id'] ?>"><?= $val['acc_name']  ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <div class="col-12 form-group">
                                <label for="">Date</label>
                                <input type="date"  name="date" class="form-control">
                            </div>
                        </div>
                            

                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="submit_bt"
                            class="btn btn-rounded btn-outline-primary"><b><?= lang('Site.button.save') ?></b></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Status Modal -->
<div id="status_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static'
    data-keyboard='false'>
    <div class="modal-dialog modal-dialog-centered">
        <form id="status_form" enctype="multipart/form-data">
            <div class="modal-content" id="change_state">

            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";

    $(document).ready(function () {

        // ------------ Data table ------------ \\
        var lang = "<?php echo $locale; ?>";
        align = 'dt-left';
        if (lang == 'ar') {
            align = 'dt-right';
        }
        // ------------ Data table ------------ \\
        manageTable = $('#manageTable').DataTable({
            // columnDefs: [
            //     { className: align, targets: [0, 1, 2, 3, 4] },
            // ],
            'ajax': base_url + '/customer/get_advances',
            'order': []
        });

        // ------------ Form Modals ------------ \\ 
        $('#branch_modal').on('show.bs.modal', function (e) {

            console.log(event.target.id)

            $('#btn_action').val(event.target.id);

            $('#btn_submit').attr('disabled', false)
            if (event.target.id == 'btn_add') {

                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('Save');
            } else {
                // $('#myModalLabel').text("<?php echo lang('Site.button.edit') ?>");
                $('#br_id').val($(e.relatedTarget).data('br_id'));
                $('#br_name').val($(e.relatedTarget).data('br_name'));
                $('#br_address').val($(e.relatedTarget).data('br_address'));

                if (event.target.id == 'btn_edit') {

                    $('#btn_action').val(event.target.id);
                    $('#btn_submit').show();
                    $('#btn_submit').html('Save Changes');

                }
            }
        });

        $('#branch_modal').on('hidden.bs.modal', function (e) {
            $(this).find('form')[0].reset();

        });


        $(document).on('submit', '#data_form', function (event) {
            form(new FormData(this), '/customer/customer_advances', '#data_form', '#branch_modal', '#inner_add');
        });

    });

    $(document).on('submit', '#status_form', function (event) { // posting data from status form
        form(new FormData(this), 'home/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function (e) { // passing data to status modal
        state_change('User Type',
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
            url: base_url + 'home/change_status',
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
            success: function (response) {
                $("#change_state").html(response.status);
            }
        });
    }

    function form(data, controller_function, form, modal, inner) {
        event.preventDefault();

        $('#submit_bt').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Saving...');
        $('#submit_bt').attr('disabled', true);

        $.ajax({
            url: base_url + controller_function,
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success === true) {

                    $('#submit_bt').attr('disabled', false);
                    $('#submit_bt').html('Save');

                    $("#msg").html(response.msg).fadeIn(500);
                    setTimeout(function () { $("#msg").fadeOut(); }, 2000);
                    manageTable.ajax.reload(null, false);


                    $(modal).modal('hide');
                    $(form)[0].reset();
                } else {

                    $('#submit_bt').attr('disabled', false);
                    $('#submit_bt').html('Save');

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

<?= $this->endSection(); ?>