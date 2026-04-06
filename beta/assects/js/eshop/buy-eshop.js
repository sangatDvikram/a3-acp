
(function($) {
    $(function() {



        var url = '/beta/api/eshop/generateEshopInfo/format/json';
        var data = 'item=' + item;
        $.post(url, data, function(data)
        {
            $('#characterinfo').html(data);
            tooltipped.init();
            
        }, 'json');

        $('body').on("submit", "#character-form", function(event) {
            event.preventDefault();
        });
        // alert("Work in progress be patient !");

        $('body').on("click", ".submit-buttons", function(event) {

            var data = $('#character-form').serialize();

            if (data != '') {
                $(".submit-buttons").attr('disabled', true);
                data = data + '&item=' + item + "&type=" + $(this).attr("value");
                console.log(data);

                var url = '/beta/api/eshop/makePayment/format/json';

                $.post(url, data, function(data)
                {
                   
                    var is = 1;
                    $.each(data.message, function(i, message)
                    {

                        if (is == 1) {
                            
                            Materialize.toast(message, 2000, '', function() {
                                location.reload();
                            });
                        }
                        else {
                            Materialize.toast(message, 4000);
                        }

                        is++;

                    })

                }, 'json');
            }
            else
            {
                alert("Please select least one character");
            }
            event.preventDefault();
        });





        $('body').on("change", "#character", function(e) {
            var character = $(this).val();
        });

    }); // end of document ready
})(jQuery); // end of jQuery name space

 