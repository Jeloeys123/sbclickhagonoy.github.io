<?php
	date_default_timezone_set("Asia/Manila");
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	include $common_path."session_logged.php";
	$db_controller = new DBController();
    $barangaycode = $_SESSION['logged_brgycode'];
    
	function demographicDataFile($brgycode)
	{
		$output = "";
        $censusyear = "";
        $householdpopulation = "";
        $numberofhouseholds = "";
        $averageofhousehold = "";
		$db_controller = new DBController();
		
		$demographicMstrQuery = "SELECT
                CENSUSYEAR,
                HOUSEHOLD_POPULATION,
                NUMBER_OF_HOUSEHOLDS,
                AVERAGE_HOUSEHOLD 
            FROM
                demographic_mstr 
            WHERE
                UPPER( BRGYCODE ) = '$brgycode'";
        $demographicMstrResult = $db_controller->runQuery($demographicMstrQuery);
        if($demographicMstrResult != NULL)
        {
            foreach($demographicMstrResult as $demographicMstrData)
            {
				$censusyear = $demographicMstrData['CENSUSYEAR'];
				$householdpopulation = $demographicMstrData['HOUSEHOLD_POPULATION'];
				$numberofhouseholds = $demographicMstrData['NUMBER_OF_HOUSEHOLDS'];
                $averageofhousehold = $demographicMstrData['AVERAGE_HOUSEHOLD'];
				
				$output .= '
					<tr>
						<td align = "center"><b>'.$censusyear.'</b></td>
						<td align = "center">'.number_format($householdpopulation).'</td>
						<td align = "center">'.number_format($numberofhouseholds).'</td>
						<td align = "center">'.$averageofhousehold.'</td>
					</tr>
				';
			}
			return $output;
		}
	}
	
	if(isset($_GET['type']))
	{
        $type = $_GET['type'];
		
		if($type == "pdf")
		{
			require_once($assets_path."tcpdf/tcpdf.php"); 
			ini_set("display_errors", 1);
			ini_set("display_startup_errors", 1);
			error_reporting(E_ALL);
			ini_set("memory_limit", "640M");
			set_time_limit(1000000);
			date_default_timezone_set("Asia/Manila");
            $brgyname = "";
            $brgylogo = "";
			$timestamp = time(); 
			
			$brgyMstrQuery = "SELECT
					BRGYNAME,
					BRGYLOGO 
				FROM
					barangay_mstr 
				WHERE
					UPPER( BRGYCODE ) = '$barangaycode'";
            $brgyMstrResult = $db_controller->runQuery($brgyMstrQuery);
            if($brgyMstrResult != NULL)
            {
                $brgyname = $brgyMstrResult[0]['BRGYNAME'];
                $brgylogo = $brgyMstrResult[0]['BRGYLOGO'];
            }
			
			class PDF extends TCPDF
			{
				//PAGE HEADER
				function Header()
				{
					global $brgylogo; 
					
					//Logo
					$image_file = K_PATH_IMAGES."barangay/".$brgylogo;
					$this->Image($image_file,25,15,20);
                    $image_file = K_PATH_IMAGES."barangay/SystemLogo.png";
					$this->Image($image_file,165,12.5,25);
                }
                
                //PAGE FOOTER
				function Footer()
				{
					$this->SetY(-20);
					$this->SetX(8);
					$this->Cell(0, 10, "PREPARED BY:  ".strtoupper($_SESSION['logged_name'])."  ".date("m/d/Y"), 0, false, "L", 0, "", 1, false, "T", "M");
				}
            }
			
			$obj_pdf = new PDF("P", PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", false);  
			$obj_pdf->SetCreator(PDF_CREATOR);  
			$obj_pdf->SetTitle("Demographic Data");  
			$obj_pdf->SetHeaderData("", "", PDF_HEADER_TITLE, PDF_HEADER_STRING);  
			$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, "", PDF_FONT_SIZE_MAIN));  
			$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, "", PDF_FONT_SIZE_DATA));  
			$obj_pdf->SetDefaultMonospacedFont("helvetica");  
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
			$obj_pdf->SetMargins("10", "25", "10"); 
			$obj_pdf->SetAutoPageBreak(TRUE, 25);  
			$obj_pdf->SetFont("helvetica", "", 9);  
			$obj_pdf->AddPage();
            $content = "";
            
            $content = '
				<strong align = "center" style = "font-size: 12px;"> 
					DEMOGRAPHIC DATA
				</strong>
				<br>
				<strong align = "center" style = "font-size: 8px;"> 
					OF BARANGAY '.strtoupper($brgyname).' HAGONOY, BULACAN
				</strong>
				<br>
				<br>
				<br>
			';
			
			$content .= '
				<table border = "0.5" cellspacing = "0" cellpadding = "3">
					<tr align = "center" style = "font-size: 10px;">
						<th width = "100"><b> Year </b></th>
						<th width = "146"><b> House Population </b></th>
						<th width = "146"><b> Number of Households </b></th>
						<th width = "148"><b> Average Household Size </b></th>
					</tr>
			';
			$content .= demographicDataFile($barangaycode);
            $content .= '
				</table>
			';
			
			$filename = "Demographic-Data_".$barangaycode."_".date("Y-m-d").".pdf";
			$obj_pdf->writeHTML($content); 
		    $obj_pdf->Output();
		    //$obj_pdf->Output($filename, "D");
		}
	}
?>