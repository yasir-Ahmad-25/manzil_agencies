<?= $this->extend("admin/layouts/base"); ?>
<?= $this->section('content'); ?>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <!--                        <h4 class="page-title">Starter Page</h4>-->
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= 'floor' ?></li>
                         </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 align-self-center d-none d-md-block">
                <!--<button class="btn float-right btn-success"><i class="mdi mdi-plus-circle"></i> Create</button>-->
                <div class="dropdown float-right mr-2 hidden-sm-down">

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
                        <!-- <h4 class="card-title"> Manage Property </h4> -->
                        <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#floormodel"><?= 'add' ?></button> <br>
                        <br />
                        <div id="messages"></div>

                        <table id="manageTable_floors" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= 'Floor Name' ?></th>
                                    <th><?= 'Site Name'?></th>
                                    <th><?= 'Apartments' ?></th>
                                    <th><?= 'Status' ?></th>
                                    <th><?='Action' ?></th>
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
    <div id="floormodel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= 'floor' ?></h4>
                    <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="data_form">

                        <div class="modal-body">
                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="floor_id" id="floor_id">
                            <div class="form-group">
                                <label for="type_name"><?= 'floor name'?></label>
                                <input type="text" class="form-control" id="floor_name" name="floor_name" placeholder="" autocomplete="off">
                            </div>

                            <div class="form-group text-dark">
                                <label for="cmd_site"><?= 'site name' ?></label>
                                <select class="form-control border-secondary " id="site_id" name="site_id">
                                    <option selected disabled>Choose Building</option>
                                   

                                    <?php foreach ($site_type as $types) : ?>
                                        <option value="<?= $types['site_id'] ?>"><?= $types['site_name']  ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btn_submit" class="btn btn-rounded btn-outline-primary"><b><?= 'save' ?></b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <!-- Status Modal -->
    <div id="status_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
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
var base_url = "<?php echo base_url($locale); ?>";
    var manageTable;
    var lang = "<?php echo $locale; ?>";
 

    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 
        manageTable = $('#manageTable_floors').DataTable({
            'ajax': base_url + '/apartment/fetch_floors',
            'order': []
        });



        $('#floormodel').on('show.bs.modal', function(e) {

            // alert(event.target.id)
            $('#btn_action').val(event.target.id);

            $('#btn_submit').attr('disabled', false)
            $('#floor_name').attr('readonly', false)
            $('#site_id').attr('readonly', false)

            if (event.target.id == 'btn_add') {
                $('#btn_submit').show();
                $('#btn_submit').html('Save');
            } else if (event.target.id == 'btn_edit') {

                $('#floor_name').val($(e.relatedTarget).data('floor_name'));
                $('#site_id').val($(e.relatedTarget).data('site_id'));
                $('#floor_id').val($(e.relatedTarget).data('floor_id'));
                $('#btn_submit').show();
                $('#btn_submit').html('Save Changes');


            } else if (event.target.id == 'btn_view') {

                $('#floor_name').val($(e.relatedTarget).data('floor_name'));
                $('#site_id').val($(e.relatedTarget).data('site_id'));
                $('#floor_name').attr('readonly', true)
                $('#site_id').attr('readonly', true)
                $('#btn_submit').hide();
                //    $('#btn_submit').attr('disabled', true)

            }

            // $('#btn_submit').html('Save');

        });


        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/apartment/crud_floors', '#data_form', '#floormodel', '#inner_add');
        });

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