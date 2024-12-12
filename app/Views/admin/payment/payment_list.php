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
                            <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-md-12" style="text-align: end">
                <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#payment_modal"><?= 'Add Payment' ?></button>
            </div>
        </div>
    </div> </br>
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

                        <br />
                        <div id="messages"></div>

                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <!--<th>#</th>-->
                                    <th>Supplier Name</th>
                                    <th>Paid Amount</th>
                                    <!-- <th>Invoice #</th> -->
                                    <th>Payment Account</th>
                                    <th>Payment Date</th>
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
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    <!-- add modal content -->
    <!-- add modal -->
    <div id="payment_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Supplier Payment</h4>
                    <button type="button" class="btn-close border-0 p-2" id="resetButton" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="data_form">

                        <div class="modal-body">

                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="pay_id" id="pay_id">

                            <div class="row">
                                <div class="form-group col-12 text-dark">
                                    <label for="sup_id">Supplier Name </label>
                                    <select class="form-control border-secondary " id="sup_id" name="sup_id">
                                        <option selected disabled>Choose Supplier</option>
                                        <?php foreach ($suppliers as $val) : ?>
                                            <option value="<?= $val['sup_id'] ?>"><?= $val['sup_name']  ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>

                            <div class="row">
                                <!-- <div class="form-group col-6 text-dark">
                                    <label for="inv_id">Invoices</label>
                                    <select class="form-control border-secondary " id="inv_id" name="inv_id">
                                    
                                    </select>
                                </div> -->


                                <div class="form-group col-4 text-dark">
                                    <label for="total">Total Amount</label>
                                    <input type="text" class="form-control" id="total" name="total" readonly>
                                </div>

                                <div class="form-group col-8 text-dark">
                                    <label for="hhh">Invoices</label>
                                    <h4 id="bills-badge">
                                    </h4>
                                </div>

                                <div class="form-group col-6 text-dark">
                                    <label for="pay_amount">Amount Paid</label>
                                    <input type="text" class="form-control" id="pay_amount" name="pay_amount">
                                </div>

                                <div class="form-group col-6 text-dark">
                                    <label for="bal">Balance</label>
                                    <input type="number" class="form-control" id="bal" name="bal" value="0">
                                </div>


                                <div class="form-group col-6 text-dark">
                                    <label for="account_id">Payment Account</label>
                                    <select class="form-control border-secondary " id="account_id" name="account_id">
                                        <option selected disabled>Choose Account</option>
                                        <?php foreach ($accounts as $val) : ?>
                                            <option value="<?= $val['account_id'] ?>"><?= $val['acc_name']  ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <?php $curryear = date('Y-m-d'); ?>

                                <div class="form-group col-6 text-dark">
                                    <label for="pay_date">Payment Date</label>
                                    <input type="date" class="form-control" id="pay_date" name="pay_date" value="<?= $curryear ?>">
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
    </div><!-- /.modal -->

    <div id="delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Payment</h4>
                    <button type="button" class="btn-close border-0 p-2" id="resetButton" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="inner_add_d"></div>
                    <form id="delete_form">

                        <div class="modal-body">

                            <input type="hidden" name="_pay_id" id="_pay_id">
                            <input type="hidden" name="_trx_id" id="_trx_id">
                            <input type="hidden" name="_amount" id="_amount">
                            <input type="hidden" name="_sup_id" id="_sup_id">

                            <h4> Are you sure to delete this payment?</h4>


                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="" class="btn btn-rounded btn-outline-danger"><b><?= 'Delete' ?></b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




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
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/payment/fetch_payments',
            'order': []
        });

        $('#resetButton').click(function() {
            $('#data_form')[0].reset();
            manageTable.ajax.reload(null, false);
        });

        // $('#inv_id').on('change', function() {
        //     $.ajax({
        //         url: base_url + 'payment/get_total_invoice',
        //         type: "POST",
        //         data: {
        //             inv_id: $(this).val(),
        //         },
        //         success: function(response) {
        //             $("#total").val(response);
        //         }
        //     });
        // });

        $('#sup_id').on('change', function() {

            $.ajax({
                url: base_url + '/invoice/get_outstanding_invoices',
                type: "POST",
                data: {
                    sup_id: $(this).val(),
                },
                dataType: "json",
                success: function(response) {
                    //$("#inv_id").html(response);
                    $("#bills-badge").html(response.bill);
                    $("#total").val(response.total);

                }
            });
        });

        // $('#rdiscount').on('keyup', function() {
        //     if ($(this).val() == '') {
        //         $('#rdue').val(parseInt($('#rbill').val()));

        //     }
        //     $('#rpay').val('');
        //     $('#rbal').val('');
        //     const discount = parseInt($(this).val());
        //     const bill = parseInt($('#rbill').val());
        //     if (discount >= bill) {
        //         alert('Discount is Greater than Total Amount');
        //         $(this).val('');
        //         $('#rdiscount').val('');
        //         $('#rdue').val('');
        //         return;
        //     }

        //     const actual = bill - discount;
        //     $('#rdue').val(actual);
        // });

        $('#pay_amount').on('keyup', function() {

            const total = parseInt($(this).val());
            let actual = parseInt($('#total').val());

            const final_balance = actual - total;
            $('#bal').val(final_balance);
        });

        $('#payment_modal').on('show.bs.modal', function(e) {

            $('#btn_submit').prop('disabled', false);

            // alert(event.target.id)
            $('#btn_action').val(event.target.id);

            // $('#btn_submit').attr('disabled', false)
            // $('#bill_id').attr('readonly', false)
            // $('#amount').attr('readonly', false)
            // $('#account_id').attr('readonly', false)
            // $('#receipt_date').attr('readonly', false)

            if (event.target.id == 'btn_add') {
                // $('#allbill').hide();
                // $('#bill_id').show();
                // $('#btn_submit').show();
                // $('#btn_submit').html('Save');

            } else if (event.target.id == 'btn_edit') {
                $('#allbill').show();
                $('#bill_id').hide();
                $('#allbill').val($(e.relatedTarget).data('bill_id'));
                $('#rbill').val($(e.relatedTarget).data('ttlbill'));
                $('#rdiscount').val($(e.relatedTarget).data('discount'));
                $('#rdue').val($(e.relatedTarget).data('actual'));
                $('#rpay').val($(e.relatedTarget).data('ttlpay'));
                $('#rbal').val($(e.relatedTarget).data('final_bal'));
                $('#account_id').val($(e.relatedTarget).data('account_id'));
                $('#receipt_date').val($(e.relatedTarget).data('receipt_date'));

                $('#btn_submit').show();
                $('#btn_submit').html('Save Changes');


            } else if (event.target.id == 'btn_view') {

                $('#allbill').show();
                $('#bill_id').hide();
                $('#allbill').val($(e.relatedTarget).data('bill_id'));
                $('#rbill').val($(e.relatedTarget).data('ttlbill'));
                $('#rdiscount').val($(e.relatedTarget).data('discount'));
                $('#rdue').val($(e.relatedTarget).data('actual'));
                $('#rpay').val($(e.relatedTarget).data('ttlpay'));
                $('#rbal').val($(e.relatedTarget).data('final_bal'));
                $('#account_id').val($(e.relatedTarget).data('account_id'));
                $('#receipt_date').val($(e.relatedTarget).data('receipt_date'));
                $('#btn_submit').hide();

                $('#allbill').attr('readonly', true)
                $('#rbill').attr('readonly', true)
                $('#rdiscount').attr('readonly', true)
                $('#rdue').attr('readonly', true)
                $('#rpay').attr('readonly', true)
                $('#rbal').attr('readonly', true)
                $('#account_id').attr('readonly', true)
                $('#receipt_date').attr('readonly', true)

            }

        });
        $('#delete_modal').on('show.bs.modal', function(e) {

            $('#_pay_id').val($(e.relatedTarget).data('pay_id'));
            $('#_trx_id').val($(e.relatedTarget).data('trx_id'));
            $('#_sup_id').val($(e.relatedTarget).data('sup_id'));
            $('#_amount').val($(e.relatedTarget).data('amount'));

        });



        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/payment/create_payment', '#data_form', '#payment_modal', '#inner_add');
        });
        $(document).on('submit', '#delete_form', function(event) {
            form(new FormData(this), '/payment/delete_payment', '#delete_form', '#delete_modal', '#inner_add_d');
        });

    });

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


    $(document).on('submit', '#status_form', function(event) {
        form(new FormData(this), 'sites/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function(e) {
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

        $('#btn_submit').prop('disabled', true);

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

                    $(modal).modal('hide');
                    $(form)[0].reset();
                    progressBar();
                } else {

                    $('#btn_submit').prop('disabled', false);

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