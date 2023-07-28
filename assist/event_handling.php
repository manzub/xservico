<?php

require_once "../core/init.php";

$query = selectQuery("select * from members where roles = 1");
$row1 = mysqli_fetch_assoc($query);
$admin_id = $row1['id'];

if(isset($_GET['m-trnx'])) {
    $query = selectQuery("select * from others where type='merchant_fees'");
    $row = mysqli_fetch_assoc($query);
    $merchant_fees = $row['value'];

    $type = $_GET['type'];
    if($type == 'paypal-trnx-merchant') {

        $bank_name = $_GET['pr1'];
        $acct_name = $_GET['pr2'];
        $acct_number = 'merchant-fees';
        $amount = $merchant_fees;
        $method = 'paypal-checkout-merchant-fees';
        $orderid = 'paypal-checkout-merchant-account-fees';
        $date = date('Y-m-d H:i:s');

        // log new payment
        createLog($admin_id, "Payment - Merchant Account");
        otherQuery("insert into payments(order_id, method, amount, bank_name, acct_name, acct_number, date_posted, date_modified) values ('$orderid','$method','$amount','$bank_name','$acct_name','$acct_number','$date','$date')");

        // add to subscriptions
        $today = $date;
        $due_days = "31";
        $due_date_str = new DateTime("now");
        $due_date_str->modify("+".$due_days." day");
        $due_date = $due_date_str->format("Y-m-d H:i:s");
        // create encryption
        $hash = md5("".$due_date."--".$today);
        // create new subscription
        otherQuery("insert into subscriptions(type, days_due, date_posted, date_enc, pending) values ('$acct_number', '$due_days','$today','$hash','$acct_name')");



        echo "success";
    }elseif ($type = 'paypal-trnx-merchant-renew') {
        $bank_name = $_GET['pr1'];
        $acct_name = $_GET['pr2'];
        $acct_number = 'merchant-fees-renew';
        $amount = $merchant_fees;
        $method = 'paypal-checkout-merchant-fees-renew';
        $orderid = 'paypal-checkout-merchant-account-fees-renew';
        $slug = $_GET['slug'];
        $date = date('Y-m-d H:i:s');
        $userid = getUserID($slug);

        // log new payment
        createLog($admin_id, "Payment - Merchant Account");
        otherQuery("insert into payments(order_id, method, amount, bank_name, acct_name, acct_number, date_posted, date_modified) values ('$orderid','$method','$amount','$bank_name','$acct_name','$acct_number','$date','$date')");

        // add to subscriptions
        $today = $date;
        $due_days = "31";
        $due_date_str = new DateTime("now");
        $due_date_str->modify("+".$due_days." day");
        $due_date = $due_date_str->format("Y-m-d H:i:s");
        // create encryption
        $hash = md5("".$due_date."--".$today);

        otherQuery("update subscriptions set days_due = '$due_days', date_posted = '$date', date_enc = '$hash' where user_id = '$userid'");
    }
}