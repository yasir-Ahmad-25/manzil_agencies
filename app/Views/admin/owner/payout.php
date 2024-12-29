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
                            <li class="breadcrumb-item active" aria-current="page"><?= 'owners settlement' ?></li>
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
                        <!-- <h4 class="card-title">  </h4> -->
                        <button class="btn btn-primary" id="btn_pay" data-bs-toggle="modal" data-bs-target="#owner_paid_model">
                        <?= 'Add Payout' ?>
                        </button>
                        <div id="messages"></div>

                        <table id="manageTable_owner_settlement" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr> 
                                    <th>#</th>                                                                                                                                     
                                    <th><?= 'Fullname' ?></th> 
                                    <th><?= 'Account'?></th> 
                                    <th><?= 'Amount'?></th>
                                    <th><?= 'Paid From'?></th>
                                    <th><?= 'Paid At'?></th>
                                </tr>
                            </thead>

                            <tbody>
                                
                            </tbody>

                        </table>

                        <!-- print button -->
                        <button class="btn btn-primary" id="print_owner_settlement" data-toggle="modal" data-target="#">Print</button>
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

    <!-- paid modal content -->
       <!-- PAID modal -->
    <div id="owner_paid_model" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"></h4>
                    <button type="button" class="btn-close border-0 p-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            
                <div class="modal-body">
                <div id="inner_add"></div>
                    <form method="post" id="data_paid_form">

                        <div class="modal-body">
                            <input type="hidden" name="btn_action" id="btn_action">
                            <!-- <input type="hidden" name="owner_id" id="owner_id"> -->
                            
                            <div class="form-group mt-3">
                                <label for="#">Choose Owner</label>
                                <select class="form-control" id="selectedOwner" name="selectedOwner" autocomplete="off">
                                    <option value="" selected disabled>Select an Owner</option> <!-- Default option -->
                                    <?= $site_owners ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="#">Total Amount</label>
                                        <input type="text" class="form-control" name="total_amount" id="total_amount" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="#">Account Number</label>
                                        <input type="text" class="form-control" name="Account_Number" id="Account_Number" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-dark">
                                <label for="acc_tag"><?= 'Account' ?></label>
                                <select class="form-control border-secondary" id="acc_tag_rec" name="acc_tag_rec">
                                    <option selected disabled value="">-- Select Account --</option>
                                    <?php foreach ($accounts as $val): ?>
                                        <option value="<?= $val['account_id'] ?>"><?= $val['acc_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="#">Paying Amount</label>
                                <input type="text" class="form-control" name="Paying_Amount" id="Paying_Amount" placeholder="Enter The Amount Here .... ">
                            </div>

                            <div class="form-group mt-3">
                                <label for="#">Remark</label>
                                <input type="text" class="form-control" name="Remark" id="Remark" placeholder="">
                            </div>

                            <div class="form-group mt-3">
                                <label for="#">Refrence</label>
                                <input type="text" class="form-control" name="Refrence" id="Refrence" placeholder="">
                            </div>
                              
                                            
                        </div>

                        <div class="bg-danger p-2 rounded text-center text-white" id="deleteMessage"></div>
                        <div class="modal-footer">
                            <button type="submit" id="btn_submit" class="btn btn-rounded btn-outline-primary"><b><?= 'Pay' ?></b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
</div>

    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>
    <script type="text/javascript">

        var base_url = "<?php echo base_url($locale); ?>"; 
        var manageTable;
        var lang = "<?php echo $locale; ?>";

        $(document).ready(function () {
            // This is hidden by default but when user clicks de-activate this message pops out
            $('#tablesMainNav').addClass('active');
            // initialize the datatable 
            manageTable_owner_settlement = $('#manageTable_owner_settlement').DataTable({
                'ajax': base_url + '/owner/fetch_settlements',
                'order': []
            });
            
            $('#deleteMessage').hide();


            $('#selectedOwner').on('change',function(){
                    $('#total_amount').html('<option value="">loading....</option> ');
                    $('#Account_Number').html('<option value="">loading....</option> ');
                    var owner_id = $(this).val();
                    $.ajax({
                        url: base_url + '/owner/get_owner_Account_And_Balance',
                        type: "POST",
                        dataType: "json",  // Add this line to tell jQuery to expect JSON and automatically parse it
                        data: {
                            owner_id:owner_id
                        },
                        success: function(response) {
                                $('#total_amount').val(response.amount);
                                $('#Account_Number').val(response.accountNumber);
                            },
                            error:function(){
                                alert('error Occured');
                                $('#total_amount').html('0');
                                $('#Account_Number').html('0');
                            }
                        });
            })


            // If Add Button clicks it 
            $('#owner_paid_model').on('show.bs.modal', function(e) {
            //    alert(event.target.id)
                $('#btn_action').val(event.target.id);
                
                $('#btn_submit').attr('disabled', false)
                $('#fullname').attr('readonly', false)
                $('#Account_Number').attr('readonly', false)

                if (event.target.id == 'btn_pay') {

                    console.log(" pay button triggered" );

                    // $('#fullname').attr('readonly', true)
                    // $('#Account_Number').attr('readonly', true)
                    
                    // $('#owner_id').val($(e.relatedTarget).data('owner_id'));
                    // $('#fullname').val($(e.relatedTarget).data('owner_fullname'));
                    // $('#Account_Number').val($(e.relatedTarget).data('owner_account_number'));


                    $('#btn_submit').show();
                    $('#btn_submit').html('P A Y');
                    
                        
                }
                
            });


            $(document).on('submit', '#data_paid_form', function(event) {
                form(new FormData(this), '/owner/owner_settlement', '#data_paid_form', '#owner_paid_model', '#inner_add');
            });


        });

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
                            manageTable_owner_settlement.ajax.reload(null, false);
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

        $('#print_owner_settlement').click(function () {

                $('#manageTable_owner_settlement').printThis({
                        debug: false, // show the iframe for debugging
                        importCSS: true, // import parent page css
                        importStyle: true, // import style tags
                        printContainer: true, // path to additional css file - use an array [] for multiple
                        pageTitle: "OWNER SETTLEMENT", // add title to print page
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
                });

            });


    </script>


<?= $this->endSection(); ?>