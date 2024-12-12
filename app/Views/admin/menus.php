<?= $this->extend("admin/layouts/base");?>

<?= $this->section('content');?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center  p-2">
                <h2 class="page-title"><?= lang('Site.menus.title') ?></h2>
            </div>
            <!-- <div class="col-md-12 align-self-center"> -->
            <div class="col-md-7" style="text-align: end">
                <button class="btn btn-primary " id="addrole" data-bs-toggle="modal" data-bs-target="#add_modal"> +
                    <?= lang('Site.button.add') ?></button> <br>
            </div>
        </div>
    </div>
    <!-- Data Table  -->
    <div class="container-fluid">
        <div class="card col-md-12">
            <div id="outer"></div>
            <div id="msg" class="alert alert-success alert-dismissible" role="alert" style="display:none;">
                <!-- <span class="text-danger text-strong" id="msg"></span>  -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="manageTable" class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?= lang('Site.menus.name_en') ?></th>
                                <th><?= lang('Site.menus.name_ar') ?></th>
                                <th><?= 'Url' ?></th>
                                <th><?= 'Icon' ?></th>
                                <th><?= lang('Site.menus.menu_type') ?></th>
                                <th><?= lang('Site.menus.order') ?></th>
                                <!-- <th><?//= lang('menus')['input_title'] ?></th> -->
                                <!-- <th><?//= lang('menus')['type'] ?></th> -->
                                <th><?= lang('Site.common.status') ?></th>
                                <th><?= lang('Site.common.action') ?></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- add modal -->
    <div id="add_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= 'Menus Form' ?></h4>
                    <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="inner_add"></div>
                    <!-- <form id="add_form" enctype="multipart/form-data"> -->
                    <form id="add_form" method="post" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-dark">
                                    <label><?= lang('Site.menus.name_en') ?></label>
                                    <input type="text" class="form-control border-secondary" name="tab_name_en" id="tab_name_en" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-dark" style="text-align: right;">
                                    <label><?= lang('Site.menus.name_ar') ?></label>
                                    <input type="text" class="form-control border-secondary" name="tab_name_ar" id="tab_name_ar" style="text-align: right;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-dark">
                                    <label><?= lang('Site.menus.parent_menu') ?></label>
                                    <select class="form-control border-secondary" name="tab_type" id="tab_parent" required>
                                        <option value="0">N/A</option>
                                        <!-- <option value="single"><?//= lang('Site.menus.branch') ?></option> -->
                                        <?php foreach ($menus as $tab) : 
                                            if($tab['tab_parent'] != '0'){
                                                continue;
                                            }
                                            ?>
                                            <option value="<?= $tab['tab_id'] ?>"><?= $tab['tab_name_en']  ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="form-group text-dark">
                                    <label><?= lang('Site.menus.icon') ?></label>
                                    <input type="text" class="form-control border-secondary" name="tab_icon" id="tab_icon" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-dark">
                                    <label><?= lang('Site.menus.order') ?></label>
                                    <input type="number" step="1" min="1" class="form-control border-secondary" id="tab_order" name="tab_order">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-dark">
                                    <label><?= lang('Site.menus.url') ?></label>
                                    <input type="text" class="form-control border-secondary" name="tab_url" id="tab_url" placeholder="" required>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submit_bt" class="btn btn-rounded btn-outline-primary"><b><?= lang('Site.button.save') ?></b></button>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
  


<script>

var base_url = "<?php echo base_url($locale); ?>";
var lang = "<?php echo $locale; ?>";
var manageTable;

    $(document).ready(function() {
        //alert('Hello...');
        
    
        align = 'dt-left';
        if(lang == 'ar'){
            align = 'dt-right';
        }
        // ------------ Data table ------------ \\
        manageTable = $('#manageTable').DataTable({
            columnDefs: [
                { className: align, targets: [0, 1, 2, 3, 4,5,6] },
            ],
            'ajax': base_url + '/settings/menu_list',
            'lengthMenu': [
                [25, 50, -1],
                [25, 50, 'All']
            ],
            
        });
        // ------------ Form Modals ------------ \\ 
        //-- Add --\\ 

        $(document).on('submit', '#add_form', function(event) {
            form(new FormData(this), '/settings/add_menu', '#add_form', '#add_modal', '#inner_add');
        });

        $('#add_modal').on('show.bs.modal', function(e) {
           
           console.log(event.target.id)

           $('#btn_action').val(event.target.id);

           $('#btn_submit').attr('disabled', false)
           if (event.target.id == 'btn_add') {

               $('#btn_action').val(event.target.id);
               $('#btn_submit').show();
               $('#btn_submit').html('Save');
           } else {
               $('#tab_id').val($(e.relatedTarget).data('tab_id'));
               $('#tab_name_en').val($(e.relatedTarget).data('tab_name_en'));
               $('#tab_name_ar').val($(e.relatedTarget).data('tab_name_ar'));
               $('#tab_icon').val($(e.relatedTarget).data('tab_icon'));
               $('#tab_url').val($(e.relatedTarget).data('tab_url'));
               $('#tab_order').val($(e.relatedTarget).data('tab_order'));
               $('#tab_parent').val($(e.relatedTarget).data('tab_parent'));

               if (event.target.id == 'btn_edit') {

                   $('#btn_action').val(event.target.id);
                   $('#btn_submit').show();
                   $('#btn_submit').html('Save Changes');

               }
           }
       });

       $('#add_modal').on('hidden.bs.modal', function(e) {
            $(this).find('form')[0].reset();

        });

   
    });

    function form(data, controller_function, form, modal, inner) {
        event.preventDefault();

        $('#submit_bt').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Saving...');
        $('#submit_bt').attr('disabled', true);

        $.ajax({
            url: base_url + controller_function,
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {

                    $('#submit_bt').attr('disabled', false);
                    $('#submit_bt').html('Save');

                    $("#msg").html(response.msg).fadeIn(500);
                    setTimeout(function() { $("#msg").fadeOut(); }, 2000);
                    manageTable.ajax.reload(null, false);
       
                    
                    $(modal).modal('hide');
                    $(form)[0].reset();
                } else {

                    $('#submit_bt').attr('disabled', false);
                    $('#submit_bt').html('Save');

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

<?= $this->endSection();?>