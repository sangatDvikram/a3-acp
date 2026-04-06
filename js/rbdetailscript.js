$(document).ready(function()
{

    $(".loader").hide();
    $("#main").hide();

    $(".Rb").change(function()
    {
        $("#main").hide();
        $(".Rb").fadeTo(250, 0.33);
        $(".Rb").attr("disabled", "disabled");
        $(".loader").show();
        var id = $(this).val();
        var dataString = 'Rb=' + id;
        $.ajax
                ({
                    type: "POST",
                    url: "/Stats/Rbdetails.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {

                        $("#rbdetails").html(html);
                        $(".loader").hide();
                        $("#main").show(500);
                        $(".Rb").fadeTo(250, 1);
                        $(".Rb").removeAttr("disabled");
                    }
                });

    });


});
$("[rel=drevil]").popover({
    placement: 'bottom',
    html: 'true',
    trigger: "hover"
});
function disable() {


}