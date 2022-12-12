<?php
    date_default_timezone_set("Asia/Manila");
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
	
	if(isset($_POST['type']))
	{
        $type = $_POST['type'];
        
		if($type == "GETDEMOGRAPHICDATA")
		{
            $brgycode = $_GET['id'];
            $censusyear = "";
            $householdpop = "";
            $noofhouseholds = "";
			$avgofhouseholds = "";
			$demographicdata_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $demographicMstrRowQuery = "SELECT
					ID 
				FROM
					demographic_mstr 
				WHERE
					UPPER( BRGYCODE ) = '$brgycode' 
				ORDER BY
					CENSUSYEAR DESC";
            $demographicMstrRowResult = $db_controller->numRows($demographicMstrRowQuery);
			$totalData = $demographicMstrRowResult;
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
					UPPER( BRGYCODE ) = '$brgycode'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$demographicMstrQuery.= " AND (CENSUSYEAR LIKE '%".$requestData['search']['value']."%' OR HOUSEHOLD_POPULATION LIKE '%".$requestData['search']['value']."%' OR NUMBER_OF_HOUSEHOLDS LIKE '%".$requestData['search']['value']."%' OR AVERAGE_HOUSEHOLD LIKE '%".$requestData['search']['value']."%')";
            }
			$demographicMstrRowsResult = $db_controller->numRows($demographicMstrQuery);
			$totalFiltered = $demographicMstrRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$demographicMstrQuery .= " ORDER BY CENSUSYEAR DESC,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$demographicMstrResult = $db_controller->runQuery($demographicMstrQuery);
			if($demographicMstrResult != NULL)
			{
				foreach($demographicMstrResult as $demographicMstrData)
				{  
                    $censusyear = $demographicMstrData['CENSUSYEAR'];
                    $householdpop = $demographicMstrData['HOUSEHOLD_POPULATION'];
                    $noofhouseholds = $demographicMstrData['NUMBER_OF_HOUSEHOLDS'];
                    $avgofhouseholds = $demographicMstrData['AVERAGE_HOUSEHOLD'];
                    
                    //PREPARING AN ARRAY
					$nestedData = array(); 
					$nestedData[] = "<center>".$censusyear."</center>";
					$nestedData[] = "<center>".$householdpop."</center>";
					$nestedData[] = "<center>".$noofhouseholds."</center>";
					$nestedData[] = "<center>".$avgofhouseholds."%</center>";
                    $demographicdata_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $demographicdata_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
		
		if($type == "SETBARANGAYOFFICIALDATA")
		{
            $brgycode = $_GET['id'];
            $firstname = "";
			$middlename = "";
			$middleinitials = "";
			$lastname = "";
			$suffixname = "";
			$fullname = "";
            $position = "";
			$barangayofficialdata_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "barangay_officials.ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $brgyOfficialsRowQuery = "SELECT
					barangay_officials.ID 
				FROM
					barangay_officials
					INNER JOIN position_mstr ON position_mstr.POSITIONCODE = barangay_officials.POSITION 
				WHERE
					UPPER( barangay_officials.BRGYCODE ) = '$brgycode' 
				ORDER BY
					barangay_officials.TAG,
					barangay_officials.FIRSTNAME,
					barangay_officials.LASTNAME";
            $brgyOfficialsRowResult = $db_controller->numRows($brgyOfficialsRowQuery);
			$totalData = $brgyOfficialsRowResult;
			// WHEN THERE IS NO SEARCH PARAMETER THEN THE TOTAL ROWS = TOTAL NUMBER FILTERED ROWS.
			$totalFiltered = $totalData;
			
            $brgyOfficialsQuery = "SELECT
					barangay_officials.FIRSTNAME,
					barangay_officials.MIDDLENAME,
					barangay_officials.LASTNAME,
					barangay_officials.SUFFIXNAME,
					position_mstr.DESCRIPTION 
				FROM
					barangay_officials
					INNER JOIN position_mstr ON position_mstr.POSITIONCODE = barangay_officials.POSITION 
				WHERE
					UPPER( barangay_officials.BRGYCODE ) = '$brgycode'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$brgyOfficialsQuery.= " AND (CONCAT(barangay_officials.FIRSTNAME,' ',barangay_officials.LASTNAME) LIKE '%".$requestData['search']['value']."%' OR CONCAT(barangay_officials.LASTNAME,' ',barangay_officials.FIRSTNAME) LIKE '%".$requestData['search']['value']."%' OR position_mstr.DESCRIPTION LIKE '%".$requestData['search']['value']."%')";
            }
			$brgyOfficialsRowsResult = $db_controller->numRows($brgyOfficialsQuery);
			$totalFiltered = $brgyOfficialsRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$brgyOfficialsQuery .= " ORDER BY barangay_officials.TAG, barangay_officials.FIRSTNAME, barangay_officials.LASTNAME,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$brgyOfficialsResult = $db_controller->runQuery($brgyOfficialsQuery);
			if($brgyOfficialsResult != NULL)
			{
				foreach($brgyOfficialsResult as $brgyOfficialsData)
				{  
                    $firstname = $brgyOfficialsData['FIRSTNAME'];
                    $middlename = $brgyOfficialsData['MIDDLENAME'];
                    $lastname = $brgyOfficialsData['LASTNAME'];
                    $suffixname = $brgyOfficialsData['SUFFIXNAME'];
                    $position = $brgyOfficialsData['DESCRIPTION'];
					
					if($suffixname == "")
					{
						if($middlename == "")
						{
							$fullname = $firstname." ".$lastname;
						}
						else
						{
							$middleinitials = explode(" ",$middlename);
							if(sizeof($middleinitials) == 2)
							{
								$fullname = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],0,1).". ".$lastname;
							}
							else
							{
								$fullname = $firstname." ".substr($middleinitials[0],0,1).". ".$lastname;
							}
						}
					}
					else
					{
						if($middlename == "")
						{
							$fullname = $firstname." ".$lastname.", ".$suffixname;
						}
						else
						{
							$middleinitials = explode(" ",$middlename);
							if(sizeof($middleinitials) == 2)
							{
								$fullname = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],0,1).". ".$lastname.", ".$suffixname;
							}
							else
							{
								$fullname = $firstname." ".substr($middleinitials[0],0,1).". ".$lastname.", ".$suffixname;
							}
						}
					}
                    
                    //PREPARING AN ARRAY
					$nestedData = array(); 
					$nestedData[] = "<center style = 'text-align: left;'>".$fullname."</center>";
					$nestedData[] = "<center style = 'text-align: left;'>".$position."</center>";
                    $barangayofficialdata_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $barangayofficialdata_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
    }
	
	$db_controller->closeQuery();
?>