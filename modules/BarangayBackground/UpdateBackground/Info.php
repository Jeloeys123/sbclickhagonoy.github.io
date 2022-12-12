<?php
    date_default_timezone_set("Asia/Manila");
    
    $profile = "";
    $email = "";
    $mobile = "";
    $telephone = "";
    $facebook = "";
    $bio = "";
    $brgyProfileQuery = "SELECT
            barangay_mstr.BRGYLOGO,
            barangay_profile.EMAIL,
            barangay_profile.MOBILE,
            barangay_profile.TELEPHONE,
            barangay_profile.BIO,
            barangay_profile.FBLINK 
        FROM
            barangay_profile
            INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = barangay_profile.BRGYCODE 
        WHERE
            UPPER( barangay_profile.BRGYCODE ) = '$barangaycode'";
    $brgyProfileResult = $db_controller->runQuery($brgyProfileQuery);
    if($brgyProfileResult != NULL)
    {
        $profile = $brgyProfileResult[0]['BRGYLOGO'];
        $email = $brgyProfileResult[0]['EMAIL'];
        $mobile = $brgyProfileResult[0]['MOBILE'];
        $telephone = $brgyProfileResult[0]['TELEPHONE'];
        $bio = $brgyProfileResult[0]['BIO'];
        $facebook = $brgyProfileResult[0]['FBLINK'];
    }
?>