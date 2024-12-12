<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>

<div class="page-breadcrumb">
<div class="row">
            <div class="col-md-4 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url($locale) ?>/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?=$title?> </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
</div> </br>
<!-- Data Table  -->
<div class="container-fluid">
    <div class="row">
    <div class="card col-md-12">
            <div id="outer" class="col-md-12 my-1 "></div>
            
            <div id="msg" class="alert alert-success alert-dismissible" role="alert" style="display:none;"></div>
            <div id="err" class="alert alert-danger alert-dismissible" role="alert" style="display:none;"></div>
            
            <div class="card col-md-12">

                <div class="card-body">
                    <form id="form_main" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><?= lang('Site.common.date')?></label>
                                    <input type="date" class="form-control" id="trx_date" name="trx_date" value="<?= date('Y-m-d'); ?>">
                                    <input type="hidden" class="form-control" id="total_amount" name="trx_amount">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label><?= 'Source' ?></label>
                                    <textarea class="form-control" rows="1" name="trx_source" id="trx_source" placeholder="" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?= lang('Site.financial.doneby')?>:</label>
                                    <input type="text" disabled class="form-control" value="<?= session()->get('user')['user_name']; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <!-- dr and cr section start -->
                            <div class="col-md-12">
                                <div class="box-body">
                                    <div class="row">
                                        <!-- dr section -->
                                        <div class="col-md-6 prent  border-right">
                                            <div class="col-md-12 row">
                                                <div class="col-md-9">
                                                    <h4 class="box-title " id="hovert"><i class="fa fa-credit-card text-dark mx-1"></i> <b><?= 'Debit' ?> </b></h4>
                                                </div>
                                                <div class="col-md-3">
                                                    <a class="add_dr_section btn-link btn" data-ti=''><i class="fa fa-plus-circle text-info mx-1"></i><?= lang('Site.financial.account')?></a>
                                                </div>
                                            </div>

                                            <div class="row dbr dr_section" data-idd="1" data-vald="" style="margin-bottom: 10px;">

                                                <div class="col-md-7">
                                                    <select name="dr_account_id[]" id="method" class="form-control dr_account_id crd">
                                                        <option selected disabled>Select Account</option>
                                                        <?php foreach ($allacc as $dr_account) : 
                                                            $accname = $locale == 'ar' ? $dr_account['acc_name_ar'] : $dr_account['acc_name']; 
                                                            ?>
                                                            <option value="<?= $dr_account['account_id']; ?>"><?= $accname; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">$</div>
                                                        </div>
                                                        <input type="number" min="0.00" step="0.1" name="dr_amount[]" class="form-control dramount" id="" placeholder="0.00" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-1" style="margin-top: 3px;">
                                                    <a class="remove1 btn-link btn" data-ti=''><i class="fa fa-trash-alt text-danger mx-1"></i></a>
                                                </div>

                                                <div class="col-md-11 my-1">
                                                    <div class="form-group">
                                                        <textarea class="form-control drdesc" rows="1" name="trx_det_des_dr[]" id="acc_des" placeholder="<?= lang('Site.common.remarks')?>"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- cr section -->
                                        <div class="col-md-6 prent">

                                            <div class="col-md-12 row">
                                                <div class="col-md-9">
                                                    <h4 class="box-title"><i class="fa fa-credit-card fa-flip-horizontal text-dark mx-1"></i> <b><?= 'Credit' ?></b></h4>
                                                </div>
                                                <div class="col-md-3">
                                                    <a class="add_cr_section btn-link btn" data-ti=''><i class="fa fa-plus-circle text-info mx-1"></i><?= lang('Site.financial.account')?></a>
                                                </div>
                                            </div>
                                            <div class="row crr cr_section" data-idc="2" data-valc="" style="margin-bottom: 10px;">
                                                <div class="col-md-7">
                                                    <select name="cr_account_id[]" id="method" class="form-control crd">
                                                        <option selected disabled>Select Account</option>
                                                        <?php foreach ($allacc as $cr_account) : 
                                                            $accname = $locale == 'ar' ? $cr_account['acc_name_ar'] : $cr_account['acc_name']; 
                                                            ?>
                                                            <option value="<?= $cr_account['account_id']; ?>"><?= $accname; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">$</div>
                                                        </div>
                                                        <input type="number" min="0.00" step="0.1" name="cr_amount[]" class="form-control cramount" id="" placeholder="0.00" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-1" style="margin-top: 3px;">
                                                    <a class="remove2 btn-link btn" data-ti=''><i class="fa fa-trash-alt text-danger mx-1"></i></a>
                                                </div>

                                                <div class="col-md-11 my-1">
                                                    <div class="form-group">
                                                        <textarea class="form-control crdesc" rows="1" name="trx_det_des_cr[]" id="acc_des" placeholder="<?= lang('Site.common.remarks')?>"></textarea>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 20px;">
                                        <div class="col-md-6 " style="text-align: right; font-size: 17px;">
                                            <span><?= 'Total Debit' ?>: </span>
                                            $<span class="ttldebit" id="tdr" style="font-weight: bold;font-size: 17px;">0.00</span>
                                        </div>
                                        <div class="col-md-6" style="text-align: left; font-size: 17px;">
                                            <span><?= 'Total Credit' ?>: </span>
                                            $<span class="ttlcredit" id="tcr" style="font-weight: bold;font-size: 17px;">0.00</span>
                                        </div>
                                        <span id="selacc" style="display: none;"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="post_record" class="btn btn-rounded btn-outline-primary"><b><?= lang('Site.button.save') ?></b></button>
                    </form>

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
    
        // ------------ Form Modals ------------ \\ 
        //-- Add --\\ 
        $(document).on('submit', '#form_main', function(event) {
            event.preventDefault();
            var ttld = parseFloat($('.ttldebit').html());
            var ttlc = parseFloat($('.ttlcredit').html());
            if (ttld !== ttlc) {
                $("#err").html('Total Debit Must be Equal to Total Credit').fadeIn(500);
                setTimeout(function() { $("#err").fadeOut(); }, 2000);;
                return false;
            } else if (ttld == 0 || ttlc == 0) {
                $("#err").html('Total Debit Must be Equal to Total Credit').fadeIn(500);
                setTimeout(function() { $("#err").fadeOut(); }, 2000);;
                return false;
            } else {
                // $('#totalamt').val(ttld);
                $('#totalamt').val($('.ttlcredit').html());
                $('#total_amount').val(parseFloat($('#tcr').html()));
                // alert(parseFloat($('#tdr').html())+parseFloat($('#tcr').html()));
                // $("#openingfrm").submit();
            }
            var form = $(this);
            $.ajax({
                url: base_url + '/financial/post-journal',
                type: form.attr('method'),
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success === true) {
                        // manageTable.ajax.reload(null, false);
                        window.location.replace(base_url + '/financial/journal');

                    } else {
                        $("#err").html(response.msg).fadeIn(500);
                        setTimeout(function() { $("#msg").fadeOut(); }, 2000);
                    }
                }
            });
            return false;
        });
        $('.add_dr_section').on('click', function() {
            aut++;
            var row = $(this).closest("div.prent").children('.dr_section').html();
            $(this).closest("div.prent").append('<div class="row dbr dr_section" data-idd="' + aut + '" data-valc="" style="margin-bottom: 10px">' + row + '</div>');
        });
        $('.add_cr_section').on('click', function() {
            aut++;
            var row = $(this).closest("div.prent").children('.cr_section').html();
            $(this).closest("div.prent").append('<div class="row crr cr_section"  data-idc="' + aut + '" data-valc="" style="margin-bottom: 10px">' + row + '</div>');

        });
        // $(document).on('mouseover', '#hovert', function() { // mouse over for hover
        //     alert('mouseover');
        // });
        $(document).on('focusin', '.dramount', function() {
            console.log("Saving value " + $(this).val());
            $(this).data('val', $(this).val() !== '' ? $(this).val() : '0');
            // // explaing the above line
            // if ($(this).val() !== '') { // if the value is not empty
            //     $(this).data('val', $(this).val()); // save the value in data-val
            // } else {
            //     $(this).data('val', '0'); // save 0 in data-val
            // }
        }).on("change paste keyup", '.dramount', function() {
            // if($(this).val() == ''){
            //     $(this).val('0');
            // }
            var prev = $(this).data('val');
            var current = $(this).val() !== '' ? $(this).val() : 0.00;
            var ttl = parseFloat($('.ttldebit').html()) - parseFloat(prev);
            console.log("total = " + ttl);
            //
            $('.ttldebit').html(parseFloat(ttl) + parseFloat(current));

            //Testing Abdulfatah's Requirement
            // $('#cramt').val( parseFloat(ttl) + parseFloat(current));
            //   $('.ttlcredit').html( parseFloat(ttl) + parseFloat(current));
            //Testing Abdulfatah's Requirement
            //
            //console.log("Prev value " + prev);
            //console.log("New value " + current);
            $(this).data('val', current);
            //alert($(this).val()); 
        });
        // short hand for $(document).on('focusin', '.dramount', function() 
        $(document).on('focusin', '.cramount', function() {
            //console.log("Saving value " + $(this).val());
            $(this).data('val', $(this).val() !== '' ? $(this).val() : '0');
        }).on("change paste keyup", '.cramount', function() {
            //            if($(this).val() == ''){
            //                $(this).val('0');
            //            }
            var prev = $(this).data('val');
            var current = $(this).val() !== '' ? $(this).val() : 0;
            var ttl = parseInt($('.ttlcredit').html()) - parseInt(prev);
            //console.log("current = " + current);
            //
            $('.ttlcredit').html(parseInt(ttl) + parseInt(current));
            //console.log("Prev value " + prev);
            //console.log("New value " + current);
            $(this).data('val', current);
            //alert($(this).val()); 
        });
        $('body').on('click', '.remove1', function() {
            const rowlen = $(".dbr").length;
            if (rowlen > 1) {
                const dramt = $(this).closest(".row").find('.dramount').val();
                const ttl = $('.ttldebit').html();
                const dr = dramt !== '' ? dramt : 0.00;
                $('.ttldebit').html(parseFloat(ttl) - parseFloat(dr));
                $(this).closest('.row').remove();
            }
        });
        $('body').on('click', '.remove2', function() {
            const rowlen = $(".crr").length;
            if (rowlen > 1) {
                const cramt = $(this).closest(".row").find('.cramount').val();
                const ttl = $('.ttlcredit').html();
                const cr = cramt !== '' ? cramt : 0.00;
                $('.ttlcredit').html(parseFloat(ttl) - parseFloat(cr));
                $(this).closest('.row').remove();
            }
        });

        $('body').on('change', '.drd', function() {

            var id = $(this).val();

            di = $(this).closest(".row").data('idd');
            dv = $(this).closest(".row").data('vald');

            sid = id + ',';
            var d = $('#selacc:contains(' + sid + ')');
            if (d.length > 0) {

                // alert("This account is already selected");
                alert_outer('This Account is Already Selected', 'danger');
                $(this).val('.....').attr('selected', true).siblings('option').removeAttr('selected');
                var bid = dv.substring(2);

                $(this).closest(".row").data('vald', '');

                $("#selacc").text($("#selacc").text().replace(bid, ''));
                // alert($(this).closest(".row").data('idd'))
            } else {
                var fc = $('#selacc').text();
                fc = fc + id + ',';
                $('#selacc').text(fc);

                if (dv != '') {

                    var bid = dv.substring(2);
                    alert(bid)
                    dv_r = di + '-' + id + ',';
                    $(this).closest(".row").data('vald', dv_r);

                    $("#selacc").text($("#selacc").text().replace(bid, id));
                    // alert($(this).closest(".row").data('idd'))

                } else {
                    dv = di + '-' + id + ',';

                    $(this).closest(".row").data('vald', dv);

                }
            }

        });

        $('body').on('change', '.crd', function() {
            var id = $(this).val();

            di = $(this).closest(".row").data('idc');
            dv = $(this).closest(".row").data('valc');

            sid = id + ',';
            var d = $('#selacc:contains(' + sid + ')');
            if (d.length > 0) {

                // alert("This account is already selected");
                alert_outer('This Account is Already Selected', 'danger');

                $(this).val('.....').attr('selected', true).siblings('option').removeAttr('selected');
                var bid = dv.substring(2);

                $(this).closest(".row").data('valc', '');

                $("#selacc").text($("#selacc").text().replace(bid, ''));
                // alert($(this).closest(".row").data('idd'))
            } else {
                var fc = $('#selacc').text();
                fc = fc + id + ',';
                $('#selacc').text(fc);

                if (dv != '') {

                    var bid = dv.substring(2);
                    // alert(bid)
                    dv_c = di + '-' + id + ',';
                    $(this).closest(".row").data('valc', dv_c);

                    $("#selacc").text($("#selacc").text().replace(bid, id));
                    // alert($(this).closest(".row").data('idd'))

                } else {
                    dv = di + '-' + id + ',';

                    $(this).closest(".row").data('valc', dv);

                }
            }

        });

    });
</script>

<?= $this->endSection(); ?>