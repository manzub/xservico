<?php

require 'core/init.php';
if(isset($_SESSION['xservico'])) {
    header("Location: res/users/index");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/top-styles.php"; ?>
    <title>User Login - Xservico Online Store</title>
    <?php require_once "includes/bottom-styles.php"; ?>
</head>
<body>

<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START MAIN SECTION -->
    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="text-center heading_s1">
                                <h3>Login</h3>
                            </div>
                            <?php if(isset($_SESSION['login_error'])){ ?>
                            <div class="alert alert-danger text-center"><?php echo $_SESSION['login_error']; ?></div>
                            <?php unset($_SESSION['login_error']);} ?>
                            <form action="assist/validation" method="post">
                                <div class="form-group">
                                    <input type="email" required class="form-control" name="email" placeholder="Your Email" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                <div class="login_footer form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                            <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                        </div>
                                    </div>
                                    <a href="<?php echo $GLOBALS['path']; ?>forgot-password">Forgot password?</a>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="login">Log in</button>
                                </div>
                                <div class="form-note text-center">Don't have an account? <a href="<?php echo $GLOBALS['path']; ?>signup">Sign Up</a></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN SECTION -->

</div>
<!-- END MAIN CONTENT -->
<!-- END MAIN CONTENT -->

<?php require_once "includes/scripts.php";  ?>

</body>
</html>
