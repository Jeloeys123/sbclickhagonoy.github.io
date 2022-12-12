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
    $barangaycode = $_SESSION['logged_brgycode'];
    
    if(isset($_POST['type']))
    {
        $type = $_POST['type'];
        
        if($type == "UPDATENOTIFICATION")
        {
            $notifcode = $_POST['id'];
            $refcode = "";
            $refno = "";
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $notificationMstrQuery = "UPDATE notification_mstr 
                SET TAG = '1',
                UPDATEDBY = '$username',
                UPDATEDDATE = '$updateddate',
                UPDATEDTIME = '$updatedtime' 
                WHERE
                    UPPER( NOTIFCODE ) = '$notifcode' 
                    AND UPPER( BRGYCODE ) = '$barangaycode'";
            $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
            if($notificationMstrResult)
            {
                $notifInfoQuery = "SELECT
                        UPPER( SUBSTRING( REFCODE, 1, 1 ) ) AS REFCODE,
                        UPPER( REFCODE ) AS REFNO 
                    FROM
                        notification_mstr 
                    WHERE
                        UPPER( NOTIFCODE ) = '$notifcode' 
                        AND UPPER( BRGYCODE ) = '$barangaycode' 
                        AND TAG = '1'";
                $notifInfoResult = $db_controller->runQuery($notifInfoQuery);
                if($notifInfoResult != NULL)
                {
                    $refcode = $notifInfoResult[0]['REFCODE'];
                    $refno = $notifInfoResult[0]['REFNO'];
                    
                    echo $refcode.",".$refno;
                }
            }
        }
    }
    
    $db_controller->closeQuery();
?>