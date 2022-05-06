<?php
session_start();
include("db-connection.php");
    $cpf = $_SESSION["cpf_sess"];
    $log_query = mysqli_query($db_connect, "select * from registered_employee where cpf='$cpf'");
    $log_row = mysqli_num_rows($log_query);
    if ($log_row>0) {
        $otp = rand(100000, 999999);
        include("email-otp.php");
        if ($mail_status == 1) {
            $insert_query = mysqli_query($db_connect, "update registered_employee SET otp = '$otp' WHERE cpf = '$cpf'");
            $aff_row = mysqli_affected_rows($db_connect);
            if ($aff_row>0) {
                header("location: otp.php");
                die();
            }
        }
    }
?>