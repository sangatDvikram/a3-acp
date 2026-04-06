<?php 
require_once "inc/config.php";
require_once "inc/secondary_functions.php";

ini_set( "display_errors", 0);
	$err = array();
	$msg = array();
	
	
foreach($_GET as $key => $value) {
	$get[$key] = antisql($value); //get variables are filtered.
}

if(isset($_POST['reset']))
{

foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
	    $raw_name=$_SESSION['raw_name'];
		unset($_SESSION['raw_name']);		
		$raw_pname=$_SESSION['raw_pname'];
		unset($_SESSION['raw_pname']);
		$raw_add=$_SESSION['raw_add'];
		unset($_SESSION['raw_add']);
		$raw_cod=$_SESSION['raw_cod'];
		unset($_SESSION['raw_cod']);
		$new1=GenKey();
		
		$result = odbc_exec($con,"SELECT * FROM account WHERE c_id = '$raw_name' AND c_status='L'"); 
		$user= odbc_fetch_array($result); 

		if(odbc_num_rows($result) > 0){

			$sql_insert0 = "INSERT INTO LoginLog (id, ip, datetime, action, logaction, grade) VALUES ('$raw_name', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'ACCOUNT', 'Generated New Pass, email=$raw_add, name=$raw_name ', 'Normal')";
			$query0 = odbc_exec($con2, $sql_insert0); 
			$sql_insert2 = "UPDATE account SET c_headera = '$new1' , c_status='A' WHERE c_id = '$raw_name' AND c_status='L'";
			$query1 = odbc_exec($con, $sql_insert2); 
			$log = "Hello ".$raw_pname.",<br>Your Account Password is old and need to be changed.<br>
			As per your request new generated password is <b>$new1</b> <br>Please Login using your new password and change it accordingly.<br>
			Follow the Link to Login to ACP.<a href=\"http://$_SERVER[HTTP_HOST]/ACP/MyProfile/?cp=$new1\"><b>Click Here.</b></a><br>
			If you can't see the link please copy paste the following link into your address bar and press enter.<br>http://$_SERVER[HTTP_HOST]/ACP/MyProfile/?cp=$new1
			<br>
			- Admin, <br>Team Ultimate";
			
			$address = $raw_add;
			log_action($user['c_id'],"N.A",$log,$con);
			$subject = "A3 Ultimate : New account password.";
			email_action($user['c_id'],$subject,$log,$con);
			$mailparts = explode("@", $address);
			$output = truncate($mailparts[0]);
			$output .= "@" . $mailparts[1];
				$msg[] ="<h4>New generated password has been sent.</h4><strong>New generated password has been sent to <b>$output</b> .<br> If you cant access this email or don't get the password email, Please send an email to support@a3ultimate.com</strong>";
			}
			else
			{
				$err[] = "Something went wrong.";
				 @mkdir("userlogs/Dharamlog/".date("Y")."/".date("F")."",0755, true);
                        $logf = fopen("userlogs/Dharamlog/".date("Y")."/".date("F")."/".date("jS")."-".date("F")."-Dharamlog-log.txt", "a+");
                        fprintf($logf, "Date: %s  Account : %s \r\n", date("d-m-Y h:i:s A"),$raw_name);
                        fclose($logf);
			}

}
if(isset($_POST['verify']))
{
	foreach($_POST as $key => $value) {
		$data[$key] = antisql($value); // post variables are filtered
	}
		$raw_name=$_SESSION['raw_name'];
		//unset($_SESSION['raw_name']);
		$raw_pname=$_SESSION['raw_pname'];
		//unset($_SESSION['raw_pname']);
		$raw_add=$_SESSION['raw_add'];
		//unset($_SESSION['raw_add']);
		$raw_cod=$_SESSION['raw_cod'];
		//unset($_SESSION['raw_cod']);
		$result = odbc_exec($con,"SELECT * FROM account WHERE c_id = '$raw_name' "); 
		$user= odbc_fetch_array($result); 
		$log = "Hello ".$raw_pname.",<br>Your Account needs to be verified.<br>To verify the email id <a href=\"http://$_SERVER[SERVER_NAME]/verifyemail.php?acc=".$user['c_id']."&code=".$user['actcode']."\"><b>Click Here</b></a><br>
		If you can't see the link please copy paste the following link into your address bar and press enter.<br>http://$_SERVER[SERVER_NAME]/verifyemail.php?acc=".$user['c_id']."&code=".$user['actcode']."<br>- Admin Ultimate";
		$address = $raw_add;
		log_action($user['c_id'],"N.A",$log,$con);
		$subject = "A3 Ultimate : Verify your account.";
		email_action($user['c_id'],$subject,$log,$con);
		$mailparts = explode("@", $address);
		$output = truncate($mailparts[0]);
		$output .= "@" . $mailparts[1];
			$msg[]= "<h4 align='center'>Acount acctivation link has been sent.</h4><align='center'>Acount acctivation link has been sent to $output .<br> If you cant access this email or don't get the password email, Please send an email to support@a3ultimate.com</strong>";
	}//Start form Processing
if(isset($_POST['doLogin']))//Start form Processing
{
foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}

$username = $data['username'];
$password = $data['password'];
$result = odbc_exec($con,"SELECT c_id,actcode,c_headerb,c_headera,c_status,acc_status,verified,msg,unban_date FROM account WHERE c_id = '$username' AND c_headera = '$password'"); 
$num = odbc_num_rows($result);
$user= odbc_fetch_array($result); 
$unban_date = odbc_result($result, "unban_date");
$unban_date = ($unban_date=='') ? "" : "  <br> Your account will automatically unban on $unban_date hrs. "; 
$sql_insert0 = "INSERT INTO login (id, ip, datetime, action, logaction, grade) VALUES ('$username', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'Login', 'tried to login', 'Unknown')";
$query0 = odbc_exec($con2, $sql_insert0); 
$dsf = odbc_exec($con,"SELECT * FROM AccountInfo WHERE account = '$username'");
$fgh = odbc_fetch_array($dsf); 
$_SESSION['raw_name']=$username;
$_SESSION['raw_pname']=$fgh['name'];
$_SESSION['raw_add']=$user['c_headerb'];
$_SESSION['raw_cod']=$user['actcode'];
//$user="$username";
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) {
	//is as verifed accout.
	if($user['verified'] == 1)
	{
	
	$username = odbc_result($result, "c_id");
	$password = odbc_result($result, "c_headera");
	$c_status = odbc_result($result, "c_status");
	$grade = odbc_result($result, "acc_status");
	$msg1 = odbc_result($result, "msg");
	
	if($c_status=='L'){
	$mailparts = explode("@", $user['c_headerb']);
		$output = truncate($mailparts[0]);
		$output .= "@" . $mailparts[1];

		$msg[] = "<h4 align='center'>Your account password has been expired. To generate new password Please Click on 'Generate New Password' button. </h4><form method='post' action='http://$_SERVER[HTTP_HOST]/Login' class='inline' style='margin:0;padding:0'>
		<button type='submit' name='reset' class='btn btn-inverse pull-right inline' >Generate New Password</button>
		</form> 
		New Password will be sent to <b>$output</b> . Click  <strong>'Generate New Password'</strong> to recive new password details on your respective email . <br>If you cant access this email or don't recieve new password via email, Please contact support@a3ultimate.com
		
		";
	
	}
		else {
	if($c_status=='A'||$c_status=='Z'||$c_status=='D'){
	
	if(empty($err)){			
	  // session_regenerate_id (true); //prevent against session fixation attacks.
		@session_start();
	   // this sets variables in the session 
		$_SESSION['username'] = $username;
		$_SESSION['c_status'] = $c_status;
		$_SESSION['grade'] = $grade;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		$_SESSION['Player']= $username;
		
		//update the timestamp and key for cookie
		$stamp = time();
		$ckey = GenKey();
		odbc_exec($con,"UPDATE account SET ctime = '$stamp', ckey = '$ckey' WHERE c_id='$username'");
		odbc_exec($con,"UPDATE account SET online = 1 WHERE c_id='$username'");
		//set a cookie 
	   if(2==2){
				  setcookie("c_id", $_SESSION['username'], time()+60*60*24*'COOKIE_TIME_OUT', "/");
				  setcookie("userkey", sha1($ckey), time()+60*60*24*'COOKIE_TIME_OUT', "/");
				  setcookie("username",$_SESSION['username'], time()+60*60*24*'COOKIE_TIME_OUT', "/");
		}	
		  $sql_insert2 = "INSERT INTO login (id, ip, datetime, action, logaction, grade) VALUES ('$username', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'Login', 'Just Logged in', '$grade')";
		$query1 = odbc_exec($con2, $sql_insert2); 
		if(isset($_SESSION['redirect_url']))
		{
		$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : '/';
		unset($_SESSION['redirect_url']);
		header("Location: $redirect_url");
		exit;
		 }
		 else{
		 header("Location:http://$_SERVER[SERVER_NAME]/ACP/"); }
		 }
		
		} else {	
		$err[] = "<h4>$msg1</h4>$unban_date";
		
		}
		}
		}
		else{
		$mailparts = explode("@", $user['c_headerb']);
		$output = truncate($mailparts[0]);
		$output .= "@" . $mailparts[1];

		$msg[] = "<h4 align='center'>Your account need to be vefied</h4>.<form method='post' action='http://$_SERVER[HTTP_HOST]/Login' class='inline' style='margin:0;padding:0'>
		<button type='submit' name='verify' class='btn btn-success pull-right inline' >Send</button>
		</form> 
		Account verification link will be sent to $output . Click  <strong>'Send'</strong> to recive varification email . <br>If you cant access this email or don't get the password email, Please send an email to support@a3ultimate.com
		
		";}
		}
		else
		{
		$err[] = "<h4>Invalid Id/password. </h4>Please use the forgot password option or send an email to support@a3ultimate.com if you have lost the access to your registered email account.";
		}
	
}


?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - ACP Login</title>
    <?php include 'header.php' ?>
    <div class="container-fluid">
    <div class="page-header">
    <h1>Account Control Panel:&nbsp;&nbsp; <small>Login</small></h1>
    </div>
     	   <?php	
	if(!empty($err))  {
	   echo "<div class=\"alert alert-error\" align=\"Center\">";
	  foreach ($err as $e) {
	    echo "$e <br>";
	    }
	  echo "</div>";
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"alert alert-block\"> <button type='button' class='close' data-dismiss='alert'>&times;</button>" . $msg[0] . "</div>";

	   }
	   if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			echo "<div class=\"alert alert-success\" align=\"Center\"><h4>You are successfully Loged Out</h4>Thank You For Using ACP !!</div>";
		} 
		 if (isset($_GET['err']) && $_GET['err'] == 1) {
			echo "<div class=\"alert alert-error\" align=\"Center\"><h4>Notice : The Activation code is incorrect. </h4> Please verify the code and try again.</div>";
		} 
		 if (isset($_GET['act']) && $_GET['act'] == 1) {
			echo "<div class=\"alert alert-info\" align=\"Center\"><h4>Notice : Account already Activated.</h4>You can login!!</div>";
		} 
		 if (isset($_GET['ban']) && $_GET['ban'] == 1) {
			echo "<div class=\"alert alert-error\" align=\"Center\"><h4>Notice : Your account is banned.</h4>Please contact support. You will be redirected to the support page in 5 seconds.</div>";
			echo '<META HTTP-EQUIV=Refresh CONTENT="5; URL='."http://support.a3ultimate.com".'">';
		} 
		 if (isset($_GET['success']) && $_GET['success'] == 1) {
			echo "<div class=\"alert alert-success\" align=\"Center\"><h4>Your account is now Activated.</h4>Welcome to A3Ultimate Enjoy Gamming !!</div>";
		} 
		if (isset($_GET['verify']) && $_GET['verify'] == 1) {}
		
	  ?>
	  <?php
				if (!isset($_SESSION['Player'])) {?>
    <div id="row" >
    <form class="form-horizontal" method="post" action="http://<?php echo "$_SERVER[HTTP_HOST]";?>/Login ">
    <div class="control-group">
    <label class="control-label" for="inputEmail" style="width:40%; margin-right:10px;">Username</label>
    <div class="controls">
    <input type="text" id="username" name="username" placeholder="Username" required validationMessage="Please enter a Username" />
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputPassword"  style="width:40%; margin-right:10px;">Password</label>
    <div class="controls">
    <input type="password" name="password" id="inputPassword" placeholder="Password"  required validationMessage="Please enter a Password" />
    </div>
    </div>
    <div class="control-group">
    <div class="controls">
    <label class="checkbox" style="margin-left:28%">
     <a href="http://<?php echo "$_SERVER[HTTP_HOST]";?>/ForgotPass/" style="color:#09C">Forgot Password</a>
    </label>
    <button type="submit"  name="doLogin" class="btn btn-primary"  style="margin-left:30%">Login</button>
    </div>
    </div>
    </form>

</div> 

<?php } 
else { echo "<p style='text-align:center'>You are alredy loged in click here to go to <a href='ACP/'><span class='label label-info'>ACP</span></acp></p>" ;}?>

</div> <!-- /container -->

<?php include 'footer.php' ?>