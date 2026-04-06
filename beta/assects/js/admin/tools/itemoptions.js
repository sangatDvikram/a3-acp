(function($){
    $(function(){

        var type = [];
        type["Armor"] = 4129;
        type["Boots"] = 7201;
        type["Gloves"] = 6177;
        type['Helmet'] = 3105;
        type['Pant'] = 5153;
        type['Shield']=481;
        type['WarriorSword']=2145;
        type['WarriorSpear']=2273;
        type['WarriorAxe']=2209;
        type['HKSword']=1377;
        type['HKMace']=1441;
        type['MageEle']=2337;
        type['MageNon-Ele']=2721;
        type['ArcherBow']=1569;
        type['ArcherxBow']=1633;

        //$('.result').delay(400).fadeOut();
/*warrior sword - 2145
warrior spear - 2273
warrior axe - 2209
hk sword - 1377 
hk mace - 1441
mage ele - 2337
mage non-ele - 2721
archer bow - 1569
archer xbow - 1633*/


        $('body').on("change", "#is_storage_box",function() {
            var item=parseInt($('#code').val());
            var options=parseInt($('#option').val());
            var type_code=$('#type').val();
           if($('#is_storage_box').prop('checked')) {
                
                if(item!=""&&options!="")
                {
                    $('#code').attr('value',17);
                    $('#option').attr('value',item);
                }
                $("#storage_box_calculation").show();
                
                $("#item_options_calculation").hide();
            }
            else
            {
                 $('#code').attr('value',options);
                 $('#option').attr('value',type[""+type_code+""]);

                 $("#storage_box_calculation").hide();

                 $("#item_options_calculation").show();
            }
        });
        $('#characterName').autocomplete({
            serviceUrl: '/beta/api/admin/characters/format/json',
            minChars:2,
            onSelect: function (suggestion) {

            },
            showNoSuggestionNotice: true,
            noSuggestionNotice: 'Sorry, no matching results',
            appendTo: '#character-suggestions'
        });

        $('#autocomplete').autocomplete({
            serviceUrl: '/beta/api/guide/searchitem/format/json',
            minChars:3,
            onSelect: function (suggestion) {
                $("#myForm").trigger("reset");
               
                if($('#is_storage_box').prop('checked')) 
                {
                    $('#code').attr('value',17);
                    $('#option').attr('value',suggestion.data);
                }
                else 
                {
                    $('#code').attr('value',suggestion.data);
                }
                searchOptions(suggestion.data);

            },
            showNoSuggestionNotice: true,
            noSuggestionNotice: 'Sorry, no matching results',
            appendTo: '#item-suggestions'
        });

        function searchOptions(code)
        {
            var url='/beta/api/crafting/itemOptions/format/json';
            var data = 'code='+code;



            $.post(url,data,function(data)
            {
                $.each(data, function(i, item)
                {
                    //console.log(item.options);
                    $('#type').attr('value',item.item_class+""+item.item_weapon_type);
                    $('#class').attr('value',item.item_class);
                    //Calculate The Item type.
                    if(item.item_type=='Weapon')
                    {
                        $('#option').attr('value',type[""+item.item_class+""+item.item_weapon_type+""]);
                    }
                    else
                    {
                        $('#option').attr('value',type[""+item.item_type+""]);
                    }
                    $('#unique').attr('value','909'+Date.now().toString().slice(4,11));

                    $('#level').attr('value',1);
                    $('#blue').attr('value',0);
                    $('#blue').attr('max',63);
                    $('#red').attr('value',0);
                    $('#red').attr('max',63 );
                    $('#yellow').attr('value',0);
                    $('#yellow').attr('max',63);

                    $.each(item.options, function(i, options)
                    {
                        $('#level').attr('value',options.item_range);
                        $('#blue').attr('value',options.item_blue);
                        $('#blue').attr('max',(options.item_blue)? options.item_blue : '63');
                        $('#red').attr('value',options.item_red);
                        $('#red').attr('max',(options.item_red)? options.item_red : '63' );
                        $('#yellow').attr('value',options.item_yellow);
                        $('#yellow').attr('max',(options.item_yellow)? options.item_yellow : '63');

                    })
                })


                },'json');

        }

        $('body').on("click", ".calculate",function() {
            calculate();
        });
        function calculate()
        {
            var item=parseInt($('#code').val());
            var level=parseInt($('#level').val());
            var blue=parseInt($('#blue').val());
            var red=parseInt($('#red').val());
            var yellow=parseInt($('#yellow').val());
            var blessing=0;
            var mounting=parseInt($('#mounting').val());
            var additional=0;
            var options=parseInt($('#option').val());
            var unique=parseInt($('#unique').val());
            var count=parseInt($('#count').val());
            if($('#is_storage_box').prop('checked'))
            {
                options=(16384 * count)+options;
            }
            else
            {
                    if($('#blessing').prop('checked')) {
                        // something when checked
                        blessing=32768;
                    }
                    if($('#additional').prop('checked')) {
                        // something when checked
                        additional=16;
                    }
                    if($('#unidentified').prop('checked')){
                        // something when checked
                        options=options-32;
                    }
                    if(blue>$('#blue').attr('max')&&blue>63)
                    {
                        alert('Blue Option Cannot Be greater Than '+ $('#blue').attr('max')+ ' for '+ $('#autocomplete').val()+'!!')
                        return;
                    }
                    if(red>$('#red').attr('max')&&red>63)
                    {
                        alert('Red Option Cannot Be greater Than '+ $('#red').attr('max')+ ' for '+ $('#autocomplete').val()+'!!')
                        return;
                    }
                    if(yellow>$('#yellow').attr('max')&&yellow>63)
                    {
                        alert('Yellow Option Cannot Be greater Than '+ $('#yellow').attr('max')+ ' for '+ $('#autocomplete').val()+'!!')
                        return;
                    }
                    //Blessings
                    item=item+blessing;
                    //Mounting
                    item=item+(65536*mounting);
                    //Level
                    options=options+(level-1);
                    //Additional
                    options=options+additional;
                    //blue
                    options=options+(blue*16384);
                    //red
                    options=options+(red*1048576);
                    //yellow
                    options=options+(yellow*67108864);
            }

            var final= item+';'+options+';'+unique+''+'';
 
            $('#final').attr('value',final);
            $('#item').attr('value',final);

        }
    }); // end of document ready
})(jQuery); // end of jQuery name space



