<?php
    date_default_timezone_set("Asia/Manila");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
    $db_controller = new DBController();
    include $common_path."session_logged.php";
    $username = $_SESSION['logged_username'];
    
    if(isset($_POST['type']))
    {
        $type = $_POST['type'];
        
        if($type == "UPDATEBARANGAYPROFILE")
        {
            $brgycode = $_POST['brgycode'];
            $profile = $_POST['profile'];
            $email = str_replace("'","\'",$_POST['email']);
            $mobile = $_POST['mobile'];
            $telephone = $_POST['telephone'];
            $facebook = $_POST['facebook'];
            $bio = str_replace("'","\'",$_POST['bio']);
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $brgyProfileQuery = "UPDATE barangay_profile 
                SET EMAIL = '$email',
                MOBILE = '$mobile',
                TELEPHONE = '$telephone',
                BIO = '$bio',
                FBLINK = '$facebook',
                UPDATEDBY = '$username',
                UPDATEDDATE = '$updateddate',
                UPDATEDTIME = '$updatedtime' 
                WHERE
                    UPPER( BRGYCODE ) = '$brgycode'";
            $brgyProfileResult = $db_controller->executeQuery($brgyProfileQuery);
            if($brgyProfileResult)
            {
                if($profile == "")
                {
                    echo "RecordSaved";
                }
                else
                {
                    $brgyMstrQuery = "UPDATE barangay_mstr 
                        SET BRGYLOGO = '$profile',
                        UPDATEDBY = '$username',
                        UPDATEDDATE = '$updateddate',
                        UPDATEDTIME = '$updatedtime' 
                        WHERE
                            UPPER( BRGYCODE ) = '$brgycode'";
                    $brgyMstrResult = $db_controller->executeQuery($brgyMstrQuery);
                    if($brgyMstrResult)
                    {
                        echo "RecordSaved";
                    }
                }
            }
        }
    }
    
    $db_controller->closeQuery();
?>