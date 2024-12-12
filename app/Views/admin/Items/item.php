<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>


<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title">Items</h2>
        </div>
        <div class="col-md-12 align-self-center">
            <!-- <button class="btn btn-primary " id="btn_add" data-toggle="modal" data-target="#form_modal"> +
                    <?= 'add' ?>
                </button> -->

            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#form_modal">
                +
                Add Items
            </button>

            </button> <button class="btn btn-primary " id="btn_open_balance" data-bs-toggle="modal"
                data-bs-target="#open_balance_modal">
                Opening Balance
            </button>
            <br>
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
                            <th>Item Name</th>
                            <th>
                                Avaialable Qty
                            </th>

                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Status Modal -->

<!-- add modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static'
    data-bs-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Items</h4>
                <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="add_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="inner_add"></div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>
                                    <?= 'item Name' ?>
                                </label>
                                <input type="text" class="form-control" name="item_name" id="item_name" autofocus>
                                <input type="hidden" class="form-control border-secondary" name="form_tag" id="form_tag">
                                <input type="hidden" class="form-control border-secondary" name="item_id" id="item_id">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group text-dark">
                                <label>
                                    Unit
                                </label>
                                <input type="decimal" class="form-control" name="unit" id="unit">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group text-dark">
                                <label>
                                    Cost
                                </label>
                                <input type="decimal" class="form-control"
                                    name="cost" id="cost">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- info list -->
                        <div class="col-md-12">
                            <div class="form-group text-dark">
                                <label for="type_id">Item Types</label>
                                <select class="form-control border-secondary" name="type_id" id="type_id" required>
                                    <option selected disabled value=""> Select Types </option>
                                    <?php foreach ($item_types as $val) { ?>
                                        <option value="<?= $val['type_id'] ?>">
                                            <?= $val['type_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>
                                    Stock limit
                                </label>
                                <input class="form-control" id="stocks_limit" name="stock_limit"></input>
                            </div>
                        </div> -->

                    </div>

                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary"><b> Submit </b></button>
                </div>

            </form>
        </div>

    </div>
</div><!-- /.modal-content -->
</div>
</div>


<!-- open balance modal -->
<div id="open_balance_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static'
    data-keyboard='false'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Add Balance</h4>
                <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div id="inner_open_balance"></div>
                <form id="open_balance_form">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-dark">
                                <label>Item Name</label>
                                <select class="form-control" name="item_id" id="op_item_id">
                                    <option selected disabled>Select Item</option>
                                    <?php foreach ($items as $val) { ?>
                                        <option value="<?= $val['item_id'] ?>">
                                            <?= $val['item_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>Open Qty</label>
                                <input type="decimal" class="form-control" placeholder="" name="op_qty" id="op_qty">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>Open Cost</label>
                                <input type="decimal" class="form-control" placeholder="" name="op_cost" id="op_cost">
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-rounded btn-outline-primary submit_bt"><b> Save changes</b></button>
            </div>

            </form>
        </div>
    </div>
</div>

<!-- Details Modal  -->
<!-- Status Modal -->
<div id="status_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static'
    data-keyboard='false'>
    <div class="modal-dialog modal-dialog-centered">
        <form id="status_form" enctype="multipart/form-data">
            <div class="modal-content" id="change_state">

            </div>
        </form>
    </div>
</div>


</div>

</div>

<script>
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";
    var lang = "<?php echo $locale; ?>";

    $(document).ready(function() {

        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/items/fetch_items',
            'order': [],
            destroy: true,
            searching: false

        });
    });

    // ------------ Form Modals ------------ \\ 
    //-- Add --\\ 
    $(document).on('submit', '#add_form', function(event) {
        form(new FormData(this), '/items/item_form', '#add_form', '#form_modal', '#inner_add');
        // $('#btn_main').html('');
    });


    $(document).on('submit', '#open_balance_form', function(event) {
        form(new FormData(this), '/items/open_balance_form', '#open_balance_form', '#open_balance_modal', '#inner_open_balance');
    });


    //-- Status --\\ 
    $(document).on('submit', '#status_form', function(event) {
        form(new FormData(this), '/items/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    // ------------ Data Passing To Modals ------------ \\
    //-- Details --\\ 

    $('#form_modal').on('show.bs.modal', function(e) {
        // console.log(event.target.id) 
        $('#form_tag').val(event.target.id);

        if (event.target.id == 'btn_add') {

        } else {

            $('#item_id').val($(e.relatedTarget).data('item_id'));
            $('#item_name').val($(e.relatedTarget).data('item_name'));
            $('#type_id').val($(e.relatedTarget).data('type_id'));
            $('#cost').val($(e.relatedTarget).data('cost'));
            $('#unit').val($(e.relatedTarget).data('unit'));
            if (event.target.id == 'btn_edit') {

            } else if (event.target.id == 'btn_det') {


            }
        }
    });

    $('#form_modal').on('hide.bs.modal', function(e) {
        $(this).find('form').trigger('reset');
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
            url: base_url + '/items/change_status',
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
                manageTable.ajax.reload(null, false);
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




    // Product Image
    function pro_img() {
        document.querySelector('#p_img').click();
    }
    // Product Image
    function pro_img_dis(e) {
        if (e.files) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#p_img_dis').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }


    function triggerClick() {
        document.querySelector('#p_img').click();
    }
    var q = 1;
    $("#add_purchases").click(function() {
        //alert($("#type_id").val())

        if ($("#product_name").val() == '') {
            alert('Please enter product')
            return false;
        }
        if ($("#price").val() == '') {
            alert('Please enter price')
            return false;
        }

        if ($("#main_cat").val() == null || $("#sub_cat_add").val() == null) {
            alert('Please select category or sub-category')
            return false;
        }

        if ($("#bar_code").val() == '') {
            alert('Please enter barcode')
            return false;
        }
        if ($("#stock_limit").val() == '') {
            alert('Please enter stock limit')
            return false;
        }





        $(".add_purchases tbody").append(
            '<tr class="fadetext ">' +

            '<td class="mx-3"> <div class="form-check mr-sm-2"><input class="form-check-input" id="ch_tr' + q + '" type="checkbox" >' +
            '<label class="form-check-label" for="ch_tr' + q + '"></label></div>' +
            '<td>' + $("#product_name").val() + '<input type="hidden" class="form-control" name="product_name[]" value="' + $("#product_name").val() + '"></td>' +
            '<td>' + $("#price").val() + '<input type="hidden" class="form-control" name="price[]" value="' + $("#price").val() + '"></td>' +
            '<td>' + $("#main_cat option:selected").text() + '<input type="hidden" class="form-control" name="main_cat[]" value="' + $("#main_cat").val() + '"></td>' +
            '<td>' + $("#sub_cat_add option:selected").text() + '<input type="hidden" class="form-control" name="sub_cat[]" value="' + $("#sub_cat_add").val() + '"></td>' +
            '<td>' + $("#bar_code").val() + '<input type="hidden" class="form-control" name="barcode[]" value="' + $("#bar_code").val() + '"></td>' +
            '<td>' + $("#stock_limit").val() + '<input type="hidden" class="form-control" name="stokc_limits[]" value="' + $("#stock_limit").val() + '"></td>' +
            //   '<td>' + $("#open_qty").val() + '<input type="hidden" class="form-control" name="open_qty[]" value="' + $("#open_qty").val() + '"></td>' +
            //  '<td>' + $("#open_cost").val() + '<input type="hidden" class="form-control" name="open_cost[]" value="' + $("#open_cost").val() + '"></td>' +
            // '<td>' + $("#remarks").val() + '<input type="hidden" class="form-control" name="remarks[]" value="' + $("#remarks").val() + '"></td>' +
            '<td> <button type="button" class="remover btn btn-outline-danger btn-block" id="tr' + q + '"><i class="fas fa-trash-alt mx-1"></i></button></td>' +
            '</tr>'
        );
        q++;
        $("#product_name").val('');
        $("#price").val('');
        $("#main_cat").val('');
        $("#sub_cat_add").val('');
        $("#bar_code").val('');
        $("#open_qty").val('');
        $("#remarks").val('');
        $("#open_cost").val('');

    });

    $(document).on('click', '.remover', function(event) {

        if ($('#ch_' + event.target.id).is(":checked")) {
            $('#' + event.target.id).parents("tr").remove();
        } else {
            alert(event.target.id + 'check the row first');
        }
        console.log($('#' + event.target.id).parents("tr"));
    });
</script>






<?= $this->endSection('content'); ?>