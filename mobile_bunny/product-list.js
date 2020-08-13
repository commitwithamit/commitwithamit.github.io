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
});