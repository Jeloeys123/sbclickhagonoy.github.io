<?php
    date_default_timezone_set("Asia/Manila");
    
    $title = "";
    $startdate = "";
    $enddate = "";
    $content = "";
    $filename = "";
    $createddate = "";
    $createdtime = "";
    $updatedby = "";
    $updateddate = "";
    $updatedtime = "";
    $datecreated = "";
    $dateupdated = "";
    $announcementMstrQuery = "SELECT
            TITLE,
            STARTDATE,
            ENDDATE,
            CONTENT,
            FILE,
            CREATEDDATE,
            CREATEDTIME,
            UPDATEDBY,
            UPDATEDDATE,
            UPDATEDTIME 
        FROM
            announcement_mstr 
        WHERE
            UPPER( ANNCODE ) = '$announcementcode'";
    $announcementMstrResult = $db_controller->runQuery($announcementMstrQuery);
    if($announcementMstrResult != NULL)
    {
        foreach($announcementMstrResult as $announcementMstrData)
        {
            $title = $announcementMstrData['TITLE'];
            $startdate = $announcementMstrData['STARTDATE'];
            $enddate = $announcementMstrData['ENDDATE'];
            $content = $announcementMstrData['CONTENT'];
            $filename = $announcementMstrData['FILE'];
            $createddate = $announcementMstrData['CREATEDDATE'];
            $createdtime = $announcementMstrData['CREATEDTIME'];
            $updatedby = $announcementMstrData['UPDATEDBY'];
            $updateddate = $announcementMstrData['UPDATEDDATE'];
            $updatedtime = $announcementMstrData['UPDATEDTIME'];
        }
    }
    
    $createddate = DateTime::createFromFormat("Y-m-d", $createddate);
    if(!empty($createddate))
    {
        $datecreated = $createddate->format("F d, Y");
    }
    
    $updateddate = DateTime::createFromFormat("Y-m-d", $updateddate);
    if(!empty($updateddate))
    {
        $dateupdated = $updateddate->format("F d, Y");
    }
?>