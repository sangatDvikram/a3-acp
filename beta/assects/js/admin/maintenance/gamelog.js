(function ($) {
    $(function () {

        $('#gamelog').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax":
                    {
                        "url": "/beta/api/game/gamelogs/format/json",
                        "type": "POST",
                        "data": function (d) {
                            d.type = types;
                            // d.custom = $('#myInput').val();
                            // etc
                        }
                    },
            "deferLoading": total_log,
            "scrollX": true
        });


    }); // end of document ready
})(jQuery); // end of jQuery name space



