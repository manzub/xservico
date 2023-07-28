<?php
require_once "core/init.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/top-styles.php"; ?>
    <title>404 Error- Xservico Online Store</title>
    <?php require_once "includes/bottom-styles.php"; ?>
</head>

<body>

<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START MAIN SECTION -->
    <div class="section">
        <div class="error_wrap">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-10 order-lg-first">
                        <div class="text-center">
                            <div class="error_txt">404</div>
                            <h5 class="mb-2 mb-sm-3">oops! The page you requested was not found!</h5>
                            <p>The page you are looking for was moved, removed, renamed or might never existed.</p>
                            <a href="<?php echo $GLOBALS['path']; ?>index" class="btn btn-fill-out">Back To Home</a>
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

<?php
require_once "includes/scripts.php";
?>

</body>
</html>