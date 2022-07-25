<?php
session_start();
if(!isset($_SESSION["admin_cpf"])){
    header("location: index.php?login_first");
    die();
}else{
include("../db-connection.php");
$dark = "";
$cpf = $_SESSION["admin_cpf"];
if(!empty($cpf)){
    $get_email = mysqli_query($db_connect, "select email from ongc_admin where admin_cpf='$cpf'");
    if(mysqli_num_rows($get_email)>0){
        $email_fet = mysqli_fetch_array($get_email);
        $email = $email_fet["email"];
    }
}
$block = "";
$outline = "";
$err_msg = "";
if($_POST){
    if(!empty($_POST["otp"])){
        $otp = $_POST["otp"];
        # chk if otp length is equal to 6 or not 
        $otp_len = strlen($otp);
        if($otp_len == 6){
            $otp_chk_query = mysqli_query($db_connect, "select * from ongc_admin where otp='$otp' and admin_cpf='$cpf'");
            if(mysqli_num_rows($otp_chk_query)>0){
                $fetch = mysqli_fetch_array($otp_chk_query);
                $admin_id =  $fetch["admin_id"];
                $admin_name =  $fetch["name"];
                $update_otp_blank = mysqli_query($db_connect, "update ongc_admin set otp='' where admin_cpf='$cpf'");
                if($update_otp_blank == true){
                    unset($_SESSION["admin_cpf"]); 
                    $_SESSION["admin_id"] = $admin_id;
                    $_SESSION["admin_name"] = $admin_name;
                    header("location: dashboard.php");
                    die();
                }
            }else{
                $block = "d-block";
                $outline = "err_border";
                $err_msg = "* Invalid Otp";
            }
        }else{
            $block = "d-block";
            $outline = "err_border";
            $err_msg = "* Otp must be of 6 digits";
        }   
    }else{
        $block = "d-block";
        $outline = "err_border";
        $err_msg = "* Otp field is required";
    }
}
function censor_email($email){
    $exp = explode("@", $email);
    $slice = implode("@", array_slice($exp, 0, 1));
    $len  = strlen($slice);
    return substr($slice, 0, 1) . str_repeat('*', $len-1) . "@" . end($exp);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css-->
    <link rel="stylesheet" href="../bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="../css/index.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="../bootstrap-icons-1.7.0/bootstrap-icons.css">
    <title>ONGC | Otp Verification</title>

</head>

<body class="<?=$dark?>">

    <div class="main-con">

        <div class="box">
            <div class="logo-error-con">
                <div class="logo">
                    <?php
                        if ($dark == "") {
                            ?>
                    <img src="../images/maroon-logo.png" alt="logo">
                    <?php
                        }
                        if ($dark == "dark") {
                    ?>
                        <img src="../images/maroon-logo.png" class="white-logo" alt="logo">
                        <img src="../images/white-logo.png" class="<?=$d_block?>" alt="logo">
                    <?php
                        }
                    ?>
                </div>
            </div>
            <!-- <h5 class="py-2 text-center">Member Login</h5> -->

            <form action="admin-otp.php" method="post" class="form-pd">

                <div class="group mb-1">
                    <label for="inp-otp">Enter verfication code </label>
                    <input type="number" class="form-control <?=$outline?>" placeholder="6-digit code" name="otp" id="inp-otp">
                    <span id="span_otp" class="error_msg <?=$block?>">
                        <?php
                            echo $err_msg;
                        ?>
                    </span>
                </div>

                <div class="group group-btn mb-2">
					<input type="submit" value="Verify" id="submit-btn" class="sub-btn btn px-4 fw-bold">
                </div>

                <div class="group mb-0 mt-4 group-btn">
					<p>
						<i class="bi bi-envelope"></i> 
						Please check your email <?php if(!empty($email)) echo censor_email($email)?> for an OTP.
					</p>
                </div>

                <div class="group mb-0 mt-2 resend">
                    <span class="re-otp">
                        Didn't received otp? &nbsp; 
                        <a href="resend-otp-handler.php"> Re-send otp.</a>
                    </span>
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
	<script src="../js/jquery.js"></script>
    <script>
        $(document).ready(function () {
            $(".dark-light").click(function(){
                $("body").toggleClass("dark");
                $(".logo").find("img").toggle();
                $(".dl-btn").find("i").toggle();
            });
            if($("body").hasClass("dark")){

            }
            $("#submit-btn").click(function(){
                var inp_otp = $("#inp-otp").val();
                    otp_len = inp_otp.length;
                if(inp_otp == ''){
                    $("#span_otp").show().text("* Otp field is required");
                    $("#inp-otp").addClass("err_border");
                    return false;
                }else{
                    $("#span_otp").hide();
                    $("#inp-otp").removeClass("err_border");
                }
                if(otp_len != 6){
                    $("#span_otp").show().text("* Otp must be of 6 digits");
                    $("#inp-otp").addClass("err_border");
                    return false;
                }else{
                    $("#span_otp").hide();
                    $("#inp-otp").removeClass("err_border");
                }
            });

        });
    </script>
</body>
</html>
<?php
}
?>