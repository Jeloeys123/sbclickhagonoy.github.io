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
        
        if($type == "APPROVEDORDINANCEINFO")
        {
            $brgycode = $_POST['brgycode'];
            $ordinancecode = $_POST['ordinancecode'];
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $ordinanceMstrQuery = "UPDATE ordinance_mstr 
                SET STATUS = 'APPROVED' 
                WHERE
                    UPPER( BRGYCODE ) = '$brgycode' 
                    AND UPPER( ORDCODE ) = '$ordinancecode'";
            $ordinanceMstrResult = $db_controller->executeQuery($ordinanceMstrQuery);
            if($ordinanceMstrResult)
            {
                echo "RecordSaved";
            }
        }
        
        if($type == "REJECTEDORDINANCEINFO")
        {
            $brgycode = $_POST['brgycode'];
            $ordinancecode = $_POST['ordinancecode'];
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $ordinanceMstrQuery = "UPDATE ordinance_mstr 
                SET STATUS = 'REJECTED' 
                WHERE
                    UPPER( BRGYCODE ) = '$brgycode' 
                    AND UPPER( ORDCODE ) = '$ordinancecode'";
            $ordinanceMstrResult = $db_controller->executeQuery($ordinanceMstrQuery);
            if($ordinanceMstrResult)
            {
                echo "RecordSaved";
            }
        }
        
        if($type == "REVISEDORDINANCEINFO")
        {
            $brgycode = $_POST['brgycode'];
            $ordinancecode = $_POST['ordinancecode'];
            $reason = $_POST['reason'];
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $ordinanceMstrQuery = "UPDATE ordinance_mstr 
                SET STATUS = 'PENDING',
                REMARKS = '$reason' 
                WHERE
                    UPPER( BRGYCODE ) = '$brgycode' 
                    AND UPPER( ORDCODE ) = '$ordinancecode'";
            $ordinanceMstrResult = $db_controller->executeQuery($ordinanceMstrQuery);
            if($ordinanceMstrResult)
            {
                echo "RecordSaved";
            }
        }
    }
    
    $db_controller->closeQuery();
?>