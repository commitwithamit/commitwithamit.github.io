<?php
include('../functions.php');
include('../db-connection.php');
$post_content = "";
$post_text = "";
/* $post_id = "3X3P2R";
$user_id = 551451;
$post_time = "2022-04-15 17:24:10"; */
$email_query = mysqli_query($db_connect, "select email, name from registered_employee where user_id = '$user_id'");
$user_info = getuser($user_id);
$post_info = get_flag_post($post_id, $user_id, $post_time);
$pro_pic = $user_info['pro_pic'];
$user_name = $user_info['name'];
$post_time = strtotime($post_info[0]['posting_time']);
$time = date("d, F o h:i a", $post_time);
$post_type = $post_info[0]['post_type'];
$post_text = $post_info[0]['text'];
$post_img = $post_info[0]['image'];
$post_vid = $post_info[0]['video'];
if ($post_type == "image" || $post_type == "text/image") {
    $post_content = $post_img;
}
if ($post_type == "video" || $post_type == "text/video") {
    $post_content = "<video controls style=width:100%>
        <source src='C:/xampp/htdocs/ongc/$post_vid'>
        Your browser does not support HTML5 video.
        </video>";
}
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (mysqli_num_rows($email_query)>0) {
    $fetch = mysqli_fetch_array($email_query);
    $emp_email = $fetch["email"];
    $emp_name = $fetch["name"];

    require ("../phpmailer/Exception.php");
    require ("../phpmailer/PHPMailer.php");
    require ("../phpmailer/SMTP.php");

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
        $mail->addEmbeddedImage("../$pro_pic", "pro_pic");
        $mail->addEmbeddedImage("../$post_content", "post_content");
        $mail->Subject = 'ONGC | Your post has been banned from our platform.';
        $mail->Body = "<h2 style='text-align:center;color:#a51e24;font-family:arial;'>Your post goes against our community guidlines.</h2>
        <p style='text-align:center;color:#a51e24;font-family:arial;'>We have removed your following post from our platform</p>
        <div style='font-family:arial;padding:1rem;margin:1.5rem auto;border:1px solid #a51e24;border-radius:3px;max-width:600px;'>
            <div style='overflow: hidden;'>
                <div style='display:grid;grid-template-columns:50px auto 35px;grid-column-gap:10px;'>
                    <span style='width: 50px;height: 50px;border-radius: 3px;overflow: hidden;position: relative;border: 1px solid #bf676b;'>
                        <img src='cid:pro_pic' style='width: 100%;position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);'>
                    </span>
                    <span style='display: flex;flex-flow: column;overflow: hidden;line-height: 1;'>
                        <div style='font-size: 1.2rem;font-weight: 600;padding-bottom: 15px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;'>
                            $user_name
                        </div>
                        <div style='color: #504a4a;font-size: 0.76rem;'>
                            $time
                        </div>
                    </span>
                </div>
                <hr class='post-br-line'>
                <div class='post-main'>
                       <img src='cid:post_content' style='width:100%;'>
                    <div class='caption'>
                        <p style='cursor: default;margin-bottom: 0.6rem;'>
                            $post_text
                        </p>
                    </div>
                </div>
            </div>
        </div> ";
        
        $mail->send();
        $mail_status = 1;
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
    }
}

?>