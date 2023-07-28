<?php
require_once '../core/init.php';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM members WHERE email='{$email}'";
    $query = selectQuery($sql);
    while ($row=mysqli_fetch_assoc($query)) {
        $activity = "Attempted account login.";
        createLog(getUserInfo($email, "id"), $activity);
        if($row['user_status'] == 2) {
            $activity = "Login failed because account is blocked.";
            createLog(getUserInfo($email, "id"), $activity);
            $_SESSION['login_error'] = $activity.' Please contact us through your registered email address to resolve issues.';
            header("Location: {$GLOBALS['path']}login");
            exit;
        }
        $hash = $row['password'];
        $slug = $row['email_slug'];
        $roles = $row['roles'];
        $fname = $row['fname'];
        $id = $row['id'];
        $email = $row['email'];
    }

    if(mysqli_num_rows($query)>0) {
        if(!password_verify($password, $hash)) {
            $activity = "Login failed because of incorrect password.";
            createLog(getUserInfo($email, "id"), $activity);
            $_SESSION['login_error'] = "Email or password is incorrect!";
            header("Location: {$GLOBALS['path']}login");
        }else {
            $user = array($slug, $roles, $fname, $hash);
            $_SESSION['xservico_slug'] = $user;

            // send email
            $date = date("Y-m-d H:i:s");
            $subject = "Login Alert!";
            $message = "Dear {$fname},<br><br>You have successfully logged in to your account at {$date}.<br><br>Xservico Team.";
            sendEmail($email, $subject, $message);

//            redirect to url
            $redirect = $roles != NULL ? "res/administrator/index" : "res/users/index";
            if($roles != NULL) {
                $x = explode(',', $roles);
                $is_merchant = in_array('7',$x);
                if($is_merchant) {
                    //check subscription
                    $user_id = getUserID($slug);
                    $query3 = selectQuery("select * from subscriptions where user_id = '$user_id' and (pending = '$email' or pending is null)");
                    $subscription = mysqli_fetch_assoc($query3);


                    if(mysqli_num_rows($query3)>0) {
                        //check if subscription still valid
                        $now = time();
                        $x = new DateTime(date("Y-m-d", strtotime($subscription['date_posted'])));
                        $x->modify("+".$subscription['days_due']." day");
                        $y = $x->format("Y-m-d H:i:s");
                        $next_due = strtotime($y);
                        $datediff = $next_due - $now;
                        $diff = round($datediff / (60 * 60 * 24));

                        if($diff <= 0) {
                            $_SESSION['login_error'] = "Merchant Subscription has expired. <a href='{$GLOBALS['path']}renew-plan?m={$slug}'>CLick here to renew</a>";
                            header("Location: {$GLOBALS['path']}login");
                            exit;
                        }else {
                            if($diff >=0 && $diff <= 5) {
                                $_SESSION['login_info_message'] = $diff." more days till subscription expires <a style='color: black' href='{$GLOBALS['path']}renew-plan?m={$slug}'>Click here to renew</a>";
                            }
                        }
                    }else {
                        $_SESSION['login_error'] = "Merchant Subscription has expired. <a href='{$GLOBALS['path']}renew-plan?m={$slug}'>Click here to renew</a>";
                        header("Location: {$GLOBALS['path']}login");
                        exit;
                    }
                }
            }
            $activity = "Logged in to account.";
            createLog(getUserID($_SESSION['xservico_slug'][0]), $activity);
            if(isset($_SESSION['previous_location'])) {
                header("Location: {$_SESSION['previous_location']}");
                unset($_SESSION['previous_location']);
            }else {
                header("Location: {$GLOBALS['path']}{$redirect}");
            }
            exit;
        }
    }else {
        $_SESSION['login_error'] = "Username or password is incorrect!";
        if(isset($_SESSION['xservico_slug'])){unset($_SESSION['xservico_slug']);}
        header("Location: {$GLOBALS['path']}login");
        exit;
    }
}elseif (isset($_POST['signup'])){
    $email = $_POST['email'];
    $terms_use = $_POST['terms_use'];
    if(isset($_POST['terms_use']) && $_POST['terms_use'] == '1') {
        $merchant = isset($_POST['merchant']) ? $_POST['merchant'] : null;
//        echo $merchant;
        $query = selectQuery("select * from members where email='$email' and (user_status='0' or user_status='1' or user_status='2' or user_status='4')");
        if(mysqli_num_rows($query)>0) {
            $_SESSION['error'] = "Sorry, email already taken";
            header("Location: {$GLOBALS['path']}signup");
        }else{
            $password1 = $_POST['password'];
            $password2 = $_POST['c_password'];
            if($password1!=$password2) {
                $_SESSION['error'] = "Error! Passwords Dont Match.";
                header("Location: {$GLOBALS['path']}signup");
            }else{
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $phone = $_POST['phone'];
                $user_status = $merchant == 1 ? "4": "1";
                $hash = password_hash($password1, PASSWORD_BCRYPT);;
                $email_slug = password_hash($email, PASSWORD_BCRYPT);;
                $date = date("Y-m-d H:i:s");

                otherQuery("insert into members (fname, lname, email, phone, password, email_slug,user_status, date_registered, date_modified) values ('$fname','$lname','$email','$phone','$hash','$email_slug','$user_status','$date','$date')");

                // send Mail
                $subject = "Welcome to Xservico Store.";
                $message = "Congratulations on your successful registration on our platform. You can now login to continue shopping with us.<br><br>Xservico Team.";
                sendEmail($email, $subject, $message);
                if($merchant==1){
                    $user_id = getUserID($email_slug);
                    otherQuery("update subscriptions set user_id = '$user_id', pending = null where pending = '$email'");
                    // send Mail 2 for merchant
                    $subject = "Xservico Store Merchant Registration.";
                    $message = "Your Request to signup as a merchant on our platform is being processed, A mail will be sent to you within the next 24hrs.<br><br>Xservico Team";
                    sendEmail($email, $subject, $message);

                    $query2 = selectQuery("select * from members where roles = '1'");
                    $row = mysqli_fetch_assoc($query2);
                    $admin_email = $row['email'];
                    // send Mail to Admin
                    $subject = "New Merchant Account.";
                    $message = "A new merchant account request has been placed, check admin dashboard to manage actions<br><br><a href='https://xservico.com/login'>Click here</a>";
                    sendEmail($admin_email, $subject, $message);
                }

                $activity = "Account created.";
                createLog(getUserInfo($email, "id"), $activity);
                $_SESSION['success'] = "Your registration was successful! <a href='login'>Login</a> to continue.";
                header("Location: {$GLOBALS['path']}signup");
            }
        }
    }else {
        $_SESSION['error'] = "Please Accept Terms And Policies";
            header("Location: {$GLOBALS['path']}signup");
    }
}elseif(isset($_SESSION['xservico_slug'][0]) && isset($_SESSION['xservico_slug'][2]) && isset($_SESSION['xservico_slug'][3])){
    // sessions are still active and accurate
    $query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}' and fname = '{$_SESSION['xservico_slug'][2]}' and password = '{$_SESSION['xservico_slug'][3]}' and (user_status = '1' or user_status = '4')");
    // credentials don't match
    if(mysqli_num_rows($query)==0){
        // unset user sessions
        unset($_SESSION['xservico_slug']);
        $_SESSION['login_error'] = "Please login again to continue!";
        header("Location: {$GLOBALS['path']}login");
        exit;
    }
    // else session is active and accurate
    // PROCEED TO CURRENT PAGE


}else{
    if(isset($_SESSION['xservico_slug'])){unset($_SESSION['xservico_slug']);}
    header("Location: {$GLOBALS['path']}login");
    exit;
}