<?php
    date_default_timezone_set("Asia/Manila");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
    $db_controller = new DBController();
    include $common_path."session_logged.php";
    $barangaycode = $_SESSION['logged_brgycode'];
    
    if(isset($_POST['type']))
    {
        $type = $_POST['type'];
        
        if($type == "VERIFYDEMOGRAPHICDATA")
        {
            $censusyear = $_POST['censusyear'];
            
            $demographicMstrQuery = "SELECT
                    ID 
                FROM
                    demographic_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode' 
                    AND CENSUSYEAR = '$censusyear'";
            $demographicMstrResult = $db_controller->numRows($demographicMstrQuery);
            if($demographicMstrResult == 0)
            {
                echo "RecordNotFound";
            }
            else
            {
                echo "RecordDuplicate";
            }
        }
    }
    
    $db_controller->closeQuery();
?>