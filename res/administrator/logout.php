<?php
require_once "../../core/init.php";

if(isset($_SESSION['xservico_slug'])){
    $activity = "Logged out of account.";
    createLog(getUserID($_SESSION['xservico_slug'][0]), $activity, date("Y-m-d H:i:s"));
    unset($_SESSION['xservico_slug']);
    if(isset($_SESSION['login_info_message'])) {
        unset($_SESSION['login_info_message']);
    }
    // $_SESSION = [];
    // session_destroy();
}
header("Location: {$GLOBALS['path']}index");
exit;