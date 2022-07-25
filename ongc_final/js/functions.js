  $(document).ready(function () { 
    // delete comment
    $(document).on("click", ".del-com", function(){
      var com_id = $(this).attr("data-com-id");
      var post_id = $(this).attr("data-post-id");
      var count_here = $(this).parent(".modal-footer").closest(".comment-list-con").siblings(".like-cmt-con").find(".com-count");
      // div_id we'll hide div_id on succ delete
      var div_id = $("#com-del-"+com_id);
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'actions.php?a=del_com',
        data: {'com_id':com_id, 'post_id':post_id},
        success:function(result){
          if(result.status){
            // closing modal on click of this button
            $(function () {
              $("#comment-delete-"+com_id).modal('toggle');
            });
            // hiding the comment
            $(div_id).hide();
            // updating comment counts
            if(result.total_com == 1){
              $(count_here).text(result.total_com + " Comment");
            }else if(result.total_com > 1){
              $(count_here).text(result.total_com + " Comments");
            }else{
              $(count_here).text("0 Comment");
            }
          }else{
            // updating comment counts
            if(result.total_com == 1){
              $(count_here).text(result.total_com + " Comment");
            }else if(result.total_com > 1){
              $(count_here).text(result.total_com + " Comments");
            }else{
              $(count_here).text("0 Comment");
            }
            // error message 
            $(".msg-details").addClass("msg-err");
            if($(".msg-details").hasClass("msg-err")){
              $(".msg-box").text("Unabel to delete comment, please try again.");
              $(".msg-con").addClass("top-zero");
              setTimeout(function(){
                $(".msg-details").fadeOut(3000);
                $(".msg-details").removeClass("msg-err");
                $(".msg-con").removeClass("top-zero");
              }, 5000);
              $(".msg-close").click(function(){
                $(".msg-details").fadeOut("fast").removeClass("msg-err");
              });
            }else{
              $(".msg-con").removeClass("top-zero");
              $(".msg-details").removeClass("msg-suc, msg-err");  
            }
          }
        }
      });
    });

    // add comment
    $(".cmt-sub-btn").on("click", function(){
      var btn = $(this);
      var post_id = $(btn).attr("data-id");
      var user_id = $(btn).attr("data-user");
      var comment = $(btn).siblings(".com-box").val();
      var post_com = $(btn).parent(".comment-box-con").siblings(".comment-list-con");
      var count_here = $(btn).parent().siblings(".like-cmt-con").find(".com-count");
      $(btn).prop("disabled", true).css("color", "#979797");
      $(btn).siblings('.com-box').prop('disabled', true);
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'actions.php?a=add_comm',
        data: {'post_id':post_id, 'curr_user':user_id, 'com':comment},
        success:function(result){
          if(result.status){
            $(post_com).prepend(result.comments);
            $(btn).prop("disabled", true).css("color", "#979797");
            $(btn).siblings('.com-box').prop('disabled', false).val('');
            // updating comment counts
            if(result.total_com == 1){
              $(count_here).text(result.total_com + " Comment");
            }else if(result.total_com > 1){
              $(count_here).text(result.total_com + " Comments");
            }else{
              $(count_here).text("0 Comment");
            }
          }else{
            $(btn).prop("disabled", true).css("color", "#979797");
            $(btn).siblings('.com-box').prop('disabled', false).val('');

            if(result.total_com == 1){
              $(count_here).text(result.total_com + " Comment");
            }else if(result.total_com > 1){
              $(count_here).text(result.total_com + " Comments");
            }else{
              $(count_here).text("0 Comment");
            }
            // error message 
            $(".msg-details").addClass("msg-err");
            if($(".msg-details").hasClass("msg-err")){
              $(".msg-box").text("comment failed, please try again.");
              $(".msg-con").addClass("top-zero");
              setTimeout(function(){
                $(".msg-details").fadeOut(3000);
                $(".msg-details").removeClass("msg-err");
                $(".msg-con").removeClass("top-zero");
              }, 5000);
              $(".msg-close").click(function(){
                $(".msg-details").fadeOut("fast").removeClass("msg-err");
              });
            }else{
              $(".msg-con").removeClass("top-zero");
              $(".msg-details").removeClass("msg-suc, msg-err");  
            }
          }
        }
      })
    });

    // disabling comment post button if there's no text
    $(".com-box").on("keyup",function(){
      var empty = $(this).val().trim().length == 0;
      if(empty == false){
        $(this).siblings(".cmt-sub-btn").prop("disabled", false).css("color", "#a51e24");
      }else{
        $(this).siblings(".cmt-sub-btn").prop("disabled", true).css("color", "#979797");
      }
    });

    // comment box scroll if height > 80
    $(".com-box").on("input", function() {
      if(this.scrollHeight >= 80){
        $(this).height(80).css("overflow-y", "scroll");
      }else{
        $(this).height(35).height(this.scrollHeight);
      }
    });
    $(".com-box").on("blur", function() {
      var inp = $(this).val();
      if(inp == "" || $.trim(inp) == ""){
        $(this).height(35).css("overflow", "hidden");
      }
    });

    // Like a post
    $(".like-btn").on("click",function(){
      var btn = $(this);
      var post_id = $(btn).attr("data-id");
      var user_id = $(btn).attr("data-user");
      var likes_here = $(btn).siblings(".like-count");
      // console.log(likes);
      // console.log(post_id);
      $(btn).attr("disabled", true);
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'actions.php?a=like',
        data: {'post_id':post_id, 'curr_user':user_id},
        success:function(result){
          if(result.status){
            $(btn).attr("disabled", true);
            $(btn).hide();
            $(btn).siblings().show().attr("disabled", false);
            // updating likes counts
            if(result.likes == 1){
              $(likes_here).text(result.likes + " Like");
            }else if(result.likes > 1){
              $(likes_here).text(result.likes + " Likes");
            }else{
              $(likes_here).text("0 Like");
            }
          }else{
            $(btn).attr("disabled", false);
            $(btn).show();
            $(btn).siblings().hide().attr("disabled", true);
            if(result.likes == 1){
              $(likes_here).text(result.likes + " Like");
            }else if(result.likes > 1){
              $(likes_here).text(result.likes + " Likes");
            }else{
              $(likes_here).text("0 Like");
            }
          }
        }
      })
    });

    // Unike a post
    $(".unlike-btn").on("click",function(){
      var btn = $(this);
      var post_id = $(btn).attr("data-id");
      var user_id = $(btn).attr("data-user");
      var likes_here = $(btn).siblings(".like-count");
      // console.log(post_id); 
      $(btn).attr("disabled", true);
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'actions.php?a=unlike',
        data: {'post_id':post_id, 'curr_user':user_id},
        success:function(result){
          if(result.status){
            $(btn).attr("disabled", true);
            $(btn).hide();
            $(btn).siblings().show().attr("disabled", false);
            if(result.likes == 1){
              $(likes_here).text(result.likes + " Like");
            }else if(result.likes > 1){
              $(likes_here).text(result.likes + " Likes");
            }else{
              $(likes_here).text("0 Like");
            }
          }else{
            $(btn).attr("disabled", false);
            $(btn).show();
            $(btn).siblings().hide().attr("disabled", true);
            if(result.likes == 1){
              $(likes_here).text(result.likes + " Like");
            }else if(result.likes > 1){
              $(likes_here).text(result.likes + " Likes");
            }else{
              $(likes_here).text("");
            }
          }
        }
      })
    });

    // disabling save button if there's no text
    $(".edit-cap").on("keyup",function(){
      var type = $(this).attr("data-ptype");
      // var empty = false;
      var empty = $(this).val().length == 0;
      if(empty && type == "text"){
        $(this).siblings().find("#edit-sub-btn").attr("disabled", "disabled");
      }else{
        $(this).siblings().find("#edit-sub-btn").attr("disabled", false);
      }
    });

    // edit caption
    $(".edit-btn").click(function(){
      var id = $(this).attr("data-inpid");
      var pos = parseInt($(id).offset().top) - parseInt("100");
      var p_cap = $(id).find(".p_caption");
      var form = $(id).find(".form-edit-cap");
      var textarea = $(id).find(".edit-cap");
      var text_val = $(textarea).val();
      $(p_cap).hide();
      $(form).addClass("active-cap");
      $("html, body").animate({
        scrollTop: pos
      },1000);
      $(textarea).focus().val(" ").val(text_val);
      $(".edit-bg").show();
      //for disabling save btn 
      var data_type = $(this).attr("data-ptype");
      $(id).find(".edit-cap").attr("data-ptype", data_type);
    });

    $(".cancel-cap").click(function(){
      $(".form-edit-cap").removeClass("active-cap");
      $(".p_caption").show();
      $(".edit-bg").hide();
    });

    // Switching modal message between edit post & delete post
    $("#op-del").click(function(){
      $(".modal-del").css("display","flex");
      $(".modal-edit").css("display","none");
    });

    // toggle option btn on each post
    $(".btn-option").click(function () { 
      $(".option-list").slideUp();
      $(this).siblings(".option-list").toggleClass("active-op");
      if($(".option-list").hasClass("active-op")){
        $(this).siblings(".option-list").slideDown();
      }else{
        $(this).siblings(".option-list").slideUp();
      }
    }); 
    
    // closing modal on clicking anywhere but modal
    $(document).on('click',function(e){
      if(!(($(e.target).closest(".option-list").length > 0 ) || ($(e.target).closest(".btn-option").length > 0) || ($(e.target).closest("#confirm-delete").length > 0))){
      $(".option-list").removeClass("active-op").slideUp();
     }
    });

    // to preview profile-pic on profile.php page
    $("#inp-img").change(function(){
      imgPreview(this);
    });

    // to see preview from add post block(homepage/ profile)
    $("#inp-img-vid").change(function(){
      previewpost(this);
      $("#add-post-close-btn").show();
      $(".display-img-vid-con").slideDown(1000);
    });
    $("#add-post-close-btn").click(function(){
      $(this).toggle();
      $("#preview-img, #video_here").attr("src", "");
      $(".display-img-vid-con").slideUp(1000);
    });
  });

  // preview profile image before uploading
  function imgPreview(img_file){
    var file = img_file.files[0];
    var fileType = file["type"];
    
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png"];
    if ($.inArray(fileType, validImageTypes) < 0) {
      // invalid file type code goes here.
      alert("Please select a jpg, jpeg or png image");
    }else{
      var reader = new FileReader();
      reader.onload = function(e){
        $("#preview-pro-pic").show().attr("src", e.target.result);
      }
      reader.readAsDataURL(img_file.files[0]);
    }
  }

  // to add photo/video from add post block(homepage/ profile)
  function previewpost(input){
    var file = input.files[0];
    var mixedfile = file["type"].split("/");
    var filetype = mixedfile[0];
    if(filetype == "image"){
      var reader = new FileReader();
      reader.onload = function(e){
        $("#preview-img").show().attr("src", e.target.result);
        $("#video_here").attr("src", "");
        $("#preview-vid").hide();
        $(".display-img-vid-con").slideDown();
      }
      reader.readAsDataURL(input.files[0]);
    }else if(filetype == "video"){
      $("#video_here").attr("src", URL.createObjectURL(input.files[0]));
      $("#preview-vid").show()[0].load();
      $("#preview-img").hide().attr("src", "");
      $(".display-img-vid-con").slideDown();
    }else{
      alert("Please select a Image or Video file");
    }
  }
  
  // error/succesfull message alerts coming through php
  $(window).on("load", function(){
    if($(".msg-details").hasClass("msg-suc") || $(".msg-details").hasClass("msg-err")){
      $(".msg-con").addClass("top-zero");
      setTimeout(function(){
        $(".msg-details").fadeOut(3000);
        $(".msg-details").removeClass("msg-err");
        $(".msg-con").removeClass("top-zero");
      }, 5000);
      $(".msg-close").click(function(){
        $(".msg-details").fadeOut("fast").removeClass("msg-err, msg-suc");
      });
    }else{
      $(".msg-con").removeClass("top-zero");
      $(".msg-details").removeClass("msg-suc, msg-err");  
    }
  });      