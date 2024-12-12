<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= 'Order List' ?></h2>
        </div>
        <!-- <div class="col-md-12 align-self-center">
            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#branch_modal"> +
                <?= lang('Site.button.add') ?></button> <br>
        </div> -->
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
                    <div id="messages"></div>


                    <div class="row">
                        <div class="col-md-3 align-right">

                            <label>Payment Number </label>
                            <div class="form-group text-dark">
                                <select class="form-control border-secondary  form-control-sm" name="account_id" id="account_id">
                                    <option value="">Choose Account</option>
                                    <?php foreach ($accounts as $acc) : ?>
                                        <option value="<?= $acc['account_id'] ?>">
                                            <?= $acc['acc_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

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

                        <br><br>

                        <div class="col-md-12" id="basket_order_list">

                        </div>

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
<script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>
<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');

        var wid = 'All';
        get_orders_list(wid);


        $('#waiter_id').on('change', function() {

            let id = $(this).val();
            wid = id;

            get_orders_list(wid);

        })


    });

    function get_orders_list(wid) {

        $.ajax({
            type: 'POST',
            url: base_url + '/waiter/get_basket_orders',
            data: {
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
            url: base_url + '/pos/printable_bill',
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

    function process_payment(basket_id, amount) {


        if ($('#account_id').val() == "") {
            alert('Fadlan dooro Account-ka');
            return;
        }

        if (confirm('Are you sure you want to complete this payment?')) {

            $.ajax({
                type: 'POST',
                url: base_url + '/waiter/pay_order',
                data: {
                    basket_id: basket_id,
                    acc_id: $('#account_id').val(),
                    amount: amount

                },
                success: function(response) {

                    alert('Payment Success')
                    get_orders_list('All');


                }
            });

        }

    }
</script>
<?= $this->endSection(); ?>