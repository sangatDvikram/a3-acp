(function ($) {
    $(function () {
 
        $('#itemtracker').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax":
                    {
                        "url": "/beta/api/game/tracklogs/format/json",
                        "type": "POST",
                        "data": function (d) {
                            d.account = account;
                            d.character = character;
                            d.ic=ic;
                            d.iu=iu;
                        }
                    },
            "deferLoading": total_log,
            "scrollX": true
        });


    }); // end of document ready
})(jQuery); // end of jQuery name space



