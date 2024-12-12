<!-- Page wrapper  -->
<!-- ============================================================== -->

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
                        <li class="breadcrumb-item active" aria-current="page">Rental Bills</li>
                    </ol>
                </nav>
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
                    <h3 class="card-title"> Rental Bills </h3>
                    <div class="row">

                        <!-- <div class="col-md-1 align-self-left"><button class="btn btn-primary" id="btn_add">Due Bills</button> <br></div> -->
                        <br>
                        <div class="col-md-3 align-self-left">

                        </div>
                        <div class="col-md-3 align-self-left">

                            <!-- <select class="form-control border-secondary " id="floor" name="floor">
                                    <option selected disabled>Select Floor</option>


                                </select> -->
                        </div>
                        <div class="col-md-3">
                            <select class="form-control border-secondary " id="rent_type" name="rent_type">
                                <option value="all_bill">All Bills</option>
                                <option value="rent">Rental </option>
                                <option value="bill">Utility </option>
                            </select>
                        </div>
                        <div class="col-md-3 align-self-right">

                            <select class="form-control border-secondary " id="view" name="view">
                                <option value="all_bill">All Bills</option>
                                <option value="unpaid_bill">Unpaid </option>
                                <option value="paid_bill">Paid </option>
                                <option value="partial_bill">Partial</option>
                            </select>
                        </div>
                    </div>

                    <br />
                    <div id="messages"></div>
                    <!-- <div class="table-responsive" id="badale"> -->
                    <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>

                                <th><?= 'Month' ?></th>
                                <th><?= 'Tenant' ?></th>
                                <th><?= 'Total' ?></th>
                                <th>Discount</th>
                                <th>Paid Amount</th>
                                <th>Remaining</th>
                                <th><?= 'Bill Date' ?></th>
                                <th><?= 'Details' ?></th>
                                <th><?= 'Action' ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                    <!-- </div> -->

                    <div class="text-center" id="generate">
                        <!-- <button class="btn btn-success" id="btn_generate">generate</button> <br> -->
                    </div>

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

<div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static'
    data-bs-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"> Bill Payment </h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="add_form" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>Paid amount</label>
                                <input type="text" class="form-control " name="pay_amount" id="pay_amount" min="0">
                                <input type="hidden" name="form_tag" id="form_tag">
                                <input type="hidden" name="bill_id" id="bill_id">

                                <input type="hidden" name="ten_id" id="ten_id">
                                <input type="hidden" name="paid" id="paid">
                                <input type="hidden" name="bill_type" id="bill_type">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>Discount</label>
                                <input type="text" class="form-control " name="discount" id="discount">

                            </div>
                        </div>
                        <div class="form-group col-6 text-dark">
                            <label for="account_id">Payment account</label>
                            <select class="form-control border-secondary" id="account_id" name="account_id" required>
                                <option selected disabled value="">Choose Account</option>
                                <?php foreach ($accounts as $val): ?>
                                    <option value="<?= $val['account_id'] ?>"><?= $val['acc_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>Date</label>
                                <input type="date" class="form-control " name="date" id="date" required>


                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-outline-primary submit"
                            id="btn_submit"><b><?= 'Save' ?></b></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id="cancel_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static'
    data-bs-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"> Cancel Payment </h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div id="inner_add_c"></div>
                <form id="cancel_form" enctype="multipart/form-data">
                    <div class="row">

                        <p style="margin: 10px;"> Are you sure to cancel this payment?</p>

                        <input type="hidden" id="cancel_bill_id" name="cancel_bill_id">
                        <input type="hidden" id="cancel_amount" name="cancel_amount">
                        <input type="hidden" id="cancel_ten_id" name="cancel_ten_id">
                        <input type="hidden" id="trx_id" name="trx_id">
                        <input type="hidden" id="cancel_dis" name="cancel_dis">

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-outline-primary submit"><b>Confirm
                                Cancelation</b></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div id="print_inv" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static'
    data-bs-keyboard='false'>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Print Invoice </h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="add_form" enctype="multipart/form-data">
                    <div class="row" id="print_area">
                        <div class="col-md-12 pb-3">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center">
                                    <img src="" alt="Logo" width="300">
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>
                        <div class="col-md-12" id="invoice_data">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center">
                                    <h2>BILL INVOICE</h2>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-6 py-2 row">
                                    <div class="col-md-12"> From: </div>
                                    <div class="col-md-12"> Barakaale Apartment</div>
                                    <div class="col-md-12"> Address: Hodan, Taleex. Mogadishu, Somalia</div>
                                </div>

                                <div class="col-md-12">
                                    <table class="table ">
                                        <th>

                                        <th>Type </th>
                                        <th>Amount</th>
                                        </th>
                                        <tbody id="print_body">

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6 py-2 ">
                                    <div class="col-md-12"> Issuer:</div>

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



<style>
    .select2 {
        width: 100% !important;
        font-size: medium;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>
<script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";

    $(document).ready(function () {


        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/bill/fetch_bills/all',
            'order': []

        });

        $(document).on('submit', '#add_form', function (event) {
            form(new FormData(this), '/bill/record_receipt', '#add_form', '#form_modal', '#inner_add');
        });
        $(document).on('submit', '#cancel_form', function (event) {
            form(new FormData(this), '/bill/cancel_receipt', '#cancel_form', '#cancel_modal', '#inner_add_c');
        });


        $("#view").change(function () {
            var value = $(this).val();
            if (value == "all_bill") {
                $('#def_value').html('Bill No');
                manageTable = $('#manageTable').DataTable({
                    'ajax': base_url + '/bill/fetch_bills/all',
                    'order': [],
                    destroy: true,
                    searching: false
                });
            } else if (value == "unpaid_bill") {
                $('#def_value').html('Bill No');
                manageTable = $('#manageTable').DataTable({
                    'ajax': base_url + '/bill/fetch_bills/UNPAID',
                    'order': [],
                    destroy: true,
                    searching: false
                });
            } else if (value == "paid_bill") {
                $('#def_value').html('Bill No');
                manageTable = $('#manageTable').DataTable({
                    'ajax': base_url + '/bill/fetch_bills/PAID',
                    'order': [],
                    destroy: true,
                    searching: false
                });
            } else if (value == "partial_bill") {
                // alert();
                $('#def_value').html('Bill No');
                manageTable = $('#manageTable').DataTable({
                    'ajax': base_url + '/bill/fetch_bills/PARTIAL',
                    'order': [],
                    destroy: true,
                    searching: false
                });
            }
        });

        $("#rent_type").change(function () {
            var value = $(this).val();
            if (value == "bill") {
                $('#def_value').html('Bill No');
                manageTable = $('#manageTable').DataTable({
                    'ajax': base_url + '/bill/fetch_bills/bill',
                    'order': [],
                    destroy: true,
                    searching: false
                });
            } else if (value == "rent") {
                $('#def_value').html('Bill No');
                manageTable = $('#manageTable').DataTable({
                    'ajax': base_url + '/bill/fetch_bills/rent',
                    'order': [],
                    destroy: true,
                    searching: false
                });
            } 
        });
        $('#form_modal').on('show.bs.modal', function (e) {

            $('#form_tag').val(event.target.id);

            if (event.target.id == 'btn_add') {

            } else {
                $('#bill_id').val($(e.relatedTarget).data('bill_id'));
                $('#pay_amount').val($(e.relatedTarget).data('total'));
                $('#discount').val($(e.relatedTarget).data('dis'));

                $('#account_id').val($(e.relatedTarget).data('account_id'));
                $('#bill_type').val($(e.relatedTarget).data('bill_type'));

                $('#date').val($(e.relatedTarget).data('bill_date'));
                $('#ten_id').val($(e.relatedTarget).data('ten_id'));

                $('#paid').val($(e.relatedTarget).data('total'));

                if (event.target.id == 'btn_edit') {


                }
            }
        });
        $('#cancel_modal').on('show.bs.modal', function (e) {

            $('#cancel_bill_id').val($(e.relatedTarget).data('bill_id'));
            $('#cancel_amount').val($(e.relatedTarget).data('total'));

            $('#cancel_ten_id').val($(e.relatedTarget).data('ten_id'));
            $('#trx_id').val($(e.relatedTarget).data('trx_id'));

            $('#cancel_dis').val($(e.relatedTarget).data('dis'));

        });




        $('#print_inv').on('show.bs.modal', function (e) {
            var sid = $(e.relatedTarget).data('bill_id');
            alert(sid);

            $.ajax({
                url: '<?= base_url($locale) ?>/bill/print_bill',
                type: 'POST',
                dataType: 'json',
                data: {
                    sid: sid
                },
                success: function (data) {
                    $('#print_body').html(data)
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });


            $('#bill_no').text($(e.relatedTarget).data('bill_no'));
            $('#ten_name').text($(e.relatedTarget).data('ten_name'));
            $('#bill_amount').text('$' + $(e.relatedTarget).data('total'));
            $('#bill_date').text($(e.relatedTarget).data('bill_date'));
            $('#bill_due').text($(e.relatedTarget).data('bill_due'));
            $('#acc_name').text($(e.relatedTarget).data('acc_name'));

        });



        $('#discount').on('keyup', function () {
            if ($(this).val() == '') {
                $('#pay_amount').val(parseFloat($('#paid').val()));
            }

            let discount = parseFloat($(this).val());
            discount = isNaN(discount) ? 0 : discount;

            let total = parseFloat($('#paid').val());

            let paid = total - discount;
            $('#pay_amount').val(paid);
        });

    });

    function form(data, controller_funtion, form, modal, inner) {
        event.preventDefault();

        $('.submit').prop('disabled', true);

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

                    $('.submit').prop('disabled', false);


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

                    $(modal).modal('hide');
                    $(form)[0].reset();
                    progressBar();
                } else {

                    $('.submit').prop('disabled', false);

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

    $('#advanced').click(function () {
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
</script>

<?= $this->endSection() ?>