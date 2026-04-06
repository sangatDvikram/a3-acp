<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Storage Info </title>

<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }
?>
    <div class="container-fluid">
     
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Storage Info : 
</h1></div>
	 
	 <center>
	 <form action='' method='POST'>
	<div class="input-append">
<input type="text"  name="term"  class="span9" placeholder="Enter character name"  data-provide="typeahead" data-items="10" data-source='[""<?php $sqlstring1="select * from account ";
$r1= odbc_exec($con,$sqlstring1);
while($dd = odbc_fetch_array($r1)) {
echo ",\"".trim($dd['c_id'])."\"";
} ?>]'>
<input type="submit" name="S1" value="Search" class="btn"  >
</div>
</form>
	 <table cellpadding="3" cellspacing='3' >
  
  
  <tbody>
    <tr>
	 <?php 
	 if($_POST['S1'] == 'Search')
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }

 $char=$data['term'];
 echo $char."'s Storage :";
 
$query1 = odbc_exec($con,"SELECT m_body FROM ItemStorage0 WHERE c_id='$char' ");
while ($sup = odbc_fetch_array($query1))
	{
$temp=$sup['m_body'];
$sr = explode(";",$temp);
$result = array();
$source = array_values($sr);
$count = count($source);
for($i = 3; $i < $count; $i +=4) {
    $result[] = $source[$i]+1;
}
$array2 = array( "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29" ,"30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60","61","62","63","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80");
$result1 = array_diff($array2,$result);
sort($result);
$j=0;
$new1=0;
$resultnew = $result + $result1;
foreach($array2 as $value1) {
if (in_array($value1, $result)) {
$slot=$new1;
$new=$value1;
include 'Stats/str.php'  ;
  print "<td style='cursor:pointer'><img src='$img' class='thumbnail' rel='drevil'  data-trigger='hover' data-content=\"$message<b>Slot:</b> $value1\" data-original-title=\"<b>$name</b>\" > </td>";
$new1++;
}
if (in_array($value1, $result1)) {
    print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='<b>Slot:</b> $value1' data-original-title='<b>Empty Inventory</b>' > </td>";
}
if(($j+1)%5==0){echo "</tr><tr>";}
  $j++;

  }
 }	

} ?>
   </tr>
  </tbody>
</table>
</center>

</div><!-- Main -->
</div><!-- Cointainer -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  
<script src="/js/bootstrap-tooltip.js"></script>  
<script src="/js/bootstrap-popover.js"></script>  
<script type="text/javascript">
 $(document).ready(function() {
  $("[rel=drevil]").popover({
      placement : 'bottom', 
      html: 'true',
	  trigger: "hover"
});
});
</script>
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
