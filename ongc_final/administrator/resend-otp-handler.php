<?php
session_start();
include("../db-connection.php");
    $cpf_no = $_SESSION["admin_cpf"];
    $log_query = mysqli_query($db_connect, "select * from ongc_admin where admin_cpf='$cpf_no'");
    
    $log_row = mysqli_num_rows($log_query);
    if ($log_row>0) {
        $otp = rand(100000, 999999);
        include("email-otp.php");
        if ($mail_status == 1) {
            $insert_query = mysqli_query($db_connect, "update ongc_admin set otp='$otp' where admin_cpf='$cpf_no'");
            $aff_row = mysqli_affected_rows($db_connect);
            if ($aff_row>0) {
                header("location: admin-otp.php");
                die();
            }
        }
    }
?>