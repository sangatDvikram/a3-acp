(function($){
    $(function(){
/* This is how we use INIT function where we create object and pass the object through .init() function*/

    	$('.loadermonster').hide("slow");
    	$('.loadercrafting').hide("slow");
    	$('#monster-info').hide("slow");
    	$('#crafting-info').hide("slow");
    	$('#options-info').hide("slow");



		$('body').on("click", ".monsters",function() {
		  var href= $(this).attr('data-href');
		  window.location=href;
		});

		$('body').on("click", ".items",function() {
		
		  var href= $(this).attr('data-href');
		  window.location=href;
		});
		
		$('body').on("click", ".animation",function() {
		
		  var src=$(".monster-image").attr('src');
		  var gif= $(this).attr('data-gif');
		  var jpg= $(this).attr('data-jpg');
		
		
        $(".monster-image").attr('src',(src == gif) ? jpg : gif);
		  
		});

		$('body').on("click", ".hidder",function() {
		
			var state=$(this).attr('data-state');
			var toggle=$(this).attr('data-toggle');
		  	var targethtml=$('#'+toggle).html();
		  	var itemcode=$('#'+toggle).attr('data-item');
		  	var type=$('#'+toggle).attr('data-type');
		  	targethtml=$.trim(targethtml);

		  	if(targethtml=="")
		  	{
		  		$(' .loader'+type).show();
		  		var meessage="You are dealing wwith something blank";
		  		var url="";
		  		if(type=='monster')
		  		 url='/beta/api/crafting/itemMonster/format/json';
		  		else
		  		 url='/beta/api/crafting/itemCrafting/format/json';

		        	var data = 'code='+itemcode;

		        $.post(url,data,function(data)
		        {
		        	$(' .loader'+type).hide();
		        	$('#'+toggle).html('');
		            $('#'+toggle).append(data.data);
		            tooltipped.init();
		        },'json');
		       // alert(itemcode+type);
		  	}
		  	

		  if(state=='show')
		  {
		  	$(this).attr('data-state','hide');
		  	$('.arrow'+type).removeClass('mdi-hardware-keyboard-arrow-down').addClass('mdi-hardware-keyboard-arrow-up');
		  	$('#'+toggle).show("slow");

		  }
		  else
		  {
		  	$(this).attr('data-state','show');
		  	$('.arrow'+type).removeClass('mdi-hardware-keyboard-arrow-up').addClass('mdi-hardware-keyboard-arrow-down');
		  	$('#'+toggle).hide("slow");
		  }

		});
		$('body').on("click", ".crafting-hidder",function() {
		
			var state=$(this).attr('data-state');
			var toggle=$(this).attr('data-toggle');
		  
		  if(state=='show')
		  {
		  	$(this).attr('data-state','hide');
		  	$('.crafting-hidder .arrow').removeClass('mdi-hardware-keyboard-arrow-down').addClass('mdi-hardware-keyboard-arrow-up');
		  	$('#'+toggle).show("slow");

		  }
		  else
		  {
		  	$(this).attr('data-state','show');
		  	$('.crafting-hidder .arrow').removeClass('mdi-hardware-keyboard-arrow-up').addClass('mdi-hardware-keyboard-arrow-down');
		  	$('#'+toggle).hide("slow");
		  }

		});

		$('body').on("change keyup paste", ".monster-search",function() {

		  
		  var str = $(this).val();
		 // alert(str);
		  var length=str.length;
		  var name=$.trim(str);

		  if(length>3)
		  {
		  

				  	var url='/beta/api/crafting/monster/format/json';
		        	var data = 'name='+name;

		        $.post(url,data,function(data)
		        {
		        	$('#category').html('Search Result');
		        	$('.result-data').html('');
		            $.each(data, function(i, monster)
		             {
					    	var monster_name=monster.monster_name;
					    	var monster_code=monster.monster_code;
					    	var monster_image=monster.monster_image;
					    	var map_name=monster.map_name;
					    	var monster_link=monster.link;
					    	var monster_info=monster.monster_info;
					    	var info='';

					    	info='<a href="/beta/guides/maps?monster='+monster_link+'"><div class="col s12 m4" ><div class="card-panel grey lighten-2 black-text" style="cursor:pointer" id="'+monster_code+'" data-href="/beta/guides/maps.html?monster='+monster_link+'"><div class="row valign-wrapper" ><div class="col s4"><img src="/allitems/monsters/'+monster_code+'.jpg" alt="" class=" responsive-img"></div><div class="col s8 "style="min-height:80px;font-size:14px" > <span>Name : <b> '+monster_name+' </b></span> <br><span>Map : <b> '+map_name+' </b></span> <br> <span>Info : '+monster_info+'<br></span></div></div></div></div></a>';
                                 $( ".result-data" ).append(info);

					})

		        },'json');


		  }

		});

		$('body').on("change keyup paste", ".item-search",function() {

		  
		  var str = $(this).val();
		 // alert(str);
		  var length=str.length;
		  var name=$.trim(str);

		  if(length>3)
		  {
		  

				  	var url='/beta/api/crafting/item/format/json';
		        	var data = 'name='+name;

		        $.post(url,data,function(data)
		        {
		        	$('#category').html('Search Result');
		        	$('.result-data').html('');
		            $.each(data, function(i, item)
		             {
					    	var item_name=item.item_name;
					    	var item_link=item.link;
					    	var item_image=item.image;
					    	var item_info=item.item_info;
					    	var item_type=item.item_type;
					    	var item_class=item.item_class;

					    	var info='';

					    	info='<a href="/beta/guides/items?item='+item_link+'"><div class="col s12 m4" ><div class="card-panel grey lighten-2 black-text" style="cursor:pointer;max-height:125px;" id="'+item_name+'" data-href="/beta/guides/items.html?item='+item_link+'"><div class="row valign-wrapper" ><div class="col s3"><img src="'+item_image+'" alt="" class=" responsive-img"></div><div class="col s9 "> <span>Name : <b> '+item_name+' </b></span> <br><span>Type : <b> '+item_type+' </b></span> <br> <span>Class : '+item_class+'<br></span></div></div></div></div></a>';
                                 $( ".result-data" ).append(info);

					})

		        },'json');


		  }

		});
        $('#autocomplete').autocomplete({
            serviceUrl: '/beta/api/guide/searchitem/format/json',
            minChars:3,
            onSelect: function (suggestion) {
                search(suggestion.value);
               // $("#result").html('You selected: ' + suggestion.value + ', ' + suggestion.data);
            },
            showNoSuggestionNotice: true,
            noSuggestionNotice: 'Sorry, no matching results',
            appendTo: '.autocomplete-suggestions'
        });

        function search(name)
        {
            var url='/beta/api/crafting/item/format/json';
            var data = 'name='+name;

            $.post(url,data,function(data)
            {
                $('#category').html('Search Result');
                $('.result-data').html('');
                $( ".result-data" ).append(data.data);

            },'json');

        }
    }); // end of document ready
})(jQuery); // end of jQuery name space



 