<?php
$email_query = mysqli_query($db_connect, "select email, name from registered_employee where cpf = '$cpf'");
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (mysqli_num_rows($email_query)>0) {
    $fetch = mysqli_fetch_array($email_query);
    $emp_email = $fetch["email"];
    $emp_name = $fetch["name"];

    require ("phpmailer/Exception.php");
    require ("phpmailer/PHPMailer.php");
    require ("phpmailer/SMTP.php");

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;          //Enable verbose debug output
        $mail->isSMTP();                                   //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';              //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                          //Enable SMTP authentication
        $mail->Username   = 'xyz@gmail.com';               //SMTP username
        $mail->Password   = 'password';                    //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Enable implicit TLS encryption
        $mail->Port       = 465;                           //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('xyz@gmail.com', 'ONGC');
        $mail->addAddress($emp_email, $emp_name);          //Add a recipient

        //Content
        $mail->isHTML(true);                               //Set email format to HTML
        $mail->Subject = 'ONGC Login otp';
        $mail->Body = $otp;
        
        $mail->send();
        $mail_status = 1;
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
    }
}

# Turn on access for less secure apps on the sender's account. https://www.google.com/settings/u/0/security/lesssecureapps
?>

