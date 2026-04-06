<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - View Character Info</title>
	
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }
$character = antisql($_GET['char']);
page_protect();
?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <div class="span3">
             <?php include 'side_bar_admin.php' ?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
			  <?php
$sqlstring1="SELECT c_headera FROM charac0 WHERE sr_no = '$character'";
$rsstring1 = odbc_exec($con,$sqlstring1);
$charstring1 = odbc_result($rsstring1,'c_headera');
$temp1 = explode(";",$charstring1);
$STR = $temp1[0];
$INT = $temp1[1];
$DEX = $temp1[2];
$VITAL = $temp1[3];
$MANA = $temp1[4];
$RSTAT = $temp1[5];
$HP = $temp1[6];
$MP = $temp1[7];
$HPLEFT = $temp1[8];
$MPLEFT = $temp1[9];
$query1 = "SELECT * FROM charac0 WHERE sr_no = '$character'";
$rs1 = odbc_exec($con,$query1);
$sup = odbc_fetch_array($rs1);
?>
 			   <h1>View Character Info: <small><?php echo $sup['c_id']; ?></small></h1></div>
			   

	<div class="row-fluid ">
<div class="span4">
<b>Character: </b><?php echo $sup['c_id']; ?>
</div>
<div class="span4">
<b>Username :</b> <?php echo $sup['c_sheadera']; ?>

</div>
<div class="span4">
<b>Char Type :</b><?php if($sup['c_sheaderb'] == "0") { echo "Warrior"; } if($sup['c_sheaderb'] == "1") { echo "HK"; } if($sup['c_sheaderb'] == "2") { echo "Mage"; } if($sup['c_sheaderb'] == "3") { echo "Archer"; } ?>
</div>
</div>
<div class="row-fluid ">
<div class="span4">
<b>Level : </b><?php echo $sup['c_sheaderc']; ?>
</div>
<div class="span4">
<b>Rebirth :</b> <?php echo $sup['rb']; ?>

</div>
<div class="span4">
<b>Woonz : </b><?php echo $sup['c_headerc']; ?>
</div>
</div>
<div class="row-fluid ">
<div class="span4">
<b>Str : </b><?php echo $STR; ?>
</div>
<div class="span4">
<b>Dex :</b> <?php echo $DEX; ?>

</div>
<div class="span4">
<b>Int : </b><?php echo $INT; ?>
</div>
</div>
<div class="row-fluid ">
<div class="span4">
<b>Vital : </b><?php echo $VITAL; ?>
</div>
<div class="span4">
<b>Mana :</b> <?php echo $MANA; ?>

</div>
<div class="span4">
<b>Rem Stats : </b><?php echo $RSTAT; ?>
</div>
</div>
<div class="row-fluid ">
<div class="span4">
<b>Hp : </b><?php echo $HP; ?>
</div>
<div class="span4">
<b>Mp :</b> <?php echo $MP; ?>

</div>
<div class="span4">
<b>Total : </b><?php echo $STR+$INT+$DEX+$VITAL+$MANA+$RSTAT; ?>
</div>
</div>

  			 
			 <div class="form-actions" align="center">
			 <a class="btn btn-inverse" href="" >Edit Charachar</a>
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
