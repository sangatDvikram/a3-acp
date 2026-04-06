<!DOCTYPE html>
<html lang="en">
  <head>
    
    <title> Add item to auction - Auction - A3ultimate.com
	</title>
<?php include 'header-acp.php'; 

if($_POST){
	foreach($_POST as $key => $value) {
	$data[$key] = antisql($value); // post variables are filtered
}

//include 'conn/pdoclass.php';

$pdo=new PDOExamples();

$owner=$data['owner'];
$char=$data['owner'];
$type=$data['class'];
$slot=$data['slot'];
$oldslot=$data['slot'];
$price=$data['Coins'];
$pprice=$data['Pcoins'];
$gprice=$data['Gcoins'];
$comment=rtrim($data['comment']);
$comment=$comment;
$ip=$_SERVER['REMOTE_ADDR'];
$user=$_SESSION['username'];
$id=GenKey();

$Itminfo=$pdo->ItemOptions($slot, "$char");

$info=invtoption($slot,"$char");
$slot=$data['slot']*4;
include('inc/m_body_char.php');
//echo "$charstring <br>";
if($price==''){$price=0;}
if($pprice==''){$pprice=0;}
if($gprice==''){$gprice=0;}
//explode the string
$newp=$price*1;
$newpp=$pprice*1;
$newgp=$gprice*1;
//-----------------------------EError Handling -------------------------------------------
if($newp=='0'&&$newpp=='0'&&$newgp=='0'){
	$err[]= "ERROR: Please insert proper item price!!";
}
if($newp>99999||$newpp>99999||$newgp>99999){
	$err[]= "ERROR: Item price cannot be more than 99999!!";
}
if ($type=="") {
	$err[]="ERROR:: Item Type is not valid . Please select proper item !!";
}
if(isonline($char)) { $err[] = "Error : Please logout in game before continuing."; }
if(is_online($_SESSION['username'])) { $err[] = "Error : Please logout from game before continuing. and make sure that no other characters from your account is logged in"; }
if(!is_numeric($price)&&!is_numeric($pprice)&&!is_numeric($gprice)){
	$err[]= "ERROR: Please insert proper item price!!";
}

 $string= $Itminfo['Itmid'].";".$Itminfo['Typeid'].";".$Itminfo['Uniqid'].";".$Itminfo['Itmslot'].";";

$sr = explode(";",$INVEN[1]);
$result = array();
$source = array_values($sr);
$count = count($source);
for($i = 3; $i < $count; $i +=4) {
	$result[] = $source[$i]+1;
}

$array2 = array( "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29" ,"30");
$result1 = array_diff($array2,$result);
sort($result);

if(!in_array($Itminfo['Itmslot']+1,$result)){
	$err[]="ERROR:: No such item available in inventry to be inserted into Auction !!";
}
if(!in_array($oldslot,$array2)){
	$err[]="ERROR:: No such item available in inventry to be inserted into Auction !!";
}
if($comment==''){
	$err[]= "ERROR: Please add some description!!";
}
if($Itminfo['Type']=='Quest Item'||$Itminfo['Type']=='Costume'){
	$err[]="ERROR:: Item Type is not valid . Please select proper item !!";
}
if ($Itminfo['Name']=='Empty Inventory') {
	$err[]="ERROR:: Item is not valid . Please select proper item !!";
}
//$class=itemInfo($Itminfo['ItemNumber']);
if($Itminfo['Type']=='Helmet'||$Itminfo['Type']=='Armor'||$Itminfo['Type']=='Pant'||$Itminfo['Type']=='Shield'||$Itminfo['Type']=='Boots'||$Itminfo['Type']=='Weapon'||$Itminfo['Type']=='Gloves'){
	if($Itminfo['Class']=='HK')$Itminfo['Class']="Holy Knight";
	$type= "$Itminfo[Class]";
}
else if($Itminfo['Type']=='RB'){$type= 'RB';}
else if($Itminfo['Type']=='Necklace'){$type='Necklace';}
else if($Itminfo['Type']=='Ring'){$type= 'Ring';}
else if($Itminfo['Type']=='Rings'){$type= 'Rings';}
else if($Itminfo['Type']=='Crafting'){$type= 'Crafting';}
else if($Itminfo['Type']=='Extra'){$type= 'Extra';}
else if($Itminfo['Type']=='Skills'){
	if($Itminfo['Class']=='HK')$Itminfo['Class']="Holy Knight";
	$type= "$Itminfo[Class] Skill";}
//-----------------------------------------------------------------------------------------------------
if (empty($err)) {

	
	$source = array_values($sr);
	$last=end($source);

	if($last==$Itminfo['Itmslot']){
		$insc = ";".$Itminfo['Itmid'].";".$Itminfo['Typeid'].";".$Itminfo['Uniqid'].";".$Itminfo['Itmslot']."";
	}else {
		$insc = $Itminfo['Itmid'].";".$Itminfo['Typeid'].";".$Itminfo['Uniqid'].";".$Itminfo['Itmslot'].";";
	}

	$name=$Itminfo['Name'];
	if($Itminfo['ItemCode']==17){
		$name=$Itminfo['Storageitem']." ". $Itminfo['Name'];
	}
	//echo $name;
	
	//$INVEN[1] = str_replace($insc,"",$INVEN[1]);
                  $value=$Itminfo['Slot'];
                  unset($sr[$value]);
                  unset($sr[$value-1]);
                  unset($sr[$value-2]);
                  unset($sr[$value-3]);
                  $sr = array_values($sr);
                  $INVEN[1]=implode(";", $sr);
	$temp[6] = implode("=",$INVEN);
	$mbody = implode("\_1",$temp);
	$updatec = odbc_exec($con,"UPDATE charac0 SET m_body = '$mbody' WHERE c_id = '$char' AND c_sheadera = '$_SESSION[username]'");

	$insert_comment=odbc_exec($con2, "insert into auction (name,type,itemid,typeid,uniqopt,pprice,gprice,price,sold,owner,ownerid,auctiondate,sellerip,itemcode,auctionid,comments) values ('$name','$type','$Itminfo[Itmid]','$Itminfo[Typeid]','$Itminfo[Uniqid]','$pprice','$gprice','$price','0','$owner','$_SESSION[username]',CONVERT(DATETIME, '$date', 102),'$ip','$Itminfo[ItemCode]','$id','$comment')");

if ($insert_comment) {
	
$date=date(' j/n/Y h:i:s A');
$log = "Congratulations!! You have successfully placed <b>$Itminfo[Name]</b> for auction from character <b>$owner</b> at $date .<br>Please check your auction at <a href='/Auction/Buy/$id/'>/Auction/Buy/$id/</a>. <br> If you did not placed $Itminfo[Name] for auctoin , Please send an email to support@a3ultimate.com .<br>Thank you for using our Ultimate Auction.<br><b>-Admin Ultimate</b>";

log_action($_SESSION['username'],$char,$log,$con);
$subject = "A3 Ultimate : Item $Itminfo[Name] Successfully placed for auction !!";
email_action($_SESSION['username'],$subject,$log,$con);
$link="/Auction/Buy/$id/";
$msg[]="<div class=\"alert alert-success\" align=\"Center\"><h4>$Itminfo[Name] has been successfully inserted into aunction.!!</h4>You can check yout item here <a href='/Auction/Buy/$id/'>/Auction/Buy/$id/</a> !!</div>";


}
else {
	
$err[]="Unable to process your request now :) ";
}
}



}


?>
<script type="text/javascript">
$(document).ready(function()
{

$(".loader").hide();
$("#main").hide();

$(".char").change(function()
{
  $("#main").hide();
$(".msg").hide();
$("#main").hide();
$(".slot").fadeTo(250, 0.33);
$(".char").attr("disabled", "disabled");
$(".slot").attr("disabled", "disabled");
$(".itemoptions").html('');
$(".loader").show();
var id=$(this).val();
var dataString = 'char='+ id;
$.ajax
({
type: "POST",
url: "/Stats/get-invt.php",
data: dataString,
cache: false,
success: function(html)
{
$(".slot").fadeTo(250,1);
$(".slot").html(html);
$(".loader").hide();
$(".slot").removeAttr("disabled");
$(".char").removeAttr("disabled");
} 
});

});

$(".slot").change(function()
{
$("#main").hide();
$(".msg").hide();
$(".auction").attr("disabled", "disabled");
$(".char").attr("disabled", "disabled");
$(".slot").attr("disabled", "disabled");
$(".itemoptions").fadeTo(250, 0.33);
$(".loader").show();
var id=$(this).val();
var charid=$(".char").val();
var dataString = 'slot='+ id+'&char='+charid;
$.ajax
({
type: "POST",
url: "/Stats/invtoptions.php",
data: dataString,
cache: false,
dataType: 'json',
success: function(html)
{
$(".price").attr("value",'');
$(".pprice").attr("value",'');
$(".gprice").attr("value",'');
$("#comment").html(html.des); 
$(".itemoptions").fadeTo(250, 1);
$(".itemoptions").html(html.msg);
$(".ty").val(html.type);
$(".loader").hide();
$(".slot").removeAttr("disabled");
$(".char").removeAttr("disabled");
$(".auction").removeAttr("disabled");
$("#main").show(500);
}
});
});



});

</script>
    <div class="container-fluid">
     
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
 			   <h1>Auction : Add item <img src="/images/ajax-loader.gif" class="loader"></h1></div>
			<?php if(!empty($err))  {
	   echo "<div class=\"alert alert-error\" align=\"Center\">";
	  foreach ($err as $e) {
	    echo "<b>$e</b> <br>";
	    }
	  echo "</div>";
	   }
	   if(!empty($msg)&&empty($err))  {
	    echo  $msg[0];

	   }
	   ?>
			   
			   <div class="row-fluid ">
			   
			   <div class="span8">
			   
			  <form class="form-inline" method="POST" action="">
			   <fieldset id="item">
   <legend>Select Item: <small>Please note that we will deduct 10 % from the amount you get if the item is sold in Premium Coins</small></legend>
			   Character
<select name="owner" class="char owner">

<option selected="selected">--Select Char--</option>
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

Inventory :
<select name="slot" class="slot">
<option selected="selected" value="x">--Select Invt--</option>
</select>

</fieldset>
<br>
<div id='main'>
<fieldset id="type">
   <legend>Description:</legend>
   <textarea autocomplet='off' style="width:100%;resize: none;" name="comment" id="comment" placeholder="Add Description..." required validationMessage="Please Add Some Comment"></textarea>
</fieldset>
   <fieldset id="type">
   <legend>Select Type:</legend>
Type : <input type='text' class='span3 ty ' name='class' readonly='readonly'  value=''>
</fieldset>
<br>
   <fieldset id="price">
   <legend>Enter Price:</legend>
<div class="input-prepend input-append">
  <span class="add-on">P</span>
  <input class="span6 pprice" pattern="[0-9]+" autocomplete='off'  maxlength="7" id="appendedPrependedInput" name='Pcoins' type="text" placeholder="Premium Price" >
  <span class="add-on">.00</span>
</div>
<div class="input-prepend input-append">
  <span class="add-on">E</span>
  <input class="span6 price" pattern="[0-9]+" autocomplete='off'  maxlength="7" id="appendedPrependedInput" name='Coins' type="text" placeholder="Coin Price"  >
  <span class="add-on">.00</span>
</div>
<div class="input-prepend input-append">
  <span class="add-on">G</span>
  <input class="span6 gprice" pattern="[0-9]+" autocomplete='off' maxlength="7" id="appendedPrependedInput" name='Gcoins' type="text" placeholder="Gold Price" >
  <span class="add-on">.00</span>
</div>
</fieldset>

  <div class="form-actions" align='center'>
  <button type="submit" class="btn btn-large btn-block btn-primary auction" name="auction">Add To Auction</button>
  </div>
    </form >

 </div><!-- Main -->
 </div><!-- Main -->
 <div class="span4">
 <div class="itemoptions"></div>
 <div class="error"></div>
 
 </div><!-- Main -->
 </div><!-- Main -->
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