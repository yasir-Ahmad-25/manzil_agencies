<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= lang('Site.hr.payroll')?></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-12" style="text-align: end">
            <button class="btn btn-primary" id="btn_add" data-bs-toggle="modal" data-bs-target="#salary_modal">
                        <?= lang('Site.button.add') .' Payroll'; ?>
                        </button>
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
                    <div id="msg" class="alert alert-success alert-dismissible" role="alert" style="display:none;"></div>
                    <div id="err" class="alert alert-danger alert-dismissible" role="alert" style="display:none;"></div>
                    
                    <div class="card-body">

                        <br />
                        <div id="messages"></div>

                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= lang('Site.hr.employee')?></th>
                                    <th><?= lang('Site.hr.job')?></th>
                                    <th><?= lang('Site.hr.commission')?></th>
                                    <th><?= lang('Site.hr.deductions')?></th>
                                    <th><?= lang('Site.hr.net_salary')?></th>
                                    <th><?= lang('Site.hr.month')?></th>
                                    <th><?= lang('Site.hr.payment_acc')?></th>
                                    <th><?= lang('Site.common.date')?></th>
                                    <th><?= lang('Site.common.action')?></th>
                                </tr>
                            </thead>
                            <tbody>

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

    <!-- form modal -->
    <div id="salary_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= lang('Site.hr.payroll')?></h4>
                    <button type="button" class="btn-close border-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="data_form">

                        <div class="modal-body">

                            <input type="hidden" name="btn_action" id="btn_action">

                            <input type="hidden" name="salary_id" id="salary_id">
                            <input type="hidden" name="old_trx_id" id="old_trx_id">
                            <input type="hidden" name="old_amount" id="old_amount">


                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="emp_id" class="control-label"><?= lang('Site.hr.employee')?></label>
                                    <select name="emp_id" id="emp_id" class="form-control" required>
                                        <option value="" selected disabled>Select Employee</option>
                                        <?php
                                        foreach ($employees as $val) { ?>
                                            <option value="<?php echo $val['emp_id']; ?>"><?php echo $val['emp_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-6 form-group">
                                    <label for="job_name" class="control-label"><?= lang('Site.hr.job')?></label>
                                    <input type="text" class="form-control" id="job_name" name="job_name" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="gross_sal"> <?= lang('Site.hr.base_salary')?></label>
                                    <input type="text" class="form-control" id="gross_sal" name="gross_sal">
                                    <input type="hidden" class="form-control" id="base_salary" name="base_salary">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="deduction"> <?= lang('Site.hr.deductions')?></label>
                                    <input type="number" class="form-control" id="deduction" name="deduction" min="0" readonly>
                                </div>
                            </div>

                            <div class="row">
                                
                                <div class="col-6 form-group">
                                    <label for="comm"><?= lang('Site.hr.commission')?></label>
                                    <input type="number" class="form-control" id="comm" name="comm" min="0" readonly>
                                </div>

                                <div class="col-6 form-group">
                                    <label for="net_pay"><?= lang('Site.hr.net_salary')?></label>
                                    <input type="text" class="form-control" id="net_pay" name="net_pay">
                                </div>
                            </div>

                            <div class="row">

                            <div class="col-6 form-group">
                                    <label for="month" class="control-label"><?= lang('Site.hr.month')?></label>
                                    <select name="month" id="month" class="form-control" required>
                                        <option value="" selected disabled>Select Month</option>
                                        <?php
                                        for ($m = 1; $m <= 12; $m++) {
                                            $month = date('F', mktime(0, 0, 0, $m));
                                            echo '<option value="' . $month . '">' . $month. '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-6 form-group">
                                    <label for="account_id" class="control-label"><?= lang('Site.hr.payment_acc')?></label>
                                    <select name="account_id" id="account_id" class="form-control" required>
                                        <option value="" selected disabled>Select Account</option>
                                        <?php
                                        foreach ($accounts as $val) { ?>
                                            <option value="<?php echo $val['account_id']; ?>"><?php echo $val['acc_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="payment_date"><?= lang('Site.common.date')?></label>
                                <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?= date('Y-m-d') ?>">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="btn_submit" class="btn btn-rounded btn-outline-primary"><b><?= lang('Site.button.save') ?></b></button>
                        </div>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <!-- delete modal content -->
    <!-- Status Modal -->
    <div id="status_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-dialog-centered">
            <form id="status_form" enctype="multipart/form-data">
                <div class="modal-content" id="change_state">

                </div>
            </form>
        </div>
    </div>


<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script type="text/javascript">
    var manageTable_site;
    var base_url = "<?php echo base_url($locale); ?>";


    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 

        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + '/hr/get_payroll',
            'order': []
        });

        function job() {

            var lang = "<?php echo $locale; ?>";
            align = 'dt-left';
            if(lang == 'ar'){
                align = 'dt-right';
            }
            manageTable = $('#manageTable').DataTable({
                columnDefs: [
                { className: align, targets: [0, 1, 2, 3, 4] },
                ],
                'ajax': base_url + '/hr/get_jobs',
                'order': [],
                destroy: true,
                searching: false
            });

        }

        // ------------ Data Passing To Modals ------------ \\
        $('#salary_modal').on('show.bs.modal', function(e) {

            // alert(event.target.id)
            $('#btn_action').val(event.target.id);

            $('#btn_submit').attr('disabled', false)


            if (event.target.id == 'btn_add') {

                $('#data_form')[0].reset();

                $('#btn_submit').show();
                //$('#btn_submit').html('Save');

            } else if (event.target.id == 'btn_edit') {

                let comm = $(e.relatedTarget).data('comm');
                let net_pay = $(e.relatedTarget).data('net_pay');
                let deduction = $(e.relatedTarget).data('deduction');
                let gross_sal =  parseFloat(net_pay) + parseFloat(deduction);
                $('#gross_sal').val(gross_sal);

                $('#emp_id').val($(e.relatedTarget).data('emp_id'));
                $('#job_id').val($(e.relatedTarget).data('job_id'));
                $('#comm').val($(e.relatedTarget).data('comm'));
                $('#deduction').val($(e.relatedTarget).data('deduction'));
                $('#net_pay').val($(e.relatedTarget).data('net_pay'));
                $('#account_id').val($(e.relatedTarget).data('account_id'));
                $('#month').val($(e.relatedTarget).data('month'));

                $('#old_amount').val($(e.relatedTarget).data('net_pay'));
                $('#old_trx_id').val($(e.relatedTarget).data('trx_id'));

                $('#salary_id').val($(e.relatedTarget).data('salary_id'));


                $('#btn_submit').show();
                $('#btn_submit').html('Save Changes');

            }

        });

        $('#emp_id').on('change', function() {

            $.ajax({
                url: base_url + '/hr/get_base_salary',
                type: "POST",
                data: {
                    emp_id: $(this).val(),
                },
                dataType: "JSON",
                success: function(response) {
                    $("#net_pay").val(response.job_salary);
                    $("#gross_sal").val(response.job_salary);
                    $("#base_salary").val(response.job_salary);
                    $('#comm').val(0);
                    $('#deduction').val(0);
                    $('#job_name').val(response.job_name);

                }
            });
        });

        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), '/hr/manage_salary', '#data_form', '#salary_modal', '#inner_add');
        });

    });

    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), 'tenant/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
        state_change('job',
            $(e.relatedTarget).data('rec_tbl'),
            $(e.relatedTarget).data('rec_tag'),
            $(e.relatedTarget).data('rec_tag_col'),
            $(e.relatedTarget).data('rec_id'),
            $(e.relatedTarget).data('rec_id_col'),
            $(e.relatedTarget).data('rec_title'));
    });



    function state_change(rec_page, rec_tbl, rec_tag, rec_tag_col, rec_id, rec_id_col, rec_title) {
        // alert('')
        $.ajax({
            url: base_url + 'tenant/change_status',
            type: "POST",
            dataType: 'json',
            data: {
                rec_id: rec_id,
                rec_id_col: rec_id_col,
                rec_title: rec_title,
                rec_tag: rec_tag,
                rec_tag_col: rec_tag_col,
                rec_tbl: rec_tbl,
                rec_page: rec_page
            },
            success: function(response) {
                $("#change_state").html(response.status);
            }
        });
    }

    function form(data, controller_funtion, form, modal, inner) {
        event.preventDefault();

        $('#btn_submit').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Saving...');
        $('#btn_submit').attr('disabled', true);

        $.ajax({
            url: base_url + controller_funtion,
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {

                    $('#btn_submit').attr('disabled', false);
                    $('#btn_submit').html('Save');


                    $("#msg").html(response.msg).fadeIn(500);
                    setTimeout(function() { $("#msg").fadeOut(); }, 2000);
                    manageTable.ajax.reload(null, false);


                    $(modal).modal('hide');
                    $(form)[0].reset();
                } else {

                    $('#btn_submit').attr('disabled', false);
                    $('#btn_submit').html('Save');


                    $("#err").html(response.msg).fadeIn(500);
                    setTimeout(function() { $("#err").fadeOut(); }, 2000);
                }
            }
        });
        return false;
    }


    function triggerClick() {
        // alert();
        document.querySelector('#id_img').click();
    }

    function display(e) {
        // alert();
        if (e.files) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#pdis').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }
</script>
<?= $this->endSection('content'); ?>