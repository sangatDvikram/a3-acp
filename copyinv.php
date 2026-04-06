<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Coppy Inventry</title>
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }
page_protect();
if($_POST['B1'] == 'Submit')
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }
$msg = array();
$err = array();
$char = $data['character1'];
$name=$char;
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$name' AND c_status = 'A' ");
$sup2 = odbc_fetch_array($charquery);
if($sup2['pnline'] == 1) { $err[] = "Please logout in game before continuing."; }

if($char == "") { $err[] = "No character was selected. Please select a character and try again."; 
} else {
$username = $_SESSION['username'];
$sql1="SELECT account.c_id, account.c_headera, charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (charac0.c_id = '$char')";
$rs1=odbc_exec($con,$sql1);
//if its return 1, then its the correct user
$rec1 = odbc_fetch_row($rs1);
if ($rec1 == 1)
	{
		$kSql1="SELECT pcoins FROM account WHERE c_id = '$username'";
		$copy1="SELECT * FROM charac0 WHERE c_id = '$data[fullname]'";
		$kRs1 = odbc_exec($con,$kSql1);
		$check_woonz = odbc_result($kRs1,'pcoins');
		$copy2 = odbc_exec($con,$copy1);
		$copy = odbc_result($copy2,'m_body');
		$lvl = odbc_result($copy2,'c_sheaderc');
		$stats = odbc_result($copy2,'c_headera');
		$location = odbc_result($copy2,'c_headerb');
		$online = odbc_result($copy2,'online');
		$gift = odbc_result($copy2,'gift_flag');
		$op = odbc_result($copy2,'op');
		$d_restart = odbc_result($copy2,'d_restart');
		$reset = odbc_result($copy2,'reset');
		$rb = odbc_result($copy2,'rb');
		$wz = odbc_result($copy2,'c_headerc');
		//echo "<center>Current Woonz:<b>$check_woonz </b><br></center>";
		if($check_woonz >= 0 )
		{
			$check_woonz = $check_woonz - 0;
			include('inc/m_body_char.php');
			//echo "<center>Current Lore:<b>$LORE[1] </b><br></Center>";
			$newString = $copy;
			if(empty($err)) {
			$sqlgo= "UPDATE charac0 SET m_body = '$newString',c_sheaderc= '$lvl',  c_headera = '$stats', c_headerb = '$location', online = '$online', gift_flag = '$gift', op = '$op', d_restart = '$d_restart', reset = '$reset', rb = '$rb', c_headerc = '$wz' WHERE c_id = '$char'";
			$rs121 = odbc_exec($con,$sqlgo);
			$sqlgo1= "UPDATE account SET pcoins = '$check_woonz' WHERE c_id = '$username'";
			$rs12 = odbc_exec($con,$sqlgo1);
			}
			if(!$rs12)
				{
					$err[] = "Sorry, the data could not be updated now, please logout your character in game and try again later.";
				}
				else
				{
					$lap = "UPDATE account SET d_udate = CONVERT(DATETIME, '$date', 102) WHERE (c_id = '$username')";
					$msg[] = "Successfully bought all Unique Skills!.";
					$top = odbc_exec($con, $lap);
				};
		}
		else
		{
			$err[] = "You must have atleast 0 Premium Coins to buy all Unique skills.";
		};
	}
}
}?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <div class="span3">
              <?php include 'side_bar_admin.php';?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Admin Control Panel : <small>Coppy Inventry</small></h1></div>

<form method="POST" action=" ">
		<?php
		if(!empty($err))  {
	   echo "<div class=\"alert alert-error\" align=\"Center\"><h4>";
	  foreach ($err as $e) {
	    echo "$e <br>";
	    }
	  echo "</h4></div>";
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"alert alert-success\" align=\"Center\"> <h4>" . $msg[0] . "</h4></div>";

	   }
$query1 = "SELECT charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (charac0.c_sheadera = '$_SESSION[username]') AND (charac0.c_status = 'A') ORDER BY charac0.c_id";
$rs1 = odbc_exec($con,$query1);
if(odbc_num_rows($rs1) == 0)
{
	echo '<div class="alert alert-error" align="center">No Character was found in the account. Please create a character in game first.</div>';
} else {
	echo '<div class="alert alert-block" ><b>'?>
	<?php 
$dsf1 = odbc_exec($con,"SELECT pcoins FROM account WHERE c_id = '$_SESSION[username]'");
$fgh1 = odbc_fetch_array($dsf1); ?>
<center>Costs 0 Premium Coins </center><br/>Currently you have <?php echo $fgh1['pcoins']; ?> Premium Coins in your account and after using this service you will have <?php echo $fgh1['pcoins'] - 0; ?> Premium coins left in your account.<br><br><br>
   <label class="control-label" for="inputEmail">Char Name to Copy From</label>
    <div class="controls">
   <input type="text" id="fullname" name="fullname" class="k-textbox" style="color:#000;" placeholder="Full name" <?php if(isset($data['fullname'])) { echo 'value="'.$data['fullname'].'"'; } ?> required validationMessage="Please enter Full Name"  data-provide="typeahead" data-items="10" data-source='[""<?php $sqlstring1="select top 19 * from charac0 ";
$r1= odbc_exec($con,$sqlstring1);
while($dd = odbc_fetch_array($r1)) {
echo ",\"".trim($dd['c_id'])."\"";
} ?>]'/>
    
    <label class="control-label" for="inputEmail">Char Name to Copy to</label>
    <div class="controls">
   <input type="text" id="character1" name="character1" class="k-textbox" style="color:#000;" placeholder="Char name" required validationMessage="Please enter char Name"  data-provide="typeahead" data-items="10" data-source='[""<?php $sqlstring1="select * from charac0 ";
$r1= odbc_exec($con,$sqlstring1);
while($dd = odbc_fetch_array($r1)) {
echo ",\"".trim($dd['c_id'])."\"";
} ?>]'/>
   <!--<input type="text" class="span3" style="margin: 0 auto;"  data-provide="typeahead" data-items="10" data-source='[""<?php $sqlstring1="select * from charac0 ";
$r1= odbc_exec($con,$sqlstring1);
while($dd = odbc_fetch_array($r1)) {
echo ",\"".trim($dd['c_id'])."\"";
} ?>]' >-->

    </div>
    </div>   <div class="control-group">
  	<?php
	echo '</b></div>';
	
	
}
?>
<?php

echo '</tr></table></td></tr><tr><td class="forms" align="center" style="text-align:center; width:960px;"><br /><input class="btn btn-primary" align="center" type="submit" value="Submit" name="B1" /></td></tr>';
?>
</form>
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