$(document).ready(function () {
  $(".banner-link").hover(function () {
      // over
      $(".banner-text").addClass("full-line");
        setTimeout(function(){
          $(".banner-link").addClass("pulsate-fwd");
        }, 100);
    }, function () {
      // out
      $(".banner-text").removeClass("full-line");
      $(".banner-link").removeClass("pulsate-fwd");
    }
  );


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

    // learn by self & book a repair slide animation on scroll position
    $(window).scroll(function(){
      if($(this).scrollTop()>400){
        $(".ani-slide-left, .ani-slide-right").css("visibility", "visible");
        $(".ani-slide-left").addClass("slide-in-left");
        $(".ani-slide-right").addClass("slide-in-right");
      }
    });    
});



  /* $(".product-img-con").css("transform: translateY(-20px)", "box-shadow: none").addClass("active"); */