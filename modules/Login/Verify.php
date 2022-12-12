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
        
        if($type == "VERIFYUSERNAME")
        {
            $username = $_POST['username'];
            
            $userInfoQuery = "SELECT
                    ID 
                FROM
                    user_mstr 
                WHERE
                    USERNAME = '$username'";
            $userInfoResult = $db_controller->numRows($userInfoQuery);
            if($userInfoResult == 0)
            {
                echo "NotExistingUsername";
            }
            else
            {
                echo "ExisitingUsername";
            }
        }
        
        if($type == "LOGINVERIFY")
        {
            $username = $_POST['username'];
            $password = bin2hex($_POST['password']);
            $brgycode = "";
            $empcode = "";
            $firstname = "";
            $middlename = "";
            $middleinitials = "";
            $lastname = "";
            $suffixname = "";
            $firstlogin = 0;
            $loginattempt = 0;
            $fullname = "";
            $enddate = "";
            $announcementcode = "";
            $title = "";
            $fileupload = "";
            $maxlogscode = 0;
            $logscodeformat = 0;
            $flag = 0;
            $currentdate = date("Y-m-d");
            $createdtime = date("h:i:sa");
            
            $attemptInfoQuery = "SELECT
                    user_mstr.BRGYCODE,
                    user_mstr.EMPCODE,
                    barangay_representative.FIRSTNAME,
                    barangay_representative.MIDDLENAME,
                    barangay_representative.LASTNAME,
                    barangay_representative.SUFFIXNAME,
                    user_mstr.FIRSTLOGIN,
                    MAX( user_mstr.LOGINATTEMPT ) AS TOTALLOGINATTEMPT 
                FROM
                    user_mstr
                    INNER JOIN barangay_representative ON barangay_representative.EMPCODE = user_mstr.EMPCODE 
                WHERE
                    user_mstr.USERNAME = '$username'";
            $attemptInfoResult = $db_controller->runQuery($attemptInfoQuery);
            if($attemptInfoResult != NULL)
            {
                $brgycode = $attemptInfoResult[0]['BRGYCODE'];
                $empcode = $attemptInfoResult[0]['EMPCODE'];
                $firstname = $attemptInfoResult[0]['FIRSTNAME'];
                $middlename = $attemptInfoResult[0]['MIDDLENAME'];
                $lastname = $attemptInfoResult[0]['LASTNAME'];
                $suffixname = $attemptInfoResult[0]['SUFFIXNAME'];
                $firstlogin = $attemptInfoResult[0]['FIRSTLOGIN'];
                $loginattempt = $attemptInfoResult[0]['TOTALLOGINATTEMPT'];
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
                        $fullname = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],01).". ".$lastname;
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
            
            if($firstlogin == 1)
            {
                echo "FirstLogin,".$username;
            }
            else
            {
                if($loginattempt <= 0)
                {
                    echo "AccountBlocked";
                }
                else
                {
                    $userInfoQuery = "SELECT
                            ID 
                        FROM
                            user_mstr 
                        WHERE
                            USERNAME = '$username' 
                            AND PASSWORD = '$password' 
                            AND LOGINATTEMPT <> '0'";
                    $userInfoResult = $db_controller->numRows($userInfoQuery);
                    if($userInfoResult == 0)
                    {
                        $loginattempt -= 1;
                        $userMstrQuery = "UPDATE user_mstr 
                            SET LOGINATTEMPT = '$loginattempt' 
                            WHERE
                                USERNAME = '$username'";
                        $userMstrResult = $db_controller->executeQuery($userMstrQuery);
                        if($userMstrResult)
                        {
                            if($loginattempt <= 0)
                            {
                                echo "AccountBlocked";
                            }
                            else
                            {
                                echo "LoginFailed,".$loginattempt;
                            }
                        }
                    }
                    else
                    {
                        $userMstrQuery = "UPDATE user_mstr 
                            SET LOGINATTEMPT = '5' 
                            WHERE
                                USERNAME = '$username'";
                        $userMstrResult = $db_controller->executeQuery($userMstrQuery);
                        if($userMstrResult)
                        {
                            $announcementMstrQuery = "UPDATE announcement_mstr 
                                SET STATUS = 'EXPIRED' 
                                WHERE
                                    ENDDATE <= '$currentdate'";
                            $announcementMstrResult = $db_controller->executeQuery($announcementMstrQuery);
                            if($announcementMstrResult)
                            {
                                $logsMaxQuery = "SELECT
                                        MAX( SUBSTRING( LOGSCODE, 4 ) ) AS MAX_LOGSCODE 
                                    FROM
                                        logs_mstr 
                                    GROUP BY
                                        LOGSCODE";
                                $logsMaxResult = $db_controller->runQuery($logsMaxQuery);
                                if($logsMaxResult != NULL)
                                {
                                    foreach($logsMaxResult as $logsMaxData)
                                    {
                                        $maxlogscode = $logsMaxData['MAX_LOGSCODE'];
                                    }
                                }
                                
                                $announcementInfoQuery = "SELECT
                                        ANNCODE,
                                        TITLE,
                                        FILE 
                                    FROM
                                        announcement_mstr 
                                    WHERE
                                        UPPER( BRGYCODE ) = '$brgycode' 
                                        AND UPPER( STATUS ) = 'EXPIRED'";
                                $announcementInfoResult = $db_controller->runQuery($announcementInfoQuery);
                                if($announcementInfoResult != NULL)
                                {
                                    foreach($announcementInfoResult as $announcementInfoData)
                                    {
                                        $announcementcode = $announcementInfoData['ANNCODE'];
                                        $title = $announcementInfoData['TITLE'];
                                        $fileupload = $announcementInfoData['FILE'];
                                        
                                        $logscodeformat = "LOG".str_pad(($maxlogscode + 1), 7, "0", STR_PAD_LEFT);
                                        
                                        $notificationMstrQuery = "UPDATE notification_mstr 
                                            SET TAG = '1' 
                                            WHERE
                                                UPPER( BRGYCODE ) = '$brgycode' 
                                                AND UPPER( REFCODE ) = '$announcementcode'";
                                        $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                                        if($notificationMstrResult)
                                        {
                                            $logsQuery = "SELECT
                                                    ID 
                                                FROM
                                                    logs_mstr 
                                                WHERE
                                                    UPPER( BRGYCODE ) = '$brgycode' 
                                                    AND LOGTITLE = '$title' 
                                                    AND UPPER( STATUS ) = 'EXPIRED'";
                                            $logsResult = $db_controller->numRows($logsQuery);
                                            if($logsResult == 0)
                                            {
                                                $logsMstrQuery = "INSERT INTO logs_mstr ( BRGYCODE, LOGSCODE, LOGTITLE, LOGDESC, STATUS, FILE, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                                    VALUES
                                                        (
                                                            '$brgycode',
                                                            '$logscodeformat',
                                                            '$title',
                                                            'Announcement Expired.',
                                                            'EXPIRED',
                                                            '$fileupload',
                                                            'SBADMIN2022-01',
                                                        '$currentdate',
                                                        '$createdtime')";
                                                $logsMstrResult = $db_controller->executeQuery($logsMstrQuery);
                                                if($logsMstrResult)
                                                {
                                                    $flag = 1;
                                                }
                                            }
                                            else
                                            {
                                                $flag = 1;
                                            }
                                        }
                                        
                                        $maxlogscode++;
                                    }
                                }
                                else
                                {
                                    $flag = 1;
                                }
                            }
                        }
                    }
                }
            }
            
            if($flag == 1)
            {
                session_start();
                $_SESSION['logged_brgycode'] = $brgycode;
                $_SESSION['logged_empcode'] = $empcode;
                $_SESSION['logged_name'] = $fullname;
                $_SESSION['logged_username'] = $username;
                echo "LoginSuccess";
            }
        }
    }
    
    $db_controller->closeQuery();
?>