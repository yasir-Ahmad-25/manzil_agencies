<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <!--                        <h4 class="page-title">Starter Page</h4>-->
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Waiter Orders </li>

                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 align-self-center d-none d-md-block">
                <!--<button class="btn float-right btn-success"><i class="mdi mdi-plus-circle"></i> Create</button>-->
                <div class="dropdown float-right mr-2 hidden-sm-down">

                </div>
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
                        <br />
                        <div id="messages">
                  
                        </div>

                        <div class="row">
                            <div class="col-md-3 align-right">

                                <label>Waiters </label>
                                <div class="form-group text-dark">
                                    <select class="form-control border-secondary  form-control-sm" name="waiter_id" id="waiter_id">
                                        <option value="All">All</option>


                                        <?php foreach ($waiters as $acc) : ?>
                                            <option value="<?= $acc['waiter_id'] ?>">
                                                <?= $acc['waiter_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-3 align-right">
                                <label>Date </label>
                                <div class="form-group text-dark">
                                    <input type="date" class="form-control" id="start" name="start" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="col-md-6">

                            <!-- <div class="button-group">
                                <button type="button" class="btn btn-lg waves-effect waves-light btn-outline-info">Order In  (<span id="order_in"></span>)</button>

                                <button type="button" class="btn btn-lg waves-effect waves-light btn-outline-success">Completed (<span id="completed"></span>)</button>
                                <button type="button" class="btn btn-lg waves-effect waves-light btn-outline-danger">Canceled  (<span id="canceled"></span>)</button>
                            </div> -->

                        </div>

                        <br>


                        <div class="col-md-12" id="basket_order_list">

                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->


        <div id="order_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard='false'>
            <div class="modal-dialog vertical-center-scroll-modal">
                <form id="discard_form">
                    <div class="modal-content">
                        <div class="modal-body" id="print_this_order">
                            <p class="text-center" style="text-align: center; margin: 0px 0px;">
                                <br>
                                <br><span id="order_label">Order Details</span><br>
                            </p>
                            <div class="row">
                                <div class="col-md-12" id="print_order_set">

                                </div>

                            </div>


                        </div>


                    </div>
                </form>
            </div>
        </div>


    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url() ?>js/printThis.js"></script>
    <script type="text/javascript">
     var base_url = "<?php echo base_url($locale); ?>";

        var manageTable;
 

        $(document).ready(function() {
            $('#tablesMainNav').addClass('active');

            let date = $('#start').val();

            get_orders_list('All', date);

            $('#waiter_id').on('change', function() {

                let wid = $(this).val();
                let date = $('#start').val();

                get_orders_list(wid, date);

            });


            $('#start').on('change', function() {

                let wid = $('#waiter_id').val();
                let date = $(this).val();

                get_orders_list(wid, date);

            });

        });


        function get_orders_list(wid, date) {

            $.ajax({
                type: 'POST',
                url: base_url +'/orders/get_empty_orders',
                data: {
                    date: date,
                    wid: wid
                },
                success: function(response) {

                    $('#basket_order_list').html(response);

                }
            });

        }

        function process_printing(order_id) {

            $.ajax({
                type: 'POST',
                url: base_url+'/pos/printable_bill',
                dataType: 'json',
                data: {
                    basket_id: order_id,
                },
                success: function(response) {
                    $('#order_modal').modal('show');
                    $('#print_order_set').html(response.print_basket);

                }
            });

        }

        function process_cancel(basket_id, amount) {


            if (amount != undefined) {
                alert('Lama tiri karo dalabkaan');
                return;
            }


            $.ajax({
                type: 'POST',
                url: base_url+'/orders/cancel_order',
                data: {
                    basket_id: basket_id,

                },
                success: function(response) {

                    alert(response)

                    let wid = $('#waiter_id').val();
                    let date = $('#start').val();

                    get_orders_list(wid, date);


                }
            });


        }
    </script>


<?= $this->endSection('content'); ?>