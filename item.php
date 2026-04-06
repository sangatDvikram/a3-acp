<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inventory</title>

<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }
?>
    <div class="container-fluid">
     
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Inventory
</h1></div>
	 <div class="well" style="font-family:Calibri" >
	 <center>
	 <form action='' method='POST'>
	
<input type="text"  name="term"  class="span3" placeholder="Enter Item Code To Be Searched"  required autocomplete="off" >
<input type="text"  name="from"  class="span3" placeholder="Start value "    value="1">
<input type="text"  name="to"  class="span3" placeholder="End value "    value="30000">

<br>
<input type="radio" value="itvt" name="type" checked/>Inventory <input type="radio" value="strg" name="type" />Storage
<input type="submit" name="S1" value="Search" class="btn"  >

</form>
	
	 <?php 
	 $_SESSION['rslt']=1;
	 if($_POST['S1'] == 'Search')
{
foreach($_POST as $key => $value) {
$data[$key] = antisql($value); }

  $char1=$data['term'];
  $typ=$data['type'];
  $from=$data['from'];
  $to=$data['to'];
  
  if($typ=='itvt'){
 echo "<h1>This are from Character </h1>";
 ?>
 <table class="table table-condensed" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:0;font-family:Trebuchet MS;font-weight: normal;">
<tr><th>Char Name </th><th > Account Id</th><th > Password</th></tr>
 <?php $icrm=0;

		
$query1 = odbc_exec($con,"SELECT * FROM charac0 WHERE m_body like '%$char1;%' and sr_no<$to and sr_no>$from  ");
while ($sup = odbc_fetch_array($query1))
	{
		$char=$sup['c_id'];
		include('inc/m_body_char.php');
		$newArry =explode(';', $INVEN[1]);
		$key1 = array_keys($newArry,$char1);
		$result = array();
		//fucking dimag :P
		/**/
		$icount=0;

		$tmpCont=0;
		$sr = explode(";",$INVEN[1]);
		$result1 = array();
		$source = array_values($sr);
		$count = count($source);
		for($i = 0; $i < $count; $i +=4) {
    	$result1[] = $source[$i];
		}
		$getResultKey=array_keys($result1,$char1);


		foreach($getResultKey as $value){
    	$result[]=$value*4;
		}
		$inst=implode(",", $result1);
		$instances = substr_count($inst,$char1);
		$keys="";
		
		foreach($result as $value){
		if($newArry[$value]=='17'){
			$itm=storageboxoptions($newArry[$value+1]);
			$prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$itm[Item]'");
			$prot10 = odbc_fetch_array($prot0);
			$itmN = $prot10['itmname'];
			$itp=$prot10['price']; 
			$icount=$itp*$itm['Count'];
			$tmpCont=$tmpCont+$icount;
			$keys.=($newArry[$value]).";".trim($itmN)." ($itm[Count]);".($newArry[$value+2]).";".($newArry[$value+3]).";<br>";
		}else{
			$keys.=($newArry[$value]).";".($newArry[$value+1]).";".($newArry[$value+2]).";".($newArry[$value+3]).";<br>";
		}
   		 
		
		unset($newArry[$value]);
		unset($newArry[$value+1]);
		unset($newArry[$value+2]);
		unset($newArry[$value+3]);
		}
		$prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$char1'");
		$prot10 = odbc_fetch_array($prot0);
		$val=$prot10['price'];
		$KeysCount=explode(";", $keys);
		$source = array_values($KeysCount);
		$count = count($source);
		$instances = floor($count/4);
		$newval=($val*$instances)+$tmpCont;
		$tmpCont=0;
		$newArry = array_values($newArry);
		$INVEN[1]=implode(";", $newArry);
		$temp[6] = implode("=",$INVEN);
		$mbody = implode("\_1",$temp);/*
		$updatec = odbc_exec($con,"UPDATE charac0 SET m_body = '$mbody' WHERE c_id = '$char' ");
		$updatea1 = odbc_exec($con,"UPDATE account SET coins = coins+$newval WHERE c_id = '$sup[c_sheadera]'");
		if($instances!=0){
			@mkdir("userlogs/Inventory/",0755, true);
            $logf = fopen("userlogs/Inventory/".trim($sup['c_sheadera'])."-Inventory-Replace-log.txt", "a+");
             fprintf($logf, "Date: %s  Account : %s User : %s Code: %s, Count : %s, Coins:%s \r\n", date("d-m-Y h:i:s A"),trim($sup['c_sheadera']),trim($char),$keys,$instances, $newval );
            fclose($logf);}*/
		//print_r(array_keys($newArry,$char1));

$query2 = odbc_exec($con,"SELECT * FROM account WHERE c_id='$sup[c_sheadera]' ");
	$sup1 = odbc_fetch_array($query2);
echo "<tr><td>$sup[sr_no]".clear($sup['c_id'])." ($instances) ($newval) ($keys) </td>";
$newval=0;
echo "<td>$sup[c_sheadera]</td>";
echo "<td>$sup1[c_headera]</td></tr>";$icrm++;
$_SESSION['rslt']=$sup['sr_no'];
} 
echo $icrm." number of results"; } else{
$char1=$data['term'];
 // $val=$data['val']; 
  $from=$data['from'];
  $to=$data['to'];?> 
</table>
<?php 
echo "<h1>This are from Item Storage </h1> "; ?>

<table class="table table-condensed" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:0;font-family:Trebuchet MS;font-weight: normal;">
<tr><th>Account Id</th></tr>
<?php
$icrm=0;
$query1 = odbc_exec($con,"SELECT * FROM ItemStorage0 WHERE m_body like '%$char1;%' and sr_no<2000 and sr_no>1  ");
while ($sup = odbc_fetch_array($query1))
	{
		$icrm++;
		$sql="SELECT * FROM ItemStorage0 WHERE c_id = '$sup[c_id]'";
		$rss=odbc_exec($con,$sql);
		$charstring = odbc_fetch_array($rss);
		$icount=0;

		$tmpCont=0;
		$newArry =explode(';',  $charstring['m_body']);
		$key1 = array_keys($newArry,$char1);
		$result = array();
		//fucking dimag :P
		/**/
		$sr = explode(";", $charstring['m_body']);
		$result1 = array();
		$source = array_values($sr);
		$count = count($source);
		for($i = 0; $i < $count; $i +=4) {
    	$result1[] = $source[$i];
		}
		$getResultKey=array_keys($result1,$char1);


		foreach($getResultKey as $value){
    	$result[]=$value*4;
		}
		$inst=implode(",", $result1);
		$instances = substr_count($inst,$char1);
		$keys="";
		foreach($result as $value){
   		 if($newArry[$value]=='17'){
			$itm=storageboxoptions($newArry[$value+1]);
			$prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$itm[Item]'");
			$prot10 = odbc_fetch_array($prot0);
			$itmN = $prot10['itmname'];
			$itp=$prot10['price']; 
			$icount=$itp*$itm['Count'];
			$tmpCont=$tmpCont+$icount;
			$keys.=($newArry[$value]).";".trim($itmN)." ($itm[Count]);".($newArry[$value+2]).";".($newArry[$value+3]).";<br>";
		}else{
			$keys.=($newArry[$value]).";".($newArry[$value+1]).";".($newArry[$value+2]).";".($newArry[$value+3]).";<br>";
		}
		unset($newArry[$value]);
		unset($newArry[$value+1]);
		unset($newArry[$value+2]);
		unset($newArry[$value+3]);
		}
		$prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$char1'");
		$prot10 = odbc_fetch_array($prot0);
		$val=$prot10['price'];
		$KeysCount=explode(";", $keys);
		$source = array_values($KeysCount);
		$count = count($source);
		$instances = floor($count/4);
		$newval=($val*$instances)+$tmpCont;
		$icount=0;

		$tmpCont=0;
		$newArry = array_values($newArry);
		$mbody=implode(";", $newArry);/*
		$updatec = odbc_exec($con,"UPDATE ItemStorage0 SET m_body = '$mbody' WHERE c_id = '$sup[c_id]' ");
		$updatea1 = odbc_exec($con,"UPDATE account SET coins = coins+$newval WHERE c_id = '$sup[c_id]' ");
			if($instances!=0){
			@mkdir("userlogs/Storage/",0755, true);
            $logf = fopen("userlogs/Storage/".trim($sup['c_id'])."-Storage-Replace-log.txt", "a+");
            fprintf($logf, "Date: %s  User : %s Code: %s, Count : %s, Coins:%s \r\n", date("d-m-Y h:i:s A"), trim($sup['c_id']),$keys,$instances, $newval );
            fclose($logf);}*/
		echo "<tr><td>$sup[sr_no] $sup[c_id] ($instances) ($newval) ($keys)</td></tr>";
} echo $icrm." number of results"; 
}

} ?>
</table>
   
</center>
</div>
</div><!-- Main -->
</div><!-- Cointainer -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  
<script src="/js/bootstrap-tooltip.js"></script>  
<script src="/js/bootstrap-popover.js"></script>  
<script type="text/javascript">
 $(document).ready(function() {
  $("[rel=drevil]").popover({
      placement : 'bottom', //placement of the popover. also can use top, bottom, left or right
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
