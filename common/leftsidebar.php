<?php
    $username = $_SESSION['logged_username'];
    $empcode = $_SESSION['logged_empcode'];
    $usertype = "";
    
    $userMstrQuery = "SELECT
            USERTYPE 
        FROM
            user_mstr 
        WHERE
            USERNAME = '$username'";
    $userMstrResult = $db_controller->runQuery($userMstrQuery);
    if($userMstrResult != NULL)
    {
        $usertype = $userMstrResult[0]['USERTYPE'];
    }
?>
<!-- ========== Left Sidebar Start ========== -->
<div class = "leftside-menu">
    <!-- LOGO -->
    <a href = "main-page" class = "logo text-center logo-light">
        <span class = "logo-lg">
            <img src = "assets/images/barangay/SystemLogo.png" alt = "" height = "125">
        </span>
        <span class = "logo-sm">
            <img src = "assets/images/barangay/SystemLogo.png" alt = "" height = "125">
        </span>
    </a>
    <!-- LOGO -->
    <a href = "main-page" class = "logo text-center logo-dark">
        <span class = "logo-lg">
            <img src = "assets/images/barangay/SystemLogo.png" alt = "" height = "125">
        </span>
        <span class = "logo-sm">
            <img src = "assets/images/barangay/SystemLogo.png" alt = "" height = "125">
        </span>
    </a>
    <br>
    <br>
    <div class = "h-100" id = "leftside-menu-container" data-simplebar = "">
        <!--- Sidemenu -->
        <?php
            if($usertype == "ADM")
            {
        ?>
                <ul class = "side-nav">
                    <li class = "side-nav-title side-nav-item"> Navigation </li>
                    <li class = "side-nav-item">
                        <a href = "main-page" class = "side-nav-link active">
                            <i class = "uil-home"> </i>
                            <span> Home </span>
                        </a>
                    </li>
                    <li class = "side-nav-item">
                        <a href = "announcement-main" class = "side-nav-link">
                            <i class = "uil-comment-alt-message"> </i>
                            <span> Announcement </span>
                        </a>
                    </li>
                    <li class = "side-nav-item">
                        <a href = "manage-barangay-main" class = "side-nav-link">
                            <i class = "uil-comment-alt-message"> </i>
                            <span> Barangay Master List </span>
                        </a>
                    </li>
                    <li class = "side-nav-item">
                        <a data-bs-toggle = "collapse" href = "#sidebarManageUser" aria-expanded = "false" aria-controls = "sidebarManageUser" class = "side-nav-link">
                            <i class = "uil-store"> </i>
                            <span> Manage User </span>
                            <span class = "menu-arrow"></span>
                        </a>
                        <div class = "collapse" id = "sidebarManageUser">
                            <ul class = "side-nav-second-level">
                                <li>
                                    <a href = "manage-user-addmain"> Add User </a>
                                    <a href = "manage-user-updatemain"> Update User </a>
                                    <a href = "manage-user-viewmain"> User Master List </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class = "side-nav-item">
                        <a data-bs-toggle = "collapse" href = "#sidebarOrdinance" aria-expanded = "false" aria-controls = "sidebarOrdinance" class = "side-nav-link">
                            <i class = "uil-store"> </i>
                            <span> Ordinance </span>
                            <span class = "menu-arrow"></span>
                        </a>
                        <div class = "collapse" id = "sidebarOrdinance">
                            <ul class = "side-nav-second-level">
                                <li>
                                    <a href = "approved-ordinance-main"> Approved Ordinance </a>
                                    <a href = "rejected-ordinance-main"> Disapproved Ordinance </a>
                                    <a href = "pending-ordinance-main"> Pending Ordinances </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
        <?php
            }
            else
            {
        ?>
                <ul class = "side-nav">
                    <li class = "side-nav-title side-nav-item"> Navigation </li>
                    <li class = "side-nav-item">
                        <a href = "main-page" class = "side-nav-link active">
                            <i class = "uil-home"> </i>
                            <span> Home </span>
                        </a>
                    </li>
                    <li class = "side-nav-item">
                        <a data-bs-toggle = "collapse" href = "#sidebarBarangayBackground" aria-expanded = "false" aria-controls = "sidebarBarangayBackground" class = "side-nav-link">
                            <i class = "uil-store"> </i>
                            <span> Barangay Background </span>
                            <span class = "menu-arrow"></span>
                        </a>
                        <div class = "collapse" id = "sidebarBarangayBackground">
                            <ul class = "side-nav-second-level">
                                <li>
                                    <a href = "barangay-background-addmain"> Add Background </a>
                                    <a href = "barangay-background-updatemain"> Update Background </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class = "side-nav-item">
                        <a href = "barangay-officials-main" class = "side-nav-link">
                            <i class = "uil-comment-alt-message"> </i>
                            <span> Barangay Officials </span>
                        </a>
                    </li>
                    <li class = "side-nav-item">
                        <a href = "demographic-profile-main" class = "side-nav-link">
                            <i class = "uil-comment-alt-message"> </i>
                            <span> Demographic Profile </span>
                        </a>
                    </li>
                    <li class = "side-nav-item">
                        <a href = "activity-log-main" class = "side-nav-link">
                            <i class = "uil-calender"> </i>
                            <span> Activity Log </span>
                        </a>
                    </li>
                    <li class = "side-nav-item">
                        <a href = "barangay-ordinance-main" class = "side-nav-link">
                            <i class = "uil-calender"> </i>
                            <span> Ordinance </span>
                        </a>
                    </li>
                </ul>
        <?php
            }
        ?>
        <div class = "clearfix"> </div>
    </div>
</div>