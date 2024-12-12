<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center  p-2">
                <h2 class="page-title"><?= 'Category' ?></h2>
            </div>
            <div class="col-md-12 align-self-center">
                <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#form_modal"> +
                    <?= 'add' ?>
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
                                <th><?= 'Category' ?></th>
                                <th><?= 'Action' ?></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- add modal -->
    <div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= 'Category' ?></h4>
                    <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="add_form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-dark">
                                    <label><?= 'Category' ?></label>
                                    <input type="text" class="form-control " placeholder="<?= 'category' ?>" name="pro_cat_name" id="pro_cat_name">
                                    <input type="hidden" class="form-control border-secondary" name="form_tag" id="form_tag">
                                    <input type="hidden" class="form-control border-secondary" name="form_id" id="form_id">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?= 'Description' ?></label>
                                    <textarea class="form-control border-secondary" rows="3" name="pro_cat_des" id="pro_cat_des" placeholder="<?= 'description' ?>"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-rounded btn-outline-primary"><b><?= 'save' ?></b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <!-- Status Modal -->
    <div id="status_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog modal-dialog-centered">
            <form id="status_form" enctype="multipart/form-data">
                <div class="modal-content" id="change_state">

                </div>
            </form>
        </div>
    </div>
    <script>
        var base_url = "<?php echo base_url($locale); ?>";

        $(document).ready(function() {

            var manageTable;

            var lang = "<?php echo $locale; ?>";
            align = 'dt-left';
            if (lang == 'ar') {
                align = 'dt-right';
            }
            var manageTable;
            
            // ------------ Data table ------------ \\
            manageTable = $('#manageTable').DataTable({
                'ajax': base_url + '/meals/fetch_category',
                'order': []
            });
            // ------------ Form Modals ------------ \\ 
            //-- Add --\\ 
            $(document).on('submit', '#add_form', function(event) {
                form(new FormData(this), '/meals/product_cat', '#add_form', '#form_modal', '#inner_add');
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
                $('#form_tag').val(event.target.id);
                $('#pro_cat_name,#pro_cat_des').attr('readonly', false)
                $('#btn_submit').attr('disabled', false)
                if (event.target.id == 'btn_add') {

                    $('#add_form')[0].reset();

                } else {
                    $('#form_id').val($(e.relatedTarget).data('form_id'));
                    $('#pro_cat_name').val($(e.relatedTarget).data('pro_cat_name'));
                    $('#pro_cat_des').val($(e.relatedTarget).data('pro_cat_des'));
                    if (event.target.id == 'btn_edit') {


                    } else if (event.target.id == 'btn_det') {
                        $('#pro_cat_name,#pro_cat_des').attr('readonly', true)
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
    </script>


    <?= $this->endSection('content'); ?>