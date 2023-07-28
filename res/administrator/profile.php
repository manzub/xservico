<?php
require_once "../../core/init.php";
require_once "../../core/bookmark.php";
require_once 'validation.php';

validateAdmin('1,7');

$query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}'");
while($row=mysqli_fetch_assoc($query)) {
    $admin_id = $row['id'];
    $acct_password = $row['password'];
    $roles = explode(',',$row['roles']);
}

if(isset($_POST['update'])) {
    $activity = "Attempted updating profile information.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $npassword = $_POST['npassword'];
    $cpassword = $_POST['cpassword'];

    if($npassword!="" && $npassword==$cpassword || $npassword=="") {
        if(!password_verify($password, $acct_password)) {
            $activity = "Creation failed due to wrong password.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $error = "Sorry, your password is incorrect!";
        }else{
            $date = date("Y-m-d H:i:s");

            if($npassword!=""){ $acct_password = password_hash($npassword, PASSWORD_BCRYPT); }
            otherQuery("update members set fname='$fname', lname='$lname', phone='$phone', date_modified='$date', password='$acct_password' where email_slug='{$_SESSION['xservico_slug'][0]}'");

            $activity = "Update was successful.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $success = "Changes updated successfully!";
        }
    }else{
        $activity = "Update failed due to mismatched passwords.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, new passwords do not match!";
    }
}

$query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}'");
while($row=mysqli_fetch_assoc($query)){
    $fname = $row['fname'];
    $lname = $row['lname'];
    $phone = $row['phone'];
    $email = $row['email'];
    $roles = "";
    $role = explode(",", $row['roles']);
    if(in_array("1", $role)){$roles.="Super Admin,";}
    if(in_array("2", $role)){$roles.="Members, ";}
    if(in_array("3", $role)){$roles.="Stocks, ";}
    if(in_array("4", $role)){$roles.="Transactions, ";}
    if(in_array("5", $role)){$roles.="Tickets, ";}
    if(in_array("6", $role)){$roles.="Blogs & Pages";}
    if(in_array("7", $role)){$roles.="Merchants";}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>My Profile | Xservico Online Store</title>
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
    <?php if(in_array('7',$role)) { require_once "includes/sidebar2.php"; }else{ require_once "includes/sidebar.php"; } ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
            <?php //require_once "includes/theme-panel.php"; ?>
            <!-- END THEME PANEL -->
            <h1 class="page-title"> My Profile
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>My Profile</span>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12 mb-2">
                    <?php if (isset($success)){ ?>
                        <div class="alert alert-success text-center"><?php echo $success; ?></div>
                    <?php }elseif(isset($error)){ ?>
                        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                    <?php } ?>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-body form">
                            <form action="" method="post" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label>Email </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="email" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($email); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>First Name <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" placeholder="First name" required="" name="fname" value="<?php echo htmlentities($fname); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" placeholder="Last name" required="" name="lname" value="<?php echo htmlentities($lname); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-phone"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" placeholder="Phone number" required="" name="phone" value="<?php echo htmlentities($phone); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Admin Role</label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($roles); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Current Password <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-lock"></i>
                                                    </span>
                                            <input type="password" autocomplete="new-password" class="form-control input-circle-right" placeholder="Old Password" required="" name="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>New Password <sub>(optional)</sub></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-lock"></i>
                                                    </span>
                                            <input type="password" autocomplete="new-password" class="form-control input-circle-right" placeholder="New password" name="npassword">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password <sub>(optional)</sub></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-lock"></i>
                                                    </span>
                                            <input type="password" autocomplete="new-password" class="form-control input-circle-right" placeholder="Confirm password" name="cpassword">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" onclick="return confirm('Confirm changes?');" name="update" class="btn blue">Update</button>
                                    <a href="index"><button type="button" class="btn default">Cancel</button></a>
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
