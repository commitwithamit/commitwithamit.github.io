<?php
include("db-connection.php");
if($_POST["cpf"]){
    $cpf = $_POST["cpf"];
    $log_query = mysqli_query($db_connect, "select * from registered_employee where cpf='$cpf'");
    $log_row = mysqli_num_rows($log_query);
        if($log_row>0){
            $dark_update_query = mysqli_query($db_connect, "update registered_employee set dark_mode = 'dark' where cpf='$cpf'");
        }
}
?>