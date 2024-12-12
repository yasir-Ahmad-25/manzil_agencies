<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
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
                            <li class="breadcrumb-item active" aria-current="page">Rent Booking</li>
                            <!--<span> <p> <?= $error ?></p></span>-->
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

                        <button class="btn btn-primary" id="btn_add" data-toggle="modal" data-target="#rent_modal">
                            <?= lang('btn')['add']; ?>
                        </button> <br> <br>

                        <div class="row">


                            <div class="col-md-3 align-self-right">


                            </div>
                        </div>
                        <!-- <h4 class="card-title">  </h4> -->

                        <br />
                        <div id="messages"></div>

                        <table id="manageTable" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>hall Name</th>
                                    <th>Customer Name</th>
                                    <th>booking Date</th>
                                    <th>Start Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>0Price</th>
                                    <th>Discount</th>
                                    <th><?= lang('common')['status'] ?></th>
                                    <th><?= lang('common')['action'] ?></th>
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
    <div id="rent_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Rent Booking</h4>
                    <button type="button" class="btn-close border-0 p-3" data-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="data_form" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group text-dark">
                                            <input type="hidden" name="btn_action" id="btn_action">
                                            <input type="hidden" name="rent_id" id="rent_id">
                                            <label>Hall Name</label>
                                            <select class="form-control border-secondary" id="hall_id" name="hall_id">
                                                <option value="" disabled selected>Select hall</option>
                                                <?php foreach ($hall as $val) { ?>
                                                    <option value="<?php echo $val['hall_id']; ?>" data-hallp="<?= $val['hall_price'] ?>"><?php echo $val['hall_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group text-dark">
                                            <label>Customers</label>
                                            <select class="form-control border-secondary" id="customer_id" name="customer_id">
                                                <option value="" disabled selected>Select Customer</option>
                                                <?php foreach ($cus as $val) { ?>
                                                    <option value="<?php echo $val['ten_id']; ?>"><?php echo $val['ten_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group text-dark">
                                            <label>Booking Date</label>
                                            <input type="date" class="form-control border-secondary" name="booking_date" id="booking_date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group text-dark">
                                            <label>Start Date</label>
                                            <input type="date" class="form-control border-secondary" name="start_date" id="start_date">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group text-dark">
                                            <label>Start Time</label>
                                            <input type="time" class="form-control border-secondary" name="start_time" id="start_time">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group text-dark">
                                            <label>End Time</label>
                                            <input type="time" class="form-control border-secondary" name="end_time" id="end_time">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group text-dark">
                                    <label>Hours</label>
                                    <input type="number" readonly class="form-control border-secondary" name="hours" id="hours">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group text-dark">
                                    <label>Price($)</label>
                                    <input type="number" readonly class="form-control border-secondary" name="booking_price" id="booking_price">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group text-dark">
                                    <label>Discount</label>
                                    <input type="number" class="form-control border-secondary" name="discount" id="discount">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btn_submit" class="btn btn-rounded btn-outline-primary"><b><?= lang('btn')['save'] ?></b></button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    
          <div id="print_inv" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Print Receipt </h4>
                    <button type="button" class="btn-close border-0 p-3" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="add_form" enctype="multipart/form-data">
                        <div class="row" id="print_area">
                            <div class="col-md-12 pb-3">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <img src="<?=base_url()?>assets/images/core/logo.png" alt="Logo" width="300">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                            <div class="col-md-12" id="invoice_data">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <h2>BOOKING AGREEMENT LETTER</h2>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-6 py-2 row">
                                        <div class="col-md-12"> From: </div>
                                        <div class="col-md-12"> Yamalasham Restaurant</div>
                                        <div class="col-md-12"> Address: Benadir Mogadishu, Somalia</div>
                                    </div>
                                  
                                    <div class="col-md-12">
                                        <table class="table ">
                                            <th>Customer Name </th>
                                            <th>Hall </th>
                                            <th>Booking Price </th>
                                            <th>Booking Date</th>
                                            <th>Start Date </th>

                                            <tr>
                                                <td id="ten_name"></td>
                                                <td id="hall"></td>
                                                <td id="price"></td>
                                                <td id="booking"></td>
                                                <td id="started"></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-6 py-2 ">
                                        <div class="col-md-12"> Recipient:</div>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <!-- <a id="advanced" href="#nada" class="button button-primary">Print kittens</a> -->
                            <button type="button" id="advanced" class="btn btn-rounded btn-info"><b>Print</b></button>
                            <button type="button" class="btn btn-rounded btn-outline-danger" data-dismiss="modal" aria-label="Close"><b>Close</b></button>
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
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<script src="<?php echo base_url() ?>js/printThis.js"></script>
<script type="text/javascript">
    var manageTable_site;
    var base_url = "<?php echo base_url(); ?>";
    var hall_price = 0;

    function timeInHours(str) {
        const sp = str.split(":");
        return parseInt(sp[0]) + parseInt(sp[1]) / 60;
    }

    function hoursToString(h) {
        var hours = Math.floor(h);
        var minutes = (h - hours) * 60;

       // return hours + ":" + minutes;
       return hours;
    }

    $(document).ready(function() {
        $('#tablesMainNav').addClass('active');
        // initialize the datatable 

        rent_booking();

        function rent_booking() {

            manageTable = $('#manageTable').DataTable({
                'ajax': base_url + 'rent_booking/fetch_list',
                'order': [],
                destroy: true,
                searching: false
            });

        }

        $('#hall_id').on('change', function() {

            hall_price = $('option:selected', this).data("hallp");

        });

        $("#end_time").on('change', function() {
            const end = $('#end_time').val();
            const start = $('#start_time').val();
            // const diff = start - end;
            // const total = pack_price * capacity;
            // $('#total').val(total);

            let diff = hoursToString(timeInHours(end) - timeInHours(start));

            const total = hall_price * diff;
            $('#booking_price').val(total);
            $('#hours').val(diff);
            console.log(diff, hall_price, total)

        });

        // ------------ Data Passing To Modals ------------ \\
        //-- Details --\\ 
        $('#rent_modal').on('show.bs.modal', function(e) {
            console.log(event.target.id)

            $('#btn_submit').attr('disabled', false)
            if (event.target.id == 'btn_add') {


                $('#btn_action').val(event.target.id);
                $('#btn_submit').show();
                $('#btn_submit').html('Save');
            } else {
                $('#rent_id').val($(e.relatedTarget).data('rent_id'));
                $('#hall_id').val($(e.relatedTarget).data('hall_id'));
                $('#customer_id').val($(e.relatedTarget).data('customer_id'));
                $('#booking_date').val($(e.relatedTarget).data('booking_date'));
                $('#start_date').val($(e.relatedTarget).data('start_date'));
                $('#start_time').val($(e.relatedTarget).data('start_time'));
                $('#end_time').val($(e.relatedTarget).data('end_time'));
                $('#booking_price').val($(e.relatedTarget).data('booking_price'));
                $('#discount').val($(e.relatedTarget).data('discount'));
                $('#hours').val($(e.relatedTarget).data('hours'));

                if (event.target.id == 'btn_edit') {
                    $('#btn_action').val(event.target.id);
                    $('#btn_submit').show();
                    $('#btn_submit').html('Save Changes');

                }
            }
        });
        

         $('#print_inv').on('show.bs.modal', function(e) {

                     $('#ten_name').text($(e.relatedTarget).data('ten_name'));
                     $('#hall').text($(e.relatedTarget).data('hall'));
                     $('#price').text($(e.relatedTarget).data('booking_price'));
                     $('#booking').text($(e.relatedTarget).data('booking_date'));
                     $('#started').text($(e.relatedTarget).data('start_date'));

            });



        $(document).on('submit', '#data_form', function(event) {
            form(new FormData(this), 'rent_booking/crud_list', '#data_form', '#rent_modal', '#inner_add');
        });

    });

    $(document).on('submit', '#status_form', function(event) { // posting data from status form
        form(new FormData(this), 'home/status_changer', '#status_form', '#status_modal', '#inner_status');
    });
    $('#status_modal').on('show.bs.modal', function(e) { // passing data to status modal
        state_change('Rent',
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
                    manageTable.ajax.reload(null, false);


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
                    $(modal).modal('hide');
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

            $('#advanced').click(function() {
                    $('#print_area').printThis({
                        debug: false, // show the iframe for debugging
                        importCSS: true, // import parent page css
                        importStyle: true, // import style tags
                        printContainer: true, // print outer container/$.selector
                        loadCSS: "<?php echo base_url() ?>assets/css/style.min.css", // path to additional css file - use an array [] for multiple
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