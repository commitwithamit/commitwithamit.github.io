$(document).ready(function () {
    // dropdown hide/show & color bg changes
    $(".dropdown").hover(function () {
      $(".dropdown .dropdown-menu").toggleClass("display");
      if ($(".dropdown .dropdown-menu").hasClass("display")) {
        $(".drop-link").css("color", "black");
      } else {
        $(".drop-link").css("color", "white");
      }
    });
    // hiding dropdown on hover of other links
    $(".drop-hide").hover(function(){
      $(".dropdown-menu, .drop-link").removeClass("show");
    });
    // hiding dropdown on click of dropdown menu
    $(".dropdown").click(function () { 
      $(".dropdown-menu").toggleClass("show");
    });

    $(window).scroll(function(){
        if($(this).scrollTop()>400){
            $(".ani-slide-left, .ani-slide-right").css("visibility", "visible");
            // $(".ani-slide-left").addClass("slide-in-left");
            // $(".ani-slide-right").addClass("slide-in-right");
        }
        // var top = $(document).scrollTop();
        // console.log(top);
    });

    // $(window).scroll(function(){
        // if($(this).scrollTop()>360){
        //   $(".animate, .animate-2").addClass("four");
        //   $(".animate, .animate-2").css("display", "flex");
        // }else{
        //   $(".animate, .animate-2").removeClass("four");
        //   $(".animate, .animate-2").css("display", "none");
        // }
    // });

});