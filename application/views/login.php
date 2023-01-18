
<div class="content" id="content">
    
</div>

<script type="text/template" id="login-template">
    <div class="contentBx">
        <div class="formBx">
            <h2>Login</h2>
            <form>
                <div class="inputBx">
                    <span>Username:</span>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="inputBx">
                    <span>Password:</span>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="remember">
                    <label><input type="checkbox" name="remember">Remember me</label>
                </div>
                <div class="inputBx">
                    <input type="submit" value="Sign In">
                </div>
                <div class="inputBx">
                    <p>Don't have an account? <a href="<?php echo base_url(); ?>users/login#register"">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>

</script>

<script type="text/template" id="register-template">
    <div class="contentBx">
        <div class="formBx">
            <h2>Register</h2>
            <form>
            <div class="inputBx">
                    <span>First Name:</span>
                    <input type="text" name="firstname" id="firstname" required>
                </div>
                <div class="inputBx">
                    <span>Last Name:</span>
                    <input type="text" name="lastname" id="lastname" required>
                </div>
                <div class="inputBx">
                    <span>Username:</span>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="inputBx">
                    <span>Email:</span>
                    <input type="text" name="email" id="email" required>
                </div>
                <div class="inputBx">
                    <span>Password:</span>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="inputBx">
                    <span>Confirm Password:</span>
                    <input type="password" name="password2" id="password2" required>
                </div>
                <div class="inputBx">
                    <input type="submit" value="Sign Up">
                </div>
                <div class="inputBx">
                    <p>Already have an account? <a href="<?php echo base_url(); ?>users/login"">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</script>

<script src="<?php echo base_url(); ?>assets/js/users.js"></script>
