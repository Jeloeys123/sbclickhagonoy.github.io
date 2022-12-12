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
        
        if($type == "VERIFYACCOUNT")
        {
            $brgycode = $_POST['brgycode'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            
            $brgyRepInfoQuery = "SELECT
                    ID 
                FROM
                    barangay_representative 
                WHERE
                    UPPER( BRGYCODE ) = '$brgycode' 
                    AND FIRSTNAME = '$firstname' 
                    AND LASTNAME = '$lastname'";
            $brgyRepInfoResult = $db_controller->numRows($brgyRepInfoQuery);
            if($brgyRepInfoResult == 0)
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