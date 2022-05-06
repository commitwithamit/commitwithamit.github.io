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
        <!-- single post container -->
        <div class='post-container'>
            <!-- employee's profile image, name -->
            <div class='emp-pro-img-con'>
                <span class='pro-img-con'>
                    <!-- poster's pro-pic -->
                    <?php
                        if(!empty($pro_pic)){
                        echo "<img src='../$pro_pic'>";
                        }else{
                        echo '<img src=../images/unknown.png>';
                        }
                    ?>
                </span>
                <span class='name-date-con'>
                    <div class='emp-name'>
                        <!-- poster's name -->
                        <?php
                            if(!empty($user_name)){
                                echo $user_name;
                            }
                        ?>
                    </div>
                    <div class='post-date'>
                        <!-- posting time -->
                        <?=$post_info[0]['posting_time']?>
                    </div>
                </span>
            </div>
            <hr class='post-br-line'>
            <!-- uploaded post of user -->
            <div class='post-main'>
                <!-- actual post -->
                <?php
                    if ($post_type == 'image' || $post_type == 'text/image') {
                        echo "<img src='../$post_img' class='emp-img-vid'>";
                    }
                    if ($post_type == 'video' || $post_type == 'text/video') {
                        echo '<video controls style=width:100%>
                            <source src=../$post_vid>
                            Your browser does not support HTML5 video.
                            </video>';
                    }
                ?>
                <div class='caption'>
                    <!-- caption (if any) -->
                    <p class='p_caption'>
                        <?php
                            if(!empty($post_text)){
                                echo $post_text;
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div> 
</body>
</html>