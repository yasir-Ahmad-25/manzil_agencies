<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= 'Waiters List' ?></h2>
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

                    <div class="col-md-12 align-self-center">
                        <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#waiter_modal"> +
                            <?= lang('Site.button.add') ?></button> <br>
                    </div> <br> <br>

                    <div class="row">


                        <div class="col-md-3 align-self-right">


                        </div>
                    </div>
                    <!-- <h4 class="card-title">  </h4> -->

                    <br />
                    <div id="messages"></div>

                    <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name </th>
                                <th>Phone</th>
                                <th>Pass Code</th>
                                <th>Balance</th>
                                <th>Reg Date</th>
                                <th>Status</th>
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



<!-- form modal -->
<div id="waiter_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Waiter</h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="data_form" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <input type="hidden" name="btn_action" id="btn_action">
                                        <input type="hidden" name="waiter_id" id="waiter_id">
                                        <label>Name</label>
                                        <input type="text" class="form-control border-secondary" name="waiter_name" id="waiter_name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label>Phone</label>
                                        <input type="text" class="form-control border-secondary" name="tel" id="tel">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group text-dark">
                                        <label>Balance</label>
                                        <input type="number" class="form-control border-secondary" name="balance" id="balance">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group text-dark">
                                        <label>Password</label>
                                        <input type="Password" class="form-control border-secondary" name="pass_code" id="pass_code">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group text-dark">
                                        <label>Registration Date</label>
                                        <input type="date" class="form-control border-secondary" name="reg_date" id="reg_date">
                                    </div>
                                </div>

                            


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
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script type="text/javascript">
    var manageTable_site;
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 

        meal_categories();

        function meal_categories() {

            manageTable = $('#manageTable').DataTable({
                'ajax': base_url + '/waiter/fetch_waiters',
                'order': [],
                destroy: true,
                searching: false
            });

        }


        // ------------ Data Passing To Modals ------------ \\
        //-- Details --\\ 
        $('#waiter_modal').on('show.bs.modal', function(e) {
            console.log(event.target.id)

            $('#btn_submit').attr('disabled', false)
            if (event.target.id == 'btn_add') {

                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('Save');

                $('#data_form')[0].reset();
                
            } else {

                $('#waiter_id').val($(e.relatedTarget).data('waiter_id'));
                $('#waiter_name').val($(e.relatedTarget).data('waiter_name'));
                $('#tel').val($(e.relatedTarget).data('tel'));
                $('#pass_code').val($(e.relatedTarget).data('pass_code'));
                $('#balance').val($(e.relatedTarget).data('balance'));
                $('#reg_date').val($(e.relatedTarget).data('reg_date '));
                $('#des').val($(e.relatedTarget).data('des'));

                if (event.target.id == 'btn_edit') {

                    $('#btn_action').val(event.target.id);
                    $('#btn_submit').show();
                    $('#btn_submit').html('Save Changes');

                }
            }
        });

        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/waiter/create_waiter', '#data_form', '#waiter_modal', '#inner_add');
        });

    });

    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), '/util/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
        state_change('Waiter',
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
        $.ajax({
            url: base_url + controller_funtion,
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
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
<?= $this->endSection(); ?>