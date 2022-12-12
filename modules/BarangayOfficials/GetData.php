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
        
        if($type == "GETBARANGAYOFFICIALS")
		{
            $firstname = "";
            $middlename = "";
            $middleinitials = "";
            $lastname = "";
            $suffixname = "";
            $position = "";
            $email = "";
            $mobile = "";
            $fullname = "";
			$barangayofficials_arr = array();
			
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
                    UPPER( barangay_officials.BRGYCODE ) = '$barangaycode' 
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
                    barangay_officials.POSITION,
                    position_mstr.DESCRIPTION,
                    barangay_officials.EMAIL,
                    barangay_officials.MOBILE 
                FROM
                    barangay_officials
                    INNER JOIN position_mstr ON position_mstr.POSITIONCODE = barangay_officials.POSITION 
                WHERE
                    UPPER( barangay_officials.BRGYCODE ) = '$barangaycode'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$brgyOfficialsQuery.= " AND (CONCAT(barangay_officials.FIRSTNAME,' ',barangay_officials.LASTNAME) LIKE '%".$requestData['search']['value']."%' OR CONCAT(barangay_officials.LASTNAME,' ',barangay_officials.FIRSTNAME) LIKE '%".$requestData['search']['value']."%' OR position_mstr.DESCRIPTION LIKE '%".$requestData['search']['value']."%' OR barangay_officials.EMAIL LIKE '%".$requestData['search']['value']."%' OR barangay_officials.MOBILE LIKE '%".$requestData['search']['value']."%')";
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
                    $positioncode = $brgyOfficialsData['POSITION'];
                    $description = $brgyOfficialsData['DESCRIPTION'];
                    $email = $brgyOfficialsData['EMAIL'];
                    $mobile = $brgyOfficialsData['MOBILE'];
                    
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
                                $fullname = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],01).". ".$lastname;
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
					$nestedData[] = "<center style = 'text-align: left;'>".$description."</center>";
					$nestedData[] = "<center style = 'text-align: left'>".strtolower($email)."</center>";
					$nestedData[] = "<center style = 'text-align: left'>".$mobile."</center>";
					$nestedData[] = "<center>
                                <button type = 'button' class = 'btn btn-primary btn-sm isBtnUpdate' title = 'Update Record' id = '$firstname,$lastname,$positioncode'><i class = 'uil uil-edit'></i> </button>
                                <button type = 'button' class = 'btn btn-danger btn-sm isBtnDelete' title = 'Delete Record' id = '$firstname,$lastname,$positioncode'><i class = 'uil uil-trash'></i> </button>
                            </center>";
                    $barangayofficials_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $barangayofficials_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
    }
    
    $db_controller->closeQuery();
?>