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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Settings | Xservico Online Store</title>
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

            <div class="container">
                <h1 class="page-title"> Settings</h1>
                <div class="page-bar rounded">
                    <ul class="page-breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="index">Account</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <span>Settings</span>
                        </li>
                    </ul>
                </div>

                <div class="card card-custom card-stretch gutter-b rounded">
                    <div class="card-body pt-4 rounded-bottom" style="position: relative">
                        <div class="row">
                            <div class="col-lg-6 bg-grey-100 mb-5">
                                <a href="general" class="d-flex align-items-center">
                                    <div class="settings-icon-card">
                                        <span class="icon-settings"></span>
                                    </div>
                                    <div class="body-part">
                                        <h3 class="pl- m-0">General</h3>
                                        <p style="font-size: 12px" class="p-0 text-muted">Edit store info (address, work line and contact details.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 bg-grey-100 mb-5">
                                <a href="bank-accounts" class="d-flex align-items-center">
                                    <div class="settings-icon-card">
                                        <span class="icon-credit-card"></span>
                                    </div>
                                    <div class="body-part">
                                        <h3 class="pl- m-0">Payments & Checkout</h3>
                                        <p style="font-size: 12px" class="p-0 text-muted">Manage Your Store's Payment Info</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 bg-grey-100 mb-5">
                                <a href="email-subscriptions" class="d-flex align-items-center">
                                    <div class="settings-icon-card">
                                        <span class="icon-envelope"></span>
                                    </div>
                                    <div class="body-part">
                                        <h3 class="pl- m-0">Notifications</h3>
                                        <p style="font-size: 12px" class="p-0 text-muted">All customers subscribed to your newsletter..</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 bg-grey-100 mb-5">
                                <a href="shipping-fees.php" class="d-flex align-items-center">
                                    <div class="settings-icon-card">
                                        <span class="icon-map"></span>
                                    </div>
                                    <div class="body-part">
                                        <h3 class="pl- m-0">Shipping & Delivery</h3>
                                        <p style="font-size: 12px" class="p-0 text-muted">All customers subscribed to your newsletter..</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 bg-grey-100 mb-5">
                                <a id="legalControl" class="d-flex align-items-center">
                                    <div class="settings-icon-card">
                                        <span class="icon-folder-alt"></span>
                                    </div>
                                    <div class="body-part">
                                        <h3 class="m-0">Legal</h3>
                                        <p style="font-size: 12px" class="p-0 text-muted">Edit/Manage Your Store's Page Contents e.g (FAQs, Return Policies...)</p>
                                    </div>
                                </a>
                                <div class="collapse m-5 pl-5" id="legalCollapse">
                                    <div>
                                        <a href="terms-use" class="p-3" style="font-size: 15px;color: #444;background-color: #e3e3e3;">- Terms & Conditions</a>
                                        <a href="privacy-policy" class="p-3" style="font-size: 15px;color: #444;background-color: #e3e3e3;">- Privacy Policy</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php require_once "includes/footer.php"; ?>
<!-- END FOOTER -->
<!-- BEGIN QUICK NAV -->
<?php //require_once "includes/quick-nav.php"; ?>
<!-- END QUICK NAV -->
<?php require_once "includes/scripts.php"; ?>
<script>
    $(document).ready(function () {
        $("#legalControl").click(function (){
            var legalControlcollapse = document.querySelector("#legalCollapse");
            var x = Array.from(legalControlcollapse.classList);
            if(x.includes("show")) {
                legalControlcollapse.classList.remove("show");
            }else legalControlcollapse.classList.add("show");
        })
    })
</script>
</body>
</html>
