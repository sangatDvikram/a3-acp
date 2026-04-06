
// Function to insert comment
$(document).ready(function()
{
$('.pop').click(function() //delete cookes
{
popup('popUpDiv');
var element = $(this);
var Id = element.attr("id");

//$(".popimg").attr("src",'/2.gif');
var dataString = 'id='+Id ;
$.ajax({
type: "POST",
url: "/Stats/getgall.php",
data: dataString,
cache: false,
dataType: 'json',
success: function(html){

$(".popimg").html(html.img);
if(html.prev=='0'){ $(".prv").hide(); }else{$(".prv").show(); $(".prv").attr("id",html.prev);}
if(html.nxt=='0'){ $(".nxt").hide(); }else{$(".nxt").show(); $(".nxt").attr("id",html.nxt); }


$(".details").html(html.data);
//$(".details").html(html.prev+" & "+html.nxt);
$(".num").html(html.num);
 $(".comment").attr("href", "/Gallery/Show/"+html.id+"/#commentMe");
}
});
return false;


});
$('.nxt').click(function() //delete cookes
{
var element = $(this);
var Id = element.attr("id");
//$(".popimg").attr("src",'/2.gif');
var dataString = 'id='+Id ;
$.ajax({
type: "POST",
url: "/Stats/getgall.php",
data: dataString,
cache: false,
dataType: 'json',
success: function(html){

$(".popimg").html(html.img);
if(html.prev=='0'){$(".prv").hide(); }else{$(".prv").show(); $(".prv").attr("id",html.prev);}
if(html.nxt=='0'){$(".nxt").hide(); }else{$(".nxt").show(); $(".nxt").attr("id",html.nxt); }

$(".details").html(html.data);
//$(".details").html(html.prev+" & "+html.nxt);
$(".num").html(html.num);
 $(".comment").attr("href", "/Gallery/Show/"+html.id+"/#commentMe");
}
});
return false;


});
$('.prv').click(function() //delete cookes
{
var element = $(this);
var Id = element.attr("id");

//$(".popimg").attr("src",'/2.gif');
var dataString = 'id='+Id ;
$.ajax({
type: "POST",
url: "/Stats/getgall.php",
data: dataString,
cache: false,
dataType: 'json',
success: function(html){

$(".popimg").html(html.img);
if(html.prev=='0'){$(".prv").hide(); }else{$(".prv").show(); $(".prv").attr("id",html.prev);}
if(html.nxt=='0'){$(".nxt").hide(); }else{$(".nxt").show(); $(".nxt").attr("id",html.nxt); }
$(".details").html(html.data);
//$(".details").html(html.prev+" & "+html.nxt);
$(".num").html(html.num);
 $(".comment").attr("href", "/Gallery/Show/"+html.id+"/#commentMe");
}
});
return false;


});
			
});
$(document).keyup(function(e) {

  //if (e.keyCode == 27) {popup('popUpDiv');}   // esc
  if (e.keyCode == 37) { $('.prv').click();}   // left
  if (e.keyCode == 39) {$('.nxt').click();}   // right
});
