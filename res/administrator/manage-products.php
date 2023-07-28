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

if(isset($_POST['delete']) && isset($_GET['m'])){
    $query = selectQuery("select * from prod_images where prod_id = '{$_GET['m']}'");
    while($row=mysqli_fetch_assoc($query)){
        if(!unlink($row['image'])){
            echo "error deleting file!";
        }
    }
    otherQuery("delete from prod_images where prod_id = '{$_GET['m']}'");
    otherQuery("delete from prods where id = '{$_GET['m']}'");
}

if(isset($_POST['update']) && isset($_GET['m'])) {
    $activity = "Attempted updating product information.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);

    $title = $_POST['title'];
    $cat_id = $_POST['prod_cat'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $discounted_price = isset($_POST['discounted_price']) && is_numeric($_POST['discounted_price'])?$_POST['discounted_price']:0.00;
    $query = selectQuery("select * from prods where id = '{$_GET['m']}'");
    $row=mysqli_fetch_assoc($query);
    $images = $row['images'];
    $quantity = 0;
    $quantity=isset($_POST['update_qty'])?$row['quantity']+intval($_POST['update_qty']):$row['quantity'];
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
    $deal_stop_date = !empty($_POST['deal_stop_date']) && $deal=="1" ? "'$deal_date'" :  'NULL';
    $status=$images==0?"0":$_POST['status'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else {
        $query = selectQuery("select * from prods where title = '$title' and id <> '{$_GET['m']}'");
        if($deal=="1" && $deal_stop_date==null){
            $activity = "Update failed due to missing deal end date.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $error = "Cannot set Deal without end date, Deal end date must be set!";
        }else{
            otherQuery("update prods set title='$title', cat_id='$cat_id', brand_id='$brand', price='$price', discounted_price='$discounted_price', quantity='$quantity', brief='$brief', warranty='$warranty', return_policy='$return_policy', pay_on_delivery='$pay_on_delivery', tags='$tags', description='$description', additional_info='$additional_info', featured='$featured', special_offer='$special_offer', deal='$deal', deal_start_level='$stock_level', deal_stop_date='$deal_stop_date', status='$status', date_modified='$date' where id = '{$_GET['m']}'");

            $activity = "Update was successful.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            $success = $images==0 && $_POST['status']=="1"?"Update was successful but product cannot be published until you add at least one image!":"Product updated successfully!";
        }
    }
}


if(isset($_GET['m'])){
    $id = $_GET['m'];
    $query = selectQuery("select * from prods where id = '$id'");
    while($row=mysqli_fetch_assoc($query)){
        $title = $row['title'];
        $slug = $row['slug'];
        $cat_id = $row['cat_id'];
        $brand_id = $row['brand_id'];
        $price = $row['price'];
        $discounted_price = $row['discounted_price'];
        $quantity = $row['quantity'];
        $brief = $row['brief'];
        $warranty = $row['warranty'];
        $return_policy = $row['return_policy'];
        $pay_on_delivery = $row['pay_on_delivery'];
        $tags = $row['tags'];
        $description = htmlentities($row['description']);
        $additional_info = htmlentities($row['additional_info']);
        $featured = $row['featured'];
        $special_offer = $row['special_offer'];
        $deal = $row['deal'];
        $deal_stop_date = $row['deal_stop_date'];
        $product_code = $row['product_code'];
        $status = $row['status'];
    }

    if(mysqli_num_rows($query)==0){
        header("Location: manage-products");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Manage Products | Xservico Online Store</title>
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
            <h1 class="page-title"> Manage Products
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Manage Products</span>
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
                                <h4>Edit Product</h4>
                                <form action="" method="post" role="form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Product Title <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" value="<?php echo htmlentities($title); ?>" placeholder="Product Title" name="title" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Slug</label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" readonly class="form-control input-circle-right" value="<?php echo htmlentities($slug); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Code</label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" readonly class="form-control input-circle-right" value="<?php echo htmlentities($product_code); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Category <span class="required">*</span></label>
                                            <select name="prod_cat" required="" class="form-control input-circle">
                                                <optgroup>
                                                    <?php echo updateProdCategories($cat_id); ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Brand <span class="required">*</span></label>
                                            <select name="brand" required="" class="form-control input-circle">
                                                <optgroup>
                                                    <?php echo updateBrands($brand_id); ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Price <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-dollar"></i>
                                                    </span>
                                                <input type="number" class="form-control input-circle-right" value="<?php echo htmlentities($price); ?>" placeholder="Price" name="price" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Discounted Price <sub>(optional)</sub></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-dollar"></i>
                                                    </span>
                                                <input type="number" class="form-control input-circle-right" value="<?php echo htmlentities($discounted_price); ?>" placeholder="Discounted Price" name="discounted_price">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-sort-numeric-asc"></i>
                                                    </span>
                                                <input type="number" class="form-control input-circle-right" value="<?php echo htmlentities($quantity); ?>" placeholder="Quantity" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Update Stock <sub>(optional)</sub></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-sort-numeric-asc"></i>
                                                    </span>
                                                <input type="number" class="form-control input-circle-right" placeholder="Update Quantity" name="update_qty">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Brief Info <span class="required">*</span></label>
                                            <textarea class="form-control" required="" name="brief" placeholder="Brief" rows="2"><?php echo htmlentities($brief); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Warranty <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" value="<?php echo htmlentities($warranty); ?>" placeholder="Warranty" name="warranty" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Return Policy <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" value="<?php echo htmlentities($return_policy); ?>" placeholder="Return Policy" name="return_policy" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Pay on Delivery <span class="required">*</span></label>
                                            <select name="pay_on_delivery" required="" class="form-control">
                                                <optgroup>
                                                    <option <?php if($pay_on_delivery=="Yes"){echo "selected";} ?>>Yes</option>
                                                    <option <?php if($pay_on_delivery=="No"){echo "selected";} ?>>No</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tags <sub>optional (press enter after each entry)</sub></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-text-width"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" value="<?php echo htmlentities($tags); ?>" data-role="tagsinput" placeholder="Tags" name="tags">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Long Desciption <span class="required">*</span></label>
                                            <textarea class="ckeditor form-control" name="description" rows="6" data-error-container="#editor_error"><?php echo $description; ?></textarea>
                                            <div id="editor_error"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Additional Info <span class="required">*</span></label>
                                            <textarea class="ckeditor form-control" name="additional_info" rows="6" data-error-container="#editor2_error"><?php echo $additional_info; ?></textarea>
                                            <div id="editor2_error"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Featured <span class="required">*</span></label>
                                            <select name="featured" required="" class="form-control">
                                                <optgroup>
                                                    <option <?php if($featured=="1"){echo "selected";} ?> value="1">Yes</option>
                                                    <option <?php if($featured=="0"){echo "selected";} ?> value="0">No</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Special Offer <span class="required">*</span></label>
                                            <select name="special_offer" required="" class="form-control">
                                                <optgroup>
                                                    <option <?php if($special_offer=="1"){echo "selected";} ?> value="1">Yes</option>
                                                    <option <?php if($special_offer=="0"){echo "selected";} ?> value="0">No</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Deal of the Day <span class="required">*</span></label>
                                            <select name="deal" required="" class="form-control">
                                                <optgroup>
                                                    <option <?php if($deal=="1"){echo "selected";} ?> value="1">Yes</option>
                                                    <option <?php if($deal=="0"){echo "selected";} ?> value="0">No</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Deal End Date <sub>(optional)</sub></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                <input type="date" class="form-control input-circle-right" placeholder="Deal End Date" value="<?php echo $deal_stop_date; ?>" name="deal_stop_date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Status <span class="required">*</span></label>
                                            <select name="status" required="" class="form-control">
                                                <optgroup>
                                                    <option <?php if($status=="1"){echo "selected";} ?> value="1">Published</option>
                                                    <option <?php if($status=="0"){echo "selected";} ?> value="0">Draft</option>
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
                                        <a href="upload-product-image?x=<?php echo $id; ?>"><button type="button" class="btn default">View Images</button></a>
                                        <button type="submit" onclick="return confirm('Confirm delete?');" name="delete" class="btn red">Delete</button>
                                        <a href="manage-products"><button type="button" class="btn default"><span class="fa fa-long-arrow-left"></span> Back</button></a>
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
                        <h4>All Products</h4>
                        <div class="table-scrollable">
                            <table id="myTable" class="list table table-striped" style="padding-top: 20px;">
                                <thead>
                                <th>POSTED</th>
                                <th>TITLE</th>
                                <th>CODE</th>
                                <th>CATEGORY</th>
                                <th>BRAND</th>
                                <th>QTY</th>
                                <th>IMAGES</th>
                                <th>STATUS</th>
                                <th>MODIFIED</th>
                                <th>ACTION</th>
                                <th>SLUG</th>
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
            "order": [[ 0, 'desc' ]],
            "processing": true,
            "serverSide": true,
            "ajax": "../../core/functions/products-processing.php",
            "searching": { "regex": true },
            "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, -1], [10, 25, 50, 100, 200, 500, 1000, "All"] ],
            "pagingType": "full",
            "columnDefs": [
                {
                    "render": function ( data, type, row ) {
                        var x = "<a href='upload-product-image?x="+ row[10] +"'>Upload</a>";
                        if(data>0){
                            x = data + " - " + x;
                        }
                        return x;
                    },
                    "targets": 6
                },
                { "visible": false,  "targets": [ 10 ] }
            ],
        } );
    });
</script>
