<?php
session_start();
if(!isset($_SESSION["user_id"])){
  header("location: index.php");
  die();
}else{
  $user_id = $_SESSION["user_id"];
  $username = $_SESSION["name"];
  $_SESSION["pagename"] = "homepage";
  $post = "";
  include("messages.php");
  include("functions.php");
  $posts = getpost();
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css">
    <!-- navbar external css -->
    <link rel="stylesheet" href="css/navbar-style.css">
    <!-- external css -->
    <link rel="stylesheet" href="css/homepage-style.css">
    <!-- bootstrap icon link -->
    <link rel="stylesheet" href="bootstrap-icons-1.7.0/bootstrap-icons.css">
    
    <title>ONGC | Homepage</title>
</head>
<body>
<?php
  $pagename= "homepage";
  include("navbar.php");
?>

<!-- main body for adding post and showing other people's post -->
<main class="main-con">
  
  <!-- add post (text, img, video) block -->
  <?php
    include("add-post-block.html");

    // showing post dynamically from DB
    foreach($posts as $post){
      # getting the number of likes & comments on a post
      $like_count = getlikes($post["post_id"]);
      $comments = getcomments($post["post_id"]);      
    ?>
    <div class="post-block">
      <!-- single post container -->
      <div class="post-container">
        <!-- employee's profile image, name -->
        <div class="emp-pro-img-con">
          <span class="pro-img-con">
            <a href="profile.php?pro_id=<?=$post['user_id']?>">
              <!-- poster's pro-pic -->
              <?php
                if(!empty($post['pro_pic'])){
                  echo "<img src=$post[pro_pic]>";
                }else{
                  echo "<img src=images/unknown.png>";
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
            <!-- options -->
            <?php
            # options will be shown only when it's user's own post.
            # if user A is logged in then he will see option icon only on his posts 
          if($user_id == $post["user_id"]){
            echo "<i class='bi bi-three-dots-vertical btn-option'></i>
                  <ul class='option-list'>
                    <li id='op-edit-cap' class='edit-btn' data-inpid='#$post[post_id]' data-ptype='$post[post_type]'>Edit <i class='bi bi-pencil'></i></li>
                    <li data-bs-toggle='modal' data-bs-target='#confirm-delete-$post[post_id]'>Delete <i class='bi bi-trash'></i></li>
                  </ul>";
          ?>          
            <!-- delete post confirmation modal box -->
            <div class="modal fade" id="confirm-delete-<?=$post['post_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Delete Post</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete this post?
                    </div>
                    <div class="modal-footer">
                      <!-- delete using ajax so user can remain on same page and same place coz page won't load -->
                      <a href="actions.php?a=del&p_id=<?=$post['post_id']?>" class="btn btn-danger">Yes, delete it.</a>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                  </div>
                </div>
            </div>
          <?php    
            }
          ?>
          </span>
        </div>
        <hr class="post-br-line">
        <!-- uploaded post of user -->
        <div class="post-main">
          <!-- actual post -->
          <?php
            if ($post["post_type"] == "image" || $post["post_type"] == "text/image") {
              echo "<img src='$post[image]' class='emp-img-vid'>";
            }
            if ($post["post_type"] == "video" || $post["post_type"] == "text/video") {
              echo "<video controls style='width:100%'>
                      <source src='$post[video]'>
                      Your browser does not support HTML5 video.
                    </video>";
            }
          ?>
          <div class="caption" id="<?=$post['post_id']?>">
            <!-- caption (if any) --> 
            <p class="p_caption">
              <?=$post["text"]?>
            </p>
            <!-- edit caption form -->
            <form action="actions.php?a=edit_cap&p_id=<?=$post['post_id']?>&type=<?=$post['post_type']?>" method="POST" class="form-edit-cap">
              <textarea name="edit-cap" class="edit-cap"><?=$post["text"]?></textarea>
              <div class="d-flex justify-content-end">
                <input type="submit" value="Save" id="edit-sub-btn" class="btn btn-sm btn-outline-success">
                <button type="button" class="cancel-cap ms-2 btn btn-sm btn-outline-danger">Cancel</button>
              </div>
            </form>
          </div>
          <div class="like-cmt-con">
            <span class="btn-like">
              <!-- When liked, remove class bi-hand-thumbs-up and add bi-hand-thumbs-up-fill and vice versa-->
              <?php 
                if(chk_like_status($post['post_id'], $user_id)){
                  $display = "";
                  $hide = "display:none";
                }else{                  
                  $display = "display:none";
                  $hide = "";
                }

                # showing the number of likes on a post
                if(count($like_count) == 1){
                  echo "<small class='like-count'>".count($like_count)." Like</small>";
                }elseif(count($like_count) > 1){
                  echo "<small class='like-count'>".count($like_count)." Likes</small>";
                }else{
                  echo "<small class='like-count'>0 Like</small>";
                }
              ?>
              <button type="button" class="like-btn like_ajax" data-id="<?=$post['post_id']?>" data-user="<?=$user_id?>" style="<?=$hide?>">
                <i class="bi bi-hand-thumbs-up like-unfill"></i>
              </button>
              <button type="button" class="unlike-btn like_ajax" data-id="<?=$post['post_id']?>" data-user="<?=$user_id?>" style="<?=$display?>">
                <i class="bi bi-hand-thumbs-up-fill like-fill"></i>
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
                        echo "<img src='$user[pro_pic]'>";
                      }else{
                        echo "<img src='images/unknown.png'>";
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
                      <span>
                        <?php
                          if($user_id == $com['user_id']){
                            echo "<i data-bs-toggle='modal' data-bs-target='#comment-delete-$com[comment_id]' class='bi bi-trash'></i>";
                          }
                        ?>
                      </span>
                    </div>
                  </div>     
                </div>   
                
                <!-- delete comment confirmation modal box -->
                <div class="modal fade" id="comment-delete-<?=$com['comment_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Delete Post</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Are you sur e you want to delete this comment?
                        </div>
                        <div class="modal-footer">
                          <!-- delete using ajax so user can remain on same page and same place coz page won't load -->
                          <button data-com-id="<?=$com["comment_id"]?>" data-post-id="<?=$post["post_id"]?>" class="btn btn-danger del-com">Yes, delete it.</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        </div>
                      </div>
                    </div>
                </div>
              <?php
                }
              ?>
            
          </div>

          <!-- enter comment here -->
          <div class="comment-box-con">
              <textarea name="comment-box" id="com-box" class="com-box" placeholder="Add a comment..."></textarea>
              <button type="button" class="cmt-sub-btn" data-id="<?=$post['post_id']?>" data-user="<?=$user_id?>" disabled>
                <i class="bi bi-send"></i>
              </button>
          </div>
        </div>
      </div>
    </div>
  <?php
    }
  ?>
  
<!-- [post_id] => 0P5H6Q
[user_id] => 551451
[posting_time] => 2022-02-02 00:26:48
[post_type] => text/image
[text] => Maker of things that go clank!
[image] => 
[video] => 
[name] => Amit Kumar Jayashankara Iyar
[pro_pic] => user-images/0O0U0K6O2A.jpeg -->

  <!-- backend validations disappering dialog box/alert -->
  <div class="msg-con">
    <div class="msg-details <?php if(!empty($msg_class)) echo $msg_class; ?>">
      <span class="msg-box">
        <!-- message here -->
        <?php
          if(!empty($message))echo $message;
        ?>
      </span>
      <span class="msg-close">
        <i class="bi bi-x-lg"></i>
      </span>
    </div>
  </div>

</main>
<div class="edit-bg"></div>
  
  <script src="bootstrap-5.0.0-beta2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.js"></script>
  <script src="js/nav.js"></script>
  <script src="js/functions.js"></script>
</body>
</html>
<?php
}
?>