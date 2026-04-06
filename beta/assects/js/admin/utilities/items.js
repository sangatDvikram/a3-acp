(function($) {
    $(function() {
        var datatable_url = "/beta/api/data/itemlist/format/json";
        $('#example').dataTable({
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": datatable_url,
                "type": "POST"
            }

        });

        $('body').on("click", ".open-item-edit-model", function() {

            var link = $(this).attr('id');
            var data = 'sr=' + link;

           // toast('This option under construction', 3000);

            var url = '/beta/api/data/getItemDetails/format/json';

            $.post(url, data, function(data)
            {
                $(".item_info").val(data.item_info);
                $(".sr_no").val(data.sr_no);
                $(".item_code").val(data.item_code);
                $(".item_name").val(data.item_name);
                $(".item_type").val(data.item_type);
                $(".item_class").val(data.item_class);
                $(".image").val(data.image);
                $(".modify-form").show(500);
                jQuery("html, body").animate({scrollTop: 300}, 500);

            }, 'json');


            return false;
        });

        $("#item-edit-form").submit(function() {

            //toast('This option under construction', 3000);
            var data = $("#item-edit-form").serialize();

            //console.log(data);


            var url = '/beta/api/data/updateItemDetails/format/json';

            $.post(url, data, function(data)
            {
                Materialize.toast(data, 3000);
                regenerate_datatable()
                $(".modify-form").hide();
            }, 'json');

            return false;
        });


        function regenerate_datatable()
        {
            $("#item-edit-form")[0].reset();
            //$("#category_update_form")[0].reset();
            $('#example').dataTable().fnDestroy();
            $('#example').dataTable({
                "scrollX": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": datatable_url,
                    "type": "POST"
                }

            });
        }
    }); // end of document ready
})(jQuery); // end of jQuery name space
