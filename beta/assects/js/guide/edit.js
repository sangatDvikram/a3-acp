(function($) {
    $(function() {
        
         var data_table_url = "/beta/api/game_guide/getPlayerGameGuideList/format/json";
        
        $('#player-guide-info').dataTable({
            "scrollX": true,
            "ajax": {
                "url": data_table_url,
                "type": "POST"
            }

        });
        tinymce.init({
            selector: "textarea",
            theme: "modern",
            plugins: [
                "advlist autolink lists link image charmap preview hr anchor",
                "searchreplace wordcount visualblocks visualchars code ",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                " paste textpattern textcolor colorpicker"
            ],
            toolbar1: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify |  numlist outdent indent | link image",
            toolbar2: " preview media | forecolor backcolor",
            image_advtab: true
        });

        $('body').on("click", ".view-guide", function() {

            var link = $(this).attr('id');
            var url = '/beta/api/game_guide/getPlayerGameGuideDetails/format/json';
            var data = 'link=' + link;

            $.post(url, data, function(data)
            {
                $('#preview-game-guide-title').html(data.guide_title);
                $('#preview-game-guide').html(data.guide_body);
                $("#preview_game_guide_modal").openModal();

            }, 'json');

            return false;
        });

    }); // end of document ready
})(jQuery); // end of jQuery name space



