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
                            <li class="breadcrumb-item active" aria-current="page"><?= 'owners' ?></li>
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
                        <!-- <h4 class="card-title">  </h4> -->
                        <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#ownermodel">
                        <?= 'Add Owner' ?>
                        </button> <br>
                        <br/>
                        <div id="messages"></div>

                        <table id="manageTable_site" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr> 
                                    <th>#</th>                                                                                                                                     
                                    <th><?= 'Fullname' ?></th> 
                                    <th><?= 'phone'?></th> 
                                    <th><?= 'Email'?></th> 
                                    <th><?= 'Owner Type' ?></th>
                                    <th><?= 'Company Name' ?></th>
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
    <!-- ============================================================== -->

    <!-- add modal content -->
       <!-- add modal -->
    <div id="ownermodel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"></h4>
                    <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            
                <div class="modal-body">
                <div id="inner_add"></div>
                    <form method="post" id="data_form">

                        <div class="modal-body">
                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="owner_id" id="owner_id">
                            <div class="form-group mt-3">
                                 <label for="#"> Full-name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="" autocomplete="off">
                            </div>   

                            <div class="form-group mt-3">
                                 <label for="#"> Phone </label>
                                <input type="text" class="form-control" id="Phone" name="Phone" placeholder="" autocomplete="off">
                            </div>   

                            <div class="form-group mt-3" id="BuildingAddressDiv">
                                <label for="#"> Email </label>
                                <input type="text" class="form-control" id="Email" name="Email" placeholder="" autocomplete="off">
                            </div> 

                            <div class="form-group mt-3 " id="OwnerTypeDiv">
                                <label for="#">Select Owner Type</label>
                                <select name="OwnerType" id="OwnerType" class="form-select">
                                    <option value="" selected disabled></option>
                                    <option value="individual">individual</option>
                                    <option value="Company">Company</option>
                                </select>
                            </div>

                            <div class="form-group mt-3" id="CompanyNameDiv">
                                <label for="#"> Company Name</label>
                                <input type="text" class="form-control" name="companyName" id="companyName">
                            </div>


                            <div class="form-group mt-3">
                                <label for="#">Account Number</label>
                                <input type="text" class="form-control" name="Account_Number" id="Account_Number">
                            </div>
                              
                                            
                        </div>

                        <div class="bg-danger p-2 rounded text-center text-white" id="deleteMessage"></div>
                        <div class="modal-footer">
                            <button type="submit" id="btn_submit" class="btn btn-rounded btn-outline-primary"><b><?= 'save'?></b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    



    <!-- delete modal content -->
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
     const OwnerTypeBox = document.getElementById('OwnerType');

    $(document).ready(function () {
         // This is hidden by default but when user clicks de-activate this message pops out
         $('#tablesMainNav').addClass('active');
         $('#CompanyNameDiv').hide();
        // initialize the datatable 
        manageTable_site = $('#manageTable_site').DataTable({
            'ajax': base_url + '/owner/list',
            'order': []
        });
        
        $('#deleteMessage').hide();

         // Event listener to trigger table update when status is selected
         document.getElementById("OwnerType").addEventListener("change", function() {
                const selectedType = this.value;
                if(selectedType == "Company"){
                    $('#CompanyNameDiv').show();
                }else{
                    $('#CompanyNameDiv').hide();
                }
        });


        // If Add Button clicks it 
        $('#ownermodel').on('show.bs.modal', function(e) {
        //    alert(event.target.id)
            $('#btn_action').val(event.target.id);
            
            $('#btn_submit').attr('disabled', false)
            $('#fullname').attr('readonly', false)
            $('#Phone').attr('readonly', false)
            $('#Email').attr('readonly', false)
            
            $('#CompanyNameDiv').attr('readonly', false)
           
            // Disable the select element
            OwnerTypeBox.disabled = true;

            if (event.target.id == 'btn_add') {
                $('#myModalLabel').text(' Add New Owner ');
                $('#btn_submit').show();
                OwnerTypeBox.disabled = false;
                $('#btn_submit').html('S A V E');
            } else if (event.target.id == 'btn_edit') {

                console.log("edit button triggred: " );
                OwnerTypeBox.disabled = false;
                $('#owner_id').val($(e.relatedTarget).data('owner_id'));
                $('#fullname').val($(e.relatedTarget).data('ownerfullname'));
                $('#Phone').val($(e.relatedTarget).data('ownerphone'));
                $('#Email').val($(e.relatedTarget).data('owneremail'));
                $('#OwnerType').val($(e.relatedTarget).data('ownertype'));
                $('#companyName').val($(e.relatedTarget).data('ownercompanyname'));
                $('#Account_Number').val($(e.relatedTarget).data('owner_account_number'));

                ownerType = document.getElementById("OwnerType").value;                
                if(ownerType != "individual"){
                    $('#CompanyNameDiv').show();
                }else{
                    $('#CompanyNameDiv').hide();
                }

                $('#btn_submit').show();
                $('#btn_submit').html('U P D A T E');
                
                    
            } else if (event.target.id == 'btn_view') {
               
                console.log("view button is triggred");
                
                // setting values
                $('#owner_id').val($(e.relatedTarget).data('owner_id'));
                $('#fullname').val($(e.relatedTarget).data('ownerfullname'));
                $('#Phone').val($(e.relatedTarget).data('ownerphone'));
                $('#Email').val($(e.relatedTarget).data('owneremail'));
                $('#OwnerType').val($(e.relatedTarget).data('ownertype'));
                $('#companyName').val($(e.relatedTarget).data('ownercompanyname'));
                $('#Account_Number').val($(e.relatedTarget).data('owner_account_number'));

                ownerType = document.getElementById("OwnerType").value;                
                if(ownerType != "individual"){
                    $('#CompanyNameDiv').show();
                }else{
                    $('#CompanyNameDiv').hide();
                }
                // reading data
               $('#fullname').attr('readonly', true)
               $('#Phone').attr('readonly', true)
               $('#Email').attr('readonly', true)
               $('#companyName').attr('readonly', true)
               $('#Account_Number').attr('readonly', true)

                // Disable the select element
                OwnerTypeBox.disabled = true;

               $('#btn_submit').hide();
               
            } else if (event.target.id == 'btn_de_activate') {
                
                console.log("DE-ACTIVATE Button is Triggred");
                
                // // setting values
                $('#owner_id').val($(e.relatedTarget).data('owner_id'));
                $('#fullname').val($(e.relatedTarget).data('ownerfullname'));
                $('#Phone').val($(e.relatedTarget).data('ownerphone'));
                $('#Email').val($(e.relatedTarget).data('owneremail'));
                $('#OwnerType').val($(e.relatedTarget).data('ownertype'));
                $('#companyName').val($(e.relatedTarget).data('ownercompanyname'));
                $('#Account_Number').val($(e.relatedTarget).data('owner_account_number'));

                ownerType = document.getElementById("OwnerType").value;                
                if(ownerType != "individual"){
                    $('#CompanyNameDiv').show();
                }else{
                    $('#CompanyNameDiv').hide();
                }

                $('#fullname').attr('readonly', true)
                $('#Phone').attr('readonly', true)
                $('#Email').attr('readonly', true)
                $('#companyName').attr('readonly', true)
                $('#Account_Number').attr('readonly', true)

                // Disable the select element
                OwnerTypeBox.disabled = true;

                $('#btn_submit').show();
                $('#btn_submit').html('DE-ACTIVATE');

                $('#deleteMessage').text("ARE YOU SURE YOU WANT TO DE-ACTIVATE THIS SITE ?");
                $('#deleteMessage').show();
            } else if (event.target.id == 'btn_Activate') {
                
                console.log("Activate button is triggred");
                
                // // setting values
                $('#owner_id').val($(e.relatedTarget).data('owner_id'));
                $('#fullname').val($(e.relatedTarget).data('ownerfullname'));
                $('#Phone').val($(e.relatedTarget).data('ownerphone'));
                $('#Email').val($(e.relatedTarget).data('owneremail'));
                $('#OwnerType').val($(e.relatedTarget).data('ownertype'));
                $('#companyName').val($(e.relatedTarget).data('ownercompanyname'));
                $('#Account_Number').val($(e.relatedTarget).data('owner_account_number'));

                ownerType = document.getElementById("OwnerType").value;                
                if(ownerType != "individual"){
                    $('#CompanyNameDiv').show();
                }else{
                    $('#CompanyNameDiv').hide();
                }

                $('#fullname').attr('readonly', true)
                $('#Phone').attr('readonly', true)
                $('#Email').attr('readonly', true)
                $('#companyName').attr('readonly', true)
                $('#Account_Number').attr('readonly', true)
                // Disable the select element
                OwnerTypeBox.disabled = true;
                $('#btn_submit').show();
                $('#btn_submit').html('ACTIVATE');

                $('#deleteMessage').text("ARE YOU SURE YOU WANT TO ACTIVATE THIS SITE ?");
                $('#deleteMessage').show();
                
            }
           
            // $('#btn_submit').html('Save');
            
        });


         $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/owner/crud_owners', '#data_form', '#ownermodel', '#inner_add');
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
                        manageTable_site.ajax.reload(null, false);
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