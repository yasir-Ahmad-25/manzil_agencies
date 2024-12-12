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

                        <div class="row">


                            <div class="col-md-3 align-right">

                                <label>Halls</label>
                                <div class="form-group text-dark">
                                    <select class="form-control border-secondary  form-control-sm" name="hall_id" id="hall_id">
                                        <option value="All" selected>All</option>
                                        <?php foreach ($halls as $hall) : ?>
                                            <option value="<?= $hall['hall_id'] ?>">
                                                <?= $hall['hall_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>

                            <div class="col-2 form-group text-dark">
                                <label>Start </label>
                                <input type="date" class="form-control border-secondary" id="start">
                            </div>

                            <div class="col-md-2 form-group text-dark">
                                <label>End</label>
                                <input type="date" class="form-control border-secondary" id="end">
                            </div>
                            
                                <div class="col-md-3 form-group text-dark" >
                                <button class="btn btn-primary" type="button" id="searchBtn" value="Search" style="margin-top: 30px;">
                                   Search
                                </button>
                            </div>



                        </div>

                        <br />
                        <div id="waiter_sales_rep"></div>

                        <br />
                        <div id="waiter_sales_rep_dt"></div>


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
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');

        hall_booking_rep('All', '', '');


        $('#hall_id').on('change', function() {

            let hid = $(this).val();

            start = $('#start').val();
            end = $('#end').val();

            hall_booking_rep(hid, start, end);

        });


          $('#searchBtn').on('click', function() {

            let span = ' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Searching...'
            $('#searchBtn').html(span).prop('disabled', true);

            let hid = $('#hall_id').val();

            start = $('#start').val();
            end = $('#end').val();

            hall_booking_rep(hid, start, end);

        });

    });

    function hall_booking_rep(hid, start, end) {

        $.ajax({
            type: 'POST',
            url: base_url + '/booking/get_booking_report',
            data: {
                hall_id: hid,
                start: start,
                end: end
            },
            success: function(response) {


                $('#waiter_sales_rep').html(response);
                
                 $('#searchBtn').html('Search').prop('disabled', false);
                 
            }
        });
    

    }
</script>
<?= $this->endSection(); ?>