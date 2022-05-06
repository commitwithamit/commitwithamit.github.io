<?php
session_start();
if(isset($_GET["a"]) && $_GET["a"] == "admin"){
    session_destroy();
    header("location: administrator/index.php");
    die();
}
if(isset($_GET["a"]) && $_GET["a"] == "user"){
    session_destroy();
    header("location: index.php");
    die();
}
?>