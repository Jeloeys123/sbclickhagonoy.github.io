<?php
    date_default_timezone_set("Asia/Manila");
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
	
	if(isset($_POST['type']))
	{
        $type = $_POST['type'];
        
        if($type == "GETACTIVEACCOUNT")
		{
            $brgycode = "";
            $brgyname = "";
            $empcode = "";
            $firstname = "";
            $middlename = "";
            $middleinitials = "";
            $lastname = "";
            $email = "";
			$mobile = "";
			$position = "";
			$status = "";
            $loginattempt = "";
            $representative = "";
			$updateuser_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "barangay_representative.ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $brgyRepresentativeRowQuery = "SELECT
                    barangay_representative.ID 
                FROM
                    barangay_representative
                    INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = barangay_representative.BRGYCODE
                    INNER JOIN user_mstr ON user_mstr.EMPCODE = barangay_representative.EMPCODE
                    LEFT JOIN position_mstr ON position_mstr.POSITIONCODE = barangay_representative.POSITION 
                WHERE
                    barangay_representative.STATUS = 'ACTIVE' 
                ORDER BY
                    barangay_mstr.BRGYNAME ASC,
                    barangay_representative.CREATEDDATE";
            $brgyRepresentativeRowResult = $db_controller->numRows($brgyRepresentativeRowQuery);
			$totalData = $brgyRepresentativeRowResult;
			// WHEN THERE IS NO SEARCH PARAMETER THEN THE TOTAL ROWS = TOTAL NUMBER FILTERED ROWS.
			$totalFiltered = $totalData;
			
            $brgyRepresentativeQuery = "SELECT
                    barangay_representative.BRGYCODE,
                    barangay_mstr.BRGYNAME,
                    barangay_representative.EMPCODE,
                    barangay_representative.FIRSTNAME,
                    barangay_representative.MIDDLENAME,
                    barangay_representative.LASTNAME,
                    barangay_representative.SUFFIXNAME,
                    barangay_representative.EMAIL,
                    barangay_representative.MOBILE,
                    position_mstr.DESCRIPTION,
                    barangay_representative.STATUS,
                    user_mstr.LOGINATTEMPT 
                FROM
                    barangay_representative
                    INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = barangay_representative.BRGYCODE
                    INNER JOIN user_mstr ON user_mstr.EMPCODE = barangay_representative.EMPCODE
                    LEFT JOIN position_mstr ON position_mstr.POSITIONCODE = barangay_representative.POSITION 
                WHERE
                    UPPER( barangay_representative.STATUS ) = 'ACTIVE'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$brgyRepresentativeQuery.= " AND (barangay_mstr.BRGYNAME LIKE '%".$requestData['search']['value']."%' OR CONCAT(barangay_representative.FIRSTNAME,' ',barangay_representative.LASTNAME) LIKE '%".$requestData['search']['value']."%' OR CONCAT(barangay_representative.LASTNAME,' ',barangay_representative.FIRSTNAME) LIKE '%".$requestData['search']['value']."%' OR barangay_representative.EMAIL LIKE '%".$requestData['search']['value']."%' OR barangay_representative.MOBILE LIKE '%".$requestData['search']['value']."%' OR position_mstr.DESCRIPTION LIKE '%".$requestData['search']['value']."%' OR barangay_representative.STATUS LIKE '%".$requestData['search']['value']."%')";
            }
			$brgyRepresentativeRowsResult = $db_controller->numRows($brgyRepresentativeQuery);
			$totalFiltered = $brgyRepresentativeRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$brgyRepresentativeQuery .= " ORDER BY barangay_mstr.BRGYNAME ASC, barangay_representative.CREATEDDATE ASC,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$brgyRepresentativeResult = $db_controller->runQuery($brgyRepresentativeQuery);
			if($brgyRepresentativeResult != NULL)
			{
				foreach($brgyRepresentativeResult as $brgyRepresentativeData)
				{  
                    $brgycode = $brgyRepresentativeData['BRGYCODE'];
                    $empcode = $brgyRepresentativeData['EMPCODE'];
                    $brgyname = $brgyRepresentativeData['BRGYNAME'];
                    $firstname = $brgyRepresentativeData['FIRSTNAME'];
                    $middlename = $brgyRepresentativeData['MIDDLENAME'];
                    $lastname = $brgyRepresentativeData['LASTNAME'];
                    $suffixname = $brgyRepresentativeData['SUFFIXNAME'];
                    $email = $brgyRepresentativeData['EMAIL'];
                    $mobile = $brgyRepresentativeData['MOBILE'];
                    $position = $brgyRepresentativeData['DESCRIPTION'];
                    $status = $brgyRepresentativeData['STATUS'];
                    $loginattempt = $brgyRepresentativeData['LOGINATTEMPT'];
                    
                    if($suffixname == "")
                    {
                        if($middlename == "")
                        {
                            $representative = $firstname." ".$lastname;
                        }
                        else
                        {
                            $middleinitials = explode(" ",$middlename);
                            if(sizeof($middleinitials) == 2)
                            {
                                $representative = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],0,1).". ".$lastname;
                            }
                            else
                            {
                                $representative = $firstname." ".substr($middleinitials[0],0,1).". ".$lastname;
                            }
                        }
                    }
                    else
                    {
                        if($middlename == "")
                        {
                            $representative = $firstname." ".$lastname.", ".$suffixname;
                        }
                        else
                        {
                            $middleinitials = explode(" ",$middlename);
                            if(sizeof($middleinitials) == 2)
                            {
                                $representative = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],0,1).". ".$lastname.", ".$suffixname;
                            }
                            else
                            {
                                $representative = $firstname." ".substr($middleinitials[0],0,1).". ".$lastname.", ".$suffixname;
                            }
                        }
                    }
                    
                    //PREPARING AN ARRAY
					$nestedData = array(); 
					$nestedData[] = "<center style = 'text-align: left;'>".$brgyname."</center>";
					$nestedData[] = "<center style = 'text-align: left'>".$representative."</center>";
					$nestedData[] = "<center style = 'text-align: left'>".strtolower($email)."</center>";
					$nestedData[] = "<center style = 'text-align: left'>".$mobile."</center>";
					$nestedData[] = "<center style = 'text-align: left'>".$position."</center>";
					$nestedData[] = "<center>".strtoupper($status)."</center>";
                    if($loginattempt == 0)
                    {
                        $nestedData[] = "<center>
                                        <button type = 'button' class = 'btn btn-primary btn-sm isBtnUpdateUser' title = 'Update User Account' id = '$empcode'><i class = 'uil uil-edit'></i> </button>
                                        <button type = 'button' class = 'btn btn-info btn-sm isBtnUnblockUser' title = 'Unblock User' id = '$empcode'><i class = 'uil uil-unlock'></i> </button>
                                        <button type = 'button' class = 'btn btn-warning btn-sm isBtnResetPassword' title = 'Reset Password' id = '$empcode'><i class = 'uil uil-refresh'></i> </button>
                                    </center>";
                    }
                    else
                    {
                        $nestedData[] = "<center>
                                        <button type = 'button' class = 'btn btn-primary btn-sm isBtnUpdateUser' title = 'Update User Account' id = '$empcode'><i class = 'uil uil-edit'></i> </button>
                                        <button disabled type = 'button' class = 'btn btn-info btn-sm isBtnUnblockUser' title = 'Unblock User' id = '$empcode'><i class = 'uil uil-unlock'></i> </button>
                                        <button type = 'button' class = 'btn btn-warning btn-sm isBtnResetPassword' title = 'Reset Password' id = '$empcode'><i class = 'uil uil-refresh'></i> </button>
                                    </center>";
                    }
                    $updateuser_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $updateuser_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
    }
    
    $db_controller->closeQuery();
?>