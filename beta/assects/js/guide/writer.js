(function($) {
    $(function() {

        tinymce.init({
            selector: "textarea",
            theme: "modern",
            plugins: [
                "advlist autolink lists link image charmap preview hr anchor",
                "searchreplace wordcount visualblocks visualchars code ",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                " paste textpattern textcolor colorpicker"
            ],
            toolbar1: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | numlist outdent indent | link image",
            toolbar2: " preview media | forecolor backcolor ",
            image_advtab: true
        });


    }); // end of document ready
})(jQuery); // end of jQuery name space



