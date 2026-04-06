(function($) {
    $(function() {
        var data_table_url = "/beta/api/game_guide/getCategoryList/format/json";
        $('#example').dataTable({
            "scrollX": true,
            "ajax": {
                "url": data_table_url,
                "type": "POST"
            }

        });

        $('body').on("click", ".submit-form", function() {
            var datastring = $("#category_form").serialize(); //Serialize looks good name=textInNameInput&&telefon=textInPhoneInput---etc
            //alert(datastring);

            var url = '/beta/api/game_guide/createGuideCategory/format/json';
            //var data = 'code=' + code;

            $.post(url, datastring, function(data)
            {

                //$('#return-message').html(data);
                Materialize.toast(data, 4000);

                regenerate_datatable();
            }, 'json');

            return false;
        });

        $('body').on("click", ".edit-category", function() {
            var datastring = $("#category_update_form").serialize(); //Serialize looks good name=textInNameInput&&telefon=textInPhoneInput---etc
            //alert(datastring);

            var url = '/beta/api/game_guide/updateeGuideCategory/format/json';
            //var data = 'code=' + code;

            $.post(url, datastring, function(data)
            {
                //$('#return-message').html(data);
                Materialize.toast(data, 4000);
                regenerate_datatable();
            }, 'json');

            return false;
        });

        $('body').on("click", ".open-edit-category", function() {

            var sr = $(this).attr('id');
            var url = '/beta/api/game_guide/getCategoryDetails/format/json';
            var data = 'sr=' + sr;

            $.post(url, data, function(data)
            {
                $("#update_category_sr").attr("value", data.sr);
                $("#update_category_name").attr("value", data.category_name);
                if (data.enable_posts == "1") {
                    $("#update_enable_posts").prop('checked', true);
                }


                $("#category_update_model").openModal();

            }, 'json');
            return false;
        });

        function regenerate_datatable()
        {
            $("#category_form")[0].reset();
            $("#category_update_form")[0].reset();
            $('#example').dataTable().fnDestroy();
            $('#example').dataTable({
                "scrollX": true,
                "ajax": {
                    "url": data_table_url,
                    "type": "POST"
                }

            });
        }


    }); // end of document ready
})(jQuery); // end of jQuery name space
