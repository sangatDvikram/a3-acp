(function($){
    $(function(){

        $("#menu2").sideNav({menuWidth: 240, activationWidth: 70,closeOnClick: true });
      $("#menu1").sideNav({menuWidth: 240, activationWidth: 70,closeOnClick: true });


      $("#restore-form").submit(function(event) {
          alert("Work under progress");
          document.getElementById("restore-form").reset();
           $('input').blur();
          event.preventDefault();
        });
      
      
        $(window).bind("load resize", function() {

          
        });
        
    }); // end of document ready
})(jQuery); // end of jQuery name space
