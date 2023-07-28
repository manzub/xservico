<?php
require_once "../../core/init.php";
require_once "../../core/bookmark.php";
require_once 'validation.php';

validateAdmin('1,6');

if(isset($_GET['remove'])){
    if(!unlink($_GET['remove'])){
        $activity = "File deletion failed.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "File could not be deleted";
    }else{
        otherQuery("delete from banners where image = '{$_GET['remove']}'");
        $success = "File was deleted successfully!";
    }
}

$query = selectQuery("select * from banners order by date_posted desc");
$image_string="<table class='list table'>";
while($row=mysqli_fetch_assoc($query)){
    $name = substr($row['image'], 31);
    $image_string .= "<tr><td><img src='{$row['image']}' width='200px' /><br>{$name} <a href='?remove={$row['image']}' class='fa fa-remove' style='color:red' onclick='return confirm(\"Confirm delete?\");'> Remove</a> <br>{$row['link']}</td></tr>";
}
$image_count = mysqli_num_rows($query);
$image_string .= "</table>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Exclusive Banner | Xservico Online Store</title>
    <?php require_once "includes/styles.php"; ?>
    <link rel="stylesheet" href="assets/dashboard.css" >
</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid" style="background-color: #2a3442 !important;">
<!-- BEGIN HEADER -->
<?php require_once "includes/header.php"; ?>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php require_once "includes/sidebar.php"; ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
            <?php //require_once "includes/theme-panel.php"; ?>
            <!-- END THEME PANEL -->
            <h1 class="page-title"> Exclusive Banner
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Exclusive Banner</span>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12 ">
                    <?php if (isset($success)){ ?>
                        <div class="alert alert-success text-center"><?php echo $success; ?></div>
                    <?php }elseif(isset($error)){ ?>
                        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                    <?php } ?>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-body form">
                            <h3>Upload Exclusive Banner Images</b> (<?php echo $image_count; ?>)</h3>
                            <p>Banner Dimension: 385px width by 535px height</p>
                            <form action="assets/php/banner-upload.php" class="dropzone dropzone-file-area" id="my-dropzone" method="post" style="">

                                <h4 class="sbold">Drop files here or click to upload</h4>

                                <input type="text" class="form-control input-circle" placeholder="Product Link (e.g: https://www.xyz.com)" name="link" >

                            </form>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-body form">
                            <form action="" method="post">
                                <div class="row" style="margin-bottom: 25px;">
                                    <div class="form-actions">
                                        <a href="exclusive-banner"><button type="button" class="btn red"><span class="fa fa-refresh"></span> Refresh Page</button></a>
                                    </div>
                                </div>
                                <?php echo $image_string; ?>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
<!--    --><?php //require_once "includes/quick-sidebar.php"; ?>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php require_once "includes/footer.php"; ?>
<!-- END FOOTER -->
<!-- BEGIN QUICK NAV -->
<?php //require_once "includes/quick-nav.php"; ?>
<!-- END QUICK NAV -->
<?php require_once "includes/scripts.php"; ?>
</body>
</html>
