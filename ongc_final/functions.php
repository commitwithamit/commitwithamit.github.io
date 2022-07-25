<?php
include("db-connection.php");
date_default_timezone_set("Asia/Kolkata");

    # get comment id
    function getcommentid($post_id, $user_id, $comment){
        global $db_connect;
        $query = "select * from user_comments where post_id = '$post_id' and user_id = $user_id and comment = '$comment'";
        $run = mysqli_query($db_connect, $query);
        return mysqli_fetch_assoc($run);
    }

    # get all users from registered_emp table
    function get_reg_user($user_id){
        global $db_connect;
        $query = "select reg.user_id, reg.name, bio.pro_pic, bio.current_designation from registered_employee reg left join user_bio bio on reg.user_id = bio.user_id where reg.user_id = $user_id";
        $run = mysqli_query($db_connect, $query);
        return mysqli_fetch_assoc($run);
    }

    # get user
    function getuser($user_id){
        global $db_connect;
        $query = "select reg.name, bio.pro_pic, bio.current_designation from registered_employee reg join user_bio bio on reg.user_id = bio.user_id and reg.user_id = $user_id";
        $run = mysqli_query($db_connect, $query);
        return mysqli_fetch_assoc($run);
    }

    # get comments
    function getcomments($post_id){
        global $db_connect;
        $query = "select * from user_comments where post_id = '$post_id' order by comment_id DESC";
        $run = mysqli_query($db_connect, $query);
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    }

    # add comment
    function addcomment($post_id, $curr_user_id, $comment){
        global $db_connect;
        $query = "insert into user_comments(post_id, user_id, comment) VALUES ('$post_id', '$curr_user_id', '$comment')";
        $run = mysqli_query($db_connect, $query);
        return $run;
    }
    
    # like a post
    function like_post($post_id, $curr_user_id){
        global $db_connect;
        $query = "insert into user_likes (post_id, user_id) values ('$post_id', '$curr_user_id')";
        $run = mysqli_query($db_connect, $query);
        return $run;
    }
    
    # unlike a post
    function unlike_post($post_id, $curr_user_id){
        global $db_connect;
        $query = "delete from user_likes where post_id = '$post_id' and user_id = '$curr_user_id'";
        $run = mysqli_query($db_connect, $query);
        return $run;
    }

    # to check if user liked a post already or not
    function chk_like_status($post_id, $curr_user_id){
        global $db_connect;
        $query = "select * from user_likes where post_id = '$post_id' and user_id = '$curr_user_id'";
        $run = mysqli_query($db_connect, $query);
        return mysqli_fetch_assoc($run);
    }

    # get number of likes on a post
    function getlikes($post_id){
        global $db_connect;
        $query = "select * from user_likes where post_id = '$post_id'";
        $run = mysqli_query($db_connect, $query);
        return mysqli_fetch_all($run);
    }

    # for getting post to show it to users
    function getpost(){
        global $db_connect;
        $query = "SELECT main.post_id, main.user_id, main.posting_time, main.post_type, main.text, main.image, main.video, reg.name, bio.pro_pic FROM user_posts_main main JOIN registered_employee reg ON main.user_id = reg.user_id JOIN user_bio bio ON main.user_id = bio.user_id ORDER BY posting_time DESC";
        $run = mysqli_query($db_connect, $query);
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    }
    
    # for getting user's own post to show on his/her profile page
    function myposts($pro_id){
        global $db_connect;
        $query = "SELECT * from user_posts_main where user_id = '$pro_id' ORDER BY posting_time DESC";
        $run = mysqli_query($db_connect, $query);
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    }
    
    # comment time display format
    function comment_time($inp){
        $d_t = strtotime($inp);
        $diff = time() - $d_t;

        $sec = $diff;
        $min = round($diff/60);
        $hour = round($diff/3600);
        $days = round($diff/86400);
        $week = round($diff/604800);
        $year = round($diff/31536000);

        if($sec <= 60){
            echo "Just now";
        }elseif($min <= 60){
            echo $min."m";
        }elseif($hour <= 24){
            echo $hour."h";
        }elseif($days <= 7){
            echo $days."d";
        }elseif($week <= 52){
            echo $week."w";
        }else{
            echo $year."y";
        }
    }
    
    # post time display format
    function time_ago($inp){
        $d_t = strtotime($inp);
        $diff = time() - $d_t;
        
        $split = explode(" ", $inp);
        $db_date = strtotime($split[0]);
        $db_time = strtotime($split[1]);

        $date = date("d M, Y", $db_date);
        $time = date("g:i a", $db_time);

        $sec = $diff;
        $min = round($diff/60);
        $hour = round($diff/3600);
        $days = round($diff/86400);

        if($sec <= 60){
            echo "Just now";
        }elseif($min <= 60){
            echo "$min minutes ago";
        }elseif($hour <= 24){
            echo "$hour hours ago";
        }elseif($days >= 1){
            if($days == 1){
                echo "Yesterday at $time";
            }else{
                echo "$date at $time";
            }
        }
    }

    # 6 digit alpha num id for each new post (user_post_main table)
    function post_id(){
        $num = "";
        $alpnum = "";
        $i = 0;
        while($i < 6){
            $i++;
            if($i%2==0){
                $rand = rand(65, 90);
                $num = chr($rand);
            }else{
                $rand = rand(48, 57);
                $num = chr($rand);
            }
            $alpnum .= $num;
        }
        return $alpnum;
    }

    # 6 digit alpha num id for new post and for the edited posts (user_post_backup)
    function backup_id(){
        $num = "";
        $alpnum = "";
        $i = 0;
        while($i < 6){
            $i++;
            if($i%2==0){
                $rand = rand(65, 90);
                $num = chr($rand);
            }else{
                $rand = rand(48, 57);
                $num = chr($rand);
            }
            $alpnum .= $num;
        }
        return $alpnum;
    }

    # 10 digit alpha num name for all images and videos
    function img_name(){
        $num = "";
        $alpnum = "";
        $i = 0;
        while($i < 10){
            $i++;
            if($i%2==0){
                $rand = rand(65, 90);
                $num = chr($rand);
            }else{
                $rand = rand(48, 57);
                $num = chr($rand);
            }
            $alpnum .= $num;
        }
        return $alpnum;
    }

    // to check if user bio is filled during login, if not we will ask user to fill bio before redirecting him/her to homepage.
    function check_bio(){
        global $db_connect;
        global $user_id;
        global $name;
        global $new_user;
        global $user_name;
        # checking if profile info exist in user bio
        $bio_query = mysqli_query($db_connect, "select * from user_bio where user_id='$user_id'");
        $bio_rows = mysqli_num_rows($bio_query);
        if($bio_rows>0){
            # bio exists
            # set session here
            $_SESSION["user_id"] = $user_id;
            $_SESSION["name"] = $name;
            header("location: homepage.php");
            die();
        }else{
            # no bio (first time login)
            $_SESSION["new_user"] = $new_user;
            $_SESSION["username"] = $user_name;
            header("location: new-user-profile.php");
            die();
        }
    }

    # sanatizing values in input boxes
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    # email/mobile already exist or not
    function chk_already_exist($value, $check){
        global $db_connect;
        if($check === "email"){
            $query = mysqli_query($db_connect, "select email from registered_employee where email = '$value'");
        }
        if($check === "mobile"){
            $query = mysqli_query($db_connect, "select mobile from registered_employee where mobile = '$value'");
        }
        $rows = mysqli_num_rows($query);
        if($rows>0){
            return true;
        }else{
            return false;
        }
    }

    // moderator function
    
    function get_mod_name($mod_id){
        global $db_connect;
        $query = mysqli_query($db_connect, "select * from ongc_moderators where mod_id = '$mod_id'");
        $get_row = mysqli_fetch_assoc($query);
        $get_userid = $get_row["user_id"];
        $search = mysqli_query($db_connect, "select * from registered_employee where user_id = '$get_userid'");
        $get_row = mysqli_fetch_assoc($search);
        $mod_name = $get_row["name"];
        return $mod_name;
    }
     
    # selecting only those flagged post which are flagged by a particular moderator
    # if jon has flagged abc & xyz post then he will see only these post in flagged post page of his mod profile.
    function mod_flag_post($mod_id){
        global $db_connect;
        $query = mysqli_query($db_connect, "select * from ongc_flagged_posts where mod_id = '$mod_id' order by posting_time desc");
        return mysqli_fetch_all($query, true);
    }
    //  admin functions below

    # selecting all flagged post to show it to admin
    function sel_flag_post(){
        global $db_connect;
        $query = mysqli_query($db_connect, "select * from ongc_flagged_posts order by posting_time desc");
        return mysqli_fetch_all($query, true);
    }

    # getting only flagged post from backup table
    function get_flag_post($post_id, $user_id, $post_time){
        global $db_connect;
        $query = mysqli_query($db_connect, "select * from user_posts_backup where post_id = '$post_id' and user_id = $user_id and posting_time = '$post_time'");
        return mysqli_fetch_all($query, true);
    }

?>