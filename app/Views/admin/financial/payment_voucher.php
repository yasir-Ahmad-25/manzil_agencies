
<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
<div class="row">
            <div class="col-md-4 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url($locale) ?>/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> <?=$title?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
</div> </br>
<!-- Data Table  -->
<div class="container-fluid" style="color:#404040;">
    <div id="outer"></div>
    <div class="card">
        <div class="card-body col-10 mx-auto">
            <div id="outer"></div>
            <div id="inner"></div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <small>
                                <div id="outer"></div>

                            </small>
                            <h6 class="card-subtitle"></h6>



                            <!-- <form class="form-horizontal" id="data_form" method="post" > -->
                            <!-- <form method="POST" id="data_form" action="record_voucher" accept-charset="UTF-8" class="form-horizontal" parsley-validate="" novalidate="" enctype="multipart/form-data"> -->
                            <!-- <form class="form-horizontal" id="data_form" action="/customer/record_vouchers" method="POST"> -->
                            <form id="data_form" enctype="multipart/form-data">
                                <div class="box-header with-border">

                                    <h3 class="box-title"><?= lang('Site.Voucher.payment_voucher') ?></h3>

                                    <div id="inner_add"></div>
                                </div>
                                <br>
                                <div class="row">

                                    <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="curr_id" class="control-label"> <?= lang('currency'); ?> </label>
                                    <select class="form-control custom-select" name="curr_id" id="curr_id">
                                        <option value="">--Select--</option>

                                    </select>
                                </div>
                            </div> -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staff" class="control-label"> <?= lang('Site.Voucher.refnum') ?> </label>
                                            <input type="text" class="form-control" id="refnum" name="refnum">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php  $session = session();?>
                                            <label for="staff" class="control-label"><?= lang('Site.Voucher.payment_voucher1') ?></label>
                                            <input type="text" class="form-control" id="staff" name="staff" value="<?= $session->get('user')['fullname']; ?>" readonly placeholder="Address">

                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <?php $session = session(); ?>
                                            <label for="staff" class="control-label">Branch </label>
                                            <input type="text" class="form-control" id="staff" name="staff" value="<?= $session->get('user')['branch_id']; ?>" readonly placeholder="Address">

                                        </div>
                                    </div> -->


                                </div>

                                <hr />



                                <div class="box-body">

                                    <div class="row">
                                    <?php
                                        $language = service('request')->getLocale();
                                        $isArabic = ($language === 'ar');
                                        ?>
                                        <div class="col-4 form-group">
                                            <label for="paid_from" class="control-label"><?= lang('Site.Voucher.paid_from') ?></label>
                                       
                                            <select name="paid_from" id="paid_from" class="form-control custom-select">

                                                <?php
                                                foreach ($bank_accounts as $val) {
                                                ?>
                                                    <option value="<?= $val['account_id']; ?>"><?= $isArabic ? $val['acc_name_ar'] : $val['acc_name'] ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                                                                                                                            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="amount" class="control-label"><?= lang('Site.Voucher.amount') ?></label>
                                                <input type="text" class="form-control" id="amount" name="amount">
                                            </div>
                                        </div>

                                        <div class="col-4 form-group">
                                            <label for="paid_to" class="control-label"><?= lang('Site.Voucher.paid_to') ?></label>
                                            <select name="paid_to" id="paid_to" class="form-control">

                                                <?php
                                                //foreach ($allacc as $val) {
                                                foreach ($other_accounts as $val) {
                                                ?>
                                                    <option value="<?= $val['account_id']; ?>"><?= $isArabic ? $val['acc_name_ar'] : $val['acc_name'] ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="des" class="control-label"><?= lang('Site.Voucher.desc') ?></label>
                                                <input type="text" class="form-control" id="des" name="des">
                                            </div>
                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label for="date"><?= lang('Site.Voucher.date') ?></label>
                                                <input type="date" class="form-control" id="date" name="date" value="<?= date('Y-m-d') ?>">
                                            </div>

                                        </div>


                                    </div>

                                </div>
                                <br>
                                <br>

                                <div class="box-footer">
                                    <input type="hidden" name="voucher_type" value="PaymentVoucher">
                                    <input type="hidden" name="voucher_status" value="posted">
                                    <button type="submit" id="post_record" class="btn btn-rounded btn-outline-primary"><b><?= lang('Site.button.save') ?></b></button>
                                    <!-- <button type="submit" id="save_pv" class="btn btn-primary btn-lg"><?= lang('Site.button.save') ?></button> -->
                                    <!-- <button type="button"  id="save_pv" class="btn btn-info pull-right saverecord"><?php echo lang('submit'); ?></button> -->
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="mt-3" id="outer"></div>

                        <div class="card-body">

                            <!-- <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="startdate" class="control-label">From Date</label>
                                            <input type="date" class="form-control" id="startdate" name="startdate" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="enddate" class="control-label">To Date</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="enddate" name="enddate" autocomplete="off">
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div> -->
                            <br />
                            <br />

                            <div id="messages"></div>

                            <div id="vouchers_list"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div id="status_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
    <div class="modal-dialog modal-dialog-centered">
        <form id="status_form" enctype="multipart/form-data">
            <div class="modal-content" id="change_state">

            </div>
        </form>
    </div>
</div>
<!-- Add this in your HTML file -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function() {
        var manageTable;
        var base_url = "<?php echo base_url($locale); ?>";
        var img = '';
        // ------------ Data table ------------ \\
        // manageTable = $('#manageTable').DataTable({
        //     'ajax': base_url + 'reception/patient_list',
        //     'order': []
        // });
        // ------------ Form Modals ------------ \\ 
        //-- Add --\\ 
        // $(document).on('submit', '#data_form', function(event) {
        //     form(new FormData(this), '/customer/record_vouchers', '#data_form', '#form_modal', '#inner');
        // });
        $(document).on('submit', '#data_form', function(event) {
            event.preventDefault();

            var form = $(this);
            $.ajax({
                url: base_url + '/financial/record_vouchers',
                type: form.attr('method'),
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        // Use SweetAlert2 to display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        }).then(function() {
                            // Redirect or do other actions as needed
                            window.location.replace(base_url + '/financial/payment_voucher');
                        });
                    } else {
                        // Use SweetAlert2 to display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                        });
                    }
                }
            });
            return false;
        });



        // $(document).on('submit', '#data_form', function(event) {
        //             form(new FormData(this), '/record_voucher', '#data_form', '#user_modal', '#inner_add');
        //         });
        //-- Status --\\ 
        $(document).on('submit', '#status_form', function(event) {
            form(new FormData(this), 'admin/status_changer', '#status_form', '#status_modal', '#inner_status');
        });
        // ------------ Data Passing To Modals ------------ \\
        //-- Details --\\ 
        // $('#form_modal').on('show.bs.modal', function(e) {

        // });
        //-- Status --\\ status changer  
        $('#status_modal').on('show.bs.modal', function(e) {
            state_change('users',
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
                url: base_url + 'admin/change_status',
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
            $.ajax({
                url: base_url + controller_funtion,
                method: 'POST',
                data: data,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success === true) {
                        // manageTable.ajax.reload(null, false); 
                        var width = 1;
                        var id = {};
                        $("#outer").html(response.alert_outer);
                        $("#alert").fadeTo(20200, 500).slideUp(500, function() {
                            $("#alert").slideUp(500);
                        });

                        function progressBar() {
                            id = setInterval(frame, 200);

                            function frame() {
                                if (width >= 100) clearInterval(id);
                                else {
                                    width++;
                                    $("#progress_bar").css("width", width + "%");
                                }
                            }
                        }
                        progressBar();
                        // $(modal).modal('hide');
                        $(form)[0].reset();
                    } else {
                        var width = 1;
                        var id = {};
                        $(inner).html(response.alert_inner);
                        $("#alert").fadeTo(20200, 500).slideUp(500, function() {
                            $("#alert").slideUp(500);
                        });

                        function progressBar() {
                            id = setInterval(frame, 200);

                            function frame() {
                                if (width >= 100) clearInterval(id);
                                else {
                                    width++;
                                    $('#progress_bar').css('width', width + '%')
                                }
                            }
                        }
                        progressBar()
                    }
                }
            });
            return false;
        }
    });

    function img_trig() { // image trigger handler
        var id = $("#" + event.target.id).data('img_trig');
        document.querySelector('#' + id).click();
    }

    function img_dis(e) { // image display handler
        var id = $("#" + event.target.id).data('img_dis');
        if (e.files) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#' + id).setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }
</script>
<?= $this->endSection(); ?>