<?php
require_once "../../core/init.php";
require_once "../../core/bookmark.php";
require_once 'validation.php';

validateAdmin(1);

$query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}'");
while($row=mysqli_fetch_assoc($query)) {
    $admin_id = $row['id'];
    $acct_password = $row['password'];
}

if(isset($_POST['submit'])) {
    $activity = "Attempted creating new admin.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);

    $phone = $_POST['phone'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $roles = array();
    foreach ($_POST['roles'] as $key => $value) {
        $roles[] = $value;
    }
    if(sizeof($roles)>0) {
        $role="";
        if(in_array("1", $roles)){$role="1";}else{$role = implode(",", $roles);}

        $date = date("Y-m-d H:i:s");
        $query = selectQuery("select * from members where email = '$email'");
        if(mysqli_num_rows($query)>0){
            $activity = "Account creation failed due to duplicate email.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $error = "Email is already in use!";
        }else{
            if(!password_verify($password, $acct_password)) {
                $activity = "Creation failed due to wrong password.";
                createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
                $error = "Sorry, your password is incorrect!";
            }else{
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $email_hash = password_hash($email, PASSWORD_BCRYPT);
                otherQuery("insert into members (fname, lname, phone, email, email_slug, roles, password, user_status, date_registered, date_modified) values ('$fname','$lname','$phone','$email','$email_hash','$role','$hash','1','$date','$date')");

                $query = selectQuery("select * from members where email = '$email'");
                $row=mysqli_fetch_assoc($query);
                $user_id = $row['id'];

                $activity = "Account creation was successful.";
                createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
                $success = "Admin account created successfully!";
            }
        }
    }else{
        $activity = "Account creation failed due to missing roles.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "You must assign at least one role to the user!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Create New Admin | Xservico Online Store</title>
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
            <h1 class="page-title"> Create New Admin</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Create New Admin</span>
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
                                <span class="caption-subject bold uppercase"> Enter Admin Details</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="" method="post" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label>Email <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="email" class="form-control input-circle-right" placeholder="Email Address" required="" name="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>First Name <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" placeholder="First name" required="" name="fname">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" placeholder="Last name" required="" name="lname">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-phone"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" placeholder="Phone number" required="" name="phone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Admin Role <span class="required">*</span></label>
                                        <select multiple name="roles[]" class="form-control" required="">
                                            <option value="1">Super Admin</option>
                                            <option value="2">Members</option>
                                            <option value="3">Stocks</option>
                                            <option value="4">Transactions</option>
<!--                                            <option value="5">Tickets</option>-->
                                            <option value="6">Blogs & Pages</option>
                                        </select>
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
                                </div>
                                <div class="form-actions">
                                    <button type="submit" name="submit" class="btn blue">Submit</button>
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
