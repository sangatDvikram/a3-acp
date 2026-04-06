<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - ACP Buy All Skills</title>
<?php include 'header-acp.php'; 
page_protect();
if($_POST['B1'] == 'Submit')
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }
$msg = array();
$err = array();
$char = $data['character'];
$name=$char;
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$name' AND c_status = 'A' AND c_sheadera='$_SESSION[username]'");
$sup2 = odbc_fetch_array($charquery);
if($sup2['pnline'] == 1) { $err[] = "Please logout in game before continuing."; }

if($char == "") { $err[] = "No character was selected. Please select a character and try again."; 
} else {
$username = $_SESSION['username'];
$sql1="SELECT account.c_id, account.c_headera, charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (account.c_id = '$username') AND (charac0.c_id = '$char')";
$rs1=odbc_exec($con,$sql1);
//if its return 1, then its the correct user
$rec1 = odbc_fetch_row($rs1);
if ($rec1 == 1)
	{
		$kSql1="SELECT pcoins FROM account WHERE c_id = '$username'";
		$kRs1 = odbc_exec($con,$kSql1);
		$check_woonz = odbc_result($kRs1,'pcoins');
		//echo "<center>Current Woonz:<b>$check_woonz </b><br></center>";
		if($check_woonz >= 1700 )
		{
			$check_woonz = $check_woonz - 1700;
			include('inc/m_body_char.php');
			//echo "<center>Current Lore:<b>$LORE[1] </b><br></Center>";
			$SKILL[1] = '4294967295;4294967295;4294967295';
			$SKILLEX[1] = '4294967295;4294967295;4294967295';
			//$EXP[1]="4220806300";
			//$temp[0] = implode("=",$EXP);
			$temp[1] = implode("=",$SKILL);
			$temp[16] = implode("=",$SKILLEX);
			$m_body = implode("\_1",$temp);
			/*$newString = $temp[0]."\_1".$SKILL[0]."=".$SKILL[1]."\_1"."\_1".$temp[2]."\_1".$temp[3]."\_1".$temp[4]."\_1".$temp[5]."\_1".$temp[6]."\_1".$temp[7]."\_1".$temp[8]."\_1".$temp[9]."\_1".$temp[10]."\_1".$temp[11]."\_1".$temp[12]."\_1".$temp[13]."\_1".$temp[14]."\_1".$temp[15]."\_1".$temp[16]."\_1".$temp[17]."\_1".$temp[18]."\_1".$temp[19]."\_1".$temp[20]."\_1".$temp[21]."\_1".$temp[22]."\_1";*/
			if(empty($err)) {
			$sqlgo= "UPDATE charac0 SET m_body = '$m_body' WHERE c_id = '$char' AND c_sheadera='$_SESSION[username]'";
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
					$msg[] = "Successfully bought all Normal and Unique Skills!.";
					$top = odbc_exec($con, $lap);
				};
		}
		else
		{
			$err[] = "You must have atleast 1700 Premium Coins to buy all Normal and Unique skills.";
		};
	}
}
}?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <div class="span3">
              <?php include 'side_bar.php';?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Account Control Panel: <small>Buy All Skills</small></h1></div>

<form method="POST" action=" ">
		<?php
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
<center>Costs 1700 Premium Coins </center>Currently you have <?php echo $fgh1['pcoins']; ?> Premium Coins in your account and after using this service you will have <?php echo $fgh1['pcoins'] - 1700; ?> Premium coins left in your account.<br />
	<?php
	echo '</b></div>';
	
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
	echo '<hr><h4 class="text-center text-info"> - SELECT A CHARACTER - </h4><br><div class="controls" align="center"> ';

while (odbc_fetch_row($rs1))
	{
		$heroes1 = odbc_result($rs1, "c_id");
?> <label class="radio inline">
<input type="radio" value="<?php echo $heroes1; ?>" name="character" id="<?php echo $heroes1; ?>" /><?php echo $heroes1; ?></label>
<?php
}
echo '</div>';
echo ' <div class="form-actions" align="center"><input class="btn btn-primary" align="center" type="submit" value="Submit" name="B1" /></div>';
}
?>

</form>
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