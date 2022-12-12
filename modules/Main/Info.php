<?php
    date_default_timezone_set("Asia/Manila");
    
    $barangayname = "";
    $location = "";
    $logo = "";
    $barangayMstrQuery = "SELECT
            BRGYNAME,
            BRGYLOCATION,
            BRGYLOGO 
        FROM
            barangay_mstr 
        WHERE
            UPPER( BRGYCODE ) = '$brgycode'";
    $barangayMstrResult = $db_controller->runQuery($barangayMstrQuery);
    if($barangayMstrResult != NULL)
    {
        $barangayname = $barangayMstrResult[0]['BRGYNAME'];
        $location = $barangayMstrResult[0]['BRGYLOCATION'];
        $logo = $barangayMstrResult[0]['BRGYLOGO'];
    }
    
    $firstname = "";
    $middlename = "";
    $middleinitials = "";
    $lastname = "";
    $suffixname = "";
    $fullname = "";
    $brgyRepresentativeQuery = "SELECT
            FIRSTNAME,
            MIDDLENAME,
            LASTNAME,
            SUFFIXNAME 
        FROM
            barangay_representative 
        WHERE
            UPPER( BRGYCODE ) = '$brgycode' 
            AND UPPER( STATUS ) = 'ACTIVE'";
    $brgyRepresentativeResult = $db_controller->runQuery($brgyRepresentativeQuery);
    if($brgyRepresentativeResult != NULL)
    {
        $firstname = $brgyRepresentativeResult[0]['FIRSTNAME'];
        $middlename = $brgyRepresentativeResult[0]['MIDDLENAME'];
        $lastname = $brgyRepresentativeResult[0]['LASTNAME'];
        $suffixname = $brgyRepresentativeResult[0]['SUFFIXNAME'];
    }
    
    if($suffixname == "")
    {
        if($middlename == "")
        {
            $fullname = $firstname." ".$lastname;
        }
        else
        {
            $middleinitials = explode(" ",$middlename);
            if(sizeof($middleinitials) == 2)
            {
                $fullname = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],0,1).". ".$lastname;
            }
            else
            {
                $fullname = $firstname." ".substr($middleinitials[0],0,1).". ".$lastname;
            }
        }
    }
    else
    {
        if($middlename == "")
        {
            $fullname = $firstname." ".$lastname.", ".$suffixname;
        }
        else
        {
            $middleinitials = explode(" ",$middlename);
            if(sizeof($middleinitials) == 2)
            {
                $fullname = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],0,1).". ".$lastname.", ".$suffixname;
            }
            else
            {
                $fullname = $firstname." ".substr($middleinitials[0],0,1).". ".$lastname.", ".$suffixname;
            }
        }
    }
    
    $email = "";
    $mobile = "";
    $telephone = "";
    $bio = "";
    $facebook = "";
    $brgyProfileQuery = "SELECT
            EMAIL,
            MOBILE,
            TELEPHONE,
            BIO,
            FBLINK 
        FROM
            barangay_profile 
        WHERE
            UPPER( BRGYCODE ) = '$brgycode'";
    $brgyProfileResult = $db_controller->runQuery($brgyProfileQuery);
    if($brgyProfileResult != NULL)
    {
        $email = $brgyProfileResult[0]['EMAIL'];
        $mobile = $brgyProfileResult[0]['MOBILE'];
        $telephone = $brgyProfileResult[0]['TELEPHONE'];
        $bio = $brgyProfileResult[0]['BIO'];
        $facebook = $brgyProfileResult[0]['FBLINK'];
    }
?>