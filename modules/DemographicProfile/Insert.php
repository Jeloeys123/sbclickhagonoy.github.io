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
        
        if($type == "CREATEDEMOGRAPHIC")
        {
            $censusyear = $_POST['censusyear'];
            $housepopulation = $_POST['housepopulation'];
            $noofhouseholds = $_POST['noofhouseholds'];
            $avghousehold = $_POST['avghousehold'];
            $createddate = date("Y-m-d");
            $createdtime = date("h:i:sa");
            
            $demographicMstrQuery = "INSERT INTO demographic_mstr ( BRGYCODE, CENSUSYEAR, HOUSEHOLD_POPULATION, NUMBER_OF_HOUSEHOLDS, AVERAGE_HOUSEHOLD, CREATEDBY, CREATEDDATE, CREATEDTIME )
                VALUES
                    (
                        '$barangaycode',
                        '$censusyear',
                        '$housepopulation',
                        '$noofhouseholds',
                        '$avghousehold',
                        '$username',
                    '$createddate',
                    '$createdtime')";
            $demographicMstrResult = $db_controller->executeQuery($demographicMstrQuery);
            if($demographicMstrResult)
            {
                echo "RecordSaved";
            }
        }
        
        if($type == "DELETEDEMOGRPAHIC")
        {
            $censusyear = $_POST['censusyear'];
            
            $demographicMstrQuery = "DELETE 
                FROM
                    demographic_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode' 
                    AND CENSUSYEAR = '$censusyear'";
            $demographicMstrResult = $db_controller->executeQuery($demographicMstrQuery);
            if($demographicMstrResult)
            {
                echo "RecordDeleted";
            }
        }
        
        if($type == "UPDATEDEMOGRAPHIC")
        {
            $censusyear = $_POST['censusyear'];
            $housepopulation = $_POST['housepopulation'];
            $noofhouseholds = $_POST['noofhouseholds'];
            $avghousehold = $_POST['avghousehold'];
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $demographicMstrQuery = "UPDATE demographic_mstr 
                SET HOUSEHOLD_POPULATION = '$housepopulation',
                NUMBER_OF_HOUSEHOLDS = '$noofhouseholds',
                AVERAGE_HOUSEHOLD = '$avghousehold',
                UPDATEDBY = '$username',
                UPDATEDDATE = '$updateddate',
                UPDATEDTIME = '$updatedtime' 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode' 
                    AND CENSUSYEAR = '$censusyear'";
            $demographicMstrResult = $db_controller->executeQuery($demographicMstrQuery);
            if($demographicMstrResult)
            {
                echo "RecordSaved";
            }
        }
    }
    
    $db_controller->closeQuery();
?>