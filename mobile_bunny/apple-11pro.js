$(document).ready(function () {
    
    //to change img in carousel on the basis of clicks on colors
    //for mobile view
    $("#c-green").click(function () {
        //first two will work on BS carousel for mobile view 
        $("#img1").attr("src", "pro-MG1.png");
        $("#img2").attr("src", "pro-MG2.png");
        //next three are for desktop view
        $("#g1, #g2, #s1, #s2, #sg1, #sg2").hide();
        $("#mg1, #mg2").show();
        $(".large-img img").attr("src", "pro-MG2.png");
        //last two will work for both mobile & desktop view
        $("#c-gold, #c-silver, #c-grey").css({"box-shadow":"none","opacity":".4"});
        $(this).css({"box-shadow":"rgb(100, 100, 100) 0px 10px 7px -5px","opacity": "1"});
    });

    $("#c-gold").click(function () {
        //first two will work on BS carousel for mobile view 
        $("#img1").attr("src", "pro-G1.png");
        $("#img2").attr("src", "pro-G2.png");
        //next three are for desktop view
        $("#mg1, #mg2, #s1, #s2, #sg1, #sg2").hide();
        $("#g1, #g2").show();
        $(".large-img img").attr("src", "pro-G2.png");
        //last two will work for both mobile & desktop view
        $("#c-green, #c-silver, #c-grey").css({"box-shadow":"none","opacity":".4"});
        $(this).css({"box-shadow":"rgb(100, 100, 100) 0px 10px 7px -5px","opacity": "1"});
    });

    $("#c-silver").click(function () {
        //first two will work on BS carousel for mobile view 
        $("#img1").attr("src", "pro-S1.png");
        $("#img2").attr("src", "pro-S2.png");
        //next three are for desktop view
        $("#mg1, #mg2, #g1, #g2, #sg1, #sg2").hide();
        $("#s1, #s2").show();
        $(".large-img img").attr("src", "pro-S2.png");
        //last two will work for both mobile & desktop view
        $("#c-gold, #c-green, #c-grey").css({"box-shadow":"none","opacity":".4"});
        $(this).css({"box-shadow":"rgb(100, 100, 100) 0px 10px 7px -5px","opacity": "1"});
    });

    $("#c-grey").click(function () {
        //first two will work on BS carousel for mobile view 
        $("#img1").attr("src", "pro-SG1.png");
        $("#img2").attr("src", "pro-SG2.png");
        //next three are for desktop view
        $("#mg1, #mg2, #g1, #g2, #s1, #s2").hide();
        $("#sg1, #sg2").show();
        //last two will work for both mobile & desktop view
        $(".large-img img").attr("src", "pro-SG2.png");
        $("#c-gold, #c-silver, #c-green").css({"box-shadow":"none","opacity":".4"});
        $(this).css({"box-shadow":"rgb(100, 100, 100) 0px 10px 7px -5px","opacity": "1"});
    }); 
    

    //this will change the large image on hover of two little img
    //on desktop view
    $(".multi-img a").mouseover(function () {
        $(".large-img img").attr("src", $(this).attr("href"));
    });

    //for storage option six_four_gb two_fifty_six_gb five_one_two_gb
    $(".six_four_gb").click(function () { 
        $(this).addClass("select_storage");
        $(".two_fifty_six_gb,.five_one_two_gb").removeClass("select_storage");
    });  

    $(".two_fifty_six_gb").click(function () { 
        $(this).addClass("select_storage");
        $(".six_four_gb,.five_one_two_gb").removeClass("select_storage");
    });  

    $(".five_one_two_gb").click(function () { 
        $(this).addClass("select_storage");
        $(".two_fifty_six_gb,.six_four_gb").removeClass("select_storage");
    });  

    $("#v_more").click(function () {
        $(this).hide();
        $(".hidden").fadeIn();
        $("#v_less").show();
    });

    $("#v_less").click(function () {
        $(".hidden").fadeOut();
        $(this).hide();
        $("#v_more").show();
    });
});