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
        if($(window).width() >=992){
            $(".filter_alert").hide();
            $(".sort_alert").hide();
        }
    });


   
});