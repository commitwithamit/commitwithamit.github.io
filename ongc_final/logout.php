<?php
session_start();
if(isset($_GET["a"]) && $_GET["a"] == "admin"){
    unset($_SESSION["admin_id"]);
    header("location: administrator/index.php");
    die();
}
if(isset($_GET["a"]) && $_GET["a"] == "user"){
    unset($_SESSION["user_id"]);
    header("location: index.php");
    die();
}
if(isset($_GET["a"]) && $_GET["a"] == "mod"){
    unset($_SESSION["mod_id"]);
    header("location: moderator/index.php");
    die();
}
?>