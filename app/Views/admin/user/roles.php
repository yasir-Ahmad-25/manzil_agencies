<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">

    <div class="row">
        <div class="col-md-4 align-self-center">
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url($locale) ?>/admin">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Types</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="col-md-12" style="text-align: end">
            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#user_type_modal"> +
                <?= lang('Site.button.add') ?>
            </button> 
            <br>
        </div>
    </div>

</div>
<!-- Data Table  -->

<div class="container-fluid">
    <div class="card col-md-12">


        <div id="outer"></div>
        <div class="card-body">



            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= lang('Site.menus.role_en') ?></th>
                            <th><?= lang('Site.menus.role_ar') ?></th>
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
<div id="user_type_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"><?= 'Role Form' ?></h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="data_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-dark">
                                <label><?= 'Role Name' ?></label>
                                <input type="text" class="form-control border-secondary" name="ut_name_en" id="ut_name" required>
                                <input type="hidden" name="btn_action" id="btn_action">
                                <input type="hidden" name="ut_id" id="ut_id">
                            </div>
                            <div class="form-group text-dark">
                                <label><?= 'Role Name Ar' ?></label>
                                <input type="text" class="form-control border-secondary" name="ut_name_ar" id="ut_name_ar" required>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?= lang('Site.menus.details') ?></label>
                                <textarea class="form-control" rows="2" name="ut_des" placeholder="..." id="ut_des"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-outline-primary"><b><?= lang('Site.button.save') ?></b></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Status Modal -->
<div id="status_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
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

    $(document).ready(function() {

        // ------------ Data table ------------ \\
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/settings/roles_list',
            'order': []
        });

        // ------------ Form Modals ------------ \\ 
        $('#user_type_modal').on('show.bs.modal', function(e) {

            console.log(event.target.id)

            $('#btn_action').val(event.target.id);

            $('#btn_submit').attr('disabled', false)
            if (event.target.id == 'btn_add') {

                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('Save');

                $('#data_form')[0].reset();
            } else {

                $('#ut_id').val($(e.relatedTarget).data('ut_id'));
                $('#ut_name').val($(e.relatedTarget).data('ut_name'));
                $('#ut_name_ar').val($(e.relatedTarget).data('ut_name_ar'));
                $('#ut_des').val($(e.relatedTarget).data('ut_des'));

                if (event.target.id == 'btn_edit') {

                    $('#btn_action').val(event.target.id);
                    $('#btn_submit').show();
                    $('#btn_submit').html('Save Changes');

                }
            }
        });


        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/settings/add_user_role', '#data_form', '#user_type_modal', '#inner_add');
        });

    });

    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), 'home/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
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
            success: function(response) {
                $("#change_state").html(response.status);
            }
        });
    }

    function form(data, controller_function, form, modal, inner) {
        event.preventDefault();
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