<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3Ultimate - PayPal Payment Details</title>
	
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }
?>
    <div class="container-fluid">
     <div class="page-header" style="margin-top:0;">
 			   <h1>PayPal Payment Details:
</h1></div>
          <div class="row-fluid ">
		  
          <div class="span3">
             <?php include 'side_bar_admin.php' ?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              
	 
             <table class="table table-bordered table-striped table-hover">
	<thead>
    <tr>
      <th>Sr</th>
      <th>Name</th>
      <th>Email</th>
      <th>User ID</th>
      <th>Gross</th>
      <th>Fee</th>
      <th>Net</th>
      <th>Trns. ID</th>
      <th>Trns. Type</th>
    </tr>
  </thead>
  <tbody>
    
	<?php
	$i=1;
	$rs1=odbc_exec($con2,"select * from Transactions order by payment_date desc");
	while($dd = odbc_fetch_array($rs1)) { 
	$net=$dd['mc_gross']-$dd['mc_fee'];
     echo "<tr> <td>$i</td>
      <td>$dd[first_name] $dd[last_name]</td>
      <td>$dd[payer_email]</td>
      <td>$dd[custom_userid]</td>
      <td>$dd[mc_gross]</td>
      <td>$dd[mc_fee]</td>
      <td>$net</td>
      <td>$dd[txn_id]</td>
      <td>$dd[txn_type]</td> </tr>
	  ";
     $i++;
	  }
	  ?>
   
  </tbody>
</table>
			
</div><!-- Main -->
</div><!-- Cointainer -->
<hr>
<?php include('browser.php'); 
$ua=getBrowser();
 $ip=$_SERVER['REMOTE_ADDR'];
?>
<div class="row-fluid" align="center" class="form-inline">
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your IP:&nbsp;&nbsp;  <i>  <?php echo getRealIpAddr();?> </i></p></div>
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your Browser:<i>&nbsp;&nbsp;<?php echo $ua['name'] . " " . $ua['version'] ;?></i></p></div>
<div class="span4"><p style="margin:0; padding:0 ;text-align:center">Visitor Counter : <i>&nbsp;&nbsp;<?php echo $_country; ?></i></p></div>

</div><!-- details -->
</div> <!-- /container fluid-->
<?php include 'footer.php';?>