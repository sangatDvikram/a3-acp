(function($){
    $(function(){



        $('body').on("mouseenter ", ".player-item",function() {
            var html= $(this).attr('data-info');
            $('#item-info').html(html);
        });
        $('body').on(" mouseleave", ".player-item",function() {
            $('#item-info').html("");
        });
        $('body').on("mouseenter ", ".wear-item",function() {
            var html= $(this).attr('data-info');
            $('#wear-info').html(html);
        });
        $('body').on(" mouseleave", ".wear-item",function() {
            $('#wear-info').html("");
        });
        
        $('#autocomplete').autocomplete({
            serviceUrl: '/beta/api/admin/characters/format/json',
            minChars:3,
            onSelect: function (suggestion) {
                //console.log(suggestion);
                get_charactor_inventory_details(suggestion.value);
            },
            showNoSuggestionNotice: true,
            noCache:true,
            noSuggestionNotice: 'Sorry, no matching results',
            appendTo: '#characterSearch'
        });
        function get_charactor_inventory_details(code)
        {
            var url='/beta/api/admin/charactersInventoryInfo/format/json';
            var data = 'character='+code;
            $.post(url,data,function(data)
            {
               $('#result-inventory').html(data.item);
               $('#result-wear').html(data.wear);
               tooltipped.init();
               $("#player-info").show(500);
                },'json');

        }

        $('#bans').change(function(){
            var selected = $(this).find('option:selected');
            var info = selected.data('info');
            $('#ban-info').html(info);
        });

    }); // end of document ready
})(jQuery); // end of jQuery name space



