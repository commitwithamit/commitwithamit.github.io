<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image upload practice</title>
    <style>
        label{
            width:100px;
            height: 50px;
            background: #000;
            color: #fff;
            display: block;
            cursor: pointer;
        }
        #sel_img{
            display: none;
        }
    </style>
</head>
<body>
    <div class="main">
    <div class="img-pre-con">
        <img src="images/unknown.png" id="img-pre">
    </div>
    <div class="upload-img-con">
        <form action="img-up-practice.php" enctype="multipart/form-data" method="post">
            choose img: 
            <label for="sel_img">
                <span>FILE</span>
                <input type="file" name="img_file" id="sel_img">
            </label>
            <input type="submit" value="submit">
        </form>
    </div>
    </div>

    <script src="js/jquery.js"></script>
    <script>
        $(document).ready(function () {
            $("#sel_img").change(function(){
                var img = this.files[0];
                alert(img);
            });
        });
    </script>
</body>
</html>