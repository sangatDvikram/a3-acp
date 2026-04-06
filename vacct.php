<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - View Account Info</title>
	
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }

page_protect();
?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
               <div class="span3">
             <?php include 'side_bar_admin.php' ?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->

<?php
$account = antisql($_GET['acc']);
$query1 = "SELECT * FROM account INNER JOIN AccountInfo ON account.c_id COLLATE DATABASE_DEFAULT = AccountInfo.account COLLATE DATABASE_DEFAULT WHERE account.c_id = '$account' AND (account.acc_status = 'Normal')";
$rs1 = odbc_exec($con,$query1);
$sup = odbc_fetch_array($rs1);
?>

<div class="page-header" style="margin-top:0;">
 			   <h1> View Account info:-<small> <?php echo $sup['name'];?></small></h1></div>
 
<div class="row-fluid ">
<div class="span4">
<b>ID : </b><?php echo $sup['c_id']; ?>
</div>
<div class="span4">
<b>Contact Number :</b> <?php echo $sup['contact']; ?>

</div>
<div class="span4">
<b>Email : </b><?php echo $sup['c_headerb']; ?>
</div>
</div>
<div class="row-fluid ">
<div class="span4">
<b>Account Status : </b><?php echo $sup['acc_status']; ?>
</div>
<div class="span4">
<b>Old Password :</b> <?php echo $sup['c_sheadera']; ?>

</div>
<div class="span4">
<b>New Password : </b><?php echo $sup['c_headera']; ?>
</div>
</div>

<h3>Character Info:</h3>
<hr>
<?php
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_sheadera = '$account' AND c_status = 'A' ORDER BY c_id ASC ");
$num=odbc_num_rows($charquery);
if($num!=0){ 
			echo "<div class='row-fluid' >";
while ($sup2 = odbc_fetch_array($charquery)){
echo "<div class=\"span2 char$sup2[c_sheaderb]\" style=\"width:145px;\" >";
if($sup2['pnline'] == 1){echo "<p style=' padding:0;text-align:center;'><img src='http://$_SERVER[SERVER_NAME]/images/status.png' title='online'>";}else{echo "<p style=' padding:0;text-align:center;'><img src='http://$_SERVER[SERVER_NAME]/images/status-offline.png' title='offline'>";}
			echo wordwrap(htmlentities($sup2['c_id']),10,"<br />\n")."</p>";
			echo"<p style=' padding:0; padding-left:3px;font-size:13px;'>Reset:$sup2[reset]<br>Rebirth:$sup2[rb]<br>Online Points:$sup2[op]</p>";
			++$i;
			echo"</div>";
}
echo " </div>";
}else
{  echo '<div class="alert alert-error"><h4>No character is created in this account</h4></div>';}
?>
        	 <!-- Chatacher info -->
            <div class='row-fluid' style='margin-top:20px;'><!-- Coins  info -->
            <div class='span4' style="border-right:1px solid #d9d9d9">
			<?php 
$dsf1 = odbc_exec($con,"SELECT pcoins FROM account WHERE c_id = '$account'");
$fgh1 = odbc_fetch_array($dsf1); ?>
            <p style='font-size:15px;padding:0' >Total Premium Coins: <?php echo $fgh1['pcoins']; ?> </p>
            </div>
            <div class='span4' style="border-right:1px solid #d9d9d9">
			<?php 
			$dsf = odbc_exec($con,"SELECT coins FROM account WHERE c_id = '$account'");
$fgh = odbc_fetch_array($dsf); ?>
            <p style='font-size:15px; padding:0'>Total Eshop Coins: <?php echo $fgh['coins']; ?> </p>
            </div>
            <div class='span4'>
			<?php 
$dsf1 = odbc_exec($con,"SELECT gold FROM account WHERE c_id = '$account'");
$fgh1 = odbc_fetch_array($dsf1); ?>
            <p style='font-size:15px;padding:0'>Total Gold Coins: <?php echo $fgh1['gold']; ?> </p>
            </div>
            
  			 </div><!-- Coins  info -->
			 
			 <div class="form-actions" align="center">
			 <a class="btn btn-inverse" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/Admin/EditAccount/<?php echo $account; ?>/" >Edit Account</a>
			 </div>
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