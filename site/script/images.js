$(document).ready(function () {

    var divNam = "";

    $("li").hover(function () {
        $(this).css("background-color", "#FDA432");
        $(this).css("color","#0075B2");
    });

    $("li").click(function () {
        $("#rightContent").children().hide();
        divNam = "#" + $(this).attr("id") + "-div";
        $("#imageContainer").fadeOut("fast", function () {

            $(divNam).fadeIn("fast", function () {

            });
        });
    });

    $("li").mouseout(function () {
        $(this).css("background-color", "#DCDADA");
        $(this).css("color","#FFFFFF");
        $(divNam).fadeOut("fast", function () {
            $("#imageContainer").fadeIn("fast", function () {
            });
        });

    });
});

