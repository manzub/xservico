<?php
require_once "../../core/init.php";
require_once "../../core/bookmark.php";
require_once 'validation.php';

validateAdmin('1,6');

$query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}'");
while($row=mysqli_fetch_assoc($query)) {
    $admin_id = $row['id'];
    $acct_password = $row['password'];
}

if(isset($_POST['update'])){
    $activity = "Attempted update on return policy info.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
    $info = $_POST['info'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

    if(!password_verify($password, $acct_password)) {
        $activity = "Update failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else{

        otherQuery("update pages set info='$info', date_modified='$date' where type='return_policy'");

        $activity = "Return policy update was successful.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $success = "Return Policy was updated successfully!";
    }
}

$query = selectQuery("select * from pages where type = 'return_policy'");
while($row=mysqli_fetch_assoc($query)){
    $info = $row['info'];
    $date_modified = date("D, j M Y g:i a", strtotime($row['date_modified']));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Return Policy | Xservico Online Store</title>
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
            <h1 class="page-title"> Return Policy</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Return Policy</span>
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
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase"> Manage Return Policy Information</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <h4>Last updated: <?php echo $date_modified; ?></h4>
                            <form action="" method="post" role="form">
                                <div class="form-group">
                                    <label>Text <span class="required">*</span></label>
                                    <textarea class="ckeditor form-control" name="info" rows="6" data-error-container="#editor2_error"><?php echo $info; ?></textarea>
                                    <div id="editor2_error"> </div>
                                </div>
                                <div class="form-group">
                                    <label>Password <span class="required">*</span></label>
                                    <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                        <input type="password" autocomplete="new-password" class="form-control input-circle-right" placeholder="Password" required="" name="password">
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" name="update" class="btn blue">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <?php require_once "includes/quick-sidebar.php"; ?>
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
