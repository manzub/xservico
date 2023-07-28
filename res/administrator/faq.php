<?php
require_once "../../core/init.php";
require_once "../../core/bookmark.php";
require_once 'validation.php';

validateAdmin('1,6');

$query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}'");
while($row=mysqli_fetch_assoc($query)) {
    $admin_id = $row['id'];
    $acct_password = $row['password'];
}

if(isset($_POST['delete']) && isset($_GET['m'])){
    otherQuery("delete from faq where id = '{$_GET['m']}'");
    $success = "FAQ was deleted successfully!";
}

if(isset($_POST['update']) && isset($_GET['m'])) {
    $activity = "Attempted updating user information.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);

    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");
    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else{
        otherQuery("update faq set question='$question', answer='$answer', date_posted='$date' where id='{$_GET['m']}'");
        $activity = "FAQ update was successful.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $success = "FAQ was updated successfully!";
    }
}

if(isset($_POST['submit'])) {
    $activity = "Attempted posting new faq.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

    if(!password_verify($password, $acct_password)) {
        $activity = "Creation failed due to wrong password.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $error = "Sorry, your password is incorrect!";
    }else{
        otherQuery("insert into faq (question, answer, date_posted) values ('$question','$answer','$date')");
        $activity = "FAQ posting was successful.";
        createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
        $success = "New FAQ was posted successfully!";
    }
}

if(isset($_GET['m'])){
    $id = $_GET['m'];
    $query = selectQuery("select * from faq where id = '$id'");
    while($row=mysqli_fetch_assoc($query)){
        $question = $row['question'];
        $answer = $row['answer'];
    }

    if(mysqli_num_rows($query)==0){
        header("Location: faq");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>FAQ | Xservico Online Store</title>
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
            <h1 class="page-title"> FAQ</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index">Account</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>FAQ</span>
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
                                <span class="caption-subject bold uppercase"> Manage FAQ Information</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <?php if(isset($_GET['m'])){ ?>
                                <h4>Edit FAQ</h4>
                                <form action="" method="post" role="form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Question <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-question-circle"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" placeholder="Question" required="" value="<?php echo htmlentities($question); ?>" name="question">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Answer <span class="required">*</span></label>
                                        <textarea name="answer" data-provide="markdown" placeholder="Answer" rows="10" data-error-container="#editor_error"><?php echo $answer; ?></textarea>
                                        <div id="editor_error"> </div>
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
                                    <div class="form-actions">
                                        <button type="submit" name="update" class="btn blue">Update</button>
                                        <button type="submit" onclick="return confirm('Confirm delete?');" name="delete" class="btn red">Delete</button>
                                        <a href="faq"><button type="button" class="btn default">Cancel</button></a>
                                    </div>
                                </form>
                            <?php }else{ ?>
                                <h4>Upload New FAQ</h4>
                                <form action="" method="post" role="form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Question <span class="required">*</span></label>
                                            <div class="input-group">
                                                    <span class="input-group-addon input-circle-left">
                                                        <i class="fa fa-question-circle"></i>
                                                    </span>
                                                <input type="text" class="form-control input-circle-right" placeholder="Question" required="" name="question">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Answer <span class="required">*</span></label>
                                        <textarea name="answer" data-provide="markdown" placeholder="Answer" rows="10" data-error-container="#editor_error"></textarea>
                                        <div id="editor_error"> </div>
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
                                    <div class="form-actions">
                                        <button type="submit" name="submit" class="btn blue">Submit</button>
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
                    <h4>All FAQs</h4>
                    <table id="myTable" class="list table table-striped" style="padding-top: 20px;">
                        <thead>
                        <th>S/N</th>
                        <th>QUESTION</th>
                        <th>POSTED</th>
                        <th>ACTION</th>
                        </thead>
                        <?php echo allFAQs(); ?>
                    </table>
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
