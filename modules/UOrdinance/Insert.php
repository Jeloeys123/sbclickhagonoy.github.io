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
        
        if($type == "CREATEORDINANCE")
        {
            $ordinanceyear = $_POST['ordinanceyear'];
            $ordinancecode = $_POST['ordinancecode'];
            $ordinancetitle = $_POST['ordinancetitle'];
            $ordinancedescription = str_replace("'","\'",$_POST['ordinancedescription']);
            $submitteddate = $_POST['submitteddate'];
            $fileinput = $_POST['fileinput'];
            $brgyname = "";
            $maxnotificationcode = 0;
            $notificationcodeformat = 0;
            $submitteddateval = "";
            $notifmessage = "";
            $createddate = date("Y-m-d");
            $createdtime = date("h:i:sa");
            
            $barangayQuery = "SELECT
                    BRGYNAME 
                FROM
                    barangay_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode'";
            $barangayResult = $db_controller->runQuery($barangayQuery);
            if($barangayResult != NULL)
            {
                $brgyname = $barangayResult[0]['BRGYNAME'];
            }
            
            $notificationMaxQuery = "SELECT
                    MAX( SUBSTRING( NOTIFCODE, 4 ) ) AS MAX_NOTIFICATIONCODE 
                FROM
                    notification_mstr 
                GROUP BY
                    NOTIFCODE";
            $notificationMaxResult = $db_controller->runQuery($notificationMaxQuery);
            if($notificationMaxResult != NULL)
            {
                foreach($notificationMaxResult as $notificationMaxData)
                {
                    $maxnotificationcode = $notificationMaxData['MAX_NOTIFICATIONCODE'];
                }
            }
            
            $notificationcodeformat = "NOT".str_pad(($maxnotificationcode + 1), 7, "0", STR_PAD_LEFT);
            $notifmessage = $brgyname." has submitted an ordinance";
            
            $submitteddate = DateTime::createFromFormat("m/d/Y", $submitteddate);
            if(!empty($submitteddate))
            {
                $submitteddateval = $submitteddate->format("Y-m-d");
            }
            
            $ordinanceMstrQuery = "INSERT INTO ordinance_mstr ( BRGYCODE, ORDYEAR, ORDCODE, ORDTITLE, DESCRIPTION, SUBMITTEDDATE, FILE, STATUS, CREATEDBY, CREATEDDATE, CREATEDTIME )
                VALUES
                    (
                        '$barangaycode',
                        '$ordinanceyear',
                        '$ordinancecode',
                        '$ordinancetitle',
                        '$ordinancedescription',
                        '$submitteddateval',
                        '$fileinput',
                        'PENDING',
                        '$username',
                    '$createddate',
                    '$createdtime')";
            $ordinanceMstrResult = $db_controller->executeQuery($ordinanceMstrQuery);
            if($ordinanceMstrResult)
            {
                $notificationMstrQuery = "INSERT INTO notification_mstr ( NOTIFCODE, REFCODE, ICON, MESSAGE, TAG, CREATEDBY, CREATEDDATE, CREATEDTIME )
                    VALUES
                        (
                            '$notificationcodeformat',
                            '$ordinancecode',
                            'mdi mdi-file-upload',
                            '$notifmessage',
                            '0',
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
        
        if($type == "UPDATEORDINANCE")
        {
            $ordinancecode = $_POST['ordinancecode'];
            $ordinancedescription = str_replace("'","\'",$_POST['ordinancedescription']);
            $fileinput = $_POST['fileinput'];
            $brgyname = "";
            $notifmessage = "";
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $barangayQuery = "SELECT
                    BRGYNAME 
                FROM
                    barangay_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode'";
            $barangayResult = $db_controller->runQuery($barangayQuery);
            if($barangayResult != NULL)
            {
                $brgyname = $barangayResult[0]['BRGYNAME'];
            }
            
            $notifmessage = $brgyname." has updated the ordinance.";
            
            if($fileinput == "")
            {
                $ordinanceMstrQuery = "UPDATE ordinance_mstr 
                    SET DESCRIPTION = '$ordinancedescription' 
                    WHERE
                        UPPER( BRGYCODE ) = '$barangaycode' 
                        AND UPPER( ORDCODE ) = '$ordinancecode'";
                $ordinanceMstrResult = $db_controller->executeQuery($ordinanceMstrQuery);
                if($ordinanceMstrResult)
                {
                    $notificationMstrQuery = "UPDATE notification_mstr 
                        SET ICON = 'mdi mdi-file-replace',
                        MESSAGE = '$notifmessage',
                        TAG = '0',
                        UPDATEDBY = '$username',
                        UPDATEDDATE = '$updateddate',
                        UPDATEDTIME = '$updatedtime' 
                        WHERE
                            UPPER( BRGYCODE ) = '' 
                            AND UPPER( REFCODE ) = '$ordinancecode' 
                            AND CREATEDBY = '$username'";
                    $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                    if($notificationMstrResult)
                    {
                        echo "RecordSaved";
                    }
                }
            }
            else
            {
                $ordinanceMstrQuery = "UPDATE ordinance_mstr 
                    SET DESCRIPTION = '$ordinancedescription',
                    FILE = '$fileinput' 
                    WHERE
                        UPPER( BRGYCODE ) = '$barangaycode' 
                        AND UPPER( ORDCODE ) = '$ordinancecode'";
                $ordinanceMstrResult = $db_controller->executeQuery($ordinanceMstrQuery);
                if($ordinanceMstrResult)
                {
                    $notificationMstrQuery = "UPDATE notification_mstr 
                        SET ICON = 'mdi mdi-file-replace',
                        MESSAGE = '$notifmessage',
                        TAG = '0',
                        UPDATEDBY = '$username',
                        UPDATEDDATE = '$updateddate',
                        UPDATEDTIME = '$updatedtime' 
                        WHERE
                            UPPER( BRGYCODE ) = '' 
                            AND UPPER( REFCODE ) = '$ordinancecode' 
                            AND CREATEDBY = '$username'";
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