<?php
  include('../functions.php');
  include('../db-connection.php');
  $user_id = 551451;
  $post_id = "7Q2U4I";
  $post_time = "2022-04-13 20:46:48";
  $user_info = getuser($user_id);
  $post_info = get_flag_post($post_id, $user_id, $post_time);


  $pro_pic = $user_info['pro_pic'];
  $user_name = $user_info['name'];
  $post_time = $post_info[0]['posting_time'];
  $post_type = $post_info[0]['post_type'];
  $post_text = $post_info[0]['text'];
  $post_img = $post_info[0]['image'];
  $post_vid = $post_info[0]['video'];
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <!-- bootstrap css-->
    <link rel='stylesheet' href='../bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css'>
    <!-- navbar css -->
    <link rel='stylesheet' href='../css/navbar-style.css'>
    <!-- navbar css -->
    <link rel='stylesheet' href='../css/homepage-style.css'>
</head>

<body>
    <div class='post-block'>
        <div class='post-container'>
            <div class='emp-pro-img-con'>
                <span class='pro-img-con'>
                    <img src='../user-images/9T7K0P2N1X.jpeg'>
                </span>
                <span class='name-date-con'>
                    <div class='emp-name'>
                        Amit Kumar
                    </div>
                    <div class='post-date'>
                        2022-04-13 20:46:48
                    </div>
                </span>
            </div>
            <hr class='post-br-line'>
            <div class='post-main'>
                    <img src='../user-images/6A7R2S6W0F.jpg'>
                <div class='caption'>
                    <p class='p_caption'>
                        hello world!
                    </p>
                </div>
            </div>
        </div>
    </div> 

    <hr>

    <div style='padding:1rem;margin:1.5rem auto;border:1px solid #a51e24;border-radius:3px;max-width:600px;'>
        <div style='overflow: hidden;'>
            <div style='display: grid;grid-template-columns: 50px auto 35px;grid-column-gap: 10px;'>
                <span style='width: 50px;height: 50px;border-radius: 3px;overflow: hidden;position: relative;border: 1px solid #bf676b;'>
                    <img src='../user-images/9T7K0P2N1X.jpeg' style="width: 100%;position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);">
                </span>
                <span style='display: flex;flex-flow: column;overflow: hidden;line-height: 1;'>
                    <div style='font-size: 1.2rem;font-weight: 600;padding-bottom: 15px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;'>
                        Amit Kumar
                    </div>
                    <div style='color: #504a4a;font-size: 0.76rem;'>
                        2022-04-13 20:46:48
                    </div>
                </span>
            </div>
            <hr class='post-br-line'>
            <div class='post-main'>
                    <img src='../user-images/6A7R2S6W0F.jpg' style="width:100%;">
                <div class='caption'>
                    <p style='cursor: default;margin-bottom: 0.6rem;'>
                        hello world!
                    </p>
                </div>
            </div>
        </div>
    </div> 
</body>
</html>