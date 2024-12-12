<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= $title ?></h2>
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

                    <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#booking_modal">
                        Add Booking
                    </button> <br> <br>

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
                                <th>Hall Name</th>
                                <th>Customer</th>
                                <th>Packs</th>
                                <th>People</th>
                                <th>Total</th>
                                <!--<th>Dis</th>-->
                                <th>BookedDate</th>
                                <th>Start. Date</th>
                                <th>BookTime</th>
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
<div id="booking_modal" class="modal fade" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Hall Booking</h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="data_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">


                                <div class="col-md-4 form-group">
                                    <div class="form-group text-dark">

                                        <input type="hidden" name="btn_action" id="btn_action">
                                        <input type="hidden" name="booking_id" id="booking_id">

                                        <label>Hall Name</label>
                                        <select class="form-control" name="hall_id" id="hall_id">
                                            <option value="" selected disabled>Select Hall</option>
                                            <?php foreach ($halls as $row) { ?>
                                                <option value="<?= $row['hall_id'] ?>" data-price="<?= $row['hall_price'] ?>"><?= $row['hall_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-8 form-group">
                                    <div class="form-group text-dark">

                                        <label>Customer</label>
                                        <select class="form-control select2" name="customer_id" id="customer_id" style="width: 100%;">
                                            <option value="" selected disabled>Select Customer</option>
                                            <?php foreach ($customers as $row) { ?>
                                                <option value="<?= $row['customer_id'] ?>"><?= $row['cust_name'] ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="pack_section">

                                    <div class="pack_child row col-md-12" style="margin: 10px">

                                        <div class="col-md-4 form-group">
                                            <label>Package</label>
                                            <select class="form-control" name="package_id[]" id="package_id">
                                                <option value="">Select Package</option>
                                                <?php foreach ($packages as $row) { ?>
                                                    <option value="<?= $row['hall_pack_id'] ?>" data-packp="<?= $row['hall_pack_price'] ?>"><?= $row['hall_pack_name'] ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label>Participants</label>
                                            <input type="number" class="form-control border-secondary" name="participants[]" id="participants">

                                        </div>
                                        <div class="col-md-3 form-group">

                                            <label>SubTotal</label>
                                            <input type="number" class="form-control border-secondary s_ttl" name="sub_total[]" id="sub_total">
                                        </div>
                                        <div class="col-md-1 form-group nn">
                                            <button type="button" id="btn-pack" class="btn btn-light-info text-info" data-bs-toggle="button" data-more="#sh" aria-pressed="false" style="margin-top: 25px;">
                                                <i class="ti-plus text" aria-hidden="true"></i>
                                                <i class="ti-minus text-active" aria-hidden="true"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-8 form-group">
                                    <div class="form-group text-dark">
                                        <label>Other charges</label>
                                        <input type="text" class="form-control border-secondary" name="other_charges" id="other_charges">
                                    </div>
                                </div>

                                <div class="col-md-4 form-group">
                                    <div class="form-group text-dark">
                                        <label>Total Charges</label>
                                        <input type="decimal" class="form-control border-secondary" name="total_charges" id="total_charges">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group text-dark">
                                        <label>Total</label>
                                        <input type="number" class="form-control border-secondary" name="total" id="total">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group text-dark">
                                        <label>Discount</label>
                                        <input type="number" readonly class="form-control border-secondary" name="discount" id="discount">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="form-group text-dark">
                                        <label>Booking Date</label>
                                        <input type="date" class="form-control border-secondary" name="booking_date" id="booking_date">
                                    </div>
                                </div>

                                <div class="col-md-4 form-group">
                                    <div class="form-group text-dark">
                                        <label>Started Date</label>
                                        <input type="date" class="form-control border-secondary" name="started_date" id="started_date">
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <div class="form-group text-dark">
                                        <label>Start Time</label>
                                        <input type="time" class="form-control border-secondary" name="start_time" id="start_time">
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <div class="form-group text-dark">
                                        <label>End Time</label>
                                        <input type="time" class="form-control border-secondary" name="end_time" id="end_time">
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_submit" class="btn btn-rounded btn-outline-primary"><b><?= 'Save Booking' ?></b></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="extra_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Add Extra Form</h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="inner_add_extra"></div>
                <form id="extra_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">


                                <input type="hidden" id="extra_pack_price">
                                <input type="hidden" id="extra_booking_id" name="extra_booking_id">

                                <input type="hidden" id="extra_ten_id" name="extra_ten_id">

                                <div class="col-md-4 form-group">
                                    <label>Package</label>
                                    <select class="form-control" name="extra_package_id" id="extra_package_id">
                                        <option value="">Select Package</option>
                                        <?php foreach ($packages as $row) { ?>
                                            <option value="<?= $row['hall_pack_id'] ?>" data-extra_pr="<?= $row['hall_pack_price'] ?>"><?= $row['hall_pack_name'] ?></option>
                                        <?php } ?>
                                    </select>

                                </div>

                                <div class="col-md-4 form-group">
                                    <div class="form-group text-dark">
                                        <label>Extra People</label>
                                        <input type="number" class="form-control border-secondary" name="extra_p" id="extra_p">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group text-dark">
                                        <label>Extra Total</label>
                                        <input type="decimal" class="form-control border-secondary" name="extra_total" id="extra_total">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_submit_e" class="btn btn-rounded btn-outline-primary"><b><?= 'Save extra' ?></b></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="other_charge_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Add Other charges</h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="inner_add_charges"></div>
                <form id="charges_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">


                                <input type="hidden" id="other_booking_id" name="other_booking_id">

                                <input type="hidden" id="other_ten_id" name="other_ten_id">

                                <div class="col-md-6 form-group">
                                    <div class="form-group text-dark">
                                        <label>Other charges</label>
                                        <input type="text" class="form-control border-secondary" name="charges_des" id="charges_des">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label>Charges amount</label>
                                        <input type="decimal" class="form-control border-secondary" name="charges_amount" id="charges_amount">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_submit_charges" class="btn btn-rounded btn-outline-primary"><b><?= 'Save' ?></b></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="print_inv" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Print Receipt </h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="add_form" enctype="multipart/form-data">
                    <div class="row" id="print_area">
                        <div class="col-md-12 pb-3">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center">
                                    <img src="<?= base_url() ?>assets/images/core/logo.png" alt="Logo" width="300">
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>
                        <div class="col-md-12" id="invoice_data">

                            <h3 style="margin:20px; font-family:serif;line-height: 2.9; padding:10px">

                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6 text-center">
                                        <h3><?=session()->get('branch_name')?></h3>
                                        <h3>BOOKING AGREEMENT</h3>
                                        Booking Date : <span id="print_date"></span>
                                    </div>


                                    <div style="padding:10px"></div>

                                    <div class="col-md-12">
                                        <table class="table table-bordered table-hover" style="margin:5px; font-family:serif;line-height: 1.5; padding:5px; font-weight:bold">


                                            <tr>
                                                <td>Customer Name</td>
                                                <td id="ten_name"></td>
                                            </tr>
                                            <tr>
                                                <td> Phone Number</td>
                                                <td id="phone_no"></td>
                                            </tr>
                                            <tr>
                                                <td>Taariikhda La kiraystay</td>
                                                <td id="start_date"></td>
                                            </tr>
                                            <tr>
                                                <td>Holka La kiraystay</td>
                                                <td id="hall"></td>
                                            </tr>
                                            <tr>
                                                <td>Tirada guud ee dadka</td>
                                                <td id="capacity"></td>
                                            </tr>
                                            <tr>
                                                <td>Nooca Cuntada</td>
                                                <td>
                                                    <span id="package"> </span>
                                                    <span id="package_pr"> </span>

                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                    <td>Qiimaha Qofkii</td>
                                                    <td id="per_pack_price"></td>
                                                </tr> -->
                                            <tr>
                                                <td>Dalab dheeraad</td>
                                                <td id="dalab_dheer"></td>
                                            </tr>

                                            <tr>
                                                <td>Bixin</td>
                                                <td id="hormaris"></td>
                                            </tr>

                                            <tr>
                                                <td>Discount</td>
                                                <td id="discoon"></td>
                                            </tr>

                                            <tr>
                                                <td>Baaqi</td>
                                                <td id="baaqi"></td>
                                            </tr>

                                            <tr>
                                                <td>Soogalid</td>
                                                <td id="starts"></td>
                                            </tr>

                                            <tr>
                                                <td>Kabixid</td>
                                                <td id="ends"></td>
                                            </tr>

                                        </table>
                                    </div>

                                    <div class="col-md-6 py-2 ">
                                        <!--<div class="col-md-12"> Recipient:</div>-->

                                    </div>

                                </div>
                        </div>

                        </h3>


                        <div class="col-md-10" id="invoice_data">
                            <div class="row">

                                <h3 style="margin:10px; font-family:serif;line-height: 2; padding:10px">

                                    <div class="">


                                        <h2> Fiiro Gaara</h2>


                                        <p>1. Lacagta Carbuunta hadii aad heshiiskda kabaxdo 24 saac gudahood waxaa kaa go'aysta 60%, wixii 24 ka badan way kaa waada go'aysaa.</p>
                                        <p>2. DJ, Camera man, Invitation, boorka adaa keensanaya malinka invitationka aad keensanaysidna waxa bixinaysaa lacagta baaqiga kugu ah.</p>
                                        <p>3. Boorka haddaa kusoo doonan wayso 3 maalin kadib arooska kadib, hotelka masuul kama ahan.</p>
                                        <p>4. Wixii heshiis kan kabaxsan ee lacuno ama lacabo ee banaanka laga keeno lama ogola.</p>
                                        <!-- <p>=MAHADSANID=</p> -->

                                    </div>

                                    <table class="table">
                                        <tr>
                                            <td colspan="2"> Saxiixa Macmiilka </td>
                                            <td></td>
                                            <td colspan="2"> Saxiixa Maamulka </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2"> ________________________________ </td>
                                            <td></td>
                                            <td colspan="2"> ________________________________ </td>
                                        </tr>
                                    </table>

                                    </hr>


                                </h3>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <!-- <a id="advanced" href="#nada" class="button button-primary">Print kittens</a> -->
                        <button type="button" id="advanced" class="btn btn-rounded btn-info"><b>Print</b></button>
                        <button type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal" aria-label="Close"><b>Close</b></button>
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
<script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>
<script type="text/javascript">
    var manageTable_site;
    var base_url = "<?php echo base_url($locale); ?>";
    var pack_price = 0;
    let total = 0;


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 

        clear_prev_bookings();

        hall_bookings();

        function hall_bookings() {

            manageTable = $('#manageTable').DataTable({
                'ajax': base_url + '/booking/fetch_booking',
                'order': [],
                destroy: true,
                // searching: false
            });

        }

        // ------------ Data Passing To Modals ------------ \\
        //-- Details --\\ 
        $('#booking_modal').on('show.bs.modal', function(e) {
            console.log(event.target.id)

            $('#btn_submit').prop('disabled', false);

            if (event.target.id == 'btn_add') {
                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('Save');

            } else if (event.target.id == 'btn_edit') {
                $('#booking_id').val($(e.relatedTarget).data('booking_id'));
                $('#hall_id').val($(e.relatedTarget).data('hall_id'));
                $('#customer_id').val($(e.relatedTarget).data('customer_id'));
                $('#package_id').val($(e.relatedTarget).data('package_id'));
                $('#participants').val($(e.relatedTarget).data('participants'));
                $('#package_price').val($(e.relatedTarget).data('package_price'));
                $('#total').val($(e.relatedTarget).data('total'));
                $('#total_charges').val($(e.relatedTarget).data('total_charges'));
                $('#other_charges').val($(e.relatedTarget).data('other_charges'));
                $('#discount').val($(e.relatedTarget).data('discount'));
                $('#booking_date').val($(e.relatedTarget).data('booking_date'));
                $('#started_date').val($(e.relatedTarget).data('started_date'));
                $('#start_time').val($(e.relatedTarget).data('start_time'));
                $('#end_time').val($(e.relatedTarget).data('end_time'));
                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('Save Changes');
            }
        });
        $('#booking_modal').on('hidden.bs.modal', function(e) {

            $(this).find('#data_form')[0].reset();
        });

        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/booking/create_booking', '#data_form', '#booking_modal', '#inner_add');
        });

        $(document).on('submit', '#extra_form', function(event) {
            form(new FormData(this), '/booking/add_extra_people', '#extra_form', '#extra_modal', '#inner_add_extra');
        });

        $(document).on('submit', '#charges_form', function(event) {
            form(new FormData(this), '/booking/add_other_charges', '#charges_form', '#other_charge_modal', '#inner_add_charges');
        });

    });

    $('#extra_modal').on('show.bs.modal', function(e) {

        let booking_id = $(e.relatedTarget).data('booking_id');

        $('#extra_ten_id').val($(e.relatedTarget).data('customer_id'));

        // $('#extra_pr').val($(e.relatedTarget).data('pack_price'));
        // $('#extra_pack_price').val($(e.relatedTarget).data('pack_price'));

        $('#extra_booking_id').val($(e.relatedTarget).data('booking_id'));


    });

    $("#extra_p").on('keyup', function() {
        const extra_p = $(this).val();
        let pack_price = $('#extra_package_id option:selected').data('extra_pr');

        const total = pack_price * extra_p;
        $('#extra_total').val(total);

    });

    $('#other_charge_modal').on('show.bs.modal', function(e) {

        let booking_id = $(e.relatedTarget).data('booking_id');

        $('#other_ten_id').val($(e.relatedTarget).data('customer_id'));

        // $('#extra_pr').val($(e.relatedTarget).data('pack_price'));
        // $('#extra_pack_price').val($(e.relatedTarget).data('pack_price'));

        $('#other_booking_id').val($(e.relatedTarget).data('booking_id'));

    });


    $('#print_inv').on('show.bs.modal', function(e) {

        let booking_id = $(e.relatedTarget).data('booking_id');

        $.ajax({
            url: base_url + '/booking/get_booking_balance',
            type: "POST",
            dataType: 'json',
            data: {
                booking_id: booking_id,
            },
            success: function(response) {
                $('#hormaris').text('$' + response.advance);
                $('#baaqi').text('$' + response.balance);
                $('#discoon').text('$' + response.dis);
            }
        });

        $('#ten_name').text($(e.relatedTarget).data('ten_name'));
        $('#phone_no').text($(e.relatedTarget).data('ten_tel'));
        $('#hall').text($(e.relatedTarget).data('hall'));
        $('#package').text($(e.relatedTarget).data('package'));
        $('#package_pr').text($(e.relatedTarget).data('package_pr'));
        $('#booking').text($(e.relatedTarget).data('booking_date'));
        $('#start_date').text($(e.relatedTarget).data('started_date'));

        $('#capacity').text($(e.relatedTarget).data('participants'));
        $('#price_person').text($(e.relatedTarget).data('price'));
        $('#starts').text($(e.relatedTarget).data('start_time'));
        $('#ends').text($(e.relatedTarget).data('end_time'));

        $('#dalab_dheer').text($(e.relatedTarget).data('dalab_dheer'));

        $('#per_pack_price').text('$' + $(e.relatedTarget).data('pack_price'));

        $('#print_date').text($(e.relatedTarget).data('booking_date'));


    });


    // $('#package_id').on('change', function() {
    //     var package_id = $(this).val();
    //     pack_price = $('option:selected', this).data("packp");

    //     if ($('#participants').val() != "") {
    //         const capacity = parseFloat($('#participants').val());
    //         const total = pack_price * capacity;
    //         $('#total').val(total);
    //     }

    // });

    $('#hall_id').on('change', function() {

        $('#participants').val('');
        $('#total').val('');

    });

    // $("#participants").on('keyup', function() {

    //     const capacity = $(this).val();
    //     let total = pack_price * capacity;
    //     $('#total').val(total);


    //     total_ch = $('#total_charges').val();

    //     total = parseFloat(total) + parseFloat(total_ch);
    //     $('#whole_total').val(total);

    // });

    $('#total_charges').on('keyup', function() {

        let ttl = 0;
        let total_ch = $('#total_charges').val() == "" ? 0 : $('#total_charges').val();

        $(".s_ttl").each(function() {
            ttl = ttl + parseInt($(this).val());
        });

        ttl += parseFloat(total_ch);

        $('#total').val(ttl);

    });



    $('#btn-pack').on('click', function() {

        let new_row = `<div class="col-md-4 form-group">
                                                <label>Package</label>
                                                <select class="form-control pkp" name="package_id[]" id="package_id">
                                                    <option value="">Select Package</option>
                                                    <?php foreach ($packages as $row) { ?>
                                                        <option value="<?= $row['hall_pack_id'] ?>" data-packp="<?= $row['hall_pack_price'] ?>"><?= $row['hall_pack_name'] ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>

                                            <div class="col-md-4 form-group">
                                                <label>Participants</label>
                                                <input type="number" class="form-control border-secondary" name="participants[]" id="participants">

                                            </div>
                                            <div class="col-md-3 form-group">

                                                <label>SubTotal</label>
                                                <input type="number" class="form-control border-secondary s_ttl" name="sub_total[]" id="sub_total">
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <button type="button" class="btn btn-light-info text-danger rm-row" data-bs-toggle="button" data-more="#sh" aria-pressed="false" style="margin-top: 25px;">
                                                    <i class="ti-trash" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            </div>`;


        $(this).closest("div.pack_section").append('<div class="row col-12 pack_child" style="margin: 6px">' + new_row + '</div>');

    });

    $(document).on('click', '.rm-row', function() {

        let ttl = 0;
        let total_ch = $('#total_charges').val() == "" ? 0 : $('#total_charges').val();

        $(this).closest("div.pack_child").remove();

        $(".s_ttl").each(function() {
            ttl = ttl + parseInt($(this).val());
        });

        ttl += parseFloat(total_ch);
        $('#total').val(ttl);
    });

    $('body').on('keyup', '#participants', function() {


        let selected_package = $(this).closest('.pack_child').find('#package_id').find(':selected').text();

        if (selected_package == "Hool banan") {

            let price = $('#hall_id').find(':selected').data('price');

            $(this).closest('.pack_child').find("#sub_total").val(price);
            $('#total').val(price);

        } else {

            package_price = $(this).closest('.pack_child').find('#package_id').find(':selected').data('packp');
            let sub_ttl = package_price * parseFloat($(this).val());

            $(this).closest('.pack_child').find("#sub_total").val(sub_ttl);

            let ttl = 0;

            let total_ch = $('#total_charges').val() == "" ? 0 : $('#total_charges').val();

            $(".s_ttl").each(function() {
                ttl = ttl + parseInt($(this).val());
            });

            ttl += parseFloat(total_ch);
            $('#total').val(ttl);
        }
    });

    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), '/booking/delete_booking', '#status_form', '#status_modal', '#inner_status');
    });

    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
        state_change('Hall Booking',
            $(e.relatedTarget).data('rec_tbl'),
            $(e.relatedTarget).data('rec_tag'),
            $(e.relatedTarget).data('rec_tag_col'),
            $(e.relatedTarget).data('rec_id'),
            $(e.relatedTarget).data('rec_id_col'),
            $(e.relatedTarget).data('rec_title'));
    });


    function clear_prev_bookings() {
        $.ajax({
            url: base_url + '/booking/clear_prev_booking',
            type: "POST",
            //dataType: 'json',
            data: {},
            success: function(response) {
                console.log(response);
            }
        });
    }



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

        $('#btn_submit').prop('disabled', true);
        $('#btn_submit_e').prop('disabled', true);
        $('#btn_submit_charges').prop('disabled', true);

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

                    $('#btn_submit').prop('disabled', false);
                    $('#btn_submit_e').prop('disabled', false);
                    $('#btn_submit_charges').prop('disabled', false);

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

                    $('#btn_submit').prop('disabled', false);
                    $('#btn_submit_e').prop('disabled', false);
                    $('#btn_submit_charges').prop('disabled', false);

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

    $('#advanced').click(function() {
        $('#print_area').printThis({
            debug: false, // show the iframe for debugging
            importCSS: true, // import parent page css
            importStyle: true, // import style tags
            printContainer: true, // print outer container/$.selector
            loadCSS: "<?php echo base_url() ?>public/assets/css/style.min.css", // path to additional css file - use an array [] for multiple
            pageTitle: "Report", // add title to print page
            removeInline: false, // remove inline styles from print elements
            printDelay: 333, // variable print delay
            header: null, // prefix to html
            footer: null, // postfix to html
            base: false, // preserve the BASE tag, or accept a string for the URL
            formValues: true, // preserve input/form values
            canvas: false, // copy canvas content
            doctypeString: '...', // enter a different doctype for older markup
            removeScripts: false, // remove script tags from print content
            copyTagClasses: false, // copy classes from the html & body tag
            beforePrintEvent: null, // function for printEvent in iframe
            beforePrint: null, // function called before iframe is filled
            afterPrint: null // function called before iframe is removed
        });
    });


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