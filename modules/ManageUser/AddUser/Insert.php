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
    
    if(isset($_POST['type']))
    {
        $type = $_POST['type'];
        
        if($type == "ADDACCOUNT")
        {
            $brgycode = $_POST['brgycode'];
            $firstname = str_replace("'","\'",$_POST['firstname']);
            $middlename = str_replace("'","\'",$_POST['middlename']);
            $lastname = str_replace("'","\'",$_POST['lastname']);
            $suffixname = str_replace("'","\'",$_POST['suffixname']);
            $gender = $_POST['gender'];
            $email = str_replace("'","\'",$_POST['email']);
            $mobile = $_POST['mobile'];
            $position = str_replace("'","\'",$_POST['position']);
            $address = str_replace("'","\'",$_POST['address']);
            $brgyaccountcode = "";
            $accountcode = 0;
            $employeeinfo = "";
            $employeeval = 0;
            $empcode = "";
            $password = "";
            $notificationcode = 0;
            $notifcode = 0;
            $emptemplate = "";
            $currentyear = date("Y");
            $createddate = date("Y-m-d");
            $createdtime = date("h:i:sa");
            
            $accountInfoQuery = "SELECT
                    MAX( SUBSTRING( ACCCODE, 4, 11 ) ) AS ACCOUNTCODE 
                FROM
                    barangay_representative 
                GROUP BY
                    ACCCODE";
            $accountInfoResult = $db_controller->runQuery($accountInfoQuery);
            if($accountInfoResult != NULL)
            {
                foreach($accountInfoResult as $accountInfoData)
                {
                    $brgyaccountcode = $accountInfoData['ACCOUNTCODE'];
                }
            }
            
            $empInfoQuery = "SELECT
                    MAX( barangay_representative.EMPCODE ) AS EMPCODE,
                    barangay_mstr.EMPTEMPLATE 
                FROM
                    barangay_mstr
                    LEFT JOIN barangay_representative ON barangay_representative.BRGYCODE = barangay_mstr.BRGYCODE 
                WHERE
                    UPPER( barangay_mstr.BRGYCODE ) = '$brgycode'";
            $empInfoResult = $db_controller->runQuery($empInfoQuery);
            if($empInfoResult != NULL)
            {
                $employeeinfo = $empInfoResult[0]['EMPCODE'];
                $emptemplate = $empInfoResult[0]['EMPTEMPLATE'];
            }
            
            $notifInfoQuery = "SELECT
                    MAX( SUBSTRING( NOTIFCODE, 4, 11 ) ) AS NOTIFICATIONCODE 
                FROM
                    notification_mstr 
                GROUP BY
                    NOTIFCODE";
            $notifInfoResult = $db_controller->runQuery($notifInfoQuery);
            if($notifInfoResult != NULL)
            {
                foreach($notifInfoResult as $notifInfoData)
                {
                    $notificationcode = $notifInfoData['NOTIFICATIONCODE'];
                }
            }
            
            $employeeval = explode("-", $employeeinfo);
            if(!isset($employeeval[1]))
            {
                $employeeval[1] = 0;
            }
            
            $accountcode = "ACC".str_pad(($brgyaccountcode+1),7,"0",STR_PAD_LEFT);
            $empcode = $emptemplate."".$currentyear."-".str_pad(($employeeval[1] + 1),2,"0",STR_PAD_LEFT);
            $notifcode = "NTF".str_pad(($notificationcode+1),7,"0",STR_PAD_LEFT);
            $password = bin2hex($empcode);
            
            $barangayRepresentativeQuery = "INSERT INTO barangay_representative (
                    ACCCODE,
                    BRGYCODE,
                    EMPCODE,
                    FIRSTNAME,
                    MIDDLENAME,
                    LASTNAME,
                    SUFFIXNAME,
                    GENDER,
                    EMAIL,
                    MOBILE,
                    POSITION,
                    ADDRESS,
                    STARTDATE,
                    STATUS,
                    CREATEDBY,
                    CREATEDDATE,
                    CREATEDTIME 
                )
                VALUES
                    (
                        '$accountcode',
                        '$brgycode',
                        '$empcode',
                        '$firstname',
                        '$middlename',
                        '$lastname',
                        '$suffixname',
                        '$gender',
                        '$email',
                        '$mobile',
                        '$position',
                        '$address',
                        '$createddate',
                        'ACTIVE',
                        '$username',
                    '$createddate',
                    '$createdtime')";
            $barangayRepresentativeResult = $db_controller->executeQuery($barangayRepresentativeQuery);
            if($barangayRepresentativeResult)
            {
                $userMstrQuery = "INSERT INTO user_mstr ( BRGYCODE, EMPCODE, USERNAME, PASSWORD, USERTYPE, FIRSTLOGIN, LOGINATTEMPT, STATUS, CREATEDBY, CREATEDDATE, CREATEDTIME )
                    VALUES
                        (
                            '$brgycode',
                            '$empcode',
                            '$empcode',
                            '$password',
                            'USR',
                            '1',
                            '5',
                            'ACTIVE',
                            '$username',
                        '$createddate',
                        '$createdtime')";
                $userMstrResult = $db_controller->executeQuery($userMstrQuery);
                if($userMstrResult)
                {
                    $notificationMstrQuery = "INSERT INTO notification_mstr ( NOTIFCODE, REFCODE, ICON, MESSAGE, BRGYCODE, TAG, STATUS, CREATEDBY, CREATEDDATE, CREATEDTIME )
                        VALUES
                            (
                                '$notifcode',
                                '$accountcode',
                                'mdi mdi-account-plus',
                                'New user registered.',
                                '$brgycode',
                                '0',
                                'ACTIVE',
                                '$username',
                            '$createddate',
                            '$createdtime')";
                    $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                    if($notificationMstrResult)
                    {
                        echo "RecordSaved";
                    }
                }
            }
        }
    }
    
    $db_controller->closeQuery();
?>