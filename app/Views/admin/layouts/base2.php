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
    <link href="<?php echo base_url(); ?>assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>dist/css/style.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/libs/select2/dist/css/select2.min.css">
    <!-- This page plugin CSS -->
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>

    <?php //if ($this->session->userdata('site_lang') == 'arabic') {
        //$rtl = 'rtl';
    ?>
        <!-- RTL CSS -->
       
        <!-- <link rel="stylesheet" href="<?php //echo base_url() ?>css/font-arabic.css"> -->
    <?php //} else {
        //$rtl = '';
    //} ?>

    <style>
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
    <script src="<?php echo base_url() ?>dist/js/jquery.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/jquery/dist/jquery.min.js"></script>
</head>



<body>
    
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" style="background: #00bcda;">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="<?php echo base_url() ?>">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="<?php echo base_url(); ?>img/logoSM.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="<?php echo base_url(); ?>img/logoSM.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                  
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item search-box d-none d-md-block">
                            <form class="app-search mt-3 mr-2">
                                <input type="text" class="form-control rounded-pill border-0" placeholder="Search for...">
                                <a class="srh-btn"><i class="ti-search"></i></a>
                            </form>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <?php
                        if ($this->session->userdata('merchant')) :
                            $staff = $this->session->userdata("merchant");
                            //$simg = $this->session->userdata("logo");
                            $simg = $this->session->userdata("logo");

                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo $simg; ?>" alt="user" class="rounded-circle" width="42"></a>
                                <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                    <div class="d-flex no-block align-items-center p-3 mb-2 border-bottom">
                                        <div class=""><img src="<?php echo $simg; ?>" alt="user" class="rounded" width="80"></div>
                                        <div class="ml-2">
                                            <h4 class="mb-0"><?php echo $staff['fullname']; ?></h4>
                                            <p class=" mb-0"><?php echo $staff['email']; ?></p>
                                            <!--<a href="#" class="btn btn-rounded btn-danger btn-sm">View Profile</a>-->
                                        </div>
                                    </div>
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user mr-1 ml-1"></i> <?php echo lang('profile') ?></a>
                                    <!--<a class="dropdown-item" href="javascript:void(0)"><i class="ti-wallet mr-1 ml-1"></i> My Balance</a>-->
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email mr-1 ml-1"></i> <?php echo lang('inbox') ?></a>
                                    <div class="dropdown-divider"></div>
                                    <!--<a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings mr-1 ml-1"></i> Account Setting</a>-->
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url() ?>login/signout"><i class="fa fa-power-off mr-1 ml-1"></i> <?php echo lang('logout') ?></a>
                                </div>
                            </li>
                        <?php
                        else :

                        endif;
                        ?>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                        <?php
                        $lan = '';
                        if ($this->session->userdata('site_lang') == 'arabic') {
                            $lan = '<i class="flag-icon flag-icon-ye"></i> العربية';
                        } else {
                            $lan = '<i class="flag-icon flag-icon-gb"></i> English';
                            //$en = 'selected';
                        }
                        ?>
                        <li class="nav-item dropdown">
                            <!--                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $lan ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right  animated bounceInDown" aria-labelledby="navbarDropdown2">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>langswitch/switchLanguage/english"><i class="flag-icon flag-icon-gb"></i> English</a>
                                <a class="dropdown-item" href="<?php echo base_url(); ?>langswitch/switchLanguage/arabic"><i class="flag-icon flag-icon-ye"></i> العربية</a>
                            </div>-->

                            <div class="lang-top">
                                <?php if ($this->session->userdata('site_lang') == 'english') {
                                ?>
                                    <a style="color: #fff;padding: 10px;font-size: 18px;" href="<?php echo base_url(); ?>langswitch/switchLanguage/arabic">ع</a>
                                    <?php //} else if ($this->session->userdata('site_lang') == 'somali') {
                                    ?>
                                    <!--<a href="#">SOM</a>-->
                                <?php } else {
                                ?>
                                    <a style="color: #fff;" href="<?php echo base_url(); ?>langswitch/switchLanguage/english">ENG</a>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <section>
            <?= $this->renderSection('content');?>
        </section>

        <footer class="footer">
            &copy <?= date('Y', time()) . ' RAED Innovation & Technology. ';// . lang('setup')['footer']; ?>
        </footer>
    </div>

    <script src="<?php echo base_url() ?>assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="<?php echo base_url() ?>dist/js/app.min.js"></script>
    <script src="<?php echo base_url() ?>dist/js/app.init.js"></script>
    <script src="<?php echo base_url() ?>dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url() ?>assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url() ?>dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url() ?>dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo base_url() ?>dist/js/feather.min.js"></script>
    <script src="<?php echo base_url() ?>dist/js/custom.min.js"></script>


    <!-- ############################################################### -->
    <!-- This Page Js Files Here -->
    <!-- ############################################################### -->
    <script src="<?php echo base_url() ?>assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/echarts/dist/echarts.min.js"></script>
    <!--c3 charts -->
    <script src="<?php echo base_url() ?>assets/libs/d3/dist/d3.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/c3/c3.min.js"></script>
    <script src="<?php echo base_url() ?>dist/js/pages/dashboards/dashboard1.js"></script>
    <!--This page plugins -->
    <script src="<?php echo base_url() ?>assets/libs/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>dist/js/pages/datatable/custom-datatable.js"></script>
    <script src="<?php echo base_url() ?>dist/js/pages/datatable/datatable-api.init.js"></script>

    <script src="<?php echo base_url() ?>assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo base_url() ?>dist/js/pages/forms/select2/select2.init.js"></script>



</body>

</html>