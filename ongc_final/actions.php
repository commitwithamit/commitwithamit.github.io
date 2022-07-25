<?php
session_start();
if(isset($_SESSION["pagename"])){
    $prev_page = $_SESSION["pagename"];
}
if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
}
include("db-connection.php");
include("functions.php");

# delete comment
if(isset($_GET["a"]) && $_GET["a"]=="del_com"){
    if(!empty($_POST["com_id"])){
        $com_id = $_POST["com_id"];
    }
    if(!empty($_POST["post_id"])){
        $post_id = $_POST["post_id"];
    }
    $del_query = "delete from user_comments where comment_id = $com_id";
    $run = mysqli_query($db_connect, $del_query);
    $result["status"] = $run;
    $result["total_com"] = count(getcomments($post_id));
    echo json_encode($result);
}    
# add comment
if(isset($_GET["a"]) && $_GET["a"]=="add_comm"){
    if(!empty($_POST["post_id"])){
        $post_id = $_POST["post_id"];
    }
    if(!empty($_POST["curr_user"])){
        $curr_user_id = $_POST["curr_user"];
    }
    if(!empty($_POST["com"])){
        $comment = mysqli_real_escape_string($db_connect, $_POST["com"]);
    }
    if(addcomment($post_id, $curr_user_id, $comment)){
        $user = getuser($curr_user_id);
        $com_details = getcommentid($post_id, $curr_user_id, $comment);
        if(!empty($user['pro_pic'])){
            $pro_pic = $user['pro_pic'];
        }else{
            $pro_pic = "images/unknown.png";
        }
        $result["status"] = true;
        $result["total_com"] = count(getcomments($post_id));
        $result["comments"] = "<div class='com-list' id='com-del-$com_details[comment_id]'>
        <div class='com-pro-pic'>
            <!-- commentor's pro pic -->
            <a href='profile.php?pro_id=$curr_user_id'>
                <img src='$pro_pic' alt='$user[name]'>
            </a>
            </div>
            <div class='com-name'>
                <div class='com-username'>
                    <!-- commentor's name -->
                    <span>
                    <a href='profile.php?pro_id=$curr_user_id'>
                        <span>$user[name]</span>
                    </a>  
                    <!-- comment -->
                    <span> $com_details[comment]</span>
                    <p class='com-time'><small>Just now</small></p>
                    </span>
                    <span><i data-bs-toggle='modal' data-bs-target='#comment-delete-$com_details[comment_id]' class='bi bi-trash'></i></span>
                </div>
            </div>     
        </div>
    <!-- delete comment confirmation modal box -->
                <div class='modal fade' id='comment-delete-$com_details[comment_id]' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered'>
                      <div class='modal-content'>
                        <div class='modal-header'>
                          <h5 class='modal-title' id='exampleModalLabel'>Delete Post</h5>
                          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                          Are you sure you want to delete this comment?
                        </div>
                        <div class='modal-footer'>
                          <!-- delete using ajax so user can remain on same page and same place coz page won't load -->
                          <button data-com-id='$com_details[comment_id]' data-post-id='$post_id' class='btn btn-danger del-com'>Yes, delete it.</button>
                          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>No</button>
                        </div>
                      </div>
                    </div>
                </div>"; 
    }else{
        $result["status"] = false;
        $result["total_com"] = count(getcomments($post_id));
    }
    echo json_encode($result);
}

# like post
if(isset($_GET["a"]) && $_GET["a"]=="like"){
    if(!empty($_POST["post_id"])){
        $post_id = $_POST["post_id"];
    }
    if(!empty($_POST["curr_user"])){
        $curr_user_id = $_POST["curr_user"];
    }
    // if(like_post($post_id)){
    if(like_post($post_id, $curr_user_id)){
        $result["status"] = true;
        $result["likes"]= count(getlikes($post_id));
    }else{
        $result["status"] = false;
        $result["likes"]= count(getlikes($post_id));
    }
    echo json_encode($result); 
}

# unlike post
if(isset($_GET["a"]) && $_GET["a"]=="unlike"){
    if(!empty($_POST["post_id"])){
        $post_id = $_POST["post_id"];
    }
    if(!empty($_POST["curr_user"])){
        $curr_user_id = $_POST["curr_user"];
    }
    // if(like_post($post_id)){
    if(unlike_post($post_id, $curr_user_id)){
        $result["status"] = true;
        $result["likes"]= count(getlikes($post_id));
    }else{
        $result["status"] = false;
        $result["likes"]= count(getlikes($post_id));
    }
    echo json_encode($result); 
}


# editing caption of user's post
if(isset($_GET["a"]) && $_GET["a"]=="edit_cap" && isset($_GET["p_id"]) && isset($_GET["type"])){
    if(isset($_POST["edit-cap"]) && strlen(trim($_POST["edit-cap"])) !== 0){
        $text = str_replace("'","''",$_POST["edit-cap"]);
    }
    $p_id = $_GET["p_id"];
    $type = $_GET["type"];
    // post type value 
    if($type == "text" && empty($text)){
        header("location: $prev_page.php?msg=txt_emp");
        die();
    }
    if($type == "text" && !empty($text)){
        $new_type = "text";
    }elseif($type == "image"){
        $new_type = "text/image";
    }elseif($type == "video"){
        $new_type = "text/video";
    }elseif($type == "text/image" && !empty($text)){
        $new_type = "text/image";
    }elseif($type == "text/video" && !empty($text)){
        $new_type = "text/video";
    }elseif($type == "text/image" && empty($text)){
        $new_type = "image";
    }elseif($type == "text/video" && empty($text)){
        $new_type = "video";
    }   
    
    $chk_post = mysqli_query($db_connect, "select * from user_posts_main where post_id = '$p_id'");
    $ret_rows = mysqli_num_rows($chk_post);
    if($ret_rows>0){
        mysqli_query($db_connect, "update user_posts_main set post_type = '$new_type', text = '$text' where post_id = '$p_id'");
        $sel_backup = mysqli_query($db_connect, "select image, video from user_posts_backup where post_id = '$p_id' and user_id = $user_id");
        if(mysqli_num_rows($sel_backup)>0){
            $fetch_data = mysqli_fetch_array($sel_backup);
            $db_img = $fetch_data["image"];
            $db_vid = $fetch_data["video"];
            $b_id = backup_id();
            $time = date("Y-m-d H:i:s");
            mysqli_query($db_connect, "insert into user_posts_backup values ('$b_id', '$p_id', '$user_id', '$time', '$new_type', '$text', '$db_img', '$db_vid', '')");
        }
        // `backup_id`, `post_id`, `user_id`, `posting_time`, `post_type`, `text`, `image`, `video`, `external_url`
        if(mysqli_affected_rows($db_connect)>0){
            header("location: $prev_page.php?msg=cap_up");
            die();
        }else{
            header("location: $prev_page.php?msg=cap_up_fail");
            die();
        }
    }
}

# deleting user's own post 
if(isset($_GET["a"]) && $_GET["a"] == "del" && !empty($_GET["p_id"])){
    $post_id = $_GET["p_id"];
    $find_post = mysqli_query($db_connect, "select * from user_posts_main where post_id = '$post_id'");
    $find_row = mysqli_num_rows($find_post);
    if($find_row > 0){
        $del_query = mysqli_query($db_connect, "delete from user_posts_main where post_id = '$post_id'");
        # pending
        # unlink post when Q4 is confirmed
        $aff_row = mysqli_affected_rows($db_connect);
        if($aff_row>0){
            header("location: $prev_page.php?msg=p_del");
            die();
        }else{
            header("location: $prev_page.php?msg=un_p_del");
            die();
        }
    }else{
        header("location: $prev_page.php?msg=sww");
        die();
    }
}

# deleting profile picture of a user (profile.php/ajax)
if(isset($_GET["act"]) && $_GET["act"] == "del_img"){
    $sel_query = mysqli_query($db_connect, "select * from user_bio where user_id = '$user_id'");
    $num_rows = mysqli_num_rows($sel_query);
    if($num_rows>0){
        $fetch_img = mysqli_fetch_array($sel_query);
        $img_path = $fetch_img["pro_pic"];
        $remove_img = mysqli_query($db_connect, "update user_bio set pro_pic = '' where user_id = '$user_id'");
        $remove_img_rows = mysqli_affected_rows($db_connect);
        if($remove_img_rows>0){
            if(file_exists($img_path)){
               unlink($img_path);
               header("location: profile.php?msg=img_del");
               die();
            }
        }else{
            header("location: profile.php?msg=img_n_del");
            die();
        }
    }
}


?>