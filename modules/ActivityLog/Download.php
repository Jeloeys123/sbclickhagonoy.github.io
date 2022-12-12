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
        $logscode = $_GET['id'];
        $filename  = "";
        $filepath = "";
            
        $logsMstrQuery = "SELECT
                FILE 
            FROM
                logs_mstr 
            WHERE
                UPPER( LOGSCODE ) = '$logscode' 
            GROUP BY
                LOGSCODE";
        $logsMstrResult = $db_controller->runQuery($logsMstrQuery);
        if($logsMstrResult != NULL)
        {
            $filename = $logsMstrResult[0]['FILE'];
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