var start = 0;
var last = 0;
var withs = 0;
var first_message = "";
var last_message = "";
var last_char_message = 0;
var History = window.History;
var State_count = 1;
var chat_char = "";
var Character_menu_list = "";
var chat_date = "";

function checkUrl()
{
    var path = location.href;
    if (path.toLowerCase().indexOf("character") >= 0) {
        History.replaceState({state: State_count}, "Home - InGame Chat panel  - A3Ultimate.com", '?home');
    }
}
function isScrolledIntoView(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();
    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom) && (elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
function get_game_chat(withs)
{

    var url = '/beta/api/game/getCharChatWith/format/json';

    var data = 'with=' + withs;

    $(".chat-character").removeClass("active");
    $("#" + withs).addClass('active');
    $("#chat-char-name").html(withs);



    start = 0;
    last = 0


    $(".character-chat").html("<div id='loader'></div>");

    $.post(url, data, function(data)
    {

        if (last != data.last) {

            $(".character-chat").html(data.chat);
            tooltipped.init();
            var elem = document.getElementById('chat-messages');
            elem.scrollTop = elem.scrollHeight;
            chat_date = data.date;
            start = data.start;
            last = data.last;
            if (last_char_message == 0) {
                last_char_message = data.last;
            }
            var textbox = document.getElementById(last);
            textbox.focus();
            textbox.scrollIntoView();
        }
    }, 'json');

}
function get_serch_character(withs)
{

    var url = '/beta/api/game/getSearchedChar/format/json';

    var data = 'search=' + withs;
    $.post(url, data, function(data)
    {


        $(".character-list").html(data.list);


    }, 'json');

}
function send_wiisper(to, message)
{

    var url = '/beta/api/game/sendGameWisper/format/json';

    var data = 'to=' + to + '&message=' + message;

    $.post(url, data, function(data)
    {


        $(".chat-messages").append(data.chat);
        focus(data.id);
        if (last_char_message > 0) {
            last_char_message = data.id;
        }

    }, 'json');

}

function get_game_chat_previous()
{

    var url = '/beta/api/game/getCharChatWith/format/json';

    var data = 'with=' + withs + '&start=' + start + '&date=' + chat_date;



    $.post(url, data, function(data)
    {


        /*      var textbox = document.getElementById(start);
         textbox.focus();
         textbox.scrollIntoView();
         */

        $(".chat-messages").prepend(data.chat);
        start = data.start;
        last = data.last;
        if (last > 0) {
            $(".chat-more").fadeIn();
        }
        else {
            $(".chat-more").fadeOut();
        }

    }, 'json');

}
function get_game_chat_previous()
{

    var url = '/beta/api/game/getCharChatWith/format/json';

    var data = 'with=' + withs + '&start=' + start;



    $.post(url, data, function(data)
    {


        /*      var textbox = document.getElementById(start);
         textbox.focus();
         textbox.scrollIntoView();
         */

        $(".chat-messages").prepend(data.chat);
        start = data.start;
        last = data.last;
        if (last > 0) {
            $(".chat-more").fadeIn();
            var textbox = document.getElementById(last);
            textbox.focus();
            textbox.scrollIntoView();

        }
        else {
            $(".chat-more").fadeOut();
        }

    }, 'json');

}
function update_chat_box()
{
    if (withs != 0&&last_char_message!=0) {
        var url = '/beta/api/game/updateChat/format/json';
        var newlast=parseInt(last_char_message, 10)+parseInt("0.5", 10);
        var data = 'with=' + withs + '&last=' + (newlast)+'&date='+chat_date;
        

        $.post(url, data, function(data)
        {

            if (data.new > 0) {
                $(".chat-messages").append(data.chat);
                focus(data.last);
                if (last_char_message > 0 && data.last > 0) {
                    last_char_message = data.last;
                }
            }

        }, 'json');
    }

}
function focus(id)
{
    var textbox = document.getElementById(id);
    textbox.focus();
    textbox.scrollIntoView();
}
function destory_sesstion()
{
    var url = '/beta/api/game/destroyChatSession/format/json';

    var data = "";



    $.post(url, data, function(data)
    {
        window.location.reload();

    }, 'json');
}
function get_char_chat_list()
{
    var url = '/beta/api/game/getcharacterChatlist/format/json';

    var data = "";



    $.post(url, data, function(data)
    {
        $('.chat-list').html(data.list);

        first_message = data.start;
        last_message = data.last;

    }, 'json');
}
function animate_left_menu()
{
    $('.left-menu').animate({marginLeft: parseInt($('.left-menu').css('marginLeft'), 10) == 0 ? -$('.left-menu').outerWidth() : 0}, "medium", function(e) {
        if ($(".left-menu").hasClass('hidden'))
        {


            $(".right-main").removeClass("hide-on-med-and-down");
            $(".left-menu").removeClass('hidden');

        } else {
            $('.left-menu').addClass("hidden");
            $(".right-main").addClass("hide-on-med-and-down");
        }
    });
}

(function($) {
    $(function() {
        checkUrl();

        window.setInterval(update_chat_box, 10000);
        //$(".character-list").html("<div id='loader'></div>");

        $('body').on("click", ".chat-character", function(e) {
            if (!$(this).hasClass('active'))
            {
                $('.home-panel').hide();
                $('.chat-panel').fadeIn();
                $(".chat-more").fadeIn();
                $(".character-chat").html("<div id='loader'></div>");
                last_char_message = 0;
                if (!$('.right-main').is(':visible'))
                {
                    $('.left-menu').addClass("hidden");
                    animate_left_menu();

                }

                chat_char = $(this).attr('id');
                //window.location.hash = chat_char;
                History.pushState({state: State_count}, chat_char + "- InGame Chat panel  - A3Ultimate.com", "?character=" + chat_char);
                State_count++;
                withs = chat_char;





            }
            e.preventDefault();

        });

        $('body').on("click", "#home", function(e) {
            withs = 0;
            History.pushState({state: State_count}, "Home - InGame Chat panel  - A3Ultimate.com", '?home');
            $(".chat-character").removeClass("active");

            if ($(".left-menu").hasClass('hidden'))
            {
                animate_left_menu();


            } else
            {
                $('.chat-panel').hide();
                $('.home-panel').show();
            }

            e.preventDefault();
        });




        $('body').on("click", "#chat-more", function(e) {
            $(".chat-more").hide();
            get_game_chat_previous();
            e.preventDefault();
        });

        $('body').on("click", "#ChangeCharacter", function(e) {
            destory_sesstion();
            e.preventDefault();
        });
        $('body').on("click", "#clear-text", function(e) {
            $(".search-bar").val("");
            get_serch_character(" ");
            e.preventDefault();
        });

        $('body').on("click", ".back-to-main", function(e) {
            withs = 0;
            if ($('.back-to-main').is(':visible'))
            {
                History.pushState({state: State_count}, "Home - InGame Chat panel  - A3Ultimate.com", '?home');
                animate_left_menu();
                $(".left-menu").removeClass('hidden');
            }

            e.preventDefault();
        });

        $('body').on("keyup paste", ".serch-bar", function(e) {

            var search = $(this).val();
            if (search.length > 2)
            {
                get_serch_character(search);
            }
            if (search.length == 0)
            {
                get_serch_character(search);
            }
            if (search.length > 0)
            {
                $("#clear-text").show();
                $("#search-text").hide();
            }
            else
            {
                $("#clear-text").hide();
                $("#search-text").show();
            }

            e.preventDefault();
        });


        $("#chatbox-form").submit(function(event) {
           // alert("Work in progress be patient !");

            var message = $("#chat-message").val();

            send_wiisper(withs, message);


            document.getElementById("chatbox-form").reset();
            event.preventDefault();
        });

       


        $(window).bind("load resize", function() {

            Character_menu_list = $(".chat-list").html();

            _winHeight = $(window).height() / 100;

            // Setting Height0
            if ($(window).width() > 992)
            {
                if (!$('.left-menu').is(':visible'))
                {

                    animate_left_menu();
                    $(".left-menu").removeClass('hidden');

                }
            }

            $('.character-list').css({'height': (($(".left-menu").height() - 54 - 68)) + 'px'});
            $('.character-chat').css({'height': (($(".left-menu").height() - 136)) + 'px'});

        });



        /* $(".character-chat").bind( "scroll",function(e) {
         //alert('scrolling');
         if ($('.chat-more').is(':visible')) {
         e.stopPropagation();
         e.preventDefault();
         
         $(window).scrollTop() == $(document).height() - $(window).height()
         if ($('.character-chat').scrollTop() <= $("#chat-more").offset().top)
         {
         
         get_game_chat_previous()
         }
         }
         
         });*/
        $("img").removeClass("responsive-img");




        History.Adapter.bind(window, 'statechange', function() {
            var State = History.getState();
            //History.log(State.data, State.title, State.url);

            console.log(State);

            var url = State.url;

            var split_url = url.split("=");

            if (split_url.length > 1) {

                get_game_chat(split_url[1]);
                /* var textbox = document.getElementById(split_url[1]);
                 // textbox.focus();
                 textbox.scrollIntoView();*/
            }
            else
            {
                $("#home").trigger('click');


            }

        });


        $('.dropdown').dropdown(
                {
                    inDuration: 300,
                    outDuration: 225,
                    constrain_width: false, // Does not change width of dropdown to that of the activator
                    hover: false, // Activate on hover
                    gutter: 0, // Spacing from edge
                    belowOrigin: false // Displays dropdown below the button
                });

    }); // end of document ready
})(jQuery); // end of jQuery name space

 