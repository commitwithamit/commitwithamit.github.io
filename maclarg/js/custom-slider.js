$(document).ready(function () {
    //right (next)
    $("#next").click(function () {
      //S-out kedarnath
      $("#pro-ked").css("right", "100%");
      //S-In ram
      $("#pro-ram").css("left", "0");
    });
    
    //left (previous)
    $("#prev").click(function () {
      //S-out ram
      $("#pro-ked").css("right", "0");
      //S-IN kedarnath
      $("#pro-ram").css("left", "100%");
    });
  });