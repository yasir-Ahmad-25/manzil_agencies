<?= $this->extend("admin/layouts/base");?>

<?= $this->section('content');?>

    <div class="page-breadcrumb">
    <div class="row">
            <div class="col-md-4 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url($locale) ?>/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</br>
    <!-- Data Table  -->
    <div class="container-fluid">
        <div class="card col-md-12">
            <div id="outer"></div>
            <div id="msg" class="alert alert-success alert-dismissible" role="alert" style="display:none;">.......
            </div>
            <div class="card-body" id="accholder">
                
            </div>
        </div>
    </div>
    
    
    
      <!-- add modal -->
      <div id="form_modal" class="modal fade" role="dialog" aria-hidden="true" data-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="form_modal_label"></h4>
                    <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="inner_add" style="color: red; margin:10px"></div>
                    <form id="form_main" method="post" action="<?= base_url($locale).'/financial/manage_acc'?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12" id="acc_type_label">
                                <div class="form-group text-dark">
                                    <label><?= lang('Site.financial.acctype')?></label>
                                    <input type="text" disabled class="form-control" id="acc_type_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group text-dark col-md-6 mt-1 mb-1" style="direction: ltr;">
                                        <!-- <label><?//= lang('Site.financial.accname_en')?></label> -->
                                        <input type="text" class="form-control" name="acc_name" id="acc_name" placeholder="<?= lang('Site.financial.accname_en')?>">
                                        <input type="hidden" class="form-control" name="acc_grp_id" id="acc_grp_id">
                                        <input type="hidden" class="form-control" name="acc_type_id" id="acc_type_id">
                                        <input type="hidden" class="form-control" name="form_tag" id="form_tag">
                                        <input type="hidden" class="form-control" name="account_id" id="account_id">
                                        <input type="hidden" class="form-control" name="acc_balance" id="acc_balance">
                                    </div>
                                    <div class="form-group text-dark col-md-6">
                                        <!-- <label><?//= lang('Site.financial.accname_ar')?></label> -->
                                        <input type="text" class="form-control" name="acc_name_ar" id="acc_name2" placeholder="<?= lang('Site.financial.accname_ar')?>">

                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12" id="acc_des_label">
                                <div class="form-group">
                                    <!-- <label><?//= lang('Site.financial.accdescr')?></label> -->
                                    <textarea class="form-control" rows="2" name="acc_des" id="acc_des" placeholder="<?= lang('Site.financial.accdescr')?>"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-rounded btn-outline-primary"><b><?= lang('Site.button.save') ?></b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Edit Modal  -->
    <div id="edit" class="modal fade" role="dialog" aria-hidden="true" data-keyboard='false'>
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= lang('Site.button.edit') ?></h4>
                    <button type="button" class="btn-close border-0 p-3" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="inner_edit"></div>
                    <form id="edit_acc" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-dark">
                                    <label><?= lang('Site.financial.accname') ?></label>
                                    <input type="text" class="form-control border-secondary" name="uc_name" id="uc_name_edit">
                                    <input type="hidden" class="form-control border-secondary" name="uc_id" id="uc_id_edit">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?= lang('Site.financial.accdescr') ?></label>
                                    <textarea class="form-control" rows="3" name="uc_des" id="uc_des_edit" placeholder="Description"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-rounded btn-outline-warning"><b><?= lang('Site.button.edit') ?></b></button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
   

    <script>
    $(document).ready(function() {
        //alert('Hello...');
        var manageTable;
        var base_url = "<?php echo base_url($locale); ?>";
        var lang = "<?php echo $locale; ?>";
        align = 'dt-left';
        if(lang == 'ar'){
            align = 'dt-right';
        }
        loadAcc();

         //-- Add --\\ 
         $(document).on('submit', '#form_main', function(event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                url: base_url + '/financial/manage_acc',
                //type: form.attr('method'),
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success === true) {
                        // manageTable.ajax.reload(null, false);
                        loadAcc();
                        $("#form_modal").modal('hide');
                        $("#form_main")[0].reset();
                        $("#msg").html(response.message).fadeIn(500);
                        setTimeout(function() { $("#msg").fadeOut(); }, 2000);
                        
                    } else {
                       // $("#form_modal").modal('hide');
                        $("#form_main")[0].reset();

                        $("#inner_add").html(response.message).fadeIn(500);
                        setTimeout(function() { $("#inner_add").fadeOut(); }, 2000);
                       
               
                    }
                }
            });
            return false;
        });
        //-- Edit --\\ 
        $(document).on('submit', '#edit_acc', function(event) {
            event.preventDefault();
            var form = $(this);
            alert("inside Edit");
            $.ajax({
                url: base_url + '/financial/manage_acc',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success === true) {

                        $("#msg").html(response.message).fadeIn(500);
                        setTimeout(function() { $("#msg").fadeOut(); }, 2000);                     

                        $("#edit").modal('hide');
                        $("#edit_user_cat")[0].reset();
                    } else {
                        $("#msg").html(response.message).fadeIn(500);
                        setTimeout(function() { $("#msg").fadeOut(); }, 2000);
                    }
                }
            });
            return false;
        });

        //*********** Form Modal**************/
        $('#form_modal').on('show.bs.modal', function(e) {
            // $('#uc_id_edit').val($(e.relatedTarget).data('uc_id_edit'));
            if (event.target.id == 'btn_add') {
                $('#acc_type_label, #acc_des_label').attr('hidden', false)
                $('#acc_name').attr('readonly', false)
                $('#acc_grp_id').val($(e.relatedTarget).data('acc_grp_id'));
                $('#acc_type_id').val($(e.relatedTarget).data('acc_type_id'));
                $('#acc_type_name').val($(e.relatedTarget).data('acc_type_name'));
                $('#acc_grp_name').val($(e.relatedTarget).data('acc_grp_name'));
                $('#form_tag').val(event.target.id);
                $('#form_modal_label').html('<i class="fas fa-plus-circle text-primary mx-1"></i> <?= lang('Site.financial.newacc')?>');
            } else if (event.target.id == 'btn_edit') {
                $('#acc_type_label').attr('hidden', true)
                $('#acc_des_label').attr('hidden', false)
                $('#acc_name').attr('readonly', false)

                $('#acc_name').val($(e.relatedTarget).data('acc_name'));
                $('#acc_name2').val($(e.relatedTarget).data('acc_name_ar'));
                $('#acc_des').val($(e.relatedTarget).data('acc_des'));
                $('#account_id').val($(e.relatedTarget).data('account_id'));
                $('#form_tag').val(event.target.id);
                $('#form_modal_label').html('<i class="fas fa-edit text-warning mx-1"></i> <?= lang('Site.financial.editacc')?>');
            } else if (event.target.id == 'btn_del') {
                $('#acc_type_label, #acc_des_label').attr('hidden', true)
                $('#acc_name').attr('readonly', true)
                $('#acc_name').val($(e.relatedTarget).data('acc_name'));
                $('#acc_des').val($(e.relatedTarget).data('acc_des'));
                $('#account_id').val($(e.relatedTarget).data('account_id'));
                $('#acc_balance').val($(e.relatedTarget).data('acc_balance'));
                $('#form_tag').val(event.target.id);
                $('#form_modal_label').html('<i class="fas fa-trash-alt text-danger mx-1"></i> Delete Account');
            }


        });

        $('#edit').on('show.bs.modal', function(e) {
            // $('#uc_id_edit').val($(e.relatedTarget).data('uc_id_edit'));
            $('#acc_grp_id').val($(e.relatedTarget).data('acc_grp_id'));
            $('#acc_type_id').val($(e.relatedTarget).data('acc_type_id'));
            // alert($(e.relatedTarget).data('acc_type_name'));
        });

       function loadAcc(){
            $.ajax({
                url: base_url + '/financial/acc_list',
                //type: 'POST',
                //method: 'POST',
                //dataType: 'json',
                success: function(resp) {
                    $("#accholder").html(resp);
                } ,
                error: function(err) {
                    console.log(err);
                }
            });
       }
  


 });
   
   
</script>

<?= $this->endSection();?>