<?php
$user_id = $_SESSION["user_id"];
$username = $_SESSION["name"];
# for displaying first name in navbar using session 
$name_exp = explode(" ", $username);
$first_name = $name_exp[0];
$last_name = $name_exp[1];
?>
<!-- navbar -->
<nav class="navbar navbar-light bg-light navbar-expand-lg">
    <div class="container-fluid">
        <!-- logo -->
        <a class="navbar-brand" href="homepage.php">
            <img src="images/maroon-logo.png" alt="ONGC Logo">
        </a>

        <!-- desktop search bar -->
        <div class="nav-search">
        <form class="">
            <div class="search-bar-form">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
        </div>

        <!-- menu button -->
        <button type="button" class="navbar-toggler"><span class="menu-icon"></span></button>

        <!-- collapsing menu -->
        <div class="collapse-menu">
            <ul class="navbar-nav gx-5">
                <!-- search bar for mob view -->
                <li class="nav-item nav-ham-search">
                <form class="">
                    <div class="search-bar-form">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                </li>
                <li class="nav-item">
                    <a href="homepage.php" class="nav-link <?php if($pagename=="homepage") echo "link-active" ?>" data-text="home">
                        <i class="bi bi-house"></i>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="profile.php?pro_id=<?=$user_id?>" class="nav-link <?php if($pagename=="profile" && $user_id == $pro_id) echo "link-active" ?>" data-text="profile">
                        <i class="bi bi-person-circle"></i>
                        <?php if(!empty($first_name)){
                            echo $first_name;
                        }else{
                            echo "Profile";
                        } ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php if($pagename=="settings") echo "link-active" ?>" data-text="settings">
                        <i class="bi bi-gear"></i>
                        Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php?a=user" class="nav-link" data-text="logout">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </a>
                </li> 
            </ul>
        </div>
    </div>
</nav>


