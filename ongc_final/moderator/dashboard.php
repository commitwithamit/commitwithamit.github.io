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
    $_SESSION["pagename"] = "homepage";
    $post = "";
    include("../messages.php");
    include("../functions.php");
    $posts = getpost();
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
  }
  .like-btn,
  .bi-chat-square-text{
    pointer-events: none;
  }
  @media screen and (min-width: 1110px){
    .collapse-menu {
      width: 410px;
    }
  }
  </style>
  <title>ONGC | Moderator</title>
</head>
<body>
  <?php
  # navbar
  include("navbar.php");
  if(!empty($posts)){
    # showing post dynamically from DB
    foreach($posts as $post){
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
                  if(!empty($post['pro_pic'])){
                    echo "<img src=../$post[pro_pic]>";
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
                  <?=$post['name']?>
                </a>
              </div>
              <div class="post-date">
                <!-- posting time -->
                <?=time_ago($post["posting_time"])?>
              </div>
            </span>
            <span id="post-options">
              <!-- flag post option -->
              <i class="bi bi-flag flag-icon" data-bs-toggle="modal" data-bs-target="#flag-<?=$post['post_id']?>"></i>
              <!-- delete post confirmation modal box -->
              <div class="modal fade" id="flag-<?=$post['post_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Delete Post</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to flag this post?
                    </div>
                    <div class="modal-footer">
                      <!-- delete using ajax so user can remain on same page and same place coz page won't load -->
                      <button class="btn btn-danger confirm-flag" data-user="<?=$post['user_id']?>" data-post="<?=$post['post_id']?>" data-time="<?=$post["posting_time"]?>" data-mod-id="<?=$mod_id?>">Yes, flag it.</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                  </div>
                </div>
              </div>
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
        var mod_id = $(this).attr("data-mod-id");
        // console.log(post_id, post_time, user_id);
        $.ajax({
          type: "post",
          url: "admin-actions.php?a=flag-post",
          data: {
            "user_id": user_id,
            "post_id": post_id,
            "post_time": post_time,
            "mod_id": mod_id
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
    </script>
</body>

</html>
<?php
  }else{
    header("location: ../logout.php?a=mod");
  }
}
?>