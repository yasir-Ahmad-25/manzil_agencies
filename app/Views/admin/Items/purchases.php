<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title">Purchase orders</h2>
        </div>
        <div class="col-md-12 align-self-center">
            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#purchase_modal">
                New Purchase / Stock in
            </button> <br>
        </div>
    </div>
</div>


<!-- Data Table   -->
<div class="container-fluid">
    <div class="card col-md-12">
        <div id="outer"></div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Supplier</th>
                            <th>Total Cost</th>
                            <th>Purchased Date</th>
                            <th>Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- add modal -->

<div id="purchase_modal" class="modal fade" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false' style="overflow:hidden;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"><?= 'Purchase Form' ?></h4>
                <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="add_form" enctype="multipart/form-data">
                    <div class="row">


                        <input type="hidden" name="form_tag" id="form_tag">
                        <input type="hidden" name="purchase_id" id="purchase_id">
                        <input type="hidden" name="ttl_cost" id="ttl_cost">

                        <input type="hidden" name="old_trx_id" id="old_trx_id">
                        <input type="hidden" name="old_amount" id="old_amount">
                        <input type="hidden" name="old_suppid" id="old_suppid">

                        <div class="col-md-3">
                            <div class="form-group text-dark">
                                <label>Supplier</label>
                                <select class="form-control" name="supplier_id" id="supplier_id" required>
                                    <option selected disabled value=""><?= 'Select supplier' ?></option>
                                    <?php foreach ($suppliers as $value) : ?>
                                        <option value="<?= $value['sup_id'] ?>"><?= $value['sup_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label><?= 'Item Name' ?></label>
                                <select class="form-control" name="product_id" id="product_id">
                                    <option selected disabled value=""><?= 'Select Item' ?></option>
                                    <?php foreach ($items as $value) : ?>
                                        <option value="<?= $value['item_id'] ?>"><?= $value['item_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group text-dark">
                                <label><?= 'Quantity' ?></label>
                                <input type="decimal" class="form-control" name="qty" id="qty">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group text-dark">
                                <label>Cost/Unit($)</label>
                                <input type="decimal" class="form-control" name="cost_per_unit" id="cost_per_unit">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>Total Cost($)</label>
                                <input type="decimal" class="form-control" name="total_cost" id="total_cost">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group text-dark">
                                <label>Invoice No</label>
                                <input type="text" class="form-control" name="invoice_no" id="invoice_no">
                            </div>
                        </div>


                        <br>
                        <hr><br>

                        <div class="col-md-12">
                            <table class="add_purchases table table-bordered table-hover" width="30%">
                                <thead>
                                    <tr>
                                        <input type="checkbox" id="select-all" class="form-check-input">
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Cost/unit</th>
                                        <th>Total</th>
                                        <th>
                                            <button type="button" class="btn btn-primary btn-block  btn-sm" id="add_purchases">
                                                Add
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-primary" id="submit_bt"> </i><b><?= 'Submit' ?></b></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    var base_url = "<?php echo base_url($locale); ?>";
    var lang = "<?php echo $locale; ?>";

    $(document).ready(function() {
        var product_cost;
        var manageTable;

        manageTable = $('#manageTable').DataTable({
            // columnDefs: [
            // { className: align, targets: [0, 1, 2, 3, 4,5,6,7,8] },
            // ],
            'ajax': base_url + '/purchases/fetch_purchases',
            'order': [],
            destroy: true,
            searching: false
        });



        $('#cost_per_unit').change(function() {
            var calc = parseFloat($(this).val()) + parseFloat(product_cost)
            var average_cost = calc / 2
            $('#newcost').val(average_cost)
        });

        $(document).on('submit', '#add_form', function(event) {
            form(new FormData(this), '/purchases/purchase_form', '#add_form', '#purchase_modal', '#inner_add');
        });


        $('#purchase_modal').on('show.bs.modal', function(e) {

            $('#purchase_id').val($(e.relatedTarget).data('supplier_id'));
            $('#supplier_id').val($(e.relatedTarget).data('supplier_id'));

            $('#old_trx_id').val($(e.relatedTarget).data('trx_id'));
            $('#old_amount').val($(e.relatedTarget).data('total_cost'));
            $('#old_suppid').val($(e.relatedTarget).data('supplier_id'));

            $('#invoice_no').val($(e.relatedTarget).data('invoice_no'));

            $('#form_tag').val(event.target.id);

            if (event.target.id == 'btn_edit') {

                $.ajax({
                    url: base_url + '/purchases/get_purchase_details',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        purchase_id: $(e.relatedTarget).data('purchase_id'),
                    },

                    success: function(response) {

                        let q = 1;

                        $.each(response, function(key, val) {

                            let total = val['qty'] * val['cost'];
                            $(".add_purchases tbody tr").last().after(
                                '<tr class="fadetext ">' +

                                '<td class="mx-3"> <div class="form-check mr-sm-2"><input class="form-check-input" id="ch_tr' + q + '" type="checkbox" >' +
                                '<label class="form-check-label" for="ch_tr' + q + '"></label></div>' +
                                '<td>' + val['item_name'] + '<input type="hidden" class="form-control" name="_product_id[]" value="' + val['item_name'] + '"></td>' +
                                '<td>' + val['qty'] + '<input type="hidden" class="form-control" name="_qty[]" value="' + val['qty'] + '"> </td>' +
                                '<td>' + val['cost'] + '<input type="hidden" class="form-control" name="_cost[]" value="' + val['cost'] + '"></td>' +
                                '<td>' + total + '<input type="hidden" class="form-control" name="total_cost[]" value="' + total + '"></td>' +
                                '<td> <button type="button" class="remover btn btn-outline-danger btn-block" id="tr' + q + '"><i class="fas fa-trash-alt mx-1"></i></button></td>' +
                                '</tr>'
                            );

                            q++;

                        });
                    }
                });
            }

            $('#btn_submit').attr('disabled', false)
        });

        $('#purchase_modal').on('hide.bs.modal', function(e) {
            $(this).find('form').trigger('reset');

            $(".add_purchases > tbody").empty();
        });


        function get_orderno(tp) {
            // alert('')
            $.ajax({
                url: base_url + 'inventory/get_order_no/' + tp,
                type: "POST",

                success: function(response) {
                    $("#order_no1").val(response);
                }
            });
        }

        function form(data, controller_funtion, form, modal, inner) {
            event.preventDefault();

            $('#submit_bt').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Submiting...');
            $('#submit_bt').attr('disabled', true);

            $.ajax({
                url: base_url + controller_funtion,
                method: 'POST',
                data: data,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success === true) {

                        $('#submit_bt').attr('disabled', false);
                        $('#submit_bt').html('Submit');

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

                        $(".add_purchases > tbody").empty();

                    } else {

                        $('#submit_bt').attr('disabled', false);
                        $('#submit_bt').html('Submit');

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
        var q = 1;
        ttl_cost = 0;
        $("#add_purchases").click(function() {

            if ($("#product_id").val() == '' || $('#qty').val() == '') {

                alert('Please fill all fields');
                return;
            }

            let total = parseFloat($("#cost_per_unit").val()) * parseFloat($("#qty").val()).toFixed(2);

            ttl_cost += total;


            $(".add_purchases tbody tr").last().after(
                '<tr class="fadetext ">' +

                '<td class="mx-3"> <div class="form-check mr-sm-2"><input class="form-check-input" id="ch_tr' + q + '" type="checkbox" >' +
                '<label class="form-check-label" for="ch_tr' + q + '"></label></div>' +
                '<td>' + $("#product_id option:selected").text() + '<input type="hidden" class="form-control" name="_product_id[]" value="' + $("#product_id").val() + '"></td>' +
                '<td>' + $("#qty").val() + '<input type="hidden" class="form-control" name="_qty[]" value="' + $("#qty").val() + '"> </td>' +
                '<td>' + $("#cost_per_unit").val() + '<input type="hidden" class="form-control" name="_cost[]" value="' + $("#cost_per_unit").val() + '"></td>' +
                '<td>' + total + '<input type="hidden" class="form-control" name="total_cost[]" value="' + total + '"></td>' +
                '<td> <button type="button" class="remover btn btn-outline-danger btn-block" id="tr' + q + '"><i class="fas fa-trash-alt mx-1"></i></button></td>' +
                '</tr>'
            );
            q++;
            $("#product_id").val('product_id');
            $("#store_id").val('store_id');
            $("#qty").val('');
            $("#total_cost").val('');
            $("#cost_per_unit").val('');


            $("#ttl_cost").val(ttl_cost);
        });
        $(document).on('click', '.remover', function(event) {
            // alert(event.target.id);
            // $('#'+event.target.id ).remove();
            if ($('#ch_' + event.target.id).is(":checked")) {
                $('#' + event.target.id).parents("tr").remove();
            } else {
                alert(event.target.id + 'check the row first');
            }
            console.log($('#' + event.target.id).parents("tr"));
        });



        $('#cost_per_unit').on('keyup', function() {

            let cost_per_unit = $(this).val();
            let qty = $('#qty').val();
            let total_cost = cost_per_unit * qty;
            $('#total_cost').val(total_cost);
        });


    });
</script>


<?= $this->endSection('content'); ?>