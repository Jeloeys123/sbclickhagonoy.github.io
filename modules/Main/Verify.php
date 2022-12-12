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
        
        if($type == "SHOWGRAPH")
        {
            $brgycode = $_GET['id'];
            $householdpop = 0;
            $numofhousehold = 0;
            $householdpoplabel = array();
            $householdpoptotal = array();
            $numofhouseholdtotal = array();
            $demographic_arr = array();
            $demographicMstrQuery = "SELECT
                    CENSUSYEAR,
                    HOUSEHOLD_POPULATION,
                    NUMBER_OF_HOUSEHOLDS 
                FROM
                    ( SELECT CENSUSYEAR, HOUSEHOLD_POPULATION, NUMBER_OF_HOUSEHOLDS FROM demographic_mstr WHERE UPPER( BRGYCODE ) = '$brgycode' ORDER BY CENSUSYEAR DESC ) AS TBLDEMOGRAPHIC 
                ORDER BY
                    CENSUSYEAR 
                    LIMIT 5";
            $demographicMstrResult = $db_controller->runQuery($demographicMstrQuery);
            if($demographicMstrResult != NULL)
            {
                foreach($demographicMstrResult as $demographicMstrData)
                {
                    $censusyear = $demographicMstrData['CENSUSYEAR'];
                    $householdpop = $demographicMstrData['HOUSEHOLD_POPULATION'];
                    $numofhousehold = $demographicMstrData['NUMBER_OF_HOUSEHOLDS'];
                    
                    array_push($householdpoplabel, $censusyear);
					array_push($householdpoptotal, $householdpop);
					array_push($numofhouseholdtotal, $numofhousehold);
                }
            }
            
            $demographic_arr[] = array(
                "HOUSEHOLDPOPULATIONYEAR" => $householdpoplabel,
                "HOUSEHOLDPOPULATIONDATA" => $householdpoptotal,
                "NUMOFHOUSEHOLDDATA" => $numofhouseholdtotal
            );
            
            echo json_encode($demographic_arr);
        }
    }
    
    $db_controller->closeQuery();
?>