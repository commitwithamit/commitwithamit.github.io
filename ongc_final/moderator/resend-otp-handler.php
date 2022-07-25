<?php
session_start();
include("../db-connection.php");
    $mod_user_id = $_SESSION["mod_user"];
    $log_query = mysqli_query($db_connect, "select * from registered_employee where user_id='$mod_user_id'");
    $log_row = mysqli_num_rows($log_query);
    if ($log_row>0) {
        $fet = mysqli_fetch_assoc($log_query);
        $cpf_no = $fet["cpf"];
        $otp = rand(100000, 999999);
        include("email-otp.php");
        if ($mail_status == 1) {
            $insert_query = mysqli_query($db_connect, "update ongc_moderators set otp = '$otp' where user_id = '$mod_user_id'");
            $aff_row = mysqli_affected_rows($db_connect);
            if ($aff_row>0) {
                header("location: moderator-otp.php");
                die();
            }
        }
    }
?>