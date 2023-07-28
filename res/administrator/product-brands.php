<?php
require_once "../../core/init.php";
require_once "../../core/bookmark.php";
require_once 'validation.php';

validateAdmin('1,3');

$query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}'");
while($row=mysqli_fetch_assoc($query)) {
    $admin_id = $row['id'];
    $acct_password = $row['password'];
}

if(isset($_POST['update']) && isset($_GET['m'])) {
    $activity = "Attempted updating product brands information.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
    $brand_name = $_POST['brand_name'];
    $status = $_POST['status'];
    $password = $_POST['password'];

    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else {
        $query = selectQuery("select * from brands where name = '{$brand_name}' and id <> '{$_GET['m']}'");
        if(mysqli_num_rows($query)>0) {
            $activity = "Update failed due to duplicate brand name.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $error = "Brand name already exists!";
        }else {
            otherQuery("update brands set name='{$brand_name}', status='{$status}' where id='{$_GET['m']}'");

            $activity = "Update was successful.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $success = "Brand updated successfully!";
        }
    }
}

if(isset($_POST['submit'])) {
    $activity = 'Attempted creating new brand';
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
    $brand_name = $_POST['brand_name'];
    $password = $_POST['password'];

    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else {
        $query = selectQuery("select * from brands where name = '{$brand_name}' and id <> '{$_GET['m']}'");
        if(mysqli_num_rows($query)>0) {
            $activity = "Created failed due to duplicate brand name.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $error = "Brand name already exists!";
        }else {
            $x=0;$slug="";
            do{
                if($x==0){
                    $slug_array = explode(" ", $brand_name);
                    $slug = implode("-", $slug_array);
                }elseif($x==1){
                    $slug .= "-".$x;
                }else{
                    $size = strlen($x-1);
                    $slug = substr($slug, 0, -$size);
                    $slug .= "-".$x;
                }
                $x++;
                $query = selectQuery("select * from brands where slug = '{$slug}'");
            }while(mysqli_num_rows($query)>0);

            otherQuery("insert into brands (name,slug) values ('{$brand_name}','{$slug}')");
            $activity = "Creation was successful.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $success = "Brand added successfully!";
        }
    }
}

if(isset($_GET['m'])){
    $id = $_GET['m'];
    $query = selectQuery("select * from brands where id = '{$id}'");
    while($row=mysqli_fetch_assoc($query)){
        $brand_name = $row['name'];
        $brand_slug = $row['slug'];
        $status = $row['status'];
    }

    if(mysqli_num_rows($query)==0){
        header("Location: product-brands");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Product Brands | Xservico Online Store</title>
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
            <h1 class="page-title"> Product Brands</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Product Brands</span>
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
                                <h4>Edit Brand</h4>
                                <form action="" method="post" role="form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Brand Name <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" name="brand_name" required="" value="<?php echo htmlentities($brand_name); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Brand Slug </label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($brand_slug); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Status <span class="required">*</span></label>
                                            <select name="status" required="" class="form-control">
                                                <optgroup>
                                                    <option <?php if($status=="1"){echo "selected";} ?> value="1">Active</option>
                                                    <option <?php if($status=="2"){echo "selected";} ?> value="2">Disabled</option>
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
                                        <a href="product-brands"><button type="button" class="btn default">Cancel</button></a>
                                    </div>
                                </form>
                            <?php }else{ ?>
                                <h4>Create New Brand</h4>
                                <form action="" method="post" role="form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Brand Name </label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" placeholder="Brand Name" name="brand_name" required="">
                                            </div>
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
                                        <a href="product-brands"><button type="button" class="btn default">Cancel</button></a>
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
                        <h4>All Product Brands</h4>
                        <table id="myTable" class="list table table-striped" style="padding-top: 20px;">
                            <thead>
                            <th>S/N</th>
                            <th>NAME</th>
                            <th>SLUG</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                            </thead>
                            <?php echo allBrands(); ?>
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
