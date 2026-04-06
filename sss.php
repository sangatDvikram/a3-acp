<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - ACP Buy 150 level SS</title>
<?php include 'header-acp.php'; 
page_protect();
if($_POST['B1'] == 'Buy 150 Level SS')
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }
$msg = array();
$err = array();
$char = $data['character'];
$queryt = "SELECT pcoins FROM account WHERE (c_id = '$_SESSION[username]')";
$rst = odbc_exec($con,$queryt);
$pcoins = odbc_result($rst,'pcoins');
$newpcoins = $pcoins - 2500;

if($newpcoins <= '-1') { $err[] = "Error: Not enough Premium Coins."; }
$name=$char;
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$name' AND c_status = 'A' ");
$sup2 = odbc_fetch_array($charquery);
if($sup2['pnline'] == 1) { $err[] = "Please logout in game before continuing."; }

if($char == "") { $err[] = "Error : No character was selected. Please select a character and try again."; 
} else {
$username = $_SESSION['username'];
$query = "SELECT c_id, c_headerc, c_sheaderb FROM charac0 WHERE (c_sheadera = '$_SESSION[username]') AND (c_id = '$char') AND (c_status = 'A') ORDER BY charac0.c_id ASC";
$rs = odbc_exec($con,$query);
if(odbc_num_rows($rs) == 0) { $err[] = "Error : No such eligible character was found."; }
$class = odbc_result($rs,'c_sheaderb');

switch ($class)
{
	case 0 : $code = "1012;4201147;4152361110;3758603247"; // Warrior Pet
	break;
	case 1 : $code = "1013;4201147;4152361110;3758603247"; // Holy Knight Pet
	break;
	case 2 : $code = "1014;1448732;4152361366;3759385467"; // Mage Pet
	break;
	case 3 : $code = "1015;4201147;4152361110;3758603247"; // Archer Pet
	break;
}

//initializing string
$sqlstring="SELECT m_body FROM charac0 WHERE c_id = '$char'";
$rsstring=odbc_exec($con,$sqlstring);
$charstring = odbc_result($rsstring,'m_body');

//explode the string
$temp = explode("\_1",$charstring);

//initialize variable for the string
$EXP = explode("=",$temp[0]);
$SKILL = explode("=",$temp[1]);
$PK = explode("=",$temp[2]);
$RTM = explode("=",$temp[3]);
$SINFO = explode("=",$temp[4]);
$WEAR = explode("=",$temp[5]);
$INVEN = explode("=",$temp[6]);
$PETINV = explode("=",$temp[7]);
$CQUEST = explode("=",$temp[8]);
$WAR = explode("=",$temp[9]);
$SQUEST = explode("=",$temp[10]);
$FAVOR = explode("=",$temp[11]);
$PSKILL = explode("=",$temp[12]);
$SKLSLT = explode("=",$temp[13]);
$CHATOPT = explode("=",$temp[14]);
$TYR = explode("=",$temp[15]);
$SKILLEX = explode("=",$temp[16]);
$SKLSLTEX = explode("=",$temp[17]);
$PETACT = explode("=",$temp[18]);
$LORE = explode("=",$temp[19]);
$LQUEST = explode("=",$temp[20]);
$RESRV0 = explode("=",$temp[21]);
$RESRV1 = explode("=",$temp[22]);

$inventory = explode(";",$PETINV[1]);
$chunk = array_chunk($inventory,4);
if($PETINV[1] != "") { $err[] = "Error : Please make sure that your Shue inventory is Empty."; }
/* foreach($chunk as $key)
{
	if(end($key) == $slot) 
	{ 
	$search = implode(";",$key);
	$replace = $code;
	$subject = $PETINV[1];
	$PETINV[1] = str_replace($search,$replace,$subject);
	}
} */
$insc = $code;
$df = strrpos($PETINV[1],$insc);
if($df === false) {
	if($PETINV[1] == "")
	{
		$PETINV[1] = $code;
	} else {
	$PETINV[1] = $PETINV[1].";".$insc; }
} else {
	$err[] = "Info.. : Please Empty Your Shue Inventory first."; }
	
$temp[7] = implode("=",$PETINV);
$mbody = implode("\_1",$temp);

if(empty($err)) {
$updatect = odbc_exec($con,"UPDATE account SET pcoins = '$newpcoins' WHERE c_id = '$_SESSION[username]'");
$updatec = odbc_exec($con,"UPDATE charac0 SET m_body = '$mbody'WHERE c_id = '$char' AND c_sheadera = '$_SESSION[username]'");
if($updatect) { 
$msg[] = "Shue successfully Purchased. Please login and check ingame."; 
$log = "Congratulations!! You have successfully purchased your 150 level Shue for your character named ".$char.". <br>Please check it in game!! <br>- Admin Ultimate";
log_action($username,$char,$log,$con);
$subject = "A3 Ultimate : Super Shue Successfully Received!";
email_action($username,$subject,$log,$con);
}
}
if(!$updatec) { $err[] = "Error : Super Shue could not be received."; }
}

}?>
    <div class="container-fluid">
      
   <script>
  $(document).ready(function()
  {
$('#online').load('http://<?php echo $_SERVER['SERVER_NAME'];?>/Stats/chkonline.php?randval='+ Math.random());
	 $('#coins').load('http://<?php echo $_SERVER['SERVER_NAME'];?>/Stats/coins.php?randval='+ Math.random());
	//ajaxTime.php is called every second to get time from server
   var refreshId = setInterval(function() 
   {
	 $('#online').load('http://<?php echo $_SERVER['SERVER_NAME'];?>/Stats/chkonline.php?randval='+ Math.random());
	 $('#coins').load('http://<?php echo $_SERVER['SERVER_NAME'];?>/Stats/coins.php?randval='+ Math.random());
	}, 60000);
   
   
  });
   </script>
          <div class="row-fluid ">
              <div class="span3">
              <?php include 'side_bar.php';?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Account Control Panel: <small>Buy Buy 150 level SS</small></h1></div>

<form method="POST" action=" ">
		<?php
$query1 = "SELECT charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (charac0.c_sheadera = '$_SESSION[username]') AND (charac0.c_status = 'A') ORDER BY charac0.c_id";
$rs1 = odbc_exec($con,$query1);
if(odbc_num_rows($rs1) == 0)
{
	echo '<div class="alert alert-error" align="center">No Character was found in the account. Please create a character in game first.</div>';
} else {
	echo '<div class="alert alert-info" ><span id="coins"></span></div>';
	echo '<div class="alert alert-block" >A 150 level Super Shue costs 2500 Premium Coins.<br> Please select a character and click on <b>Buy 150 Level SS</b>button to buy and recieve it in game.</div>';
	
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
echo ' <div class="form-actions" align="center"><input class="btn btn-primary" align="center" type="submit"  value="Buy 150 Level SS" name="B1" /></div>';
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