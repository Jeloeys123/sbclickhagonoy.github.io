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
        
        if($type == "CHANGEPASSWORD")
        {
            $empcode = $_POST['empcode'];
            $newpassword = bin2hex($_POST['newpassword']);
            $oldpassword = "";
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $oldPasswordQuery = "SELECT PASSWORD 
                FROM
                    user_mstr 
                WHERE
                    UPPER( EMPCODE ) = '$empcode'";
            $oldPasswordResult = $db_controller->runQuery($oldPasswordQuery);
            if($oldPasswordResult != NULL)
            {
                $oldpassword = $oldPasswordResult[0]['PASSWORD'];
            }
            
            if($newpassword == $oldpassword)
            {
                echo "SamePassword";
            }
            else
            {
                $userMstrQuery = "UPDATE user_mstr 
                    SET PASSWORD = '$newpassword',
                    FIRSTLOGIN = '0',
                    LOGINATTEMPT = '5',
                    UPDATEDBY = '$empcode',
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
        }
    }
    
    $db_controller->closeQuery();
?>