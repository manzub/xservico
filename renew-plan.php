<?php
require 'core/init.php';

if(!isset($_GET['m']) || !getUserID($_GET['m'])) {
    header("Location: {$GLOBALS['path']}");
    exit;
}

$query = selectQuery("select * from others where type='merchant_fees'");
$row = mysqli_fetch_assoc($query);
$merchant_fees = $row['value'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/top-styles.php"; ?>
    <title>Renew Subscription - Xservico Online Store</title>
    <?php require_once "includes/bottom-styles.php"; ?>
</head>
<body>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
</head>

<body>

<div class="container mt-5">
    <div class="text-center heading_s1 mb-5">
        <h2 class="title">Renew Merchant Subscription</h2>
        <p>Amount #<?php echo $merchant_fees; ?></p>
    </div>
    <input style="visibility: hidden" value="<?php echo $merchant_fees?>" id="paypal-button-amount" >
    <input style="visibility: hidden" value="<?php echo $_GET['m'] ?>" id="email-slug">
    <p style="visibility: hidden" id="converted_val"></p>
    <div id="smart-button-container">
        <div style="text-align: center;">
            <div id="paypal-button-container"></div>
        </div>
    </div>
</div>


<?php require_once "includes/scripts.php";  ?>
<script>
    $(document).ready(function(){$.ajax({url:"https://free.currconv.com/api/v7/convert?q=USD_NGN&compact=ultrra&apiKey=641aae8ed46482b4b1db",type:"GET",success:function(e){let t=e.results.USD_NGN.val,a=document.querySelector("#paypal-button-amount").value,r=parseInt(a)/parseInt(t);document.querySelector("#converted_val").innerHTML=parseFloat(r).toFixed(2)}})});
</script>
<script src="https://www.paypal.com/sdk/js?client-id=AW7KOjM-gvEc1IbpV-lLZW_RgNfbr53p6g3z05FzmomQUv7CL2LW5m5alrkAta-O4AD9A7MMTJnIMIa8" data-sdk-integration-source="button-factory"></script>
<script>
    function initPayPalButton() {
        let str = document.querySelector("#converted_val");
        let r = document.querySelector("#email-slug");
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'paypal',

            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{"amount":{"currency_code":"USD","value":str.innerHTML}}]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    // Full available details
                    // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                    // Show a success message within this page, e.g.
                    const element = document.getElementById('paypal-button-container');
                    element.innerHTML = '';
                    element.innerHTML = '<h3>Thank you for your payment!</h3>';

                    // Or go to another URL:  actions.redirect('thank_you.html');
                    $.ajax({
                        url: "assist/event_handling.php?m-trnx&type=paypal-trnx-merchant=sb&pr1="+orderData.payer.email_address+"&slug="+r.value,
                        type:'GET',
                        success: function (data) {
                            element.innerHTML += "<p>GO Back to Login <a href='/login'>Click here</a></p>";
                        }
                    })
                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    initPayPalButton();
</script>
</body>
</html>

</body>