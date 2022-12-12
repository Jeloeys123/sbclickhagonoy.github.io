<?php
    date_default_timezone_set("Asia/Manila");
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
	
	if(isset($_POST['type']))
	{
        $type = $_POST['type'];
        
        if($type == "GETALLPENDINGORDINANCE")
		{
            $brgycode = "";
            $brgyname = "";
            $ordinanceno = "";
            $ordinancetitle = "";
            $description = "";
            $file = "";
            $status = "";
            $createddate = "";
            $createdtime = "";
			$pendingordinancedata_arr = array();
			
			//STORING REQUEST (IE,. GET/POST) GLOBAL ARRAY TO A VARIABLE
			$requestData = $_REQUEST;
			
			//DATATABLE COLUMN INDEX  => DATABASE COLUMN NAME
			$columns = array( 
                0 => "ordinance_mstr.ID",
			);
			
			//GETTING TOTAL NUMBER RECORD WITHOUT ANY SEARCH
            $ordinanceMstrRowQuery = "SELECT
                    ordinance_mstr.ID 
                FROM
                    ordinance_mstr
                    INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = ordinance_mstr.BRGYCODE 
                WHERE
                    UPPER( ordinance_mstr.STATUS ) = 'PENDING' 
                ORDER BY
                    barangay_mstr.BRGYNAME ASC,
                    ordinance_mstr.ORDYEAR DESC,
                    ordinance_mstr.ORDCODE ASC";
            $ordinanceMstrRowResult = $db_controller->numRows($ordinanceMstrRowQuery);
			$totalData = $ordinanceMstrRowResult;
			// WHEN THERE IS NO SEARCH PARAMETER THEN THE TOTAL ROWS = TOTAL NUMBER FILTERED ROWS.
			$totalFiltered = $totalData;
			
            $ordinanceMstrQuery = "SELECT
                    ordinance_mstr.BRGYCODE,
                    barangay_mstr.BRGYNAME,
                    ordinance_mstr.ORDCODE,
                    ordinance_mstr.ORDTITLE,
                    ordinance_mstr.DESCRIPTION,
                    ordinance_mstr.FILE,
                    ordinance_mstr.STATUS,
                    ordinance_mstr.CREATEDDATE,
                    ordinance_mstr.CREATEDTIME 
                FROM
                    ordinance_mstr
                    INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = ordinance_mstr.BRGYCODE 
                WHERE
                    UPPER( ordinance_mstr.STATUS ) = 'PENDING'";
			if( !empty($requestData['search']['value']) ) 
			{   
				//IF THERE IS A SEARCH PARAMETER, $requestData['search']['value'] CONTAINS SEARCH PARAMETER
				$ordinanceMstrQuery.= " AND (barangay_mstr.BRGYNAME LIKE '%".$requestData['search']['value']."%' OR ordinance_mstr.ORDTITLE LIKE '%".$requestData['search']['value']."%' OR ordinance_mstr.DESCRIPTION LIKE '%".$requestData['search']['value']."%' OR ordinance_mstr.STATUS LIKE '%".$requestData['search']['value']."%' OR ordinance_mstr.CREATEDDATE LIKE '%".$requestData['search']['value']."%' OR ordinance_mstr.CREATEDTIME LIKE '%".$requestData['search']['value']."%')";
            }
			$ordinanceMstrRowsResult = $db_controller->numRows($ordinanceMstrQuery);
			$totalFiltered = $ordinanceMstrRowsResult; 
			//WHEN THERE IS A SEARCH PARAMETER THEN WE HAVE TO MODIFY TOTAL NUMBERS FILTERED ROWS AS PER SEARCH RESULT 
			$ordinanceMstrQuery .= " ORDER BY barangay_mstr.BRGYNAME ASC, ordinance_mstr.ORDYEAR DESC, ordinance_mstr.ORDCODE ASC,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$ordinanceMstrResult = $db_controller->runQuery($ordinanceMstrQuery);
			if($ordinanceMstrResult != NULL)
			{
				foreach($ordinanceMstrResult as $ordinanceMstrData)
				{  
                    $brgycode = $ordinanceMstrData['BRGYCODE'];
                    $brgyname = $ordinanceMstrData['BRGYNAME'];
                    $ordinanceno = $ordinanceMstrData['ORDCODE'];
                    $ordinancetitle = $ordinanceMstrData['ORDTITLE'];
                    $description = $ordinanceMstrData['DESCRIPTION'];
                    $file = $ordinanceMstrData['FILE'];
                    $status = $ordinanceMstrData['STATUS'];
                    $createddate = $ordinanceMstrData['CREATEDDATE'];
                    $createdtime = $ordinanceMstrData['CREATEDTIME'];
                    
                    //PREPARING AN ARRAY
					$nestedData = array(); 
                    $nestedData[] = "<center style = 'text-align: left;'>".$brgyname."</center>";
                    $nestedData[] = "<center style = 'text-align: left;'>".$ordinancetitle."</center>";
					$nestedData[] = "<center style = 'text-align: left;'>".$description."</center>";
					$nestedData[] = "<center style = 'text-align: left;'>".$file."</center>";
					$nestedData[] = "<center style = 'text-align: left;'>".$status."</center>";
                    $nestedData[] = "<center style = 'text-align: left;'>".$createddate."<br>".$createdtime."</center>";
                    $nestedData[] = "<center style = 'text-align: left;'>
                                <button type = 'button' class = 'btn btn-success btn-sm isBtnApproved' title = 'Approve Ordinance' id = '$brgycode,$ordinanceno'><i class = 'uil uil-check'></i> </button>
                                <button type = 'button' class = 'btn btn-warning btn-sm isBtnRevision' title = 'Revised Ordinance' id = '$brgycode,$ordinanceno'><i class = 'uil  uil-comment-alt-edit'></i> </button>
                                <button type = 'button' class = 'btn btn-danger btn-sm isBtnRejected' title = 'Disapprove Ordinance' id = '$brgycode,$ordinanceno'><i class = 'uil uil-times'></i> </button>
                            </center>";
					/*$nestedData[] = "<center style = 'text-align: left;'>
                                <button disabled type = 'button' class = 'btn btn-primary btn-sm isBtnDownload' title = '' id = '$brgycode,$ordinanceno'><i class = 'uil uil-file-download'></i> </button>
                            </center>";*/
                    $pendingordinancedata_arr[] = $nestedData;
				}
            }
            
            $json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $pendingordinancedata_arr   // total data array
			);
			echo json_encode($json_data);  // send data as json format
        }
    }
    
    $db_controller->closeQuery();
?>