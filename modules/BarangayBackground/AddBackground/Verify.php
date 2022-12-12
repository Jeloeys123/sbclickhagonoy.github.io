<?php
    date_default_timezone_set("Asia/Manila");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
    $db_controller = new DBController();
    
    if(isset($_POST['type']))
    {
        $type = $_POST['type'];
        
        if($type == "VERIFYBARANGAYPROFILE")
        {
            $brgycode = $_POST['brgycode'];
            
            $brgyProfileQuery = "SELECT
                    ID 
                FROM
                    barangay_profile 
                WHERE
                    UPPER( BRGYCODE ) = '$brgycode'";
            $brgyProfileResult = $db_controller->numRows($brgyProfileQuery);
            if($brgyProfileResult == 0)
            {
                echo "RecordNotExist";
            }
            else
            {
                echo "RecordExist";
            }
        }
    }
    
    $db_controller->closeQuery();
?>