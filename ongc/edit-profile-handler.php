<?php
session_start();
include("db-connection.php");
if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
}
if(isset($_SESSION["new_user"])){
    $user_id = $_SESSION["new_user"];
    $username = $_SESSION["username"];
    $user = "new";
}

include("functions.php");
$pro_pic = "";
$bio = "";
$desig = "";
$dob = "";
$mar_ani = "";
$int = "";
$pro_img_db = "";
if (!empty($_FILES["pro-img"])) {
    $pro_pic = $_FILES["pro-img"]["name"];
    $tmp_path = $_FILES["pro-img"]["tmp_name"];
    $ext = strtolower(pathinfo($pro_pic, PATHINFO_EXTENSION));
    $sup_ext = array("jpg", "jpeg", "png");
    if (in_array($ext, $sup_ext)) {
        $valid_img_name = img_name().".".$ext;
        $destination = "user-images/".$valid_img_name;
        $pro_img_db = "pro_pic = '$destination',";
        move_uploaded_file($tmp_path, $destination);
    }
}else{
    $destination = "images/unkown.png";
    $pro_img_db = "pro_pic = '$destination',";
}
if ($_POST) {
    # strlen(trim($_POST["bio"])) !== 0) check's being used to remove those strings which has on whitespaces eg "   ";
    if (!empty($_POST["bio"]) && strlen(trim($_POST["bio"])) !== 0) {
        $bio = str_replace("'","''",$_POST["bio"]);
    }
    if (!empty($_POST["desig"]) && strlen(trim($_POST["desig"])) !== 0) {
        $desig = str_replace("'","''",$_POST["desig"]);
    }
    if (!empty($_POST["dob"])) {
        $dob = $_POST["dob"];
    }
    if (!empty($_POST["mar_ani"])) {
        $mar_ani = $_POST["mar_ani"];
    }
    if (!empty($_POST["intrests"]) && strlen(trim($_POST["intrests"])) !== 0) {
        $int = str_replace("'","''",$_POST["intrests"]);
    }
    
}

# checking wheather profile data already exist in db if yes then user's updating if no then user is inserting for first time
$select_query = mysqli_query($db_connect, "select * from user_bio where user_id = '$user_id'");
$select_num_rows = mysqli_num_rows($select_query);
if($select_num_rows>0){
    # updating profile data         
    # not updating dob assuming user has inserted it while editing his profile for the first time and now input:date has been disabled so user can't update it.
    $up_query = mysqli_query($db_connect, "update user_bio set $pro_img_db bio = '$bio', current_designation = '$desig', marriage_anniversary = '$mar_ani', intrests = '$int' where user_id = '$user_id'");
    $aff_row = mysqli_affected_rows($db_connect);
    if ($aff_row>0) {
        header("location: profile.php?msg=up_suc");
        die();
    } else {
        header("location: profile.php?msg=up_failed");
        die();
    }
}else{
    # inserting profile data for the first time      
    if (!empty($dob)) {
        $in_query = mysqli_query($db_connect, "insert into user_bio values ('$user_id', '$destination', '$bio', '$desig', '$dob', '$mar_ani', '$int')");
        $aff_row = mysqli_affected_rows($db_connect);
        if ($aff_row > 0) {
            if(!empty($user) && $user == "new"){
                $_SESSION["user_id"] = $user_id;
                $_SESSION["name"] = $username;
                unset($_SESSION["new_user"]);
                header("location: homepage.php?msg=in_suc");
                die();    
            }else{
                header("location: profile.php?msg=in_suc");
                die();
            }
        } else {
            if(!empty($user) && $user == "new"){
                header("location: new-user-profile.php?msg=in_failed");
                die();
            }else{
                header("location: profile.php?msg=in_failed");
                die();
            }
            
        }
    } else {
        if(!empty($user) && $user == "new"){
            header("location: new-user-profile.php?msg=dob_empty");
            die();
        }else{
            header("location: profile.php?msg=dob_empty");
            die();
        }
    }
    // echo "$bio, $desig, $dob, $mar_ani, $int";
}

?>