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
    <title>Reset Password - Xservico Online Store</title>
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
                                <h3>Forgot Password?</h3>
                            </div>
                            <?php if(isset($_SESSION['f_error'])){ ?>
                                <div class="alert alert-danger text-center"><?php echo $_SESSION['f_error']; ?></div>
                            <?php unset($_SESSION['f_error']);} ?>
                            <?php if(isset($_SESSION['f_message'])){ ?>
                                <div class="alert alert-success text-center"><?php echo $_SESSION['f_message']; ?></div>
                            <?php unset($_SESSION['f_message']);} ?>
                            <form action="assist/f-password" method="post">
                                <div class="form-group">
                                    <input type="email" required class="form-control" name="email" placeholder="Your Email" />
                                    <small>A new password will be generated and sent to the above email<br/>* check spam box</small>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="f-password">Request New Password</button>
                                </div>
                                <a href="<?php echo $GLOBALS['path']; ?>login">Back To Login</a>
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
