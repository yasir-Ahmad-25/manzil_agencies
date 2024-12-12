<?= $this->extend("admin/layouts/base"); ?>
<?= $this->section('content'); ?>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"> Sales List</h2>
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
                            <th>Sales Order</th>
                            <th>Total Sales</th>
                            <th>Sales Date</th>
                            <th>Staff</th>
                            <th>Details</th>
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

<!-- Details modal -->
<div id="sales_return_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Sales Returns</h4>
                <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div id="inner_add"></div>
                <form id="add_form" enctype="multipart/form-data">

                    <div class="row">


                        <!-- <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>Quantity returned</label>
                                <input type="number" class="form-control" placeholder="" name="qty_return" id="qty_return">
                            </div>
                        </div> -->

                        <div id="sales_returned_view"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-primary" id="submit_bt"> </i><b><?= 'Submit' ?></b></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Details modal -->
    <div id="details_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Sales Details</h4>
                    <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="col-md-12 pb-3">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 text-center">
                                <img src="<?= base_url() ?>public/assets/images/core/logo-icon.png" alt="Logo" width="120">
                                <h3>Sales Details</h3>
                            </div>
                            <div class="col-md-4"></div>

                        </div>
                    </div>

                    <div id="details_view"></div>


                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn-close border-0 p-2 btn-rounded btn-primary" data-dismiss="modal" aria-label="Close">Close</button>
                </div> -->
                </form>
            </div>
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
            'ajax': base_url + '/pos/fetch_sales',
            'order': [],
            destroy: true,
            searching: false
        });

    });


    //-- Edit --\\ 
    $('#edit_modal').on('show.bs.modal', function(e) {
        // console.log(event.target.id) 
        $('#form_tag_edit').val(event.target.id);
        $('#order_pur_qty_edit,#unit_edit').attr('readonly', false)
        $('#order_pur_remark_edit').attr('readonly', false)
        $('#supplier_id_edit,#store_id_edit,#order_pur_order_no_edit,#product_id_edit,#product_type_id_edit,#product_cat_id_edit').attr('disabled', false)
        $('#btn_submit').attr('disabled', false)
        if (event.target.id == 'btn_add') {
            get_orderno('order_no'); // Calling Function of Order number id 
        } else {
            $('#order_purchase_id_edit').val($(e.relatedTarget).data('order_purchase_id'));
            $('#order_pur_remark').val($(e.relatedTarget).data('order_pur_remark'));
            $('#order_pur_order_no').val($(e.relatedTarget).data('order_pur_order_no'));
            $('#unit_edit').val($(e.relatedTarget).data('order_pur_unit'));
            $('#order_pur_qty').val($(e.relatedTarget).data('order_pur_qty'));
            $('#product_id_edit').val($(e.relatedTarget).data('product_id'));
            $('#product_cat_id_edit').val($(e.relatedTarget).data('product_cat_id'));
            $('#product_type_id_edit').val($(e.relatedTarget).data('product_type_id'));
            $('#supplier_id_edit').val($(e.relatedTarget).data('supplier_id'));
            $('#store_id_edit').val($(e.relatedTarget).data('store_id'));

        }
    });

    $('#details_modal').on('show.bs.modal', function(e) {

        let sales_id = $(e.relatedTarget).data('sales_id')

        $.ajax({
            url: base_url + '/items/get_item_details',
            type: "POST",
            data: {
                sales_id: sales_id,

            },
            success: function(response) {
                $("#details_view").html(response);
            }
        });

    });

    $('#sales_return_modal').on('show.bs.modal', function(e) {

        let sales_id = $(e.relatedTarget).data('sales_id');

        $.ajax({
            url: base_url + '/items/get_item_details_for_returns',
            type: "POST",
            data: {
                sales_id: sales_id,

            },
            success: function(response) {
                $("#sales_returned_view").html(response);
            }
        });
        
        $('#qty_returned').val($(e.relatedTarget).data('sales_id'));

       
    });


    $(document).on('submit', '#add_form', function(event) {
        form(new FormData(this), 'medicine/purchase_form', '#add_form', '#purchase_modal', '#inner_add');
        // $('#btn_main').html('');
    });
    //-- Status --\\ 
    $(document).on('submit', '#status_form', function(event) {
        form(new FormData(this), 'admin/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#purchase_modal').on('show.bs.modal', function(e) {
        //   alert(event.target.id)
        // $("#order_purchase_id_con").val((e.relatedTarget).data('rec_id'))
        $('#purchase_id_pur').val($(e.relatedTarget).data('purchase_id'));
        $('#purchase_no_pur').val($(e.relatedTarget).data('purchase_no'));

        //  alert($(e.relatedTarget).data('order_no')) 
        $('#form_tag').val('btn_det');
        $('#supplier_id_pur').attr('disabled', false)

        $('#btn_submit').attr('disabled', false)
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
            url: base_url + 'home/change_status',
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

        $('.submit').prop('disabled', true);
        $('.submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

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

                    $(".add_purchases tbody td").html('')

                    $('.submit').prop('disabled', false);
                    $('.submit').html('<b>Save</b>');
                } else {
                    $('.submit').prop('disabled', false);
                    $('.submit').html('<b>Save</b>');

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
    let whole_ttl = 0;

    $("#add_purchases").click(function() {

        let total = parseFloat($("#cost_per_unit").val()) * parseFloat($("#qty").val()).toFixed(2);

        if ($('#product_id').val() == "" || $('#cost_per_unit').val() == "" || $('#expire_date').val() == "" || $('#qty').val() == "") {
            alert('Please enter all inputs');
            return
        }

        $(".add_purchases tbody tr").last().after(
            '<tr class="fadetext ">' +

            '<td class="mx-3"> <div class="form-check mr-sm-2"><input class="form-check-input" id="ch_tr' + q + '" type="checkbox" >' +
            '<label class="form-check-label" for="ch_tr' + q + '"></label></div>' +
            '<td>' + $("#product_id option:selected").text() + '<input type="hidden" class="form-control" name="_product_id[]" value="' + $("#product_id").val() + '"></td>' +
            '<td>' + $("#expire_date").val() + '<input type="hidden" class="form-control" name="_expire_date[]" value="' + $("#expire_date").val() + '"></td>' +
            // '<td>' + $("#unit").val() + '<input type="hidden" class="form-control" name="_unit[]" value="' + $("#unit").val() + '"></td>' +
            '<td>' + $("#qty").val() + '<input type="hidden" class="form-control" name="_qty[]" value="' + $("#qty").val() + '"> </td>' +
            '<td>' + $("#cost_per_unit").val() + '<input type="hidden" class="form-control" name="_cost[]" value="' + $("#cost_per_unit").val() + '"></td>' +
            '<td>' + total + '<input type="hidden" class="form-control" name="total_cost[]" value="' + total + '"></td>' +
            '<td> <button type="button" class="remover btn btn-outline-danger btn-block" id="tr' + q + '"><i class="fas fa-trash-alt mx-1"></i></button></td>' +
            '</tr>'
        );
        q++;
        whole_ttl += parseFloat($("#total_cost").val());
        $('#whole_ttl').val(whole_ttl);

        $("#product_id").val('product_id');
        // $("#supplier_id").val('supplier_id');
        $("#store_id").val('store_id');
        $("#qty").val('');
        //  $("#unit").val('');
        $("#total_cost").val('');
        $("#cost_per_unit").val('');
        $("#expire_date").val('');
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
</script>

<?= $this->endSection(); ?>