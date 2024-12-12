<?= $this->extend("layouts/base");?>

<?= $this->section('content');?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center  p-2">
                <h2 class="page-title"><?= lang('Site.user.users') ?></h2>
            </div>
            <div class="col-md-7" style="text-align: end">
                <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#user_modal"> +
                    <?= lang('Site.button.add') ?></button> <br>
            </div>
        </div>
    </div>
    <!-- Data Table  -->
    <div class="container-fluid">
        <div class="card col-md-12">
            <div id="outer"></div>
            <div id="msg" class="alert alert-success alert-dismissible" role="alert" style="display:none;">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="manageTable" class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('Site.common.name') ?></th>
                                <th><?= lang('Site.common.tel') ?></th>
                                <th><?= lang('Site.menus.role') ?></th>
                                <th><?= lang('Site.common.status') ?></th>
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
    <div id="user_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= lang('Site.button.add') ?></h4>
                    <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="data_form" method="post" action="<?= base_url($locale.'/user/crud')?>" enctype="multipart/form-data">

                        <input type="hidden" name="btn_action" id="btn_action">
                        <input type="hidden" name="user_id" id="user_id">

                        <div class="row">
                            <div class="col-md-3  mx-auto">
                                <div class="form-group text-center">
                                    <img src="<?= base_url(); ?>public/assets/images/core/ph.png" onclick="triggerClick()" id="pdis" class="img img-thumbnail">
                                    <input type="file" onchange="display(this)" name="user_img" id="user_img" style="display: none;"><br>
                                    <input type="hidden" class="form-control border-secondary" name="old_img" id="old_img">
                                    <small><i><?= lang('Site.common.image') ?></i></small>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group text-dark">
                                            <label><?= lang('Site.common.name') ?></label>
                                            <input type="text" class="form-control border-secondary" name="user_name" id="user_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group text-dark">
                                            <label><?= lang('Site.common.tel') ?></label>
                                            <input type="text" class="form-control border-secondary" name="user_tell" id="user_tell">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group text-dark">
                                            <label><?= lang('Site.common.email') ?></label>
                                            <input type="text" class="form-control border-secondary" name="user_email" id="user_email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group text-dark">
                                            <label for="utt_id"><?= lang('Site.menus.role') ?></label>
                                            <select class="form-control border-secondary" name="ut_id" id="ut_id">
                                                <option selected disabled><?= lang('Site.menus.role') ?></option>
                                                <?php foreach ($user_types as $types) : ?>
                                                    <option value="<?= $types['ut_id'] ?>"><?= $locale == "ar" ? $types['ut_name_ar'] : $types['ut_name_en']  ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group text-dark">
                                            <label><?= lang('Site.user.username') ?></label>
                                            <input type="text" class="form-control border-secondary" name="username" id="u_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="pass_f">
                                        <div class="form-group text-dark">
                                            <label><?= lang('Site.user.password') ?></label>
                                            <input type="password" class="form-control border-secondary" name="password" id="password">
                                        </div>
                                    </div>


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
var base_url = "<?php echo base_url($locale); ?>";
$(document).ready(function() {
    var manageTable;
    
    var lang = "<?php echo $locale; ?>";
    align = 'dt-left';
    if(lang == 'ar'){
        align = 'dt-right';
    }
    // ------------ Data table ------------ \\
    manageTable = $('#manageTable').DataTable({
        columnDefs: [
            { className: align, targets: [0, 1, 2, 3, 4,5,6] },
        ],
        'ajax': base_url + '/user/users_list',
        'lengthMenu': [
            [25, 50, -1],
            [25, 50, 'All']
        ],
        
    });

    // ------------ Form Modals ------------ \\ 
    $('#user_modal').on('show.bs.modal', function(e) {

        console.log(event.target.id)

        $('#btn_action').val(event.target.id);

        $('#btn_submit').attr('disabled', false)
        if (event.target.id == 'btn_add') {

            $('#btn_action').val(event.target.id);
            $('#btn_submit').show();
            $('#pass_f').show();
            //$('#btn_submit').html('Save');
            $('#data_form')[0].reset();

        } else if (event.target.id == 'btn_edit') {

            $('#user_id').val($(e.relatedTarget).data('user_id'));
            $('#user_name').val($(e.relatedTarget).data('user_name'));
            $('#user_tell').val($(e.relatedTarget).data('user_tell'));
            $('#user_email').val($(e.relatedTarget).data('user_email'));
            $('#ut_id').val($(e.relatedTarget).data('ut_id'));
            $('#u_name').val($(e.relatedTarget).data('u_name'));
            $('#user_status').val($(e.relatedTarget).data('user_status'));

            $('#password').val($(e.relatedTarget).data('password'));
            $('#pass_f').hide();

            

            $('#img_holder').html('<img src="<?= base_url(); ?>assets/images/core/ph.png" onclick="triggerClick()" id="pdis" class="img img-thumbnail"><input type="file" onchange="display(this)" name="user_img" id="id_img" style="display: none;"><br><input type="hidden" class="form-control border-secondary" name="old_img" id="old_img"><small><i>User Image</i></small>');
            $('#pdis').attr('src', $(e.relatedTarget).data('user_img'));
            $('#old_img').val($(e.relatedTarget).data('old_img'));

            $('#btn_action').val(event.target.id);
            $('#btn_submit').show();
            $('#btn_submit').html('Save Changes');

        }

        });


        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/user/crud', '#data_form', '#user_modal', '#inner_add');
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
            // url: base_url + controller_function,
            url: $(form).attr('action'),
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {
                    manageTable.ajax.reload(null, false);

                    $("#msg").html(response.message).fadeIn(500);
                    setTimeout(function() { $("#msg").fadeOut(); }, 2000);


                    
                    $(modal).modal('hide');
                    $(form)[0].reset();
                } else {
                    // var width = 1;
                    // var id = {};
                    // $(inner).html(response.alert_inner);
                    // $("#alert").fadeTo(20200, 500).slideUp(500, function() {
                    //     $("#alert").slideUp(500);
                    // });

                    // function progressBar() {
                    //     id = setInterval(frame, 200);

                    //     function frame() {
                    //         if (width >= 100) clearInterval(id);
                    //         else {
                    //             width++;
                    //             $('#progress_bar').css('width', width + '%')
                    //         }
                    //     }
                    // }
                    // progressBar()
                }
            }
        });
        return false;
    }

    
    function triggerClick() {
        document.querySelector('#user_img').click();
    }

</script>

<?= $this->endSection();?>