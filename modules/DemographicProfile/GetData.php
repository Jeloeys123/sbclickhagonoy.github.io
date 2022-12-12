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
        
        if($type == "SETDEMOGRAPHICDATA")
		{
            $censusyear = "";
            $housepopulation = "";
            $noofhouseholds = "";
            $avghousehold = "";
			$demographicprofiledata_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $demographicRowQuery = "SELECT
                    ID 
                FROM
                    demographic_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode' 
                ORDER BY
                    CENSUSYEAR DESC";
            $demographicRowResult = $db_controller->numRows($demographicRowQuery);
			$totalData = $demographicRowResult;
			// WHEN THERE IS NO SEARCH PARAMETER THEN THE TOTAL ROWS = TOTAL NUMBER FILTERED ROWS.
			$totalFiltered = $totalData;
			
            $demographicMstrQuery = "SELECT
                    CENSUSYEAR,
                    HOUSEHOLD_POPULATION,
                    NUMBER_OF_HOUSEHOLDS,
                    AVERAGE_HOUSEHOLD 
                FROM
                    demographic_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$demographicMstrQuery.= " AND (CENSUSYEAR LIKE '%".$requestData['search']['value']."%' OR HOUSEHOLD_POPULATION LIKE '%".$requestData['search']['value']."%' OR NUMBER_OF_HOUSEHOLDS LIKE '%".$requestData['search']['value']."%' OR AVERAGE_HOUSEHOLD LIKE '%".$requestData['search']['value']."%')";
            }
			$demographicRowsResult = $db_controller->numRows($demographicMstrQuery);
			$totalFiltered = $demographicRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$demographicMstrQuery .= " ORDER BY CENSUSYEAR DESC,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$demographicMstrResult = $db_controller->runQuery($demographicMstrQuery);
			if($demographicMstrResult != NULL)
			{
				foreach($demographicMstrResult as $demographicMstrData)
				{  
                    $censusyear = $demographicMstrData['CENSUSYEAR'];
                    $housepopulation = $demographicMstrData['HOUSEHOLD_POPULATION'];
                    $noofhouseholds = $demographicMstrData['NUMBER_OF_HOUSEHOLDS'];
                    $avghousehold = $demographicMstrData['AVERAGE_HOUSEHOLD'];
                    
                    //PREPARING AN ARRAY
					$nestedData = array(); 
                    $nestedData[] = "<center>".$censusyear."</center>";
					$nestedData[] = "<center>".number_format($housepopulation)."</center>";
					$nestedData[] = "<center>".number_format($noofhouseholds)."</center>";
					$nestedData[] = "<center>".$avghousehold."</center>";
					$nestedData[] = "<center>
                                <button type = 'button' class = 'btn btn-primary btn-sm isBtnEdit' title = 'Edit Demographic Data' id = '$censusyear'><i class = 'uil uil-edit-alt'></i> </button>
                                <button type = 'button' class = 'btn btn-danger btn-sm isBtnDelete' title = 'Delete Demographic Data' id = '$censusyear'><i class = 'uil uil-trash-alt'></i> </button>
                            </center>";
                    $demographicprofiledata_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $demographicprofiledata_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
        
        if($type == "SETUPDATEDDEMOGRAPHICDATA")
		{
            $censusyear = "";
            $housepopulation = "";
            $noofhouseholds = "";
            $avghousehold = "";
			$demographicprofiledata_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $demographicRowQuery = "SELECT
                    ID 
                FROM
                    demographic_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode' 
                ORDER BY
                    CENSUSYEAR DESC";
            $demographicRowResult = $db_controller->numRows($demographicRowQuery);
			$totalData = $demographicRowResult;
			// WHEN THERE IS NO SEARCH PARAMETER THEN THE TOTAL ROWS = TOTAL NUMBER FILTERED ROWS.
			$totalFiltered = $totalData;
			
            $demographicMstrQuery = "SELECT
                    CENSUSYEAR,
                    HOUSEHOLD_POPULATION,
                    NUMBER_OF_HOUSEHOLDS,
                    AVERAGE_HOUSEHOLD 
                FROM
                    demographic_mstr 
                WHERE
                    UPPER( BRGYCODE ) = '$barangaycode'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$demographicMstrQuery.= " AND (CENSUSYEAR LIKE '%".$requestData['search']['value']."%' OR HOUSEHOLD_POPULATION LIKE '%".$requestData['search']['value']."%' OR NUMBER_OF_HOUSEHOLDS LIKE '%".$requestData['search']['value']."%' OR AVERAGE_HOUSEHOLD LIKE '%".$requestData['search']['value']."%')";
            }
			$demographicRowsResult = $db_controller->numRows($demographicMstrQuery);
			$totalFiltered = $demographicRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$demographicMstrQuery .= " ORDER BY CENSUSYEAR DESC,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$demographicMstrResult = $db_controller->runQuery($demographicMstrQuery);
			if($demographicMstrResult != NULL)
			{
				foreach($demographicMstrResult as $demographicMstrData)
				{  
                    $censusyear = $demographicMstrData['CENSUSYEAR'];
                    $housepopulation = $demographicMstrData['HOUSEHOLD_POPULATION'];
                    $noofhouseholds = $demographicMstrData['NUMBER_OF_HOUSEHOLDS'];
                    $avghousehold = $demographicMstrData['AVERAGE_HOUSEHOLD'];
                    
                    //PREPARING AN ARRAY
					$nestedData = array(); 
                    $nestedData[] = "<center>".$censusyear."</center>";
					$nestedData[] = "<center>".number_format($housepopulation)."</center>";
					$nestedData[] = "<center>".number_format($noofhouseholds)."</center>";
					$nestedData[] = "<center>".$avghousehold."</center>";
                    $demographicprofiledata_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $demographicprofiledata_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
    }
    
    $db_controller->closeQuery();
?>