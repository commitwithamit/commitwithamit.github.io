$(document).ready(function () {
    //h-burger menu open close
    $(".sidebarbtn").click(function () {
        $(".sidebar").toggleClass("active");
        $(".sidebarbtn").toggleClass("toggle");
    });

    //categories inside of burger menu open close
    $("#sign").click(function () {
        $("#mini-list").slideToggle(1000);
        $("#mini-list2, #mini-list3,#b_list,#p_list,#l_list,#a_list").slideUp();
        $(this).find("svg").toggle();
        $("#more .caret_up, #category .caret_up").hide();
        $("#more .caret_down, #category .caret_down").show();
    });

    //dropdown on hover of sign in
    //sign-in hover menu
    $(".hov-si").hover(function () {
        // over
        $(".drop-signin").fadeIn();
    }, function () {
        // out
        $(".drop-signin").hide();
    });

    $(".drop-signin").hover(function () {
        // over
        $(this).show();
    }, function () {
        // out
        $(this).hide();
    });


    $("#more").click(function () {
        $("#mini-list2").slideToggle(1000);
        $("#mini-list, #mini-list3,#b_list,#p_list,#l_list,#a_list").slideUp();
        $(this).find("svg").toggle();
        $("#sign .caret_up, #category .caret_up").hide();
        $("#sign .caret_down, #category .caret_down").show();
    });

    //more dropdown
    $(".hov-mo").hover(function () {
        // over
        $(".drop-more").fadeIn();
        $("#down-arrow").hide();
        $("#up-arrow").show();
    }, function () {
        // out
        $(".drop-more").hide();
        $("#down-arrow").show();
        $("#up-arrow").hide();
    });

    $(".drop-more").hover(function () {
        // over
        $(this).show();
        $("#down-arrow").hide();
        $("#up-arrow").show();
    }, function () {
        // out
        $(this).hide();
        $("#down-arrow").show();
        $("#up-arrow").hide();
    });

    $("#category").click(function () {
        $("#mini-list3").slideToggle(1000);
        $("#mini-list, #mini-list2").slideUp();
        $(this).find("svg").toggle();
        $("#more .caret_up, #sign .caret_up").hide();
        $("#more .caret_down, #sign .caret_down").show();
    });


    //list open close inside category (inside buger menu)
    $("#li_brand").click(function () {
        $("#mini-list3,#p_list,#l_list,#a_list").hide();
        $("#b_list").show();
    });

    $(".bback").click(function () {
        $("#mini-list3").show();
        $("#b_list").hide();
    });

    $("#li_pprice").click(function () {
        $("#mini-list3,#b_list,#l_list,#a_list").hide();
        $("#p_list").show();
        $("#b_list").hide();
    });

    $(".pback").click(function () {
        $("#mini-list3").show();
        $("#p_list").hide();
    });

    $("#li_launch").click(function () {
        $("#mini-list3,#b_list,#p_list,#a_list").hide();
        $("#l_list").show();
    });

    $(".lback").click(function () {
        $("#mini-list3").show();
        $("#l_list").hide();
    });

    $("#li_access").click(function () {
        $("#mini-list3,#b_list,#p_list,#l_list").hide();
        $("#a_list").show();
    });

    $(".aback").click(function () {
        $("#mini-list3").show();
        $("#a_list").hide();
    });

    //category nav dropdowns will appear only after @min-width:1200px

    $(".brand").hover(function () {
        // over 
        $(".drop-brand").fadeIn(); 
     }, function () {
         // out
         $(".drop-brand").hide();
     });
    $(".drop-brand").hover(function () {
        // over    
        $(this).show();            
     }, function () {
         // out
         $(".drop-brand").hide();
     });

    $(".price").hover(function () {
        // over
        $(".drop-price").fadeIn();            
    }, function () {
        // out
        $(".drop-price").hide();
    });
    $(".drop-price").hover(function () {
        // over
        $(this).show();     
    }, function () {
        // out
        $(".drop-price").hide();
    });

    $(".launches").hover(function () {
        // over
        $(".drop-launches").fadeIn();
    }, function () {
        // out
        $(".drop-launches").hide();
    });
    $(".drop-launches").hover(function () {
        // over
        $(this).show();
    }, function () {
        // out
        $(this).hide();
    });

    $(".accessories").hover(function () {
        // over
        $(".drop-accessories").fadeIn();
    }, function () {
        // out
        $(".drop-accessories").hide();
    });
    $(".drop-accessories").hover(function () {
        // over
        $(this).show(); 
    }, function () {
        // out
        $(".drop-accessories").hide();
    });

    $(".drop-brand").hover(function () {
        $(".brand").toggleClass("drop-hov");
    });
    $(".drop-price").hover(function () {
        $(".price").toggleClass("drop-hov");
    });
    $(".drop-launches").hover(function () {
        $(".launches").toggleClass("drop-hov");
    });
    $(".drop-accessories").hover(function () {
        $(".accessories").toggleClass("drop-hov");
    });
    $(".drop-more").hover(function () {
        $(".more").toggleClass("more-hov");
    });


    //owl carousel
    $('.owl-carousel').owlCarousel({
        loop:false,
        rewind: true,   
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            900:{
                items:3
            },
            1100:{
                items:4
            },
            1200:{
                items:5
            }
        }
    });


     //phones will shake on hover
     $(".shadow-animation").hover(function () {
        // over
        $(this).addClass("vibrate-1");
    }, function () {
        // out
        $(this).removeClass("vibrate-1");
    });

    //jello animation on subscribe button
    $(".cta-btn, .cta-btn2").mouseover(function () { 
        $(this).addClass("jello-horizontal");
    });
});