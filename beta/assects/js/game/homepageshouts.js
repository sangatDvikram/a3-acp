(function($) {
    $(function() {
        var shout_loaded = 0; 

        function get_game_shouts()
        {

            var url = '/beta/api/game/getGameShouts/format/json';

            var data = '';

            if (shout_loaded != 0)
            {
                data = 'start=' + shout_loaded;
            }

            $.post(url, data, function(data)
            {
                //$("#shouts").html(" ");

                shout_loaded = data.last;

                $.each(data.shouts, function(i, shout)
                {

                    $("#shouts").append(/*"<span style='color:#b5e7a0'>" + current_date() + "</span>*/"<span class='white-text'><b>" + shout.player + " : </b></span>" + shout.message + "<br>");
                    $("#shouts").fadeIn(500);


                })

                if (data.total_fetch > 0)
                {
                    var elem = document.getElementById('shouts');
                    elem.scrollTop = elem.scrollHeight;
                }

            }, 'json');

        }
        
        function current_date()
        {
            var d = new Date();
            var hr = d.getHours();
            var ampm = "";
            if(hr>12)
            {
                hr -= 12;
                ampm="PM";
            }
            else if(hr == 12)
            {
                ampm="PM";
            }
            else
            {
                ampm="AM";
            }
            return /* d.getDate() +"/" + d.getMonth() + "/" + d.getFullYear() + " " + */"[" + hr + ":" + d.getMinutes() + ampm + "] ";
        } 

        $('body').removeClass('grey');
        $('body').addClass('grey darken-4');



        get_game_shouts();

        window.setInterval(get_game_shouts, 10000);


        $('body').on("click", ".send-web-shout", function(e) {
                    e.preventDefault();
            $('body .toast').hide();
            var data = "This will cost you &nbsp; <b class='yellow-text'> 3 </b> &nbsp; Eshop Coins.";
            Materialize.toast(data, 4000);

            data = "Do you want to continue ? &ensp; <a class='green-text send_shout_yes' href='#' id=''>Yes</a> &ensp; <a class='red-text send_shout_no' href='#' id=''>No</a>";
            Materialize.toast(data, 4000);

        });


        $('body').on("click", ".login-player", function() {

            $('body .toast').hide();

            var data = $("#login-form-homepage").serializeArray();


            var url = '/beta/api/login/loginplayers/format/json';



            $.post(url, data, function(data)
            {

                if (data.success == '1')
                {
                    $('#modal1').closeModal();
                    $("#login-form-homepage")[0].reset();
                    window.location.reload()
                }
                else
                {
                    //console.log(data.error);
                    Materialize.toast(data.error, 4000);
                }

            }, 'json');
        });

        $('body').on("click", ".logmeout", function(e) {

            e.preventDefault();

            var url = '/beta/api/login/logout/format/json';

            var data="";

            $.post(url, data, function(data)
            {

                if (data.success == '1')
                {
                    window.location.reload()
                }

            }, 'json');



        });



        $('body').on("click", ".send_shout_yes", function(e) {
             $(this).parent().fadeOut();+
             
            $('body .toast').fadeOut();

            var shout_text = $("#shout_text").val();

            var regex = /\?+/g;
            var replaceWith='?';


            var data ="shout_text=" + shout_text.replace(regex,replaceWith);

             var url = '/beta/api/game/sendGameShout/format/json';
             
             
             $.post(url, data, function(data)
             {
             $("body #shout_text").val('');    
             $('body .toast').fadeOut();
            
             $.each(data.error, function(i, error)
                {

                    Materialize.toast(error, 3000);


                });
                 $.each(data.message, function(i, message)
                {

                    Materialize.toast(message, 3000);


                });
                
                get_game_shouts();
             
             }, 'json'); 

            e.preventDefault();
        });
        $('body').on("click", ".send_shout_no", function(e) {
            
            $(this).parent().slideUp();
            $('body .toast').slideUp();

            e.preventDefault();

        });

        $(window).bind("load resize", function() {
            _winHeight = $(window).height() / 100;

            // Setting Height0
            $('#shouts').css({'height': (($(window).height() - $("#send_shout").height())) + 'px'}); // 50% Height
            $('body .modal-content').css({'height': '80%'}); // 50% Height
            // alert(100-(($("#send_shout").height()/$(window).height())*100));
            //alert(($("#send_shout").height()));
            //$('#shouts').css({'margin-bottom':_winHeight * (100-85)});
            //$('#send_shout').css({'height':_winHeight * 5}); // 25% Height
        });

    }); // end of document ready
})(jQuery); // end of jQuery name space
