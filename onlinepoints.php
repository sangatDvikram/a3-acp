<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include 'header-acp.php'; 
  
  
?>

<script type="text/javascript">
$(document).ready(function()
{

$(".loader").hide();
$(".info").hide();
$(".slot").attr("disabled", "disabled");

$(".char").change(function()
{
$(".info").hide();
$(".slot").fadeTo(250, 0.33);
$(".char").attr("disabled", "disabled");
$(".btn").attr("disabled", "disabled");
$(".slot").attr("disabled", "disabled");
$(".itemoptions").html('');
$(".loader").show();
var id=$(this).val();
var dataString = 'char='+ id;
$.ajax
({
type: "POST",
url: "/Stats/get_opinfo.php",
data: dataString,
cache: false,
dataType: 'json',
success: function(html)
{
$(".slot").fadeTo(250,1);
$(".info").html(html.op);
$(".info").show(500)
//$(".slot").html(html.slots);
if(html.enable==1){
$(".slot").removeAttr("disabled");
$(".btn").removeAttr("disabled");
}
$(".loader").hide();
$(".char").removeAttr("disabled");
} 
});

});


});

</script>
 <?php
 $msg = array();
$err = array();
 if(isset($_POST['buyop'])){ 
 foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}
$char=$data['char'];
$slot=$data['slot'];
// Check that any other char from this id is online or not.
 $sql="SELECT * FROM charac0 WHERE c_sheadera = '$_SESSION[username]'";
$rss=odbc_exec($con,$sql);
while($rs=odbc_fetch_array($rss)){
if($rs['pnline'] == 1) { $err[] = "Error : Please logout from game before continuing. and make sure that no other characters from your account is logged in"; }
}
  $sql="SELECT * FROM charac0 WHERE c_id = '$char' AND c_sheadera = '$_SESSION[username]";
$rss=odbc_exec($con,$sql);
$chr=odbc_fetch_array($rss);
if($chr['pnline'] == 1) { $err[] = "Error : Please logout from game before continuing."; }
$nwop=$chr['op']-5000;
if($nwop<0) { 
 $err[] = "Error : $char have $nwop online points but to convert online points to OP1 it requires 5000 online points!!."; 
 //$nwop=0;
 }

$charstring = $chr['m_body'];
//explode the string
$temp = explode("\_1",$charstring);

//initialize variable for the string
$EXP = explode("=",$temp[0]);
$SKILL = explode("=",$temp[1]);
$PK = explode("=",$temp[2]);
$RTM = explode("=",$temp[3]);
$SINFO = explode("=",$temp[4]);
$WEAR = explode("=",$temp[5]);
$INVEN = explode("=",$temp[6]);
$PETINV = explode("=",$temp[7]);
$CQUEST = explode("=",$temp[8]);
$WAR = explode("=",$temp[9]);
$SQUEST = explode("=",$temp[10]);
$FAVOR = explode("=",$temp[11]);
$PSKILL = explode("=",$temp[12]);
$SKLSLT = explode("=",$temp[13]);
$CHATOPT = explode("=",$temp[14]);
$TYR = explode("=",$temp[15]);
$SKILLEX = explode("=",$temp[16]);
$SKLSLTEX = explode("=",$temp[17]);
$PETACT = explode("=",$temp[18]);
$LORE = explode("=",$temp[19]);
$LQUEST = explode("=",$temp[20]);
$RESRV0 = explode("=",$temp[21]);
$RESRV1 = explode("=",$temp[22]);


$sr = explode(";",$INVEN[1]);
$filledInven=get_filled_inventory($sr);
$emptyInven=get_empty_inventory($filledInven);
$source = array_values($sr);

$newInvt=$emptyInven[0]-1;

$insc = "9653;32;1708909;".$newInvt;


if (empty($emptyInven)) {
    $err[] = "Error : You dont have any empty slot in your inventory please make sure you keep least one empty slot."; 
}

if(empty($source)){
$INVEN[1] = $insc; 
}
else {
$INVEN[1] = $INVEN[1].";".$insc; 
}

$temp[6] = implode("=",$INVEN);
$mbody = implode("\_1",$temp);

if(empty($err)) {
$updatec = odbc_exec($con,"UPDATE charac0 SET m_body = '$mbody',op='$nwop' WHERE c_id = '$char' AND c_sheadera = '$_SESSION[username]'");

if($updatec) { 
$msg[] = "Online points converted Successfully. It Has been added to slot ".($newInvt+1)."!!";
$log = "Congratulations!! You have successfully converted <b>Online Points</b> to get OP1 at <b>5000</b> online points  for character <b>".$char."</b>.<br>You now have <b>".$nwop."</b> onlin points in your character $char. <br>Please check your item in your inventory.!! <br>Thank you for using our Ultimate Online Point Converter .<br><b>-Admin Ultimate</b>";
log_action($_SESSION['username'],$char,$log,$con);
$subject = "A3 Ultimate : Online points converted Successfully!!";
email_action($_SESSION['username'],$subject,$log,$con);
}

}
 
 }
 
 
 ?>
    <meta charset="utf-8">
    <title>Online Point Converter - A3ultimate.com</title>
	

    <div class="container-fluid">
     
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Online Point Converter :  
</h1></div>
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
<div class="row-fluid ">

          <div class="span3">
              <?php include 'side_bar.php';?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
		  <div class="info">
		  </div>
 
<form class="form-inline" method='POST'>

			   <fieldset id="item">
   <legend>Select Character: <small>You can convert 5,000 Online points to OP1(sharable 4,000 Online Points)</small><img src="/images/ajax-loader.gif" class="loader"></legend>
			<center>   Character
<select name="char" class="char owner">

<option selected="selected" value="x">--Select Char--</option>
<?php 
$getchars = odbc_exec($con,"SELECT * FROM charac0 WHERE c_sheadera = '$_SESSION[username]' AND c_status = 'A'");
while (odbc_fetch_row($getchars))
	{
		$heroes1 = odbc_result($getchars, "c_id");
?>
<option  value="<?php echo $heroes1; ?>"><?php echo $heroes1; ?></option>
<?php
}
?>
</select>
<!--     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
Inventory :
<select name="slot" class="slot">
<option selected="selected" value="x">Select Invt</option>
</select>-->
</center>
</fieldset>

<div class="form-actions" style=" padding:7px;">
<button class='btn btn-block btn-large btn-primary ' name='buyop' type='submit' title='Convert Online points' disabled="disabled" >Convert Online points</button></div>
</form>
</div>
<div class="span5">

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