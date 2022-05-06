<?php
session_start();
if(isset($_SESSION["admin_id"]))  {
    header("location: dashboard.php");
    die();
}else{
include("../db-connection.php");
$err_msg = $block = $outline = $top_err = $cpf_no = $pass = $err_msg_p = $outline_p = $block_p = "";
if($_POST){
    if(!empty($_POST["cpf_no"])){
        $cpf_no = $_POST["cpf_no"];
    }else{
        $err_msg = "* CPF number is required";
        $block = "d-block";
        $outline = "err_border";
    }
    if(!empty($_POST["password"])){
        $pass = $_POST["password"];
    }else{
        $err_msg_p = "* Password is required";
        $block_p = "d-block";
        $outline_p = "err_border";
    }
    if(!empty($cpf_no) && !empty($pass)){
        $encode_pass = hash("sha512", $pass);
        $query = mysqli_query($db_connect, "select * from ongc_admin where admin_cpf = '$cpf_no' and password = '$encode_pass'");
        if(mysqli_num_rows($query)>=1){
            $fetch = mysqli_fetch_array($query);
            $admin_cpf = $fetch["admin_cpf"];
            $email = $fetch["email"];
            if(!empty($email)){
                $otp = rand(100000,999999);
                include("email-otp.php");
                if($mail_status == 1){
                    $insert_query = mysqli_query($db_connect, "update ongc_admin set otp = '$otp' where admin_cpf = '$cpf_no'");
                    $aff_row = mysqli_affected_rows($db_connect);
                    if($aff_row>0){
                        $_SESSION["admin_cpf"] = $admin_cpf;
                        header("location:admin-otp.php");
                        die();
                    }
                }else{
                    # if no internet then user will go to 404 error page with a message no internet 
                    header("location: ../failed.php");
                    die();
                }
            }
        }else{
            $block = "d-block";
            $outline = $outline_p = "err_border";   
            $top_err = "Wrong credentials or missing access rights to application";
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
    <link rel="stylesheet" href="../bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="../css/index.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="../bootstrap-icons-1.7.0/bootstrap-icons.css">
    <title>ONGC | Admin Login</title>
    <style>
        .logo-error-con{
            height: max-content;
        }
        .top-err{
            padding: 0 1.5rem;
        }
    </style>
</head>

<body>

    <div class="main-con">

        <div class="box">

            <div class="logo-error-con">
                <div class="logo">
                    <img src="../images/maroon-logo.png" alt="logo">
                    <img src="../images/white-logo.png" class="white-logo" alt="logo">
                </div>
                <span class="error_msg text-center <?=$block?> top-err">
                    <?php
                        echo $top_err;
                    ?>
                </span>
            </div>
            <!-- <h5 class="py-2 text-center">Member Login</h5> -->

            <form action="index.php" method="POST" class="form-pd">

                <div class="group">
                    <label for="cpf_no">CPF No.</label>
                    <input type="text" class="form-control <?=$outline?>" name="cpf_no" id="cpf_no"  value="<?php if(!empty($cpf_no)) echo $cpf_no ?>">
                    <span id="span_cpf" class="error_msg <?=$block?>">
                        <?php
                            if(empty($cpf_no)) echo $err_msg;
                        ?>
                    </span>
                </div>
                <div class="group">
                    <label for="pass">Password</label>
                    <input type="password" class="form-control <?=$outline_p?>" name="password" id="pass" autocomplete="off">
                    <span id="span_pass" class="error_msg <?=$block_p?>">
                        <?php
                            if(empty($pass)) echo $err_msg_p;
                        ?>
                    </span>
                </div>

                <div class="group group-btn mb-0">
                    <input type="submit" value="Login" id="submit-btn" class="sub-btn btn fw-bold">
                </div>
            </form>
        </div>

        <!-- dark mode button -->
        <div class="dark-light">
            <div class="dl-btn">
                <!-- <i class="bi bi-moon-stars-fill"></i> -->
                <i class="bi bi-moon-stars"></i>
                <i class="bi bi-brightness-high white-logo"></i>
            </div>
        </div>

    </div>

<script src="../bootstrap-5.0.0-beta2-dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/jquery.js"></script>
<script>
    $(document).ready(function () {

        $("#submit-btn").click(function(){
            var inp_cpf = $.trim($("#cpf_no").val());
            var inp_pass = $.trim($("#pass").val());
            if(inp_cpf.length > 0){
                $("#span_cpf").hide();
                $("#cpf_no").removeClass("err_border");
            }else{
                $("#span_cpf").show().text("* CPF number is required.");
                $("#cpf_no").addClass("err_border");
                return false;
            }
            if(inp_pass.length > 0){
                $("#span_pass").hide();
                $("#pass").removeClass("err_border");
            }else{
                $("#span_pass").show().text("* Password is required.");
                $("#pass").addClass("err_border");
                return false;
            }
        });

        $(".dark-light").click(function(){
            $("body").toggleClass("dark");
            $(".logo").find("img").toggle();
            $(".dl-btn").find("i").toggle();
            // var cpf = $("#cpf_no").val();
        });

    });
</script>
    
</body>

</html>
<?php
}
?>