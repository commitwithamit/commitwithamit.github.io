<?php
$email_query = mysqli_query($db_connect, "select * from registered_employee where cpf = '$cpf'");
if (mysqli_num_rows($email_query)>0) {
    $fetch = mysqli_fetch_array($email_query);
    $user_name = $fetch["name"];

    # $to = admin's email address will come here.
    $to = "akak61999@gmail.com";
    $subject = "Mobile Update Request";
    $message = "New mobile update request from $cpf | $user_name";
    $header = "From: akak61999@gmail.com";
    $mail_status = mail($to, $subject, $message, $header);
}
?>