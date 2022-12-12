<?php
    $username = $_SESSION['logged_username'];
    $barangaycode = $_SESSION['logged_brgycode'];
    $usertype = "";
    $brgyname = "";
    $brgylogo = "";
    $updatedtime = date("h:i:sa");
    
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
        
        if($usertype == "ADM")
        {
            $usertype = "Administrator";
        }
        else
        {
            $usertype = "User";
        }
    }
    
    $notificationCountQuery = "SELECT
            ID 
        FROM
            notification_mstr 
        WHERE
            UPPER( BRGYCODE ) = '$barangaycode' 
            AND TAG = 0 
        GROUP BY
            NOTIFCODE,
            BRGYCODE";
    $notificationCountResult = $db_controller->numRows($notificationCountQuery);
    
    $barangayMstrQuery = "SELECT
            BRGYNAME,
            BRGYLOGO 
        FROM
            barangay_mstr 
        WHERE
            UPPER( BRGYCODE ) = '$barangaycode'";
    $barangayMstrResult = $db_controller->runQuery($barangayMstrQuery);
    if($barangayMstrResult != NULL)
    {
        $brgyname = $barangayMstrResult[0]['BRGYNAME'];
        $brgylogo = $barangayMstrResult[0]['BRGYLOGO'];
    }
?>
<!-- Topbar Start -->
<div class = "navbar-custom">
    <ul class = "list-unstyled topbar-menu float-end mb-0">
        <li class = "dropdown notification-list d-lg-none">
            <a class = "nav-link dropdown-toggle arrow-none" data-bs-toggle = "dropdown" href = "#" role = "button" aria-haspopup = "false" aria-expanded = "false">
                <i class = "dripicons-search noti-icon"> </i>
            </a>
            <div class = "dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                <form class = "p-3">
                    <input type = "text" class = "form-control" placeholder = "Search ..." aria-label = "Recipient's username">
                </form>
            </div>
        </li>
        <li class = "dropdown notification-list">
            <a class = "nav-link dropdown-toggle arrow-none" data-bs-toggle = "dropdown" href = "#" role = "button" aria-haspopup = "false" aria-expanded = "false">
                <i class = "dripicons-bell noti-icon"> </i>
                <?php
                    if($notificationCountResult > 0)
                    {
                        echo '
                            <span class = "noti-icon-badge"> </span>
                        ';
                    }
                ?>
            </a>
            <div class = "dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">
                <!-- Item-->
                <div class = "dropdown-item noti-title">
                    <h5 class = "m-0">
                        <span class = "float-end">
                            <a href = "javascript: void(0);" class = "text-dark">
                                <small> Clear All </small>
                            </a>
                        </span> Notification
                    </h5>
                </div>
                <div style = "max-height: 230px;" data-simplebar = "">
                    <?php
                        $notificationMstrQuery = "SELECT
                                NOTIFCODE,
                                ICON,
                                MESSAGE 
                            FROM
                                notification_mstr 
                            WHERE
                                UPPER( BRGYCODE ) = '$barangaycode' 
                                AND TAG = 0 
                            GROUP BY
                                NOTIFCODE,
                                BRGYCODE 
                            ORDER BY
                                CREATEDDATE DESC,
                                CREATEDTIME DESC";
                        $notificationMstrResult = $db_controller->runQuery($notificationMstrQuery);
                        if($notificationMstrResult != NULL)
                        {
                            foreach($notificationMstrResult as $notificationMstrData)
                            {
                                echo '
                                    <a href = "#" class = "dropdown-item notify-item isBtnNotif" id = "'.$notificationMstrData['NOTIFCODE'].'">
                                        <div class = "notify-icon bg-primary">
                                            <i class = "'.$notificationMstrData['ICON'].'"> </i>
                                        </div>
                                        <p class = "notify-details">'
                                            .$notificationMstrData['MESSAGE'].'
                                        </p>
                                    </a>
                                ';
                            }
                        }
                    ?>
                </div>
                <?php
                    if($notificationCountResult > 0)
                    {
                        echo '
                            <a href = "javascript:void(0);" class = "dropdown-item text-center text-primary notify-item notify-all">
                                View All
                            </a>
                        ';
                    }
                ?>
            </div>
        </li>
        <li class = "notification-list">
            <a class = "nav-link end-bar-toggle" href = "javascript: void(0);">
                <i class = "dripicons-gear noti-icon"> </i>
            </a>
        </li>
        <li class = "dropdown notification-list">
            <a class = "nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle = "dropdown" hrefrole = "button" aria-haspopup = "false" aria-expanded = "false">
                <span class = "account-user-avatar"> 
                    <?php
                        if($usertype == "Administrator")
                        {
                            echo '
                                <img src = "assets/images/barangay/Hagonoy.png" alt = "user-image" class = "rounded-circle">
                            ';
                        }
                        else
                        {
                            echo '
                                <img src = "assets/images/barangay/'.$brgylogo.'" alt = "user-image" class = "rounded-circle">
                            ';
                        }
                    ?>
                </span>
                <span>
                    <span class = "account-user-name"> <?php echo $_SESSION['logged_name'] ?> </span>
                    <span class = "account-position"> <?php echo $usertype ?> </span>
                </span>
            </a>
            <div class = "dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                <div class = " dropdown-header noti-title">
                    <h6 class = "text-overflow m-0">Welcome !</h6>
                </div>
                <a href = "signout" class = "dropdown-item notify-item">
                    <i class = "mdi mdi-logout me-1"> </i>
                    <span> Logout </span>
                </a>
            </div>
        </li>
    </ul>
    <button class = "button-menu-mobile open-left">
        <i class = "mdi mdi-menu"></i>
    </button>     
</div>
<!-- End Topbar -->