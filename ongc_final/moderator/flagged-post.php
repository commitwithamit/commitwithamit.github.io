<?php
session_start();
if(!isset($_SESSION["mod_id"])){
  header("location: index.php?login_first");
  die();
}else{
  $mod_id = $_SESSION["mod_id"];
  include("../db-connection.php");
  $query = mysqli_query($db_connect, "select * from ongc_moderators where mod_id = '$mod_id' and mod_status = 'active'");
  if(mysqli_num_rows($query)>0){
    $_SESSION["pagename"] = "flagged_post";
    $post = "";
    include("../messages.php");
    include("../functions.php");
    include("../db-connection.php");
    
    $sel_flag_post = mod_flag_post($mod_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap css-->
  <link rel="stylesheet" href="../bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css">
  <!-- navbar css -->
  <link rel="stylesheet" href="../css/navbar-style.css">
  <!-- navbar css -->
  <link rel="stylesheet" href="../css/navbar-admin.css">
  <!-- navbar css -->
  <link rel="stylesheet" href="../css/homepage-style.css">
  <!-- bootstrap icons -->
  <link rel="stylesheet" href="../bootstrap-icons-1.7.0/bootstrap-icons.css">
  <style>
  .flag-icon {
    font-size: 1.5rem;
    cursor: pointer;
    color: #a51e24;
    pointer-events: none;
  }
  .like-btn, .bi-chat-square-text {
    pointer-events: none;
  }
  @media screen and (min-width: 1110px){
    .collapse-menu {
      width: 410px;
    }
  }
  </style>
  <title>ONGC | Flagged Posts</title>
</head>

<body>
  <?php
  # navbar
  include("navbar.php");
  if(!empty($sel_flag_post)){
    # showing post dynamically from DB
    foreach($sel_flag_post as $flag_post){
      $post_id = $flag_post["post_id"];
      $user_id = $flag_post["user_id"];
      $post_time = $flag_post["posting_time"];
      $backup_post = get_flag_post($post_id,$user_id,$post_time);
      foreach($backup_post as $post){
        $user = getuser($post["user_id"]);
        # getting the number of likes & comments on a post
        $like_count = getlikes($post["post_id"]);
        $comments = getcomments($post["post_id"]);      
  ?>
        <div class="post-block" id="<?=$post["post_id"]?>">
          <!-- single post container -->
          <div class="post-container">
            <!-- employee's profile image, name -->
            <div class="emp-pro-img-con">
              <span class="pro-img-con">
                  <a href="profile.php?pro_id=<?=$post['user_id']?>">
                      <!-- poster's pro-pic -->
                      <?php
                        if(!empty($user['pro_pic'])){
                          echo "<img src=../$user[pro_pic]>";
                        }else{
                          echo "<img src=../images/unknown.png>";
                        }
                      ?>
                  </a>
              </span>
              <span class="name-date-con">
                  <div class="emp-name">
                      <a href="profile.php?pro_id=<?=$post['user_id']?>">
                          <!-- poster's name -->
                          <?=$user['name']?>
                      </a>
                  </div>
                  <div class="post-date">
                      <!-- posting time -->
                      <?=time_ago($post["posting_time"])?>
                  </div>
              </span>
              <span id="post-options">
                  <!-- flag post option -->
                  <i class="bi bi-flag-fill flag-icon" data-bs-toggle="modal" data-bs-target="#flag-<?=$post['post_id']?>"></i>
              </span>
            </div>
            <hr class="post-br-line">
            <!-- uploaded post of user -->
            <div class="post-main">
              <!-- actual post -->
              <?php
                if ($post["post_type"] == "image" || $post["post_type"] == "text/image") {
                  echo "<img src='../$post[image]' class='emp-img-vid'>";
                }
                if ($post["post_type"] == "video" || $post["post_type"] == "text/video") {
                  echo "<video controls style='width:100%'><source src='../$post[video]'>Your browser does not support HTML5 video.</video>";
                }
              ?>
              <div class="caption" id="<?=$post['post_id']?>">
                  <!-- caption (if any) -->
                  <p class="p_caption">
                      <?=$post["text"]?>
                  </p>
              </div>
              <div class="like-cmt-con">
                  <span class="btn-like">
                      <!-- When liked, remove class bi-hand-thumbs-up and add bi-hand-thumbs-up-fill and vice versa-->
                      <?php 
                        # showing the number of likes on a post
                        if(count($like_count) == 1){
                          echo "<small class='like-count'>".count($like_count)." Like</small>";
                        }elseif(count($like_count) > 1){
                          echo "<small class='like-count'>".count($like_count)." Likes</small>";
                        }else{
                          echo "<small class='like-count'>0 Like</small>";
                        }
                      ?>
                      <button type="button" class="like-btn like_ajax" disabled>
                          <i class="bi bi-hand-thumbs-up like-unfill"></i>
                      </button>
                  </span>
                  <!-- comment button -->
                  <span class="btn-comment">
                      <?php
                      # showing the number of comments on a post
                        if(count($comments) == 1){
                          echo "<small class='com-count'>".count($comments)." Comment</small>";
                        }elseif(count($comments) > 1){
                          echo "<small class='com-count'>".count($comments)." Comments</small>";
                        }else{
                          echo "<small class='com-count'>0 Comment</small>";
                        }
                      ?>
                      <i class="bi bi-chat-square-text"></i>
                  </span>
              </div>

              <!-- list of comments here -->
              <div class="comment-list-con">

                <?php
                  foreach($comments as $com){
                    $user = getuser($com["user_id"]);
                ?>
                    <!-- com-del-$com['comment_id'] class is used to id the div to delete(hide) when user deletes it using ajax -->
                    <div class="com-list" id="com-del-<?=$com['comment_id']?>">
                        <div class="com-pro-pic">
                            <!-- commentor's pro pic -->
                            <a href="profile.php?pro_id=<?=$com['user_id']?>">
                                <?php
                                  if(!empty($user['pro_pic'])){
                                    echo "<img src='../$user[pro_pic]'>";
                                  }else{
                                    echo "<img src='../images/unknown.png'>";
                                  }
                                ?>
                            </a>
                        </div>
                        <div class="com-name">
                            <div class="com-username">
                                <!-- commentor's name -->
                                <span>
                                    <a href="profile.php?pro_id=<?=$com['user_id']?>">
                                        <span><?=$user['name']?></span>
                                    </a>
                                    <!-- comment -->
                                    <span> <?=$com['comment']?></span>
                                    <p class="com-time"><small><?=comment_time($com["time"])?></small></p>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
    <?php
    }
  }
}else{
  echo "<p class='text-center' style='margin-top:5rem;'>- Nothing to show here -</p>";
}
  ?>
    <script src="../bootstrap-5.0.0-beta2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/nav.js"></script>
    <script>
    $(".confirm-flag").click(function() {
      var modal = $(this).closest(".modal");
      var post_id = $(this).attr("data-post");
      var post_time = $(this).attr("data-time");
      var user_id = $(this).attr("data-user");
      // console.log(post_id, post_time, user_id);
      $.ajax({
          type: "post",
          url: "admin-actions.php?a=flag-post",
          data: {
            "user_id": user_id,
            "post_id": post_id,
            "post_time": post_time
          },
          success: function(result) {
            // closing modal on click of this button
            $(function() {
              $(modal).modal('toggle');
            });
            $("#" + post_id).hide();
          }
      });
    });

    $(".navbar-toggler").click(function() {
      $(this).toggleClass("active");
      $(this, ".menu-icon").toggleClass("rotate-center");
      $(".collapse-menu").slideToggle();
    });
    // decreasing the height of navbar on scroll
    $(window).scroll(function() {
      var pos = $(window).scrollTop();
      if (pos >= 1) {
        $(".navbar").addClass("nav-scroll");
      } else {
        $(".navbar").removeClass("nav-scroll");
      }
    });
    </script>
</body>

</html>
<?php
  }else{
    header("location: ../logout.php?a=mod");
  }
}
?>