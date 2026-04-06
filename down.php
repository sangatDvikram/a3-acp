<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Downloads</title>
	
<?php include 'header.php'; 
?>
    <div class="container-fluid">
     
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Downloads:</h1></div><!-- Heading -->
			   <!-- Write The fuck you want here -->
	  <div class="row-fluid ">
              <div class="span3">
              <div class="well" style=" padding: 8px;">
<ul class="nav nav-list">
<li class="nav-header">Downloads</li>
   <li> <a  href="#Client"  >Client</a></li>
   <li> <a  href="#Updater"  >Updater</a></li>
        </ul>
</div>      
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
			  <a id="client"></a>
			  <div class="page-header" style="margin-top:0;">
 			   <h1>Client:</h1></div><!-- Heading -->
			   <div class="row-fluid">
				<ul class="thumbnails">
              
              <li class="span6">
                <div class="thumbnail">
                  <img src="http://localhost/images/client.jpg"  title=" Download Ultimate Client" height="100" alt="Download Ultimate Client">
                  <div class="caption">
                    <h3>Ultimate Client</h3>
                    Used to download game client . <br>
					<br>
                    <a class="btn btn-large btn-inverse" href="http://localhost/downloads/A3Ultimate.rar" title=" Download Ultimate Client"><i class="icon-chevron-down icon-white"></i> Download</a>
                  </div>
                </div>
              </li> 
              </ul>
          </div>      
			   <a id="Updater"></a>
			  <div class="page-header" style="margin-top:0;">
 			   <h1>Updater</h1></div><!-- Heading -->
			   <div class="row-fluid">
				<ul class="thumbnails">
              
              <li class="span4">
                <div class="thumbnail">
                  <img src="http://localhost/images/patch64.jpg"  title=" Download Ultimate Uploader x34" alt="Download Ultimate Uploader x34">
                  <div class="caption">
                    <h3>Client Updater</h3>
                    Used to download game / update /patch game, Just run A3.exe or paste it into any other existing A3 Folder and then run it.<br>
					<br>
                    <a class="btn btn-large btn-danger" href="http://localhost/downloads/A3.exe"><i class="icon-chevron-down"></i> Download</a>
                  </div>
                </div>
              </li>
			  <li class="span4">
                <div class="thumbnail">
                  <img src="http://localhost/images.jpg" width="195" alt="">
                  <div class="caption">
                    <h3>
Microsoft .Net 2.0 Framework</h3>
                    Download only if running on Windows Xp.<br>
					<br>
                    <a class="btn btn-large " href="http://localhost/downloads/dotnetfx.exe"><i class="icon-chevron-down"></i> Download</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>

			   
              </div>
	</div>
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
