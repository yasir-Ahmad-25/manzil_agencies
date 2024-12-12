<?= $this->extend("admin/layouts/base"); ?>
<?= $this->section('content'); ?>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title">PAYABLES REPORT </h2>
        </div>
       
    </div>
</div>
<!-- Data Table  -->
<div class="container-fluid">
    <div class="card col-md-12">
        <div id="outer"></div>
        <div class="card-body">
            <div class="table-responsive">
                
                <table id="manageTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Supplier Name</th>
                            <th>Phone Number</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- add modal -->

<script>
    var base_url = "<?php echo base_url($locale); ?>";
    var lang = "<?php echo $locale; ?>";
    var manageTable;
    $(document).ready(function() {

        payables_report();

    });


    function payables_report() {

        $.ajax({
            url: base_url + '/report/payables_report',
            type: "GET",
            data: {
            },
            success: function(response) {

                $("#manageTable").append(response);

            }
        });
    }
</script>

<?= $this->endSection(); ?>