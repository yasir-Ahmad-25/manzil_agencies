<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
<div class="row">
            <div class="col-md-4 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url($locale) ?>/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> <?=$title?> </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
</div> </br>
<!-- Data Table  -->
<div class="container-fluid">
    <div class="row">

        <div class="col-12">
            <!-- Horizontal Form -->
            <div class="card">
                <div class="card-title" style="margin: 20px;">
                    <?php
                    $open =  lang('Site.financial.opened');
                    $notopen = lang('Site.financial.closed');
                    ?>
                    <h5> <?= lang('Site.financial.finperiod')?> <?php echo $fp == true ? "( $open )" : "( $notopen )"; ?></h5>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?php echo base_url($locale) ?>/financial/start-period" method="POST" id="openingfrm">

                    <div class="card-body">
                        

                        <?php
                        if ($fp == false) { ?>
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-info"></i> <?= lang('Site.financial.note')?></h3>
                                <div class="jumbotron" style="padding: 20px;">
                                    <p class="">Must Open.</p>
                                </div>
                            </div>
                        <?php } else { ?>

                            <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="trdate" class="col-md-4 control-label"><?= lang('Site.financial.start_date')?></label>
                                            <?php
                                            $sdate = date('F Y', strtotime($finfo->fp_start_date));
                                            ?>
                                            <input type="text" class="form-control" id="address" name="trdate" value="<?= $sdate ?>" readonly placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="trdate" class="col-md-4 control-label"><?= lang('Site.financial.end_date')?></label>
                                            <?php
                                            $edate = date('F Y', strtotime($finfo->fp_end_date));
                                            ?>
                                            <input type="text" class="form-control" id="address" name="trdate" value="<?= $edate ?>" readonly placeholder="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>

                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-info"></i> <?= lang('Site.financial.note')?></h3>
                                <div class="jumbotron" style="padding: 20px;">
                                    <p class="">Must Close.</p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <?php
                    if ($fp == false) { ?>
                        <input type="hidden" name="ttlamount" class="form-control" id="totalamt">
                        <button type="submit" class="btn btn-info saverecord"><?= lang('Site.financial.open')?></button>
                    <?php } ?>

                    <?php
                    if ($inc_exps == 0 && $fp == true) {
                    ?>
                        <button type="button" id="closeperiod" class="btn btn-warning" style="margin:10px"><?= lang('Site.financial.close')?></button>
                    <?php } ?>

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
        if (lang == 'ar') {
            align = 'dt-right';
        }

        $('.addacct').on('click', function() {
            var row = $(this).closest("div.prent").children('.row').html();
            //alert(row);
            $(this).closest("div.prent").append("<div class='row' style='margin-bottom: 10px'>" + row + "</div>");

        });



        $('#closeperiod').on('click', function() {

            $.ajax({

                url: '<?= base_url() ?>financial/end_fin_period',
                type: 'POST',
                success: function(response) {

                    alert(response)
                    location.href = '<?= base_url() ?>financial/finperiod'

                },
                error: function(response) {

                    alert(response)

                }

            });

        });
  
     




    });
</script>

<?= $this->endSection(); ?>