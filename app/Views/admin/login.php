<!DOCTYPE html>
<html dir="" lang="<?= $locale?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/jpg" sizes="16x16" href="<?= base_url() ?>public/assets/images/core/favicon.png">
    <title><?= isset($title) ? $title : 'Welcome Home...'; ?></title>
    <link rel="canonical" href="https://daleelcom.net/" />


    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/css/style.min.css" rel="stylesheet">
    <?php $dir='ltr'; if($locale == 'ar'): $dir='rtl';?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/css/bootstrap.rtl.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/css/font-arabic.css" rel="stylesheet">
    <?php endif;?>
    </head>

<body dir="<?= $dir?>">
    <div class="main-wrapper mt-0">
       
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(<?php echo base_url() ?>public/assets/images/core/login_bg.jpg) no-repeat left bottom; background-size: cover;">
            <div class="auth-box p-2 bg-white rounded">
                <!-- login set -->
                <div id="loginfrm">
                    <div class="logo text-center">
                        <img src="<?php echo base_url() ?>public/assets/images/core/logo-vertical.png" lt="logo-vertical" height="130">
                        <h2 class="box-title mb-3"><b><?= lang('Site.login.title'); ?></b></h2>
                    </div>
                    
                     <div class="text-center">
                        <span class="text-danger text-strong" id="err" style="display:none;"></span> 
                     </div>
                    
                    <!-- Form -->
                    <div class="row px-4">
                        <div class="col-12">
                            <form class="form-horizontal mt-3 form-material" id="login_form" method="post" action="<?= base_url($locale.'/admin/login')?>">
                            <?php if(session()->has('expired')):?>
                                
                                <h3 style="color:red;"><?= session('expired')?></h3>    
                                
                            <?php endif;?>
                            <div class="form-group mb-3">
                                    <input class="form-control" type="text" required placeholder="<?= lang('Site.login.username'); ?>" name="username">
                                </div>
                                <div class="form-group mb-3">
                                    <input id="pwd" class="form-control" type="password" required placeholder="<?= lang('Site.login.password');?>" name="password">
                                </div>
                                <!-- <div class="form-group mb-3">

                                    <a href="javascript:void(0)" id="addrole" data-toggle="modal" data-target="#reset_modal" class="text-dark float-right mb-3"><i class="fa fa-lock mr-1"></i><?//= lang('btn')['forgot']; ?></a>
                                </div> -->
                                <div class="form-group text-center">
                                    <button id="login" type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"><?= lang('Site.login.btn'); ?></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- reset modal -->
                <div id="reset_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title" id="myModalLabel"><?= lang('Site.message'); ?></h4>
                                <button type="button" class="btn-close border-0 p-2" data-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                                <!-- <h6 class="mb-3 text-center text-secondary"><?//= lang('login')['reset_note'] ?></h6> -->
                                <h6 class="mb-3 text-center text-secondary"><?= lang('Site.message'); ?></h6>
                                <form id="reset" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <!-- <input class="form-control text-dark border-dark" type="email" placeholder="<?//= lang('login')['email'] ?>" name="email" required> -->
                                                <input class="form-control text-dark border-dark" type="email" placeholder="<?= lang('Site.message'); ?>" name="email" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <!-- <button type="submit" class="btn btn-block btn-outline-primary"><b><?//= lang('btn')['reset'] ?></b></button> -->
                                        <button type="submit" class="btn btn-block btn-outline-primary"><b><?= lang('Site.message');?></b></button>
                                    </div>

                                </form>

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>
 

    <script src="<?php echo base_url() ?>public/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var manageTable;
            var base_url = "<?php echo base_url($locale).'/admin'; ?>";
            // ------------ Form Modals ------------ \\ 
            //-- Log in --\\ 
            $(document).on('submit', '#login_form', function(event) {
                event.preventDefault();
                var form = $(this);
                
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    //method: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success === 1) {
                            $("#login_form")[0].reset();
                            window.location.replace(base_url);
                        } else {
                            $("#pwd").focus();
                            $("#err").html(response.message).fadeIn(500);
                            setTimeout(function() { $("#err").fadeOut(); }, 2000);
                            //  $("#alert").fadeTo(20200, 500).slideUp(500, function() {
                                //  $("#alert").slideUp(500);
                            // });
                            
                        }
                    }
                });
                return false;
            });
        });
    </script>






</body>
</html>