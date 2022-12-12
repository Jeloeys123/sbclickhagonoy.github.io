<?php
    session_start();
    date_default_timezone_set("Asia/Manila");
    $today = date('Y-m-d');
    
    if(!isset($_SESSION["logged_username"])) 
    {
        header("location: /Kasangguni/login");
    }
    else
    {
        $empno = $_SESSION["logged_username"];
    }
?>