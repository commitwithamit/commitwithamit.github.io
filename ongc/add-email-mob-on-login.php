<?php
include("db-connection.php");
if(!empty($_GET["cpf"])){
    $cpf = $_GET["cpf"];
    $em_mob_query = mysqli_query($db_connect, "select email, mobile from registered_employee where cpf = '$cpf'");
    if(mysqli_num_rows($em_mob_query)>0){
        $fetch = mysqli_fetch_array($em_mob_query);
        $db_email = $fetch["email"];
        $db_mobile = $fetch["mobile"];
    }
}

$p_email = "";
$p_mobile = "";
if($_POST){
    $email_error = "";
    $mob_error = "";
    $block = "";
    $outline = "";
    $outline2 = $inst_mail = $inst_mob = $chk_mail = $chk_mob = "";
    if(isset($_POST["p_email"])){
        $p_email = $_POST["p_email"];
        $chk_con = "email = '$p_email'";
    } 
    if(isset($_POST["p_mobile"])){
        $p_mobile = $_POST["p_mobile"];
        $chk_con = "mobile = '$p_mobile'";
        if(strlen($_POST["p_mobile"]) != 10){
            $mob_error = "* Mobile number must be of 10 digits";
            $block = "d-block";
            $outline2 = "err_border";
        }
    }
    if(isset($_POST["p_mobile"]) && isset($_POST["p_email"])){
        $chk_con = "email = '$p_email' or mobile = '$p_mobile'";
    }
    if(empty($db_mobile) && empty($db_email)){
        $emp_inp = !empty($p_email) && !empty($p_mobile);
        $inst_mail = "email = '$p_email',";
        $inst_mob = "mobile = '$p_mobile',";
    }elseif(empty($db_mobile)){
        $emp_inp = !empty($p_mobile);
        $inst_mob = "mobile = '$p_mobile',";
    }elseif(empty($db_email)){
        $emp_inp = !empty($p_email);
        $inst_mail = "email = '$p_email',";
    }

    if($emp_inp){
        $chk_already_exist = mysqli_query($db_connect, "select email, mobile from registered_employee where $chk_con");
        $chk_rows = mysqli_num_rows($chk_already_exist);
        if($chk_rows>0){
            $fetch = mysqli_fetch_assoc($chk_already_exist);
            $db_email_fetch = $fetch["email"];
            $db_mob_fetch = $fetch["mobile"];
            
            if($db_email_fetch == $p_email){
                $email_error = "* Email already exists" ;
                $block =  "d-block";
            }elseif($db_mob_fetch == $p_mobile){
                $block = "d-block";
                $mob_error = "* Mobile number already exists";
            }
        }else{
            echo "update registered_employee set $inst_mail $inst_mob status = 'pending' where cpf= '$cpf'";
            $update_query = mysqli_query($db_connect, "update registered_employee set $inst_mail $inst_mob status = 'pending' where cpf= '$cpf'");
            $aff_row = mysqli_affected_rows($db_connect);
            if($aff_row>0){
                header("location: index.php?msg=update_successful");
                die();
            }
        }
    }else{
        if(empty($_POST["p_email"])){
            $email_error = "* Email is required";
            $block = "d-block";
            $outline = "err_border";
        }
        if(empty($_POST["p_mobile"])){
            $mob_error = "* Mobile number is required";
            $block = "d-block";
            $outline2 = "err_border";
        }    
    }

}
/*
if(!empty($_POST["p_email_2"])){
    $p_email_2 = $_POST["p_email_2"];
    $chk_already_exist = mysqli_query($db_connect, "select * from registered_employee where email = '$p_email_2'");
    $chk_rows = mysqli_num_rows($chk_already_exist);
    if($chk_rows>0){
        $email_error = "* Email already exists" ;
        $block =  "d-block";
        $outline = "err_border";
    }else{
        $upd_email = mysqli_query($db_connect, "update registered_employee set email = '$p_email_2', status = 'pending' where cpf= '$cpf'");
        $aff_row = mysqli_affected_rows($db_connect);
        if($aff_row>0){
            header("location: index.php?msg=update_successful");
        }
    }
}
if(!empty($_POST["p_mobile_2"])){
    $p_mobile_2 = $_POST["p_mobile_2"];
    $chk_already_exist = mysqli_query($db_connect, "select * from registered_employee where mobile = '$p_mobile_2'");
    $chk_rows = mysqli_num_rows($chk_already_exist);
    if($chk_rows>0){
        $block = "d-block";
        $mob_error = "* Mobile number already exists";
        $outline2 = "err_border";
    }else{
        $upd_mobile = mysqli_query($db_connect, "update registered_employee set mobile = '$p_mobile_2', status = 'pending' where cpf= '$cpf'");
        $aff_row = mysqli_affected_rows($db_connect);
        if($aff_row>0){
            header("location: index.php?msg=update_successful");
        }
    }
    
}
} */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css-->
    <link rel="stylesheet" href="bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="css/index.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="bootstrap-icons-1.7.0/bootstrap-icons.css">
    <title>ONGC | Add Details</title>
</head>

<body>

    <div class="main-con">

        <div class="box">

            <div class="logo mb-4">
                <img src="images/maroon-logo.png" alt="logo">
                <img src="images/white-logo.png" class="white-logo" alt="logo">
            </div>

            <!-- <h5 class="py-2 text-center">Member Login</h5> -->
                <form action="add-email-mob-on-login.php?cpf=<?=$cpf?>" method="post" class="px-5">
                    
                <?php
                    if(empty($db_email)){
                ?>
                        <div class="group mb-1">
                            <label for="f1_email">Enter Your Email </label>
                            <input type="email" class="form-control <?=$outline?>" name="p_email"  value="<?php if(!empty($p_email)) echo $p_email ?>" id="f1_email">
                            <span id="span_f1_email" class="error_msg <?=$block?>">
                                <?=$email_error?>
                            </span>
                        </div>
                <?php        
                    }
                    if(empty($db_mobile)){
                ?>

                        <div class="group mb-1">
                            <label for="f1_mob">Enter Your Mobile Number </label>
                            <input type="number" class="form-control <?=$outline2?>"  name="p_mobile" value="<?php if(!empty($p_mobile)) echo $p_mobile ?>" placeholder="10-digit number" id="f1_mob">
                            <span id="span_f1_mob" class="error_msg <?=$block?>">
                                <?=$mob_error?>
                            </span>
                        </div>
                <?php
                    }
                ?>
                    <div class="group group-btn mb-2">
                        <input type="submit" value="Save" id="submit-btn" class="sub-btn req-btn btn px-4 fw-bold">
                    </div>

                </form>

        </div>

        <div class="dark-light">
            <div class="dl-btn">
                <!-- <i class="bi bi-moon-stars-fill"></i> -->
                <i class="bi bi-moon-stars"></i>
                <i class="bi bi-brightness-high white-logo"></i>
            </div>
        </div>

    </div>
	<script src="js/jquery.js"></script>
    <script>
        $(document).ready(function () {
            $(".dark-light").click(function(){
                $("body").toggleClass("dark");
                $(".logo").find("img").toggle();
                $(".dl-btn").find("i").toggle();
            });
            // # * Mobile number is required
            // $("#submit-btn").click(function(){
            //     var f1_email = $("#f1_email").val();
            //     if(f1_email == ''){
            //         $("#span_f1_email").show().text("* Email is required");
            //         $("#f1_email").addClass("err_border");
            //         return false;
            //     }else{
            //         $("#span_f1_email").hide();
            //         $("#f1_email").removeClass("err_border");
            //     }
            //     var f1_mob = $("#f1_mob").val();
            //     if(f1_mob == ''){
            //         $("#span_f1_mob").show().text("* Mobile number is required");
            //         $("#f1_mob").addClass("err_border");
            //         return false;
            //     }else{
            //         $("#span_f1_mob").hide();
            //         $("#f1_mob").removeClass("err_border");
            //     }

            //     # for else's form where either email or mobile input box will be shown at a time
            //     var f2_email = $("#f2_email").val();
            //     if(f2_email == ''){
            //         $("#span_f2_email").show().text("* Email is required");
            //         $("#f2_email").addClass("err_border");
            //         return false;
            //     }else{
            //         $("#span_f2_email").hide();
            //         $("#f2_email").removeClass("err_border");
            //     }
            //     var f2_mob = $("#f2_mob").val();
            //     var len = f2_mob.length;
            //     if(f2_mob == ''){
            //         $("#span_f2_mob").show().text("* Mobile number is required");
            //         $("#f2_mob").addClass("err_border");
            //         return false;
            //     }else{
            //         $("#span_f2_mob").hide();
            //         $("#f2_mob").removeClass("err_border");
            //     }
            //     if(len == 10){
            //         $("#span_f2_mob").hide();
            //         $("#f2_mob").removeClass("err_border");
            //     }else{
            //         $("#span_f2_mob").show().text("* Mobile number must be of 10 digits");
            //         $("#f2_mob").addClass("err_border");
            //         return false;                   
            //     }
            // });
        });
    </script>
</body>
</html>