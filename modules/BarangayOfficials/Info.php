<?php
    date_default_timezone_set("Asia/Manila");
    
    $firstname = "";
    $middlename = "";
    $lastname = "";
    $suffixname = "";
    $email = "";
    $mobile = "";
    $brgyOfficialsQuery = "SELECT
            FIRSTNAME,
            MIDDLENAME,
            LASTNAME,
            SUFFIXNAME,
            EMAIL,
            MOBILE 
        FROM
            barangay_officials 
        WHERE
            UPPER( BRGYCODE ) = '$barangaycode' 
            AND UPPER( FIRSTNAME ) = '$fname' 
            AND UPPER( LASTNAME ) = '$lname' 
            AND UPPER( POSITION ) = '$poscode'";
    $brgyOfficialsResult = $db_controller->runQuery($brgyOfficialsQuery);
    if($brgyOfficialsResult != NULL)
    {
        $firstname = $brgyOfficialsResult[0]['FIRSTNAME'];
        $middlename = $brgyOfficialsResult[0]['MIDDLENAME'];
        $lastname = $brgyOfficialsResult[0]['LASTNAME'];
        $suffixname = $brgyOfficialsResult[0]['SUFFIXNAME'];
        $email = $brgyOfficialsResult[0]['EMAIL'];
        $mobile = $brgyOfficialsResult[0]['MOBILE'];
    }
?>