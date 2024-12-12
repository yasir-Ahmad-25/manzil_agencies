<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>
<div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center  p-2">
                <h2 class="page-title">Purchase information</h2>
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
                                <th><?= 'Item Name' ?></th>
                                <th><?= 'Quanity' ?></th>
                                <th>Cost/unit</th>
                                <th>Total cost</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- add modal -->



    <!-- Status Modal -->
    <div id="status_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-dialog-centered">
            <form id="status_form" enctype="multipart/form-data">
                <div class="modal-content" id="change_state">
                </div>
            </form>
        </div>
    </div>
</div>





<script>

var base_url = "<?php echo base_url($locale); ?>";
    var lang = "<?php echo $locale; ?>";

    $(document).ready(function() {
        var manageTable;
    

        manageTable = $('#manageTable').DataTable({
                // columnDefs: [
                // { className: align, targets: [0, 1, 2, 3, 4,5,6,7,8] },
                // ],
                'ajax': base_url + '/purchases/purchase_details_list/'+'<?=$rid?>',
                'order': [],
                destroy: true,
                searching: false
            })
    

    });
</script>

<?= $this->endSection('content'); ?>



