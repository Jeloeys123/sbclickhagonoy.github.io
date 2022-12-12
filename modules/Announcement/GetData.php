<?php
    date_default_timezone_set("Asia/Manila");
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
    include $common_path."session_logged.php";
    $barangaycode = $_SESSION['logged_brgycode'];
	
	if(isset($_POST['type']))
	{
        $type = $_POST['type'];
        
        if($type == "SETANNOUNCEMENTDATA")
		{
            $brgyname = "";
            $brgycount = "";
            $anncode = "";
            $title = "";
            $enddate = "";
            $description = "";
            $createddate = "";
            $createdtime = "";
            $filename = "";
			$announcementdata_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "announcement_mstr.ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $announcementRowQuery = "SELECT
                    announcement_mstr.ID 
                FROM
                    announcement_mstr
                    INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = announcement_mstr.BRGYCODE 
                WHERE
                    UPPER( announcement_mstr.STATUS ) = 'ONGOING' 
                GROUP BY
                    announcement_mstr.ANNCODE 
                ORDER BY
                    announcement_mstr.CREATEDDATE DESC,
                    announcement_mstr.CREATEDTIME DESC";
            $announcementRowResult = $db_controller->numRows($announcementRowQuery);
			$totalData = $announcementRowResult;
			// WHEN THERE IS NO SEARCH PARAMETER THEN THE TOTAL ROWS = TOTAL NUMBER FILTERED ROWS.
			$totalFiltered = $totalData;
			
            $announcementMstrQuery = "SELECT
                    GROUP_CONCAT( barangay_mstr.BRGYNAME ) AS BRGYNAME,
                    COUNT( barangay_mstr.BRGYNAME ) AS BRGYNAMECOUNT,
                    announcement_mstr.ANNCODE,
                    announcement_mstr.TITLE,
                    announcement_mstr.ENDDATE,
                    announcement_mstr.CONTENT,
                    announcement_mstr.FILE,
                    announcement_mstr.CREATEDDATE,
                    announcement_mstr.CREATEDTIME 
                FROM
                    announcement_mstr
                    INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = announcement_mstr.BRGYCODE 
                WHERE
                    UPPER( announcement_mstr.STATUS ) = 'ONGOING'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$announcementMstrQuery.= " AND (barangay_mstr.BRGYNAME LIKE '%".$requestData['search']['value']."%' OR announcement_mstr.TITLE LIKE '%".$requestData['search']['value']."%' OR announcement_mstr.ENDDATE LIKE '%".$requestData['search']['value']."%' OR announcement_mstr.CONTENT LIKE '%".$requestData['search']['value']."%' OR announcement_mstr.CREATEDDATE LIKE '%".$requestData['search']['value']."%' OR announcement_mstr.CREATEDTIME LIKE '%".$requestData['search']['value']."%')";
            }
            $announcementMstrQuery .= " GROUP BY announcement_mstr.ANNCODE";
			$announcementRowsResult = $db_controller->numRows($announcementMstrQuery);
			$totalFiltered = $announcementRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$announcementMstrQuery .= " ORDER BY announcement_mstr.CREATEDDATE DESC, announcement_mstr.CREATEDTIME DESC,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$announcementMstrResult = $db_controller->runQuery($announcementMstrQuery);
			if($announcementMstrResult != NULL)
			{
				foreach($announcementMstrResult as $announcementMstrData)
				{  
                    $brgyname = $announcementMstrData['BRGYNAME'];
                    $brgycount = $announcementMstrData['BRGYNAMECOUNT'];
                    $anncode = $announcementMstrData['ANNCODE'];
                    $title = $announcementMstrData['TITLE'];
                    $enddate = $announcementMstrData['ENDDATE'];
                    $description = $announcementMstrData['CONTENT'];
                    $createddate = $announcementMstrData['CREATEDDATE'];
                    $createdtime = $announcementMstrData['CREATEDTIME'];
                    $filename = $announcementMstrData['FILE'];
                    
                    //PREPARING AN ARRAY
                    $nestedData = array(); 
                    if($brgycount >= 26)
                    {
                        $nestedData[] = "<center style = 'text-align: left;'> All Barangays </center>";
                    }
                    else
                    {
                        $nestedData[] = "<center style = 'text-align: left;'>".$brgyname."</center>";
                    }
                    $nestedData[] = "<center style = 'text-align: left'>".$title."</center>";
                    $nestedData[] = "<center style = 'text-align: left'>".$description."</center>";
                    $nestedData[] = "<center style = 'text-align: left;'>".$enddate."</center>";
                    $nestedData[] = "<center style = 'text-align: left;'>".$createddate."<br>".$createdtime."</center>";
                    if($filename == "")
                    {
                        $nestedData[] = "<center style = 'text-align: left;'>
                                <button type = 'button' class = 'btn btn-primary btn-sm isBtnEdit' title = 'Edit Announcement' id = '$anncode'><i class = 'uil uil-edit'></i> </button>
                                <button type = 'button' class = 'btn btn-danger btn-sm isBtnDelete' title = 'Delete Announcement' id = '$anncode'><i class = 'uil uil-trash-alt'></i> </button>
                            </center>";
                    }
                    else
                    {
                        $nestedData[] = "<center style = 'text-align: left;'>
                                <button type = 'button' class = 'btn btn-primary btn-sm isBtnEdit' title = 'Edit Announcement' id = '$anncode'><i class = 'uil uil-edit-alt'></i> </button>
                                <button type = 'button' class = 'btn btn-danger btn-sm isBtnDelete' title = 'Delete Announcement' id = '$anncode'><i class = 'uil uil-trash-alt'></i> </button>
                                <button type = 'button' class = 'btn btn-dark btn-sm isBtnDownload' title = 'Download File' id = '$anncode'><i class = 'uil uil-download-alt'></i> </button>
                            </center>";
                    }
                    $announcementdata_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $announcementdata_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
    }
    
	$db_controller->closeQuery();
?>