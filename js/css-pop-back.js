var isIE = /*@cc_on!@*/false;                            // At least IE6
function toggle(div_id) {
	var el = document.getElementById(div_id);
	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
	else {el.style.display = 'none';}
}
function blanket_size(popUpDivVar) {
	/*if (typeof window.innerWidth != 'undefined') {
		viewportheight = window.innerHeight;
	} else {
		viewportheight = document.documentElement.clientHeight;
	}
	if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
		blanket_height = viewportheight;
	} else {
		if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
			blanket_height = document.body.parentNode.clientHeight;
		} else {
			blanket_height = document.body.parentNode.scrollHeight;
		}
	}
	var blanket = document.getElementById('blanket');
	//blanket.style.height = blanket_height + 'px';
	var popUpDiv = document.getElementById(popUpDivVar);
	//popUpDiv_height=blanket_height/2-200;//200 is half popup's height
	//popUpDiv.style.top = popUpDiv_height + 'px';*/
}
function window_pos(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportwidth = window.innerHeight;
	} else {
		viewportwidth = document.documentElement.clientHeight;
	}
	if ((viewportwidth > document.body.parentNode.scrollWidth) && (viewportwidth > document.body.parentNode.clientWidth)) {
		window_width = viewportwidth;
	} else {
		if (document.body.parentNode.clientWidth > document.body.parentNode.scrollWidth) {
			window_width = document.body.parentNode.clientWidth;
		} else {
			window_width = document.body.parentNode.scrollWidth;
		}
	}
	var popUpDiv = document.getElementById(popUpDivVar);
	//window_width=window_width/2-200;//200 is half popup's width
	//popUpDiv.style.left = window_width + 'px';
}
function popup(windowname) {
	blanket_size(windowname);
	window_pos(windowname);
	toggle('blanket');
	toggle(windowname);		
}


// Function to insert comment
$(document).ready(function()
{
$('.pop').click(function() //show image
{
popup('popUpDiv');
var element = $(this);
var Id = element.attr("id");
getimage(Id);
return false;


});
$('.nxt').click(function() //show next image
{
var element = $(this);
var Id = element.attr("id");
getimage(Id);
return false;


});
$('.prv').click(function() //delete cookes
{
var element = $(this);
var Id = element.attr("id");
getimage(Id);
return false;


});
			
});
$(document).keyup(function(e) {

 if (e.keyCode == 27) {
 $('#blanket').fadeOut();
 $('#popUpDiv').fadeOut();
/*var stateObj = { stats: this.hash };
	history.replaceState(stateObj, "page 2", '/');*/
	removeUrl();
	}   
  if (e.keyCode == 37) { $('.prv').click();}   // left
  if (e.keyCode == 39) {$('.nxt').click();}   // right
});

function getimage(img){

pushthis(img);

var dataString = 'id='+img ;

if(window.location.hash!=""){
	dataString=dataString+'&hash=1'
}

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
}

function replcUrl(){
$('#blanket').fadeOut();$('#popUpDiv').fadeOut();
	removeUrl();
	popup('popUpDiv');
}

function pushthis(url){

	var isIE = /*@cc_on!@*/false;                            // At least IE6
	if(isIE==true)
	{
		window.location.hash = '/Gallery/Show/'+url+'/';
	}
	else
	{
	var stateObj = { stats: this.hash };
	history.replaceState(stateObj, "page 2", '/Gallery/Show/'+url+'/');
	}


}
function removeUrl(){
	
	if(isIE==true)
	{
		window.location.hash = '';
	}
	else
	{
	var stateObj = { stats: this.hash };
	history.replaceState(stateObj, "page 2", '/');
	}


}