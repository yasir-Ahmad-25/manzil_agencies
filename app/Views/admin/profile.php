<?php 
use App\Models\Back\UserModel;

$user = new UserModel();
?>

<?= $this->extend("admin/layouts/base");?>

<?= $this->section('content');?>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-8 align-self-center  p-2">
                <h2 class="page-title"> Profile of <?= session()->get('user')['fullname']; ?></h2>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <button class="btn btn-primary " id="addrole" data-bs-toggle="modal" data-bs-target="#change_pass">Change Password</button> <br>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card col-md-12">
            <div id="outer"></div>
            <div class="card-body">

                <?php
                $profile = $user->get_user_profile();
                ?>

                <form id="update_profile" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-3  mx-auto">
                            <div class="form-group text-center">
                                <img src="<?= base_url('public/assets/images/users/').session()->get('user')['user_img']; ?>" class="img img-thumbnail" onclick="img_trig()" id="pdis" data-img_trig="pt_img">
                                <!-- <small><i>Image</i></small> -->

                                <input type="file" onchange="img_dis(this)" data-img_dis="pdis" name="pt_img" id="pt_img" style="display: none;"><br><input type="hidden" class="form-control border-secondary" name="old_img" value="<?= session()->get('user')['user_img']; ?>"><small><i><?= 'Image' ?></i></small>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label>Name</label>
                                        <input type="text" class="form-control border-secondary" name="user_nm" value="<?= $profile['cl_name'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label>Tell</label>
                                        <input type="text" class="form-control border-secondary" name="user_tl" value="<?= $profile['cl_tell'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label>Email</label>
                                        <input type="text" class="form-control border-secondary" name="user_em" value="<?= $profile['cl_email'] ?>">
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group text-dark">
                                        <label>Status</label>
                                        <h3><?= session()->get('user')['user_status']; ?></h3>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-rounded btn-block btn-outline-primary"><b>Save Changes</b></button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- Change Password modal -->
    <div id="change_pass" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop='static' data-bs-keyboard='false'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">Change Password</h4>
                    <button type="button" class="btn-close border-0 p-1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="inner_add"></div>
                    <form id="change_pass_modal" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-dark">
                                    <label>Old Password</label>
                                    <input type="text" class="form-control border-secondary" name="old_pass">

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-dark">
                                    <label>New Password</label>
                                    <input type="text" class="form-control border-secondary" name="new_pass">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-dark">
                                    <label>Confirm New Password</label>
                                    <input type="text" class="form-control border-secondary" name="confirm_new_pass">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-rounded btn-block btn-outline-dark"><b>Change Password</b></button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>

var base_url = "<?php echo base_url($locale); ?>";
    var lang = "<?php echo $locale; ?>";

    $(document).ready(function() {
        // ------------ Form Modals ------------ \\ 
        //-- Add --\\ 
        $(document).on('submit', '#change_pass_modal', function(event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                url: base_url + '/user/change_password',
                type: form.attr('method'),
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success === true) {
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
                        $("#change_pass").modal('hide');
                        $("#change_pass_modal")[0].reset();
                    } else {
                        var width = 1;
                        var id = {};
                        $("#inner_add").html(response.alert_inner);
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
            });
            return false;
        });

        // profile update
        $(document).on('submit', '#update_profile', function(event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                url: base_url + '/user/update_profile',
                type: form.attr('method'),
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success === true) {
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
                        $("#update_profile")[0].reset();
                    } else {
                        var width = 1;
                        var id = {};
                        $("#inner_add").html(response.alert_inner);
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
            });
            return false;
        });
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

<?= $this->endSection('content'); ?>