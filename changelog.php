<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="windows-1252">
    <title>A3 Ultimate - Changelogs</title>
<?php include 'header.php'; ?>
    <div class="container-fluid">
      
          
          <div class="row-fluid ">
              <!--<div class="span3">
              <?php //include 'side_bar.php';?>
            </div> Menu -->
              <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			  
<tr><td align="center" width="960"><div id="login" align="center">
		<h1>A3 Ultimate : <span style="color:#B60404;text-shadow: 1px 1px 3px #E55E5E;font-family:Calibri;font-size:32px">Changelogs</span></h1></div>
</div></td></tr>

<?php include 'changelogbox.php' ?>

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