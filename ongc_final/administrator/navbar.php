<?php
$pagename = $_SESSION["pagename"];
?>
<!-- navbar -->
<nav class="navbar navbar-light bg-light navbar-expand-lg">
    <div class="container-fluid">
        <!-- logo -->
        <a class="navbar-brand" href="dashboard.php">
            <img src="../images/maroon-logo.png" alt="ONGC Logo">
        </a>

        <!-- desktop search bar -->
        <div class="nav-search">
        <form class="">
            <div class="search-bar-form">
                <input class="form-control me-2 search-nav" type="search" placeholder="Search" aria-label="Search">
                <button class="" type="submit"><i class="bi bi-search"></i></button>
                <div class="display-result"></div>
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
                        <input class="form-control me-2 search-nav" type="search" placeholder="Search" aria-label="Search">
                        <button class="" type="submit"><i class="bi bi-search"></i></button>
                        <div class="display-result"></div>
                    </div>
                </form>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?php if($pagename=="homepage") echo "link-active" ?>" data-text="home">
                        <i class="bi bi-house"></i>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="users-data.php" class="nav-link <?php if($pagename=="users_data") echo "link-active" ?>" data-text="users">
                        <i class="bi bi-person-circle"></i>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a href="moderators.php" class="nav-link <?php if($pagename=="moderators") echo "link-active" ?>" data-text="users">
                        <i class="bi bi-person-workspace"></i>
                        moderators
                    </a>
                </li>
                <li class="nav-item">
                    <a href="flagged-post.php" class="nav-link <?php if($pagename=="flagged_post") echo "link-active" ?>" data-text="flagged_post">
                        <i class="bi bi-flag"></i>
                        Flagged Posts
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../logout.php?a=admin" class="nav-link" data-text="logout">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </a>
                </li> 
            </ul>
        </div>
    </div>
</nav>


