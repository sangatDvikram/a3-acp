
function checkUrl() {
    var path = location.href;
    if (path.toLowerCase().indexOf("category") >= 0) {

        var split_url = path.split("=");

        document.title = split_url[1].replace(/\+/gi, " ") + ' - Eshop  - A3Ultimate.com';

        get_category_items(split_url[1]);
    }
    else
    {
        var url = '/beta/api/eshop/topitemlist/format/json';
        var data = "";

        $.post(url, data, function(data)
        {

            $('#category').html("Top Eshop Items");
            $("#items-list").html(data);
            var textbox = document.getElementById("category");
            textbox.focus();
            textbox.scrollIntoView();

        }, 'json');
    }
}
function get_category_items(category)
{
    var url = '/beta/api/eshop/getcategorylist/format/json';
    var data = "category=" + category;

    $.post(url, data, function(data)
    {

        $('#category').html(category.replace(/\+/gi, " "));
        $("#items-list").html(data);
        var textbox = document.getElementById("category");
            textbox.focus();
            textbox.scrollIntoView();

    }, 'json');
}
function search(name)
{
    var str = name;
    // alert(str);
    var length = str.length;
     name = $.trim(str);

    if (length > 3)
    {
        var url = '/beta/api/eshop/search/format/json';
        var data = 'name=' + name;
        $.post(url, data, function(data)
        {
            $('#category').html(name);
            $("#items-list").html(data);
            var textbox = document.getElementById("category");
            textbox.focus();
            textbox.scrollIntoView();
            
        }, 'json');
    }
}
(function($) {
    $(function() {
        checkUrl();
        var State_count = 0;



        $('body').on("click", ".eshop_menu_item", function(e) {


            var url = $(this).attr('href');
            var id = $(this).attr('id');
            //window.location.hash = chat_char;
            History.pushState({state: State_count}, id + " - Eshop  - A3Ultimate.com", url);
            State_count++;
            e.preventDefault();

        });

        $('#autocomplete').autocomplete({
            serviceUrl: '/beta/api/eshop/searchitem/format/json',
            minChars: 3,
            onSelect: function(suggestion) {
                search(suggestion.value);
            },
            showNoSuggestionNotice: true,
            noSuggestionNotice: 'Sorry, no matching results',
            appendTo: '.autocomplete-suggestions'
        });

       


        History.Adapter.bind(window, 'statechange', function() {
            var State = History.getState();
            //History.log(State.data, State.title, State.url);



            checkUrl();
            // console.log(split_url);

        });

        $('#Character').addClass("mdi-action-perm-identity");

        $('#Others').addClass("mdi-maps-local-attraction");

        $('#Skill').addClass("mdi-image-flash-on");

        
        $('.eshop-menu-collapse').sideNav({
      menuWidth: 300, // Default is 240
      edge: 'left', // Choose the horizontal origin
      closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
    }
  );


      $("#chatbox-form").submit(function(event) {
           // alert("Work in progress be patient !");

            var message = $("#chat-message").val();

            send_wiisper(withs, message);


            document.getElementById("chatbox-form").reset();
            event.preventDefault();
        });
        
        $('body').on("change", "#character", function(e) {
            alert($(this).val());
        });
        
    }); // end of document ready
})(jQuery); // end of jQuery name space

 