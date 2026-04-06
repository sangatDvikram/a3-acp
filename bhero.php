<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Board of Heros</title>
	
<?php include 'header.php'; 

//header('Refresh: 60');// Set the time here in seconds
?>
    <div class="container-fluid">
      
        <script>
  $(document).ready(function()
  {
  $('#heros').load('http://<?php echo "$_SERVER[HTTP_HOST]"; ?>/Stats/bhero.php?randval='+ Math.random());
  $('#top').load('http://<?php echo "$_SERVER[HTTP_HOST]"; ?>/Stats/top.php?randval='+ Math.random());
  $('#pvpk').load('http://<?php echo "$_SERVER[HTTP_HOST]"; ?>/Stats/pvpkiller.php?randval='+ Math.random());
  $('#killer').load('http://<?php echo "$_SERVER[HTTP_HOST]"; ?>/Stats/killer.php?randval='+ Math.random());
  $('#noobs').load('http://<?php echo "$_SERVER[HTTP_HOST]"; ?>/Stats/noobs.php?randval='+ Math.random());
	 

   
   
  });
   </script>  
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Board of Heros:</h1></div>
	<?php if(isset($_GET['act']) && $_GET['act']=="Online"){?>
	
	<ul id="myTab" class="nav nav-tabs">

              <li ><a href="#boh" data-toggle="tab" >Board of Heroes</a></li>
              
               <li><a href="#pvpkk" data-toggle="tab" >Recent 25 PKs</a></li>
                <li><a href="#top" data-toggle="tab" >Top 25 Online Player</a></li>
             <li><a href="#kill" data-toggle="tab" >TOP 25 Killer</a></li>
             <li><a href="#noob" data-toggle="tab" >TOP 25 Dead Emperors</a></li>
			  
            </ul>
 
			<div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in " id="boh">
			  <div class="well" style=" padding: 8px;">
               <span id="heros"></span>
			   </div>
              </div>

              <div class="tab-pane fade in " id="top">
        <div class="well" style=" padding: 8px;">
               <span id="top"></span>
         </div>
              </div>

              <div class="tab-pane fade in " id="pvpkk">
              <div class="well" style=" padding: 8px;">
              <span id="pvpk"></span>
         </div>
         
              </div>
              <div class="tab-pane fade in " id="kill">
            <div class="well" style=" padding: 8px;">
         <span id="killer"></span>
              </div>
              </div> 
              <div class="tab-pane fade in " id="noob">
            <div class="well" style=" padding: 8px;">
         <span id="noobs"></span>
              </div>
              </div> 
			  <div class="tab-pane fade in active" id="ser">
            <div class="well" style=" padding: 8px;">
			   <span id="aonl"></span>
              </div>
              </div> 
	
	
	<?php } else{?>
			<ul id="myTab" class="nav nav-tabs">

              <li class="active"><a href="#boh" data-toggle="tab" >Board of Heroes</a></li>
               
              <li><a href="#pvpkk" data-toggle="tab" >Recent 25 PKs</a></li>
               <li><a href="#top" data-toggle="tab" >Top 25 Online Player</a></li>
             <li><a href="#kill" data-toggle="tab" >TOP 25 Killer</a></li>
             <li><a href="#noob" data-toggle="tab" >TOP 25 Dead Emperors</a></li>
             
			  
            </ul>
 
			<div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in active" id="boh">
			  <div class="well" style=" padding: 8px;">
               <span id="heros"></span>
			   </div>
              </div>
              <div class="tab-pane fade in " id="pvpkk">
              <div class="well" style=" padding: 8px;">
              <span id="pvpk"></span>
         </div>
         
              </div>
              <div class="tab-pane fade in " id="top">
              <div class="well" style=" padding: 8px;">
              <span id="top"></span>
         </div>
         
              </div>
              <div class="tab-pane fade in " id="kill">
            <div class="well" style=" padding: 8px;">
         <span id="killer"></span>
              </div>
              </div> 
              <div class="tab-pane fade in " id="noob">
            <div class="well" style=" padding: 8px;">
         <span id="noobs"></span>
              </div>
              </div> 
			  <div class="tab-pane fade in " id="ser">
            <div class="well" style=" padding: 8px;">
			   <span id="aonl"></span>
              </div>
              </div> <?php }?>
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
