<?php
if(isset($_SESSION['xservico_slug'][0]) && isset($_SESSION['xservico_slug'][2]) && isset($_SESSION['xservico_slug'][3])){
    // sessions are still active and accurate
    $query = selectQuery("select * from members where email_slug = '{$_SESSION['xservico_slug'][0]}' and fname = '{$_SESSION['xservico_slug'][2]}' and password = '{$_SESSION['xservico_slug'][3]}' and (user_status = '1' or user_status = '4')");
    // credentials don't match
    if(mysqli_num_rows($query)==0){
        // unset user sessions
        unset($_SESSION['xservico_slug']);
//        store requesting url
        $_SESSION['req_link'] = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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