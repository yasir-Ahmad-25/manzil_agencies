<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <?= $this->extend("admin/layouts/base"); ?>

    <?= $this->section('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-4 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url($locale) ?>/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Rental List</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-12" style="text-align: end">
                <button class="btn btn-primary text-right" id="btn_add" data-bs-toggle="modal"
                    data-bs-target="#rental_modal"><?= 'New Rental' ?></button>
            </div>
        </div>
    </div>
    <!-- Data Table  -->
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

                        <!-- <h3 class="card-title"> Rental List </h3> -->

                        <div id="messages"></div>

                        

                        <div class="form-group mb-3">
                            <label for="#">Search by site: </label>
                            <select name="selected_site" id="selected_site" class="form-control">
                                <option selected disabled>All Sites</option>
                                <?= $sites ?>
                            </select>
                        </div>

                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Apartment No</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Duration</th>
                                    <th>Left Period</th>
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

    <div id="terminate_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
        data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog dialog-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Termination</h4>
                    <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="inner_term"></div>

                    <form id="terminate_form">

                        <input type="text" name="term_rental_id" id="term_rental_id">
                        <input type="text" name="t_ap_id" id="t_ap_id">

                        <input type="text" name="tbal" id="tbal">
                        <input type="text" name="tdep" id="tdep">

                        <div class="row">

                            <div class="form-group col-6 text-dark">
                                <label for="t_tenant">Customer name</label>
                                <input type="text" class="form-control" id="t_tenant" name="t_tenant" disabled>
                            </div>


                            <div class="form-group col-6 text-dark">
                                <label for="t_apartment">Apartment No</label>
                                <input type="text" class="form-control" id="t_apartment" name="t_apartment" disabled>
                            </div>

                        </div>
                            <!-- <div class="form-group col-6 text-dark">
                                <label for="t_bal">Customer balance</label>
                                <input type="text" class="form-control" id="t_bal" name="t_bal" disabled>
                            </div> -->


                            <div class="form-group text-dark">
                                <label for="t_deposit">Deposit</label>
                                <input type="text" class="form-control" id="t_deposit" name="t_deposit" disabled>
                            </div>

                        <div class="row">

                            <div class="form-group col-6 text-dark">
                                <label for="t_s_date">Started Date</label>
                                <input type="date" class="form-control" id="t_s_date" name="t_s_date" disabled>
                            </div>


                            <div class="form-group col-6 text-dark">
                                <label for="t_e_date">End Date</label>
                                <input type="date" class="form-control" id="t_e_date" name="t_e_date" disabled>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-12 text-dark">
                                <label for="t_duration">Duration</label>
                                <input type="text" class="form-control" id="t_duration" name="t_duration" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12 text-dark">
                                <label for="t_reason">Reason</label>
                                <input type="text" class="form-control" id="t_reason" name="t_reason">
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-rounded btn-warning"><b>Confirm</b></button>
                        </div>


                    </form>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div>

    <!-- /.modal-dialog -->
    <div id="relocate_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static'
        data-bs-keyboard='false'>
        <div class="modal-dialog dialog-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Relocate</h4>
                    <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="inner_rel"></div>

                    <form id="relocate_form">

                        <input type="hidden" name="rental_id" id="relocate_rental_id">
                        <input type="hidden" name="curr_apartment" id="rel_curr_apartment">

                        <!-- <input type="hidden" name="tbal" id="tbal"> -->
                        <!-- <input type="hidden" name="tdep" id="tdep"> -->

                        <div class="row">

                            <div class="form-group col-6 text-dark">
                                <label for="t_tenant">Customer name</label>
                                <input type="text" class="form-control" id="rel_t_tenant" name="t_tenant" disabled>
                            </div>


                            <div class="form-group col-6 text-dark">
                                <label for="t_apartment">Current Apartment No</label>
                                <input type="text" class="form-control" id="rel_t_apartment" name="t_apartment" disabled>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-6 text-dark">
                                <label for="t_deposit">New Apartment</label>
                                <!-- <input type="text" class="form-control" id="t_deposit" name="t_deposit" disabled> -->
                                <select class="form-control" name="new_apartment" id="new_apartment">

                                   
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-rounded btn-warning"><b>Confirm</b></button>
                        </div>


                    </form>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div>

    <!-- /.modal-dialog -->


    <div id="extend_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static'
        data-bs-keyboard='false'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Extension</h4>
                    <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="inner_extend"></div>

                    <form id="extend_form">

                        <input type="hidden" name="extend_rental_id" id="extend_rental_id">

                        <input type="hidden" name="extend_ten_id" id="extend_ten_id">

                        <div class="row">

                            <div class="form-group col-6 text-dark">
                                <label for="_date"><?= 'Started date' ?></label>
                                <input type="date" class="form-control" id="s_date" name="s_date" disabled>
                            </div>


                            <div class="form-group col-6 text-dark">
                                <label for="e_date"><?= 'End date' ?></label>
                                <input type="date" class="form-control" id="e_date" name="e_date" disabled>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-12 text-dark">
                                <label for="prev_duration"><?= 'Duration' ?></label>
                                <input type="text" class="form-control" id="prev_duration" name="prev_duration"
                                    disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-6 text-dark">
                                <label for="new_end_date"><?= 'New Date' ?></label>
                                <input type="date" class="form-control" id="new_end_date" name="new_end_date" value="">
                            </div>

                            <div class="form-group col-6 text-dark">
                                <label for="extra_duration"><?= 'Extra duration' ?></label>
                                <input type="text" class="form-control" id="extra_duration" name="extra_duration"
                                    readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12 text-dark">
                                <label for="extra_charges">Charges</label>
                                <input type="number" class="form-control" id="extra_charges" name="extra_charges"
                                    min="0">
                            </div>
                        </div>

                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-info"><b>Confirm Extend</b></button>
                </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->


    <div id="print_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static'
        data-bs-keyboard='false'>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Print Rental Agreement</h4>
                    <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add_form" enctype="multipart/form-data">
                        <div class="row" id="print_area">
                            <div class="col-md-12 pb-3">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <img style="width:150px;"
                                            src="<?= base_url() ?>/public/assets/images/core/logo-vertical.png"
                                            alt="Logo" width="300">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                            <div class="col-md-12" id="invoice_data">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <h2>RENTAL AGREEMENT</h2>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-12 py-2 row" style="margin:10px">
                                        <p>
                                            Maanta oo ay taariikhdu tahay <b> 18/03/2023</b> waxaa Heshiiskan Kiro kala
                                            saxeexanaaya dhinacyada soo socda: Magaca Kireeyaha <b><span
                                                    id="r-site"></span></b> oo sita aqoonsi lambar <b> 1234568589 </b>
                                            (eeg lifaaqa dokumentiga kireystaha). </p>

                                        <p>
                                            Iyo
                                        </p>

                                        <p>
                                            Magaca Kireystaha <b> <span id="r-tenant"></span> </b> oo Sita aqoonsi
                                            lambar <b>123456896</b> (eeg lifaaqa dokumentiga kireystaha).
                                        </p>

                                        <p>
                                            Kireeyuhu wuxuu ka ijaarayaa Kireesytaha, isagoo raali ka ah, apartment ku
                                            yaalla Degmada <b> <span id="r-addr"></span></b> ee gobolka <b>Benaadir</b>
                                            ee lambarkiisu yahay <b><span id="r-apno"></span>.</b>
                                        </p>

                                        <p>
                                            Muddada heshiiska kirada waa <b><span id="r-dur"></span> </b> oo ka
                                            bilaabaneysa <b><span id="r-sdate"></span></b> kuna eg <b><span
                                                    id="r-edate"></span>.</b>
                                        </p>

                                        <p>
                                            Dhinacyadu waxay ku heshiiyeen in qiimaha kirada apaartmentka laga bixinaayo
                                            ay tahay bishiiba <b>US$(<span id="r-price"></span>)</b>, qimahaas oo uu ku
                                            bixinaayo Kireysataha shanta bisha (5ta).
                                        </p>
                                        <p>
                                            Lacag bixintaas waa in ay ku caddahay qoraal uu bixinaayo Kireeyaha.
                                        </p>

                                        <p>
                                            Dhinacyadu waxay ku heshiiyeen in ka hor intaanu Kirestaha guriga deggin uu
                                            bixiyo siiyana Kireeyaha lacag dibaaji ah ee u dhiganta 2 bil kiradood, ahna
                                            <b>US$ (<span id="r-deposit"></span>)</b> oo dollar
                                        </p>

                                        <table style="width:100%" cellpadding="4">
                                            <tr>
                                                <th> <b> Kireeyaha </b></th>
                                                <th> <b>Kireystaha </b> </th>
                                            </tr>

                                            <tr>
                                                <td>Magaca : <b> <span id="r-owner"></span> </b> </td>
                                                <td>Magaca: <b> <span id="r-ten_name"></span> </b> </td>
                                            </tr>

                                            <tr>
                                                <td>Saxiixa : __________________________ </td>
                                                <td>Saxiixa: ___________________________ </td>
                                            </tr>

                                            <tr>
                                                <td> Taariikh: __________________________ </td>
                                                <td>Taariikh: ___________________________ </td>
                                            </tr>
                                        </table>


                                        </p>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" id="advanced" class="btn btn-rounded btn-info"><b>Print</b></button>
                            <button type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal"
                                aria-label="Close"><b>Close</b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="rental_modal" class="modal fade" role="dialog" aria-hidden="true" data-bs-backdrop='static'
        data-bs-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= 'Rental Agreement' ?></h4>
                    <button type="button" class="btn-close border-0 p-2" id="resetButton" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div id="inner_add"></div>

                    <form id="data_form" method="post">

                        <div class="modal-body">

                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="rental_id" id="rental_id">

                            <input type="hidden" id="duration_days" name="duration_days">

                            <div class="row">
                                <div class="form-group col-6 text-dark">
                                    <label for="ten_id"><?= 'Customer name' ?></label>
                                    <select class="form-control border-secondary select2" id="ten_id" name="ten_id"
                                        style="width:100%">
                                        <option selected disabled>Choose Tenant</option>
                                        <?php foreach ($customers as $val): ?>
                                            <option value="<?= $val['customer_id'] ?>"><?= $val['cust_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-6 text-dark">
                                    <label for="ap_id"><?= 'Apartment No' ?></label>
                                    <select class="form-control border-secondary " id="apid_add" name="ap_id">
                                        <!-- <option selected disabled>Choose Apartment</option> -->
                                        <?= $Active_Apartment ?> 
                                    </select>

                                    <select class="form-control border-secondary " id="ap_id" name="ap_id">
                                        <option selected disabled>Choose Apartment</option>
                                        <?php foreach ($all_apartment as $val): ?>
                                            <option value="<?= $val['ap_id'] ?>"><?= $val['ap_no'] ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>


                            </div>

                            <?php $curryear = date('Y-m-d'); ?>


                            <div class="row">

                                <div class="form-group col-6 text-dark">
                                    <label for="start_date"><?= 'Start date' ?></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="<?= $curryear ?>">
                                </div>


                                <div class="form-group col-6 text-dark">
                                    <label for="end_date"><?= 'End date' ?></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-6 text-dark">
                                    <label for="rental_date"><?= 'Rental date' ?></label>
                                    <input type="date" class="form-control" id="rental_date" name="rental_date"
                                        value="<?= $curryear ?>">
                                </div>

                                <div class="form-group col-6 text-dark">
                                    <label for="duration"><?= 'Duration' ?></label>
                                    <input type="text" class="form-control" id="duration" name="duration">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6 text-dark">
                                    <label for="rent_price"><?= 'Price/month' ?></label>
                                    <input type="decimal" class="form-control bg-secondary text-light" id="rent_price" name="rent_price"
                                        min="0" readonly>
                                </div>

                                <div class="form-group col-6 text-dark">
                                    <label for="acc_tag"><?= 'Account' ?></label>
                                    <select class="form-control border-secondary" id="acc_tag_rec" name="acc_tag_rec">
                                        <option selected disabled value="">--------------</option>
                                        <?php foreach ($accounts as $val): ?>
                                            <option value="<?= $val['account_id'] ?>"><?= $val['acc_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>



                            <div class="row">

                                <div class="form-group col-6 text-dark">
                                    <label for="deposit"><?= 'Deposit' ?></label>
                                    <input type="decimal" class="form-control" id="deposit" name="deposit" min="0">
                                </div>
                                <div class="form-group col-6 text-dark">
                                    <label for="acc_tag"><?= 'Account' ?></label>
                                    <select class="form-control border-secondary" id="acc_tag_dep" name="acc_tag_dep">
                                        <option selected disabled value="">--------------</option>
                                        <?php foreach ($accounts as $val): ?>
                                            <option value="<?= $val['account_id'] ?>"><?= $val['acc_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btn_submit"
                                class="btn btn-rounded btn-outline-primary"><b><?= 'Save' ?></b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function () {
        $('#tablesMainNav').addClass('active');

            fetchTable('All_Sites');

            // Event listener to trigger table fetch table when site is selected
            document.getElementById("selected_site").addEventListener("change", function() {
                const selectedSite = this.value;
                fetchTable(selectedSite);
            });

            function fetchTable(site) {
                let CI4_ROUTE;

                // Determine which route to use based on the selected site
                CI4_ROUTE = base_url + '/rental/fetch_rentals/' + site;

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

            $('#apid_add').on('change', function () {

                $.ajax({
                    url: base_url + '/rental/get_apartment_price',
                    type: "POST",
                    data: {
                        ap_id: $(this).val(),
                    },
                    success: function (response) {
                        $("#rent_price").val(response);
                    }
                });
            });

            $('#end_date').change(function () {
                let edate = new Date($(this).val());
                let sdate = new Date($('#start_date').val());

                let dt = calcDate(edate, sdate);

                $('#duration').val(dt);
            });

            $('#new_end_date').change(function () {
                let edate = new Date($(this).val());
                let sdate = new Date($('#e_date').val());

                let dt = calcDate(edate, sdate);

                $('#extra_duration').val(dt);
            });

    });


    $('#rental_modal').on('show.bs.modal', function (e) {

        //    alert(event.target.id)
        $('#btn_action').val(event.target.id);

        $('#btn_submit').attr('disabled', false)
        $('#ten_id').attr('readonly', false)
        $('#ap_id').attr('readonly', false)
        $('#start_date').attr('readonly', false)
        $('#end_date').attr('readonly', false)
        $('#duration').attr('readonly', false)
        $('#rental_date').attr('readonly', false)
        $('#deposit').attr('readonly', false)
        $('#ref_person_id').attr('readonly', false)

        if (event.target.id == 'btn_add') {
            $('#apid_add').show();
            $('#ap_id').hide();
            $('#btn_submit').show();
            $('#btn_submit').html('Save');

            get_apartments(); // FETCHES ALL ACTIVE-APARTMENTS 

        } else if (event.target.id == 'btn_edit') {
            $('#apid_add').hide();
            $('#ap_id').show();
            $('#ten_id').val($(e.relatedTarget).data('ten_id'));
            $('#ap_id').val($(e.relatedTarget).data('ap_id'));

            $('#start_date').val($(e.relatedTarget).data('start_date'));
            $('#end_date').val($(e.relatedTarget).data('end_date'));
            $('#duration').val($(e.relatedTarget).data('duration'));
            $('#rental_date').val($(e.relatedTarget).data('rental_date'));
            $('#deposit').val($(e.relatedTarget).data('deposit'));
            $('#ref_person_id').val($(e.relatedTarget).data('ref_person_id'));

            $('#rental_id').val($(e.relatedTarget).data('rental_id'));
            $('#btn_submit').show();
            $('#btn_submit').html('Save Changes');


        } else if (event.target.id == 'btn_view') {
            $('#apid_add').hide();
            $('#ap_id').show();
            $('#ten_id').val($(e.relatedTarget).data('ten_id'));
            $('#ap_id').val($(e.relatedTarget).data('ap_id'));

            $('#start_date').val($(e.relatedTarget).data('start_date'));
            $('#end_date').val($(e.relatedTarget).data('end_date'));
            $('#duration').val($(e.relatedTarget).data('duration'));
            $('#rental_date').val($(e.relatedTarget).data('rental_date'));
            $('#deposit').val($(e.relatedTarget).data('deposit'));
            $('#ref_person_id').val($(e.relatedTarget).data('ref_person_id'));


            $('#ten_id').attr('readonly', true)
            $('#ap_id').attr('readonly', true)
            $('#start_date').attr('readonly', true)
            $('#end_date').attr('readonly', true)
            $('#duration').attr('readonly', true)
            $('#rental_date').attr('readonly', true)
            $('#deposit').attr('readonly', true)
            $('#ref_person_id').attr('readonly', true)
            $('#btn_submit').hide();
            //    $('#btn_submit').attr('disabled', true)

        }

    });

    $('#print_modal').on('show.bs.modal', function (e) {

        $('#r-sdate').text($(e.relatedTarget).data('start_date'));
        $('#r-edate').text($(e.relatedTarget).data('end_date'));
        $('#r-dur').text($(e.relatedTarget).data('dur'));
        $('#r-rdate').text($(e.relatedTarget).data('rental_date'));
        $('#r-deposit').text($(e.relatedTarget).data('deposit'));
        //    $('#ref_person_id').val($(e.relatedTarget).data('ref_person_id'));

        $('#r-price').text($(e.relatedTarget).data('price'));

        $('#r-tenant').text($(e.relatedTarget).data('ten_name'));
        $('#r-ten_name').text($(e.relatedTarget).data('ten_name'));
        $('#r-owner').text($(e.relatedTarget).data('site_name'));
        $('#r-addr').text($(e.relatedTarget).data('site_address'));
        $('#r-site').text($(e.relatedTarget).data('site_name'));
        $('#r-apno').text($(e.relatedTarget).data('ap_no'));

    });

    $('#extend_modal').on('show.bs.modal', function (e) {

        let edate = $(e.relatedTarget).data('end_date');

        $('#s_date').val($(e.relatedTarget).data('start_date'));
        $('#e_date').val(edate);
        $('#prev_duration').val($(e.relatedTarget).data('duration'));

        $('#new_end_date').attr('min', new Date(edate).toISOString().split('T')[0])

        $('#extend_rental_id').val($(e.relatedTarget).data('rental_id'));
        $('#extend_ten_id').val($(e.relatedTarget).data('ten_id'));

    });

    $('#relocate_modal').on('show.bs.modal', function (e) {
        get_apartments()
        // $('#cur_ap').val($(e.relatedTarget).data('ap_no'));
        $('#rel_curr_apartment').val($(e.relatedTarget).data('ap_id'));
        $('#rel_t_apartment').val($(e.relatedTarget).data('ap_no'));

        $('#rel_t_tenant').val($(e.relatedTarget).data('ten_name'));

        $('#relocate_rental_id').val($(e.relatedTarget).data('rental_id'));

    });

    $('#terminate_modal').on('show.bs.modal', function (e) {

        $('#t_tenant').val($(e.relatedTarget).data('ten_name'));
        $('#t_apartment').val($(e.relatedTarget).data('ap_no'));

        $('#t_deposit').val($(e.relatedTarget).data('deposit'));
        $('#tdep').val($(e.relatedTarget).data('deposit'));

        $('#t_bal').val($(e.relatedTarget).data('balance'));
        $('#tbal').val($(e.relatedTarget).data('balance'));

        $('#t_s_date').val($(e.relatedTarget).data('start_date'));
        $('#t_e_date').val($(e.relatedTarget).data('end_date'));
        $('#t_duration').val($(e.relatedTarget).data('duration'));

        $('#term_rental_id').val($(e.relatedTarget).data('rental_id'));
        $('#t_ap_id').val($(e.relatedTarget).data('ap_id'));

    });

    $(document).on('submit', '#extend_form', function (event) {
        form(new FormData(this), '/rental/extend_rental_duration', '#extend_form', '#extend_modal', '#inner_extend');
    });

    $(document).on('submit', '#terminate_form', function (event) {
        form(new FormData(this), '/rental/terminate_rental_agreement', '#terminate_form', '#terminate_modal', '#inner_term');
    });

    $(document).on('submit', '#relocate_form', function (event) {
        form(new FormData(this), '/rental/relocate_tenant', '#relocate_form', '#relocate_modal', '#inner_rel');
    });


    // save rental record
    $(document).on('submit', '#data_form', function (event) {
        form(new FormData(this), '/rental/record_rentals', '#data_form', '#rental_modal', '#inner_add');
    });

    function calcDate(date1, date2) {
        var diff = Math.floor(date1.getTime() - date2.getTime());
        var day = 1000 * 60 * 60 * 24;

        var days = Math.floor(diff / day);
        var months = Math.floor(days / 31);
        var years = Math.floor(months / 12);

        if (days <= 30 || days <= 31 ) {
            $('#duration_days').val(days);
           
            if (days > 1) {
                return days + ' days'
            }else{
                return days + ' day '
            }
        }else if (months <= 12){
            $('#duration_days').val(months);
            if (months > 1) {
                return months + ' Months '
            }else{
                return months + ' Month '
            }
        }else{
            $('#duration_days').val(years);
            if (years > 1) {
                return years + ' years '
            }else{
                return years + ' year '
            }
        }
    }


    function get_apartments() {

        $("#apid_add").html('<option disabled value="" selected>loading..</option>');
        $("#new_apartment").html('<option disabled value="" selected>loading..</option>');

        $.ajax({
            url: base_url + '/rental/get_active_apartments',
            type: "POST",
            success: function (response) {
                $("#apid_add").html(response);
                $("#new_apartment").html(response);
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
            success: function (response) {
                if (response.success === true) {
                    manageTable.ajax.reload(null, false);


                    var width = 1;
                    var id = {};
                    $("#outer").html(response.alert_outer);
                    $("#alert").fadeTo(20200, 500).slideUp(500, function () {
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
                    $("#alert").fadeTo(20200, 500).slideUp(500, function () {
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