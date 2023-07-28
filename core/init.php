<?php

session_start();
error_reporting(E_ALL);
date_default_timezone_set('Africa/Lagos');
$_SESSION['is_dev_admin'] = true;
require_once 'connection/database.php';
require_once 'functions/func.basic.php';