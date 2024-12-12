<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= 'Meals' ?></h2>
        </div>
        <div class="col-md-12 align-self-center">
            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#form_modal"> +
                <?= 'add' ?>
            </button>
            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#product_multi_modal"> +
                Add Multi Product
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
                            <th><?= 'Image' ?></th>
                            <th><?= 'Name' ?></th>
                            <th><?= 'Category' ?></th>
                            <th><?= 'Type' ?></th>
                            <th><?= 'Price' ?></th>
                            <th><?= 'Action' ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- add single modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"><?= 'Add' ?></h4>
                <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="add_form" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-2  mx-auto">
                            <div class="form-group text-center" id="img_holder">
                                <img src="<?= base_url(); ?>public/assets/images/core/ph.png" onclick="triggerClick()" id="p_img_dis" class="img img-thumbnail">
                                <input type="file" onchange="display(this)" name="p_img" id="p_img" style="display: none;"><br>
                                <small><i><?= 'image' ?></i></small>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group text-dark">
                                        <label><?= 'product name' ?></label>
                                        <input type="text" class="form-control" placeholder="<?= 'product name' ?>" name="pro_name" id="pro_name" autofocus>
                                        <input type="hidden" class="form-control border-secondary" name="form_tag" id="form_tag_single">
                                        <input type="hidden" class="form-control border-secondary" name="pro_id" id="pro_id">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group text-dark">
                                        <label><?= 'price' ?></label>
                                        <input type="decimal" class="form-control" placeholder="<?= 'Price' ?>" name="pro_price" id="pro_price">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group text-dark">
                                                <label for="product_cat_id"><?= 'Type' ?></label>
                                                <select class="form-control border-secondary" name="pro_type_id" id="pro_type_id">
                                                    <option selected disabled value=""><?= 'Select Type' ?></option>
                                                    <?php foreach ($types as $value) : ?>
                                                        <option value="<?= $value['product_type_id'] ?>"><?= $value['pro_type_name']  ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group text-dark">
                                                <label><?= 'description' ?></label>
                                                <textarea readonly class="form-control" rows="3" id="pro_des" name="pro_des" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- info list -->

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-rounded btn-outline-primary"><b><?= 'Save' ?></b></button>
            </div>

            </form>

        </div>
    </div><!-- /.modal-content -->
</div>

<!-- add multi modal  -->

<div id="product_multi_modal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Products</h4>
                <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="inner_add_m"></div>
                <form id="add_form_multi" enctype="multipart/form-data">

                    <div class="row">


                        <div class="col-md-4">
                            <div class="form-group text-dark">
                                <label>Product </label>
                                <input type="text" class="form-control" placeholder="" name="product_name" id="product_name">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group text-dark">
                                <label>Price</label>
                                <input type="number" class="form-control" placeholder="" name="price" id="price">
                                <input type="hidden" class="form-control border-secondary" name="form_tag" id="form_tag">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group text-dark">
                                <label for="type_id">Product Type</label>
                                <select class="form-control border-secondary" name="type_id" id="type_id">
                                    <option selected disabled>Select Type</option>
                                    <?php foreach ($types as $value) : ?>
                                        <option value="<?= $value['product_type_id'] ?>"><?= $value['pro_type_name']  ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-dark">
                                <label>Remarks </label>
                                <input type="text" class="form-control" placeholder="" name="remarks" id="remarks">
                            </div>
                        </div>
                    </div>


                    <br>
                    <hr><br>
                    <div class="col-md-12">
                        <table class="add_purchases table table-bordered table-hover" width="30%">
                            <thead>
                                <tr>
                                    <!-- <input type="checkbox" id="select-all" class="form-check-input"> -->
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Remarks</th>
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




                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-primary"> </i><b><?= 'submit' ?></b></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Details Modal  -->
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

</div>

<script type="text/javascript">
    var base_url = "<?php echo base_url($locale); ?>";

    $(document).ready(function() {

        var manageTable;
        var lang = "<?php echo $locale; ?>";
        align = 'dt-left';
        if (lang == 'ar') {
            align = 'dt-right';
        }

        // ------------ Data table ------------ \\
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/meals/products_list',
            'order': []
        });


        // ------------ Form Modals ------------ \\ 
        //-- Add --\\ 
        $(document).on('submit', '#add_form', function(event) {
            form(new FormData(this), '/meals/products_form', '#add_form', '#form_modal', '#inner_add');
            // $('#btn_main').html('');
        });

        $(document).on('submit', '#add_form_multi', function(event) {
            form(new FormData(this), 'products/product_form_multi', '#add_form_multi', '#product_multi_modal', '#inner_add_m');
            // $('#btn_main').html('');
        });

        //-- Status --\\ 
        $(document).on('submit', '#status_form', function(event) {
            form(new FormData(this), 'home/status_changer', '#status_form', '#status_modal', '#inner_status');
        });
        // ------------ Data Passing To Modals ------------ \\
        //-- Details --\\ 

        $('#form_modal').on('show.bs.modal', function(e) {
            // console.log(event.target.id) 
            $('#form_tag_single').val(event.target.id);

       
            if (event.target.id == 'btn_add') {
                $('#add_form')[0].reset();

            } else {

                $('#pro_id').val($(e.relatedTarget).data('product_id'));
                $('#pro_name').val($(e.relatedTarget).data('pro_name'));
                $('#pro_type_id').val($(e.relatedTarget).data('product_type_id'));
                $('#pro_price').val($(e.relatedTarget).data('pro_price'));
                $('#bar_code_no').val($(e.relatedTarget).data('bar_code_no'));
                $('#p_img').val($(e.relatedTarget).data('p_img'));
                $('#pro_des').val($(e.relatedTarget).data('pro_des'));
                if (event.target.id == 'btn_edit') {

                    $('#img_holder').html('<img src="<?= base_url(); ?>public/assets/images/core/ph.png" onclick="triggerClick()" id="pdis" class="img img-thumbnail"><input type="file" onchange="display(this)" name="p_img" id="p_img" style="display: none;"><br><input type="hidden" class="form-control border-secondary" name="old_img" id="old_img"><small><i>User Image</i></small>');
                    $('#pdis').attr('src', $(e.relatedTarget).data('meal_img'));
                    $('#old_img').val($(e.relatedTarget).data('old_img'));

                } else if (event.target.id == 'btn_det') {

                    $('#pro_price,#bar_code_no,#pro_des,#pro_name').attr('readonly', true)
                    $('#product_type_id').attr('disabled', true)
                    $('#product_cat_id').attr('disabled', true)
                    $('#brand_id').attr('disabled', true)
                    $('#p_img').attr('disabled', true)
                    $('#btn_submit').attr('disabled', true)

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

        function form(data, controller_funtion, form, modal, inner) {
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



    // Product Image
    function pro_img() {
        document.querySelector('#p_img').click();
    }
    // Product Image
    function display(e) {
        if (e.files) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#pdis').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }


    function triggerClick() {
        document.querySelector('#p_img').click();
    }


    var q = 1;
    $("#add_purchases").click(function() {

        $(".add_purchases tbody tr").last().after(
            '<tr class="fadetext ">' +

            '<td class="mx-3"> <div class="form-check mr-sm-2"><input class="form-check-input" id="ch_tr' + q + '" type="checkbox" >' +
            '<label class="form-check-label" for="ch_tr' + q + '"></label></div>' +
            '<td>' + $("#product_name").val() + '<input type="hidden" class="form-control" name="product_name[]" value="' + $("#product_name").val() + '"></td>' +
            '<td>' + $("#price").val() + '<input type="hidden" class="form-control" name="price[]" value="' + $("#price").val() + '"></td>' +
            '<td>' + $("#type_id option:selected").text() + '<input type="hidden" class="form-control" name="type_id[]" value="' + $("#type_id").val() + '"></td>' +
            '<td>' + $("#remarks").val() + '<input type="hidden" class="form-control" name="remarks[]" value="' + $("#remarks").val() + '"></td>' +
            '<td> <button type="button" class="remover btn btn-outline-danger btn-block" id="tr' + q + '"><i class="fas fa-trash-alt mx-1"></i></button></td>' +
            '</tr>'
        );
        q++;
        $("#product_name").val('');
        $("#price").val('');
        $("#type_id").val('type_id');
        $("#remarks").val('');
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



<!-- -Depend -->

<?= $this->endSection('content'); ?>