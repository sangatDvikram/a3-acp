(function($) {
    $(function() {


        $('#autocomplete').autocomplete({
            serviceUrl: '/beta/api/admin/searchaccount/format/json',
            minChars: 0,
            onSelect: function(suggestion) {
               search_account();
            }
        });
        $('#registerd_accounts').dataTable({
            "scrollX": true,
            "searching": false,
            "ajax":
                    {
                        "url": "/beta/api/admin/registerd_accounts/format/json",
                        "type": "POST"
                    }
        });
       function search_account() {
            var id = $("#autocomplete").val();
            //alert(id);
            $('#registerd_accounts').dataTable().fnDestroy();
            var table = $('#registerd_accounts').dataTable({
                "scrollX": true,
                "searching": false,
                "ajax": {
                    "url": "/beta/api/admin/registerd_accounts/char/" + id + "/format/json",
                    "type": "POST",
                    "data": function(d) {
                        d.char = id;
                        // d.custom = $('#myInput').val();
                        // etc
                    }
                }
            });

        }

    }); // end of document ready
})(jQuery); // end of jQuery name space



