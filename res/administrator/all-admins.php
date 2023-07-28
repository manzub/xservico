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

if(isset($_POST['update']) && isset($_GET['m'])) {
    $activity = "Attempted updating admin information.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);

    $user_status = $_POST['status'];
    $password = $_POST['password'];
    $roles = array();
    foreach ($_POST['roles'] as $key => $value) {
        $roles[] = $value;
    }
    if(sizeof($roles)>0) {
        if(!verify_password($password, $acct_password)) {
            $activity = "Creation failed due to wrong password.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $error = "Sorry, your password is incorrect!";
        }else{
            $role="";
            if(in_array("1", $roles)){$role="1";}else{$role = implode(",", $roles);}

            $date = date("Y-m-d H:i:s");
            otherQuery("update members set user_status = '$user_status', roles='$role', date_modified = '$date' where email_slug = '{$_GET['m']}';");


            $query = selectQuery("select * from members where email_slug = '{$_GET['m']}'");
            $row=mysqli_fetch_assoc($query);
            $user_id = $row['id'];

            $activity = "Update was successful.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $success = "Changes updated successfully!";
        }
    }else {
        $activity = "Update failed due to missing roles.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "You must assign at least one role to the user!";
    }
}


if(isset($_GET['m'])){
    $email_slug = $_GET['m'];
    $query = selectQuery("select * from members where email_slug = '$email_slug' and roles is not null");
    while($row=mysqli_fetch_assoc($query)){
        $names = $row['fname']." ".$row['lname'];
        $phone = $row['phone'];
        $email = $row['email'];
        $user_status = $row['user_status'];
        $roles = explode(",", $row['roles']);
    }

    if(mysqli_num_rows($query)==0){
        header("Location: all-admins");
        exit;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php if(isset($_GET['m'])){ ?>Edit Admin<?php }else{ ?>All Administrators <?php } ?> | Xservico Online Store</title>
    <?php require_once "includes/styles.php"; ?>

    <link rel="stylesheet" href="assets/dashboard.css" >
</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid" style="background-color: #2a3442 !important;">
<!-- BEGIN HEADER -->
<?php require_once "includes/header.php"; ?>
<div class="clearfix"> </div>
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
            <h1 class="page-title"> <?php if(isset($_GET['m'])){ ?>Edit Admin<?php }else{ ?>All Administrators <?php } ?>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php if(isset($_GET['m'])){ ?>Edit Admin<?php }else{ ?>All Administrators <?php } ?></span>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <?php if(isset($_GET['m'])){ ?>
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
                                            <label>Names </label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($names); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Admin Role <span class="required">*</span></label>
                                            <select multiple name="roles[]" class="form-control" required="">
                                                <option <?php if(in_array("1", $roles)){echo "selected='selected'";} ?> value="1">Super Admin</option>
                                                <option <?php if(in_array("2", $roles)){echo "selected='selected'";} ?> value="2">Members</option>
                                                <option <?php if(in_array("3", $roles)){echo "selected='selected'";} ?> value="3">Stocks</option>
                                                <option <?php if(in_array("4", $roles)){echo "selected='selected'";} ?> value="4">Transactions</option>
                                                <option <?php if(in_array("5", $roles)){echo "selected='selected'";} ?> value="5">Tickets</option>
                                                <option <?php if(in_array("6", $roles)){echo "selected='selected'";} ?> value="6">Blogs & Pages</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>User Status <span class="required">*</span></label>
                                            <select name="status" required="" class="form-control">
                                                <optgroup>
                                                    <option <?php if($user_status=="1"){echo "selected";} ?> value="1">Active</option>
                                                    <option <?php if($user_status=="2"){echo "selected";} ?> value="2">Blocked</option>
                                                </optgroup>
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
                                        <button type="submit" onclick="return confirm('Confirm changes?');" name="update" class="btn blue">Update</button>
                                        <a href="all-admins"><button type="button" class="btn default">Cancel</button></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END SAMPLE FORM PORTLET-->
                    </div>
                </div>
            <?php }else{ ?>
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="table-scrollable">
                            <table id="myTable" class="list table table-striped" style="padding-top: 20px;">
                                <thead>
                                <th>S/N</th>
                                <th>NAMES</th>
                                <th>EMAIL</th>
                                <th>PHONE</th>
                                <th>STATUS</th>
                                <th>ROLES</th>
                                <th>REGISTERED</th>
                                <th>ACTION</th>
                                </thead>
                                <?php echo allAdmins(); ?>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
<script type="text/javascript">
    $(document).ready(function(){
        var t = $('#myTable').DataTable( {
            dom: 'Bfrtipl',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
        } );
    });
</script>