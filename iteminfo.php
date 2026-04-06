<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3Ultimate - Item Details</title>
	
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }
?>
    <div class="container-fluid">
     <div class="page-header" style="margin-top:0;">
 			   <h1>Item Details:
</h1></div>
          <div class="row-fluid ">
		            <!-- Menu -->
              <div class="span12"><!-- Main -->
              
	 <form action=" " method="post" class="form-inline">
<div class="form-actions" align="center">
Search By <select name="type" id="type" class="k-textbox" style="color:#000;"><option value="1">All</option><option value="ownerid">ID</option><option value="buyeip">IP</option><option value="owner">Character</option></select>
Result Count <input type="text" class="k-textbox" name="count" placeholder="Input Result Count" value="100"  style="color:#000;" >Char/Id<input type="text" class="k-textbox" name="term" value="1" style="color:#000;" >
<input type="submit" name="S1" value="Search" class="btn btn-primary" style="height:27px;" /></div>
</form>
             <table class='table table-condense' >
	<thead>
    <tr>
      <th>Sr</th>
      <th>Item</th>
      <th>Type</th>
      <th>Image</th>
      <th>Extra</th>
	  </tr>
  </thead>
  <tbody>
    
	<?php
	
$rs1 =odbc_exec($con2,"SELECT * FROM itemlist order by code asc ");	
	
	while($dd = odbc_fetch_array($rs1)) { 
     echo "<tr> <td>$dd[code]</td>
      <td>".clear(rtrim($dd['itmname']))."</td>
      <td>$dd[ittype]</td>
      <td><a href='$dd[image]'>Image</a></td>
      <td>$dd[itclass]</td>
     ";
     $i++;
	  }
	  ?>
   
  </tbody>
</table>
			
</div><!-- Main -->
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