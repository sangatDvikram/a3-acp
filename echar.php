<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Edit Character Info</title>
	
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }


$character = antisql($_GET['char']);
page_protect();

if($_POST['doUpdate'] == 'UPDATE CHARACTER INFO')
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }
$msg = array();
$err = array();

$result = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$character'"); 
$num = odbc_num_rows($result);
$char1 = odbc_result($result, "c_id");
$chartype1 = odbc_result($result, "c_sheaderb");
$lvl1 = odbc_result($result, "c_sheaderc");
$rb1 = odbc_result($result, "rb");
$wz1 = odbc_result($result, "c_headerc");
$reset1 = odbc_result($result, "reset");
$status1 = odbc_result($result, "c_status");
$gold1 = odbc_result($result, "gold");
$mbody = odbc_result($result, "m_body");
$online = odbc_result($result, "pnline");
$online_duration = odbc_result($result, "online");
$restart = odbc_result($result, "d_restart");

if($online!=1){
$sql_insert1 = "INSERT INTO LoginLog (id, ip, datetime, action, logaction, grade) VALUES ('$_SESSION[username]', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'Pre Edit Char', 'char=$char1, type=$chartype1, lvl=$lvl1, RB=$rb1, WZ=$wz1, reset=$reset1, status=$status1', '$_SESSION[grade]')";
		$query1 = odbc_exec($con2, $sql_insert1); 
$lap = "UPDATE charac0 SET c_id = '$data[name]', c_sheaderb = '$data[CharacterType]',online = '$data[online]', op = '$data[op]',  c_sheaderc = '$data[level]', c_headerc = '$data[woonz]', rb = '$data[rebirths]', reset = '$data[reset]', c_status = '$data[c_status]', d_restart = '$data[d_restart]' WHERE c_id = '$character'";
$top = odbc_exec($con, $lap);
$sql_insert2 = "INSERT INTO LoginLog (id, ip, datetime, action, logaction, grade) VALUES ('$_SESSION[username]', '$_SERVER[REMOTE_ADDR]', CONVERT(DATETIME, '$date', 102), 'Post Edit Char', 'char=$data[name], type=$data[CharacterType], lvl=$data[level], RB=$data[rebirths], WZ=$data[woonz], reset=$data[reset], status=$data[c_status]', '$_SESSION[grade]')";
		$query1 = odbc_exec($con2, $sql_insert2); 

if($top) {
	$msg[] = "Character successfully updated."; }
	else { $err[] = "Error : Cannot update this character."; }
}
else { $err[] = "Error : Character is still online, You can update character info only when it is offline .";}
}
?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
               <div class="span3">
             <?php include 'side_bar_admin.php' ?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->



<div class="page-header" style="margin-top:0;">
<?php 
$result = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$character'");
$sup=odbc_fetch_array($result); ?>
 			   <h1> Edit character info:-<small> <?php if($sup['pnline'] == 1){echo "<img src='http://$_SERVER[SERVER_NAME]/images/status.png' title='online'>";}else{echo "<img src='http://$_SERVER[SERVER_NAME]/images/status-offline.png' title='offline'>";} echo $character;?></small></h1></div>
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
 
<form method="post" action=" ">
<?php
$sqlstring1="SELECT c_headera FROM charac0 WHERE c_id = '$character'";
$rsstring1=odbc_exec($con,$sqlstring1);
$charstring1 = odbc_result($rsstring1,'c_headera');
$temp1 = explode(";",$charstring1);
$STR = $temp1[0];
$INT = $temp1[1];
$DEX = $temp1[2];
$VITAL = $temp1[3];
$MANA = $temp1[4];
$RSTAT = $temp1[5];
$HP = $temp1[6];
$MP = $temp1[7];
$HPLEFT = $temp1[8];
$MPLEFT = $temp1[9];
$query1 = "SELECT * FROM charac0 WHERE c_id = '$character'";
$rs1 = odbc_exec($con,$query1);

echo '<tr><td align="center" class="forms" style="text-align:center; font-size:20px; font-weight:800; width:100%;"> - EDIT CHARACTER DETAILS - </td></tr><tr><td class="forms" style="text-align:center; width:960px;">';
echo '<table border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; text-align:center; width:100%;" class="table table-bordered">';
while ($sup = odbc_fetch_array($rs1))
	{
?>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Character</td><td class="rankingc" style="text-align:left; padding:5px;">
<input type="text" id="name" name="name" class="k-textbox" style="color:#000; padding:5px;" placeholder="Character Name" required validationMessage="Please enter a Character Name." value="<?php echo $sup['c_id']; ?>" /></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Username</td><td class="rankingc" style="text-align:left; padding:5px;"><?php echo $sup['c_sheadera']; ?></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Character Type</td><td class="rankingc" style="text-align:left; padding-left:5px;">
<select id="CharacterType" name="CharacterType" style="width:140px;">
<option value="1" <?php if($sup['c_sheaderb'] == "1") { echo "selected"; } ?>>HK</option>
<option value="0" <?php if($sup['c_sheaderb'] == "0") { echo "selected"; } ?>>Warrior</option>
<option value="2" <?php if($sup['c_sheaderb'] == "2") { echo "selected"; } ?>>Mage</option>
<option value="3" <?php if($sup['c_sheaderb'] == "3") { echo "selected"; } ?>>Archer</option>
</select></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Level</td><td class="rankingc" style="text-align:left; padding:5px;">
<input type="text" id="level" name="level" class="k-textbox" style="color:#000; padding:5px;" placeholder="Character Level" required validationMessage="Please enter a Character Level." value="<?php echo $sup['c_sheaderc']; ?>" /></td></tr>
<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Rebirths</td><td class="rankingc" style="text-align:left; padding:5px;">
<input type="text" id="rebirths" name="rebirths" class="k-textbox" style="color:#000; padding:5px;" placeholder="Character Rebirths" value="<?php echo $sup['rb']; ?>" /></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Woonz</td><td class="rankingc" style="text-align:left; padding:5px;">
<input type="text" id="woonz" name="woonz" class="k-textbox" style="color:#000; padding:5px;" placeholder="Character Woonz" required validationMessage="Please enter Character Woonz." value="<?php echo $sup['c_headerc']; ?>" /></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">reset</td><td class="rankingc" style="text-align:left; padding:5px;">
<input type="text" id="reset" name="reset" class="k-textbox" style="color:#000; padding:5px;" placeholder="reset" required validationMessage="Please enter Character reset." value="<?php echo $sup['reset']; ?>" /></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Status</td><td class="rankingc" style="text-align:left; padding:5px;">
<input type="text" id="c_status" name="c_status" class="k-textbox" style="color:#000; padding:5px;" placeholder="Character Status" required validationMessage="Please enter Character reset." value="<?php echo $sup['c_status']; ?>" /></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Online Time Spent</td><td class="rankingc" style="text-align:left; padding:5px;">
<input type="text" id="online" name="online" class="k-textbox" style="color:#000; padding:5px;" placeholder="online" required validationMessage="Please enter online." value="<?php echo $sup['online']; ?>" /></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">Online Points(OP)</td><td class="rankingc" style="text-align:left; padding:5px;">
<input type="text" id="op" name="op" class="k-textbox" style="color:#000; padding:5px;" placeholder="op" required validationMessage="Please enter OP." value="<?php echo $sup['op']; ?>" /></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">RB lvl for shout</td><td class="rankingc" style="text-align:left; padding:5px;">
<input type="text" id="d_restart" name="d_restart" class="k-textbox" style="color:#000; padding:5px;" placeholder="d_restart" required validationMessage="Please enter d_restart." value="<?php echo $sup['d_restart']; ?>" /></td></tr>

<tr><td class="rankingh" style="width:20px; text-align:left; padding-left:5px;">m_body</td><td class="rankingc" style="width:20px; text-align:left; padding-left:5px;"><?php echo wordwrap($sup['m_body'], 95, "\n",true); ?></td></tr>
<?php
}
?>
</td></tr>
</table></td></tr>
<tr><td align="center" class="forms" style="text-align:left; font-size:20px; font-weight:800; width:960px;"> <input align="center" class="btn btn-info" name="doUpdate" type="submit" value="UPDATE CHARACTER INFO" /></form></td></tr>
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