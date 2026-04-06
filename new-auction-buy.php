<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include 'header.php'; 
?>

<script type="text/javascript">
$(document).ready(function()
{

$(".loader").hide();
$("#main").hide();

$(".char").change(function()
{
$("#main").hide();
$(".slot").fadeTo(250, 0.33);
$(".char").attr("disabled", "disabled");
$(".slot").attr("disabled", "disabled");
$(".itemoptions").html('');
$(".loader").show();
var id=$(this).val();
var dataString = 'char='+ id;
$.ajax
({
type: "POST",
url: "/Stats/get_empty.php",
data: dataString,
cache: false,
success: function(html)
{
$(".slot").fadeTo(250,1);
$(".slot").html(html);
$(".loader").hide();
$(".slot").removeAttr("disabled");
$(".char").removeAttr("disabled");
} 
});

});
});

</script>
  <?php
$id=antisql($_GET['id']);

$msg = array();
$err = array();
//Start Processing for Transaction Password
if (isset($_POST['Trans'])) {
	foreach($_POST as $key => $value) {
		$data[$key] = antisql($value); // post variables are filtered
	}
	$pss=$data['trnx'];
	$sq=$data['sqestion'];
	$sa=$data['sans'];
	//echo $pass."|".$sq."|".$sa;
	$pass=$data['Tpass'];
	$trans=odbc_exec($con,"select * from AccountInfo where account='$_SESSION[username]' and trnxpass ='$pss' ");
	$act=odbc_num_rows($trans);
	if($act!=0){
		$err[]="Transaction Passsword is alredy set .!!";
	}
	
	if($pss==''&&strlen($sq)<4){
		$err[]="Error :: Plase enter Transaction Password greater than 4 characters!!";
	}
	if($sq==''&&strlen($sq)<8){
		$err[]="Error :: Plase enter Transaction Secret Question greater than 8 characters!!";
	}
	if($sa==''){
		$err[]="Error :: Plase enter Transaction Secret Answer!!";
	}
	
	if (empty($err)) {
		$account = $_SESSION['username'];
$getinfo1 = odbc_exec($con,"SELECT * FROM account INNER JOIN AccountInfo ON account.c_id COLLATE DATABASE_DEFAULT = AccountInfo.account COLLATE DATABASE_DEFAULT WHERE account.c_id = '$account'");
		$acct=odbc_fetch_array($getinfo1);
		$address = $acct['c_headerb'];
		
		$update=odbc_exec($con,"update AccountInfo set trnxpass='$pss',question='$sq',answer='$sa' WHERE account = '$account'");
		$log = "Hello ".$acct['name'].",<br>Your transaction password is successfully set. Transaction details are as follows .<br>
		Transaction Password : $pss <br>
		Secret Question : $sq <br>
		Secret Answer : $sa <br>
		Please Keep this password with and dont share it with any one else it is to secure transaction on our <b>A3 Ultimate AUCTION</b>. You will required this password to buy any item in auction or to claim back your own auction. 
		
		<br>
		- Admin, <br>Team Ultimate";
		
		log_action($_SESSION[username],"N.A",$log,$con);
		$subject = "A3 Ultimate : Transaction password is successfully set.";
		email_action($_SESSION[username],$subject,$log,$con);
		
		
		
		$mailparts = explode("@", $address);
		$output = truncate($mailparts[0]);
		$output .= "@" . $mailparts[1];
		$msg[]="Hello $acct[name] Your transaction password is successfully set. !! <br> Transaction details are sent to $output .<br> If you cant access this email or don't get the Transaction details email, Please send an email to support@a3ultimate.com";
	}
	
	
}
//Reset Transaction Password 

if (isset($_POST['ResetPass'])) {
	foreach($_POST as $key => $value) {
		$data[$key] = antisql($value); // post variables are filtered
	}
	//$pss=$data['trnx'];
	$sq=$data['sqestion'];
	$sa=$data['sans'];
	//echo $pass."|".$sq."|".$sa;
	//$pass=$data['Tpass'];
	$trans=odbc_exec($con,"select * from AccountInfo where account='$_SESSION[username]' and answer ='$sa' ");
	$act=odbc_num_rows($trans);
	$tp=odbc_fetch_array($trans);
	if($act==0){
		$err[]="Transaction Secret Answer is not valid !!";
	}

	if($sq==''){
		$err[]="Error :: Plase enter Transaction Secret Question greater than 8 characters!!";
	}
	if($sa==''){
		$err[]="Error :: Plase enter Transaction Secret Answer!!";
	}
	
	if (empty($err)) {
		$account = $_SESSION['username'];
$getinfo1 = odbc_exec($con,"SELECT * FROM account INNER JOIN AccountInfo ON account.c_id COLLATE DATABASE_DEFAULT = AccountInfo.account COLLATE DATABASE_DEFAULT WHERE account.c_id = '$account'");
		$acct=odbc_fetch_array($getinfo1);
		$address = $acct['c_headerb'];
		
		$psswrd = $acct['trnxpass'];
		$contact = $acct['contact'];

		
		//$update=odbc_exec($con,"update AccountInfo set trnxpass='$pss',question='$sq',answer='$sa' WHERE account = '$account'");
		$log = "Hello ".$acct['name'].",<br> In response to your request, we are sending you your transaction password. Your Transaction Password for A3Ultimate Auction is : <b>$tp[trnxpass]</b> <br>
		
		Please Keep this password with and dont share it with any one else it is to secure transaction on our <b>A3 Ultimate AUCTION</b>. You will required this password to buy any item in auction or to claim back your own auction. 
		
		<br>
		- Admin, <br>Team Ultimate";
		
		log_action($_SESSION[username],"N.A",$log,$con);
		$subject = "A3 Ultimate : Transaction Password Recovery.";
		email_action($_SESSION[username],$subject,$log,$con);
		
		
		
		$mailparts = explode("@", $address);
		$output = truncate($mailparts[0]);
		$output .= "@" . $mailparts[1];
		$msg[]="Transaction details are sent to $output .<br> If you cant access this email or don't get the Transaction details email, Please send an email to support@a3ultimate.com";
	}
	
	
}

if(isset($_POST['claimback'])){
include 'getopt.php';  //start thr clain back
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
$char=$data['char'];
$slot=$data['slot'];
$pass=$data['Tpass'];
$trans=odbc_exec($con,"select * from AccountInfo where account='$_SESSION[username]' and trnxpass is not null ");
$act=odbc_fetch_array($trans);
if($act['trnxpass']!=$pass){
	$err[]="Invalid Transaction Passsword entered .!!";
}
if(isonline($char)) { $err[] = "Error : Please logout in game before continuing."; }
if(is_online($_SESSION['username'])) { $err[] = "Error : Please logout from game before continuing. and make sure that no other characters from your account is logged in"; }

$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$char' and c_sheadera='$_SESSION[username]' AND c_status = 'A' ");
$numb=odbc_num_rows($charquery);
if($numb!=1){$err[] = "Error : Please check that you are not doing any thing stupid :) !! Because We always Love You !! ";}
if($char == 'x') { $err[] = "Error : Please select least one character."; }
if($slot == 'x') { $err[] = "Error : Please select least one slot."; }
if($sold == '1') { $err[] = "Error : Item is alredy sold to some one else better luck Next time :) !!"; }
if($claim == '1') { $err[] = "Error : Item is alredy claim backed better luck Next time :) !!"; }
$string = $itemid.";".$typeid.";".$unique.";".$slot;
//initializing string
$sqlstring="SELECT * FROM charac0 WHERE c_id = '$char'";
$rsstring=odbc_exec($con,$sqlstring);
$charstring = odbc_result($rsstring,'m_body');
$rclasss = odbc_result($rsstring,'c_sheaderb');
$ponline = odbc_result($rsstring,'pnline');

//echo "$charstring <br>";
if($ponline == 1) { $err[] = "Error : Please logout from game before continuing."; }

$sql="SELECT * FROM charac0 WHERE c_sheadera = '$_SESSION[username]'";
$rss=odbc_exec($con,$sql);
while($rs=odbc_fetch_array($rss)){
if($rs['pnline'] == 1) { $err[] = "Error : Please logout from game before continuing. and make sure that no other characters from your account is logged in"; }
}
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

$insc = $itemid.";".$typeid.";".$unique.";".$slot;
$sr = explode(";",$INVEN[1]);
$result = array();
$source = array_values($sr);
$count = count($source);
for($i = 3; $i < $count; $i +=4) {
    $result[] = $source[$i]+1;
}

if(empty($result)){
$INVEN[1] = $insc; 
}
else {
$INVEN[1] = $INVEN[1].";".$insc; 
}
$temp[6] = implode("=",$INVEN);
$mbody = implode("\_1",$temp);
$date=date(' n/j/Y h:i:s A');
if(empty($err)) {
$updatec = odbc_exec($con,"UPDATE charac0 SET m_body = '$mbody' WHERE c_id = '$char' AND c_sheadera = '$_SESSION[username]'");
$updatee = odbc_exec($con2,"UPDATE auction SET sold = '1',claimback='1',claimbackdate='$date',selldate='$date',buyer='$char',buyerid='$_SESSION[username]',buyerip='$_SERVER[REMOTE_ADDR]' WHERE auctionid = '$id'");


if($updatec) { 
$msg[] = "Item Claim Back Successfully.";
$log = "Congratulations!! You have successfully Claim Back  your item <b>".$name."</b> in character <b>".$char."</b>.<br>Please check you got the item in your inventory.!! <br>Thank you for using our Ultimate Auction.<br> If you did not got your item back, Please send an email to support@a3ultimate.com .<br><b>-Admin Ultimate</b>";
log_action($_SESSION['username'],$char,$log,$con);
$subject = "A3 Ultimate : Item Claim Back Successfully!!";
email_action($_SESSION['username'],$subject,$log,$con);
}

}

}
if(isset($_POST['coins'])){

include 'getopt.php';  //start the coins :D
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
$char=$data['char'];
$slot=$data['slot'];
$pass=$data['Tpass'];
$trans=odbc_exec($con,"select * from AccountInfo where account='$_SESSION[username]' and trnxpass is not null ");
$act=odbc_fetch_array($trans);
if($act['trnxpass']!=$pass){
	$err[]="Invalid Transaction Passsword entered .!!";
}
if(isonline($char)) { $err[] = "Error : Please logout in game before continuing."; }
if(is_online($_SESSION['username'])) { $err[] = "Error : Please logout from game before continuing. and make sure that no other characters from your account is logged in"; }
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$char' and c_sheadera='$_SESSION[username]' AND c_status = 'A' ");
$numb=odbc_num_rows($charquery);
if($numb!=1){$err[] = "Error : Please check that you are not doing any thing stupid :) !! Because We always Love You !! ";}
if($char == 'x') { $err[] = "Error : Please select least one character."; }
if($slot == 'x') { $err[] = "Error : Please select least one slot."; }
if($sold == '1') { $err[] = "Error : Item is alredy sold to some one else better luck Next time :) !!"; }
if($claim == '1') { $err[] = "Error : Item is alredy claim backed better luck Next time :) !!"; }
$string = $itemid.";".$typeid.";".$unique.";".$slot;
//initializing string
$sqlstring="SELECT * FROM charac0 WHERE c_id = '$char'";
$rsstring=odbc_exec($con,$sqlstring);
$charstring = odbc_result($rsstring,'m_body');
$rclasss = odbc_result($rsstring,'c_sheaderb');
$ponline = odbc_result($rsstring,'pnline');
//echo "$charstring <br>";
if($ponline == 1) { $err[] = "Error : Please logout from game before continuing."; }
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

$insc = $itemid.";".$typeid.";".$unique.";".$slot;
$sr = explode(";",$INVEN[1]);
$result = array();
$source = array_values($sr);
$count = count($source);
for($i = 3; $i < $count; $i +=4) {
    $result[] = $source[$i]+1;
}

if(empty($result)){
$INVEN[1] = $insc; 
}
else {
$INVEN[1] = $INVEN[1].";".$insc; 
}

$temp[6] = implode("=",$INVEN);
$mbody = implode("\_1",$temp);
$date=date(' n/j/Y h:i:s A');
if(empty($err)) {
$updatec = odbc_exec($con,"UPDATE charac0 SET m_body = '$mbody' WHERE c_id = '$char' AND c_sheadera = '$_SESSION[username]'");
$updatea = odbc_exec($con,"UPDATE account SET coins = '$newcoins' WHERE c_id = '$_SESSION[username]'");
$updatea1 = odbc_exec($con,"UPDATE account SET coins = coins+$price WHERE c_id = '$ownerid'");
$updatee = odbc_exec($con2,"UPDATE auction SET sold = '1',pbuy='1',selldate='$date',buyer='$char',buyerid='$_SESSION[username]',buyerip='$_SERVER[REMOTE_ADDR]' WHERE auctionid = '$id'");


if($updatea1) { 
$msg[] = "Item bought Successfully!!";
$log = "Congratulations!! You have successfully bought item <b>".$name."</b> by $owner in character <b>".$char."</b> in $price Eshop coins.<br>Please check you got the item in your inventory.!! <br>Thank you for shopping at our Ultimate Auction.<br> If you did not got your item, Please send an email to support@a3ultimate.com .<b>-Admin Ultimate</b>";
log_action($_SESSION['username'],$char,$log,$con);
$subject = "A3 Ultimate : Item bought Successfully!!";
email_action($_SESSION['username'],$subject,$log,$con);

$log = "Congratulations!! Your auction item <b>$name</b> has been successfully sold to <b>$char</b> in $price Eshop coins. <br>Please check you got $price Eshop coins in your account !! <br>Thank you for using our Ultimate Auction.<br> If you did not got your eshop coins, Please send an email to support@a3ultimate.com .<br><b>-Admin Ultimate</b>";
log_action($ownerid,$char,$log,$con);
$subject = "A3 Ultimate : Your auction item $name sold Successfully!!";
email_action($ownerid,$subject,$log,$con);

}
else {
$err[] = "Error : Something Went Wrong.";
} 

}

}
if(isset($_POST['pcoins'])){

include 'getopt.php';  //start the coins :D
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
$char=$data['char'];
$slot=$data['slot'];
$pass=$data['Tpass'];
$trans=odbc_exec($con,"select * from AccountInfo where account='$_SESSION[username]' and trnxpass is not null ");
$act=odbc_fetch_array($trans);
if($act['trnxpass']!=$pass){
	$err[]="Invalid Transaction Passsword entered .!!";
}
if(isonline($char)) { $err[] = "Error : Please logout in game before continuing."; }
if(is_online($_SESSION['username'])) { $err[] = "Error : Please logout from game before continuing. and make sure that no other characters from your account is logged in"; }
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$char' and c_sheadera='$_SESSION[username]' AND c_status = 'A' ");
$numb=odbc_num_rows($charquery);
if($numb!=1){$err[] = "Error : Please check that you are not doing any thing stupid :) !! Because We always Love You !! ";}
if($char == 'x') { $err[] = "Error : Please select least one character."; }
if($slot == 'x') { $err[] = "Error : Please select least one slot."; }
if($sold == '1') { $err[] = "Error : Item is alredy sold to some one else better luck Next time :) !!"; }
if($claim == '1') { $err[] = "Error : Item is alredy claim backed better luck Next time :) !!"; }
$string = $itemid.";".$typeid.";".$unique.";".$slot;
//initializing string
$sqlstring="SELECT * FROM charac0 WHERE c_id = '$char'";
$rsstring=odbc_exec($con,$sqlstring);
$charstring = odbc_result($rsstring,'m_body');
$rclasss = odbc_result($rsstring,'c_sheaderb');
$ponline = odbc_result($rsstring,'pnline');
//echo "$charstring <br>";
if($ponline == 1) { $err[] = "Error : Please logout from game before continuing."; }
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

$insc = $itemid.";".$typeid.";".$unique.";".$slot;
$sr = explode(";",$INVEN[1]);
$result = array();
$source = array_values($sr);
$count = count($source);
for($i = 3; $i < $count; $i +=4) {
    $result[] = $source[$i]+1;
}

if(empty($result)){
$INVEN[1] = $insc; 
}
else {
$INVEN[1] = $INVEN[1].";".$insc; 
}
$temp[6] = implode("=",$INVEN);
$mbody = implode("\_1",$temp);
$date=date(' n/j/Y h:i:s A');
if(empty($err)) {
$updatec = odbc_exec($con,"UPDATE charac0 SET m_body = '$mbody' WHERE c_id = '$char' AND c_sheadera = '$_SESSION[username]'");
$updatea = odbc_exec($con,"UPDATE account SET pcoins = '$newpcoins' WHERE c_id = '$_SESSION[username]'");
$updatea1 = odbc_exec($con,"UPDATE account SET pcoins = pcoins+$pprice*.9 WHERE c_id = '$ownerid'");
$updatee = odbc_exec($con2,"UPDATE auction SET sold = '1',ppbuy='1',selldate='$date',buyer='$char',buyerid='$_SESSION[username]',buyerip='$_SERVER[REMOTE_ADDR]' WHERE auctionid = '$id'");


if($updatea1) {
$msg[] = "Item bought Successfully!!";
$log = "Congratulations!! You have successfully bought item <b>".$name."</b> by $owner in character <b>".$char."</b> in $pprice Premium coins.<br>Please check you got the item in your inventory.!! <br>Thank you for shopping at our Ultimate Auction.<br> If you did not got your item, Please send an email to support@a3ultimate.com .<b>-Admin Ultimate</b>";
log_action($_SESSION['username'],$char,$log,$con);
$subject = "A3 Ultimate : Item bought Successfully!!";
email_action($_SESSION['username'],$subject,$log,$con);
$ppprice=$pprice*.9;
$log = "Congratulations!! Your auction item <b>$name</b> has been successfully sold to <b>$char</b> in $pprice Premium coins. <br>We have deducted 10 Percent of the cost as Auction Trade Charges<br>Please check you got $ppprice premium coins in your account !! <br>Thank you for using our Ultimate Auction.<br> If you did not got your premium coins, Please send an email to support@a3ultimate.com .<br><b>-Admin Ultimate</b>";
log_action($ownerid,$char,$log,$con);
$subject = "A3 Ultimate : Your auction item $name sold Successfully!!";
email_action($ownerid,$subject,$log,$con);

}
else {
$err[] = "Error : Something Went Wrong.";
} 

}
}
if(isset($_POST['gcoins'])){

include 'getopt.php';  //start the coins :D
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
$char=$data['char'];
$slot=$data['slot'];
$pass=$data['Tpass'];
$trans=odbc_exec($con,"select * from AccountInfo where account='$_SESSION[username]' and trnxpass is not null ");
$act=odbc_fetch_array($trans);
if($act['trnxpass']!=$pass){
	$err[]="Invalid Transaction Passsword entered .!!";
}
if(isonline($char)) { $err[] = "Error : Please logout in game before continuing."; }
if(is_online($_SESSION['username'])) { $err[] = "Error : Please logout from game before continuing. and make sure that no other characters from your account is logged in"; }
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$char' and c_sheadera='$_SESSION[username]' AND c_status = 'A' ");
$numb=odbc_num_rows($charquery);
if($numb!=1){$err[] = "Error : Please check that you are not doing any thing stupid :) !! Because We always Love You !! ";}
if($char == 'x') { $err[] = "Error : Please select least one character."; }
if($slot == 'x') { $err[] = "Error : Please select least one slot."; }
if($sold == '1') { $err[] = "Error : Item is alredy sold to some one else better luck Next time :) !!"; }
if($claim == '1') { $err[] = "Error : Item is alredy claim backed better luck Next time :) !!"; }
$string = $itemid.";".$typeid.";".$unique.";".$slot;
//initializing string
$sqlstring="SELECT * FROM charac0 WHERE c_id = '$char'";
$rsstring=odbc_exec($con,$sqlstring);
$charstring = odbc_result($rsstring,'m_body');
$rclasss = odbc_result($rsstring,'c_sheaderb');
$ponline = odbc_result($rsstring,'pnline');
//echo "$charstring <br>";
if($ponline == 1) { $err[] = "Error : Please logout from game before continuing."; }
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

$insc = $itemid.";".$typeid.";".$unique.";".$slot;
$sr = explode(";",$INVEN[1]);
$result = array();
$source = array_values($sr);
$count = count($source);
for($i = 3; $i < $count; $i +=4) {
    $result[] = $source[$i]+1;
}

if(empty($result)){
$INVEN[1] = $insc; 
}
else {
$INVEN[1] = $INVEN[1].";".$insc; 
}

$temp[6] = implode("=",$INVEN);
$mbody = implode("\_1",$temp);
$date=date(' n/j/Y h:i:s A');
if(empty($err)) {
$updatec = odbc_exec($con,"UPDATE charac0 SET m_body = '$mbody' WHERE c_id = '$char' AND c_sheadera = '$_SESSION[username]'");
$updatea = odbc_exec($con,"UPDATE account SET gold = '$newgcoins' WHERE c_id = '$_SESSION[username]'");
$updatea1 = odbc_exec($con,"UPDATE account SET gold = gold+$gprice WHERE c_id = '$ownerid'");
$updatee = odbc_exec($con2,"UPDATE auction SET sold = '1',gpbuy='1',selldate='$date',buyer='$char',buyerid='$_SESSION[username]',buyerip='$_SERVER[REMOTE_ADDR]' WHERE auctionid = '$id'");


if($updatea1) { 
$msg[] = "Item bought Successfully!!";
$log = "Congratulations!! You have successfully bought item <b>".$name."</b> by $owner in character <b>".$char."</b> in $gprice Gold coins.<br>Please check you got the item in your inventory.!! <br>Thank you for shopping at our Ultimate Auction.<br> If you did not got your item, Please send an email to support@a3ultimate.com .<b>-Admin Ultimate</b>";
log_action($_SESSION['username'],$char,$log,$con);
$subject = "A3 Ultimate : Item bought Successfully!!";
email_action($_SESSION['username'],$subject,$log,$con);

$log = "Congratulations!! Your auction item <b>$name</b> has been successfully sold to <b>$char</b> in  $gprice Gold coins. <br>Please check you got  $gprice gold coins in your account !! <br>Thank you for using our Ultimate Auction.<br> If you did not got your gold coins, Please send an email to support@a3ultimate.com .<br><b>-Admin Ultimate</b>";
log_action($ownerid,$char,$log,$con);
$subject = "A3 Ultimate : Your auction item $name sold Successfully!!";
email_action($ownerid,$subject,$log,$con);

}
else {
$err[] = "Error : Something Went Wrong.";
} 

}



}
  ?>
    <meta charset="utf-8">
    <title><?php include 'getopt.php'; 
	echo "$name by $seller";?>- Buy - Auction - A3ultimate.com</title>
	

    <div class="container-fluid">
     
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Auction Buy : 
</h1></div><?php if($num!='0'){ ?> 
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
	   
?>
<ul class="pager">
<?php if (logged_in()) { echo '  <li class="previous"> <a href="/Auction/View/category=MyAuctions">My Auctions</a> </li>'; } ?>
  <li >
    <a href="/Auction/View/">Auction Home</a>
  </li>
  
  <li class="next">
    <a href="/Auction/">Add Item For Auction</a>
  </li>
  
</ul>
<div class="row-fluid " style="font-family:Ubuntu">

          <div class="span7">
<ul class="thumbnails">

<li class='span12'>
 <div class='thumbnail'>
 <div class='media'>
              <a class='pull-left thumbnail' href='#' onclick='return false' >
                <img class='media-object' src='<?php echo $img;?>' title ='<?php echo $name;?>' style='height:100px'>
              </a>
              <div class='media-body' style='font-size:16px'>
                <h2 class='media-heading' style="text-shadow: 1px 1px 3px #BDBDBD;" ><?php echo $name;?></h2>
				Class : <?php echo $itype;?> <br>
				Type : <?php echo $typ;?> <br>
				Description : <?php echo clear($comment);?> <br>
				<?php if($price!='0'){ echo "Coins : <span style='color:#084B8A'>".$price."</span> <br>";} ?> 
				<?php if($pprice!='0'){ echo "Premium Coins : <span style='color:#088A08'>".$pprice."</span> <br>";} ?> 
				<?php if($gprice!='0'){ echo "Gold Coins : <span style='color:#FF8000'>".$gprice."</span> <br>";} ?> 
				Seller : <span class="muted"><i><?php echo $seller;?></i> </span><br>	
				Date Added : <span class="muted"><i><?php echo $date;?></i> </span><br>
				<?php if($sold=='1'&&$claim=='0'){ echo "Sold To : <span class='text-warning'><b><i> $buyer</i></b> </span><br>Selling Date : <span class='text-warning'><b><i> $selldate</i></b> </span><br>
				Sold in : <span class='text-info'><b><i> $buy</i></b> </span><br>
				" ;}?>
				<?php if($claim=='1'){ echo "Claim back to : <span class='text-info'><b><i> $buyer</i></b> </span><br>Claim Back Date : <span class='text-info'><b><i>$claimdate</i></b> </span><br>
				" ;}?>
				<center><h3 style="color:#DF0101;text-shadow: 1px 1px 3px #F78181;">Item Options</h3></center>
				<div class=' white' style='margin-bottom:10px;padding:10px;'>
				<?php echo "<span style='font-size:18px'>Item Info : $desc $level $bless $blue $red $grey $mount $addi $strg $count</span>"; ?>
                </div>
                </div>
            </div>
 </div>
</li>
</ul>
</div>
<div class="span5">
<div class=' thumbnail' style='font-family:Calibri;font-size:16px'>
<?php if (logged_in()) { ?>
<div class='alert alert-info'><?php 
$dsf1 = odbc_exec($con,"SELECT pcoins,coins,gold FROM account WHERE c_id = '$_SESSION[username]'");
$fgh1 = odbc_fetch_array($dsf1); ?>
            Total Premium Coins: <?php echo $fgh1['pcoins']; ?> <br>
                
            Total Eshop Coins: <?php echo $fgh1['coins']; ?> <br>
			
           Total Gold Coins: <?php echo $fgh1['gold']; ?> </div>
 <form class="form-inline" method='POST'>
			   <fieldset id="item">
   <legend>Select Inventry: <img src="/images/ajax-loader.gif" class="loader"></legend>
			   Character
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

Inventory :
<select name="slot" class="slot">
<option selected="selected" value="x">--Select Invt--</option>
</select>

</fieldset>
<br>
<?php


 ?>
<div class="row-fluid " style='margine:0;padding:0'>
<div class="form-actions" style=" padding:7px;margin:0;">
<center>
<?php 
if($sold=='0'){
	echo '<a href="#buyModel" class="btn btn-block btn-success" role="button"  data-toggle="modal">Buy Item</a>';
}else{
	echo "<button class='btn btn-block btn-danger' disabled='disabled' name='claimback' type='submit' title='Item Is Sold' >Sold</button>";
}
?>

</center>
</div>
 <!-- Mode Start here -->
<div class="modal hide fade" id="buyModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h3 id="myModalLabel">Transaction Password:</h3>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" method="post" action=" ">
       		<?php 
       		$trans=odbc_exec($con,"select * from AccountInfo where account='$_SESSION[username]' and trnxpass is not null ");
       		$valid=odbc_num_rows($trans);
       		if ($valid!=0) {
			echo " <label>Transaction Password :</label><input type='password' name='Tpass' placeholder='Transaction Password' required> <br><br>
            <a href='#forgotmodel' role='button' data-dismiss='modal' data-toggle='modal'>forgot Transaction password ? </a><br>
            <div class='form-actions' style=' padding:7px;margin:0;'>";
			if($sold=='0'){ if ($ownerid==$_SESSION['username']){
				echo "  <div class='span12'>
			
  <button class='btn btn-block btn-inverse' name='claimback' type='submit' title='Get Your Item Back' >Claim Back</button>
			
			
</div></center>
</div>
</div>
</form>";
			} else {
				if($pprice!='0'){
					if($newpcoins < 0 ){
						echo "  <div class='span4'>
			
  <button class='btn btn-block btn-success' disabled='disabled' type='submit' title='You dont have enough Premium Coins to buy this item' >Buy via P.Coins</button>
			
			
</div>";}
						if($newpcoins >= 0 ){
							echo "  <div class='span4'>
			
  <button class='btn btn-block btn-success' name='pcoins' type='submit' title='Buy Item Via Premium Coins' >Buy via P.Coins</button>
			
			
</div>";}
			
				}
				if($price!='0'){
					if($newcoins < 0 ){
						echo "  <div class='span4'>
			
  <button class='btn btn-block btn-info' disabled='disabled' type='submit' title='You dont have enough Eshop Coins to buy this item' >Buy via Coins</button>
			
			
</div>";}
						if($newcoins >=0 ){
							echo "  <div class='span4'>
			
  <button class='btn btn-block btn-info' name='coins' type='submit' title='Buy Item Via Eshop Coins' >Buy via Coins</button>
			
			
</div>";}
			
				}
				if($gprice!='0'){
					if($newgcoins < 0 ){
						echo "  <div class='span4'>
			
  <button class='btn btn-block btn-warning' disabled='disabled' type='submit' title='You dont have enough Gold to buy this item' >Buy via Gold</button>
			
			
</div>";}
						if($newgcoins >= 0 ){
							echo "  <div class='span4'>
			
  <button class='btn btn-block btn-warning' name='gcoins' type='submit' title='Buy Item Via Gold' >Buy via Gold</button>
			
			
</div>";}
			
				}
				echo "</div>";
				if($pprice!='0'){
					if($newpcoins >= 0 ){
						echo "Premium Coins you will have after buying this item :<b>$newpcoins </b><br>";
				}}
				 if($price!='0'){
				if($newcoins >= 0 ){
				echo "Eshop Coins you will have after buying this item : <b>$newcoins </b> <br>";
				}}
				 if($gprice!='0'){
				if($newgcoins >= 0 ){
				echo "Gold you will have after buying this item : <b>$newgcoins </b><br>";
				}}
				}
				} else {echo "  <div class='span12'>
				
				  <button class='btn btn-block btn-danger' disabled='disabled' name='claimback' type='submit' title='Item Is Sold' >Sold</button>
				
				
				</div></center>
				</div>
				
				";} 
				 
       		}else {
       			
				echo "<div class='alert' ><h4>You dont have Transaction Password Set Yet Please Set Your Transaction Password now <br> <a href='#tsmodel' class='btn btn-block btn-success' role='button' data-dismiss='modal' data-toggle='modal'>Click here</a> <h4> </div>";

       		}
       		?>
            </form>
 
   
            </div>
            
        </div>
 <!-- Mode End here -->
 <!-- Mode Start here -->
 <div class="modal hide fade" id="tsmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h3 id="myModalLabel">Transaction Password:</h3>
            </div>
            <div class="modal-body">
    <form class="form-horizontal" method="post" action=" ">
	<table>
     <tr>
	 <td>
    <label class="control-label" for="inputEmail">Transaction Password</label>
    </td><td>
    <input type="password" id="trnx" name="trnx" placeholder="Transaction Password" required validationMessage="Please enter a Transaction Password" /><br>
    </td>
    </tr>
    <tr>
	 <td>
    <label class="control-label" for="inputPassword"  >Secrate Question</label>
     </td><td>
    <input type="text" name="sqestion"  placeholder="Secrate Question"  required validationMessage="Please enter a Secrate Question" /><br>
    </td>
    </tr>
    <tr>
    
	 <td>
    <label class="control-label" for="inputPassword"  >Secrate Answer</label>
     </td><td>
    <input type="text" name="sans" placeholder="Secrate Answer"  required validationMessage="Please enter a Secrate Question" /><br>
    </td>
    </tr>
   <tr>
	<td colspan='2'>
    
    <button type="submit"  name="Trans" class="btn btn-block btn-success"  >Set Password</button>
    </td>
    </tr>
	</table>
    </form>
            </div>
            
        </div>
 
 
 <!-- Mode End here -->
<!-- Mode Start here -->
<div class="modal hide fade" id="forgotmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            ×
        </button>
        <h3 id="myModalLabel">Reset Transaction Password:</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" method="post" action=" ">
            <table><?php $trans=odbc_exec($con,"select * from AccountInfo where account='$_SESSION[username]' ");
            			$transx=odbc_fetch_array($trans);
            		?>
                  <tr>
                    <td>
                        <label class="control-label" for="inputPassword"  >Secrate Question</label>
                    </td><td>
                        <input type="text" name="sqestion"  placeholder="Secrate Question"  required readonly='readonly' value="<?php echo "$transx[question]";?>" /><br>
                    </td>
                </tr>
                <tr>

                    <td>
                        <label class="control-label" for="inputPassword"  >Secrate Answer</label>
                    </td><td>
                        <input type="text" name="sans" placeholder="Secrate Answer"  required validationMessage="Please enter a Secrate Question" /><br>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>

                        <button type="submit"  name="ResetPass" class="btn btn-block btn-success"  >Reset Password</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>


<!-- Mode End here -->
</div>
</form>
<?php } 
				else { $_SESSION['redirect_url'] = curPageURL(); 
				echo "<div class=\"alert alert-block\" align=\"center\"><h4> Please Login first , to Buy this item. <a href=\"http://$_SERVER[SERVER_NAME]/Login?next=".urlencode(curPageURL())."\" class=\"btn btn-primary\">Login</a></h4></div>";
				}
				?>
</div>
</div>



<?php } else { ?> 
	 <div class="well" >
             <div class="alert " align="Center"><h1>Oops! Item Is Not Available !!<br>
Please Make sure that You are Not doing something stupid !!.</h1></div>
			   </div>
			   
			   <?php }?> 
</div><!-- Main --></div><!-- Main -->
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