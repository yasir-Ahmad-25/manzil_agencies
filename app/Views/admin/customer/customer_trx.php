<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= 'Customer Statments' ?></h2>
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
                    <div class="card-body" id="print_area">

                    <h3 class="card-title text-center"> <?=session()->get('branch_name')?></h3>
                        <h4 class="card-title text-center"> Customer Balance Information </h4>
                        <h5 class="card-title text-center"> Customer Name: <?= $cust->cust_name ?></h5>
                        <!-- <button class="btn btn-primary" id="btn_add" data-toggle="modal" data-target="#form_modal">Add</button> <br> -->
                        <br />
                        <div id="messages"></div>

                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr style="background-color:#c0ed95;">
                                    <th>Issue Date</th>
                                    <th>Remarks</th>
                                    <th>Amount </th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $bal = 0;
                                $dr_total =  $cr_total = 0;
                                foreach ($history as $val) {
                                    $total += $val['balance'];
                                    if ($val['remarks'] == "Receipt") {
                                      //  $debit = $val['amount'];
                                        $dr_total -= $val['amount'];
                                    } else {
                                        $credit = $val['amount'];
                                        $cr_total += $val['amount'];
                                    }

                                    $bal = $val['balance'];
                                ?>
                                    <tr>
                                        <td><?= date('d M, Y', strtotime($val['created_date'])) ?></td>
                                        <td><?= $val['remarks'] ?></td>
                                        <td>$<?= $val['amount']?></td>
                                        <td>$<?= $val['balance'] ?></td>
                                    </tr>

                                <?php } ?>

                                <!-- <tr>
                                    <td colspan="1" style="text-align:right;"><b>Total</b></td>
                                    <td><b>$<?= $dr_total ?></b></td>
                                    <td><b>$<?= $cr_total ?></b></td>
                                    <td><b>$<?= $bal ?></b></td>
                                </tr> -->

                            </tbody>

                        </table>

                    </div>
                    <div class="col-12 text-right" style="margin: 10px;">
                        <input type="button" value="Print" id="advanced">
                    </div>
                    <br>
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
<script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>
<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function() {

        $('#tablesMainNav').addClass('active');
        // initialize the datatable 
        // manageTable = $('#manageTable').DataTable({
        //     'ajax': base_url + 'property/fetch_apart_types',
        //     'order': []
        // });


    });

    $('#advanced').click(function() {
        $('#print_area').printThis({
            debug: false, // show the iframe for debugging
            importCSS: true, // import parent page css
            importStyle: true, // import style tags
            printContainer: true, // print outer container/$.selector
            loadCSS: "<?php echo base_url() ?>public/assets/css/style.min.css", // path to additional css file - use an array [] for multiple
            pageTitle: "Report", // add title to print page
            removeInline: false, // remove inline styles from print elements
            printDelay: 333, // variable print delay
            header: null, // prefix to html
            footer: null, // postfix to html
            base: false, // preserve the BASE tag, or accept a string for the URL
            formValues: true, // preserve input/form values
            canvas: false, // copy canvas content
            doctypeString: '...', // enter a different doctype for older markup
            removeScripts: false, // remove script tags from print content
            copyTagClasses: false, // copy classes from the html & body tag
            beforePrintEvent: null, // function for printEvent in iframe
            beforePrint: null, // function called before iframe is filled
            afterPrint: null // function called before iframe is removed
        });
    });
</script>
<?= $this->endSection();?>