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
        
        if($type == "SETACTIVITYLOGDATA")
		{
            $logscode = "";
            $logtitle = "";
            $logdesc = "";
            $status = "";
            $remarks = "";
            $fileupload = "";
            $createddate = "";
            $datecreated = "";
			$activitylogdata_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $logsRowQuery = "SELECT
                    ID 
                FROM
                    logs_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode' 
                GROUP BY
                    LOGSCODE 
                ORDER BY
                    CREATEDDATE DESC,
                    CREATEDTIME DESC";
            $logsRowResult = $db_controller->numRows($logsRowQuery);
			$totalData = $logsRowResult;
			// WHEN THERE IS NO SEARCH PARAMETER THEN THE TOTAL ROWS = TOTAL NUMBER FILTERED ROWS.
			$totalFiltered = $totalData;
			
            $logsMstrQuery = "SELECT
                    LOGSCODE,
                    LOGTITLE,
                    LOGDESC,
                    STATUS,
                    REMARKS,
                    FILE,
                    CREATEDDATE 
                FROM
                    logs_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$logsMstrQuery.= " AND (LOGTITLE LIKE '%".$requestData['search']['value']."%' OR LOGDESC LIKE '%".$requestData['search']['value']."%' OR STATUS LIKE '%".$requestData['search']['value']."%' OR REMARKS LIKE '%".$requestData['search']['value']."%' OR CREATEDDATE LIKE '%".$requestData['search']['value']."%')";
            }
            $logsMstrQuery .= " GROUP BY LOGSCODE";
			$logsRowsResult = $db_controller->numRows($logsMstrQuery);
			$totalFiltered = $logsRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$logsMstrQuery .= " ORDER BY CREATEDDATE DESC, CREATEDTIME DESC,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
            $logsMstrResult = $db_controller->runQuery($logsMstrQuery);
			if($logsMstrResult != NULL)
			{
				foreach($logsMstrResult as $logsMstrData)
				{  
                    $logscode = $logsMstrData['LOGSCODE'];
                    $logtitle = $logsMstrData['LOGTITLE'];
                    $logdesc = $logsMstrData['LOGDESC'];
                    $status = $logsMstrData['STATUS'];
                    $remarks = $logsMstrData['REMARKS'];
                    $fileupload = $logsMstrData['FILE'];
                    $createddate = $logsMstrData['CREATEDDATE'];
                    
                    $createddate = DateTime::createFromFormat("Y-m-d", $createddate);
                    if(!empty($createddate))
                    {
                        $datecreated = $createddate->format("F d, Y");
                    }
                    
                    //PREPARING AN ARRAY
                    $nestedData = array(); 
                    $nestedData[] = "<center style = 'text-align: left'>".$datecreated."</center>";
                    $nestedData[] = "<center style = 'text-align: left'><b>".$logtitle."</b><br>".$logdesc."</center>";
                    $nestedData[] = "<center style = 'text-align: left'>".$status."</center>";
                    $nestedData[] = "<center style = 'text-align: left'>".$remarks."</center>";
                    if($status == "DELETED" || $status == "EXPIRED" || $fileupload == "")
                    {
                        $nestedData[] = "<center style = 'text-align: left;'>
                            <button disabled type = 'button' class = 'btn btn-dark btn-sm isBtnDownload' title = 'Download File' id = '$logscode'><i class = 'uil uil-download-alt'></i> </button>
                            </center>";
                    }
                    else
                    {
                        $nestedData[] = "<center style = 'text-align: left;'>
                            <button type = 'button' class = 'btn btn-dark btn-sm isBtnDownload' title = 'Download File' id = '$logscode'><i class = 'uil uil-download-alt'></i> </button>
                            </center>";
                    }
                    $nestedData[] = "<center> </center>";
                    $activitylogdata_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $activitylogdata_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
    }
    
	$db_controller->closeQuery();
?>