<?= $this->extend("front/layouts/base"); ?>

<?= $this->section('content'); ?>

 
<style>
 
.signup-container {
  background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    box-sizing: border-box;
    margin: auto; /* Ku dar si aad xarun ugu dhigto */
}

.form-header {
    text-align: center;
    margin-bottom: 20px;
}

.form-header h2 {
    margin: 0;
    font-size: 24px;
    color: #333;
}

.form-header p {
    color: #666;
    font-size: 14px;
}

.signup-form {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.signup-button {
    background: #74ebd5;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.signup-button:hover {
    background: #ACB6E5;
}

</style></head>
<body>
    <div class="signup-container">
        <div class="form-header">
            <h2>Sign Up</h2>
            <p>Create your account</p>
        </div>
        <form id="myForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="imagefile">Upload Logo </label>
                <input type="file" id="imagefile" name="imagefile" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="username" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            
            <div class="links">
             <p><a href="#">Forgot Password?</a></p>
        </div>
            <button type="submit" id="btn_submit" class="signup-button">Sign Up</button>
         
         
            <div class="links" style="margin-top: 18px;">
            <p>Already have an account? <a href="<?= base_url($locale) ?>/front/signin">Sign In</a></p>
         </div>
        </form>
    </div>
</body>
</html>


 
 

 


<script>
        $(document).ready(function() {
            $('#myForm').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);

                $.ajax({
                    url: '/submit-form',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#response').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });
    </script>



  
<?= $this->endSection(); ?>