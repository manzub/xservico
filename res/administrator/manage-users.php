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
    $activity = "Attempted updating user information.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);

    $user_status = $_POST['status'];
    $user_id = $_POST['user_id'];
    $date = date("Y-m-d H:i:s");
    $password = $_POST['password'];

    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else{
        otherQuery("update members set user_status = '$user_status', date_modified = '$date' where email_slug = '{$_GET['m']}'");

        $activity = "Update was successful.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $success = "Changes updated successfully!";
    }
}

if(isset($_GET['m'])){
    $email_slug = $_GET['m'];
    $query = selectQuery("select * from members where email_slug = '$email_slug' and roles is null");
    while($row=mysqli_fetch_assoc($query)){
        $user_id = $row['id'];
        $names = $row['fname']." ".$row['lname'];
        $phone = $row['phone'];
        $email = $row['email'];
        $user_status = $row['user_status'];

        $billing_address1 = "Nil";
        $billing_address2 = "Nil";
        $billing_city = "Nil";
        $billing_state = "Nil";
        $billing_zip = "Nil";
        $billing_phone = "Nil";
        $billing_email = "Nil";
        $shipping_address1 = "Nil";
        $shipping_address2 = "Nil";
        $shipping_city = "Nil";
        $shipping_state = "Nil";
        $shipping_zip = "Nil";
        $shipping_phone = "Nil";
        $shipping_email = "Nil";
        $query2 = selectQuery("select * from addresses where member_id = '{$row['id']}'");
        while($row2=mysqli_fetch_assoc($query2)){
            if($row2['type']=="billing"){
                $billing_address1 = $row2['address1'];
                $billing_address2 = $row2['address2'];
                $billing_city = $row2['city'];
                $billing_state = $row2['state'];
                $billing_zip = $row2['zip'];
                $billing_phone = $row2['phone'];
                $billing_email = $row2['email'];
            }else{
                $shipping_address1 = $row2['address1'];
                $shipping_address2 = $row2['address2'];
                $shipping_city = $row2['city'];
                $shipping_state = $row2['state'];
                $shipping_zip = $row2['zip'];
                $shipping_phone = $row2['phone'];
                $shipping_email = $row2['email'];
            }
        }
    }

    if(mysqli_num_rows($query)==0){
        header("Location: manage-users");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php if(isset($_GET['m'])){ ?>Edit User<?php }else{ ?>All Users <?php } ?> | Xservico Online Store</title>
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
            <h1 class="page-title"> <?php if(isset($_GET['m'])){ ?>Edit User<?php }else{ ?>All Users <?php } ?></small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php if(isset($_GET['m'])){ ?>Edit User<?php }else{ ?>All Users <?php } ?></span>
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

                                        <div class="caption font-red-sunglo">
                                            <i class="fa fa-info-circle font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase"> Bio Data</span>
                                        </div>
                                        <br>
                                        <input type="text" name="user_id" value="<?php echo $user_id; ?>" style="display: none;">
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
                                            <label>Phone </label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($phone); ?>">
                                            </div>
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
                                        <a href="manage-users"><button type="button" class="btn default">Cancel</button></a>
                                    </div>
                                </form>

                                <div class="form-body">

                                    <br>
                                    <div class="caption font-red-sunglo">
                                        <i class="fa fa-info-circle font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase"> Billing Data</span>
                                    </div>
                                    <br>

                                    <div class="form-group">
                                        <label>Address Line 1 </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                            <input type="email" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_address1); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address Line 2 </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_address2); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>City </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_city); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>State </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                            <input type="email" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_state); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>ZIP </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_zip); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_phone); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-envelop"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_email); ?>">
                                        </div>
                                    </div>

                                    <br>
                                    <div class="caption font-red-sunglo">
                                        <i class="fa fa-info-circle font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase"> Shipping Data</span>
                                    </div>
                                    <br>

                                    <div class="form-group">
                                        <label>Address Line 1 </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                            <input type="email" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_address1); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address Line 2 </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_address2); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>City </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_city); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>State </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                            <input type="email" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_state); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>ZIP </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_zip); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_phone); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email </label>
                                        <div class="input-group">
                                                <span class="input-group-addon input-circle-left">
                                                    <i class="fa fa-envelop"></i>
                                                </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_email); ?>">
                                        </div>
                                    </div>


                                </div>
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
                                <th>REGISTERED</th>
                                <th>FNAME</th>
                                <th>LNAME</th>
                                <th>EMAIL</th>
                                <th>PHONE</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                                </thead>

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
<script type="text/javascript">
    $(document).ready(function(){
        var t = $('#myTable').DataTable( {
            dom: 'Bfrtipl',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "order": [[ 0, 'desc' ]],
            "processing": true,
            "serverSide": true,
            "ajax": "../../core/functions/users-processing.php",
            "searching": { "regex": true },
            "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, -1], [10, 25, 50, 100, 200, 500, 1000, "All"] ],
            "pagingType": "full",
        } );
    });
</script>
