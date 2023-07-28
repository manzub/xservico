<?php
require_once '../core/init.php';

if(isset($_POST['f-password'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM members WHERE email='$email'";
    $query = selectQuery($sql);
    if(mysqli_num_rows($query)>0) {
        $row = mysqli_fetch_assoc($query);
        $phone = $row['phone'];
        $new_pass = generateUserPassword($phone);
        $message =  "Use this password: \n$new_pass\n\nto login into your account";
        $hash = md5($new_pass);
        otherQuery("update members set password='$hash' where email='$email'");
        sendEmail($email, 'New Password Generated', $message);
        $_SESSION['f_message'] = 'Password has been sent to your email';
        header("Location: {$GLOBALS['path']}forgot-password");
    }else {
        $_SESSION['f_error'] = 'Invalid User Email';
        header("Location: {$GLOBALS['path']}forgot-password");
    }
}else{
    header("Location: {$GLOBALS['path']}");
}