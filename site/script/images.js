$(document).ready(function () {

    var divNam = "";

    $("li").hover(function () {
        $(this).css("background-color", "#FDA432");
        $(this).css("color","#0075B2");
    });

    $("li").click(function () {

        divNam = "#" + $(this).attr("id") + "-div";
        $("#imageContainer").fadeOut("slow", function () {

            $(divNam).fadeIn("slow", function () {

            });
        });
    });

    $("li").mouseout(function () {
        $(this).css("background-color", "#DCDADA");
        $(this).css("color","#FFFFFF");
        $(divNam).fadeOut("slow", function () {
            $("#imageContainer").fadeIn("slow", function () {
            });
        });

    });
});

