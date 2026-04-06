$(document).ready(function()
{

$(".loader").hide();
$("#main").hide();

$(".btn").click(function()
{
$("#main").hide();
$(".char").fadeTo(250, 0.33);
$(".char").attr("disabled", "disabled");
$(".loader").show();
var id=$('.user').val();
var dataString = 'char='+ id;
$.ajax
({
type: "POST",
url: "/Stats/stats.php",
data: dataString,
cache: false,
success: function(html)
{

$("#rbdetails").html(html);
$(".loader").hide();
$("#main").show(500);
$(".char").fadeTo(250, 1);
$(".char").removeAttr("disabled");
} 
});
return false;
});


});
function disable(){
/*	$("#myForm").submit();
    $(".btn-success").attr("disabled", "disabled");*/

}
function add (value) {
	 	var min=$("."+value).val();
	 	var rem=$(".remaining").val();
	 	if(value!='vitality'&&value!='Mana'){
	 		if(rem<=0||min>=65535){
	 	
	 }else{
	 	$("."+value).removeAttr("readonly");
	 	$(".remaining").removeAttr("readonly");
	 	$("."+value).val((min*1)+100);
	 	$(".remaining").val((rem*1)-100);
	 	$("."+value).attr("readonly", "readonly");
	 	$(".remaining").attr("readonly", "readonly");
	 }
	 	}else{
	 		if(rem<=0||min>=15000){
	 	
	 }else{
	 	$("."+value).removeAttr("readonly");
	 	$(".remaining").removeAttr("readonly");
	 	$("."+value).val((min*1)+100);
	 	$(".remaining").val((rem*1)-100);
	 	$("."+value).attr("readonly", "readonly");
	 	$(".remaining").attr("readonly", "readonly");
	 }
	 	}
	 	
		
	 	return false;
	 }
	 function minus (string) {
		var min=$("."+string).val();
		var rem=$(".remaining").val();
	 	if(min<=50){
	 	
	 }else{
	 	$("."+string).removeAttr("readonly");
	 	$(".remaining").removeAttr("readonly");
	 	$("."+string).val((min*1)-100);
	 	$(".remaining").val((rem*1)+100);
	 	$("."+string).attr("readonly", "readonly");
	 	$(".remaining").attr("readonly", "readonly");
	 }
	 }