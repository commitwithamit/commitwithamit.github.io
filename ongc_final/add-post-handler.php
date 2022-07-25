<?php 
# main = post_id, user_id, posting_time, post_type,	text, image, video,	external_url, views, status
# backup = backup_id, post_id, user_id, posting_time, post_type, text, image, video, external_url
# id's to be generated 1) 6 digit alphanum post_id 2) 6 digit backup_id
session_start();
include("db-connection.php");
include("functions.php");
date_default_timezone_set("Asia/Kolkata");
if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
    $pagename = $_SESSION["pagename"];
}
$post_type = "";
$file_type = "";
# checking caption for not empty and 0 black spaces (whitespace)
if(!empty($_POST["caption"]) && strlen(trim($_POST["caption"])) !== 0){
    $caption = str_replace("'", "''", $_POST["caption"]);
}
if(!empty($_FILES["img-vid"]["name"])){
    $inp_file = $_FILES["img-vid"];
    $file_name = $_FILES["img-vid"]["name"];
    $file_tmp_path = $_FILES["img-vid"]["tmp_name"];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $new_file_name = img_name().".".$file_ext;
    $file_destination = "user-images/".$new_file_name;
    $mix_type = explode("/", $_FILES["img-vid"]["type"]);
    $file_type = $mix_type[0];
    if($file_type == "image" || $file_type == "video"){
        move_uploaded_file($file_tmp_path, $file_destination);
        if($file_type == "image"){
            $image_file = $file_destination;
            $video_file = "";
        }else{
            $video_file = $file_destination;
            $image_file = "";
        }
    }else{
        if($pagename == "homepage"){
            header("location: homepage.php?msg=invalid_file");
            die();
        }else{
            header("location: profile.php?msg=invalid_file");
            die();
        }
    }
}  
#inserting post's data into DB
if(!empty($caption) || !empty($inp_file)){
    $post_id = post_id();
    $backup_id = backup_id();
    $time = date("Y-m-d H:i:s");
    if(!empty($caption) && !empty($inp_file)){
        $post_type = "text/".$file_type;
    }elseif(!empty($caption)){
        $post_type = "text";
    }else{
        $post_type = $file_type;
    }
    mysqli_query($db_connect, "insert into user_posts_main values ('$post_id', '$user_id', '$time', '$post_type', '$caption', '$image_file', '$video_file', '', '', '')");
    mysqli_query($db_connect, "insert into user_posts_backup values ('$backup_id', '$post_id', '$user_id', '$time', '$post_type', '$caption', '$image_file', '$video_file', '')");
    if(mysqli_affected_rows($db_connect)>0){
        if($pagename == "homepage"){
            header("location: homepage.php?msg=pas");
            die();
        }else{
            header("location: profile.php?msg=pas");
            die();
        }
    }else{
        if($pagename == "homepage"){
            header("location: homepage.php?msg=paus");
            die();
        }else{
            header("location: profile.php?msg=paus");
            die();
        }
    }
}else{
    if($pagename == "homepage"){
        header("location: homepage.php?msg=nopo");
    die();
    }else{
        header("location: profile.php?msg=nopo");
    die();
    }
    
}

?>