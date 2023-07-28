<?php

require 'core/init.php';
if(isset($_SESSION['xservico'])) {
    header("Location: res/users/index");
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
    <title>User Sign Up - Xservico Online Store</title>
    <?php require_once "includes/bottom-styles.php"; ?>
</head>
<body>

<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START MAIN SECTION -->
    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="text-center heading_s1">
                                <h3>Create An Account</h3>
                            </div>
                            <?php if (isset($_SESSION['success'])){ ?>
                                <div class="alert alert-success text-center"><?php echo $_SESSION['success']; ?></div>
                                <div class="alert alert-warning">If Mail Doesn't Appear Check spam box</div>
                            <?php unset($_SESSION['success']);}elseif(isset($_SESSION['error'])){ ?>
                                <div class="alert alert-danger text-center"><?php echo $_SESSION['error']; ?></div>
                                <?php unset($_SESSION['error']);} ?>
                            <form action="assist/validation.php" method="post">
                                <input autocomplete="off" name="hidden" style="display: none" type="text">
                                <div class="form-group">
                                    <input type="text" required class="form-control" name="fname" placeholder="Your First Name" />
                                </div>
                                <div class="form-group">
                                    <input type="text" required class="form-control" name="lname" placeholder="Your Last Name" />
                                </div>
                                <div class="form-group">
                                    <input type="text" required class="form-control" name="phone" placeholder="Your Phone Number" />
                                </div>
                                <div class="form-group">
                                    <input id="emailField" type="email" required class="form-control" name="email" placeholder="Your Email" />
                                    <small style="display: none" id="emailFieldErr" class="text-danger">Email Address required</small>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="c_password" placeholder="Confirm Password">
                                </div>
                                <div class="login_footer form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input required="" class="form-check-input" type="checkbox" name="terms_use" id="exampleCheckbox2" value="1">
                                            <label class="form-check-label" for="exampleCheckbox2"><span>I agree to terms &amp; Policy.</span></label>
                                        </div>
                                    </div>
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input onclick="initMerchantSignup()"  class="form-check-input" type="checkbox" name="merchant" id="exampleCheckbox3" value="1">
                                            <label class="form-check-label" for="exampleCheckbox3"><span>Sign Up As Merchant.</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div id="payment-card" class="form-group" style="display: none">
                                    <script src="https://www.paypal.com/sdk/js?client-id=AW7KOjM-gvEc1IbpV-lLZW_RgNfbr53p6g3z05FzmomQUv7CL2LW5m5alrkAta-O4AD9A7MMTJnIMIa8"> // Replace YOUR_CLIENT_ID with your sandbox client ID
                                    </script>
                                    <input style="visibility: hidden" value="<?php echo $merchant_fees?>" id="paypal-button-amount" >
                                    <p style="visibility: hidden" id="converted_val"></p>
                                    <div id="paypal-button-container"></div>
                                </div>
                                <div class="form-group">
                                    <button id="submit-register-form" type="submit" class="btn btn-fill-out btn-block" name="signup">Sign Up</button>
                                </div>
                                <div class="form-note text-center">Already have an account? <a href="<?php echo $GLOBALS['path']; ?>login">Log in</a></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN SECTION -->

</div>
<!-- END MAIN CONTENT -->
<!-- END MAIN CONTENT -->

<?php require_once "includes/scripts.php";  ?>
<script>
    $(document).ready(function(){$.ajax({url:"https://free.currconv.com/api/v7/convert?q=USD_NGN&compact=ultrra&apiKey=641aae8ed46482b4b1db",type:"GET",success:function(e){let t=e.results.USD_NGN.val,a=document.querySelector("#paypal-button-amount").value,r=parseInt(a)/parseInt(t);document.querySelector("#converted_val").innerHTML=parseFloat(r).toFixed(2)}})});
</script>
<script>
    function initMerchantSignup(){var e=document.querySelector("#exampleCheckbox3"),r=document.querySelector("#emailField");if(""==r.value)document.querySelector("#emailFieldErr").style.display="block",e.checked=!1;else if(e.checked){if(confirm("Are you sure")){document.querySelector("#payment-card").style.display="block",document.querySelector("#submit-register-form").setAttribute("disabled","true");let e=document.querySelector("#converted_val");console.log(r.value),paypal.Buttons({createOrder:function(r,t){return t.order.create({purchase_units:[{amount:{value:e.innerHTML}}]})},onApprove:function(e,t){return t.order.capture().then(function(e){alert("Transaction completed by "+e.payer.name.given_name),document.querySelector("#submit-register-form").removeAttribute("disabled");const t=document.getElementById("paypal-button-container");t.innerHTML="",t.innerHTML="<h3>Thank you for your payment!</h3>",$.ajax({url:"assist/event_handling.php?m-trnx&type=paypal-trnx-merchant=sb&pr1="+e.payer.email_address+"&pr2="+r.value,type:"GET",success:function(e){t.innerHTML+="<p>Click below to Complete signup process</p>"}})})},onError:function(e){console.log(e)}}).render("#paypal-button-container")}}else document.querySelector("#submit-register-form").removeAttribute("disabled")}
</script>

</body>
</html>
