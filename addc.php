<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Give Premium Coins</title>
	
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }


$msg = array();

if ($_POST['doGive']=='Give Coins')
{

foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}


$username = $data['username'];
$extra = $data['extra'];
$coins = 0;
$result = odbc_exec($con,"SELECT c_id,pcoins FROM account WHERE c_id = '$username'"); 
$num = odbc_num_rows($result);
$coins = odbc_result($result, "pcoins");
$ncoins = $coins + $data['pcoins'] + $extra;
$newcoins = $data['pcoins'] + $extra;
$query = odbc_exec($con,"UPDATE account SET pcoins = '$ncoins' WHERE c_id = '$username'");
$query2 = odbc_exec($con, "INSERT INTO coinlog(GMName,eshopper,coinsadded,extra,DateTime) VALUES('$_SESSION[username]','$data[username]','$data[pcoins]','$data[extra]', CONVERT(DATETIME, '$date', 102))");
if($query)
{ 
$msg[] = "$data[pcoins] + $data[extra] Premium Coins have been successfully added, Into account $data[username] !!";
$log = "Hello,<br>You have successfully purchased ".$data['pcoins']." Premium coins in id: ".$username.".<br>You have recived ".$extra." extra Premium coins as an offer. Total Premium coins added to your account is ".$newcoins."<br> Thus, You now have ".$ncoins." Premium Coins in your account.<br>You can use these Premium coins to shop at our awesome E-Shop.<br><a href=\"/Eshop/\">Click Here</a> to go to our E-Shop. <br><br> - Eshop Admin Ultimate";
log_action($username,"N.A",$log,$con);
$subject = "A3 Ultimate : ".$newcoins." Premium coins credited to your account.";
email_action($username,$subject,$log,$con);
}
}
if ($_POST['doGive1']=='Give Coins')
{

foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}


$username = $data['username'];
$extra = $data['extra'];
$result = odbc_exec($con,"SELECT c_id,c_sheadera FROM charac0 WHERE c_id = '$username'"); 
$name = odbc_result($result, "c_sheadera");
$coins = 0;
$result = odbc_exec($con,"SELECT c_id,pcoins FROM account WHERE c_id = '$name'"); 
$num = odbc_num_rows($result);
$coins = odbc_result($result, "pcoins");
$ncoins = $coins + $data['pcoins'] + $extra;
$newcoins = $data['pcoins'] + $extra;
$query = odbc_exec($con,"UPDATE account SET pcoins = '$ncoins' WHERE c_id = '$name'");
$query2 = odbc_exec($con, "INSERT INTO coinlog(GMName,eshopper,coinsadded,extra,DateTime) VALUES('$_SESSION[username]','$data[username]','$data[pcoins]','$data[extra]', CONVERT(DATETIME, '$date', 102))");
if($query)
{ 
$msg[] = "$data[pcoins] + $data[extra] Premium Coins have been successfully added, Into character $data[username] !!";
$log = "Hello,<br>You have successfully purchased ".$data['pcoins']." Premium coins in id: ".$name.".<br>You have recived ".$data['extra']." extra Premium coins as an offer. Total Premium coins added to your account is ".$newcoins."<br> Thus, You now have ".$ncoins." Premium Coins in your account.<br>You can use these Premium coins to shop at our awesome E-Shop.<br><a href=\"/Eshop/\">Click Here</a> to go to our E-Shop. <br><br> - Eshop Admin Ultimate";
log_action($name,"N.A",$log,$con);
$subject = "A3 Ultimate : ".$newcoins." Premium coins credited to your account.";
email_action($name,$subject,$log,$con);
}
}
?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <div class="span3">
             <?php include 'side_bar_admin.php' ?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Admin Control Panel: <small>Give Premium Coins</small></h1></div>
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
	  <h3>By Username</h3>
<form action=" " method="POST">
<div class="control-group" align="Center">
<input type="text" id="username" name="username" class="k-textbox" style="color:#000;" placeholder="Username" required validationMessage="Please enter a Username" data-provide="typeahead" data-items="10" data-source='[""<?php $sqlstring1="select top 10 * from account ";
$r1= odbc_exec($con,$sqlstring1);
while($dd = odbc_fetch_array($r1)) {
echo ",\"".trim($dd['c_id'])."\"";
} ?>]'/>
<input type="text" id="pcoins" name="pcoins" class="k-textbox" style="color:#000;" placeholder="Premium Coins" required validationMessage="Please enter number of Premium coins" />
<input type="text" id="pextra" name="extra" class="k-textbox" style="color:#000;" placeholder="Offer extra Coins" required validationMessage="Extra offer Premium Coins" /></div>
<div class="form-actions" align="Center">

<input class="btn btn-primary" name="doGive" type="submit"  value="Give Coins" />
</div>
</form>
<h3>By Character</h3>
<form action=" " method="POST">
<div class="control-group" align="Center">
<input type="text" id="username" name="username" class="k-textbox" style="color:#000;" placeholder="Character" required validationMessage="Please enter a Username" data-provide="typeahead" data-items="10" data-source='[""<?php $sqlstring1="select top 10 * from charac0 ";
$r1= odbc_exec($con,$sqlstring1);
while($dd = odbc_fetch_array($r1)) {
echo ",\"".trim($dd['c_id'])."\"";
} ?>]'/>
<input type="text" id="cpcoins" name="pcoins" class="k-textbox" style="color:#000;" placeholder="Premium Coins" required validationMessage="Please enter number of Premium coins" />
<input type="text" id="cextra" name="extra" class="k-textbox" style="color:#000;" placeholder="Offer extra Coins" required validationMessage="Extra offer Premium Coins" /></div>
<div class="form-actions" align="Center">

<input class="btn btn-primary" name="doGive1" type="submit"  value="Give Coins" />
</div>
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
<script type="text/javascript">
  $('#pcoins').keyup(function () {
    
  var val=$(this).val();
  var total=val*0;
  total=Math.ceil(total);
  $('#pextra').val(total);
 
  

   return false;
  });
   $('#ccoins').keyup(function () {
    
  var val=$(this).val();
  var total=val*0.3;
  total=Math.ceil(total);
  $('#cextra').val(total);
 
  

   return false;
  });
</script>
<?php include 'footer.php';?>
