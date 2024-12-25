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
                            <li class="breadcrumb-item active" aria-current="page"><?= 'sites' ?></li>
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
                        <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#sitemodel">
                        <?= 'Add' ?>
                        </button> <br>
                        <br/>
                        <div id="messages"></div>

                        <table id="manageTable_site" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr> 
                                    <th>#</th>                                                                                                                                     
                                    <th><?= 'Site Name' ?></th> 
                                    <th><?= 'Site Owner' ?></th> 
                                    <th><?= 'Address'?></th> 
                                    <th><?= 'Built in'?></th> 
                                    <th><?= 'Floors' ?></th> 
                                    <th><?= 'Status' ?></th> 
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

    <!-- add modal content -->
       <!-- add modal -->
    <div id="sitemodel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= 'Add Building' ?></h4>
                    <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            
                <div class="modal-body">
                <div id="inner_add"></div>
                    <form method="post" id="data_form">

                        <div class="modal-body">
                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="site_id" id="site_id">
                            <input type="hidden" name="branch_id" id="branch_id">

                            <div class="form-group mt-3">
                                 <label for="#"> Building name</label>
                                <input type="text" class="form-control" id="sitename" name="sitename" placeholder="" autocomplete="off">
                            </div>   

                            <div class="form-group mt-3">
                                <label for="#">Building Owner</label>
                                <select class="form-control" id="siteOwner" name="siteOwner" autocomplete="off">
                                    <option value="">Select an Owner</option> <!-- Default option -->
                                </select>
                            </div>
   

                            <div class="form-group mt-3" id="BuildingAddressDiv">
                                <label for="#"> Building Address</label>
                                <input type="text" class="form-control" id="siteaddress" name="siteaddress" placeholder="" autocomplete="off">
                            </div> 

                            <div class="form-group mt-3" id="YearBuiltDiv">
                                <label for="#"> Year Built in</label>
                                <input type="date" class="form-control" id="SiteYearBuild" name="SiteYearBuild" placeholder="" autocomplete="off">
                            </div> 

                            <div class="row" id="FloorsAndPrefixRowDiv">
                                <div class="col-md-6">
                            <div class="form-group mt-3">
                               
                                <input type="number" class="form-control" id="floor" name="floor" placeholder="" autocomplete="off">
                            </div>
                            </div> 
                            <div class="col-md-6">
                            <div class="form-group mt-3">
                                
                                <input type="text" class="form-control" id="Prefix" name="Prefix" value="Floor">
                            </div>
                            </div> 
                            </div>
                            <div class="form-group mt-3" id="GenerateFloorsByNumberOrAlphaDiv">
                                <label for="floors">Generate Floors</label>
                                <div class="row">
                               <div class="col-md-5">
                                <input type="radio"  name="floors" id='byname' value="byname"> By Alphabetic
                                </div>
                               <div class="col-md-5">
                               <input type="radio"  name="floors" id="bynum" value="bynum" > By Numeric
                               </div>
                               </div>
                               </div>

                               <div class="form-group mt-3" id="display">
                                <h6 id="num"></h6>
                                <h6 id="name"></h6>
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
    

    $(document).ready(function () {


        // Perform AJAX request to fetch owner data
        $.ajax({
            url: base_url + '/apartment/owner_list', // URL to your route that fetches the owners
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.data) {
                    // Clear the existing options (if any)
                    $('#siteOwner').empty();
                    
                    // Add a default 'Select an Owner' option
                    $('#siteOwner').append('<option value="">Select an Owner</option>');
                    
                    // Populate the select box with owners from the response
                    $.each(response.data, function(index, owner) {
                        // Assuming 'fullname' is the name of the owner and 'owner_id' is the ID
                        $('#siteOwner').append('<option value="' + owner.id + '">' + owner.rec_title + '</option>');
                    });
                }
            },
            error: function() {
                console.error("Error fetching owners.");
            }
        });
    
         // This is hidden by default but when user clicks de-activate this message pops out
         $('#tablesMainNav').addClass('active');

         // get the branch id
         branch_id = <?= session()->get('user')['branch_id'] ?>;
         $('#branch_id').val(branch_id);
         console.log("branch-id: " + branch_id);
         
         if(branch_id != 1){
            console.log("BRANCH-ID IS: " + branch_id);
            fetchTable(branch_id); // initialize the datatable 
         }else{
            console.log("THIS IS THE SUPER-ADMIN");
            fetchTable(1) // initialize the datatable 
         }

         function fetchTable(branch_id) {
            let CI4_ROUTE;

            // Determine which route to use based on the selected site
            CI4_ROUTE = base_url + '/apartment/fetch_sites/' + branch_id;

            // Initialize the DataTable only if it hasn't been initialized yet
            if (!$.fn.dataTable.isDataTable('#manageTable_site')) {
                manageTable_site = $('#manageTable_site').DataTable({
                        destroy: true,
                    'ajax': CI4_ROUTE,  // Dynamic data source URL based on the selected status
                    'order': []         // Optionally specify your table ordering logic
                });
            } else {
                // If the DataTable is already initialized, just reload the data
                manageTable_site.ajax.url(CI4_ROUTE).load();
            }
        }
        
 
        
        $('#deleteMessage').hide();
        $('#name').hide();
            $('#num').hide();

        // If Admin selects to store floors by Numbers
        $('#byname').on("change click", function() {
            $('#num').hide();
            $('#name').show();
            $('#name').html($('#Prefix').val() + ' A ,' +$('#Prefix').val() + ' B ,' +$('#Prefix').val() + ' C, ...');
        });

        // If Admin selects to store floors by Alphabetically
        $('#bynum').on("change click", function() {
            $('#name').hide();
            $('#num').show();
            $('#num').html($('#Prefix').val() + ' 1 ,' +$('#Prefix').val() + ' 2 ,' +$('#Prefix').val() + ' 3, ...');
        });


        // If Add Button clicks it 
        $('#sitemodel').on('show.bs.modal', function(e) {
        //    alert(event.target.id)
            $('#btn_action').val(event.target.id);

            $('#btn_submit').attr('disabled', false)
            $('#sitename').attr('readonly', false)
            $('#siteOwner').attr('readonly', false)
            $('#SiteYearBuild').attr('readonly', false)
            $('#siteaddress').attr('readonly', false)
            $('#Prefix').attr('readonly', false)
            $('#floor').attr('readonly', false)

            if (event.target.id == 'btn_add') {
                $('#btn_submit').show();
                $('#btn_submit').html('S A V E');
            } else if (event.target.id == 'btn_edit') {

                $('#sitename').val($(e.relatedTarget).data('site_name'));
                $('#siteaddress').val($(e.relatedTarget).data('site_address'));
                $('#siteOwner').val($(e.relatedTarget).data('site_owner'));
                $('#SiteYearBuild').val($(e.relatedTarget).data('site_build_year'));
                $('#floor').val($(e.relatedTarget).data('floor'));
                $('#Prefix').val($(e.relatedTarget).data('Prefix'));
                $('#site_id').val($(e.relatedTarget).data('site_id'));
                $('#Prefix').attr('readonly', true)
                $('#floor').attr('readonly', true)

                $('#btn_submit').show();
                $('#btn_submit').html('U P D A T E');
                
                    
            } else if (event.target.id == 'btn_view') {
               
                // setting values
                $('#sitename').val($(e.relatedTarget).data('site_name'));
                $('#siteaddress').val($(e.relatedTarget).data('site_address'));
                $('#SiteYearBuild').val($(e.relatedTarget).data('site_build_year'));
                $('#siteOwner').val($(e.relatedTarget).data('site_owner'));

               
                


                $('#floor').val($(e.relatedTarget).data('floor'));
                $('#Prefix').val($(e.relatedTarget).data('Prefix'));

                // reading data
               $('#sitename').attr('readonly', true)
               $('#siteaddress').attr('readonly', true)
               $('#siteOwner').attr('readonly', true)
               $('#SiteYearBuild').attr('readonly', true)
               $('#Prefix').attr('readonly', true)
                $('#floor').attr('readonly', true)
               $('#btn_submit').hide();
               
            } else if (event.target.id == 'btn_de_activate') {
                
                // setting values
                $('#sitename').val($(e.relatedTarget).data('site_name'));
                $('#siteaddress').val($(e.relatedTarget).data('site_address'));
                $('#siteOwner').val($(e.relatedTarget).data('site_owner'));
                $('#SiteYearBuild').val($(e.relatedTarget).data('site_build_year'));
                $('#floor').val($(e.relatedTarget).data('floor'));
                $('#Prefix').val($(e.relatedTarget).data('Prefix'));
                $('#site_id').val($(e.relatedTarget).data('site_id'));
                $('#Prefix').attr('readonly', true)
                $('#floor').attr('readonly', true)

                $('#btn_submit').show();
                $('#btn_submit').html('DE-ACTIVATE');

                $('#deleteMessage').text("ARE YOU SURE YOU WANT TO DE-ACTIVATE THIS SITE ?");
                $('#deleteMessage').show();
            } else if (event.target.id == 'btn_Activate') {
                
                // setting values
                $('#sitename').val($(e.relatedTarget).data('site_name'));
                $('#siteaddress').val($(e.relatedTarget).data('site_address'));
                $('#siteOwner').val($(e.relatedTarget).data('site_owner'));
                $('#SiteYearBuild').val($(e.relatedTarget).data('site_build_year'));
                $('#floor').val($(e.relatedTarget).data('floor'));
                $('#Prefix').val($(e.relatedTarget).data('Prefix'));
                $('#site_id').val($(e.relatedTarget).data('site_id'));
                $('#Prefix').attr('readonly', true)
                $('#floor').attr('readonly', true)

                $('#btn_submit').show();
                $('#btn_submit').html('ACTIVATE');

                $('#deleteMessage').text("ARE YOU SURE YOU WANT TO ACTIVATE THIS SITE ?");
                $('#deleteMessage').show();
                
            }
           
            // $('#btn_submit').html('Save');
            
        });


         $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/apartment/crud_sites', '#data_form', '#sitemodel', '#inner_add');
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