<?php
    date_default_timezone_set("Asia/Manila");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
    $db_controller = new DBController();
    
    if(isset($_FILES['file']['name']))
    {
        $filename = $_FILES['file']['name'];
        
        $location = "../../../assets/images/barangay/".$filename;
        $path = "assets/images/barangay/".$filename;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        
        $valid_extensions = array("jpg","jpeg","png");
        $response = 0;
        
        if(in_array(strtolower($imageFileType),$valid_extensions))
        {
            if(move_uploaded_file($_FILES['file']['tmp_name'],$location))
            {
                $response = $path;
            }
        }
        
        echo $response;
        exit;
    }
    
    echo 0;
?>