<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical" data-boxed-layout="boxed" data-card="shadow"><head>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Favicon icon-->
  <link rel="icon" type="image/jpg" sizes="16x16" href="<?= base_url() ?>public/assets/images/core/favicon.png">

  <!-- Core Css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/css/style.min.css" rel="stylesheet">

  <title>Page Not Found</title>
</head>

<body data-sidebartype="mini-sidebar">
  <!-- Preloader -->
  <div class="preloader" style="display: none;">
    <img src="<?= base_url() ?>public/assets/images/core/favicon.png" alt="loader" class="lds-ripple img-fluid">
  </div>
  <div id="main-wrapper" class="auth-customizer-none">
    <div class="position-relative overflow-hidden min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-lg-4">
            <div class="text-center">
              <img src="<?=base_url()?>public/assets/images/core/errorimg.svg" alt="" class="img-fluid" width="500">
              <h1 class="fw-semibold mb-7 fs-9">Opps!!!</h1>
              <h4 class="fw-semibold mb-7">This page you are looking for could not be found.</h4>
              <a class="btn btn-primary" href="<?=base_url($locale)?>/admin" role="button">Go Back to Home</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->
  <script src="<?php echo base_url() ?>public/assets/js/bootstrap.bundle.min.js"></script>
    <!-- apps -->
    <script src="<?php echo base_url() ?>public/assets/js/app.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/js/app.init.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>


</body></html>