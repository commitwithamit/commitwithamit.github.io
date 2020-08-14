$(document).ready(function () {
    $(".sort").click(function () { 
        $(".sort_alert").show(600); 
        $(".filter_alert").hide(500);       
    });
    $(".sort_close_icon").click(function () { 
        $(".sort_alert").hide(600);
        
    });
    $(".filter").click(function () { 
        $(".filter_alert").show(600); 
        $(".sort_alert").hide(500);  
    });
    $(".filter_close_icon").click(function () { 
        $(".filter_alert").hide(600);
    });


    //to hide filters and sort list once the screen width is >=992
    //using the below method won't allow the filters and sort list
    //pop-up again when the screen width is <=992
    $(window).resize(function () { 
        if($(window).width() >=900){
            $(".filter_alert").hide();
            $(".sort_alert").hide();
        }
    });


    //sliding up and down filters for desktop view
    $("#d-price").slideDown(1000);
    $("#f-price").click(function (e) { 
        $("#d-price").slideToggle(1000);
    });

    $("#f-brand").click(function (e) { 
        $("#d-brand").slideToggle(1000);
    });

    $("#f-cam").click(function (e) { 
        $("#d-cam").slideToggle(1000);
    });

    $("#f-os").click(function (e) { 
        $("#d-os").slideToggle(1000);
    });
    
    $("#f-battery").click(function (e) { 
        $("#d-battery").slideToggle(1000);
    });

    $(".filter-head").click(function () { 
        $(this).find("img").toggle();        
    });

   
});