<?php
include("../db-connection.php");
# flagging a post by adding the details of the post in flagged_posts db table and deleteing this post from post main table
if(isset($_GET["a"]) && $_GET["a"] == "flag-post"){
    if(!empty($_POST["user_id"]) && !empty($_POST["post_id"]) && !empty($_POST["post_time"])){
        $user_id = $_POST["user_id"];        
        $post_id = $_POST["post_id"];        
        $post_time = $_POST["post_time"];

        $ins_query = mysqli_query($db_connect, "insert into ongc_flagged_posts (`post_id`, `user_id`, `posting_time`) values ('$post_id', '$user_id', '$post_time')");
        #deleting from user_post_main so no one can see as it is flagged
        $del_query = mysqli_query($db_connect, "delete from `user_posts_main` where post_id = '$post_id' and user_id = $user_id and posting_time = '$post_time'");

        // include("flag-email.php");

        if($ins_query == true && $del_query == true){
            $result = true;
        }else{
            $result = false;
        }
        echo $result;
    }
}

# add moderator
if(isset($_GET["a"]) && $_GET["a"] == "add-mod"){
    if(!empty($_GET["pro_id"])){
        $pro_id = $_GET["pro_id"];
        $query = mysqli_query($db_connect, "insert into ongc_moderators (user_id) values ($pro_id)");
        if(mysqli_affected_rows($db_connect)){
            header("location: moderators.php?msg=mod_suc");
            die();
        }else{
            header("location: moderators.php?msg=mod_uns");
            die();
        }
    }
}
# delete moderator
if(isset($_GET["a"]) && $_GET["a"] == "del-mod"){
    if(!empty($_GET["pro_id"])){
        $pro_id = $_GET["pro_id"];
        $query = mysqli_query($db_connect, "delete from ongc_moderators where user_id = $pro_id");
        if(mysqli_affected_rows($db_connect)){
            header("location: moderators.php?msg=mod_del");
            die();
        }else{
            header("location: moderators.php?msg=mod_del_un");
            die();
        }
    }
}
?>