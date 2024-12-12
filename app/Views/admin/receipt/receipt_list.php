<?= $this->extend("admin/layouts/base"); ?>
<?= $this->section('content'); ?>
<div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center  p-2">
                <h2 class="page-title">Customer Receipts</h2>
            </div>
            <div class="col-md-12 align-self-center">
                <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#form_modal"> +
                    <?= 'Add' ?>
                </button> <br>
            </div>
        </div>
    </div>
    <!-- Data Table  -->
    <div class="container-fluid">
        <div class="card col-md-12">
            <div id="outer"></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="manageTable" class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Receipt Amount</th>
                                <th>Discount</th>
                                <th>Receipt Date</th>
                                <th>Account</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- add modal -->
    <div id="form_modal" class="modal fade" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Receipt form</h4>
                    <button type="button" class="btn-close border-0 p-2" id="resetButton" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="add_form">

                        <div class="modal-body">

                            <input type="hidden" name="btn_action" id="btn_action">
                            <input type="hidden" name="tran_id" id="tran_id">
                            <input type="hidden" name="old_trx" id="old_trx">

                            <div class="row">
                                <div class="form-group col-12 text-dark">
                                    <label for="customer_id">Customer </label>
                                    <select class="form-control border-secondary select2" id="customer_id" name="customer_id" style="width:100%;">
                                        <option selected disabled>Choose Customer</option>
                                        <?php foreach ($customers as $val) : ?>
                                            <option value="<?= $val['customer_id'] ?>"><?= $val['cust_name']  ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-4 text-dark">
                                    <label for="ttlbill"> Total Bill</label>
                                    <input type="text" class="form-control" id="ttlbill" name="ttlbill" readonly>
                                    <input type="hidden" class="form-control" id="tlbill" name="tlbill">
                                </div>

                                <div class="form-group col-8 text-dark">
                                    <label for="hhh">Invoices</label>
                                    <h4 id="bills-badge">
                                        <!-- <span class="badge badge-pill badge-success" id="bills-count">0</span> -->
                                    </h4>
                                </div>


                                <div class="form-group col-6 text-dark">
                                    <label for="discount">Discount</label>
                                    <input type="number" class="form-control" id="discount" name="discount" value="0">
                                </div>

                                <div class="form-group col-6 text-dark">
                                    <label for="actual">Due Amount</label>
                                    <input type="number" class="form-control" id="actual" name="actual" readonly>
                                </div>

                                <div class="form-group col-6 text-dark">
                                    <label for="ttlpay">Total Paid</label>
                                    <input type="number" class="form-control" id="ttlpay" name="ttlpay" required>
                                </div>

                                <div class="form-group col-6 text-dark">
                                    <label for="final_bal">Balance</label>
                                    <input type="number" class="form-control" id="final_bal" name="final_bal" readonly>
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
                                    <label for="start_date">Receipt Date</label>
                                    <input type="date" class="form-control" id="receipt_date" name="receipt_date" value="<?= $curryear ?>">
                                </div>


                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-rounded btn-outline-primary submit_bt"><b><?='Submit' ?></b></button>
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
    <script>
          var base_url = "<?php echo base_url($locale); ?>";
    var lang = "<?php echo $locale; ?>";
        $(document).ready(function() {
            var manageTable;
            // ------------ Data table ------------ \\
            manageTable = $('#manageTable').DataTable({
                // columnDefs: [
                // { className: align, targets: [0, 1, 2, 3, 4,5,6,7,8] },
                // ],
                'ajax': base_url + '/receipt/fetch_receipts',
                'order': [],
                destroy: true,
                searching: false
            });
            // ------------ Form Modals ------------ \\ 
            //-- Add --\\ 
            $(document).on('submit', '#add_form', function(event) {
                form(new FormData(this), '/receipt/create_receipt', '#add_form', '#form_modal', '#inner_add');
            });

         
            // ------------ Data Passing To Modals ------------ \\
            //-- Details --\\ 

            $('#form_modal').on('show.bs.modal', function(e) {

                // alert(event.target.id)
                $('#btn_action').val(event.target.id);

                $('#btn_submit').attr('disabled', false)
                $('#bill_id').attr('readonly', false)
                $('#amount').attr('readonly', false)
                $('#account_id').attr('readonly', false)
                $('#receipt_date').attr('readonly', false)

                if (event.target.id == 'btn_add') {
                    $('#allbill').hide();
                    $('#bill_id').show();
                    $('#btn_submit').show();
                    $('#btn_submit').html('Save');

                } else if (event.target.id == 'btn_edit') {
                    $('#allbill').show();
                    $('#bill_id').hide();
                    $('#customer_id').val($(e.relatedTarget).data('customer_id'));
                    $('#tran_id').val($(e.relatedTarget).data('tran_id'));
                  
                    $('#ttlpay').val($(e.relatedTarget).data('amount'));
                    $('#final_bal').val($(e.relatedTarget).data('final_bal'));
                    // $('#account_id').val($(e.relatedTarget).data('account_id'));
                    $('#tran_date').val($(e.relatedTarget).data('tran_date'));
                    $('#old_trx').val($(e.relatedTarget).data('trx'));

                    $('#btn_submit').show();
                    $('#btn_submit').html('Save Changes');

                    $.ajax({
                    url: base_url + '/customer/get_customer_bal',
                    type: "POST",
                    data: {
                        cid: $(e.relatedTarget).data('customer_id'),
                    },
                    success: function(balance) {
                        
                        let paid = ($(e.relatedTarget).data('amount'));
                        let ttl =(parseFloat(balance) +parseFloat(paid));
                      
                        $('#ttlbill').val(ttl);
                        $('#actual').val(ttl);

                    }
                });

                 


                } 

                // $('#btn_submit').html('Save');

            });

            $('#form_modal').on('hide.bs.modal', function(e) {
                $(this).find('form').trigger('reset');
            });


            $('#customer_id').on('change', function() {

                $.ajax({
                    url: base_url + '/receipt/get_total_bills',
                    type: "POST",
                    data: {
                        customer_id: $(this).val(),
                    },
                    dataType: 'json',
                    success: function(response) {
                        // $("#bills-badge").html(response.bill);
                        $("#ttlbill").val(response.total);
                        $("#tlbill").val(response.total);
                        $("#actual").val(response.total);
                    }
                });
            });

            $('#discount').on('keyup', function() {
                if ($(this).val() == '') {
                    $('#actual').val(parseInt($('#ttlbill').val()));
                }

                $('#ttlpay').val('');
                $('#final_bal').val('');

                let discount = parseInt($(this).val());
                discount = isNaN(discount) ? 0 : discount;

                let bill = parseInt($('#ttlbill').val());

                const actual = bill - discount;
                $('#actual').val(actual);
            });

            $('#ttlpay').on('keyup', function() {

                if ($(this).val() == '') {
                    $('.badge-pill').removeClass('badge-warning');
                    $('.badge-pill').addClass('badge-light');
                    $('#final_bal').val('');
                    return;
                }

                let paid = parseFloat($(this).val())
                let dis = parseFloat($('#discount').val())

                console.log(paid)

                $('.badge-pill').each(function() {

                    // $(this).data('bal', parseFloat($(this).data('bal') - 10));

                    if (paid >= parseFloat($(this).data('bal'))) {

                        console.log($(this).data('bal'))

                        $(this).removeClass('badge-light');
                        $(this).removeClass('badge-warning');
                        $(this).addClass('badge-success');

                    } else if (paid == 0) {
                        $(this).removeClass('badge-success');
                        $(this).removeClass('badge-warning');
                        $(this).addClass('badge-light');

                    } else {
                        $(this).removeClass('badge-success');
                        $(this).removeClass('badge-light');
                        $(this).addClass('badge-warning');
                    }

                    paid -= parseFloat($(this).data('bal'));
                    paid = paid < 0 ? 0 : paid;

                });

                const total = parseFloat($(this).val());
                let actual = parseFloat($('#actual').val());

                const final_balance = actual - total;
                $('#final_bal').val(final_balance);
            });


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
                        if (response.success === true) {

                            $('.submit_bt').attr('disabled', false);
                            $('.submit_bt').html('Save');

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

                            $('.submit_bt').attr('disabled', false);
                            $('.submit_bt').html('Save');

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


        });
    </script>

<?= $this->endSection(); ?>