<?php
include("db-connection.php");
include("functions.php");
# getting the user's email and mobile no. from db
if(!empty($_GET["cpf"])){
    $cpf = $_GET["cpf"];
    $em_mob_query = mysqli_query($db_connect, "select email, mobile from registered_employee where cpf = '$cpf'");
    if(mysqli_num_rows($em_mob_query)>0){
        $fetch = mysqli_fetch_array($em_mob_query);
        $db_email = $fetch["email"];
        $db_mobile = $fetch["mobile"];
    }
}

if($_POST){
    $email_error = $mob_error = $block = $outline = $p_valid_email = $p_valid_mobile = "";
    $outline2 = $inst_mail = $inst_mob = $chk_mail = $chk_mob = "";

    # email required 
    if(!empty($_POST["p_email"])){
        # sanitize email address with test_input & filter var functions
        $email_val = test_input($_POST["p_email"]);
        if(!filter_var($email_val, FILTER_VALIDATE_EMAIL)){
            $email_error = "* Invalid email format";
            $block = "d-block";
            $outline = "err_border";    
        }else{
            # checking whether email already exist or not
            $multi_email = chk_already_exist($email_val, "email");
            if($multi_email == true){
                $email_error = "* Email already exist";
                $block = "d-block";
                $outline = "err_border";
            }else{
                # use this variable to insert into db
                $p_valid_email = $email_val;
            }
        }
    }else{
        $email_error = "* Email is required";
        $block = "d-block";
        $outline = "err_border";
    }

    # mobile is required
    if(!empty($_POST["p_mobile"])){
        $mob_val = $_POST["p_mobile"];
        $mob_len = strlen($_POST["p_mobile"]);
        # checking if only digits & length only 10 {10}
        if(preg_match('/^[0-9]{10}+$/', $mob_val)){
            # checking whether mobile already exist or not
            $multi_mob = chk_already_exist($mob_val, "mobile");
            if($multi_mob == true){
                $mob_error = "* Mobile number already exist";
                $block = "d-block";
                $outline2 = "err_border";
            }else{
                # use this variable to insert into db
                $p_valid_mobile = $mob_val;
            }
        }else{
            if($mob_len != 10){
                $mob_error = "* Mobile number must be of 10 digits";
                $block = "d-block";
                $outline2 = "err_border";
            }else{
                $mob_error = "* Invalid mobile number";
                $block = "d-block";
                $outline2 = "err_border";
            }
        }
    }else{
        $mob_error = "* Mobile number is required";
        $block = "d-block";
        $outline2 = "err_border";
    }
    # $emp_inp is necessary when both email and mobile values are to be inserted in db
    if(empty($db_mobile) && empty($db_email)){
        $emp_inp = !empty($p_valid_email) && !empty($p_valid_mobile);
        $inst_mail = "email = '$p_valid_email',";
        $inst_mob = "mobile = '$p_valid_mobile',";
    }elseif(empty($db_mobile)){
        $emp_inp = !empty($p_valid_mobile);
        $inst_mob = "mobile = '$p_valid_mobile',";
    }elseif(empty($db_email)){
        $emp_inp = !empty($p_valid_email);
        $inst_mail = "email = '$p_valid_email',";
    }
    
    if($emp_inp){
        $update_query = mysqli_query($db_connect, "update registered_employee set $inst_mail $inst_mob status = 'inactive' where cpf= '$cpf'");
        $aff_row = mysqli_affected_rows($db_connect);
        if($aff_row>0){
            header("location: index.php?msg=update_successful");
            die();
        }
    }
}
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
                            <input type="email" class="form-control <?=$outline?>" name="p_email"  value="<?php if(!empty($email_val)) echo $email_val ?>" id="f1_email">
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
                            <input type="number" class="form-control <?=$outline2?>"  name="p_mobile" value="<?php if(!empty($mob_val)) echo $mob_val ?>" placeholder="10-digit number" id="f1_mob">
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
            //  * Mobile number is required
            $("#submit-btn").click(function(){
                var f1_email = $("#f1_email").val();
                if(f1_email == ''){
                    $("#span_f1_email").show().text("* Email is required");
                    $("#f1_email").addClass("err_border");
                    return false;
                }else{
                    $("#span_f1_email").hide();
                    $("#f1_email").removeClass("err_border");
                }
                var f1_mob = $("#f1_mob").val();
                    mob_len = f1_mob.length;
                if(f1_mob == ''){
                    $("#span_f1_mob").show().text("* Mobile number is required");
                    $("#f1_mob").addClass("err_border");
                    return false;
                }else{
                    $("#span_f1_mob").hide();
                    $("#f1_mob").removeClass("err_border");
                }
                if(mob_len == 10){
                    $("#span_f1_mob").hide();
                    $("#f1_mob").removeClass("err_border");
                }else{
                    $("#span_f1_mob").show().text("* Mobile number must be of 10 digits");
                    $("#f1_mob").addClass("err_border");
                    return false;                   
                }
                
            });
        });
    </script>
</body>
</html>