<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Edit Account Info</title>
	
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }
$account = antisql($_GET['acc']);
if($_POST['doUpdate'] == 'UPDATE ACCOUNT INFO')
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }
$msg = array();
$err = array();
$grade = $data['grade'];
$msg20 = $data['msg'];
$msg30 = array("/", "`", "(b)", "(!b)");
$msg40 = array("<br>", '"', "<b>", "</b>");
$msg50 = str_replace($msg30, $msg40, $msg20);

$result = odbc_exec($con,"SELECT * FROM account WHERE c_id = '$account'"); 
$num = odbc_num_rows($result);
$username1 = odbc_result($result, "c_id");
$password1 = odbc_result($result, "c_headera");
$c_status1 = odbc_result($result, "c_status");
$grade1 = odbc_result($result, "acc_status");
$email1 = odbc_result($result, "c_headerb");
$coin1 = odbc_result($result, "coins");
$pcoin1 = odbc_result($result, "pcoins");
$gold1 = odbc_result($result, "gold");
$unban = odbc_result($result, "unban_date");

$sql_insert1 = "INSERT INTO LoginLog (id, ip, datetime, action, logaction, grade) VALUES ('$_SESSION[username]', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'Pre Edit Acc', 'id=$username1, email=$email1, ban=$c_status1, pcoin=$pcoin1, coin=$coin1, gold=$gold1, status=$grade1', '$_SESSION[grade]')";
		$query1 = odbc_exec($con2, $sql_insert1); 
if($data['grade'] == "X") { $status = "X"; $grade = "Normal"; } else { $status = "A"; } 

$lap = "UPDATE account SET c_headera = '$data[password]', msg = '$msg50', unban_date = '$data[unban_date]', c_headerb = '$data[email]', verified = '$data[verified]', c_status = '$data[ban]', pcoins = '$data[pcoins]', acc_status = '$grade', coins = '$data[coins]', gold = '$data[gold]' WHERE c_id = '$account'";
$top = odbc_exec($con, $lap);
$hashed_trnxpass = password_hash($data['trnxpass'], PASSWORD_BCRYPT);
$hashed_answer   = password_hash($data['answer'],   PASSWORD_BCRYPT);
$lap2 = "UPDATE AccountInfo SET name = '$data[name]',trnxpass = '$hashed_trnxpass', question = '$data[question]', answer = '$hashed_answer', contact = '$data[contact]', word = '$data[word]' WHERE account = '$account'";
$top2 = odbc_exec($con, $lap2);
$sql_insert2 = "INSERT INTO LoginLog (id, ip, datetime, action, logaction, grade) VALUES ('$_SESSION[username]', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'Post Edit Acc', 'id=$account, email=$data[email], ban=$data[ban], pcoin=$data[pcoins], coin=$data[coins], gold=$data[gold], status=$grade', '$_SESSION[grade]')";
		$query1 = odbc_exec($con2, $sql_insert2); 

if($top) {
	$msg[] = "Account successfully updated."; }
	else { $err[] = "Error : Cannot Update this account."; }
}
?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <div class="span3">
             <?php include 'side_bar_admin.php' ?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->

<?php
$account = antisql($_GET['acc']);
$query1 = "SELECT * FROM account INNER JOIN AccountInfo ON account.c_id COLLATE DATABASE_DEFAULT = AccountInfo.account COLLATE DATABASE_DEFAULT WHERE account.c_id = '$account'";
$rs1 = odbc_exec($con,$query1);
$sup = odbc_fetch_array($rs1);
?>

<div class="page-header" style="margin-top:0;">
 			   <h1>Edit Account info:-<small> <?php echo $sup['name'];?></small></h1></div>
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
<table >
<tr><td width="960" style="padding-top:5px;"> 
       
</td></tr>
<?php
$query1 = "SELECT * FROM account INNER JOIN AccountInfo ON account.c_id COLLATE DATABASE_DEFAULT = AccountInfo.account COLLATE DATABASE_DEFAULT WHERE account.c_id = '$account'";
$rs1 = odbc_exec($con,$query1);

echo '<tr><td align="center" class="forms" style="text-align:center; font-size:20px; font-weight:800; width:100%;"> - ACCOUNT DETAILS - </td></tr><tr><td class="forms" style="text-align:center; width:100%;">';
echo '<table class="table table-bordered" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; text-align:center; width:100%;"><form method="POST" action=" ">';
while ($sup = odbc_fetch_array($rs1))
	{
?>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">ID</td><td class="rankingc" style="text-align:left; padding-left:5px;"><?php echo $sup['c_id']; ?></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Referred By</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="word" name="word" class="k-textbox" style="color:#000; padding:5px;" value="<?php echo $sup['word']; ?>" /></td></tr>


<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Trnx Pass</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="trnxpass" name="trnxpass" class="k-textbox" style="color:#000; padding:5px;" placeholder="Transaction Pass"value="<?php echo $sup['trnxpass']; ?>" /></td></tr>


<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Trnx Question</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="question" name="question" class="k-textbox" style="color:#000; padding:5px;" placeholder="Transaction Question"  value="<?php echo $sup['question']; ?>" /></td></tr>


<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Trnx Answer</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="answer" name="answer" class="k-textbox" style="color:#000; padding:5px;" placeholder="Transaction Answer" value="<?php echo $sup['answer']; ?>" /></td></tr>


<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Password</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="password" name="password" class="k-textbox" style="color:#000; padding:5px;" placeholder="Password" required validationMessage="Please enter a Password." value="<?php echo $sup['c_headera']; ?>" /></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Email</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="email" name="email" class="k-textbox" style="color:#000; padding:5px;" placeholder="E-mail" required validationMessage="Please enter a Email." value="<?php echo $sup['c_headerb']; ?>" /></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Account Status</td><td class="rankingc" style="text-align:left; padding-left:5px;">
<select id="grade" name="grade" style="width:140px;">
<option value="Normal" <?php if($sup['acc_status'] == "Normal") { echo "selected"; } ?>>Normal</option>
<option value="Admin 1" <?php if($sup['acc_status'] == "Admin 1") { echo "selected"; } ?>>GM</option>
<option value="Admin" <?php if($sup['acc_status'] == "Admin") { echo "selected"; } ?>>Admin</option>
</select></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Verified</td><td class="rankingc" style="text-align:left; padding-left:5px;">
<select id="verified" name="verified" style="width:140px;">
<option value="1" <?php if($sup['verified'] == "1") { echo "selected"; } ?>>Yes</option>
<option value="0" <?php if($sup['verified'] == "0") { echo "selected"; } ?>>No</option>
<option value="2" <?php if($sup['verified'] == "2") { echo "selected"; } ?>>ACP Banned</option>
</select></td></tr>
<?php 
$msg2 = $sup['msg'];
$msg4 = array("/", "`", "(b)", "(!b)");
$msg3 = array("<br>", '"', "<b>", "</b>");
$msg5 = str_replace($msg3, $msg4, $msg2); ?>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Ban Status</td><td class="rankingc" style="text-align:left; padding-left:5px;">
<select id="ban" name="ban" style="width:140px;">
<option value="A" <?php if($sup['c_status'] == "A") { echo "selected"; } ?>>Normal</option>
<option value="X" <?php if($sup['c_status'] == "X") { echo "selected"; } ?>>Temp Banned</option>
<option value="B" <?php if($sup['c_status'] == "B") { echo "selected"; } ?>>IP Banned</option>
<option value="C" <?php if($sup['c_status'] == "C") { echo "selected"; } ?>>Permanent Banned</option>
<option value="F" <?php if($sup['c_status'] == "F") { echo "selected"; } ?>>Hacker/Bug User</option>
<option value="I" <?php if($sup['c_status'] == "I") { echo "selected"; } ?>>Abuse Banned</option>
<option value="K" <?php if($sup['c_status'] == "K") { echo "selected"; } ?>>Racist Banned</option>
<option value="N" <?php if($sup['c_status'] == "N") { echo "selected"; } ?>>No Payment Banned</option>
<option value="N" <?php if($sup['c_status'] == "O") { echo "selected"; } ?>>Parental Comment Ban</option>
<option value="R" <?php if($sup['c_status'] == "R") { echo "selected"; } ?>>Deactivated</option>
<option value="P" <?php if($sup['c_status'] == "P") { echo "selected"; } ?>>RC Dealing Ban</option>
<option value="L" <?php if($sup['c_status'] == "M") { echo "selected"; } ?>>Password Expired</option>
<option value="D" <?php if($sup['c_status'] == "D") { echo "selected"; } ?>>Test Char</option>
<option value="L" <?php if($sup['c_status'] == "L") { echo "selected"; } ?>>Expired Password</option>
<option value="G" <?php if($sup['c_status'] == "G") { echo "selected"; } ?>>Advertising Server</option>
</select></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Unban Date</td><td class="rankingc" style="text-align:left; padding:5px;">Default - 1900-01-01 00:00:00<br><input type="datetime" id="unban_date" name="unban_date" style="color:#000; padding:5px;" value="<?php echo clear($sup['unban_date']); ?>" /></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Name</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="name" name="name" class="k-textbox" style="color:#000; padding:5px;" placeholder="Name" required validationMessage="Please enter a Name." value="<?php echo clear($sup['name']); ?>" /></td></tr>



<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Contact Number</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="contact" name="contact" class="k-textbox" style="color:#000; padding:5px;" placeholder="Contact" required validationMessage="Please enter a Contact No." value="<?php echo $sup['contact']; ?>" /></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Coins</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="coins" name="coins" class="k-textbox" style="color:#000; padding:5px;" placeholder="Coins" required validationMessage="Please enter No. Of Coins" value="<?php echo $sup['coins']; ?>" /></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Premium Coins</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="pcoins" name="pcoins" class="k-textbox" style="color:#000; padding:5px;" placeholder="Premium Coins" required validationMessage="Please enter No. Of Premium Coins" value="<?php echo $sup['pcoins']; ?>" /></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Gold</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="gold" name="gold" class="k-textbox" style="color:#000; padding:5px;" placeholder="Gold Amount" required validationMessage="Please enter No. Of Gold" value="<?php echo $sup['gold']; ?>" /></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">ActCode</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="actcode" name="actcode" class="k-textbox" style="color:#000; padding:5px;" placeholder="Activation Code" value="<?php echo $sup['actcode']; ?>" /></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Message from GMs</td><td class="rankingc" style="text-align:left; padding:5px;"><input type="text" id="msg" name="msg" class="k-textbox" style="color:#000; padding:5px;" placeholder="Enter the messege" required validationMessage="Please enter the messege" value="<?php echo $msg5; ?>" /></td></tr>
<tr><td class="rankingc" style="width:20px; text-align:left; padding-left:5px;">Tips to use "Message from GMs"</td><td class="rankingc" style="text-align:left; padding:5px;">If you want to type more then 1 lines in the message, here is an example message.<br>If you want output like this :- <br><font size="3" color="000000" face="Times New Roman"><center><marquee  direction=up loop=true height="50" scrollamount=1 style="border:#886046 2px SOLID">This is first line<br><b>This is Bold line</b><br>"This is Quoted line"<br></marquee></center></font><br> You will have to type :-<br>This is first line/(b)This is Bold line(!b)/`This is Quoted line` </td></tr>
<?php
}
echo '<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Characters in Account</td><td class="rankingc" style="text-align:left; padding-left:5px;">';
$charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_sheadera = '$account'");
$i = 1;
while ($sup2 = odbc_fetch_array($charquery))
{
echo $sup2['c_id']; if($i < odbc_num_rows($charquery)) { echo "(Level="; }{ echo $sup2['c_sheaderc']; }{ echo ", RB="; }{ echo $sup2['rb']; }{ echo ")"; }{ echo ", Char Status="; }{ echo $sup2['c_status']; }{ echo "<br>"; }
++$i;
}
?>
</table></td></tr>
<tr><td align="center" class="forms" style="text-align:center; font-size:28px; font-weight:800; width:100%;"> <input class="btn btn-success" name="doUpdate" type="submit" value="UPDATE ACCOUNT INFO" /></form></td></tr>
</table></div>
<tr><td align="center" width="960"><div id="login" align="center">
<table width="960" border="0" cellspacing="0" cellpadding="5" style="border-collapse:collapse;" align="center">
<tr><td class="forms" style="padding-left:7px; padding-top:px;">
Current Personal messege to the user from GMs : <font size="3" color="eeaf51" face="Times New Roman"><center><marquee  onmouseover="this.stop();" onmouseout="this.start();" direction=up loop=true height="100" scrollamount=1 style="border:#886046 2px SOLID"><?php 
$dsf1 = odbc_exec($con,"SELECT * FROM account WHERE c_id = '$account'");
$fgh1 = odbc_fetch_array($dsf1); ?>
<?php echo $fgh1['msg']; ?> <br /></marquee></center></font>
</td></tr>

</table>
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