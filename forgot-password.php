<?php 
require_once "inc/config.php";
require_once "inc/secondary_functions.php";
require_once('phpmailer/class.phpmailer.php');
ini_set( "display_errors", 0);
/*if($_SESSION['username'] != "")
{
	header("Location: index.php");
}*/
$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = antisql($value); //get variables are filtered.
}

if ($_POST['doRecover']=='Recover')
{

foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}


$username = $data['username'];

$result = odbc_exec($con,"SELECT * FROM account WHERE c_id = '$username'"); 
$num = odbc_num_rows($result);
$result1 = odbc_exec($con,"SELECT contact FROM AccountInfo WHERE account = '$username'"); 
$num1 = odbc_num_rows($result1);
$password = odbc_result($result, "c_headera");
//$password = urlencode($password);
$contact = odbc_result($result1, "contact");
$emailid = odbc_result($result, "c_headerb");
$grade = odbc_result($result, "acc_status");
//$wtf ="http://api.znisms.com/post/mobilesms.asp?userid=00919555511333&apikey=7ce0dcd4e138222ef589d3da99c2a111&sendto=$contact&message=As%20requested%2C%20Here%20are%20the%20details%20of%20your%20A3%20Ultimate%20Account%0A%0AID%20-%20$username%0APassword%20-%20$password%0A%0AEnjoy%20Ultimate%20Gaming%20%3A)";
$sendsms = file_get_contents($wtf);   
$sql_insert1 = "INSERT INTO LoginLog (id, ip, datetime, action, logaction, grade) VALUES ('$username', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'Forgot Pass', 'email sent to $emailid', '$grade')";
		$query1 = odbc_exec($con2, $sql_insert1); 

$mail             = new PHPMailer();
$body             = "In response to your request, we are sending you your password details. 
					<br>
					Your ID is : <b>$username</b> <br>
					Your Password is : <b>$password </b>
					<br>
					<br>
					Regards,<br>
					Team Ultimate.
					";
$body             = eregi_replace("[\]",'',$body);
$mail->IsSMTP();
$mail->Host       = "crx.websitewelcome.com"; 
$mail->SMTPDebug  = 0;                                                         
$mail->SMTPAuth   = true;                 
$mail->SMTPSecure = "ssl";                 
$mail->Host       = "crx.websitewelcome.com";    
$mail->Port       = 465;                  
$mail->Username   = "support@a3ultimate.com";  // GMAIL username
$mail->Password   = "Gjmptw@789#";            // GMAIL password
$mail->SetFrom('support@a3ultimate.com', 'Team Ultimate');
$mail->AddReplyTo("support@a3ultimate.com","Team Ultimate");
$mail->Subject    = "Password Recovery for $username";
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->Encoding = "base64";
$mail->MsgHTML($body);
$address = odbc_result($result, "c_headerb");
$mail->AddAddress($address, "Team Ultimate");
$mailparts = explode("@", $address);

$output =truncate($mailparts[0]); 
$output .= "@" . $mailparts[1];
$numm = truncate($contact); 

//$mail->AddAttachment("/images/phpmailer.gif");      // attachment
//$mail->AddAttachment("/images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  $err[] = "<h4>Username does not exist!!$mail->ErrorInfo</h4>Please provide proper usename.";
} else {
  $msg[] = "Password sent to <strong>$output </strong> . If you cant access this email or don't get the password email, Please send an email to support@a3ultimate.com<br>";
}
    

}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Forgot Password</title>
    <?php include 'header.php'?>
    <div class="container-fluid">
    <div class="page-header">
    <h1>Forgot Password:</h1>
    </div>
     	   <?php	if(!empty($err))  {
	   echo "<div class=\"alert alert-error\" align=\"Center\">";
	  foreach ($err as $e) {
	    echo "$e <br>";
	    }
	  echo "</div>";
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"alert alert-info\" align=\"Center\">" . $msg[0] . "</div>";

	   }
	  ?>
	  <?php
				if (!isset($_SESSION['Player'])) {?>
    <div class="row-fluid" >
   
    
    <table width="960" border="0" cellspacing="0" cellpadding="5" style="border-collapse:collapse;" align="center">

<form action=" " method="POST">
<tr><td class="forms" style="text-align:center;">    
<p style="margin:0; padding:0; text-align:center">Enter your username below to recover password via your registered e-mail address.</p></td></tr>
<tr><td class="forms" align="center" style="text-align:center; margin-top:5px">
<input type="text" id="username" name="username" class="k-textbox" style="color:#000;" placeholder="Username" required validationMessage="Please enter a Username" />

</td></tr>
<tr><td class="forms" align="center" style="text-align:center;">
<button class=" btn btn-large  btn-success" name="doRecover" type="submit"   value="Recover">Recover</button>
</td></tr>
</form>
</table>


</div> 
<?php } 
else { echo "<p style='text-align:center'>You are alredy loged in click here to go to <a href='ACP'><span class='label label-info'>ACP</span></acp></p>" ;}?>

</div> <!-- /container -->
<?php include 'footer.php' ?>