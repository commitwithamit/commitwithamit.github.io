$(document).ready(function () {
  // showing alert messages on submiting edit profile form
  $("#modal-sub-btn").on("click", function(){
    var inp_dob = $("#inp-dob").val();

    if(inp_dob == ""){
      $(".msg-details").addClass("msg-err");
      $(".msg-con").addClass("top-zero");
      $(".msg-box").text("Please enter your date of birth");
      $("#inp-dob").css("border-color", "red");
      setTimeout(function(){
        $(".msg-details").fadeOut(3000);
      }, 5000);
      $(".msg-close").click(function(){
        $(".msg-details").fadeOut("fast");
      });
      return false;
    }else{
      $(".msg-con").removeClass("top-zero");
      $(".msg-details").removeClass("msg-suc, msg-err");  
    }
  });
});
