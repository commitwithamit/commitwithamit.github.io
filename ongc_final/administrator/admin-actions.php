<?php
include("../db-connection.php");

# changing status of a user (active & inactive)
if(isset($_GET["a"]) && $_GET["a"] == "change_status"){
    $output = "";
    if(!empty($_POST["user_id"]) && !empty($_POST["status"])){
        $user_id = $_POST["user_id"];
        $cr_status = $_POST["status"];
        if($cr_status == "active"){
            $status_val = "inactive";
        }
        if($cr_status == "inactive"){
            $status_val = "active";
        }
        $up_query = mysqli_query($db_connect, "update registered_employee set status = '$status_val' where user_id = $user_id");
        $btn_query = mysqli_query($db_connect, "select status from registered_employee where user_id = $user_id");
        $db_status_arr = mysqli_fetch_assoc($btn_query);
        $db_status = $db_status_arr["status"];
        if($up_query == true){
            if($db_status == "active"){
                $output = "true~active~"."<label class='btn-view-post st_act status-btn' data-user-id='$user_id'>
                                            <i class='bi bi-person-check'></i>
                                            <span>active</span>
                                        </label>";
            }
            if($db_status == "inactive"){
                $output = "true~inactive~"."<label class='btn-view-post st_inact status-btn' data-user-id='$user_id'>
                                                <i class='bi bi-person-x'></i>
                                                <span>inactive</span>
                                            </label>";
            }
        }else{
            if($db_status == "active"){
                $output = "false~active~"."<label class='btn-view-post st_act status-btn' data-user-id='$user_id'>
                                            <i class='bi bi-person-check'></i>
                                            <span>active</span>
                                        </label>";
            }
            if($db_status == "inactive"){
                $output = "false~inactive~"."<label class='btn-view-post st_inact status-btn' data-user-id='$user_id'>
                                                <i class='bi bi-person-x'></i>
                                                <span>inactive</span>
                                            </label>";
            }
        }
    }
    echo $output;
}

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
        $query = mysqli_query($db_connect, "select * from ongc_moderators where user_id = $pro_id");
        if(mysqli_num_rows($query)>0){
            $update = mysqli_query($db_connect, "update ongc_moderators set mod_status = 'active' where user_id = $pro_id");    
        }else{
            $insert = mysqli_query($db_connect, "insert into ongc_moderators (user_id, mod_status) values ($pro_id, 'active')");
        }
        if(mysqli_affected_rows($db_connect)){
            header("location: moderators.php?msg=mod_suc");
            die();
        }else{
            header("location: moderators.php?msg=mod_uns");
            die();
        }
    }
}
# remove moderator
if(isset($_GET["a"]) && $_GET["a"] == "del-mod"){
    if(!empty($_GET["pro_id"])){
        $pro_id = $_GET["pro_id"];
        $update = mysqli_query($db_connect, "update ongc_moderators set mod_status = 'inactive' where user_id = $pro_id");
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