<?php
    date_default_timezone_set("Asia/Manila");
    
    $barangaycode = "";
    $brgyname = "";
    $brgylogo = "";
    $accountcode = "";
    $firstname = "";
    $middlename = "";
    $middleinitials = "";
    $lastname = "";
    $suffixname = "";
    $gender = "";
    $email = "";
    $mobile = "";
    $position = "";
    $address = "";
    $brgyemail = "";
    $brgymobile = "";
    $brgytelephone = "";
    $representative = "";
    $brgyRepresentativeQuery = "SELECT
            barangay_representative.BRGYCODE,
            barangay_mstr.BRGYNAME,
            barangay_mstr.BRGYLOGO,
            barangay_representative.ACCCODE,
            barangay_representative.FIRSTNAME,
            barangay_representative.MIDDLENAME,
            barangay_representative.LASTNAME,
            barangay_representative.SUFFIXNAME,
            barangay_representative.GENDER,
            barangay_representative.EMAIL,
            barangay_representative.MOBILE,
            barangay_representative.POSITION,
            barangay_representative.ADDRESS,
            barangay_profile.EMAIL AS BRGYEMAIL,
            barangay_profile.MOBILE AS BRGYMOBILE,
            barangay_profile.TELEPHONE AS BRGYTELEPHONE 
        FROM
            barangay_representative
            INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = barangay_representative.BRGYCODE
            LEFT JOIN barangay_profile ON barangay_profile.BRGYCODE = barangay_representative.BRGYCODE 
        WHERE
            barangay_representative.EMPCODE = '$employeecode'";
    $brgyRepresentativeResult = $db_controller->runQuery($brgyRepresentativeQuery);
    if($brgyRepresentativeResult != NULL)
    {
        $barangaycode = $brgyRepresentativeResult[0]['BRGYCODE'];
        $brgyname = $brgyRepresentativeResult[0]['BRGYNAME'];
        $brgylogo = $brgyRepresentativeResult[0]['BRGYLOGO'];
        $accountcode = $brgyRepresentativeResult[0]['ACCCODE'];
        $firstname = $brgyRepresentativeResult[0]['FIRSTNAME'];
        $middlename = $brgyRepresentativeResult[0]['MIDDLENAME'];
        $lastname = $brgyRepresentativeResult[0]['LASTNAME'];
        $suffixname = $brgyRepresentativeResult[0]['SUFFIXNAME'];
        $gender = $brgyRepresentativeResult[0]['GENDER'];
        $email = $brgyRepresentativeResult[0]['EMAIL'];
        $mobile = $brgyRepresentativeResult[0]['MOBILE'];
        $position = $brgyRepresentativeResult[0]['POSITION'];
        $address = $brgyRepresentativeResult[0]['ADDRESS'];
        $brgyemail = $brgyRepresentativeResult[0]['BRGYEMAIL'];
        $brgymobile = $brgyRepresentativeResult[0]['BRGYMOBILE'];
        $brgytelephone = $brgyRepresentativeResult[0]['BRGYTELEPHONE'];
    }
    
    if($suffixname == "")
    {
        if($middlename == "")
        {
            $representative = $firstname." ".$lastname;
        }
        else
        {
            $middleinitials = explode(" ",$middlename);
            if(sizeof($middleinitials) == 2)
            {
                $representative = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],0,1).". ".$lastname;
            }
            else
            {
                $representative = $firstname." ".substr($middleinitials[0],0,1).". ".$lastname;
            }
        }
    }
    else
    {
        if($middlename == "")
        {
            $representative = $firstname." ".$lastname.", ".$suffixname;
        }
        else
        {
            $middleinitials = explode(" ",$middlename);
            if(sizeof($middleinitials) == 2)
            {
                $representative = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],0,1).". ".$lastname.", ".$suffixname;
            }
            else
            {
                $representative = $firstname." ".substr($middleinitials[0],0,1).". ".$lastname.", ".$suffixname;
            }
        }
    }
?>