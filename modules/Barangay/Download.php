<?php
	date_default_timezone_set("Asia/Manila");
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	include $common_path."session_logged.php";
	$db_controller = new DBController();
    
	function barangayListFile()
	{
		$output = "";
		$line = 0;
		$brgyname = "";
        $email = "";
		$mobile = "";
		$telephone = "";
		$db_controller = new DBController();
		
		$brgyMstrQuery = "SELECT
				barangay_mstr.BRGYNAME,
				barangay_profile.EMAIL,
				barangay_profile.MOBILE,
				barangay_profile.TELEPHONE 
			FROM
				barangay_mstr
				LEFT JOIN barangay_profile ON barangay_profile.BRGYCODE = barangay_mstr.BRGYCODE 
			WHERE
				1 = 1 
			GROUP BY
				barangay_mstr.BRGYCODE 
			ORDER BY
				barangay_mstr.BRGYNAME";
        $brgyMstrResult = $db_controller->runQuery($brgyMstrQuery);
        if($brgyMstrResult != NULL)
        {
            foreach($brgyMstrResult as $brgyMstrData)
            {
				$line++;
				$brgyname = $brgyMstrData['BRGYNAME'];
                $email = $brgyMstrData['EMAIL'];
                $mobile = $brgyMstrData['MOBILE'];
                $telephone = $brgyMstrData['TELEPHONE'];
				
				$output .= '
					<tr>
						<td align = "center">'.$line.'</td>
						<td><strong>'.$brgyname.'</strong></td>
						<td>'.strtolower($email).'</td>
						<td>'.$mobile.'</td>
						<td>'.$telephone.'</td>
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
			$timestamp = time(); 
			
			class PDF extends TCPDF
			{
				//PAGE HEADER
				function Header()
				{
					//Kasangguni Logo
					$image_file = K_PATH_IMAGES."barangay/Hagonoy.png";
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
			$obj_pdf->SetTitle("Barangay Master List");  
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
					BARANGAY MASTER LIST 
				</strong>
				<br>
				<br>
				<br>
			';
			
			$content .= '
				<table border = "0.5" cellspacing = "0" cellpadding = "3">
					<tr align = "center" style = "font-size: 10px;">
						<th width = "40"><b> # </b></th>
						<th width = "130"><b> Barangay Name </b></th>
						<th width = "150"><b> Email Address </b></th>
						<th width = "110"><b> Mobile Number </b></th>
						<th width = "110"><b> Telephone Number </b></th>
					</tr>
			';
			$content .= barangayListFile();
            $content .= '
				</table>
			';
			
			$obj_pdf->writeHTML($content); 
		    $obj_pdf->Output();
		}
	}
?>