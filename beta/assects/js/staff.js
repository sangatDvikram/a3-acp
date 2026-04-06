(function($){
    $(function(){

        $('body').removeClass('grey');
        $('body').addClass('white');
        var prot=$( "#pritam-info" ).height();
        $("#pritam-parallax").css("height", prot+"px");
        var chaitnya=$( "#chaitnya-info" ).height();
        $("#chaitnya-parallax").css("height", chaitnya+"px");
        var vikram=$( "#vikram-info" ).height();
        $("#vikram-parallax").css("height", vikram+"px");
        //alert(prot);
    }); // end of document ready
})(jQuery); // end of jQuery name space
