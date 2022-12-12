<?php
    date_default_timezone_set("Asia/Manila");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
    $db_controller = new DBController();
    include $common_path."session_logged.php";
    $barangaycode = $_SESSION['logged_brgycode'];
    
    if(isset($_GET['id']))
    {
        $ordinancecode = $_GET['id'];
        $filename  = "";
        $filepath = "";
            
        $ordinanceMstrQuery = "SELECT
                FILE 
            FROM
                ordinance_mstr 
            WHERE
                UPPER( BRGYCODE ) = '$barangaycode' 
                AND UPPER( ORDCODE ) = '$ordinancecode' 
            GROUP BY
                BRGYCODE,
                ORDCODE";
        $ordinanceMstrResult = $db_controller->runQuery($ordinanceMstrQuery);
        if($ordinanceMstrResult != NULL)
        {
            $filename = $ordinanceMstrResult[0]['FILE'];
        }
        
        $filepath = "../../assets/images/ordinance/".$filename;
        
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