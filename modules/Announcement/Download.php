<?php
    date_default_timezone_set("Asia/Manila");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
    $db_controller = new DBController();
    
    if(isset($_GET['id']))
    {
        $announcecode = $_GET['id'];
        $filename  = "";
        $filepath = "";
            
        $announcementMstrQuery = "SELECT
                FILE 
            FROM
                announcement_mstr 
            WHERE
                UPPER( ANNCODE ) = '$announcecode' 
            GROUP BY
                ANNCODE";
        $announcementMstrResult = $db_controller->runQuery($announcementMstrQuery);
        if($announcementMstrResult != NULL)
        {
            $filename = $announcementMstrResult[0]['FILE'];
        }
        
        $filepath = "../../assets/images/announcement/".$filename;
        
        if(file_exists($filepath))
        {
            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename = ".basename($filepath));
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: " . filesize($filepath));
            readfile($filepath);
            exit;
        }
    }
?>