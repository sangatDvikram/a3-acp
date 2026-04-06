<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Manage Character</title>
	
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }
?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <div class="span3">
             <?php include 'side_bar_admin.php' ?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Admin Control Panel: <small>Select Character</small></h1></div>
			   <div class="alert">
1. Click on [VIEW] to see Account information.<br>2. Click on [EDIT] to edit Account information.
</div>
<form action=" " method="post">
<label for="type">Search By </label><select name="type" id="type" class="k-textbox" style="color:#000;"><option value="c_id">Name</option><option value="c_sheadera">Username</option></select>
<div class="input-append">
<input type="text"  name="term"  class="span9" placeholder="Enter character name"  data-provide="typeahead" data-items="10" data-source='[""<?php $sqlstring1="select top 100 * from charac0 ";
$r1= odbc_exec($con,$sqlstring1);
while($dd = odbc_fetch_array($r1)) {
echo ",\"".trim($dd['c_id'])."\"";
} ?>]'>
<input type="submit" name="S1" value="Search" class="btn"  >
</div>
</form>

	<?php 
if($_POST['S1'] == 'Search')
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }
$msg = array();
$err = array();

$query1 = "SELECT * FROM charac0 WHERE $data[type] LIKE '%$data[term]%'";
$rs1 = odbc_exec($con,$query1);
$num=odbc_num_rows($rs1);
if($num!=0){
echo '<tr><td align="center" class="forms" style="text-align:center; font-size:20px; font-weight:800; width:100%;margine:0;padding:0;"> - SEARCH RESULTS - </td></tr><tr><td class="forms" style="text-align:center; width:100%;">';
echo '<table border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; text-align:center; width:100%;margine:0;padding:0;"><tr><td class="rankingh">Character</td><td class="rankingh">Username</td><td class="rankingh">Level</td><td class="rankingh">RBs</td><td class="rankingh">Status</td><td class="rankingh">Action</td><td class="rankingh">Account Action</td></tr>';
while ($sup = odbc_fetch_array($rs1))
	{
?>
<tr><td class="rankingc" style="text-align:center;"><?php if($sup['pnline'] == 1){echo "<img src='http://$_SERVER[SERVER_NAME]/images/status.png' title='online'>";}else{echo "<img src='http://$_SERVER[SERVER_NAME]/images/status-offline.png' title='offline'>";} echo $sup['c_id']; ?></td><td class="rankingc" style="text-align:center;"><?php echo $sup['c_sheadera']; ?></td><td class="rankingc" style="text-align:center;"><?php echo $sup['c_sheaderc']; ?></td><td class="rankingc" style="text-align:center;"><?php echo $sup['rb']; ?></td><td class="rankingc" style="text-align:center;"><?php echo $sup['c_status']; ?></td><td class="rankingc"><a href="/Admin/viewchar/<?php echo $sup['sr_no']; ?>/" title="View Character Info.">[VIEW]</a> <a href="/Admin/editchar/<?php echo trim($sup['c_id']); ?>/" title="Edit Character Information">[EDIT]</a> <a href="#" title="View Inventory">[INVENTORY]</a> </td><td class="rankingc"><a href="/Admin/ViewAccount/<?php echo $sup['c_sheadera']; ?>/" title="View Account Info.">[VIEW]</a> <a href="/Admin/EditAccount/<?php echo $sup['c_sheadera']; ?>/" title="Edit Account Information">[EDIT]</a> </td></tr>
<?php
}
?></table></td></tr>
</table>
</td></tr>
<?php }
else {echo "<div class='alert alert-error'><h4>$data[term]  not found in the database.</h4></div>";}}?>
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
