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
});