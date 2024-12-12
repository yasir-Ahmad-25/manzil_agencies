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
                        <li class="breadcrumb-item active" aria-current="page"><?= lang('Site.hr.jobs') ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-12" style="text-align: end">
            <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#job_modal">
                <?= lang('Site.button.add') . ' Job'; ?>
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
                <div id="msg" class="alert alert-success alert-dismissible" role="alert" style="display:none;"></div>
                <div id="err" class="alert alert-danger alert-dismissible" role="alert" style="display:none;"></div>

                <div class="card-body">

                    <br />
                    <div id="messages"></div>

                    <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('Site.hr.job_name_en') ?></th>
                                <th><?= 'Base salary' ?></th>
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

<!-- form modal -->
<div id="job_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"><?= 'Jobs' ?></h4>
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
                                        <input type="hidden" name="job_id" id="job_id">

                                        <label><?= lang('Site.hr.job_name_en') ?></label>
                                        <input type="text" class="form-control border-secondary" name="job_name_en" id="job_name" required>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group text-dark">
                                        <label><?= 'Base salary' ?></label>
                                        <input type="text" class="form-control border-secondary" name="job_salary" id="job_salary" required>
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


<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script type="text/javascript">
    var manageTable_site;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 

        job();

        function job() {

            var lang = "<?php echo $locale; ?>";
            align = 'dt-left';
            if (lang == 'ar') {
                align = 'dt-right';
            }
            manageTable = $('#manageTable').DataTable({
                columnDefs: [{
                    className: align,
                    targets: [0, 1, 2, 3]
                }, ],
                'ajax': base_url + '/hr/get_jobs',
                'order': [],
                destroy: true,
                searching: false
            });

        }

        // ------------ Data Passing To Modals ------------ \\
        $('#job_modal').on('show.bs.modal', function(e) {
            console.log(event.target.id)

            $('#btn_submit').attr('disabled', false)
            if (event.target.id == 'btn_add') {


                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('<?= lang('Site.button.save') ?>');
            } else {

                $('#job_id').val($(e.relatedTarget).data('job_id'));
                $('#job_name').val($(e.relatedTarget).data('job_name'));
                // $('#job_name2').val($(e.relatedTarget).data('job_name_ar'));
                $('#job_salary').val($(e.relatedTarget).data('job_salary'));

                if (event.target.id == 'btn_edit') {
                    $('#btn_action').val(event.target.id);
                    $('#btn_submit').show();
                    $('#btn_submit').html('<?= lang('Site.button.update') ?>');

                }
            }
        });

        $('#job_modal').on('hidden.bs.modal', function(e) {
            $(this).find('form')[0].reset();

        });


        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/hr/manage_job', '#data_form', '#job_modal', '#inner_add');
        });

    });

    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), 'tenant/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
        state_change('job',
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


                    $("#msg").html(response.msg).fadeIn(500);
                    setTimeout(function() {
                        $("#msg").fadeOut();
                    }, 2000);
                    manageTable.ajax.reload(null, false);


                    $(modal).modal('hide');
                    $(form)[0].reset();
                } else {

                    $('#btn_submit').attr('disabled', false);
                    $('#btn_submit').html('Save');


                    $("#err").html(response.msg).fadeIn(500);
                    setTimeout(function() {
                        $("#err").fadeOut();
                    }, 2000);
                }
            }
        });
        return false;
    }


    function triggerClick() {
        // alert();
        document.querySelector('#id_img').click();
    }

    function display(e) {
        // alert();
        if (e.files) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#pdis').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }
</script>
<?= $this->endSection('content'); ?>