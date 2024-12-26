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
            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#form_modal"> Add Customer </button>

            <button class="btn btn-warning " id="btn_open_balance" data-bs-toggle="modal" data-bs-target="#open_balance_modal">
                Opening Balance
            </button>
        </div>

    </div>

</div>
<div id="open_balance_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-keyboard='false'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Add Balance</h4>
                <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="inner_open_balance"></div>
                <form id="open_balance_form">


                    <div class="col-md-12">
                        <div class="form-group text-dark">
                            <label><?= 'Customer Name' ?></label>
                            <select class="form-control" name="cust_id" id="cust_id">
                                <option selected disabled>Select customer</option>
                                <?php foreach ($customers as $custom) { ?>
                                    <option value="<?= $custom['customer_id'] ?>"><?= $custom['cust_name'] ?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group text-dark">
                            <label><?= 'Balance' ?></label>
                            <input type="decimal" class="form-control" placeholder="<?= '' ?>" name="cust_op_bal" id="cust_op_bal">
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-rounded btn-outline-primary submit_bt"><b><?= 'Submit' ?></b></button>
            </div>

            </form>
        </div>
    </div>
</div>
<!-- Data Table  -->
<div class="container-fluid">
    <div class="card col-md-12">
        <div id="outer"></div>
        <div class="card-body">
            <!-- <div class="form-group mb-3">
                <label for="#">Search by site: </label>
                <select name="selected_site" id="selected_site" class="form-control">
                    <option selected value="All_Sites">All Sites</option>
                    
                </select>
            </div> -->
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= 'Customer Name' ?></th>
                            <th><?= 'Tell' ?></th>
                            <th><?= 'Email' ?></th>
                            <th><?= 'ID' ?></th>
                            <th><?= 'Ref Person' ?></th>
                            <th><?= 'Balance' ?></th>
                            <th><?= 'Deposit' ?></th>
                            <th><?= 'Action' ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- add modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"><?= 'Manage customer' ?></h4>
                <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="add_form" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-7">
                            <div class="form-group text-dark">
                                <label><?= 'Customer Full Name' ?></label>
                                <input type="text" class="form-control " placeholder="<?= 'Customer Name' ?>" name="cust_name" id="cust_name">
                                <input type="hidden" class="form-control " name="form_tag" id="form_tag">
                                <input type="hidden" class="form-control " name="customer_id" id="customer_id">
                                <input type="hidden" class="form-control " name="branch_id" id="branch_id">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group text-dark">
                                <label for="sex"><?= 'Sex' ?></label>
                                <select class="form-control" name="sex" id="sex">
                                    <option selected disabled><?= 'Select sex' ?></option>
                                    <option value="male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group text-dark">
                                <label><?= 'Tell' ?></label>
                                <input type="text" class="form-control " placeholder="<?= '' ?>" name="cust_tell" id="cust_tell">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group text-dark">
                                <label><?= 'Email' ?></label>
                                <input type="text" class="form-control " placeholder="<?= '' ?>" name="cust_email" id="cust_email">
                            </div>
                        </div>


                        <div class="col-md-5">
                            <div class="form-group text-dark">
                                <label><?= 'Identification' ?></label>
                                <input type="text" class="form-control " placeholder="<?= '' ?>" name="identification" id="identification">
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group text-dark">
                                <label><?= 'Ref Person' ?></label>
                                <input type="text" class="form-control " placeholder="<?= '' ?>" name="ref_name" id="ref_name">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group text-dark">
                                <label><?= 'Ref Person Tell' ?></label>
                                <input type="text" class="form-control" name="ref_phone" id="ref_phone">
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group mb-3 mt-3">
                        <label></label>
                        <select name="selected_site" id="selected_site" class="form-control">
                            <option disabled>-- select available sites --</option>
                        </select>
                    </div> -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-rounded btn-outline-primary btn_submit"><b></b></button>
            </div>

            </form>
        </div>
    </div>
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
    var lang = "<?php echo $locale; ?>";
    // const selectedSiteBox = document.getElementById('selected_site');

    $(document).ready(function() {
        var manageTable;

        branch_id = <?= session()->get('user')['branch_id'] ?>;
        $('#branch_id').val("branch_id");
        

        // customerList();
        fetchTable('All_Sites');

    });


        // // Event listener to trigger table fetch table when site is selected
        // document.getElementById("selected_site").addEventListener("change", function() {
        //     const selectedSite = this.value;
        //     fetchTable(selectedSite);
        // });

        function fetchTable(site) {
            let CI4_ROUTE;

            // Determine which route to use based on the selected site
            CI4_ROUTE = base_url + '/customer/fetch_customers/' + site;

            // Initialize the DataTable only if it hasn't been initialized yet
            if (!$.fn.dataTable.isDataTable('#manageTable')) {
                manageTable = $('#manageTable').DataTable({
                    'ajax': CI4_ROUTE,  // Dynamic data source URL based on the selected status
                    'order': []         // Optionally specify your table ordering logic
                });
            } else {
                // If the DataTable is already initialized, just reload the data
                manageTable.ajax.url(CI4_ROUTE).load();
            }
        }

        // function customerList() {
        //     // Check if the DataTable is already initialized
        //     if ($.fn.dataTable.isDataTable('#manageTable')) {
        //         manageTable = $('#manageTable').DataTable();
        //         manageTable.ajax.reload(); // Reload the table data without reinitializing
        //     } else {
        //         manageTable = $('#manageTable').DataTable({
        //             'ajax': base_url + '/customer/fetch_customers',
        //             'order': [],
        //             'destroy': true, // Only needed the first time to destroy old table instances
        //             'searching': false
        //         });
        //     }
        // }


    $(document).on('submit', '#add_form', function(event) {
        form(new FormData(this), '/customer/customer_form', '#add_form', '#form_modal', '#inner_add');
    });
    $(document).on('submit', '#open_balance_form', function(event) {
        form(new FormData(this), '/customer/customer_open_balance', '#open_balance_form', '#open_balance_modal', '#inner_open_balance');
    });
    $(document).on('submit', '#open_balance_form', function(event) {
        form(new FormData(this), '/customer/open_balance_form', '#open_balance_form', '#open_balance_modal', '#inner_open_balance');
    });

    //-- Status --\\ 
    $(document).on('submit', '#status_form', function(event) {
        form(new FormData(this), 'admin/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    // ------------ Data Passing To Modals ------------ \\
    //-- Details --\\ 
    $('#form_modal').on('show.bs.modal', function(e) {
        console.log(event.target.id) 
        $('#form_tag').val(event.target.id);
        $('#cust_name,#cust_tell').attr('readonly', false)
        $('#cust_address,#cust_credit_limit').attr('readonly', false)
        $('#cust_des').attr('readonly', false)
        $('#sex').attr('disabled', false)
        $('#balance').attr('disabled', false)
        $('#btn_submit').attr('disabled', false)
        // Disable the select element
        // selectedSiteBox.disabled = true;
        if (event.target.id == 'btn_add') {

            $('#add_form')[0].reset();
            $('.btn_submit').html('S A V E');
            $('.btn_submit').show();

        } else {
            // selectedSiteBox.disabled = false;
            $('#customer_id').val($(e.relatedTarget).data('customer_id'));
            $('#sex').val($(e.relatedTarget).data('sex'));
            $('#cust_name').val($(e.relatedTarget).data('cust_name'));
            $('#cust_tell').val($(e.relatedTarget).data('cust_tell'));
            $('#cust_email').val($(e.relatedTarget).data('cust_email'));
            $('#balance').val($(e.relatedTarget).data('balance'));
           
            //  in case loo baahdo in lasoo aqriyo site ka uu dagan yahay customer ka 
            // const siteText = $(e.relatedTarget).data('selectedsite'); // Trim any spaces
            // console.log("site Text id: " + siteText);
            // $('#selected_site option').each(function() {
            //     console.log($(this).val() + " is equal to : " + siteText);  // Compare values, not text
            //     if ($(this).val() === siteText) {  // Use .val() instead of .text()
            //         $(this).prop('selected', true); // Set the selected property to true
            //         return false; // Break the loop after finding the match
            //     }
            // });
            

            $('#ref_name').val($(e.relatedTarget).data('ref_name'));
            $('#ref_phone').val($(e.relatedTarget).data('ref_phone'));

            $('#identification').val($(e.relatedTarget).data('identification'));


            if (event.target.id == 'btn_edit') {
                
                $('.btn_submit').html('U P D A T E');
                $('.btn_submit').show();
            } else if (event.target.id == 'btn_det') {
                $('.btn_submit').hide();

            }
        }
    });

    //-- Status --\\ status changer  
    $('#status_modal').on('show.bs.modal', function(e) {
        state_change('users',
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
            url: base_url + 'admin/change_status',
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

        // add button to spinner 
        $('.submit_bt').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Saving...');
        $('.submit_bt').attr('disabled', true);

        $.ajax({
            url: base_url + controller_function,
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success == true) {
                    // manageTable_site.ajax.reload(null, false);
                    $('.submit_bt').attr('disabled', false);
                    $('.submit_bt').html('Submit');

                    fetchTable('All_Sites');


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

                    $('.submit_bt').attr('disabled', false);
                    $('.submit_bt').html('Submit');

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