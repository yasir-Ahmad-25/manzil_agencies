<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title">Item Types</h2>
        </div>
        <div class="col-md-12 align-self-center">
            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#form_modal"> + Add </button> <br>
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
                            <th>Type name</th>
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
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Item Type Form</h4>
                <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="inner_add"></div>
                <form id="add_form" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group text-dark">
                                <label><?= 'Type' ?></label>
                                <input type="text" class="form-control" name="type_name" id="type_name" required>
                                <input type="hidden" class="form-control" name="form_tag" id="form_tag">
                                <input type="hidden" class="form-control" name="type_id" id="type_id">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-outline-primary"><b>Submit</b></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
<script type="text/javascript">
    var base_url = "<?php echo base_url($locale); ?>";
    var manageTable;
    var lang = "<?php echo $locale; ?>";

    $(document).ready(function() {

        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/items/fetch_types',
            'order': [],
            destroy: true,
            searching: false

        });
    });

    //-- Add --\\ 
    $(document).on('submit', '#add_form', function(event) {
        form(new FormData(this), '/items/item_type_form', '#add_form', '#form_modal', '#inner_add');
    });

    //-- Details --\\ 
    $('#form_modal').on('show.bs.modal', function(e) {
        $('#form_tag').val(event.target.id);
        if (event.target.id == 'btn_add') {

        } else {
            $('#type_id').val($(e.relatedTarget).data('type_id'));
            $('#type_name').val($(e.relatedTarget).data('type_name'));
            if (event.target.id == 'btn_edit') {

            } else if (event.target.id == 'btn_det') {

                $('#btn_submit').attr('disabled', true)

            }
        }
    });

    $('#form_modal').on('hide.bs.modal', function(e) {
        $(this).find('form').trigger('reset');
    });

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
</script>


<?= $this->endSection('content'); ?>