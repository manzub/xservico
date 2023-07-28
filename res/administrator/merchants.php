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
    $new_role = isset($_POST['role_change']) ? $_POST['role_change'] : 0;
    echo $new_role;

    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else{
//        get updated user info
        $query2 = selectQuery("select * from members where id='$user_id'");
        $row2 = mysqli_fetch_assoc($query2);
        //get admin email
        $query3 = selectQuery("select * from members where roles = '1'");
        $row3 = mysqli_fetch_assoc($query3);
        $admin_email = $row3['email'];

        otherQuery("update members set user_status = '$user_status', date_modified = '$date' where email_slug = '{$_GET['m']}'");
        if($new_role == 1) {
            otherQuery("update members set user_status = '4',roles = null where email_slug='{$_GET['m']}'");
            // send rejection mail
            $subject = "Xservico Store Merchant Account.";
            $message = "Your Merchant Privileges have been revoked, Contact admin at < $admin_email > .<br><br>Xservico Team";
            sendEmail($row2['email'], $subject, $message);
        }elseif ($new_role == 2) {
            //send acceptance mail
            otherQuery("update members set user_status = '$user_status', roles = '7' where email_slug='{$_GET['m']}'");
            $subject = "Xservico Store Merchant Registration.";
            $message = "Your Request to signup as a merchant on our platform is has been accepted, Log into your dashboard to upload your first product.<br><br>Xservico Team";
            sendEmail($row2['email'], $subject, $message);
        }

        $activity = "Update was successful.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $success = "Changes updated successfully!";
    }
}

if(isset($_GET['m'])){
    $email_slug = $_GET['m'];
    $query = selectQuery("select * from members where email_slug = '$email_slug' and roles = '7' or user_status = '4'");
    while($row=mysqli_fetch_assoc($query)){
        $user_id = $row['id'];
        $names = $row['fname']." ".$row['lname'];
        $phone = $row['phone'];
        $email = $row['email'];
        $user_status = $row['user_status'];
        $roles = explode(',',$row['roles']);


    }

    if(mysqli_num_rows($query)==0){
        header("Location: merchants");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php if(isset($_GET['m'])){ ?>Edit Merchants<?php }else{ ?>All Merchants <?php } ?> | Xservico Online Store</title>
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
            <h1 class="page-title"> <?php if(isset($_GET['m'])){ ?>Edit Merchant<?php }else{ ?>All Merchants <?php } ?></small>
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
                                    <?php if($user_status == '4') { ?>
                                    <div class="form-group">
                                        <input onclick="return confirm('Approve Merchant Privileges?')" type="checkbox" name="role_change" id="exampleCheckbox4" value="2">
                                        <label for="exampleCheckbox4">Approve Merchant.</label>
                                    </div>
                                    <?php }elseif(in_array('7',$roles)){ ?>
                                    <div class="form-group">
                                        <input onclick="return confirm('Remove Merchant Privileges?')" type="checkbox" name="role_change" id="exampleCheckbox3" value="1">
                                        <label for="exampleCheckbox3">Remove Merchant.</label>
                                    </div>
                                    <?php } ?>
                                    <div class="form-actions">
                                        <button type="submit" onclick="return confirm('Confirm changes?');" name="update" class="btn blue">Update</button>
                                        <a href="merchants"><button type="button" class="btn default">Cancel</button></a>
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

                <div class="portlet light">
                    <div class="portlet-body">
                        <h2><strong>Merchant Fee Payments</strong></h2>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="table-scrollable">
                                    <table class="list table table-striped" style="padding-top: 20px;">
                                        <thead>
                                        <th>EMAIL</th>
                                        <th>AMOUNT</th>
                                        <th>METHOD</th>
                                        <th>TRANSACTION DATE</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query = selectQuery("select * from payments where acct_number = 'merchant-fees'");
                                        while($row = mysqli_fetch_assoc($query)) { ?>
                                            <tr>
                                                <td><?php echo $row['acct_name'] || $row['bank_name']; ?></td>
                                                <td><?php echo $row['amount']; ?></td>
                                                <td><?php echo $row['order_id']; ?></td>
                                                <td><?php echo $row['date_posted']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
            "ajax": "../../core/functions/merchants-processing.php",
            "searching": { "regex": true },
            "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, -1], [10, 25, 50, 100, 200, 500, 1000, "All"] ],
            "pagingType": "full",
        } );
    });
</script>
