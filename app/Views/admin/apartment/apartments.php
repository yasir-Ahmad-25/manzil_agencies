<?= $this->extend("admin/layouts/base"); ?>
<?= $this->section('content'); ?>



 
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <!--                        <h4 class="page-title">Starter Page</h4>-->
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= 'apartment'?></li>
                            <!-- <span> <p> </p></span> -->
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
                        <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#apartment_model"><?='add' ?></button> <br>
                        <br />
                        <div id="messages"></div>

                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= 'Apartment No' ?></th>
                                    <th><?= 'Floor' ?></th>
                                    <th><?= 'Apartment Type' ?></th>
                                    <th><?= 'Price' ?> </th>
                                    <th><?= 'Rooms' ?></th>
                                    <th><?= 'Bedroom' ?></th>
                                    <th><?= 'Pathroom'?></th>
                                    <th><?= 'Kitchen' ?></th>
                                    <th><?= 'Status' ?></th>
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


    <!-- Status Modal -->
    <div id="status_modal" class="modal fade" tabindex="1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog modal-dialog-centered">
            <form id="status_form" enctype="multipart/form-data">
                <div class="modal-content" id="change_state">

                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- delete modal content -->

    <!-- add modal content -->
    <div id="apartment_model" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= 'Apartments' ?></h4>
                    <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form method="post" id="data_form">

                        <div class="modal-body">
                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="ap_id" id="ap_id">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ap_no"><?= 'Apartment no' ?></label>
                                        <input type="text" class="form-control" id="ap_no" name="ap_no" placeholder="" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="floor_id"><?='Buildings' ?></label>
                                        <select class="form-control" id="site_id" name="site_id" required>
                                            <option selected disabled value="">Choose Buildings</option>
                                            <?php foreach ($buildings as $k => $v) : ?>
                                                <option value="<?= $v['site_id'] ?>"><?= $v['site_name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="floor_id"><?='Floor' ?></label>
                                        <select class="form-control" id="floor_id" name="floor_id" required>
                                            <option selected disabled value="">Choose Floor</option>
                                          
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ap_type_id"><?= 'Apartment type'?></label>
                                        <select class="form-control" id="ap_type_id" name="ap_type_id">
                                            <option selected disabled>Choose Type</option>
                                            <?php foreach ($types as $k => $v) : ?>
                                                <option value="<?php echo $v['ap_type_id'] ?>"><?php echo $v['ap_type_name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price"><?='Price' ?></label>
                                        <input type="number" class="form-control" id="price" name="price" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="rooms"><?= 'Number of Rooms' ?></label>
                                <input type="number" class="form-control" id="Rooms" name="Rooms" placeholder="" autocomplete="off" min="1" max="6">
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rooms"><?= 'Bedroom' ?></label>
                                        <input type="number" class="form-control" id="bedrooms" name="bedrooms" placeholder="" autocomplete="off" min="1" max="6">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pathrooms"><?=  'Pathroom'?></label>
                                        <input type="number" class="form-control" id="pathrooms" name="pathrooms" placeholder="" autocomplete="off" min="1">

                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rooms"><?='Description' ?></label>
                                        <input type="text" class="form-control" id="ap_des" name="ap_des" autocomplete="false">

                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rooms"><?= 'Kitchen' ?></label>
                                        <input type="number" class="form-control" id="kitchen" name="kitchen" value="1" min="0" >

                                    </div>
                                </div>

                            </div>



                            <div class="modal-footer">
                                <button type="submit" id="btn_submit" class="btn btn-rounded btn-outline-primary"><b><?= 'Save'?></b></button>
                            </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <!-- ============================================================== -->




</div>


<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script type="text/javascript">
 var base_url = "<?php echo base_url($locale); ?>";
    var manageTable;
    var lang = "<?php echo $locale; ?>";
 

    $(document).ready(function() {
        // $('#tablesMainNav').addClass('active');
        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/apartment/fetch_apartments',
            'order': []
        });


        $('#site_id').on('change',function(){
            $('#floor_id').html('<option value="">loading....</option> ');
            var site_id = $(this).val();
            $.ajax({
            url: base_url + '/apartment/get_floors',
            type: "POST",
            data: {
               site_id:site_id
            },
            success: function(response) {
                $('#floor_id').html(response);
            },
            error:function(){
                alert('error Occured');
                $('#floor_id').html('<option value="">Error Occured</option>');
            }
        });
        })
        $('#apartment_model').on('show.bs.modal', function(e) {

            // alert(event.target.id)
            $('#btn_action').val(event.target.id);

            $('#btn_submit').attr('disabled', false)
            $('#ap_no').attr('readonly', false)
            $('#floor_id').attr('readonly', false)
            $('#ap_type_id').attr('readonly', false)
            $('#price').attr('readonly', false)
            $('#Rooms').attr('readonly', false)
            $('#bedrooms').attr('readonly', false)
            $('#pathrooms').attr('readonly', false)
            $('#kitchen').attr('readonly', false)
            $('#ap_des').attr('readonly', false)


            if (event.target.id == 'btn_add') {
                $('#data_form')[0].reset();

                $('#btn_submit').show();
                $('#btn_submit').html('Save');

            } else if (event.target.id == 'btn_edit') {

                $('#ap_no').val($(e.relatedTarget).data('ap_no'));
                $('#floor_id').val($(e.relatedTarget).data('floor_id'));
                $('#ap_type_id').val($(e.relatedTarget).data('ap_type_id'));
                $('#price').val($(e.relatedTarget).data('price'));
                $('#Rooms').val($(e.relatedTarget).data('rooms_number'));
                $('#bedrooms').val($(e.relatedTarget).data('bedrooms'));
                $('#pathrooms').val($(e.relatedTarget).data('pathrooms'));
                $('#kitchen').val($(e.relatedTarget).data('kitchen'));
                $('#ap_des').val($(e.relatedTarget).data('ap_des'));
                $('#ap_id').val($(e.relatedTarget).data('ap_id'));
                $('#btn_submit').show();
                $('#btn_submit').html('Save Changes');


            } else if (event.target.id == 'btn_view') {

                console.log("Returned data: " + $(e.relatedTarget).data('Rooms'));
                
                $('#ap_no').val($(e.relatedTarget).data('ap_no'));
                $('#floor_id').val($(e.relatedTarget).data('floor_id'));
                $('#ap_type_id').val($(e.relatedTarget).data('ap_type_id'));
                $('#price').val($(e.relatedTarget).data('price'));
                $('#Rooms').val($(e.relatedTarget).data('rooms_number'));
                $('#bedrooms').val($(e.relatedTarget).data('bedrooms'));
                $('#pathrooms').val($(e.relatedTarget).data('pathrooms'));
                $('#kitchen').val($(e.relatedTarget).data('kitchen'));
                $('#ap_des').val($(e.relatedTarget).data('ap_des'));
                $('#ap_no').attr('readonly', true)
                $('#floor_id').attr('readonly', true)
                $('#ap_type_id').attr('readonly', true)
                $('#price').attr('readonly', true)
                $('#bedrooms').attr('readonly', true)
                $('#pathrooms').attr('readonly', true)
                $('#kitchen').attr('readonly', true)
                $('#ap_des').attr('readonly', true)
                $('#btn_submit').hide();
                //    $('#btn_submit').attr('disabled', true)

            }

            // $('#btn_submit').html('Save');

        });


        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/apartment/crud_apartments', '#data_form', '#apartment_model', '#inner_add');
        });



    });

    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), 'property/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
        state_change('Apartment',
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
            url: base_url + 'property/change_status',
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