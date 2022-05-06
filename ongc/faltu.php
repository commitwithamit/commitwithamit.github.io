<?php
// include('../functions.php');
include('../db-connection.php');
// $post_content = "";
// $post_text = "";
$user_id = 551451;
$email_query = mysqli_query($db_connect, "select email, name from registered_employee where user_id = '$user_id'");
// $user_info = getuser($user_id);
// $post_info = get_flag_post($post_id, $user_id, $post_time);
// $pro_pic = $user_info['pro_pic'];
// $user_name = $user_info['name'];
// $post_time = $post_info[0]['posting_time'];
// $post_type = $post_info[0]['post_type'];
// $post_text = $post_info[0]['text'];
// $post_img = $post_info[0]['image'];
// $post_vid = $post_info[0]['video'];
// if ($post_type == "image" || $post_type == "text/image") {
//     $post_content = "<img src='../$post_img' class='emp-img-vid'>";
// }
// if ($post_type == "video" || $post_type == "text/video") {
//     $post_content = "<video controls style=width:100%>
//         <source src='../$post_vid'>
//         Your browser does not support HTML5 video.
//         </video>";
// }
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (mysqli_num_rows($email_query)>0) {
    $fetch = mysqli_fetch_array($email_query);
    $emp_email = $fetch["email"];
    $emp_name = $fetch["name"];
    echo $emp_email, $emp_name;
    die();

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
        $mail->Username   = 'akak61999@gmail.com';         //SMTP username
        $mail->Password   = '7879737889';                  //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Enable implicit TLS encryption
        $mail->Port       = 465;                           //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('akak61999@gmail.com', 'ONGC');
        $mail->addAddress($emp_email, $emp_name);          //Add a recipient

        //Content
        $mail->isHTML(true);                               //Set email format to HTML
        $mail->Subject = 'ONGC | Your post has been banned from our platform.';
        $mail->Body = "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='../bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css'>
            <link rel='stylesheet' href='../css/navbar-style.css'>
            <link rel='stylesheet' href='../css/homepage-style.css'>
        </head>
        
        <body>
            <div class='post-block'>
                <div class='post-container'>
                    <div class='emp-pro-img-con'>
                        <span class='pro-img-con'>
                            <img src=../$pro_pic>
                        </span>
                        <span class='name-date-con'>
                            <div class='emp-name'>
                            $user_name
                            </div>
                            <div class='post-date'>
                                $post_time
                            </div>
                        </span>
                    </div>
                    <hr class='post-br-line'>
                    <div class='post-main'>
                        $post_content
                        <div class='caption'>
                                <p class='p_caption'>
                                    $post_text
                                </p>
                        </div>
                    </div>
                </div>
            </div> 
        </body>
        </html>";
        
        $mail->send();
        $mail_status = 1;
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
    }
}

?>