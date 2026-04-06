(function($){
    $(function(){

        $('#example').dataTable( {
            "scrollX": true,
            "ajax": {
                "url": "/beta/api/data/monsterlist/format/json",
                "type": "POST"
            }

        } );


    }); // end of document ready
})(jQuery); // end of jQuery name space
