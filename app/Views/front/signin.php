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
            <h2>Sign In</h2>
         </div>
        <form action="#" method="POST" class="signup-form">
           
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
        
        
            <button type="submit" class="signup-button">Sign In</button>
         
            <div class="links" style="margin-top: 18px;">
            <p>Already have an account? <a href="<?= base_url($locale) ?>/front/signup">Sign Up</a></p>
         </div>
 
         </form>
    </div>
</body>
</html>

  
<?= $this->endSection(); ?>