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
        
        if($type == "GETUPDATEANNOUNCEMENTINFO")
        {
            $announcementcode = $_POST['announcementcode'];
            $brgycount = "";
            $brgycode = "";
            $title = "";
            $startdate = "";
            $enddate = "";
            $content = "";
            $announcement_arr = array();
            
            $barangayCountQuery = "SELECT
                    COUNT( BRGYCODE ) AS BRGYNAMECOUNT 
                FROM
                    announcement_mstr 
                WHERE
                    UPPER( ANNCODE ) = '$announcementcode'";
            $barangayCountResult = $db_controller->runQuery($barangayCountQuery);
            if($barangayCountResult != NULL)
            {
                $brgycount = $barangayCountResult[0]['BRGYNAMECOUNT'];
            }
            
            if($brgycount >= 26)
            {
                $announcementMstrQuery = "SELECT
                        BRGYCODE,
                        TITLE,
                        STARTDATE,
                        ENDDATE,
                        CONTENT 
                    FROM
                        announcement_mstr
                    WHERE
                        UPPER( ANNCODE ) = '$announcementcode'";
                $announcementMstrResult = $db_controller->runQuery($announcementMstrQuery);
                if($announcementMstrResult != NULL)
                {
                    foreach($announcementMstrResult as $announcementMstrData)
                    {
                        $brgycode = $announcementMstrData['BRGYCODE'];
                        $title = $announcementMstrData['TITLE'];
                        $startdate = $announcementMstrData['STARTDATE'];
                        $enddate = $announcementMstrData['ENDDATE'];
                        $content = $announcementMstrData['CONTENT'];
                        
                        $announcement_arr[] = array(
                            "BARANGAY" => "ALL",
                            "TITLE" => $title,
                            "STARTDATE" => $startdate,
                            "ENDDATE" => $enddate,
                            "CONTENT" => $content
                        );
                    }
                }
            }
            else
            {
                $announcementMstrQuery = "SELECT
                        BRGYCODE,
                        TITLE,
                        STARTDATE,
                        ENDDATE,
                        CONTENT 
                    FROM
                        announcement_mstr
                    WHERE
                        UPPER( ANNCODE ) = '$announcementcode'";
                $announcementMstrResult = $db_controller->runQuery($announcementMstrQuery);
                if($announcementMstrResult != NULL)
                {
                    foreach($announcementMstrResult as $announcementMstrData)
                    {
                        $brgycode = $announcementMstrData['BRGYCODE'];
                        $title = $announcementMstrData['TITLE'];
                        $startdate = $announcementMstrData['STARTDATE'];
                        $enddate = $announcementMstrData['ENDDATE'];
                        $content = $announcementMstrData['CONTENT'];
                        
                        $announcement_arr[] = array(
                            "BARANGAY" => $brgycode,
                            "TITLE" => $title,
                            "STARTDATE" => $startdate,
                            "ENDDATE" => $enddate,
                            "CONTENT" => $content
                        );
                    }
                }
            }
            
            echo json_encode($announcement_arr);
        }
    }
    
    $db_controller->closeQuery();
?>