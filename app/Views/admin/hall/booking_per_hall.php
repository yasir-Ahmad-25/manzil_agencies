<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= $title ?></h2>
        </div>
      
    </div>
</div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="mt-3" id="outer"></div>
                    <div class="card-body">

                        <h4> Hall booking report with in (<?=date('d M, Y', strtotime($start))?> and <?=date('d M, Y', strtotime($end))?> )</h4> <br>


                        <div class="row">

                            <br />

                            <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                                    <thead>
                                        <tr> 
                                        <th>Hall Name </th>
                                        <th>Customer</th>
                                        <th>Participants</th>
                                        <th>Booking Date</th>
                                        <th>Start Date</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Discount</th>
                                        <th>Balance</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                        $ttl = 0;
                                        $paid = 0;
                                         foreach ($report as $value) {
                                             
                                        $ttl += $value['total'];
                                        $paid += $value['paid'];
                                           
                                        ?>
                                        <tr>
                                            <td><?=$value['hall_name']?></td>
                                            <td><?=$value['ten_name']?></td>
                                            <td><?=$value['participants']?></td>
                                            <td><?=date('d M, Y', strtotime($value['booking_date']))?></td>
                                             <td><?=date('d M, Y', strtotime($value['started_date']))?></td>
                                             <td>$<?=$value['total']?></td>
                                            <td>$<?=$value['paid']?></td>
                                            <td>$<?=$value['dis']?></td>
                                            <td>$<?=($value['total'] - ($value['paid'] + $value['dis']))?></td>
                                            
                                        </tr>

                                        <?php }
                                        ?>
                                          <tr>
                                            <td colspan="5"><b>Total</b></td>
                                            <td><b>$<?=number_format($ttl,2)?></b></td>
                                            <td><b>$<?=number_format($paid,2)?></b></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>


                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->


    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    <script type="text/javascript">
        var manageTable_site;
        var base_url = "<?php echo base_url(); ?>";


        $(document).ready(function() {
            $('#tablesMainNav').addClass('active');

        });

     
    </script>
    <?= $this->endSection(); ?>