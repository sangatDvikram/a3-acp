(function($) {
    $(function() {

        $('body').removeClass('grey').addClass('white');
        $('body').on("keyup keydown focus blur", "#premium-coins", function() {
            
            calculate();
            
        });
        function calculate(){
            var value = $('#premium-coins').val();
            var output = $("#required-amout");
            var amount = $('#amount_paypal');
            if (value.match(/^\d+$/)) {
            var e = value / 60;
            } else if (value.match(/^\d+\.\d+$/)) {
            var e = value / 60;
            }
            else if (value == ''){var e = 0; } 
            else{var e = 0; }
            var c = Math.round(e * 100) / 100;
            c= (c/1).toFixed(2);
            if(c>=5)
            {
                amount.attr("value", c);
                output.html('<br>Total cost will be: $<b><i>'+c+'</i></b> USD');
                $("#submit").removeAttr('disabled');
                
            }
            else
            
            {
                $("#submit").attr('disabled',"");
            }
        }
    }); // end of document ready
})(jQuery); // end of jQuery name space
