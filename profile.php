<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - ACP Edit Profile</title>
<?php include 'header-acp.php'; 
page_protect();
$prot= odbc_exec($con,"SELECT * FROM account WHERE c_id = '$_SESSION[username]'");
$prot1 = odbc_fetch_array($prot);
$prot2 = $prot1['verified'];

$curpass = $prot1['c_headera'];
$gradee = $prot1['acc_status'];
$usr_email = $prot1['c_headerb'];

$prot12= odbc_exec($con,"SELECT * FROM AccountInfo WHERE account = '$_SESSION[username]'");
$prot11 = odbc_fetch_array($prot12);
$namea = $prot11['name'];
$phonea = $prot11['contact'];
$ref = $prot11['word'];
if($prot2 != "1") {
	header("Location: verify.php"); }
$err = array();
$msg = array();

if(isset($_POST['update']))
	{
		foreach($_POST as $key => $value) {
		$data[$key] = antisql($value); }
		$sql_insert0 = "INSERT INTO LoginLog (id, ip, datetime, action, logaction, grade) VALUES ('$_SESSION[username]', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'My Profile', 'Tried to change Profile, email=$usr_email, name=$namea, phone=$phonea ', '$gradee')";
		$query0 = odbc_exec($con2, $sql_insert0); 
		if(empty($data['fullname']) || strlen($data['fullname']) < 4) {
		$err[] = "ERROR : Invalid name. Please enter atleast 3 or more characters for your name"; }

		if (!checkPwd($data['password'],$data['rpassword'])) {
		$err[] = "ERROR : Invalid Password or mismatch. Enter 5 chars or more"; }

		$user_ip = $_SERVER['REMOTE_ADDR'];
		if($curpass != $data['cpassword']) {
		$err[] = "ERROR :  Invalid Current Password. Please enter correct  current Password"; };

		$host  = $_SERVER['HTTP_HOST'];
		$yoyo = $_SESSION['username'];
		if($yoyo == "testaccount") {
		$err[] = "ERROR :  You can't edit the Test Account"; };

		$host_upper = strtoupper($host);

		$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		
		$rs_duplicate = odbc_exec($con,"SELECT c_id FROM account WHERE c_id='$_SESSION[username]'");
		if (odbc_fetch_row($rs_duplicate) > 1)
		{ $err[] = "ERROR : The username already exists. Please try again with different username and email."; }

		if(empty($err)) {
		$sql_insert1 = odbc_exec($con, "UPDATE AccountInfo SET contact = '$data[tel]', name = '$data[fullname]' WHERE account = '$_SESSION[username]'");
		$sql_insert2 = "UPDATE account SET c_headera = '$data[password]' WHERE c_id = '$_SESSION[username]'";
		$query1 = odbc_exec($con, $sql_insert2); 
		if (!$query1){ $err[] = "ERROR : There was an error updating your account. Please try again later.";	}							
		else { 
				$sql_insert0 = "INSERT INTO LoginLog (id, ip, datetime, action, logaction, grade) VALUES ('$_SESSION[username]', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'My Profile', 'Changed Profile, email=$usr_email, name=$data[fullname], phone=$data[tel]' , '$gradee')";
		$query0 = odbc_exec($con2, $sql_insert0); 
		$msg[] = "Account Successfully Updated."; 
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
 			   <h1>Account Control Panel:&nbsp;&nbsp; <small>Edit Profile</small></h1></div>
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
			<?php 
$account = $_SESSION['username'];
$getinfo1 = odbc_exec($con,"SELECT * FROM account INNER JOIN AccountInfo ON account.c_id COLLATE DATABASE_DEFAULT = AccountInfo.account COLLATE DATABASE_DEFAULT WHERE account.c_id = '$account'");
while($res = odbc_fetch_array($getinfo1))
{
	?>
<table width="500" border="0" cellspacing="0" cellpadding="5" style="border-collapse:collapse;" >
<form action=" " method="POST" class="inline">
<tr><td >
<span for="id" class="required" style="width:150px;">Username</span></td><td>
<?php echo trim($res['c_id']); ?>
</td></tr>
<tr><td >
<span for="cpassword" class="required" style="width:150px;">Current Password</span></td><td>
<input id="cpassword" name="cpassword" type="password" class="k-textbox" style="color:#000;" placeholder="Current Password" required validationMessage="Please enter your current Password" <?php if(isset($_GET['cp'])){echo "value='".$_GET['cp']."'";}?> />
</td></tr>
<tr><td >
<span for="password" class="required" style="width:150px;">New Password</span></td><td>
<input id="password" name="password" type="password" class="k-textbox" style="color:#000;" placeholder="Password" required validationMessage="Please enter a Password" />
</td></tr>
<tr><td >
<span for="rpassword" class="required" style="width:150px;">New Repeat Password</span></td><td>
<input id="rpassword" name="rpassword" type="password" class="k-textbox" style="color:#000;" placeholder="Repeat Password"  required validationMessage="Please Repeat Password" />
</td></tr>
<tr><td >
<span for="fullname" class="required" style="width:150px;">Your Name</span></td><td>
<input type="text" id="fullname" name="fullname" class="k-textbox" style="color:#000;" placeholder="Full name" value="<?php echo trim($_SESSION['Player']); ?>" required validationMessage="Please enter Full Name" />
</td></tr>
<tr><td >
<span for="email" class="required" style="width:150px;">Email</span></td><td>
<?php echo trim($res['c_headerb']); ?>
</td></tr>
<tr><td >
<span for="tel" class="required" style="width:150px;">Phone</span></td><td>
<input type="tel" id="tel" name="tel" class="k-textbox" style="color:#000;" pattern="\d{10}" placeholder="Please enter a ten digit phone number" value="<?php echo trim($res['contact']); ?>" required validationMessage="Please enter a ten digit phone number"/>
</td></tr>
<tr><td >
<span for="Referral" class="required" style="width:150px;">Referred by</span></td><td>
<?php echo trim($ref); ?>
</td></tr>
<?php } ?>

<tr><td colspan="2">
<div class="form-actions">
<input class="btn btn-primary" name="update" type="submit" /></div>
</td></tr>
</form>
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