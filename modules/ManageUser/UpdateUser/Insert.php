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
        
        if($type == "UPDATEACCOUNT")
        {
            $accountcode = $_POST['acccode'];
            $brgycode = $_POST['brgycode'];
            $empcode = $_POST['empcode'];
            $firstname = str_replace("'","\'",$_POST['firstname']);
            $middlename = str_replace("'","\'",$_POST['middlename']);
            $lastname = str_replace("'","\'",$_POST['lastname']);
            $suffixname = str_replace("'","\'",$_POST['suffixname']);
            $gender = $_POST['gender'];
            $email = str_replace("'","\'",$_POST['email']);
            $mobile = $_POST['mobile'];
            $position = str_replace("'","\'",$_POST['position']);
            $address = str_replace("'","\'",$_POST['address']);
            $notificationcode = 0;
            $notifcode = 0;
            $message = "User account successfully changed.";
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
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
            
            $notifcode = "NTF".str_pad(($notificationcode+1),7,"0",STR_PAD_LEFT);
            
            $barangayRepresentativeQuery = "UPDATE barangay_representative 
                SET FIRSTNAME = '$firstname',
                MIDDLENAME = '$middlename',
                LASTNAME = '$lastname',
                SUFFIXNAME = '$suffixname',
                GENDER = '$gender',
                EMAIL = '$email',
                MOBILE = '$mobile',
                POSITION = '$position',
                ADDRESS = '$address',
                UPDATEDBY = '$username',
                UPDATEDDATE = '$updateddate',
                UPDATEDTIME = '$updatedtime' 
                WHERE
                    UPPER( EMPCODE ) = '$empcode'";
            $barangayRepresentativeResult = $db_controller->executeQuery($barangayRepresentativeQuery);
            if($barangayRepresentativeResult)
            {
                $notifInfoQuery = "SELECT
                        ID 
                    FROM
                        notification_mstr 
                    WHERE
                        UPPER( REFCODE ) = '$accountcode' 
                        AND MESSAGE = '$message'";
                $notifInfoResult = $db_controller->numRows($notifInfoQuery);
                if($notifInfoResult == 0)
                {
                    $notificationMstrQuery = "INSERT INTO notification_mstr ( NOTIFCODE, REFCODE, ICON, MESSAGE, BRGYCODE, TAG, STATUS, CREATEDBY, CREATEDDATE, CREATEDTIME )
                        VALUES
                            (
                                '$notifcode',
                                '$accountcode',
                                'mdi mdi-account-edit',
                                'User account successfully changed.',
                                '$brgycode',
                                '0',
                                'ACTIVE',
                                '$username',
                            '$updateddate',
                            '$updatedtime')";
                    $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                    if($notificationMstrResult)
                    {
                        echo "RecordSaved";
                    }
                }
                else
                {
                    $notificationMstrQuery = "UPDATE notification_mstr 
                        SET TAG = '0' 
                        WHERE
                            UPPER( REFCODE ) = '$accountcode' 
                            AND MESSAGE = '$message'";
                    $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                    if($notificationMstrResult)
                    {
                        echo "RecordSaved";
                    }
                }
            }
        }
        
        if($type == "UNBLOCKEDACCOUNT")
        {
            $empcode = $_POST['id'];
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $userMstrQuery = "UPDATE user_mstr 
                SET LOGINATTEMPT = '5',
                UPDATEDBY = '$username',
                UPDATEDDATE = '$updateddate',
                UPDATEDTIME = '$updatedtime' 
                WHERE
                    UPPER( EMPCODE ) = '$empcode'";
            $userMstrResult = $db_controller->executeQuery($userMstrQuery);
            if($userMstrResult)
            {
                echo "RecordSaved";
            }
        }
        
        if($type == "RESETPASSWORD")
        {
            $empcode = $_POST['id'];
            $resetpassword = bin2hex($empcode);
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $userInfoQuery = "SELECT
                    ID 
                FROM
                    user_mstr 
                WHERE
                    UPPER( EMPCODE ) = '$empcode' 
                    AND FIRSTLOGIN = '0'";
            $userInfoResult = $db_controller->numRows($userInfoQuery);
            if($userInfoResult == 0)
            {
                echo "RecordResetAlready";
            }
            else
            {
                $checkAccountQuery = "SELECT
                        ID 
                    FROM
                        user_mstr 
                    WHERE
                        UPPER( EMPCODE ) = '$empcode' 
                        AND FIRSTLOGIN = '0' 
                        AND LOGINATTEMPT = '0'";
                $checkAccountResult = $db_controller->numRows($checkAccountQuery);
                if($checkAccountResult == 0)
                {
                    $userMstrQuery = "UPDATE user_mstr 
                        SET PASSWORD = '$resetpassword',
                        FIRSTLOGIN = '1',
                        LOGINATTEMPT = '5',
                        UPDATEDBY = '$username',
                        UPDATEDDATE = '$updateddate',
                        UPDATEDTIME = '$updatedtime' 
                        WHERE
                            UPPER( EMPCODE ) = '$empcode'";
                    $userMstrResult = $db_controller->executeQuery($userMstrQuery);
                    if($userMstrResult)
                    {
                        echo "RecordSaved";
                    }
                }
                else
                {
                    echo "RecordBlocked";
                }
            }
        }
    }
    
    $db_controller->closeQuery();
?>