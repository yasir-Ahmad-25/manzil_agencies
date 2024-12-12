<?= $this->extend("admin/layouts/base"); ?>

<?= $this->section('content'); ?>
<style>
    .page-wrapper {
        background-color: white;
    }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center  p-2">
            <h2 class="page-title"><?= 'Rental Income' ?></h2>
        </div>
        <!-- <div class="col-md-12 align-self-center">
            <button class="btn btn-primary " id="btn_add" data-bs-toggle="modal" data-bs-target="#branch_modal"> +
                <?//= lang('Site.button.add') ?></button> <br>
        </div> -->
    </div>
</div>
<!-- Data Table  -->

<div class="container-fluid">

    <div id="rental">
        <!-- <h3 class="p-2">Rental Income</h3> -->
        <hr>
        <div>


            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0 row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select name="year" id="year" class="form-control select2" style="width:100%important">
                                    <option value='' selected>Select Year</option>
                                    <?php for ($i = -3; $i <= 6; $i++) { ?>
                                        <option value="<?php echo date('Y') + $i; ?>"><?php echo date('Y') + $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select name="month" id="month" class="form-control select2"
                                    style="width:100%important">
                                    <option value='' selected>Select Month</option>
                                    <?php
                                    $date2 = new \DateTime();
                                    $month = $date2->format('m');
                                    for ($i = 1; $i <= 12; $i++) {
                                        //create date object
                                        $dateObj = DateTime::createFromFormat('!m', $i);
                                        //get month name
                                        $monthName = $dateObj->format('F');
                                        //print month name
                                        $selected = ($i == $month) ? "selected" : '';
                                        echo "<option value='$i' " . $selected . ">$monthName</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>

                    </h5>
                </div>

            </div>

            <div id="my_invoice" style="margin:20px; text-align:center">
                <img src="<?= base_url() ?>public/assets/images/core/loogo.png" alt="" style="width:140px">
                <h3>Rental Income for the month <?= date('M') ?></h3>
                <div id="my_invoice2">

                </div>
            </div>

            <button class="btn btn-primary" id="btn_rental_income" data-toggle="modal" data-target="#">Print</button>

        </div>

    </div>



</div>
<script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>

<script type="text/javascript">
    var manageTable;
    var base_url = " <?php echo base_url($locale); ?>";

    $(document).ready(function () {
        $('#btn_rental_income').click(function () {

            // $('#print_area').prepend('<h2 class="text-center"> Muqdisho Mall & Apartments</h2><h3 class="text-center"> Income Statements</h3>');
            $('#my_invoice').printThis({
                debug: false, // show the iframe for debugging
                importCSS: true, // import parent page css
                importStyle: true, // import style tags
                printContainer: true, // path to additional css file - use an array [] for multiple
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
        $.ajax({
            type: 'POST',
            url: base_url + '/report/fetch_rep_rental',
            // async: false,
            // dataType: 'json',
            success: function (data) {
                $('#my_invoice2').html(data);
            },
            error: function () {
                alert('Could not get Data from Database');
            }
        });
        // ------------ Data table ------------ \\
        var lang = "<?php echo $locale; ?>";
        align = 'dt-left';
        if (lang == 'ar') {
            align = 'dt-right';
        }
        // ------------ Data table ------------ \\
        manageTable = $('#manageTable').DataTable({
            // columnDefs: [
            //     { className: align, targets: [0, 1, 2, 3, 4] },
            // ],
            'ajax': base_url + '/settings/get_branches',
            'order': []
        });

        // ------------ Form Modals ------------ \\ 
        $('#branch_modal').on('show.bs.modal', function (e) {

            console.log(event.target.id)

            $('#btn_action').val(event.target.id);

            $('#btn_submit').attr('disabled', false)
            if (event.target.id == 'btn_add') {

                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('Save');
            } else {
                // $('#myModalLabel').text("<?php echo lang('Site.button.edit') ?>");
                $('#br_id').val($(e.relatedTarget).data('br_id'));
                $('#br_name').val($(e.relatedTarget).data('br_name'));
                $('#br_address').val($(e.relatedTarget).data('br_address'));

                if (event.target.id == 'btn_edit') {

                    $('#btn_action').val(event.target.id);
                    $('#btn_submit').show();
                    $('#btn_submit').html('Save Changes');

                }
            }
        });

        $('#branch_modal').on('hidden.bs.modal', function (e) {
            $(this).find('form')[0].reset();

        });
        $(document).on('change', '#month', function (e) {
            var month = $(this).val();
            $('#my_invoice2').html('');
            $.ajax({
                type: 'POST',
                url: base_url + '/report/fetch_rep_rental',
                // async: false,
                // dataType: 'json',
                data: {
                    month:month
                },
                success: function (data) {
                    $('#my_invoice2').html(data);
                },
                error: function () {
                    alert('Could not get Data from Database');
                }
            });
        })

        $(document).on('submit', '#data_form', function (event) {
            form(new FormData(this), '/settings/record_branch', '#data_form', '#branch_modal', '#inner_add');
        });

    });

    $(document).on('submit', '#status_form', function (event) { // posting data from status form
        form(new FormData(this), 'home/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function (e) { // passing data to status modal
        state_change('User Type',
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
            url: base_url + 'home/change_status',
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
            success: function (response) {
                $("#change_state").html(response.status);
            }
        });
    }

    function form(data, controller_function, form, modal, inner) {
        event.preventDefault();

        $('#submit_bt').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Saving...');
        $('#submit_bt').attr('disabled', true);

        $.ajax({
            url: base_url + controller_function,
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success === true) {

                    $('#submit_bt').attr('disabled', false);
                    $('#submit_bt').html('Save');

                    $("#msg").html(response.msg).fadeIn(500);
                    setTimeout(function () { $("#msg").fadeOut(); }, 2000);
                    manageTable.ajax.reload(null, false);


                    $(modal).modal('hide');
                    $(form)[0].reset();
                } else {

                    $('#submit_bt').attr('disabled', false);
                    $('#submit_bt').html('Save');

                    var width = 1;
                    var id = {};
                    $(inner).html(response.alert_inner);
                    $("#alert").fadeTo(20200, 500).slideUp(500, function () {
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
</script>

<?= $this->endSection(); ?>