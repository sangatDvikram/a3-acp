<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - ACP Change Stats </title>
<?php include 'header-acp.php'; 

page_protect();
$err = array();
$msg = array();
$ttt = array();
if(isset($_POST['R1']))
{
	foreach($_POST as $key => $value) {
		$data[$key] = antisql($value); }
		//---------------------------------------------
		$char=$data['char'];
		$str=$data['strength'];
		$dex=$data['Dex'];
		$int=$data['Int'];
		$vit=$data['vitality'];
		$man=$data['Mana'];
		$rem=$data['remaining'];
		$str = intval(preg_replace('/[^0-9]+/', '', $str), 10);
		$dex = intval(preg_replace('/[^0-9]+/', '', $dex), 10);
		$int = intval(preg_replace('/[^0-9]+/', '', $int), 10);
		$vit = intval(preg_replace('/[^0-9]+/', '', $vit), 10);
		$man = intval(preg_replace('/[^0-9]+/', '', $man), 10);
		$rem = intval(preg_replace('/[^0-9]+/', '', $rem), 10);
		$tot=$str+$dex+$int+$vit+$man+$rem;	
		

		include_once 'inc/stat_of_char.php';
		$STR = intval(preg_replace('/[^0-9]+/', '', $STR), 10);
		$DEX = intval(preg_replace('/[^0-9]+/', '', $DEX), 10);
		$INT = intval(preg_replace('/[^0-9]+/', '', $INT), 10);
		$VITAL = intval(preg_replace('/[^0-9]+/', '', $VITAL), 10);
		$MANA = intval(preg_replace('/[^0-9]+/', '', $MANA), 10);
		$RSTAT = intval(preg_replace('/[^0-9]+/', '', $RSTAT), 10);

		$newTot=$STR+$DEX+$INT+$VITAL+$MANA+$RSTAT;
		//---------------------------------------------
		if($tot!=$newTot){ $err[] = "You are not that smart enough !! "; }
		if($newTot>15830){$err[] = "You are not that smart enough !!!!"; }
		if($str<50||$str>65535){ $err[] = "Minimum Strength should be 50 and it should not cross over 65535!! "; }
		if($dex<50||$dex>65535){ $err[] = "Minimum Dexterity should be 50 and it should not cross over 65535!! "; }
		if($int<50||$int>65535){ $err[] = "Minimum Intelligence should be 50 and it should not cross over 65535!! "; }
		if($vit<50||$vit>15000){ $err[] = "Minimum Vital should be 50 and it should not cross over 15000!! "; }
		if($man<50||$man>15000){ $err[] = "Minimum Mana should be 50 and it should not cross over 15000!! "; }
		if(is_online($_SESSION['username'])) { $err[] = "Please logout in game before continuing."; }
		if(isonline($char)) { $err[] = "Please logout in game before continuing."; }
		if($char=='x'){$err[] = "Your not that smart enough b!tch _!_ !! ";}
		if($rem<0 || $rem>15830){ $err[] = "Minimun Remaining points should be zero only baby :* !! "; };
	
		
		//---------------------------------------------

		$newStats = $str.";".$int.";".$dex.";".$vit.";".$man.";".$rem.";30;30;30;30";

		if(empty($err)) {
		$sqlgo= "update charac0 set c_headera = '$newStats' where c_id = '$char'";
		$rs12 = odbc_exec($con,$sqlgo);
		}
		if(!$rs12)
		{
			$err[] = "Sorry, the data could not be updated now, try again later.";
		}
		else
		{
			$msg[] = "Stat reallocation for $char is successful!";
			$ttt[] = "Your total stats are ".$tot.".";
		}
		

		//$msg[]= "Yoo Man this shit works ;) !!";
		
} if(isset($_POST['R2']))
	{

foreach($_POST as $key => $value) {
	$data[$key] = $value; // post variables are filtered
}
		
	$char = $_POST['character'];
$mail=$_POST['email'];
		if(!isset($char)){$err[]="ERROR : Please Select atlease one character.";}
		if(!isEmail($mail)) {
		$err[] = "ERROR : Invalid email address."; }
		$rs_duplicate = odbc_exec($con,"SELECT c_headerb FROM account WHERE c_headerb='$mail'");
		/*if (odbc_fetch_row($rs_duplicate) > 0)
		{ $err[] = "ERROR : The email-id already exists. Please try again with different email."; }*/
		$rs_duplicate = odbc_exec($con,"SELECT c_headerb FROM account WHERE c_id='$_SESSION[username]'");
		$em=odbc_fetch_row($rs_duplicate);
		$email=$em['c_headerb'];
		/*if ($email==$mail)
		{ $err[] = "ERROR : You cannot refer your own email id."; }*/
		if(empty($err)) {
		
		 $log = "Hello New Player,<br>Your Friend ".$_SESSION['Player']." want you to join A3 Ultimate ,<br>To Register your account please <a href=\"http://$_SERVER[SERVER_NAME]/Register/".base64_encode($mail)."/".trim($char)."/\"><b>Click Here.</b></a><br>
			If you can't see the link please copy paste the following link into your address bar and press enter.<br>http://$_SERVER[SERVER_NAME]/Register/".base64_encode($mail)."/".trim($char)."/<br>- Admin Ultimate";
			log_action($mail,"N.A",$log,$con);
			$subject = "A3 Ultimate : $_SESSION[Player] referred you.";
			email_action_single($mail,$subject, $log,$con);

			$user_email =explode("@", $mail);
			$msg[] = "Referance Link has been successfully Sent to ".truncate($user_email[0])."@".$user_email[1]." and follow the link to register a referal account.";
				
		}		
	}

?><script type="text/javascript" src="/js/statsplayer.js?"+ Math.random()+""></script>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <div class="span3">
              <?php include 'side_bar.php';?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Account Control Panel: <small>All Stat Changer</small></h1></div>
    		

		<?php
$query1 = "SELECT charac0.c_id,rb FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (charac0.c_sheadera = '$_SESSION[username]') AND (charac0.c_status = 'A') ORDER BY charac0.c_id";
$rs1 = odbc_exec($con,$query1);
if(odbc_num_rows($rs1) == 0)
{
	echo '<div class="alert alert-error" align="center">No Character was found in the account. Please create a character in game first.</div>';
} else {
	echo '<h4 class="text-center text-error"> - IMPORTANT - </h4><br><div class="alert alert-info"><ol>
	<li>Click + button to add 100 points and - to remove 100 points </li><li>Please logout your character before reallocation of stats.</li><li> You can use autoclicker as you want !</li></ol></div>
<hr>';

    			
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
	
	if(!empty($pre))  {
	   echo "<div class=\"alert alert-info\">";
	  foreach ($pre as $e) {
	    echo "$e <br>";
	    }
	  echo "</div>";	
	   }
	  
?>	
<form method="post" class='form-inline' style='font-size:18px' action="/ACP/All-Stat-Changer/">
<center>Select Character: <div class="input-append">

<select name="char" class="char owner">

<option selected="selected" value="x">--Select Char--</option>
<?php 
$getchars = odbc_exec($con,"SELECT * FROM charac0 WHERE c_sheadera = '$_SESSION[username]' AND c_status = 'A'");

while (odbc_fetch_row($getchars))
	{
		$heroes1 = odbc_result($getchars, "c_id");


?>
<option  value="<?php echo $heroes1; ?>"><?php echo $heroes1; ?></option>
<?php
}
?>
</select>
</div></center>
<div id='main'>
<div id="rbdetails" style="font-family:Ubuntu;font-size:18px"></div>
</div>

</form>
<?php } ?>
</table>
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