(function($) {
    $(function() {
        var data_table_url = "/beta/api/game_guide/getGameGuideList/format/json";

        $('#example').dataTable({
            "scrollX": true,
            "ajax": {
                "url": data_table_url,
                "type": "POST"
            }

        });

        $('body').on("click", ".view-guide", function() {

            var link = $(this).attr('id');
            var url = '/beta/api/game_guide/getGameGuideDetails/format/json';
            var data = 'link=' + link;

            $.post(url, data, function(data)
            {
                $('#preview-game-guide-title').html(data.guide_title);
                $('#preview-game-guide').html(data.guide_body);
                $("#preview_game_guide_modal").openModal();

            }, 'json');

            return false;
        });
        
         $('body').on("click", ".alert-delete-game-guide", function() {
            var link = $(this).attr('id');
            var data = "Do you want to delete this ? &ensp; <a class='green-text delete-game-guide' href='#' id='" + link + "'>Yes</a> &ensp; <a class='red-text dissable-alert-delete-game-guide' href='#' id='" + link + "'>No</a>";
            Materialize.toast(data, 4000);
            return false;
        });
         $('body').on("click", ".dissable-alert-delete-game-guide", function() {

            $(this).parent().fadeOut();
            return false;
        });
        $('body').on("click", ".change_status", function() {

            var link = $(this).attr('id');
            var data = "Do you want to make this guide visible to players ? &ensp; <a class='green-text visible_yes' href='#' id='" + link + "'>Yes</a> &ensp; <a class='red-text visible_no' href='#' id='" + link + "'>No</a>";
            Materialize.toast(data, 4000);

            return false;
        });
        $('body').on("click", ".visible_yes", function() {
             $(this).parent().fadeOut();
            var link = $(this).attr('id');
            var verified = 1;
            var data = "sr=" + link + "&verified=1";
            var url = '/beta/api/game_guide/updateGameGuideVisibleStatus/format/json';


            $.post(url, data, function(data)
            {
                Materialize.toast(data, 3000);
                regenerate_datatable();

            }, 'json');

            return false;
        });
        $('body').on("click", ".visible_no", function() {
            $(this).parent().fadeOut();
            var link = $(this).attr('id');
            var verified = 0;
            var data = "sr=" + link + "&verified=0";
            var url = '/beta/api/game_guide/updateGameGuideVisibleStatus/format/json';


            $.post(url, data, function(data)
            {
                Materialize.toast(data, 3000);
                regenerate_datatable();

            }, 'json');

            return false;
        });

        $('body').on("click", ".open-game-guide", function() {


            var link = $(this).attr('id');
            var url = '/beta/api/game_guide/getGameGuideDetails/format/json';
            var data = 'link=' + link;

            $.post(url, data, function(data)
            {
                $('.guide_title').val(data.guide_title);
                $('#sr').val(data.sr);

                $('#category_id').val(data.category_id);
                $(".playername").val(data.playername);
                tinymce.get('guide_body').setContent(data.guide_body);
                $("#update_game_guide_modal").openModal();
                if (data.verified == "1") {
                    $("#verified").prop('checked', true);
                }

            }, 'json');

            return false;
        });
        $('body').on("click", ".delete-game-guide", function() {


            var link = $(this).attr('id');
            var url = '/beta/api/game_guide/deleteGameGuide/format/json';
            var data = 'link=' + link;

            $.post(url, data, function(data)
            {
                $('#return-message').html(data);
                regenerate_datatable();

            }, 'json');

            return false;
        });
        $('body').on("click", ".edit-game-guide", function() {
            var guide_title = $('.guide_title').val();
            var category_id = $('#category_id').val();
            var guide_body = encodeURIComponent(tinymce.get('guide_body').getContent());
            var verified = '0';
            var sr = $('#sr').val();
            if ($('#verified').prop('checked')) {
                // something when checked
                verified = 1;
            }
            var datastring = 'sr=' + sr + '&guide_title=' + guide_title + '&category_id=' + category_id + '&guide_body=' + guide_body + '&verified=' + verified;

            //console.log(datastring)

            var url = '/beta/api/game_guide/updateGameGuide/format/json';
            //var data = 'code=' + code;

            $.post(url, datastring, function(data)
            { 
                $('#return-message').html(data);
                Materialize.toast('Guide updated successfully.', 4000);

                regenerate_datatable();
            }, 'json');


            return false;
        });

        function regenerate_datatable()
        {
            //$("#category_form")[0].reset();
            //$("#category_update_form")[0].reset();
            $('#example').dataTable().fnDestroy();
            $('#example').dataTable({
                "scrollX": true,
                "ajax": {
                    "url": data_table_url,
                    "type": "POST"
                }

            });
        }

        tinymce.init({
            selector: "textarea",
            theme: "modern",
            plugins: [
                "advlist autolink lists link image charmap preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code ",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                " paste textpattern textcolor colorpicker"
            ],
            toolbar1: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify |  numlist outdent indent | link image",
            toolbar2: " preview media | forecolor backcolor ",
            image_advtab: true
        });



    }); // end of document ready
})(jQuery); // end of jQuery name space
