<?php
include("../db-connection.php");
include("../functions.php");
if($_POST){
    $output = "";
    if(!empty($_POST["input"])){
        $input = $_POST["input"];
        $query = mysqli_query($db_connect, "select user_id from `registered_employee` where name like '$input%' and status = 'active'");
        if(mysqli_num_rows($query)>0){
            while($fetch = mysqli_fetch_assoc($query)){
                $user_id = $fetch["user_id"];
                $user_info = getuser($user_id);
                $pro_pic = $user_info["pro_pic"];
                $name = $user_info["name"];
                if(empty($pro_pic)){
                    $pro_pic = "images/unknown.png";
                }
                $output .= "<div class='user-td'>
                                <a href='profile.php?pro_id=$user_id'>
                                    <span class='pro_pic'>
                                        <img src='../$pro_pic' alt='$name'>
                                    </span>
                                    <span>
                                        $name
                                    </span>
                                </a>    
                            </div>";
            }
            echo $output;
        }
    }
}
?>