// toggling menu icon
$(".navbar-toggler").click(function(){
    $(this).toggleClass("active");
    $(this, ".menu-icon").toggleClass("rotate-center");
    $(".collapse-menu").slideToggle();
});

// search request
$(".search-nav").keyup(function () {
  var input = $(this).val();
  $.ajax({
    type: "post",
    url: "search.php",
    data: {"input": input},
    success:function(result){
      if(input != ''){
        $(".display-result").html(result);
      }else{
        $(".display-result").html('');
      }
      if(result == ""){
        $(".display-result").text('- No match found -').css("padding-left","10px");
      }else{
        $(".display-result").css("padding-left","0px");
      }
    }
  })
});

// showing search result on focus of search bar
$(".search-bar-form input").on("focus", function(){
    $(".display-result").show();
});
$(document).on('click',function(e){
  if(!(($(e.target).closest(".display-result").length > 0 ) || ($(e.target).closest(".search-bar-form input").length > 0))){
    $(".display-result").hide();
 }
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