<!DOCTYPE html>

<html dir="" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/jpg" sizes="16x16" href="<?= base_url() ?>assets/images/core/favicon.png">
    <title><?php echo $title; ?></title>
    <link rel="canonical" href="https://daleelcom.net/" />
    <!-- Custom CSS -->

    <!-- <link href="<?php echo base_url(); ?>public/assets/css/apexcharts.css" rel="stylesheet"> -->


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/dist/css/style.min.css" > -->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/css/select2.min.css">
    <!-- This page plugin CSS -->


    <?php $dir = 'ltr';
    if ($locale == 'ar') {
        $dir = 'rtl'; ?>
        <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/css/bootstrap.rtl.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/css/font-arabic.css" rel="stylesheet"> -->
    <?php
    } ?>

    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->

    <style>
        /* CSS to add zoom-in effect */
        @keyframes zoomIn {
            from {
                transform: scale(0);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-dialog {
            animation-name: zoomIn;
            animation-duration: 0.5s;
            /* Control the speed of the zoom effect */
            animation-fill-mode: both;
            /* Start animation immediately and leave the modal at its final state when completed */
        }

        td.details-control {
            background: url('<?php echo base_url(); ?>dist/js/pages/datatable/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('<?php echo base_url(); ?>dist/js/pages/datatable/details_close.png') no-repeat center center;
        }

        .lang-top {
            /*            width: 55px;
            height: 55px;*/
            /*position: fixed;*/
            /*            bottom: 30px;
            right: 30px;*/
            font-size: 14px !important;
            border-radius: 50%;
            z-index: 99;
            /*display: none;*/
            color: #fff;
            text-align: center;
            cursor: pointer;
            background: #026665;
            ;
            -webkit-animation: pulse 2s infinite;
            -o-animation: pulse 2s infinite;
            animation: pulse 2s infinite;
            padding: 8px;
            margin-top: 12px;
            text-align: center;
        }

        .lang-top a {
            font-size: 14px !important;
        }

        .lang-top::after {
            position: absolute;
            z-index: -1;
            content: '';
            top: 100%;
            left: 5%;
            height: 10px;
            width: 90%;
            opacity: 1;
            background: -webkit-radial-gradient(center, ellipse, rgba(0, 0, 0, 0.25) 0%, rgba(0, 0, 0, 0) 80%);
            background: -webkit-radial-gradient(center ellipse, rgba(0, 0, 0, 0.25) 0%, rgba(0, 0, 0, 0) 80%);
            background: radial-gradient(ellipse at center, rgba(190, 236, 27, 0.25) 0%, rgba(0, 0, 0, 0) 80%);
        }
    </style>
    <style type="text/css">
        #add_form fieldset:not(:first-of-type) {
            display: none;
        }
    </style>
    <script src="<?php echo base_url() ?>public/assets/js/jquery.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</head>



<body>
    <?php if ($locale == 'ar') { ?>
        <style type="text/css">
            :root {
                --bs-body-font-family: 'Droid Arabic Naskh', "Rubik", sans-serif;
                --bs-body-font-size: 1rem;
                --bs-body-font-style: normal;
                direction: rtl;

            }

            #main-wrapper[data-layout="vertical"][data-sidebartype="full"] .page-wrapper {
                margin-left: 0px;
                margin-right: 240px;
            }

            #main-wrapper[data-layout="vertical"][data-sidebar-position="fixed"][data-sidebartype="full"] .topbar .top-navbar .navbar-collapse {
                margin-left: 0px;
                margin-right: 240px;
            }

            .sidebar-nav .has-arrow::after {
                /* margin-right: 10px;
                
                                margin-left: 15px;*/
                right: 210px;
            }

            .logo-text {
                margin-right: 50px;
                margin-left: 0px;
            }

            .logo-text img {
                position: relative;
                top: 5px;
                right: -75px;
            }

            .logo-icon .dark-logo {
                right: -75px;
                position: inherit;
            }

            .app-search .srh-btn {
                /* position: absolute;
                                top: -19px; */
                right: 170px;

            }

            .sidebar-nav ul .sidebar-item .first-level .sidebar-item .sidebar-link {
                padding: 12px 47px 12px 15px;
            }

            .dropdown-menu-end[data-bs-popper] {
                left: 0;
                right: auto;
            }

            .dropdown-item {
                text-align: right;
            }
        </style>
    <?php } ?>
    <style>
        .scrollable-container,
        .scrollable-container_type {
            position: relative;
            overflow: hidden;
        }

        .button-container,
        .button-container_type {
            position: relative;
            width: 100%;
            margin-bottom: -15px;
            /* Adjust the margin to account for button height */
            padding-bottom: 15px;
            /* Adjust the padding to account for button height */
            overflow: hidden;
        }

        .button-wrapper,
        .button-wrapper_type {
            white-space: nowrap;
            display: inline-block;
        }

        .button,
        .button_type {
            display: inline-block;
            padding: 10px;
            margin-right: 5px;
        }

        .scroll-button,
        .scroll-button_type {
            position: absolute;
            top: 0;
            background-color: transparent;
            border: none;
            font-size: 24px;
            padding: 10px;
            cursor: pointer;
            outline: none;
            z-index: 1;
        }

        .left-button,
        .left-button_type {
            left: 0;
            z-index: 2;
        }

        .right-button,
        .right-button_type {
            right: 0;
        }



        .rounded-top-left {
            border-top-left-radius: 0.65rem;
        }

        .rounded-top-right {
            border-top-right-radius: 0.65rem;
        }

        .rounded-bottom-left {
            border-bottom-left-radius: 0.65rem;
        }

        .rounded-bottom-right {
            border-bottom-right-radius: 0.65rem;
        }

        .no-support {
            height: 65vh;
            width: 100%;
            color: white;
            overflow: auto;
        }

        .no-support1 {
            height: 45vh;
            width: 100%;
            color: white;
            overflow: auto;
        }
    </style>





    <div class="page-wrapper bg-white">
        <div class="page-breadcrumb p-1 pl-3">
            <div class="row">
                <div class="col-md-2 align-self-center text-center px-2 pt-2">
                    <span class="display-10 align-middle pt-2">Point Of Sale</span>
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>


                <div class="col-md-10 align-self-center ">
                    <div class="col-md-12 row mx-0 px-0 py-1 ">
                        <div class="col-md-1 align-middle px-1  ">
                            <button type="button" id="new_basket" class="btn btn-dark p-1 btn-block pt-2 mt-2" data-toggle="modal" data-target="#">
                                <h6 class="text-light p-0 m-0 py-2">
                                    <i class="fas fa-shopping-basket"></i>
                                    New Basket <sup class="text-light mx-1" id="basket_count">0</sup>
                                </h6>
                            </button>
                            </h2>
                        </div>
                        <div class="col-md-10 pb-0" style="height: 100px;">
                            <div class="scrollable-container align-middle">
                                <button class="scroll-button left-button bg-dark text-light p-3 rounded-top-left rounded-bottom-left">&#10094;</button>
                                <div class="button-container px-5">
                                    <div class="button-wrapper">
                                        <div class="col-md-12" id="basket_list"></div>
                                    </div>
                                </div>
                                <button class="scroll-button right-button bg-dark text-light  p-3 rounded-top-right rounded-bottom-right">&#10095;</button>
                            </div>
                            <!-- <hr> -->
                            <!-- <hr> -->
                            <!-- <div class="btn-group mx-2" role="group">
                                <button type="button" class="btn btn-danger ">X</button>
                                <div class="btn-group " role="group">
                                    <button id="basket_id_018" type="button" class="btn btn-light basket_det text-left">
                                        <small><span style="font-size: 0.6rem;">Apr 30, 2023 - Item(s): 4</span></small>
                                        <h4 class=" mb-0">1682859063 <sup class="text-dark mx-1"> # 02 </sup></h4>  
                                    </button>
                                </div>
                            </div> -->
                            <!-- <div class="btn-group mx-2 font-weight-medium" role="group">
                                <button type="button" class="btn btn-danger ">X</button>
                                <div class="btn-group " role="group">
                                    <button id="basket_id_018" type="button" class="btn btn-light basket_det text-left">
                                        <small class="" style="font-size: 0.6rem;">#01 | Apr 30, 2023 | Item(s): 4</small>
                                        <h4 class="font-weight-medium my-0">1682859063</h4>
                                    </button>
                                </div>
                            </div> -->
                            <!-- <div class="btn-group mx-2" role="group">
                                <button type="button" class="btn btn-danger ">X</button>
                                <div class="btn-group " role="group">
                                    <button id="basket_id_018" type="button" class="btn btn-light basket_det text-left">
                                        <small><span style="font-size: 0.6rem;">Apr 30, 2023 - Item(s): 15</span></small>
                                        <h4 class=" mb-0"><sup class="text-dark mx-1"> #02 </sup>1682853366 </h4>
                                    </button>
                                </div>
                            </div> -->

                        </div>
                        <div class="col-md-1 px-1">
                            <a href="<?= base_url($locale . '/pos/sales') ?>" class="link">
                                <h4 class=" align-middle mt-3 btn bg-light ">Sales</h4>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row p-0">
            <div class="container-fluid col-12 " style="color:#404040;">
                <div class="col-md-12">
                    <div class="scrollable-container_type py-2">
                        <button class="scroll-button_type left-button_type  bg-dark text-light  p-2 rounded-top-left rounded-bottom-left">&#10094;</button>
                        <div class="button-container_type px-5">
                            <div class="button-wrapper_type " id="product_types">
                            </div>
                        </div>
                        <button class="scroll-button_type right-button_type  bg-dark text-light  p-2 rounded-top-right rounded-bottom-right">&#10095;</button>
                    </div>
                </div>
            </div>

            <div class="container-fluid col-4 px-1" style="color:#404040;">
                <div class="col-md-12 mt-0">
                    <div class="card mt-0">
                        <div id="outer"></div>
                        <div id="inner_add"></div>
                        <form id="pay_form" enctype="multipart/form-data">
                            <input type="hidden" class="form-control" name="basket_id" id="basket_id">
                            <div class="row">

                                <div class="col-md-12 py-1 Scroll no-support1 basket_dt_main" id="basket_dt"></div>
                            </div>




                            <div class="col-md-12">
                                <div class="form-group text-dark">
                                    <label>Total</label>
                                    <input readonly type="text" class="form-control form-control-sm" name="total" id="bas_total">
                                </div>
                            </div>


                            <div class="card-body mt-0 p-2">
                                <div class="col-md-12 row">
                                    <div class="col-md-6">
                                        <button type="button" id="print_bill_button" data-toggle="modal" class="btn btn-lg btn-dark btn-block">
                                            <b>BILL</b>
                                        </button>
                                    </div>
                                    <div class="col-md-6" style="margin-top:5px">

                                        <button type="button" id="print_order_button" class="btn btn-lg btn-dark btn-block">
                                            <b>ORDER</b>
                                        </button>
                                    </div>
                                    <div class="col-md-4" style="display:none">
                                        <button type="button" id="print_pos" data-toggle="modal" data-target="#receipt_modal" class="btn btn-lg btn-dark print_pay_receipt btn-block">
                                            <b>Print</b>
                                        </button>

                                    </div>
                                </div>

                                <div class="col-md-12 row">

                                    <div class="col-md-12" style="margin-top:5px">
                                        <button type="button" id="clear_orders" class="btn btn-lg btn-warning btn-block">
                                            <b>Clear Orders</b>
                                        </button>
                                    </div>

                                </div>

                                <div class="col-md-12 row" style="margin-top:5px">

                                    <div class="col-md-6">
                                        <button type="button" id="edit_order_button" class="btn btn-lg btn-primary pay_receipt0 btn-block">
                                            <b>Edit</b>
                                        </button>
                                    </div>
                                    <div class="col-md-6">

                                        <button type="button" id="close_page" class="btn btn-lg btn-danger close_page btn-block">
                                            <b>Logout</b>
                                        </button>

                                    </div>
                                </div>
                            </div>
                    </div>

                    </form>

                </div>

            </div>

            <div class="container-fluid col-8 px-1" style="color:#404040;">
                <div id="outer"></div>
                <div class="col-md-12 mt-0">
                    <div class="card mt-0 p-0">
                        <div class="card-body p-0">
                            <div class="col-md-12 row container">

                                <div class="col-md-12 row  py-1 ">
                                    <div class="col-md-3 align-middle pt-2">
                                        <h3>Products</h3>

                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group mt-2 mt-md-0">


                                            <select name="subcategories" style="margin-left:20px;" id="subcat_select" class="form-control">
                                                <option value="" selected disabled>Filter By Sub Category</option>
                                                <option value="all">All</option>
                                                <?php foreach ($subcategories as $subcat) : ?>
                                                    <option value="<?= $subcat['product_cat_id'] ?>">
                                                        <?= $subcat['pro_cat_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!-- </form> -->
                                        </div>
                                    </div>

                                    <hr>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-12 m-0 p-0 row" id="product_list"></div>
                                    <!-- <div class="col-md-3 my-1"> 
                                        <div class="card border-end border-dark m-0">
                                            <div class="card-body p-2 ">
                                                <div class="d-flex no-block align-items-center">
                                                    <i class="fas fa-box mx-1"></i>
                                                    <div class="">
                                                        <h3>Product Name <br><small><i> $1.5</i></small></h3>
                                                    </div>
                                                    <div class="btn-group ">
                                                        <button type="button" class="btn border-light btn-secondary text-light font-weight-medium mx-1">
                                                            -
                                                        </button>
                                                        <button type="button" class="btn border-light btn-secondary text-light font-weight-medium mx-1">
                                                            +
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-1 ">
                                        <div class="btn-group ">
                                            <button type="button" class="btn border-light btn-secondary text-light font-weight-medium mx-1">
                                                -
                                            </button>
                                            <button type="button" class="btn border-light btn-secondary text-light font-weight-medium mx-1">
                                                +
                                            </button>

                                        </div>
                                    </div> -->

                                    <!-- <div class="col-md-2 my-1 pr-2 pl-0">
                                        <button type="button" class="btn border-dark p-1 btn-block">
                                            <div class="card-body p-2 text-left">
                                                <h4 class="mb-0">Product Name 1234</h4>
                                                <span>
                                                    <span class="font-weight-medium">$1.5 </span>&nbsp; | &nbsp;
                                                    <span class="font-weight-medium">0</span>
                                                </span>
                                            </div>
                                        </button>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"><?= 'Customer Form' ?></h4>
                    <button type="button" class="btn-close border-0 p-2" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="add_form" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-7">
                                <div class="form-group text-dark">
                                    <label><?= 'Customer Name' ?></label>
                                    <input type="text" class="form-control " placeholder="<?= '' ?>" name="cust_name" id="cust_name">
                                    <input type="hidden" class="form-control " name="form_tag" id="form_tag">
                                    <input type="hidden" class="form-control " name="customer_id" id="customer_id">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group text-dark">
                                    <label for="sex"><?= 'Sex' ?></label>
                                    <select class="form-control" name="sex" id="sex">
                                        <option selected disabled><?= 'Select Sex' ?></option>
                                        <option value="male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="form-group text-dark">
                                    <label><?= 'Tell' ?></label>
                                    <input type="number" class="form-control " placeholder="<?= '' ?>" name="cust_tell" id="cust_tell">
                                </div>
                            </div>


                            <div class="col-md-5">
                                <div class="form-group text-dark">
                                    <label><?= 'Credit_limit' ?></label>
                                    <input type="decimal" class="form-control " placeholder="<?= '' ?>" name="cust_credit_limit" id="cust_credit_limit">
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="form-group text-dark">
                                    <label><?= 'Address' ?></label>
                                    <input type="text" class="form-control " placeholder="<?= '' ?>" name="cust_address" id="cust_address">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group text-dark">
                                    <label><?= 'Balance' ?></label>
                                    <input type="decimal" class="form-control" placeholder="<?= '' ?>" name="balance" id="balance">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?= 'Remarks' ?></label>
                                    <textarea class="form-control " rows="2" name="cust_des" id="cust_des" placeholder="<?= '' ?>"></textarea>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary submit_bt"><b><?= 'Submit' ?></b></button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <div id="update_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard='false'>
        <div class="modal-dialog modal-dialog-centered">
            <form id="update_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3 class="text-center"><i class="fas fa-hash text-dark m-2 fa-2x"></i><br>Discard Basket</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="inner_update"></div>
                                <div class="form-group text-dark">
                                    <input type="number" min=1 max=1000 class="form-control" id="qtys" required>
                                    <input type="hidden" class="form-control" id="proid">
                                    <input type="hidden" class="form-control" id="basket_det_ids" name="basket_det_id">
                                </div>
                            </div>
                            <div class="col-md-12 px-3">

                                <button type="submit" class="btn btn-block btn-rounded btn-outline-dark ">
                                    <b>Update</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="update_price_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard='false'>
        <div class="modal-dialog modal-dialog-centered">
            <form id="updated_price_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3 class="text-center"><i class="fas fa-hash text-dark m-2 fa-2x"></i><br>Discard Change Price
                        </h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="inner_update"></div>
                                <div class="form-group text-dark">
                                    <input type="text" class="form-control" id="prc">
                                    <input type="hidden" class="form-control" id="basket_det_idss" name="basket_det_id">
                                </div>
                            </div>
                            <div class="col-md-12 px-3">

                                <button type="submit" class="btn btn-block btn-rounded btn-outline-dark ">
                                    <b>Update</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="discard_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard='false'>
        <div class="modal-dialog modal-dialog-centered">
            <form id="discard_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3 class="text-center"><i class="fas fa-trash-alt text-danger m-2 fa-2x"></i><br>Discard Basket
                        </h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="inner_discard"></div>
                                <div class="form-group text-dark">
                                    <input readonly type="text" class="form-control" id="basket_no">
                                    <input type="hidden" class="form-control" id="basket_id_dis" name="basket_id">
                                </div>
                            </div>
                            <div class="col-md-12 px-3">

                                <button type="submit" class="btn btn-block btn-rounded btn-outline-danger ">
                                    <b>Discard</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="receipt_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard='false'>
        <div class="modal-dialog vertical-center-scroll-modal">
            <form id="discard_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-body" id="printtss">
                        <h3 class="text-center" style="text-align: center; margin: 0px 0px;">
                            <img src="<?php echo base_url(); ?>assets/images/core/logo-horizontal.png" alt="homepage" class="dark-logo" style="display: block; margin-left: auto;margin-right: auto; filter: brightness(0%);" height="60" />
                            <br>Receipt
                        </h3>
                        <div class="row">
                            <div class="col-md-12" id="print_data_set">


                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="brint" class="btn btn-block btn-rounded btn-primary ">
                            <b>Print</b></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="payment_list_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel"> Orders List </h4>
                    <button type="button" class="btn-close border-0 p-3" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="inner_add0"></div>
                    <form id="add_form0" enctype="multipart/form-data">
                        <div class="row" id="">

                            <div class="col-md-12" id="">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <h2>ORDERS LETTER</h2>
                                    </div>


                                    <div class="col-md-12" id="basket_order_list">

                                    </div>

                                    <hr>


                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-rounded btn-outline-danger" data-dismiss="modal" aria-label="Close"><b>Close</b></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="order_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard='false'>
        <div class="modal-dialog vertical-center-scroll-modal">
            <form id="ord_form">
                <div class="modal-content">
                    <div class="modal-body" id="print_this_order">
                        <span><?= 'Waiter name' ?></span>
                        Time : <?= date('Y-m-d H:i:s') ?>
                        <!--<p class="text-center" style="text-align: center; margin: 0px 0px;">-->
                        <!--    <img src="<?php echo base_url(); ?>assets/images/core/logo-horizontal.png" alt="homepage" class="dark-logo" style="display: block; margin-left: auto;margin-right: auto; filter: brightness(0%);" height="60" />-->
                        <!--    <br>-->
                        <!--    <span>*789*705608*LACAG# / E-DAHAB:625555901.</span> <br>-->
                        <!--    <br><span id="order_label"></span><br>-->
                        <!--</p>-->
                        <div class="row">
                            <div class="col-md-12" id="print_order_set">

                            </div>

                        </div>

                        <hr />
                        <div class="row" style="text-align: center; margin: 0px 0px;">
                            <p> Powered by Raed Technology | www.raed.so. </p>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" id="order_printer" class="btn btn-block btn-rounded btn-primary ">
                            <b>Print</b></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="order_bill_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard='false'>
        <div class="modal-dialog vertical-center-scroll-modal">
            <form id="bll_form">
                <div class="modal-content">
                    <div class="modal-body" id="print_this_order_bill">
                        <p class="text-center" style="text-align: center; margin: 0px 0px;">
                            <img src="<?= base_url() ?>assets/images/core/logo.png" alt="Logo" class="dark-logo" style="display: block; margin-left: auto;margin-right: auto; filter: brightness(0%);" height="60" />
                            <!--<img src="<?php echo base_url(); ?>assets/images/core/logo-horizontal.png" alt="homepage" class="dark-logo" style="display: block; margin-left: auto;margin-right: auto; filter: brightness(0%);" height="60" />-->
                            <br>
                            <span>*789*705608*LACAG# / *113*093411*LACAG#.</span> <br>
                            <span> Served by : <?= 'WAiter name' ?></span>
                            <span> Time : <?= date('Y-m-d H:i:s') ?></span>
                            <br><span id="order_bill_1"></span><br>
                        </p>
                        <div class="row">
                            <div class="col-md-12" id="print_order_bill_set">

                            </div>

                        </div>

                        <hr />
                        <div class="row" style="text-align: center; margin: 0px 0px;">
                            <p> Powered by Raed Technology | www.raed.so. </p>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" id="order_printer_bill" class="btn btn-block btn-rounded btn-primary ">
                            <b>Print</b></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="<?php echo base_url() ?>public/assets/print/printThis.js"></script>

    <script type="text/javascript">
        let basket_number = '';

        var base_url = "<?php echo base_url($locale); ?>";
        var lang = "<?php echo $locale; ?>";

        $(document).ready(function() {
            $('#barcode').val('');
            $('#barcode').focus();

            // $(document).on('change', '#toggleSelect', function() {
            //     var selectBox = $('#customer_id');
            //     var button = $('#btn_add');
            //     if ($(this).is(':checked')) {
            //         selectBox.hide();
            //         button.show();
            //     } else {
            //         selectBox.show();
            //         button.hide();
            //     }
            // });

            $('#subcat_select').change(function() {
                // Your code to handle the change event goes here
                var selectedValue = $(this).val();
                product_by_subcat(selectedValue)
            });
            // alert('');
            $('#barcode').attr('autofocus', 'true');
            // $('#barcode:text:visible:first').focus();
            var manageTable;
            //-- Add --\\ 
            $(document).on('submit', '#add_form', function(event) {
                form(new FormData(this), 'customers/customer_form', '#add_form', '#form_modal', '#inner_add');
            });

            get_basket_list();
            get_product_types();
            btn_product_types('all');
            last_basket();

            $(document).on('submit', '#pay_form', function(event) {
                // alert('submit');

                form(new FormData(this), '/pos/sales_form', '#pay_form', '#form_modal', '#inner_add');
                get_basket_list();
                // get_product_types();
                // btn_product_types('all');
                // last_basket();
            });
            // clear_barcode a button that clears barcode input field
            $('#clear_barcode').on('click', function() {
                $('#barcode').val('');
                $('#barcode').focus();
            });
            // $(document).on('keyup', '.price_input', function() {
            //     var sub_total = parseFloat($('#sub_total').val());
            //     var total = parseFloat($('#bas_total').val());
            //     var newPrice = parseFloat($(this).val());
            //     var qty = parseFloat($(this).closest('tr').find('button[data-qtys]').data('qtys'));
            //     var newTotal = newPrice * qty;


            //     $('#sub_total').val(parseFloat(newTotal));
            //     $('#bas_total').val(parseFloat(newTotal));
            //     $(this).closest('td').next('td').next('td').text('$' + newTotal.toFixed(2));

            // });

            $(document).on('keyup', '.price_input', function() {
                var newPrice = $(this).val() || 0;
                var qty = $(this).closest('tr').find('button[data-qtys]').data('qtys');
                var newTotal = newPrice * qty;


                $(this).closest('td').next('td').next('td').text('$' + newTotal.toFixed(2));
                // Now calculate the total and subtotal for all items
                var overallSubTotal = 0;
                var overallTotal = 0;
                $('.price_input').each(function() {
                    var price = $(this).val() || 0;
                    var quantity = $(this).closest('tr').find('button[data-qtys]').data('qtys');
                    overallSubTotal += price * quantity;
                    // alert(overallSubTotal)
                });


                overallTotal = overallSubTotal;


                $('#sub_total').val(overallSubTotal.toFixed(0));
                $('#bas_total').val(overallTotal.toFixed(0));
            });

            // Call recalculateTotals when the page loads to ensure totals are correct
            // $(document).ready(function() {
            //     recalculateTotals();
            // });


            // document.body.addEventListener("keydown", function(e) {
            //     alert($('#barcode').val());// your handler here
            // }, true)
            $('#brint').on("click", function() {
                // alert('print');
                $('#printtss').printThis({
                    importCSS: false,
                    printContainer: true,
                    importStyle: true,
                    // header: "",
                    base: base_url
                });
            });
            //-- Add --\\ 
            $(document).on('click', '#new_basket', function(event) {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/new_basket',
                    dataType: 'json',
                    data: {},
                    success: function(response) {
                        if (response.success === true) {
                            get_basket_list();
                            last_basket();
                            $('.basket_det').css('border-right', '0');
                            $('#' + response.basket_id).css('border-right', ' 5px solid #00b33c ');
                        }

                    }
                });

            });
            $(document).on('submit', '#discard_form', function(event) {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/discard_basket',
                    dataType: 'json',
                    data: {
                        basket_id: $('#basket_id_dis').val(),
                    },
                    success: function(response) {
                        if (response.success === true) {
                            get_basket_list();
                            $('#discard_modal').modal('hide');
                            last_basket();
                        }

                    }
                });

            });
            $(document).on('submit', '#update_form', function(event) {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/change_qty',
                    dataType: 'json',
                    data: {
                        proid: $('#proid').val(),
                        basket_det_id: $('#basket_det_ids').val(),
                        qty: $('#qtys').val(),
                    },
                    success: function(response) {
                        if (response.success === true) {
                            // get_basket_list();
                            $('#qty_' + response.pro_id).html(response.qty)
                            $('#qty_' + response.pro_id).data('qtys', response.qty)
                            var total = $('#price_' + response.pro_id).val() * response.qty;
                            var all_totals = 0;
                            $('#td_total_' + response.pro_id).html('$<span class="totals">' + total + '</span>');
                            $('.totals').each(function() {
                                all_totals += parseFloat($(this).text());
                            });
                            $("#bas_total").val(all_totals)
                            var disc = $('#discount').val();
                            if (!disc) {
                                disc = 0;
                            }
                            $('#sub_total').val(all_totals - disc);
                            $('#in_qty_' + response.pro_id).val(response.qty)
                            $('#in_total_' + response.pro_id).val(total)
                            $('#update_item_modal').modal('hide');
                            // last_basket();

                        } else alert('In-Stock Amount is not enough.');

                    }
                });

            });


            $(document).on('keyup', '.qty-input', function() {
                alert()
                // var newPrice = parseFloat($(this).val());
                // var qty = parseFloat($('#qty-input').val()); // Assuming you have the quantity in an input with id="qty-input"
                // var newTotal = newPrice * qty;

                // Now display the new total somewhere on the page
                // For example, if you have a span with id="new-total" where you want to show the total
                // $('#new-total').text('$' + newTotal.toFixed(2));
            });
            $('#barcode').on({
                keypress: function() {
                    typed_into = true;
                },
                change: function() {
                    if (typed_into) {
                        // alert($(this).val());
                        // typed_into = false; //reset type listener

                        if ($('#basket_id').val() == '') {
                            alert('Please select a basket');
                            return;
                        }
                        var barcode = $(this).val()
                        $('#barcode').val('');
                        $('#barcode').focus();
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url($locale) ?>/pos/products_by_barcode',
                            dataType: 'json',
                            data: {
                                bar_code_no: barcode,
                            },
                            success: function(response) {
                                // $('#product_list').html(response.product_id);
                                if (response.found === true) {
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?= base_url($locale) ?>/pos/add_item',
                                        dataType: 'json',
                                        data: {
                                            product_id: response.pro_id,
                                            product_name: response.pro_name,
                                            product_price: response.pro_price,
                                            basket_id: $('#basket_id').val(),
                                        },
                                        success: function(response) {
                                            if (response.already === true) {
                                                // alert(response.qty)
                                                $('#qty_' + response.pro_id).html(response.qty)
                                                var total = $('#price_' + response.pro_id).val() * response.qty;
                                                var all_totals = 0;
                                                $('#td_total_' + response.pro_id).html('$<span class="totals">' + total + '</span>');
                                                $('.totals').each(function() {
                                                    all_totals += parseFloat($(this).text());
                                                });
                                                $("#bas_total").val(all_totals)
                                                var disc = $('#discount').val();
                                                if (!disc) {
                                                    disc = 0;
                                                }
                                                $('#sub_total').val(all_totals - disc);
                                                $('#in_qty_' + response.pro_id).val(response.qty)
                                                $('#in_total_' + response.pro_id).val(total)
                                            } else {
                                                var data = `<tr class="py-1 px-2" width = "45%" > <td  class="py-1 px-2" > ${response.pro_name}
                                                                    <input type = "hidden" class="form-control" name = "product_id[]" value = "${response.pro_id}" >
                                                                    <input type="hidden" class="form-control" name="pro_price[]" value="${response.pro_price}" >
                                                                    <input type="hidden" id="in_qty_${response.pro_id}" class="form-control " name = "qty[]" value = "${response.qty}" >
                                                                    <input type="hidden" class="form-control" id="in_total_${response.pro_id}" name = "pro_total[]" value = "${response.qty * response.pro_price}" > 
                                                    </td>
                                                    <td width="20%" class="py-1 px-2">
                                                    <input type="text" id="price_${response.pro_id}" class="form-control price_input" 
                                                    data-basket_det_id="${response.basket_id}_det" 
                                                    value="${response.pro_price}" />
                                                    </td>
                                            
                                                    <td width="20%" class="py-1 px-2"> 
                                                        <button type="button" id="qty_${response.pro_id}" class="form-control border border-0 " 
                                                            data-product_id = "${response.pro_id}" 
                                                            data-basket_det_ids="${response.basket_id}_det" data-qtys="${response.qty}" 
                                                            data-toggle="modal" data-target="#update_item_modal" >${response.qty}
                                                        </button>
                                                    </td >
                                                                <td width="15%" class="py-1 px-2" id="td_total_${response.pro_id}" > $<span class="totals" > ${response.pro_price * response.qty}</span></td>
                                                                    <td width="5%" class="py-1 px-2">
                                                                        <button data-proid="${response.pro_id}" type="button" id="${response.basket_id}_det" class="btn btn-danger discard_item btn-block p-1">
                                                                        <b>x</b>
                                                                    </button>
                                                    </td>
                                                </tr>
                                                `;
                                                $('#print_area').append(data);
                                                // alert('success')
                                                // get_basket_det($('#current_basket').val());
                                            }

                                            return;
                                        }
                                    });
                                    // get_basket_det($('#current_basket').val());
                                    // $('#barcode').val('');
                                    // $('#barcode').focus();
                                } else {
                                    alert('product Not found');
                                }

                            }
                        });
                    } else {
                        alert('not type');
                    }
                }
            });
            //-- Status --\\ 
            $(document).on('click', '.item', function(event) {

                // alert($(this).attr("data-product_count"))

                if ($('#basket_id').val() == '') {
                    alert('Please select a basket');
                    return;
                }

                console.log(this.id)
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/add_item',
                    dataType: 'json',
                    data: {
                        product_id: this.id,
                        product_name: $(this).data('pro_name'),
                        product_price: $(this).data('price'),
                        basket_id: $('#basket_id').val(),
                    },
                    success: function(response) {
                        if (response.success === true) {
                            // alert($('#current_basket').val());
                            // get_basket_list();
                            if (response.already === true) {
                                // alert(response.qty)
                                $('#qty_' + response.pro_id).html(response.qty)
                                var total = $('#price_' + response.pro_id).val() * response.qty;
                                var all_totals = 0;
                                $('#td_total_' + response.pro_id).html('$<span class="totals">' + total + '</span>');
                                $('.totals').each(function() {
                                    all_totals += parseFloat($(this).text());
                                });
                                $("#bas_total").val(all_totals)
                                var disc = $('#discount').val();
                                if (!disc) {
                                    disc = 0;
                                }
                                $('#sub_total').val(all_totals - disc);
                                $('#in_qty_' + response.pro_id).val(response.qty)
                                $('#in_total_' + response.pro_id).val(total)
                            } else {
                                var data = `<tr class="py-1 px-2" width = "45%" > <td  class="py-1 px-2" > ${response.pro_name}
                                                        <input type = "hidden" class="form-control" name = "product_id[]" value = "${response.pro_id}" >
                                                        <input type="hidden" class="form-control" name="pro_price[]" value="${response.pro_price}" >
                                                        <input type="hidden" id="in_qty_${response.pro_id }" class="form-control " name = "qty[]" value = "${response.qty}" >
                                                        <input type="hidden" class="form-control" id="in_total_${response.pro_id }" name = "pro_total[]" value = "${response.qty * response.pro_price}" > 
                                        </td>
                                        <td width="20%" class="py-1 px-2">
                                        <input type="text" id="price_${response.pro_id }" class="form-control price_input" 
                                        data-basket_det_id="${response.basket_id}_det" 
                                        value="${response.pro_price}" />
                                        </td>
                                
                                        <td width="20%" class="py-1 px-2"> 
                                            <button type="button" id="qty_${response.pro_id }" class="form-control border border-0 " 
                                                data-product_id = "${response.pro_id}" 
                                                data-basket_det_ids="${response.basket_id}_det" data-qtys="${response.qty}" 
                                                data-toggle="modal" data-target="#update_item_modal" >${response.qty}
                                            </button>
                                        </td >
                                                    <td width="15%" class="py-1 px-2" id="td_total_${response.pro_id }" > $<span class="totals" > ${response.pro_price * response.qty}</span></td>
                                                        <td width="5%" class="py-1 px-2">
                                                            <button data-proid="${response.pro_id}" type="button" id="${response.basket_id}_det" class="btn btn-danger discard_item btn-block p-1">
                                                            <b>x</b>
                                                        </button>
                                        </td>
                                    </tr>
                                    `;
                                $('#print_area').append(data);
                                var total = $('#price_' + response.pro_id).val() * response.qty;
                                var all_totals = 0;
                                $('#td_total_' + response.pro_id).html('$<span class="totals">' + total + '</span>');
                                $('.totals').each(function() {
                                    all_totals += parseFloat($(this).text());
                                });
                                $("#bas_total").val(all_totals)
                                var disc = $('#discount').val();
                                if (!disc) {
                                    disc = 0;
                                }
                                $('#sub_total').val(all_totals - disc);
                                $('#in_qty_' + response.pro_id).val(response.qty)
                                $('#in_total_' + response.pro_id).val(total)
                                // alert('success')
                                // get_basket_det($('#current_basket').val());
                            }
                            // $('.basket_det').css('border-right', '0');
                            // $('#basket_id').css('border-right', ' 5px solid #00b33c ');
                        } else alert('In-Stock Amount is not enough.');
                    }
                });
            });
            $('body').on('keyup', '.pro_qty', function(event) {
                console.log(this.id)
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/change_qty',
                    dataType: 'json',
                    data: {
                        product_id: this.id,
                        basket_det_id: $(this).attr("data-bd"),
                        qty: this.value,
                        basket_id: $('#basket_id').val(),
                    },
                    success: function(response) {
                        if (response.success === true) {
                            get_basket_list();
                            get_basket_det($('#current_basket').val());
                            // $('#'+this.id).focus();
                        }
                    }
                });
            });
            $(document).on('click', '.basket_det', function(e) {
                console.log(e.currentTarget.id),
                    $('.basket_det').css('border-right', '0');
                $('#' + e.currentTarget.id).css('border-right', ' 5px solid #00b33c ');
                get_basket_det(e.currentTarget.id); //get basket details

                basket_number = e.currentTarget.id;
            });
            $(document).on('click', '.discard_item', function(e) {
                // console.log(e.currentTarget.id)
                // get_basket_det(e.currentTarget.id);
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/discard_item',
                    dataType: 'json',
                    data: {
                        basket_det_id: e.currentTarget.id,
                        proid: $(e.currentTarget).data('proid')
                    },
                    success: function(response) {
                        get_basket_det($('#current_basket').val());
                    }
                });
            });
            // $(document).on('keyup', '#discount', function(e) {
            //     // alert($('#sub_total').val());$('#sub_total').val();$('#sub_total').val();
            //     var sub_total = parseFloat($('#sub_total').val());
            //     var discount = parseFloat($('#discount').val());
            //     var total = parseFloat($('#total').val());
            //     var paid = parseFloat($('#paid').val());
            //     var sub_total = total - discount;
            //     console.log(total);
            //     if (discount > total) {
            //         alert('Discount cannot be greater than total');
            //         $('#discount').val(0);
            //         $('#sub_total').val(total);
            //         $('#paid').val(total);
            //     } else {
            //         $('#sub_total').val(sub_total);
            //         $('#paid').val(sub_total);
            //     }
            // });
            $(document).on('keyup', '#discount', function(e) {
                // alert($('#total').val());
                var sub_total = parseFloat($('#sub_total').val());
                var discount = parseFloat($('#discount').val());
                var total = parseFloat($('#bas_total').val());
                var sub_total = total - discount;
                // alert(sub_total+' '+total+' '+discount);
                $('#sub_total').val(parseFloat(sub_total));
            });
            // $('#barcode').bind('input', function() {
            //     alert($(this).val()) // get the current value of the input field.
            // }); 
            // ------------ Data Passing To Modals ------------ \\
            //-- Details --\\ 
            $('#form_modal').on('show.bs.modal', function(e) {
                console.log(event.target.id)
                $('#name').attr('readonly', false)
                $('#des').attr('readonly', false)
                $('#btn_submit').attr('disabled', false)
                if (event.target.id == 'btn_add') {

                    $('#form_tag').val(event.target.id);
                } else {
                    $('#category_id').val($(e.relatedTarget).data('category_id'));
                    $('#name').val($(e.relatedTarget).data('name'));
                    $('#des').val($(e.relatedTarget).data('des'));

                    if (event.target.id == 'btn_edit') {

                        $('#ut_id').val($(e.relatedTarget).data('ut_id'));
                        $('#form_tag').val(event.target.id);
                    } else if (event.target.id == 'btn_det') {

                        $('#old_img').val($(e.relatedTarget).data('old_img'));
                        $('#ut_id').val($(e.relatedTarget).data('ut_id'));
                        $('#form_tag').val(event.target.id);
                        $('#name').attr('readonly', true)
                        $('#des').attr('readonly', true)
                        $('#btn_submit').attr('disabled', true)
                    }
                }
            });
            //-- Status --\\ status changer  
            // $('#pos_screens').on('show.bs.modal', function(e) {
            //     $('#basket_id').val($(e.relatedTarget).data('basket_id'));

            // });
            $('#discard_modal').on('show.bs.modal', function(e) {
                $('#basket_id_dis').val($(e.relatedTarget).data('basket_id'));
                $('#basket_no').val($(e.relatedTarget).data('basket_no'));
            });

            $('#update_item_modal').on('show.bs.modal', function(e) {
                $('#basket_det_ids').val($(e.relatedTarget).data('basket_det_ids'));
                $('#proid').val($(e.relatedTarget).data('product_id'));
                $('#qtys').val($(e.relatedTarget).data('qtys'));
            });
            $('#update_price_modal').on('show.bs.modal', function(e) {
                $('#basket_det_idss').val($(e.relatedTarget).data('basket_det_idss'));
                $('#prc').val($(e.relatedTarget).data('prc'));
            });

            $('#receipt_modal').on('show.bs.modal', function(e) {
                $('#print_data_set').html("");
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/printable_basket',
                    dataType: 'json',
                    data: {
                        basket_id: $('#current_basket').val(),
                        sub_total: $('#sub_total').val(),
                        discount: $('#discount').val(),
                        paid: $('#paid').val(),
                    },
                    success: function(response) {
                        get_basket_det($('#current_basket').val());
                        $('#print_data_set').html(response.print_basket);
                    }
                });
                // }
                //});
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

            $('#print_order_button').on('click', function() {

                let order_id = $('#current_basket').val();
                let root_url = 'printable_basket';

                if (basket_number == '') {
                    alert('Fadlan dooro basket-ka')
                    return;
                }

                $('#order_label').text('Order Sheet:' + basket_number);
                print_order_bill(order_id, root_url)

            });

            function print_order_bill(order_id, root_url = 'printable_basket') {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/' + root_url,
                    dataType: 'json',
                    data: {
                        basket_id: order_id,
                    },
                    success: function(response) {
                        // get_basket_det($('#current_basket').val());
                        $('#order_modal').modal('show');
                        $('#print_order_set').html(response.print_basket);

                    }
                });

            }

            $('#print_bill_button').on('click', function() {

                let order_id = $('#current_basket').val();
                let root_url = 'printable_basket';

                if (basket_number == '') {
                    alert('Fadlan dooro basket-ka')
                    return;
                }

                $('#order_bill_1').text('Invoice Sheet: ' + basket_number);
                print_order_bill_1(order_id, root_url)

            });

            function print_order_bill_1(order_id, root_url = 'printable_basket') {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/' + root_url,
                    dataType: 'json',
                    data: {
                        basket_id: order_id,
                    },
                    success: function(response) {
                        $('#order_bill_modal').modal('show');
                        $('#print_order_bill_set').html(response.print_basket);

                    }
                });

            }

            $('#order_printer').on("click", function() {
                $('#order_modal').modal('hide');
                $('#print_this_order').printThis({
                    importCSS: false,
                    printContainer: true,
                    importStyle: true,
                    // header: "",
                    base: base_url
                });
            });

            $('#order_printer_bill').on("click", function() {
                $('#order_bill_modal').modal('hide');
                $('#print_this_order_bill').printThis({
                    importCSS: false,
                    printContainer: true,
                    importStyle: true,
                    // header: "",
                    base: base_url
                });
            });


            $('#clear_orders').on('click', function() {

                if ($('#current_basket').val() == undefined) {
                    return;
                }

                if (confirm('Are you sure you want to clear this order?')) {

                    $.ajax({
                        type: 'POST',
                        url: base_url + '/pos/clear_orders',
                        dataType: 'json',
                        data: {
                            basket_id: $('#current_basket').val(),

                        },
                        success: function(response) {
                            if (response.success === true) {

                                location.href = base_url + '/pos/point_of_sale';

                            }
                        }
                    });
                }

            });

            $(document).on('click', '#close_page', function(event) {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/logout',
                    dataType: 'json',
                    data: {},
                    success: function(response) {
                        if (response.success === true) {
                            location.href = base_url + '/pos/login';
                        }

                    }
                });

            });

            $('#edit_order_button').on('click', function() {

                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/get_basket_orders',
                    data: {
                        account_id: $('#account_id').val(),

                    },
                    success: function(response) {

                        $('#basket_order_list').html(response);

                    }
                });

                $('#payment_list_modal').modal();

            });

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
                        $('#btn_submit').attr('disabled', false);
                        $('#btn_submit').html('Complete');
                        if (response.success === true) {
                            // manageTable.ajax.reload(null, false);
                            if (controller_funtion == '/pos/sales_form') {
                                $('form :input').val('');
                                $(".basket_dt_main").html("")
                            }
                            get_basket_list();
                            // $('#basket_dt').html('')

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
                            // $(form)[0].reset();
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
                    },
                    error: function(res) {
                        $('#btn_submit').attr('disabled', false);
                        $('#btn_submit').html('Complete');
                    }
                });
                return false;
            }
            $(document).on('change', '#job_id', function(event) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>admin/get_job_fee',
                    dataType: 'json',
                    data: {
                        job_id: $('#job_id').val(),
                    },
                    success: function(response) {
                        $('#no_fee').val(response.no_fee);
                    }

                });
            });
            // $('.').click(function(event) { 
            // });
            $('body').on('click', '.draggable-button_type', function(event) {
                // alert($(this).val()); 
                // alert(event.target.id);
                btn_product_types(event.target.id);
                // $.ajax({
                //     type: 'POST',
                //     url: '<?= base_url() ?>pos/products_by_product_types',
                //     dataType: 'json',
                //     data: {
                //         product_type_id: event.target.id,
                //     },
                //     success: function(response) {
                //         $('#product_list').html(response.product_list);
                //     }
                // });
            });

            $('.left-button').click(function() {
                $('.button-container').animate({
                    scrollLeft: '-=200px'
                }, 'slow');
            });

            $('.right-button').click(function() {
                $('.button-container').animate({
                    scrollLeft: '+=200px'
                }, 'slow');
            });
            // $('.draggable-button').draggable({
            //     axis: 'x',
            //     containment: 'parent',
            //     start: function() {
            //         // Disable scrolling while dragging the buttons
            //         $('.button-container').css('overflow-x', 'hidden');
            //     },
            //     stop: function() {
            //         // Enable scrolling after dragging the buttons ends
            //         $('.button-container').css('overflow-x', 'auto');
            //     }
            // });


        });

        function get_basket_list() {
            $.ajax({
                type: 'POST',
                url: base_url + '/pos/list_baskets',
                dataType: 'json',
                data: {},
                success: function(response) {
                    $('#basket_list').html(response.basket_list);
                    $('#basket_count').html(response.basket_count);

                }
            });
        };

        function btn_product_types(product_type_id) {
            // alert($(this).val()); 
            // alert(product_type_id);
            $.ajax({
                type: 'POST',
                url: base_url + '/pos/products_by_product_types',
                dataType: 'json',
                data: {
                    product_type_id: product_type_id,
                },
                success: function(response) {
                    $('#product_list').html(response.product_list);
                }
            });
        };

        function product_by_subcat(subcat_id) {
            // alert($(this).val()); 
            // alert(product_type_id);
            $.ajax({
                type: 'POST',
                url: base_url + '/pos/products_by_subcategory',
                dataType: 'json',
                data: {
                    subcat_id: subcat_id,
                },
                success: function(response) {
                    $('#product_list').html(response.product_list);
                }
            });
        };

        function get_product_types() {
            $.ajax({
                type: 'POST',
                url: base_url + '/pos/product_types',
                dataType: 'json',
                data: {},
                success: function(response) {
                    $('#product_types').html(response.product_types);
                }
            });
        };

        function last_basket() {
            return 0;
            $.ajax({
                type: 'POST',
                url: base_url + '/pos/last_basket',
                dataType: 'json',
                data: {},
                success: function(response) {
                    get_basket_det(response.last_basket);
                    $('.basket_det').css('border-right', '0');
                    $('#' + response.last_basket).css('border-right', ' 5px solid #00b33c ');
                }
            });
        };

        function get_basket_det(basket_id) {

            if (basket_id != '0') {
                $.ajax({
                    type: 'POST',
                    url: base_url + '/pos/basket_det',
                    dataType: 'json',
                    data: {
                        basket_id: basket_id,
                    },
                    success: function(response) {
                        // $('#basket_dt').html('');
                        $('#barcode').val('');
                        $('#barcode').focus();

                        $('#basket_dt').html(response.basket_dt);
                        // alert(response.bas_total);
                        $('#bas_total').val(response.bas_total);
                        $('#sub_total').val(response.bas_sub_total);
                        $('#basket_id').val(response.basket_id);
                        $('#cogs').val(response.cogs.toFixed(2));
                        // $('.basket_det').css('border-right', '0');
                        // $('#' + basket_id).css('border-right', ' 5px solid #00b33c ');
                    }
                });
            } else {

                $('#basket_dt').html('');
                $('#bas_total').val('');
                $('#sub_total').val('');
                $('#paid').val('');
                $('#basket_id').val('');
            }

        };
    </script>
    <script type="text/javascript">
        $('.left-button_type').click(function() {
            $('.button-container_type').animate({
                scrollLeft: '-=200px'
            }, 'slow');
        });

        $('.right-button_type').click(function() {
            $('.button-container_type').animate({
                scrollLeft: '+=200px'
            }, 'slow');
        });
        // $('.draggable-button_type').draggable({
        //     axis: 'x',
        //     containment: 'parent',
        //     start: function() {
        //         // Disable scrolling while dragging the buttons
        //         $('.button-container_type').css('overflow-x', 'hidden');
        //     },
        //     stop: function() {
        //         // Enable scrolling after dragging the buttons ends
        //         $('.button-container_type').css('overflow-x', 'auto');
        //     }
        // });
    </script>