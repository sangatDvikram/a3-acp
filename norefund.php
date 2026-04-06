<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="windows-1252">
    <title>A3 Ultimate - Refund Policy</title>
<?php include 'header.php'; ?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <!--<div class="span3">
              <?php //include 'side_bar.php';?>
            </div> Menu -->
              <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			  		<h1>A3 Ultimate :<span style='color:#B60404;text-shadow: 1px 1px 3px #E55E5E;font-family:Calibri;font-size:32px'>Refund Policy</span></h1></div>


<div class="alert alert-info" style='font-family:Calibri;font-size:18px'>
<br>
1.We would like to be happy with your purchase/Donation to the website. However, before placing your order, please read our terms regarding our Returns and Cancellation Policy relating to digital products.
<br><br>
2.Digital products are non-returnable and non-refundable. Therefore, we regret that once the Premium Coins has been purchased by you, your order may not be cancelled or refunded. However, you experience any difficulty within the process, then help is available (please check your email for our support contact details as you buy any premium coins.)
<br><br>
3.We do not accept any requests for refunds. 
<br><br>



</div><!-- Main -->
</div><!-- Main -->
</div><!-- Cointainer -->
<hr>
<?php include('browser.php'); 
$ua=getBrowser();
 $ip=$_SERVER['REMOTE_ADDR'];
?>
<div class="row-fluid" align="center">
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your IP:&nbsp;&nbsp;  <i>  <?php echo getRealIpAddr();?> </i></p></div>
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your Browser:<i>&nbsp;&nbsp;<?php echo $ua['name'] . " " . $ua['version'] ;?></i></p></div>
<div class="span4"><p style="margin:0; padding:0 ;text-align:center">Visitor Counter : <i>&nbsp;&nbsp;<?php echo $_country; ?></i></p></div>

</div><!-- details -->
</div> <!-- /container fluid-->
<?php include 'footer.php';?>