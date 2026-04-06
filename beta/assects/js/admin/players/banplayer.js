(function($){
    $(function(){



        $('body').on("click", ".monsters",function() {
            var href= $(this).attr('data-href');
            window.location=href;
        });
 
        
        $('#autocomplete').autocomplete({
            serviceUrl: '/beta/api/admin/characters/format/json',
            minChars:1,
            onSelect: function (suggestion) {
                //console.log(suggestion);
                get_char_details(suggestion.value);
            },
            showNoSuggestionNotice: true,
            noCache:true,
            noSuggestionNotice: 'Sorry, no matching results',
            appendTo: '#characterSearch'
        });
        function get_char_details(code)
        {
            var url='/beta/api/admin/charactersinfo/format/json';
            var data = 'code='+code;



            $.post(url,data,function(data)
            {
                $('#bans').val(data.status);
                $('#account').val(data.account);
                $('#bans').change();
                $('#msg').val(data.msg);
                },'json');

        }

        $('#bans').change(function(){
            var selected = $(this).find('option:selected');
            var info = selected.data('info');
            
        });

    }); // end of document ready
})(jQuery); // end of jQuery name space



