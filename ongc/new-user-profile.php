<?php
session_start();
if(!isset($_SESSION["new_user"])){
    header("location: index.php");
    die();
}else{
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Setup | ONGC</title>
    <link rel="stylesheet" href="bootstrap-5.0.0-beta2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="bootstrap-icons-1.7.0/bootstrap-icons.css">
</head>
<body>
    <div class="main-con">

        <div class="box user-box">
            <h2 class="text-center mb-4">Let's setup your Profile!</h2>

            <form action="edit-profile-handler.php" method="POST" enctype="multipart/form-data" class="form-pd">
                <!-- edit profile picture -->
                <div class="form-group">
                  <div class="modal-pro-pic-con">
                    <img src='images/unknown.png' alt='profile picture' id='preview-pro-pic'>
                  </div>
                  <div class="btn-con">
                      <!-- select image btn -->
                    <label for="inp-img" class="mb-0 btn btn-success btn-sm">
                      <span> Change </span>
                      <input type="file" accept="image/*" name="pro-img" id="inp-img">
                    </label>
    
                    <!-- delete image btn -->
                    <button type="button" class="btn btn-danger btn-sm" id="remove-img">Remove</button>
                    
                  </div>
                </div>
              
                <div class="form-group">
                  <label for="inp-bio">Bio</label>
                  <textarea name="bio" id="inp-bio" cols="30" rows="3" class="form-control"></textarea>
                </div>
    
                <div class="md-exp">
                    <div class="form-group">
                        <label for="inp-desig">Current Designation</label>
                        <input type="text" name="desig" id="inp-desig" class="form-control">
                    </div>
            
                    <div class="form-group-1">
                        <label for="inp-dob">Date Of Birth <span class="imp">*</span></label>
                        <input type="date" name="dob" id="inp-dob" class="form-control">
                        <span id="span_dob" class="error_msg"></span>
                    </div>

                
                    <div class="form-group">
                        <label for="inp-mar-ani">Marriage Anniversary</label>
                        <input type="date" name="mar_ani" id="inp-mar-ani" class="form-control">
                    </div>
        
                    <div class="form-group">
                        <label for="inp-int">Intrests</label>
                        <input type="text" name="intrests" id="inp-int" class="form-control">
                    </div>
                </div>
    
                <input type="submit" value="Save changes" id="modal-sub-btn" class="btn btn-primary">
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
    <script src="js/functions.js"></script>
    <script>
        $(document).ready(function () {
            $("#remove-img").click(function () {
                $("#inp-img").val("");
                $("#preview-pro-pic").attr("src", "images/unknown.png");
            });
            $("#modal-sub-btn").click(function(){
                var inp_dob = $("#inp-dob").val();
                if(inp_dob == ''){
                    $("#span_dob").show().text("* Date of birth is required.");
                    $("#inp-dob").addClass("err_border");
                    return false;
                }else{
                    $("#span_dob").hide();
                    $("#inp-dob").removeClass("err_border");
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