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
        
        if($type == "CREATEANNOUNCEMENT")
        {
            $id = $_POST['id'];
            $title = str_replace("'","\'",$_POST['title']);
            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];
            $content = str_replace("'","\'",$_POST['content']);
            $fileinput = $_POST['fileinput'];
            $maxannouncementcode = 0;
            $maxnotificationcode = 0;
            $maxlogscode = 0;
            $announcementcodeformat = 0;
            $notificationcodeformat = 0;
            $logscodeformat = 0;
            $startdateval = "";
            $enddateval = "";
            $notifmessage = "[Announcement]: ".$title;
            $logmessage = "Admin created new announcement in your barangay.";
            $flag = 0;
            $createddate = date("Y-m-d");
            $createdtime = date("h:i:sa");
            
            $announcementMaxQuery = "SELECT
                    MAX( SUBSTRING( ANNCODE, 4 ) ) AS MAX_ANNOUNCEMENTCODE 
                FROM
                    announcement_mstr 
                GROUP BY
                    ANNCODE";
            $announcementMaxResult = $db_controller->runQuery($announcementMaxQuery);
            if($announcementMaxResult != NULL)
            {
                foreach($announcementMaxResult as $announcementMaxData)
                {
                    $maxannouncementcode = $announcementMaxData['MAX_ANNOUNCEMENTCODE'];
                }
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
            
            $announcementcodeformat = "ANN".str_pad(($maxannouncementcode + 1), 7, "0", STR_PAD_LEFT);
            $notificationcodeformat = "NOT".str_pad(($maxnotificationcode + 1), 7, "0", STR_PAD_LEFT);
            
            $startdate = DateTime::createFromFormat("m/d/Y", $startdate);
            if(!empty($startdate))
            {
                $startdateval = $startdate->format("Y-m-d");
            }
            
            $enddate = DateTime::createFromFormat("m/d/Y", $enddate);
            if(!empty($enddate))
            {
                $enddateval = $enddate->format("Y-m-d");
            }
            
            foreach($id as $barangay)
            {
                $logscodeformat = "LOG".str_pad(($maxlogscode + 1), 7, "0", STR_PAD_LEFT);
                
                if($barangay ==  "ALL")
                {
                    $barangayMstrQuery = "SELECT
                            BRGYCODE 
                        FROM
                            barangay_mstr 
                        GROUP BY
                            BRGYCODE 
                        ORDER BY
                            BRGYCODE";
                    $barangayMstrResult = $db_controller->runQuery($barangayMstrQuery);
                    if($barangayMstrResult != NULL)
                    {
                        foreach($barangayMstrResult as $barangayMstrData)
                        {
                            $brgycode = $barangayMstrData['BRGYCODE'];
                            
                            $announcementMstrQuery = "INSERT INTO announcement_mstr ( BRGYCODE, ANNCODE, TITLE, STARTDATE, ENDDATE, CONTENT, FILE, STATUS, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                VALUES
                                    (
                                        '$brgycode',
                                        '$announcementcodeformat',
                                        '$title',
                                        '$startdateval',
                                        '$enddateval',
                                        '$content',
                                        '$fileinput',
                                        'ONGOING',
                                        '$username',
                                    '$createddate',
                                    '$createdtime')";
                            $announcementMstrResult = $db_controller->executeQuery($announcementMstrQuery);
                            if($announcementMstrResult)
                            {
                                $notificationMstrQuery = "INSERT INTO notification_mstr ( BRGYCODE, NOTIFCODE, REFCODE, ICON, MESSAGE, TAG, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                    VALUES
                                        (
                                            '$brgycode',
                                            '$notificationcodeformat',
                                            '$announcementcodeformat',
                                            'mdi mdi-comment-account-outline',
                                            '$notifmessage',
                                            '0',
                                            '$username',
                                        '$createddate',
                                        '$createdtime')";
                                $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                                if($notificationMstrResult)
                                {
                                    $logsMstrQuery = "INSERT INTO logs_mstr ( BRGYCODE, LOGSCODE, LOGTITLE, LOGDESC, STATUS, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                        VALUES
                                            (
                                                '$brgycode',
                                                '$logscodeformat',
                                                '$title',
                                                '$logmessage',
                                                'ONGOING',
                                                '$username',
                                            '$createddate',
                                            '$createdtime')";
                                    $logsMstrResult = $db_controller->executeQuery($logsMstrQuery);
                                    if($logsMstrResult)
                                    {
                                        $flag = 1;
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    $announcementInfoQuery = "SELECT
                            ID 
                        FROM
                            announcement_mstr 
                        WHERE
                            UPPER( BRGYCODE ) = '$barangay' 
                            AND TITLE = '$title'";
                    $announcementInfoResult = $db_controller->numRows($announcementInfoQuery);
                    if($announcementInfoResult == 0)
                    {
                        $announcementMstrQuery = "INSERT INTO announcement_mstr ( BRGYCODE, ANNCODE, TITLE, STARTDATE, ENDDATE, CONTENT, FILE, STATUS, CREATEDBY, CREATEDDATE, CREATEDTIME )
                            VALUES
                                (
                                    '$barangay',
                                    '$announcementcodeformat',
                                    '$title',
                                    '$startdateval',
                                    '$enddateval',
                                    '$content',
                                    '$fileinput',
                                    'ONGOING',
                                    '$username',
                                '$createddate',
                                '$createdtime')";
                        $announcementMstrResult = $db_controller->executeQuery($announcementMstrQuery);
                        if($announcementMstrResult)
                        {
                            $notificationMstrQuery = "INSERT INTO notification_mstr ( BRGYCODE, NOTIFCODE, REFCODE, ICON, MESSAGE, TAG, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                VALUES
                                    (
                                        '$barangay',
                                        '$notificationcodeformat',
                                        '$announcementcodeformat',
                                        'mdi mdi-comment-account-outline',
                                        '$notifmessage',
                                        '0',
                                        '$username',
                                    '$createddate',
                                    '$createdtime')";
                            $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                            if($notificationMstrResult)
                            {
                                $logsMstrQuery = "INSERT INTO logs_mstr ( BRGYCODE, LOGSCODE, LOGTITLE, LOGDESC, STATUS, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                    VALUES
                                        (
                                            '$barangay',
                                            '$logscodeformat',
                                            '$title',
                                            '$logmessage',
                                            'ONGOING',
                                            '$username',
                                        '$createddate',
                                        '$createdtime')";
                                $logsMstrResult = $db_controller->executeQuery($logsMstrQuery);
                                if($logsMstrResult)
                                {
                                    $flag = 1;
                                }
                            }
                        }
                    }
                    else
                    {
                        $flag = 1;
                    }
                }
                
                $maxlogscode++;
            }
            
            if($flag == 1)
            {
                echo "RecordSaved";
            }
        }
        
        if($type == "DELETEANNOUNCEMENT")
        {
            $announcementcode = $_POST['announcementcode'];
            $reason = $_POST['reason'];
            $brgycode = "";
            $title = "";
            $remarks = "";
            $maxlogscode = 0;
            $logscodeformat = 0;
            $flag = 0;
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
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
            
            $announcementMstrQuery = "UPDATE announcement_mstr 
                SET STATUS = 'DELETED',
                REMARKS = '$reason',
                UPDATEDBY = '$username',
                UPDATEDDATE = '$updateddate',
                UPDATEDTIME = '$updatedtime' 
                WHERE
                    UPPER( ANNCODE ) = '$announcementcode'";
            $announcementMstrResult = $db_controller->executeQuery($announcementMstrQuery);
            if($announcementMstrResult)
            {
                $notificationMstrQuery = "UPDATE notification_mstr 
                    SET TAG = '1' 
                    WHERE
                        UPPER( REFCODE ) = '$announcementcode'";
                $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                if($notificationMstrResult)
                {
                    $announcementQuery = "SELECT
                            BRGYCODE,
                            TITLE 
                        FROM
                            announcement_mstr 
                        WHERE
                            UPPER( ANNCODE ) = '$announcementcode'";
                    $announcementResult = $db_controller->runQuery($announcementQuery);
                    if($announcementResult != NULL)
                    {
                        foreach($announcementResult as $announcementData)
                        {
                            $brgycode = $announcementData['BRGYCODE'];
                            $title = $announcementData['TITLE'];
                            
                            $logscodeformat = "LOG".str_pad(($maxlogscode + 1), 7, "0", STR_PAD_LEFT);
                            
                            $logsMstrQuery = "INSERT INTO logs_mstr ( BRGYCODE, LOGSCODE, LOGTITLE, LOGDESC, STATUS, REMARKS, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                VALUES
                                    (
                                        '$brgycode',
                                        '$logscodeformat',
                                        '$title',
                                        '',
                                        'DELETED',
                                        '$reason',
                                        '$username',
                                    '$updateddate',
                                    '$updatedtime')";
                            $logsMstrResult = $db_controller->executeQuery($logsMstrQuery);
                            if($logsMstrResult)
                            {
                                $flag = 1;
                            }
                            
                            $maxlogscode++;
                        }
                    }
                }
            }
            
            if($flag == 1)
            {
                echo "RecordDeleted";
            }
        }
        
        if($type == "UPDATEANNOUNCEMENT")
        {
            $announcementcode = $_POST['announcementcode'];
            $id = $_POST['id'];
            $title = str_replace("'","\'",$_POST['title']);
            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];
            $content = str_replace("'","\'",$_POST['content']);
            $fileinput = $_POST['fileinput'];
            $notificationcode = "";
            $maxlogscode = 0;
            $logscodeformat = 0;
            $startdateval = "";
            $enddateval = "";
            $existingfile = "";
            $createdby = "";
            $createddate = "";
            $createdtime = "";
            $notifmessage = "[Updated Announcement]: ".$title;
            $logmessage = "Admin has updated the announcement in your barangay.";
            $flag = 0;
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
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
            
            $startdate = DateTime::createFromFormat("m/d/Y", $startdate);
            if(!empty($startdate))
            {
                $startdateval = $startdate->format("Y-m-d");
            }
            
            $enddate = DateTime::createFromFormat("m/d/Y", $enddate);
            if(!empty($enddate))
            {
                $enddateval = $enddate->format("Y-m-d");
            }
            
            if($fileinput == "")
            {
                $announcementQuery = "SELECT
                        announcement_mstr.FILE,
                        announcement_mstr.CREATEDBY,
                        announcement_mstr.CREATEDDATE,
                        announcement_mstr.CREATEDTIME,
                        notification_mstr.NOTIFCODE 
                    FROM
                        announcement_mstr
                        INNER JOIN notification_mstr ON notification_mstr.REFCODE = announcement_mstr.ANNCODE 
                    WHERE
                        UPPER( announcement_mstr.ANNCODE ) = '$announcementcode' 
                    GROUP BY
                        announcement_mstr.ANNCODE";
                $announcementResult = $db_controller->runQuery($announcementQuery);
                if($announcementResult != NULL)
                {
                    $existingfile = $announcementResult[0]['FILE'];
                    $createdby = $announcementResult[0]['CREATEDBY'];
                    $createddate = $announcementResult[0]['CREATEDDATE'];
                    $createdtime = $announcementResult[0]['CREATEDTIME'];
                    $notificationcode = $announcementResult[0]['NOTIFCODE'];
                }
                
                $announcementDelQuery = "DELETE 
                    FROM
                        announcement_mstr 
                    WHERE
                        UPPER( ANNCODE ) = '$announcementcode'";
                $announcementDelResult = $db_controller->executeQuery($announcementDelQuery);
                if($announcementDelResult)
                {
                    $notificationDelQuery = "DELETE 
                        FROM
                            notification_mstr 
                        WHERE
                            UPPER( REFCODE ) = '$announcementcode'";
                    $notificationDelResult = $db_controller->executeQuery($notificationDelQuery);
                    if($notificationDelResult)
                    {
                        foreach($id as $barangay)
                        {
                            if($barangay ==  "ALL")
                            {
                                $barangayMstrQuery = "SELECT
                                        BRGYCODE 
                                    FROM
                                        barangay_mstr 
                                    GROUP BY
                                        BRGYCODE 
                                    ORDER BY
                                        BRGYCODE";
                                $barangayMstrResult = $db_controller->runQuery($barangayMstrQuery);
                                if($barangayMstrResult != NULL)
                                {
                                    foreach($barangayMstrResult as $barangayMstrData)
                                    {
                                        $brgycode = $barangayMstrData['BRGYCODE'];
                                        
                                        $logscodeformat = "LOG".str_pad(($maxlogscode + 1), 7, "0", STR_PAD_LEFT);
                                        
                                        $announcementMstrQuery = "INSERT INTO announcement_mstr (
                                                BRGYCODE,
                                                ANNCODE,
                                                TITLE,
                                                STARTDATE,
                                                ENDDATE,
                                                CONTENT,
                                                FILE,
                                                STATUS,
                                                CREATEDBY,
                                                CREATEDDATE,
                                                CREATEDTIME,
                                                UPDATEDBY,
                                                UPDATEDDATE,
                                                UPDATEDTIME 
                                            )
                                            VALUES
                                                (
                                                    '$brgycode',
                                                    '$announcementcode',
                                                    '$title',
                                                    '$startdateval',
                                                    '$enddateval',
                                                    '$content',
                                                    '$existingfile',
                                                    'ONGOING',
                                                    '$createdby',
                                                    '$createddate',
                                                    '$createdtime',
                                                    '$username',
                                                '$updateddate ',
                                                ' $updatedtime')";
                                        $announcementMstrResult = $db_controller->executeQuery($announcementMstrQuery);
                                        if($announcementMstrResult)
                                        {
                                            $notificationMstrQuery = "INSERT INTO notification_mstr ( BRGYCODE, NOTIFCODE, REFCODE, ICON, MESSAGE, TAG, CREATEDBY, CREATEDDATE, CREATEDTIME, UPDATEDBY, UPDATEDDATE, UPDATEDTIME )
                                                VALUES
                                                    (
                                                        '$brgycode',
                                                        '$notificationcode',
                                                        '$announcementcode',
                                                        'mdi mdi-comment-edit-outline',
                                                        '$notifmessage',
                                                        '0',
                                                        '$username',
                                                        '$createddate',
                                                        '$createdtime',
                                                        '$username',
                                                    '$updateddate',
                                                    '$updatedtime')";
                                            $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                                            if($notificationMstrResult)
                                            {
                                                $logsMstrQuery = "INSERT INTO logs_mstr ( BRGYCODE, LOGSCODE, LOGTITLE, LOGDESC, STATUS, FILE, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                                    VALUES
                                                        (
                                                            '$brgycode',
                                                            '$logscodeformat',
                                                            '$title',
                                                            '$logmessage',
                                                            'ONGOING',
                                                            '$existingfile',
                                                            '$username',
                                                        '$updateddate',
                                                        '$updatedtime')";
                                                $logsMstrResult = $db_controller->executeQuery($logsMstrQuery);
                                                if($logsMstrResult)
                                                {
                                                    $flag = 1;
                                                }
                                            }
                                        }
                                        
                                        $maxlogscode++;
                                    }
                                }
                            }
                            else
                            {
                                $announcementInfoQuery = "SELECT
                                        ID 
                                    FROM
                                        announcement_mstr 
                                    WHERE
                                        UPPER( BRGYCODE ) = '$barangay' 
                                        AND TITLE = '$title'";
                                $announcementInfoResult = $db_controller->numRows($announcementInfoQuery);
                                if($announcementInfoResult == 0)
                                {
                                    $logscodeformat = "LOG".str_pad(($maxlogscode + 1), 7, "0", STR_PAD_LEFT);
                                    
                                    $announcementMstrQuery = "INSERT INTO announcement_mstr (
                                            BRGYCODE,
                                            ANNCODE,
                                            TITLE,
                                            STARTDATE,
                                            ENDDATE,
                                            CONTENT,
                                            FILE,
                                            STATUS,
                                            CREATEDBY,
                                            CREATEDDATE,
                                            CREATEDTIME,
                                            UPDATEDBY,
                                            UPDATEDDATE,
                                            UPDATEDTIME 
                                        )
                                        VALUES
                                            (
                                                '$barangay',
                                                '$announcementcode',
                                                '$title',
                                                '$startdateval',
                                                '$enddateval',
                                                '$content',
                                                '$existingfile',
                                                'ONGOING',
                                                '$createdby',
                                                '$createddate',
                                                '$createdtime',
                                                '$username',
                                            '$updateddate ',
                                            ' $updatedtime')";
                                    $announcementMstrResult = $db_controller->executeQuery($announcementMstrQuery);
                                    if($announcementMstrResult)
                                    {
                                        $notificationMstrQuery = "INSERT INTO notification_mstr ( BRGYCODE, NOTIFCODE, REFCODE, ICON, MESSAGE, TAG, CREATEDBY, CREATEDDATE, CREATEDTIME, UPDATEDBY, UPDATEDDATE, UPDATEDTIME )
                                            VALUES
                                                (
                                                    '$barangay',
                                                    '$notificationcode',
                                                    '$announcementcode',
                                                    'mdi mdi-comment-edit-outline',
                                                    '$notifmessage',
                                                    '0',
                                                    '$username',
                                                    '$createddate',
                                                    '$createdtime',
                                                    '$username',
                                                '$updateddate',
                                                '$updatedtime')";
                                        $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                                        if($notificationMstrResult)
                                        {
                                            $logsMstrQuery = "INSERT INTO logs_mstr ( BRGYCODE, LOGSCODE, LOGTITLE, LOGDESC, STATUS, FILE, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                                VALUES
                                                    (
                                                        '$barangay',
                                                        '$logscodeformat',
                                                        '$title',
                                                        '$logmessage',
                                                        'ONGOING',
                                                        '$existingfile',
                                                        '$username',
                                                    '$updateddate',
                                                    '$updatedtime')";
                                            $logsMstrResult = $db_controller->executeQuery($logsMstrQuery);
                                            if($logsMstrResult)
                                            {
                                                $flag = 1;
                                            }
                                        }
                                    }
                                    
                                    $maxlogscode++;
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
            else
            {
                $announcementQuery = "SELECT
                        announcement_mstr.CREATEDBY,
                        announcement_mstr.CREATEDDATE,
                        announcement_mstr.CREATEDTIME,
                        notification_mstr.NOTIFCODE 
                    FROM
                        announcement_mstr
                        INNER JOIN notification_mstr ON notification_mstr.REFCODE = announcement_mstr.ANNCODE 
                    WHERE
                        UPPER( announcement_mstr.ANNCODE ) = '$announcementcode' 
                    GROUP BY
                        announcement_mstr.ANNCODE";
                $announcementResult = $db_controller->runQuery($announcementQuery);
                if($announcementResult != NULL)
                {
                    $createdby = $announcementResult[0]['CREATEDBY'];
                    $createddate = $announcementResult[0]['CREATEDDATE'];
                    $createdtime = $announcementResult[0]['CREATEDTIME'];
                    $notificationcode = $announcementResult[0]['NOTIFCODE'];
                }
                
                $announcementDelQuery = "DELETE 
                    FROM
                        announcement_mstr 
                    WHERE
                        UPPER( ANNCODE ) = '$announcementcode'";
                $announcementDelResult = $db_controller->executeQuery($announcementDelQuery);
                if($announcementDelResult)
                {
                    $notificationDelQuery = "DELETE 
                        FROM
                            notification_mstr 
                        WHERE
                            UPPER( REFCODE ) = '$announcementcode'";
                    $notificationDelResult = $db_controller->executeQuery($notificationDelQuery);
                    if($notificationDelResult)
                    {
                        foreach($id as $barangay)
                        {
                            if($barangay ==  "ALL")
                            {
                                $barangayMstrQuery = "SELECT
                                        BRGYCODE 
                                    FROM
                                        barangay_mstr 
                                    GROUP BY
                                        BRGYCODE 
                                    ORDER BY
                                        BRGYCODE";
                                $barangayMstrResult = $db_controller->runQuery($barangayMstrQuery);
                                if($barangayMstrResult != NULL)
                                {
                                    foreach($barangayMstrResult as $barangayMstrData)
                                    {
                                        $brgycode = $barangayMstrData['BRGYCODE'];
                                        
                                        $logscodeformat = "LOG".str_pad(($maxlogscode + 1), 7, "0", STR_PAD_LEFT);
                                        
                                        $announcementMstrQuery = "INSERT INTO announcement_mstr (
                                                BRGYCODE,
                                                ANNCODE,
                                                TITLE,
                                                STARTDATE,
                                                ENDDATE,
                                                CONTENT,
                                                FILE,
                                                STATUS,
                                                CREATEDBY,
                                                CREATEDDATE,
                                                CREATEDTIME,
                                                UPDATEDBY,
                                                UPDATEDDATE,
                                                UPDATEDTIME 
                                            )
                                            VALUES
                                                (
                                                    '$brgycode',
                                                    '$announcementcode',
                                                    '$title',
                                                    '$startdateval',
                                                    '$enddateval',
                                                    '$content',
                                                    '$fileinput',
                                                    'ONGOING',
                                                    '$createdby',
                                                    '$createddate',
                                                    '$createdtime',
                                                    '$username',
                                                '$updateddate ',
                                                ' $updatedtime')";
                                        $announcementMstrResult = $db_controller->executeQuery($announcementMstrQuery);
                                        if($announcementMstrResult)
                                        {
                                            $notificationMstrQuery = "INSERT INTO notification_mstr ( BRGYCODE, NOTIFCODE, REFCODE, ICON, MESSAGE, TAG, CREATEDBY, CREATEDDATE, CREATEDTIME, UPDATEDBY, UPDATEDDATE, UPDATEDTIME )
                                                VALUES
                                                    (
                                                        '$brgycode',
                                                        '$notificationcode',
                                                        '$announcementcode',
                                                        'mdi mdi-comment-edit-outline',
                                                        '$notifmessage',
                                                        '0',
                                                        '$username',
                                                        '$createddate',
                                                        '$createdtime',
                                                        '$username',
                                                    '$updateddate',
                                                    '$updatedtime')";
                                            $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                                            if($notificationMstrResult)
                                            {
                                                $logsMstrQuery = "INSERT INTO logs_mstr ( BRGYCODE, LOGSCODE, LOGTITLE, LOGDESC, STATUS, FILE, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                                    VALUES
                                                        (
                                                            '$brgycode',
                                                            '$logscodeformat',
                                                            '$title',
                                                            '$logmessage',
                                                            'ONGOING',
                                                            '$fileinput',
                                                            '$username',
                                                        '$updateddate',
                                                        '$updatedtime')";
                                                $logsMstrResult = $db_controller->executeQuery($logsMstrQuery);
                                                if($logsMstrResult)
                                                {
                                                    $flag = 1;
                                                }
                                            }
                                        }
                                        
                                        $maxlogscode++;
                                    }
                                }
                            }
                            else
                            {
                                $announcementInfoQuery = "SELECT
                                        ID 
                                    FROM
                                        announcement_mstr 
                                    WHERE
                                        UPPER( BRGYCODE ) = '$barangay' 
                                        AND TITLE = '$title'";
                                $announcementInfoResult = $db_controller->numRows($announcementInfoQuery);
                                if($announcementInfoResult == 0)
                                {
                                    $logscodeformat = "LOG".str_pad(($maxlogscode + 1), 7, "0", STR_PAD_LEFT);
                                    
                                    $announcementMstrQuery = "INSERT INTO announcement_mstr (
                                            BRGYCODE,
                                            ANNCODE,
                                            TITLE,
                                            STARTDATE,
                                            ENDDATE,
                                            CONTENT,
                                            FILE,
                                            STATUS,
                                            CREATEDBY,
                                            CREATEDDATE,
                                            CREATEDTIME,
                                            UPDATEDBY,
                                            UPDATEDDATE,
                                            UPDATEDTIME 
                                        )
                                        VALUES
                                            (
                                                '$barangay',
                                                '$announcementcode',
                                                '$title',
                                                '$startdateval',
                                                '$enddateval',
                                                '$content',
                                                '$fileinput',
                                                'ONGOING',
                                                '$createdby',
                                                '$createddate',
                                                '$createdtime',
                                                '$username',
                                            '$updateddate ',
                                            ' $updatedtime')";
                                    $announcementMstrResult = $db_controller->executeQuery($announcementMstrQuery);
                                    if($announcementMstrResult)
                                    {
                                        $notificationMstrQuery = "INSERT INTO notification_mstr ( BRGYCODE, NOTIFCODE, REFCODE, ICON, MESSAGE, TAG, CREATEDBY, CREATEDDATE, CREATEDTIME, UPDATEDBY, UPDATEDDATE, UPDATEDTIME )
                                            VALUES
                                                (
                                                    '$barangay',
                                                    '$notificationcode',
                                                    '$announcementcode',
                                                    'mdi mdi-comment-edit-outline',
                                                    '$notifmessage',
                                                    '0',
                                                    '$username',
                                                    '$createddate',
                                                    '$createdtime',
                                                    '$username',
                                                '$updateddate',
                                                '$updatedtime')";
                                        $notificationMstrResult = $db_controller->executeQuery($notificationMstrQuery);
                                        if($notificationMstrResult)
                                        {
                                            $logsMstrQuery = "INSERT INTO logs_mstr ( BRGYCODE, LOGSCODE, LOGTITLE, LOGDESC, STATUS, FILE, CREATEDBY, CREATEDDATE, CREATEDTIME )
                                                VALUES
                                                    (
                                                        '$barangay',
                                                        '$logscodeformat',
                                                        '$title',
                                                        '$logmessage',
                                                        'ONGOING',
                                                        '$fileinput',
                                                        '$username',
                                                    '$updateddate',
                                                    '$updatedtime')";
                                            $logsMstrResult = $db_controller->executeQuery($logsMstrQuery);
                                            if($logsMstrResult)
                                            {
                                                $flag = 1;
                                            }
                                        }
                                    }
                                    
                                    $maxlogscode++;
                                }
                                else
                                {
                                    $flag = 1;
                                }
                            }
                            
                            $maxlogscode++;
                        }
                    }
                }
            }
            
            if($flag == 1)
            {
                echo "RecordSaved";
            }
        }
    }
    
    $db_controller->closeQuery();
?>