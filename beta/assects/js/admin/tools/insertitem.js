(function($){
    $(function(){



        $('body').on("click", ".monsters",function() {
            var href= $(this).attr('data-href');
            window.location=href;
        });


        $('#autocomplete').autocomplete({
            serviceUrl: '/beta/api/admin/characters/format/json',
            minChars:3,
            onSelect: function (suggestion) {

            },
            showNoSuggestionNotice: true,
            noSuggestionNotice: 'Sorry, no matching results',
            appendTo: '.autocomplete-suggestions'
        });


    }); // end of document ready
})(jQuery); // end of jQuery name space



