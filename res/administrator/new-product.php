<?php
require_once "../../core/init.php";
require_once "../../core/bookmark.php";
require_once 'validation.php';

validateAdmin('1,3,7');

$query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}'");
while($row=mysqli_fetch_assoc($query)) {
    $admin_id = $row['id'];
    $acct_password = $row['password'];
    $roles = explode(",",$row['roles']);
}

if(isset($_POST['submit'])) {
    $activity = "Attempted uploading new product.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);

    $title = $_POST['title'];
    $prod_cat = $_POST['prod_cat'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $brief = $_POST['brief'];
    $warranty = $_POST['warranty'];
    $return_policy = $_POST['return_policy'];
    $pay_on_delivery = $_POST['pay_on_delivery'];
    $tags = $_POST['tags'];
    $description = $_POST['description'];
    $additional_info = $_POST['additional_info'];
    $featured = $_POST['featured'];
    $special_offer = $_POST['special_offer'];
    $deal = $_POST['deal'];
    $stock_level=$deal=="1"?$quantity:null;
    $deal_date = $_POST['deal_stop_date'];
    $deal_stop_date = !empty($_POST['deal_stop_date']) && $deal=="1" ? $deal_date :  'NULL';
    $password = $_POST['password'];
    $date_posted = date("Y-m-d H:i:s");

    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else{
        $x=0;$slug="";
        do{
            if($x==0){
                $slug_array = explode(" ", $title);
                $slug = implode("-", $slug_array);
            }elseif($x==1){
                $slug .= "-".$x;
            }else{
                $size = strlen($x-1);
                $slug = substr($slug, 0, -$size);
                $slug .= "-".$x;
            }
            $x++;
            $query = selectQuery("select * from prods  where slug = '{$slug}'");
        }while(mysqli_num_rows($query)>0);
        $product_code = generateProdCode();

        $slug_str = strtolower($slug);
        $query = "insert into prods (title, slug, cat_id, brand_id, price, quantity, brief, warranty, return_policy, pay_on_delivery, tags, description, additional_info, featured, special_offer, deal, deal_start_level, deal_stop_date, product_code, date_posted, date_modified, uploaded_by) values ('$title','$slug_str','$prod_cat','$brand','$price','$quantity','$brief','$warranty','$return_policy','$pay_on_delivery','$tags','$description','$additional_info','$featured','$special_offer','$deal','$stock_level','$deal_stop_date','$product_code','$date_posted','$date_posted','$admin_id')";
        $result = otherQuery($query);

        $activity = "Upload was successful.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $success = "Product posted successfully!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>New Product | Xservico Online Store</title>
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
            <h1 class="page-title"> New Product
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>New Product</span>
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
                            <form action="" method="post" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label>Product Title <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" placeholder="Product Title" name="title" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Category <span class="required">*</span></label>
                                        <select name="prod_cat" required="" class="form-control input-circle">
                                            <optgroup>
                                                <option selected="" disabled="">select category</option>
                                                <?php echo listProdCategories(); ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Brand <span class="required">*</span></label>
                                        <select name="brand" required="" class="form-control input-circle">
                                            <optgroup>
                                                <option selected="" disabled="">select brand</option>
                                                <?php echo listBrands(); ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Price <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-dollar"></i>
                                                    </span>
                                            <input type="number" class="form-control input-circle-right" placeholder="Price" name="price" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Quantity <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-sort-numeric-asc"></i>
                                                    </span>
                                            <input type="number" class="form-control input-circle-right" placeholder="Quantity" name="quantity" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Brief Info <span class="required">*</span></label>
                                        <textarea class="form-control" required="" name="brief" placeholder="Brief" rows="2"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Warranty <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" placeholder="Warranty" name="warranty" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Return Policy <span class="required">*</span></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" placeholder="Return Policy" name="return_policy" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Pay on Delivery <span class="required">*</span></label>
                                        <select name="pay_on_delivery" required="" class="form-control">
                                            <optgroup>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tags <sub>optional (press enter after each entry)</sub></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                            <input type="text" class="form-control input-circle-right" data-role="tagsinput" placeholder="Tags" name="tags">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Long Desciption <span class="required">*</span></label>
                                        <textarea name="description" data-provide="markdown" placeholder="Long Description" rows="10" data-error-container="#editor_error"></textarea>
                                        <div id="editor_error"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Additional Info <span class="required">*</span></label>
                                        <textarea class="ckeditor form-control" name="additional_info" rows="6" data-error-container="#editor2_error"></textarea>
                                        <div id="editor2_error"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Featured <span class="required">*</span></label>
                                        <select name="featured" required="" class="form-control">
                                            <optgroup>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Special Offer <span class="required">*</span></label>
                                        <select name="special_offer" required="" class="form-control">
                                            <optgroup>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Deal of the Day <span class="required">*</span></label>
                                        <select name="deal" required="" class="form-control">
                                            <optgroup>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Deal End Date <sub>(optional)</sub></label>
                                        <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                            <input type="date" class="form-control input-circle-right" placeholder="Deal End Date" name="deal_stop_date">
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
