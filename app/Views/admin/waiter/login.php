<!DOCTYPE html>
<html>

<head>
    <title>REST PRO :: LOGIN</title>
    <link rel="icon" type="image/png" href="<?=base_url()?>public/assets/images/waiter.png" sizes="128x128" >
    <!-- Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="keywords" content="Estate Register Form a Responsive Web Template, Bootstrap Web Templates, Flat Web Templates, Android Compatible Web Template, Smartphone Compatible Web Template, Free Webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design">
    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>



    <link rel="stylesheet" href="<?= base_url() ?>public/assets/waiter_scripts/bootstrap.min.css">


</head>

<body>



    <div class="signupform" style="text-align: center;padding: 30px;">

        <div><img src="<?php echo base_url() ?>public/assets/images/logo.png" alt="" style="width: 25%;" /></div>
        <div style="display: none; margin-top: 10px;" id="login-alert" class="alert alert-danger col-sm-5 col-sm-offset-5">
            <span id="errorbox"></span>
        </div>
        <div class='clear'></div>
        <br />
        <br />
        <div class="container">
            <div class="agile_info">

                <div class="w3l_form">
                    <div class="left_grid_info">
                    </div>
                </div>

                <div class="w3_info">
                    <div class="btn-group-vertical ml-6 mt-4" role="group" aria-label="Basic example">
                        <div class="btn-group">
                            <input class="text-center form-control-lg mb-4" id="code" type="password">
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '1';">1</button>
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '2';">2</button>
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '3';">3</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '4';">4</button>
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '5';">5</button>
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '6';">6</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '7';">7</button>
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '8';">8</button>
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '9';">9</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value.slice(0, -1);">X</button>
                            <button type="button" class="btn btn-outline-secondary py-4" onclick="document.getElementById('code').value = document.getElementById('code').value + '0';">0</button>
                            <button type="button" class="btn btn-primary py-4" onclick="checkUser()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //main content -->
            <!---728x90--->
        </div>

        <br /> <br />

        <!-- footer -->
        <div class="footer">
            <p><a href="https://raed.so/" target="blank"><img src="<?php echo base_url() ?>public/assets/images/poweredby.png" alt="" style="width: 12%;"></a></p>
        </div>
        <!---728x90--->
        <!-- footer -->
    </div>

    <script src="<?= base_url() ?>public/assets/waiter_scripts/jquery.min.js"></script>


    <script type="text/javascript">

var base_url = "<?php echo base_url($locale); ?>";

        function checkUser() {
            var pass = document.getElementById('code').value;

            if (pass === '') {

                alert('Fadlan gali lambar sireedka.');
                return false;
            }

            $.ajax({
                type: "POST",
                url: base_url +  "/pos/waiter_login",
                data: {
                    pass: pass
                },
                dataType: "json",
                success: function(data) {

                    if (data.status) {
                        location.href = "<?= base_url($locale.'/') ?>pos/point_of_sale";
                    } else {
                        alert(data.msg);
                        document.getElementById('code').value = '';
                    }
                },

                error: function(request, status, error) {

                    console.log(request.responseText);
                    console.log(status);

                }
            });

        }

        $('.py-4').css('font-size', '20px').css('font-weight', 'bold');
    </script>
</body>

</html>