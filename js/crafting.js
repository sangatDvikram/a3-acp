var default_content="";
var isIE = /*@cc_on!@*/false;                            // At least IE6
$(document).ready(function(){

	$(".loader").hide();
	checkURL();
	$('.nav-list li a').click(function (e){
	$('.nav-list li ').removeClass("active");//remove all active class
	$(this).parent().addClass("active");//Make li active
	var pushUrl=$(this).attr("href");//get the data src value
		//push state TO the SRC of the a element
	pushUrl=pushUrl.replace(/ /gi,'+');
	if(isIE==true)
	{
		window.location.hash = pushUrl;
	}
	else
	{
	var stateObj = { stats: this.hash };
	history.pushState(stateObj, "page 2", '/Guide/Crafting/'+pushUrl);
	}
			checkURL(pushUrl);
			return false;
	});
	//filling in the default content
	default_content = $('.auctionContaint').html();
	setInterval("checkURL()",250);
	

	
});

var lasturl="";

function checkURL(hash)
{
	var newurl="";
		if(isIE==true)
	{
		 newurl=window.location.hash;
	newurl=newurl.replace("#","");
	}
	else
	{
		 newurl=window.location.href;
	newurl=newurl.replace("/Guide/Crafting/","");
	
	}
	
	if(!hash) hash=newurl;
	if(hash != lasturl)
	{
		lasturl=hash;
		
		// FIX - if we've used the history buttons to return to the homepage,
		// fill the pageContent with the default_content
		
		if(hash=="")
		$('.auctionContaint').html(default_content);
		else
		loadPage(hash);//lode req
		
	}
}
function loadPage(url1)
{
	var filters = ["item", "name", "category",""];
	var n=url1.split("=");
	if($.inArray(n[0], filters)=='-1'){window.location='/404.php';}else{
	if(n[0]=='item'||n[0]=='name'){
	var datastring='page='+n[0]+'&'+url1;
	$(".loader").show();
	$("#main").hide();
	$(".ItmView").hide();		
	$.ajax({
		type: "POST",
		url: "/Stats/crafting.php",
		data: datastring ,
		dataType: 'json',
		success: function(msg){
		if(msg!=0)
			{
				document.title =msg.tittle;
				$("#rbdetails").html(msg.page);
				$(".loader").hide();
				$("#main").show(500);
				jQuery("html, body").animate({ scrollTop: 300 }, 500);
				
			}
		}
		
	});
	}
		else{
	//alert(url1);
	var datastring='page='+n[0]+'&'+url1;
	$(".loader").show();
	$("#main").hide();
	$(".ItmView").hide();	
		
	$.ajax({
		type: "POST",
		url: "/Stats/crafting-view.php",
		data: datastring ,
		dataType: 'json',
		success: function(msg){
		if(msg!=0)
			{
			/*	$('.nav-list li ').removeClass("active");//remove all active class
			url1=url1.replace('category=','');
			$("#"+url1).parent().addClass("active");//Make li active
			*/
				document.title =msg.tittle;
				$('.itemstack').html(msg.page);
				$(".ItmView").show(500);	
				$('.head').html(msg.head);
				jQuery("html, body").animate({ scrollTop: 300 }, 500);
				$(".loader").hide();
			}
		}
		
	});
	}
  }
  	return false;
}
function showmsg(owner){
	var pushUrl=$("#"+owner).attr("href");//get the data src value
	//alert(pushUrl);	
	pushUrl=pushUrl.replace(/ /gi,'+');	
	if(isIE==true)
	{
		window.location.hash = pushUrl;
	}
	else
	{
	var stateObj = { stats: this.hash };
	history.pushState(stateObj, "page 2", '/Guide/Crafting/'+pushUrl);
	}
	loadPage(pushUrl);
	return false;
}
function search(){
var item=$(".item").val();
item=item.replace(/ /gi,'+');
$('.item').val('');
item='name='+item;
	if(isIE==true)
	{
		window.location.hash = item;
	}
	else
	{
	var stateObj = { stats: this.hash };
	history.pushState(stateObj, "page 2", '/Guide/Crafting/'+item);
	}
	loadPage(item);
}
