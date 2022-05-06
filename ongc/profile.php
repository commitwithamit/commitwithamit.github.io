<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("location: index.php");
  die();
} else {
  $user_id = $_SESSION["user_id"];
  $username = $_SESSION["name"];
  $_SESSION["pagename"] = "profile";
  include("db-connection.php");
  if(isset($_GET["pro_id"])){
    $pro_id = $_GET["pro_id"];
  }else{
    $pro_id = $user_id;
  }
  // $sel_query = mysqli_query($db_connect, "select * from user_bio where user_id = $pro_id");
  $sel_query = mysqli_query($db_connect, "SELECT user_bio.*, registered_employee.name FROM user_bio JOIN registered_employee ON user_bio.user_id = registered_employee.user_id and user_bio.user_id = $pro_id");
  $sel_row = mysqli_num_rows($sel_query);
  if ($sel_row>0) {
    $fetch_user = mysqli_fetch_array($sel_query);
    $pro_pic = $fetch_user["pro_pic"];
    $pro_name = $fetch_user["name"];
    $bio = $fetch_user["bio"];
    $desig = $fetch_user["current_designation"];
    $dob = $fetch_user["date_of_birth"];
    $mar_ani = $fetch_user["marriage_anniversary"];
    $int = $fetch_user["intrests"];
  } 
  include("functions.php");
  $myposts = myposts($pro_id);
  include("messages.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="bootstrap-icons-1.7.0/bootstrap-icons.css">
    <!-- navbar css -->
    <link rel="stylesheet" href="css/navbar-style.css">
    <!-- external css -->
    <link rel="stylesheet" href="css/profile-style.css">
    <link rel="stylesheet" href="css/homepage-style.css">
    <title> ONGC |
      <?php
        if (!empty($pro_name)) {
          echo $pro_name;
        } else {
          echo "Profile";
        } ?>
    </title>
</head>
<body>

<!-- navbar -->
<?php
  $pagename= "profile";
  include("navbar.php");
?>

<main class="main-con">

<!-- bio info -->
<div class="head">
  <div class="bio-data">
    <div class="profile-pic-con">
      <?php
        if(!empty($pro_pic)){
          echo "<img src='$pro_pic'>";
        }else{
            ?>
      <img src="images/unknown.png">
      <?php
        }
      ?>
    </div>

    <div class="bio-details-con">
      <div class="row1">
        <div class="user-name-con">
          <h3>
            <?php
            if (!empty($pro_name)) {
              echo $pro_name;
            } else {
              echo "Profile";
            } 
            ?>
          </h3>
        </div> 
        <div class="designation-con">
          <h6>
            <!-- designation -->
            <?php if(!empty($desig)) echo $desig; ?>
          </h6>
        </div>
      </div>

      <?php
          if($user_id == $pro_id){
      ?>
        <div class="row2">
          <div class="bio-con">
            <p>
              <!-- Space for bio -->
              <?php if(!empty($bio)) echo $bio; ?>
            </p>
          </div>
          
          <div class="btn-con">
            <div class="btn-2">
              <button class="btn-album">
                <i class="bi bi-images"></i><span>Album</span>
              </button>
            </div>

            <!-- Button trigger modal carrying edit profile form-->
            <div class="btn-1">
              <button type="button" class="btn-edit-pro" data-bs-toggle="modal" data-bs-target="#editprofile">
                <!-- do not put space between <i> & <span> if you do then you'll se space in btn on browser -->
                <i class="bi bi-pencil"></i><span>Edit Profile</span>
                <!-- #0d6efd h- #0b5ed7 -->
              </button>
            </div>
          </div>
      </div>
        <?php
          }else{
        ?>
        <div class="row3">
          <div class="bio-con">
            <p>
              <!-- Space for bio -->
              <?php if(!empty($bio)) echo $bio; ?>
            </p>
          </div>
        </div>
        <?php
          }
        ?>
    </div>    
  </div>
  <div class="hr-line"></div>
</div>

  <!-- add new post block -->
  <?php
  if($user_id == $pro_id){
    include("add-post-block.html");
  }
  ?>

  <!-- user's own post recent to older -->
  <?php
    foreach ($myposts as $mypost) {
      # getting the number of likes & comments on a post
      $like_count = getlikes($mypost["post_id"]);
      $comments = getcomments($mypost["post_id"]);      
  ?>
    <div class="post-block">
      <!-- single post container -->
      <div class="post-container">
        <!-- employee's profile image, name -->
        <div class="emp-pro-img-con">
          <span class="pro-img-con">
            <a href="profile.php?pro_id=<?=$mypost['user_id']?>">
            <!-- poster's pro-pic -->
              <?php
                if (!empty($pro_pic)) {
                    echo "<img src='$pro_pic'>";
                } else {
                    echo "<img src=images/unknown.png>";
                } 
              ?>
            </a>
          </span>
          <span class="name-date-con">
            <div class="emp-name">
              <a href="profile.php?pro_id=<?=$mypost['user_id']?>">
                <!-- poster's name -->
                <?=$username?>
              </a>
            </div>
            <div class="post-date">
              <!-- posting time -->
              <?=time_ago($mypost['posting_time'])?>
            </div>
          </span>
          <span id="post-options">
            <!-- options -->
            <?php
            # options will be shown only when it's user's own post.
            # if user A is logged in then he will see option icon only on his posts 
              if($user_id == $mypost["user_id"]){
                echo "<i class='bi bi-three-dots-vertical btn-option'></i>
                      <ul class='option-list'>
                        <li id='op-edit-cap' class='edit-btn' data-inpid='#$mypost[post_id]' data-ptype='$mypost[post_type]'>Edit <i class='bi bi-pencil'></i></li>
                        <li id='op-del' data-bs-toggle='modal' data-bs-target='#confirm-delete-$mypost[post_id]'>Delete <i class='bi bi-trash'></i></li>
                      </ul>";
            ?>          
                <!-- delete confirmation modal box -->
                <div class="modal fade" id="confirm-delete-<?=$mypost['post_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                          <a href="actions.php?a=del&p_id=<?=$mypost['post_id']?>" class="btn btn-danger">Yes, delete it.</a>
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
            if ($mypost["post_type"] == "image" || $mypost["post_type"] == "text/image") {
              echo "<img src='$mypost[image]' class='emp-img-vid'>";
            }
            if ($mypost["post_type"] == "video" || $mypost["post_type"] == "text/video") {
              echo "<video controls style='width:100%'>
                  <source src='$mypost[video]'>
                  Your browser does not support HTML5 video.
                </video>";
          } ?>
          <div class="caption" id="<?=$mypost['post_id']?>">
            <!-- caption (if any) --> 
            <p class="p_caption">
              <?=$mypost["text"]?>
            </p>
            <form action="actions.php?a=edit_cap&p_id=<?=$mypost['post_id']?>&type=<?=$mypost['post_type']?>" method="POST" class="form-edit-cap">
              <textarea name="edit-cap" class="edit-cap"><?=$mypost["text"]?></textarea>
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
                if(chk_like_status($mypost['post_id'], $user_id)){
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
              <button type="button" class="like-btn like_ajax" data-id="<?=$mypost['post_id']?>" data-user="<?=$user_id?>" style="<?=$hide?>">
                <i class="bi bi-hand-thumbs-up like-unfill"></i>
              </button>
              <button type="button" class="unlike-btn like_ajax" data-id="<?=$mypost['post_id']?>" data-user="<?=$user_id?>" style="<?=$display?>">
                <i class="bi bi-hand-thumbs-up-fill like-fill"></i>
              </button>
            </span>

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
                          <button data-com-id="<?=$com["comment_id"]?>" data-post-id="<?=$mypost["post_id"]?>" class="btn btn-danger del-com">Yes, delete it.</button>
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
              <button type="button" class="cmt-sub-btn" data-id="<?=$mypost['post_id']?>" data-user="<?=$user_id?>" disabled>
                <i class="bi bi-send"></i>
              </button>
          </div>

        </div>
      </div>
    </div>
  <?php
    }
  ?>
  <!-- edit profile form -->
  <!-- Modal -->
  <div class="modal fade" id="editprofile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Your Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="edit-profile-handler.php" method="POST" enctype="multipart/form-data">
            <!-- edit profile picture -->
            <div class="form-group-1">
              <div class="modal-pro-pic-con">
                <?php
                  if(!empty($pro_pic)){
                    echo "<img src='$pro_pic' alt='profile picture' id='preview-pro-pic'>";
                  }else{
                ?>
                    <img src="images/unknown.png" alt="profile picture" id="preview-pro-pic">
                <?php
                  }
                ?>
              </div>
              <div class="btn-con">
                <label for="inp-img" class="btn btn-success btn-sm">
                  <span> Change </span>
                  <input type="file" value="<?php if(!empty($pro_pic)) echo $pro_pic ?>" accept="image/*" name="pro-img" id="inp-img">
                </label>

                <a href="actions.php?act=del_img" type="button" class="btn btn-danger btn-sm" id="remove-img">Remove</a>
                <!-- <button type="button" class="btn-up-img btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#changeprofilepicture">
                  Edit Profile Picture
                </button> -->
              </div>
            </div>
          
            <div class="form-group">
              <label for="inp-bio">Bio</label>
              <textarea name="bio" id="inp-bio" cols="30" rows="3"><?php if(!empty($bio)) echo htmlspecialchars($bio); ?></textarea>
            </div>

            <div class="form-group">
              <label for="inp-desig">Current Designation</label>
              <input type="text" name="desig" id="inp-desig" value="<?php if(!empty($desig)) echo $desig; ?>">
            </div>

            <!-- onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" -->
            <div class="form-group">
              <label for="inp-dob">Date Of Birth</label>
              <input type="date" name="dob" id="inp-dob" value="<?php if(!empty($dob)) echo $dob; ?>" <?php if(!empty($dob)) echo "disabled"; ?> >
            </div>

            <div class="form-group">
              <label for="inp-mar-ani">Marriage Anniversary</label>
              <input type="date" name="mar_ani" id="inp-mar-ani" value="<?php if(!empty($mar_ani)) echo $mar_ani; ?>">
            </div>

            <div class="form-group">
              <label for="inp-int">Intrests</label>
              <input type="text" name="intrests" id="inp-int" value="<?php if(!empty($int)) echo $int; ?>">
            </div>

            <input type="submit" value="Save changes" id="modal-sub-btn" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>

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
    <script src="js/profile.js"></script>
    <script src="js/functions.js"></script>
</body>
</html>
<?php
}
?>