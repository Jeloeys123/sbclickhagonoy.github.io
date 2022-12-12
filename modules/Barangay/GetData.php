<?php
    date_default_timezone_set("Asia/Manila");
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
	
	if(isset($_POST['type']))
	{
        $type = $_POST['type'];
		
		if($type == "SETBARANGAYDATA")
		{
            $brgyname = "";
            $email = "";
			$mobile = "";
			$telephone = "";
			$barangaymasterlistdata_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "barangay_mstr.ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $brgyMstrRowQuery = "SELECT
					barangay_mstr.ID 
				FROM
					barangay_mstr
					LEFT JOIN barangay_profile ON barangay_profile.BRGYCODE = barangay_mstr.BRGYCODE 
				WHERE
					1 = 1 
				ORDER BY
					barangay_mstr.BRGYNAME";
            $brgyMstrRowResult = $db_controller->numRows($brgyMstrRowQuery);
			$totalData = $brgyMstrRowResult;
			// WHEN THERE IS NO SEARCH PARAMETER THEN THE TOTAL ROWS = TOTAL NUMBER FILTERED ROWS.
			$totalFiltered = $totalData;
			
            $brgyMstrQuery = "SELECT
					barangay_mstr.BRGYNAME,
					barangay_profile.EMAIL,
					barangay_profile.MOBILE,
					barangay_profile.TELEPHONE 
				FROM
					barangay_mstr
					LEFT JOIN barangay_profile ON barangay_profile.BRGYCODE = barangay_mstr.BRGYCODE 
				WHERE
					1 = 1";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$brgyMstrQuery.= " AND (barangay_mstr.BRGYNAME LIKE '%".$requestData['search']['value']."%' OR barangay_profile.EMAIL LIKE '%".$requestData['search']['value']."%' OR barangay_profile.MOBILE LIKE '%".$requestData['search']['value']."%' OR barangay_profile.TELEPHONE LIKE '%".$requestData['search']['value']."%')";
            }
			$brgyMstrQuery .= " GROUP BY barangay_mstr.BRGYCODE";
			$brgyMstrRowsResult = $db_controller->numRows($brgyMstrQuery);
			$totalFiltered = $brgyMstrRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$brgyMstrQuery .= " ORDER BY barangay_mstr.BRGYNAME,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$brgyMstrResult = $db_controller->runQuery($brgyMstrQuery);
			if($brgyMstrResult != NULL)
			{
				foreach($brgyMstrResult as $brgyMstrData)
				{  
                    $brgyname = $brgyMstrData['BRGYNAME'];
                    $email = $brgyMstrData['EMAIL'];
                    $mobile = $brgyMstrData['MOBILE'];
                    $telephone = $brgyMstrData['TELEPHONE'];
                    
                    //PREPARING AN ARRAY
					$nestedData = array(); 
					$nestedData[] = "<center style = 'text-align: left;'>".$brgyname."</center>";
					$nestedData[] = "<center style = 'text-align: left'>".strtolower($email)."</center>";
					$nestedData[] = "<center style = 'text-align: left'>".$mobile."</center>";
					$nestedData[] = "<center style = 'text-align: left'>".$telephone."</center>";
                    $barangaymasterlistdata_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $barangaymasterlistdata_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
    }
	
	$db_controller->closeQuery();
?>