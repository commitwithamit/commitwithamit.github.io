<?php
session_start();
if(!isset($_SESSION["admin_id"])){
    header("location: index.php?login_first");
    die();
}else{
    $admin_id = $_SESSION["admin_id"];
    $admin_name = $_SESSION["admin_name"];
    $_SESSION["pagename"] = "users_data";
    $post = "";
    include("../db-connection.php");
    include("../messages.php");
    include("../functions.php");
    $query = "";
    $query = "select reg.user_id, reg.name, reg.email, reg.mobile, reg.status, bio.current_designation from registered_employee reg left join user_bio bio on reg.user_id = bio.user_id";

    $total_rows = mysqli_num_rows(mysqli_query($db_connect, $query));
    
    if(!empty($_GET["search"]) && empty($_GET["status"])){
        $inp_search = $_GET["search"];
        $query .= " where reg.user_id like '$inp_search' or reg.name like '$inp_search%' or reg.email like '$inp_search' or reg.mobile like '$inp_search' or bio.current_designation like '$inp_search%'";
    }elseif(!empty($_GET["status"]) && empty($_GET["search"])){
        $inp_status = $_GET["status"];
        $query .=" where reg.status='$inp_status'";
    }elseif(!empty($_GET["search"]) && !empty($_GET["status"])){
        $inp_search = $_GET["search"];
        $inp_status = $_GET["status"];
        $query .= " where (reg.user_id like '$inp_search' or reg.name like '$inp_search%' or reg.email like '$inp_search' or reg.mobile like '$inp_search' or bio.current_designation like '$inp_search%') and reg.status='$inp_status'";
    }
    
    if(isset($_GET["a"]) && $_GET["a"] == "asc"){
        $query .= " order by name asc";
    }
    if(isset($_GET["a"]) && $_GET["a"] == "des"){
        $query .= " order by name desc";
    }
    $reg_query = mysqli_query($db_connect, $query);
    $reg_row = mysqli_num_rows($reg_query);
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

    <div class="form-con">
        <form action="users-data.php" method="GET">
            <input type="text" name="search" id="search" placeholder="Search"
                value="<?php if(!empty($inp_search)) echo $inp_search ?>" autocomplete="off">
            <span>
                <select name="status" id="status">
                    <option value="">Status</option>
                    <option <?php if(!empty($inp_status) && $inp_status == "active") echo "selected" ?> value="active">
                        Active</option>
                    <option <?php if(!empty($inp_status) && $inp_status == "pending") echo "selected" ?>
                        value="pending">Pending</option>
                </select>
            </span>
            <input type="submit" value="Search" class="btn btn-search">
            <a href="users-data.php" class="btn btn-all">Show All</a>
        </form>
    </div>

    <h5 class="result_count text-center">Showing <span><?=$reg_row?></span> results out of <span><?=$total_rows?></span>
        records</h5>

    <div class="table-con">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">User Id</th>
                        <th scope="col" class="col-name">
                            <a href="users-data.php?a=asc<?php if(!empty($_GET['search'])) echo '&search='.$inp_search; if(!empty($_GET['status'])) echo '&status='.$inp_status; ?>"
                                class="order-btn">
                                <i class="bi bi-sort-down-alt"></i>
                                <p class="tip"><i class="bi bi-caret-left-fill"></i>Ascending Order</i></p>
                            </a>
                            <span>
                                Name
                            </span>
                            <a href="users-data.php?a=des<?php if(!empty($_GET['search'])) echo '&search='.$inp_search; if(!empty($_GET['status'])) echo '&status='.$inp_status; ?>"
                                class="order-btn">
                                <i class="bi bi-sort-down"></i>
                                <p class="tip"><i class="bi bi-caret-left-fill"></i>Decending Order</i></p>
                            </a>
                        </th>
                        <th scope="col">Designation</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    if($reg_row > 0){
                        while($fetched_rows = mysqli_fetch_assoc($reg_query)){
                            $db_bio = getuser($fetched_rows["user_id"]);
                    ?>
                        <tr>
                            <td>
                                <?php
                                    if(!empty($fetched_rows["user_id"])){
                                        echo $fetched_rows["user_id"];
                                    }else{
                                        echo "<small style='color:#8f8d8dba;'>N/A</small>";
                                    }
                                ?>
                            </td>
                            <td>
                                <div class="user-td">
                                    <span class="pro_pic">
                                        <?php
                                            if(!empty($db_bio['pro_pic'])){
                                                echo "<img src='../$db_bio[pro_pic]' alt='$fetched_rows[name]'>";
                                            }else{
                                                echo "<img src='../images/unknown.png' alt='user'>";
                                            }
                                        ?>
                                    </span>
                                    <span>
                                        <?php
                                            if(!empty($fetched_rows['name'])){
                                                echo $fetched_rows['name'];
                                            }else{
                                                echo "<small style='color:#8f8d8dba;'>N/A</small>";
                                            }
                                        ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <?php
                                    if(!empty($db_bio['current_designation'])){
                                        echo $db_bio['current_designation'];
                                    }else{
                                        echo "<small style='color:#8f8d8dba;'>N/A</small>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if(!empty($fetched_rows['email'])){
                                        echo $fetched_rows['email'];
                                    }else{
                                        echo "<small style='color:#8f8d8dba;'>N/A</small>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if(!empty($fetched_rows['mobile'])){
                                        echo $fetched_rows['mobile'];
                                    }else{
                                        echo "<small style='color:#8f8d8dba;'>N/A</small>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if(!empty($fetched_rows['status'])){
                                        if($fetched_rows['status'] == "active"){
                                            echo "<div style='width:max-content;'><span class='st_act'></span> ".$fetched_rows['status']."</div>";
                                        }else{
                                            echo "<div style='width:max-content;'><span class='st_pen'></span> ".$fetched_rows['status']."</div>";
                                        }
                                    }else{
                                        echo "<small style='color:#8f8d8dba;'>N/A</small>";
                                    }
                                ?>
                            </td>
                            <td class="td-btn-con">
                                <label for="inp-sub-post" class="btn-view-post">
                                    <a href="user-profile.php?pro_id=<?=$fetched_rows['user_id']?>"><i
                                            class="bi bi-eye"></i><span>view</span></a>
                                </label>
                            </td>
                        </tr>
                <?php
                        }
                }else{
                    echo "<tr><td colspan='7'><p class='text-center mb-0'>- No record found -</p></td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../bootstrap-5.0.0-beta2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/nav.js"></script>
    <script>
    $(document).ready(function() {
        $(".order-btn").hover(function() {
            $(this).children(".tip").show();
        }, function() {
            $(this).children(".tip").fadeOut();
        });
        // closing modal on clicking anywhere but modal
        /* $(document).on('hover',function(e){
            if(!(($(e.target).closest(".option-list").length > 0 ) || ($(e.target).closest(".btn-option").length > 0) || ($(e.target).closest("#confirm-delete").length > 0))){
                $(".option-list").removeClass("active-op").slideUp();
            }
        }); */
    });
    </script>
</body>

</html>
<?php
}
?>