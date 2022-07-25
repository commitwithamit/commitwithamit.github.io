<?php
session_start();
if (!isset($_SESSION["mod_id"])) {
    header("location: index.php");
    die();
} else {
    $mod_id = $_SESSION["mod_id"];
    include("../db-connection.php");
    $query = mysqli_query($db_connect, "select * from ongc_moderators where mod_id = '$mod_id' and mod_status = 'active'");
    if(mysqli_num_rows($query)>0){
        $_SESSION["pagename"] = "profile";
        include("../db-connection.php");
        if(isset($_GET["pro_id"])){
            $pro_id = $_GET["pro_id"];
        }else{
            $pro_id ="";
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
        include("../functions.php");
        $myposts = myposts($pro_id);
        include("../messages.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="../bootstrap-icons-1.7.0/bootstrap-icons.css">
    <!-- navbar css -->
    <link rel="stylesheet" href="../css/navbar-style.css">
    <!-- navbar css -->
    <link rel="stylesheet" href="../css/navbar-admin.css">
    <!-- external css -->
    <link rel="stylesheet" href="../css/profile-style.css">
    <link rel="stylesheet" href="../css/homepage-style.css">
    <title>ONGC | <?php if (!empty($pro_name)) {
        echo $pro_name;
    } else {
        echo "Profile";
    } ?></title>
    <style>
    .like-btn,
    .bi-chat-square-text,
    .bi-hand-thumbs-up {
        cursor: default !important;
    }
    @media screen and (min-width: 1110px){
        .collapse-menu {
        width: 410px;
        }
    }
    .flag-icon {
        font-size: 1.5rem;
        cursor: pointer;
        color: #a51e24;
    }
    </style>
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
                        echo "<img src='../$pro_pic'>";
                        }else{
                    ?>
                    <img src="../images/unknown.png">
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
                    <div class="row3">
                        <div class="bio-con">
                            <p>
                                <!-- Space for bio -->
                                <?php if(!empty($bio)) echo $bio; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr-line"></div>
        </div>

        <!-- user's own post recent to older -->
        <?php
        if(!empty($myposts)){
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
                                            echo "<img src='../$pro_pic'>";
                                        } else {
                                            echo "<img src=../images/unknown.png>";
                                        } 
                                    ?>
                                </a>
                            </span>
                            <span class="name-date-con">
                                <div class="emp-name">
                                    <a href="profile.php?pro_id=<?=$mypost['user_id']?>">
                                        <!-- poster's name -->
                                        <?=$pro_name?>
                                    </a>
                                </div>
                                <div class="post-date">
                                    <!-- posting time -->
                                    <?=time_ago($mypost['posting_time'])?>
                                </div>
                            </span>
                            <span id="post-options">
                                <!-- flag post option -->
                                <i class="bi bi-flag flag-icon" data-bs-toggle="modal"
                                    data-bs-target="#flag-<?=$mypost['post_id']?>"></i>
                                <!-- delete post confirmation modal box -->
                                <div class="modal fade" id="flag-<?=$mypost['post_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <button class="btn btn-danger confirm-flag" data-user="<?=$mypost['user_id']?>" data-post="<?=$mypost['post_id']?>" data-time="<?=$mypost["posting_time"]?>">Yes, flag it.</button>
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
                                if ($mypost["post_type"] == "image" || $mypost["post_type"] == "text/image") {
                                    echo "<img src='../$mypost[image]' class='emp-img-vid'>";
                                }
                                if ($mypost["post_type"] == "video" || $mypost["post_type"] == "text/video") {
                                    echo "<video controls style='width:100%'><source src='../$mypost[video]'>Your browser does not support HTML5 video.</video>";
                                } 
                            ?>
                            <div class="caption" id="<?=$mypost['post_id']?>">
                                <!-- caption (if any) -->
                                <p class="p_caption">
                                    <?=$mypost["text"]?>
                                </p>
                                <form
                                    action="actions.php?a=edit_cap&p_id=<?=$mypost['post_id']?>&type=<?=$mypost['post_type']?>"
                                    method="POST" class="form-edit-cap">
                                    <textarea name="edit-cap" class="edit-cap"><?=$mypost["text"]?></textarea>
                                    <div class="d-flex justify-content-end">
                                        <input type="submit" value="Save" id="edit-sub-btn"
                                            class="btn btn-sm btn-outline-success">
                                        <button type="button"
                                            class="cancel-cap ms-2 btn btn-sm btn-outline-danger">Cancel</button>
                                    </div>
                                </form>
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
                                    <button type="button" class="like-btn like_ajax">
                                        <i class="bi bi-hand-thumbs-up like-unfill"></i>
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
                echo "<p class='text-center mt-5'>- Nothing to show here -</p>";
            }
        ?>

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
    </script>
</body>

</html>
<?php
  }else{
    header("location: ../logout.php?a=mod");
  }
}
?>