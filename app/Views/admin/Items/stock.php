<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>


<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title">Stock Out List</h2>
        </div>
        <div class="col-md-12 align-self-center">
            <!-- <button class="btn btn-primary " id="btn_add" data-toggle="modal" data-target="#form_modal"> +
                    <?= 'add' ?>
                </button> -->

            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#form_modal">
                +
                Add Stock Out
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
                                Quanitiy
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                User
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
                <h4 class="modal-title" id="myModalLabel">Stock Out Form</h4>
                <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="add_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="inner_add"></div>

                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group text-dark">
                                <label>Item Name</label>
                                <select class="form-control" name="item_id" id="item_id">
                                    <option selected disabled>Select Item</option>
                                    <?php foreach ($items as $val) { ?>
                                        <option value="<?= $val['item_id'] ?>">
                                            <?= $val['item_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                        <input type="hidden" class="form-control border-secondary" name="form_tag" id="form_tag">
                        <input type="hidden" class="form-control border-secondary" name="stock_id" id="stock_id">




                        <div class="col-md-3">
                            <div class="form-group text-dark">
                                <label>
                                    Available Qty
                                </label>
                                <input type="text" class="form-control" name="av_qty" id="av_qty" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group text-dark">
                                <label>
                                    Out Qty
                                </label>
                                <input type="number" class="form-control" name="qty" id="qty">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group text-dark">
                                <label>
                                    Date
                                </label>
                                <input type="date" class="form-control" name="date" id="date">
                            </div>
                        </div>

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


</div>

</div>

<script>
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";
    var lang = "<?php echo $locale; ?>";

    $(document).ready(function() {

        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/items/fetch_stock',
            'order': [],
            destroy: true,
            searching: false

        });
    });

    // ------------ Form Modals ------------ \\ 
    //-- Add --\\ 
    $(document).on('submit', '#add_form', function(event) {
        form(new FormData(this), '/items/item_stockout_form', '#add_form', '#form_modal', '#inner_add');
        // $('#btn_main').html('');
    });


    $('#form_modal').on('show.bs.modal', function(e) {
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

    $("#item_id").on('change', function() {

        $.ajax({
            url: base_url + '/items/get_av_qty',
            type: "POST",
            data: {
                'item_id': $(this).val()
            },
            success: function(response) {

                $('#av_qty').val(response)
                $('#qty').val('')
            }
        });
    });


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
</script>



<?= $this->endSection('content'); ?>