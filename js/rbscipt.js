$(document).ready(function()
{

    $(".loader").hide();
    $("#main").hide();

    $(".char").change(function()
    {
        $("#main").hide();
        $(".char").fadeTo(250, 0.33);
        $(".char").attr("disabled", "disabled");
        $(".loader").show();
        var id = $(this).val();
        var dataString = 'char=' + id;
        $.ajax
                ({
                    type: "POST",
                    url: "/Stats/get_rbdetails.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {

                        $("#rbdetails").html(html);
                        $(".loader").hide();
                        $("#main").show(500);
                        $(".char").fadeTo(250, 1);
                        $(".char").removeAttr("disabled");
                    }
                });

    });


});
function disable() {
    /*	$("#myForm").submit();
     $(".btn-success").attr("disabled", "disabled");*/

}