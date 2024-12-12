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



                                <option value="0"> <?= lang('Site.financial.choose_source') ?> </option>
                                <?php
                                foreach ($sources as $val) {  ?>
                                    <option value="<?= $val['trx_source'] ?>"><?= $val['trx_source'] ?></option>
                                <?php }
                                ?>

                            </select>
                        </div>
                        <div class="col-md-3">
                            <!-- <label for="startDate">Start Date:</label> -->
                            <input type="date" id="startDate" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <!-- <label for="endDate">End Date:</label> -->
                            <input type="date" id="endDate" class="form-control">
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button id="dateFilterBtn" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                    <!-- Date Filter Controls Start Here -->
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

        $('#dateFilterBtn').on('click', function() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
           // alert('startDate '+ startDate + ' And ' +'EndDate ' +endDate)

            // AJAX call to the server-side script
            $.ajax({
                url: base_url + '/income/filter_sales',
                type: 'POST',
                dataType: 'json',
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                success: function(response) {
                    if (response.status == 'no_data') {
                        swal("No Data", "No data found for the selected dates.", "warning");
                    } else if (response.status === 'success') {
                        $("#manageTable tbody").html(response.html);
                        // $('#res').html(response.html);
                        console.log(response.html);
                    }
                }
            });
        });

        function load_data(query) {
            $.ajax({
                url: base_url + "/financial/trxlist",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#res').html(data);
                }
            });
        }


    });
</script>

<?= $this->endSection(); ?>