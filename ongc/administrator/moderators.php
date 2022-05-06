<?php
session_start();
if(!isset($_SESSION["admin_id"])){
    header("location: index.php?login_first");
    die();
}else{
    $admin_id = $_SESSION["admin_id"];
    $admin_name = $_SESSION["admin_name"];
    $_SESSION["pagename"] = "moderators";
    include("../db-connection.php");
    include("../functions.php");
    include("../messages.php");
    # fetching moderators from db
    $mod_users = mysqli_query($db_connect, "select * from ongc_moderators");
    $mod_data = mysqli_fetch_all($mod_users, MYSQLI_ASSOC);

    # putting mod's user_id into an array and converted to string to use in a mysql IN statement
    # to seprate them from rest of the users who are not mods and list them under users.
    $arr = array();
    foreach($mod_data as $mod){
        @$mod_id = $mod["user_id"];
        $arr[] = $mod_id;
    }
    # if no mods then we will select all users form reg_emp table
    $all_users_query = "select * from registered_employee";
    # if there are mods then we will concat the below query which will not select the mods from reg_emp table
    if(!empty($arr)){
        @$mod_val = implode(",", $arr);
        $all_users_query .= " where user_id not in ($mod_val)";
    }
    $all_users = mysqli_query($db_connect, $all_users_query);
    $reg_data = mysqli_fetch_all($all_users, MYSQLI_ASSOC);

    $pic = $desig = $name = $user_id = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css-->
    <link rel="stylesheet" href="../bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css">
    <!-- navbar css -->
    <link rel="stylesheet" href="../css/navbar-style.css">
    <!-- navbar css -->
    <link rel="stylesheet" href="../css/navbar-admin.css">
    <!-- navbar css -->
    <link rel="stylesheet" href="../css/homepage-style.css">
    <!-- navbar css -->
    <link rel="stylesheet" href="../css/users-data.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="../bootstrap-icons-1.7.0/bootstrap-icons.css">
    <title>ONGC | Users Data</title>
</head>

<body>
    <?php
    # navbar
    include("navbar.php"); 
?>

    <div class="main-con">
        <div class="col-half">
            <div class="all-user-con">
                <h4>Users</h4>
                <ul>
                    <?php
                    if(!empty($reg_data)){
                        foreach($reg_data as $arr){
                            $user_data = get_reg_user($arr["user_id"]);
                            $pic = $user_data["pro_pic"];
                            $desig = $user_data["current_designation"];
                            $name = $user_data["name"];
                            $user_id = $user_data["user_id"];//reg
                    ?>
                                    <li class="li-item">
                                        <a href="user-profile.php?pro_id=<?=$user_id?>">
                                            <?php
                                                if(!empty($pic)){
                                                    echo "<img src='../$pic'>";
                                                }else{
                                                    echo "<img src='../images/unknown.png'>";
                                                }
                                            ?>
                                        </a>
                                        <span class="sp-name">
                                            <a href="user-profile.php?pro_id=<?=$user_id?>">
                                                <p><?=$name?></p>
                                            </a>
                                            <p><?=$desig?></p>
                                        </span>
                                        <span class="sp-btn">
                                            <a href="admin-actions.php?a=add-mod&pro_id=<?=$user_id?>" title="Add to moderator">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                        </span>
                                    </li>
                    <?php
                        }
                    }else{
                        echo "<p class='text-center'  style='margin-top:2rem;'>- No Users available -<p>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-half">
            <div class="all-mod-con">
                <h4>Moderators</h4>
                <ul>
                    <?php
                    if(!empty($mod_data)){
                        foreach($mod_data as $arr){
                            $user_data = get_reg_user($arr["user_id"]);
                            $pic = $user_data["pro_pic"];
                            $desig = $user_data["current_designation"];
                            $name = $user_data["name"];
                            $user_id = $user_data["user_id"];
                    ?>
                        <li class="li-item">
                            <a href="user-profile.php?pro_id=<?=$user_id?>">
                                <?php
                                    if(!empty($pic)){
                                        echo "<img src='../$pic'>";
                                    }else{
                                        echo "<img src='../images/unknown.png'>";
                                    }
                                ?>
                            </a>
                            <span class="sp-name">
                                <a href="user-profile.php?pro_id=<?=$user_id?>">
                                    <p><?=$name?></p>
                                </a>
                                <p><?=$desig?></p>
                            </span>
                            <span class="sp-btn">
                                <a href="admin-actions.php?a=del-mod&pro_id=<?=$user_id?>" title="Remove as moderator">
                                    <i class="bi bi-dash-circle"></i>
                                </a>
                            </span>
                        </li>
                    <?php
                        }
                    }else{
                        echo "<p class='text-center' style='margin-top:2rem;'>- No moderators assigned -</p>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- backend validations disappering dialog box/alert -->
    <div class="msg-con">
        <div class="msg-details <?php if(!empty($msg_class)) echo $msg_class; ?>">
        <span class="msg-box">
            <!-- message here -->
            <?php
            if(!empty($message))echo $message;
            ?>
        </span>
        <span class="msg-close">
            <i class="bi bi-x-lg"></i>
        </span>
        </div>
    </div>

    <script src="../bootstrap-5.0.0-beta2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/nav.js"></script>
    <script src="../js/functions.js"></script>
    <script>
    $(document).ready(function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
    </script>
</body>

</html>
<?php
}
?>