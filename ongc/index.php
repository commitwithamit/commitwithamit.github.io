<?php
session_start();  
if(isset($_SESSION["user_id"]))  {
    header("location: homepage.php");
    die();
}else{

    include("db-connection.php");
    
    # creating blank var to avoide undefined var notice 
    $err_msg = $body_modal = $div_modal = $div_show = $block = $outline = $cpf = $top_err = $modal_message = $modal_title = $d_none = "";
    if($_POST){
        $cpf = $_POST["cpf_no"];
        if(!empty($cpf)){
            $log_query = mysqli_query($db_connect, "select * from registered_employee where cpf='$cpf'");
            $log_row = mysqli_num_rows($log_query);
            if($log_row>0){
                $fetch = mysqli_fetch_array($log_query);
                $email = $fetch["email"];
                $mobile = $fetch["mobile"];
                if(!empty($email) && !empty($mobile)){
                    $chk_status = mysqli_query($db_connect, "select * from registered_employee where cpf = '$cpf' and status = 'active'");
                    if(mysqli_num_rows($chk_status)>0){
                        $otp = rand(100000, 999999);
                        include("email-otp.php");
                        if($mail_status == 1){
                            $insert_query = mysqli_query($db_connect, "update registered_employee set otp = '$otp' where cpf = '$cpf'");
                            $aff_row = mysqli_affected_rows($db_connect);
                            if($aff_row>0){
                                $_SESSION["cpf_sess"] = $cpf;
                                header("location: otp.php");
                                die();
                            }
                        }else{
                            # if no internet then user will go to a page where a message no internet will be shown to him/her
                            header("location: failed.php");
                            die();
                        }
                    }else{
                        #open modal with message pending status
                        $body_modal = "modal-open";
                        $div_modal = "show d-block";
                        $div_show = "modal-backdrop fade show";
                        $d_none = "d-none";
                        $modal_title = "Your account was not approved";
                        $modal_message = "We have noticed that your account was not approved. You can wait or kindly contact the administrator.";
                    }
                    
                }else{
                    $body_modal = "modal-open";
                    $div_modal = "show d-block";
                    $div_show = "modal-backdrop fade show";
                    $modal_title = "Missing contact information.";
                    $modal_message = "Your Email & Mobile is not available with us, kindly click on <b>Add details</b> button to provide your current email id and mobile number.";
                }
            }else{
                $top_err = "** User not found **";
                $block = "d-block";
            }
        }else{
            $err_msg = "* CPF number is required";
            $block = "d-block";
            $outline = "err_border";
            // header("location: index.php?error=empty");
        }
    }
    if(isset($_GET["msg"]) && $_GET["msg"]=="update_successful"){
        $top_err = "** Update Successful **";
        $block = "d-block text-success";
    }
    // 2Y8J4C9B Riya Jain riya123@gmail.com 8770488324
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
        <title>ONGC | Login</title>
    </head>

    <body class="<?=$body_modal?>">

        <div class="main-con">

            <div class="box">

                <div class="logo-error-con">
                    <div class="logo">
                        <img src="images/maroon-logo.png" alt="logo">
                        <img src="images/white-logo.png" class="white-logo" alt="logo">
                    </div>
                    <span class="error_msg text-center <?=$block?>">
                        <?php
                            echo $top_err;
                        ?>
                    </span>
                </div>
                <!-- <h5 class="py-2 text-center">Member Login</h5> -->

                <form action="index.php" method="POST" class="form-pd">

                    <div class="group">
                        <label for="cpf_no">CPF No.</label>
                        <input type="text" class="form-control <?=$outline?>" name="cpf_no" id="cpf_no">
                        <span id="span_cpf" class="error_msg <?=$block?>">
                            <?php
                               if(empty($cpf)) echo $err_msg;
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
        

        <!-- Modal -->
        <div class="modal fade <?=$div_modal?>" id="exampleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <?php if(!empty($modal_title)) echo $modal_title ?>
                    </h5>
                    <button type="button" class="btn-close close-me" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if(!empty($modal_message)) echo $modal_message ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-me" data-bs-dismiss="modal">Close</button>
                    <a href="add-email-mob-on-login.php?cpf=<?=$cpf?>" class="btn btn-primary <?=$d_none?>">Add details</a>
                </div>
                </div>
            </div>
        </div>
        <div class="<?=$div_show?>" id="modal-bg"></div>

    <script src="bootstrap-5.0.0-beta2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.js"></script>
    <script>
        $(document).ready(function () {
            $(".close-me").click(function(){
                $("body").removeClass("modal-open");
                $(".modal").removeClass("show d-block");
                $("#modal-bg").removeClass("modal-backdrop fade show");
            });

            $("#submit-btn").click(function(){
                var inp_cpf = $.trim($("#cpf_no").val());
                if(inp_cpf.length > 0){
                    $("#span_cpf").hide();
                    $("#cpf_no").removeClass("err_border");
                }else{
                    $("#span_cpf").show().text("* CPF number is required.");
                    $("#cpf_no").addClass("err_border");
                    return false;
                }
                if($("body").hasClass("dark")){
                    $.ajax({
                        type:"post",
                        url: "dark-mode-handler.php",
                        data: {"cpf":inp_cpf},
                        success:function(output){
                            alert(output);
                        }
                    });
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