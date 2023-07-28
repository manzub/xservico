<?php
require 'core/init.php';
if(isset($_SESSION['is_dev_admin'])) {
    header("Location: {$GLOBALS['path']}login");
    exit;
}
?>