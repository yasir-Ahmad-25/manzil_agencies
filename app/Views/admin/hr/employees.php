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
            <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#emp_modal">
                <?= lang('Site.button.add') . ' Employee'; ?>
            </button>
        </div>
    </div>
</div> </br>
<!-- Data Table  -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="mt-3" id="outer"></div>
                <div id="msg" class="alert alert-success alert-dismissible" role="alert" style="display:none;"></div>
                <div id="err" class="alert alert-danger alert-dismissible" role="alert" style="display:none;"></div>

                <div class="card-body">


                    <div class="row">
                        <div class="col-md-3 align-self-right">
                        </div>
                    </div>
                    <br />
                    <div id="messages"></div>

                    <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('Site.common.name') ?></th>
                                <th><?= lang('Site.common.tel') ?></th>
                                <th><?= lang('Site.hr.job') ?></th>
                                <th><?= lang('Site.common.email') ?></th>
                                <th><?= lang('Site.hr.regdate') ?></th>
                                <th><?= lang('Site.common.status') ?></th>
                                <th><?= lang('Site.common.action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- form modal -->
<div id="emp_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"><?= $title ?></h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="data_form" enctype="multipart/form-data">
                    <div class="row">



                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-dark">
                                        <input type="hidden" name="btn_action" id="btn_action">
                                        <input type="hidden" name="emp_id" id="emp_id">
                                        <label><?= lang('Site.common.name') ?></label>
                                        <input type="text" class="form-control border-secondary" name="emp_name" id="emp_name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label><?= lang('Site.common.tel') ?></label>
                                        <input type="text" class="form-control border-secondary" name="emp_phone" id="emp_phone" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label><?= lang('Site.common.email') ?></label>
                                        <input type="email" class="form-control border-secondary" name="emp_email" id="emp_email">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label><?= lang('Site.common.gender') ?></label>
                                        <select class="form-control border-secondary" id="gender" name="gender" required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label><?= lang('Site.common.dob') ?></label>
                                        <input type="date" class="form-control border-secondary" name="dob" id="dob" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label><?= lang('Site.hr.job') ?></label>
                                        <select class="form-control border-secondary" id="job_id" name="job_id" required>
                                            <option value="" disabled selected>Select Position</option>
                                            <?php foreach ($jobs as $val) { ?>
                                                <option value="<?php echo $val['job_id']; ?>"><?php echo $val['job_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label><?= lang('Site.hr.regdate') ?></label>
                                        <input type="date" class="form-control border-secondary" name="date_joining" id="date_joining" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_submit" class="btn btn-rounded btn-outline-primary"><b><?= lang('Site.button.save') ?></b></button>
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
    var manageTable_site;
    var base_url = "<?php echo base_url($locale); ?>";

    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 

        emplist();

        function emplist() {

            var lang = "<?php echo $locale; ?>";
            align = 'dt-left';
            if (lang == 'ar') {
                align = 'dt-right';
            }
            manageTable = $('#manageTable').DataTable({
                columnDefs: [{
                    className: align,
                    targets: [0, 1, 2, 3, 4, 5, 6, 7]
                }, ],
                'ajax': base_url + '/hr/emp_list',
                'order': [],
                destroy: true,
                searching: false
            });

        }


        // ------------ Data Passing To Modals ------------ \\
        //-- Details --\\ 
        $('#emp_modal').on('show.bs.modal', function(e) {
            console.log(event.target.id)

            $('#btn_submit').attr('disabled', false)
            if (event.target.id == 'btn_add') {

                $('#data_form')[0].reset();

                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
            } else {

                $('#emp_id').val($(e.relatedTarget).data('emp_id'));
                $('#emp_name').val($(e.relatedTarget).data('emp_name'));
                $('#gender').val($(e.relatedTarget).data('gender'));
                $('#emp_design').val($(e.relatedTarget).data('emp_design'));

                $('#dob').val($(e.relatedTarget).data('dob'));
                $('#emp_phone').val($(e.relatedTarget).data('emp_phone'));
                $('#emp_email').val($(e.relatedTarget).data('emp_email'));
                $('#date_joining').val($(e.relatedTarget).data('date_joining'));
                $('#job_id').val($(e.relatedTarget).data('job_id'));

                if (event.target.id == 'btn_edit') {

                    $('#btn_action').val(event.target.id);
                    $('#btn_submit').show();
                    $('#btn_submit').html('<?= lang('Site.button.update') ?>');

                }
            }
        });


        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/hr/manage_emp', '#data_form', '#emp_modal', '#inner_add');
        });

    });

    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), '/util/status_changer', '#status_form', '#status_modal', '#inner_status');
    });


    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
        state_change('common',
            $(e.relatedTarget).data('rec_tbl'),
            $(e.relatedTarget).data('rec_tag'),
            $(e.relatedTarget).data('rec_tag_col'),
            $(e.relatedTarget).data('rec_id'),
            $(e.relatedTarget).data('rec_id_col'),
            $(e.relatedTarget).data('rec_title'));
    });


    function state_change(rec_page, rec_tbl, rec_tag, rec_tag_col, rec_id, rec_id_col, rec_title) {
        $.ajax({
            url: base_url + '/util/change_status',
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

        $('#btn_submit').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Saving...');
        $('#btn_submit').attr('disabled', true);

        $.ajax({
            url: base_url + controller_funtion,
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {

                    $('#btn_submit').attr('disabled', false);
                    $('#btn_submit').html('Save');

                    $("#err").hide();
                    $("#msg").html(response.message).fadeIn(500);
                    setTimeout(function() {
                        $("#msg").fadeOut();
                    }, 2000);

                    manageTable.ajax.reload(null, false);

                    $(modal).modal('hide');
                    $(form)[0].reset();
                } else {

                    $('#btn_submit').attr('disabled', false);
                    $('#btn_submit').html('Save');

                    $("#err").html(response.message).fadeIn(500);
                    setTimeout(function() {
                        $("#err").fadeOut();
                    }, 2000);
                }
            }
        });
        return false;
    }
</script>
<?= $this->endSection(); ?>