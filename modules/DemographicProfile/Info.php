<?php
    date_default_timezone_set("Asia/Manila");
    
    $housepopulation = "";
    $noofhouseholds = "";
    $avghousehold = "";
    $demographicMstrQuery = "SELECT
            HOUSEHOLD_POPULATION,
            NUMBER_OF_HOUSEHOLDS,
            AVERAGE_HOUSEHOLD 
        FROM
            demographic_mstr 
        WHERE
            UPPER( BRGYCODE ) = '$barangaycode' 
            AND CENSUSYEAR = '$censusyear'";
    $demographicMstrResult = $db_controller->runQuery($demographicMstrQuery);
    if($demographicMstrResult != NULL)
    {
        $housepopulation = $demographicMstrResult[0]['HOUSEHOLD_POPULATION'];
        $noofhouseholds = $demographicMstrResult[0]['NUMBER_OF_HOUSEHOLDS'];
        $avghousehold = $demographicMstrResult[0]['AVERAGE_HOUSEHOLD'];
    }
?>