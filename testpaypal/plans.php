<?php
/***************** websyntax.blogspot.com **************************/
/*****************      Paypal IPN      * **************************/
/**********for questions email me at falconerie.04@gmail.com *******/
include '../inc/config.php';
include '../inc/secondary_functions.php';
$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; 
$paypal_id=getenv('PAYPAL_EMAIL'); //////you must create your own sandbox, replace this.///////////
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Donate</title>
	<?php include '../header-acp.php'; 
?>
	<script language="javascript">
	$(document).ready(function()
  {
	 $('#coins').load('/Stats/coins.php?randval='+ Math.random());
	//ajaxTime.php is called every second to get time from server
   var refreshId = setInterval(function() 
   {
		 $('#coins').load('/Stats/coins.php?randval='+ Math.random());
	}, 30000);
  });
function check_r_stats(){
	var a=$(".amount").val();
	if (a.match(/^\d+$/)) {
   var e=a/50;
   
}  else if (number.match(/^\d+*\.\d+$/)) {
var e=a/50;
}
else if(a==''){var e=0;}
else{var e=0;}
var c=Math.round(e * 100)/100;
 $(".amount_paypal").attr("value", c);
	$("#totalcoins").html('<br>Total cost will be:: $<b><i>'+c+'</i></b> USD');
	}
	
</script>

    <div class="container-fluid">
     
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>PayPal Donate:
</h1></div>
       
	
     <center>
                <form action='<?php echo $paypal_url; ?>' method='post' name='frmPayPal1' target="_blank"><!-- found on top -->
					
                    <input type='hidden' name='business' value='<?php echo $paypal_id;?>'> <!-- found on top -->
                    <input type='hidden' name='cmd' value="_xclick">
					<input type='hidden' name='image_url' value='/images/1.png'> <!-- logo of your website -->
					<input type="hidden" name="rm" value="2" /> <!--1-get 0-get 2-POST -->
                    <input type='hidden' class="name" name='item_name' value='A3 Ultimate Premium Coins'>
					<input type="hidden" name="business" value="<?php echo htmlspecialchars(getenv('PAYPAL_EMAIL')); ?>">
                    <input type='hidden' name='item_number' value='<?php echo GenKey();?>'>
					<span id='coins'></span>
					<div class="input-prepend">
      <span class="add-on"><i class="icon-gift" title="Enter required premiumcoins"></i></span>
      <input class="span12 amount" id="inputIcon" type="text" required pattern="[0-9]+" maxlength="7" size="25" value='' placeholder="Enter required premiumcoins" onkeyup="check_r_stats()" validationMessage="Please enter a number only">
    </div>

  <input class="span8 amount_paypal" type='hidden'  name='amount' value=''> 
  <span class="muted" id="totalcoins"></span>
  <br>
<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donateCC_LG.gif" border="0"  type="submit" name="submit" alt="PayPal – The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
				<input type='hidden' name='no_shipping' value='1'>
					<input type='hidden' name='no_note' value='1'>
					<input type='hidden' name='handling' value='0'>
                    <input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="cbt" value="Return to the hub">
					<input type="hidden" name="bn" value="PP-BuyNowBF">
                    <input type='hidden' name='cancel_return' value='/testpaypal/cancel.php'>
                    <input type='hidden' name='return' value='/testpaypal/success.php'>
					<input type="hidden" name="notify_url" value="/testpaypal/ipn.php" /> 
                    
                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					<input type="hidden" name="custom" value='<?php echo $_SESSION['username']; ?>'><!-- custom field -->
                </form>
			</center>
 </div><!-- Main -->
</div><!-- Cointainer -->
<hr>
<?php include('../browser.php'); 
$ua=getBrowser();
 $ip=$_SERVER['REMOTE_ADDR'];
?>
<div class="row-fluid" align="center" class="form-inline">
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your IP:&nbsp;&nbsp;  <i>  <?php echo getRealIpAddr();?> </i></p></div>
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your Browser:<i>&nbsp;&nbsp;<?php echo $ua['name'] . " " . $ua['version'] ;?></i></p></div>
<div class="span4"><p style="margin:0; padding:0 ;text-align:center">Visitor Counter : <i>&nbsp;&nbsp;<?php echo $_country; ?></i></p></div>

</div><!-- details -->
</div> <!-- /container fluid-->
<?php include '../footer.php';?>
