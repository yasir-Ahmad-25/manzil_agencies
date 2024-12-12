<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= $title ?></h2>
        </div>
        <!-- <div class="col-md-7" style="text-align: end">
                <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#user_modal"> +
                    <? //= lang('Site.button.add') 
                    ?></button> <br>
            </div> -->
    </div>
</div>
<!-- Data Table  -->
<div class="container-fluid">
<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> <?= $title ?> </h4>
                        <h6 class="card-subtitle"></h6>
                        <!--                        <a href="<?php echo base_url() ?>purchase/create_order"> 
                            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2 float-right"> New Purchase</button></a>-->

                        <br>
                        <div class="row">
                            <label class="col-md-0" style="margin-left:15px"><?= lang('Site.financial.filterby') ?></label>
                            <div class="col-md-2">

                                <select name="source" id="source" class="form-control">

                                    <option value="0" disabled> <?= lang('Site.financial.choose_source') ?> </option>
                                    <?php
                                    foreach ($sources as $val) {  ?>
                                        <option value="<?= $val['trx_source'] ?>"><?= $val['trx_source'] ?></option>
                                    <?php }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <br />


                        <div class="table-responsive">

                            <div id="res"></div>

                        </div>
                    </div>
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
        var aut = 2;
        
        load_data($('#source').val());

        $('body').on('click', '.view', function() {

            var tr = $(this).closest('tr').next('tr');
            tr.toggle();

        });

        $('#source').on('change', function() {

            load_data($(this).val());

        });


        function load_data(query) {
            $.ajax({
                url: base_url + "/financial/trxlist",
                method: "POST",
                data: {query: query},
                success: function(data) {
                    $('#res').html(data);
                }
            });
        }


    });
</script>

<?= $this->endSection(); ?>