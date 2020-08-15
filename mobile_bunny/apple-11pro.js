$(document).ready(function () {
    
    //to change img in carousel on the basis of clicks on colors
    //for mobile view
    $("#c-green").click(function () {
        $("#img1").attr("src", "pro-MG1.png");
        $("#img2").attr("src", "pro-MG2.png");
        $("#c-gold, #c-silver, #c-grey").css("opacity", ".4");
        $(this).css("opacity", "1");
    });

    $("#c-gold").click(function () {
        $("#img1").attr("src", "pro-G1.png");
        $("#img2").attr("src", "pro-G2.png");
        $("#c-green, #c-silver, #c-grey").css("opacity", ".4");
        $(this).css("opacity", "1");
    });

    $("#c-silver").click(function () {
        $("#img1").attr("src", "pro-S1.png");
        $("#img2").attr("src", "pro-S2.png");
        $("#c-gold, #c-green, #c-grey").css("opacity", ".4");
        $(this).css("opacity", "1");
    });

    $("#c-grey").click(function () {
        $("#img1").attr("src", "pro-SG1.png");
        $("#img2").attr("src", "pro-SG2.png");
        $("#c-gold, #c-silver, #c-green").css("opacity", ".4");
        $(this).css("opacity", "1");
    }); 
    
    
    
    $("#v_more").click(function () {
        $(this).hide();
        $(".hidden").fadeIn(800);
        $("#v_less").show();
    });

    $("#v_less").click(function () {
        $(".hidden").fadeOut(800);
        $(this).hide();
        $("#v_more").show();
    });
});