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
        
        if($type == "CREATEBARANGAYOFFICIAL")
        {
            $firstname = str_replace("'","\'",$_POST['firstname']);
            $middlename = str_replace("'","\'",$_POST['middlename']);
            $lastname = str_replace("'","\'",$_POST['lastname']);
            $suffixname = str_replace("'","\'",$_POST['suffixname']);
            $position = $_POST['position'];
            $email = str_replace("'","\'",$_POST['email']);
            $mobile = $_POST['mobile'];
            $tag = 0;
            $createddate = date("Y-m-d");
            $createdtime = date("h:i:sa");
            
            if($position == "PB")
            {
                $tag = 1;
            }
            if($position == "SB")
            {
                $tag = 2;
            }
            if($position == "SK")
            {
                $tag = 3;
            }
            if($position == "BS")
            {
                $tag = 4;
            }
            
            $brgyOfficialsQuery = "INSERT INTO barangay_officials ( BRGYCODE, FIRSTNAME, MIDDLENAME, LASTNAME, SUFFIXNAME, EMAIL, MOBILE, POSITION, TAG, CREATEDBY, CREATEDDATE, CREATEDTIME )
                VALUES
                    (
                        '$barangaycode',
                        '$firstname',
                        '$middlename',
                        '$lastname',
                        '$suffixname',
                        '$email',
                        '$mobile',
                        '$position',
                        '$tag',
                        '$username',
                    '$createddate',
                    '$createdtime')";
            $brgyOfficialsResult = $db_controller->executeQuery($brgyOfficialsQuery);
            if($brgyOfficialsResult)
            {
                echo "RecordSaved";
            }
        }
        
        if($type == "DELETEBARANGAYOFFICIAL")
        {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $poscode = $_POST['poscode'];
            
            $brgyOfficialsQuery = "DELETE 
                FROM
                    barangay_officials 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode' 
                    AND UPPER( FIRSTNAME ) = '$fname' 
                    AND UPPER( LASTNAME ) = '$lname' 
                    AND UPPER( POSITION ) = '$poscode'";
            $brgyOfficialsResult = $db_controller->executeQuery($brgyOfficialsQuery);
            if($brgyOfficialsResult)
            {
                echo "RecordDeleted";
            }
        }
        
        if($type == "UPDATEBARANGAYOFFICIAL")
        {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $poscode = $_POST['poscode'];
            $firstname = str_replace("'","\'",$_POST['firstname']);
            $middlename = str_replace("'","\'",$_POST['middlename']);
            $lastname = str_replace("'","\'",$_POST['lastname']);
            $suffixname = str_replace("'","\'",$_POST['suffixname']);
            $email = str_replace("'","\'",$_POST['email']);
            $mobile = $_POST['mobile'];
            $updateddate = date("Y-m-d");
            $updatedtime = date("h:i:sa");
            
            $brgyOfficialsQuery = "UPDATE barangay_officials 
                SET FIRSTNAME = '$firstname',
                MIDDLENAME = '$middlename',
                LASTNAME = '$lastname',
                SUFFIXNAME = '$suffixname',
                EMAIL = '$email',
                MOBILE = '$mobile',
                UPDATEDBY = '$username',
                UPDATEDDATE = '$updateddate',
                UPDATEDTIME = '$updatedtime' 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode' 
                    AND UPPER( FIRSTNAME ) = '$fname' 
                    AND UPPER( LASTNAME ) = '$lname' 
                    AND UPPER( POSITION ) = '$poscode'";
            $brgyOfficialsResult = $db_controller->executeQuery($brgyOfficialsQuery);
            if($brgyOfficialsResult)
            {
                echo "RecordSaved";
            }
        }
    }
    
    $db_controller->closeQuery();
?>