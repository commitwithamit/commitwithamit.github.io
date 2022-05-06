// toggling menu icon
$(".navbar-toggler").click(function(){
    $(this).toggleClass("active");
    $(this, ".menu-icon").toggleClass("rotate-center");
    $(".collapse-menu").slideToggle();
});

// decreasing the height of navbar on scroll
$(window).scroll(function(){
    var pos = $(window).scrollTop();
    if(pos >= 1){
      $(".navbar").addClass("nav-scroll");
    }else{
      $(".navbar").removeClass("nav-scroll");
    }
});