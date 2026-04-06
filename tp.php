<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - ACP Offline TP</title>
<?php include 'header-acp.php'; 
page_protect();
if(isset($_POST['O1']))
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }
$msg = array();
$err = array();
$char = $data['character'];
$name=$char;
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$name' AND c_status = 'A' ");
$sup2 = odbc_fetch_array($charquery);
if($sup2['pnline'] == 1) { $err[] = "Please logout in game before continuing."; }
$loc = $data['town'];

if($char == "" || $loc == "") { $err[] = "Please select a character and a location then try again."; 
} else {
$username = $_SESSION['username'];
$sql1 = "SELECT account.c_id, account.c_headera, charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (account.c_id = '$username') AND (charac0.c_id = '$char')";
$rs1 = odbc_exec($con,$sql1);
//if its return 1, then its the correct user
$rec1 = odbc_fetch_row($rs1);
if ($rec1 == 1)
	{
	//update the data
				$sqlgo= "UPDATE charac0 SET c_headerb = '$town' WHERE c_id = '$char'";
				$rsgo = odbc_exec($con,$sqlgo);
				if (!$rsgo)
					{
						$err[] = "Sorry, internal server error, please try again later.";
					}
					else
					{
					if(empty($err)) {
						$msg[] = "Successful teleport to the selected town.";
						$lap = "UPDATE account SET d_udate = CONVERT(DATETIME, '$date', 102) WHERE (c_id = '$username')";
						$top = odbc_exec($con, $lap);}
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
 			   <h1>Account Control Panel: <small>Offline Teleport</small></h1></div>

<form method="POST" action=" ">
		<?php
$query1 = "SELECT charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (charac0.c_sheadera = '$_SESSION[username]') AND (charac0.c_status = 'A') ORDER BY charac0.c_id";
$rs1 = odbc_exec($con,$query1);
if(odbc_num_rows($rs1) == 0)
{
	echo '<div class="alert alert-error" align="center">No Character was found in the account. Please create a character in game first.</div>';
} else {
	echo '<div class="alert alert-block" ><b>This tool is very useful when you found out that character is stuck somewhere in the maps.<br> Just fill in the particular data and where you wish to teleport your character. Make sure to logout in game before continuing.</b></div>';
	
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
echo ' <hr><h4 class="text-center text-info">- SELECT A LOCATION - </h4><br><div class="controls" align="center"><label class="radio inline"> <input type="radio" value="1;32383" name="town" id="temoz" "selected" />Temoz</label> <label class="radio inline"><input type="radio" value="7;18013" name="town" id="quanato" />Quanato</label></div><div class="form-actions" align="center"><input class="btn btn-primary" align="center" type="submit" value="Submit" name="O1" /></div>';
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