<!DOCTYPE html>

<?php include '../header.php'; 
?>
    <div class="container-fluid">
     
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>PayPal Donate: Success</h1></div>
       
	
     <center>
	 <div class='alert alert-success'> <h4><?php if(isset($_SESSION['gross'])){ echo $coins=($_SESSION['gross']*54);}?> Premium coins bought succssfully!!</h4>
	 Thank you for donating server.<br>
	 </div>
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
