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

if(isset($_POST['update']) && isset($_GET['x'])){
    $activity = "Attempted updating order information.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

    if(!password_verify($password, $acct_password)) {
        $activity = "Update failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else{

        otherQuery("update orders set status = '$status', admin = '$admin_id', date_modified = '$date' where reference = '{$_GET['x']}'");

        otherQuery("insert into ordertracks (order_ref, remarks, date_posted) values ('{$_GET['x']}','$remarks','$date')");

        if($status=="1"){
            otherQuery("insert into ordertracks (order_ref, remarks, date_posted) values ('{$_GET['x']}','Order is Complete.','$date')");
        }elseif($status=="2"){
            otherQuery("insert into ordertracks (order_ref, remarks, date_posted) values ('{$_GET['x']}','Order is Canceled.','$date')");
        }

        $activity = "Update was successful.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $success = "Changes updated successfully!";
    }
}

if(isset($_GET['x'])){
    $reference = $_GET['x'];
    $query = selectQuery("select * from orders where reference = '$reference'");
    while($row=mysqli_fetch_assoc($query)){
        $total_qty = $row['quantity'];
        $reference = $row['reference'];
        $total_amount = $row['amount'];
        $note = $row['note'];
        if($row['payment_option']=="transfer"){
            $payment_option = "Bank Transfer";
        }elseif($row['payment_option']=="on_delivery"){
            $payment_option = "Pay on Delivery";
        }if($row['payment_option']=="card"){
            $payment_option = "Debit Card";
        }
        $status = $row['status'];
        $query2 = selectQuery("select * from members where id = '{$row['member_id']}'");
        $row2=mysqli_fetch_assoc($query2);
        $email = $row2['email'];
        $query2=selectQuery("select * from orderlist where order_ref = '{$row['reference']}'");
        while($row2=mysqli_fetch_assoc($query2)){
            $prod_ids[] = $row2['prod_id'];
            $qtys[] = $row2['quantity'];
            $prices[] = $row2['price'];
            $query3 = selectQuery("select * from prod_images where prod_id = '{$row2['prod_id']}' order by date_posted asc limit 1");
            $row3 = mysqli_fetch_assoc($query3);
            $images[] = $row3['image'];
        }

        $billing_address1 = $row['billing_address1'];
        $billing_address2 = $row['billing_address2'];
        $billing_city = $row['billing_city'];
        $billing_state = $row['billing_state'];
        $billing_zip = $row['billing_zip'];
        $billing_phone = $row['billing_phone'];
        $billing_email = $row['billing_email'];
        $shipping_address1 = $row['shipping_address1'];
        $shipping_address2 = $row['shipping_address2'];
        $shipping_city = $row['shipping_city'];
        $shipping_state = $row['shipping_state'];
        $shipping_zip = $row['shipping_zip'];
        $shipping_phone = $row['shipping_phone'];
        $shipping_email = $row['shipping_email'];

    }

    if(mysqli_num_rows($query)==0){
        header("Location: all-transactions");
        exit;
    }

}else{
    header("Location: all-transactions");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Manage Order | Xservico Online Store</title>
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
            <h1 class="page-title"> Manage Order
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Manage Order</span>
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

                            <h3>Order Break-down</h3>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="product-thumbnail">&nbsp;</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php for($i=0; $i<sizeof($prod_ids); $i++){
                                    $query = selectQuery("select * from prods where id = '{$prod_ids[$i]}'");
                                    $row=mysqli_fetch_assoc($query);
                                    ?>
                                    <tr>
                                        <td class="product-thumbnail"><a href="<?php echo "manage-products?m={$prod_ids[$i]}"; ?>"><img src="<?php echo "{$GLOBALS['path']}res/administrator/{$images[$i]}"; ?>" alt="<?php echo $row['slug'] ?>" width='50px'></a></td>
                                        <td class="product-name" data-title="Product"><a href="<?php echo "manage-products?m={$prod_ids[$i]}"; ?>"><?php echo $row['title']; ?></a></td>
                                        <td class="product-price" data-title="Price">&#8358;<?php echo $prices[$i]; ?></td>
                                        <td class="product-quantity" data-title="Quantity"><?php echo $qtys[$i]; ?></td>
                                        <td class="product-subtotal" data-title="Total">&#8358;<?php echo $qtys[$i]*$prices[$i]; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="3" align="center">Total</td>
                                    <td class="product-quantity" data-title="Quantity"><?php echo $total_qty; ?></td>
                                    <td class="product-subtotal" data-title="Total">&#8358;<?php echo $total_amount; ?></td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="px-0">
                                        <div class="row no-gutters align-items-center">
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                            <h3>Customer Info & Preference</h3>
                            <form action="" method="post" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label>Customer Email </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="email" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($email); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Order Reference </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="#<?php echo htmlentities($reference); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Payment Option </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($payment_option); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Order Note </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <textarea class="form-control input-circle-right" readonly=""><?php echo $note; ?></textarea>
                                        </div>
                                    </div>

                                    <h3 style="margin-top: 70px;">Billing Address</h3>
                                    <div class="form-group">
                                        <label>Address Line 1 </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_address1); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address Line 2 </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="#<?php echo htmlentities($billing_address2); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>City </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
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
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_state); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Postcode / ZIP </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_zip); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_phone); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="email" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($billing_email); ?>">
                                        </div>
                                    </div>

                                    <h3 style="margin-top: 70px;">Shipping Address</h3>
                                    <div class="form-group">
                                        <label>Address Line 1 </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_address1); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address Line 2 </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="#<?php echo htmlentities($shipping_address2); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>City </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
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
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_state); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Postcode / ZIP </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_zip); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_phone); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email </label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                            <input type="email" class="form-control input-circle-right" readonly="" value="<?php echo htmlentities($shipping_email); ?>">
                                        </div>
                                    </div>

                                    <h3 style="margin-top: 70px;">Order Tracking</h3>
                                    <table class="table" style="margin-bottom: 50px;">
                                        <thead>
                                        <tr>
                                            <th>Updates</th>
                                            <th>Posted</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $query=selectQuery("select * from ordertracks where order_ref = '$reference' order by date_posted asc");
                                        while($row=mysqli_fetch_assoc($query)){ ?>
                                            <tr>
                                                <td><?php echo $row['remarks']; ?></td>
                                                <td><?php echo date("D, j M Y g:i a", strtotime($row['date_posted'])); ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2" class="px-0">
                                                <div class="row no-gutters align-items-center">
                                                </div>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                    <h3>Order Review / Status</h3>
                                    <?php if($status=="0"){ ?>
                                        <div class="form-group">
                                            <label>Add New Remarks <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                <textarea class="form-control input-circle-right" required="" name="remarks"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Order Status <span class="required">*</span></label>
                                            <select name="status" required="" class="form-control">
                                                <optgroup>
                                                    <option selected value="0">Pending</option>
                                                    <option value="1">Completed</option>
                                                    <option value="2">Canceled</option>
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
                                    <?php }else{ ?>
                                        <div class="form-group">
                                            <label>Order Status </label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" readonly="" value="<?php echo $status=="1" ? "COMPLETED" : "CANCELED"; ?>">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-actions">
                                    <?php if($status=="0"){ ?>
                                        <button type="submit" onclick="return confirm('Confirm changes?');" name="update" class="btn blue">Update</button>
                                    <?php } ?>
                                    <a href="all-transactions"><button type="button" class="btn default"><span class="fa fa-long-arrow-left"></span> Back</button></a>
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