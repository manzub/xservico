<?php
require_once "../../core/init.php";
require_once "../../core/bookmark.php";
require_once 'validation.php';

validateAdmin('1,7');

$query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}'");
while($row=mysqli_fetch_assoc($query)) {
    $admin_id = $row['id'];
    $acct_password = $row['password'];
    $roles = explode(",",$row['roles']);
    $merchant = in_array('7',$roles) ? 1 : 0;
}

if(isset($_POST['delete']) && isset($_GET['m'])){
    otherQuery("delete from bank_accounts where id = '{$_GET['m']}'");
}

if(isset($_POST['update']) && isset($_GET['m'])) {
    $activity = "Attempted updating bank account information.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);

    $bank_name = $_POST['bank_name'];
    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else{
        otherQuery("update bank_accounts set bank_name='$bank_name', account_name='$account_name', account_number='$account_number', account_type='$account_type', date_modified='$date' where id = '{$_GET['m']}'");

        $activity = "Update was successful.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $success = "Bank account updated successfully!";
    }
}

if(isset($_POST['submit'])) {
    $activity = "Attempted uploading new bank account information.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);

    $bank_name = $_POST['bank_name'];
    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else{
        otherQuery("insert into bank_accounts (bank_name, account_name, account_number, account_type, date_posted, date_modified, merchants) values ('$bank_name','$account_name','$account_number','$account_type','$date','$date','$merchant')");

        $activity = "Upload was successful.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $success = "Bank account was uploaded successfully!";
    }
}

if(isset($_GET['m'])) {
    $id = $_GET['m'];
    $query = selectQuery("select * from bank_accounts where id = '$id'");
    while($row=mysqli_fetch_assoc($query)){
        $bank_name = $row['bank_name'];
        $account_name = $row['account_name'];
        $account_number = $row['account_number'];
        $account_type = $row['account_type'];
    }

    if(mysqli_num_rows($query)==0){
        header("Location: bank-accounts");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Bank Accounts | Xservico Online Store</title>
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
    <?php if(in_array('7',$roles)) { require_once "includes/sidebar2.php"; }else{ require_once "includes/sidebar.php"; } ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
            <?php //require_once "includes/theme-panel.php"; ?>
            <!-- END THEME PANEL -->
            <h1 class="page-title"> Bank Accounts
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Bank Accounts</span>
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
                            <?php if(isset($_GET['m'])){ ?>
                                <h4>Edit Account Details</h4>
                                <form action="" method="post" role="form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Bank Name <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" name="bank_name" required="" value="<?php echo htmlentities($bank_name); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Account Name <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" placeholder="Account Name" name="account_name" value="<?php echo htmlentities($account_name); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Account Number <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" placeholder="Account Number" name="account_number" value="<?php echo htmlentities($account_number); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Account Type <span class="required">*</span></label>
                                            <select name="account_type" required="" class="form-control">
                                                <optgroup>
                                                    <option <?php if($account_type=="Current"){echo "selected";} ?>>Current</option>
                                                    <option <?php if($account_type=="Savings"){echo "selected";} ?>>Savings</option>
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
                                        <a href="bank-accounts"><button type="button" class="btn default">Cancel</button></a>
                                        <button type="submit" onclick="return confirm('Confirm delete?');" name="delete" class="btn red">Delete</button>
                                    </div>
                                </form>
                            <?php }else{ ?>
                                <h4>Upload New Account</h4>
                                <form action="" method="post" role="form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Bank Name </label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" placeholder="Bank Name" name="bank_name" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Account Name</label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" placeholder="Account Name" name="account_name" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Account Number</label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="number" class="form-control input-circle-right" placeholder="Account Number" name="account_number" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Account Type <span class="required">*</span></label>
                                            <select name="account_type" class="form-control" required="">
                                                <option>Current</option>
                                                <option>Savings</option>
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
                                        <button type="submit" onclick="return confirm('Confirm posting?');" name="submit" class="btn blue">Submit</button>
                                        <a href="bank-accounts"><button type="button" class="btn default">Cancel</button></a>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="table-scrollable">
                        <h4>All Bank Accounts</h4>
                        <table id="myTable" class="list table table-striped" style="padding-top: 20px;">
                            <thead>
                            <th>S/N</th>
                            <th>BANK NAME</th>
                            <th>ACCT NAME</th>
                            <th>ACCT NUMBER</th>
                            <th>ACCT TYPE</th>
                            <th>POSTED</th>
                            <th>MODIFIED</th>
                            <th>ACTION</th>
                            </thead>
                            <?php echo allBankAccounts($merchant); ?>
                        </table>
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
