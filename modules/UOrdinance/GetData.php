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
        
        if($type == "SETORDINANCEDATE")
		{
            $ordinanceno = "";
            $ordinancetitle = "";
            $description = "";
            $effectivedate = "";
            $file = "";
            $submitteddate = "";
            $status = "";
            $remarks = "";
			$ordinancedata_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $ordinanceRowQuery = "SELECT
                    ID 
                FROM
                    ordinance_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode' 
                ORDER BY
                    ORDYEAR DESC,
                    ORDCODE ASC";
            $ordinanceRowResult = $db_controller->numRows($ordinanceRowQuery);
			$totalData = $ordinanceRowResult;
			// WHEN THERE IS NO SEARCH PARAMETER THEN THE TOTAL ROWS = TOTAL NUMBER FILTERED ROWS.
			$totalFiltered = $totalData;
			
            $ordinanceMstrQuery = "SELECT
                    ORDCODE,
                    ORDTITLE,
                    DESCRIPTION,
                    EFFECTIVEDATE,
                    FILE,
                    SUBMITTEDDATE,
                    STATUS,
                    REMARKS 
                FROM
                    ordinance_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$ordinanceMstrQuery.= " AND (ORDTITLE LIKE '%".$requestData['search']['value']."%' OR DESCRIPTION LIKE '%".$requestData['search']['value']."%' OR EFFECTIVEDATE LIKE '%".$requestData['search']['value']."%' OR SUBMITTEDDATE LIKE '%".$requestData['search']['value']."%' OR STATUS LIKE '%".$requestData['search']['value']."%' OR REMARKS LIKE '%".$requestData['search']['value']."%')";
            }
			$ordinanceRowsResult = $db_controller->numRows($ordinanceMstrQuery);
			$totalFiltered = $ordinanceRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$ordinanceMstrQuery .= " ORDER BY ORDYEAR DESC, ORDCODE ASC,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$ordinanceMstrResult = $db_controller->runQuery($ordinanceMstrQuery);
			if($ordinanceMstrResult != NULL)
			{
				foreach($ordinanceMstrResult as $ordinanceMstrData)
				{  
                    $ordinanceno = $ordinanceMstrData['ORDCODE'];
                    $ordinancetitle = $ordinanceMstrData['ORDTITLE'];
                    $description = $ordinanceMstrData['DESCRIPTION'];
                    $effectivedate = $ordinanceMstrData['EFFECTIVEDATE'];
                    $file = $ordinanceMstrData['FILE'];
                    $submitteddate = $ordinanceMstrData['SUBMITTEDDATE'];
                    $status = $ordinanceMstrData['STATUS'];
                    $remarks = $ordinanceMstrData['REMARKS'];
                    
                    //PREPARING AN ARRAY
					$nestedData = array(); 
                    $nestedData[] = "<center style = 'text-align: left;'>".$ordinancetitle."</center>";
					$nestedData[] = "<center style = 'text-align: left;'>".$description."</center>";
                    if($status == "APPROVED")
                    {
                        $nestedData[] = "<center style = 'text-align: left;'>".$effectivedate."</center>";
                    }
                    else
                    {
                        $nestedData[] = "<center style = 'text-align: left;'>".$submitteddate."</center>";
                    }
					$nestedData[] = "<center style = 'text-align: left;'>".$status."</center>";
					$nestedData[] = "<center style = 'text-align: left;'>".$remarks."</center>";
					$nestedData[] = "<center style = 'text-align: left;'>
                                <button type = 'button' class = 'btn btn-primary btn-sm isBtnEdit' title = 'Edit Ordinance' id = '$ordinanceno'><i class = 'uil uil-edit-alt'></i> </button>
                                <button type = 'button' class = 'btn btn-dark btn-sm isBtnDownload' title = 'Download File' id = '$ordinanceno'><i class = 'uil uil-download-alt'></i> </button>
                            </center>";
                    $ordinancedata_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $ordinancedata_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
    }
    
    $db_controller->closeQuery();
?>