<?php
	date_default_timezone_set("Asia/Manila");
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	include $common_path."session_logged.php";
	$db_controller = new DBController();
    
	function userListFile()
	{
		$output = "";
		$line = 0;
		$brgyname = "";
		$empcode = "";
        $firstname = "";
        $middlename = "";
		$middleinitials = "";
        $lastname = "";
        $suffixname = "";
        $email = "";
		$mobile = "";
		$position = "";
		$representative = "";
		$db_controller = new DBController();
		
		$brgyRepresentativeQuery = "SELECT
                barangay_mstr.BRGYNAME,
                barangay_representative.EMPCODE,
                barangay_representative.FIRSTNAME,
                barangay_representative.MIDDLENAME,
                barangay_representative.LASTNAME,
                barangay_representative.SUFFIXNAME,
                barangay_representative.EMAIL,
                barangay_representative.MOBILE,
                position_mstr.DESCRIPTION 
            FROM
                barangay_representative
                INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = barangay_representative.BRGYCODE
                LEFT JOIN position_mstr ON position_mstr.POSITIONCODE = barangay_representative.POSITION 
            WHERE
                1 = 1 
            ORDER BY
                barangay_mstr.BRGYNAME ASC";
        $brgyRepresentativeResult = $db_controller->runQuery($brgyRepresentativeQuery);
        if($brgyRepresentativeResult != NULL)
        {
            foreach($brgyRepresentativeResult as $brgyRepresentativeData)
            {
				$line++;
				$brgyname = $brgyRepresentativeData['BRGYNAME'];
                $empcode = $brgyRepresentativeData['EMPCODE'];
                $firstname = $brgyRepresentativeData['FIRSTNAME'];
                $middlename = $brgyRepresentativeData['MIDDLENAME'];
                $lastname = $brgyRepresentativeData['LASTNAME'];
                $suffixname = $brgyRepresentativeData['SUFFIXNAME'];
                $email = $brgyRepresentativeData['EMAIL'];
                $mobile = $brgyRepresentativeData['MOBILE'];
                $position = $brgyRepresentativeData['DESCRIPTION'];
                
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
                            $representative = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],01).". ".$lastname;
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
				
				$output .= '
					<tr>
						<td align = "center">'.$line.'</td>
						<td><strong>'.strtoupper($empcode).'</strong></td>
						<td>'.$brgyname.'</td>
						<td>'.$representative.'</td>
						<td>'.strtolower($email).'</td>
						<td>'.$mobile.'</td>
						<td>'.$position.'</td>
					</tr>
				';
			}
			return $output;
		}
	}
	
	if(isset($_GET['type']))
	{
        $type = $_GET['type'];
		
		if($type == "excel")
		{
			ini_set("display_errors", 1);
			ini_set("display_startup_errors", 1);
			error_reporting(E_ALL);
			ini_set("memory_limit", "640M");
			set_time_limit(1000000);
            $brgyname = "";
			$empcode = "";
            $firstname = "";
            $middlename = "";
			$middleinitials = "";
            $lastname = "";
            $suffixname = "";
            $email = "";
			$mobile = "";
			$position = "";
			$representative = "";
    	    $numRows = 2;
			
			if (PHP_SAPI == 'cli')
				die('This example should only be run from a Web Browser');
			require_once dirname(__FILE__) . '/../../../assets/PHPExcel/Classes/PHPExcel.php';
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("Kasangguni")
										 ->setLastModifiedBy("Kasangguni");
			//Header Names
			$objPHPExcel->getActiveSheet(0)->setCellValue("A1","EMPLOYEE CODE");
			$objPHPExcel->getActiveSheet(0)->setCellValue("B1","BARANGAY NAME");
			$objPHPExcel->getActiveSheet(0)->setCellValue("C1","CONTACT NAME");
			$objPHPExcel->getActiveSheet(0)->setCellValue("D1","EMAIL ADDRESS");
			$objPHPExcel->getActiveSheet(0)->setCellValue("E1","MOBILE NUMBER");
			$objPHPExcel->getActiveSheet(0)->setCellValue("F1","POSITION");
			//AUTO SIZE PER COLUMN
			foreach(range("A","H") as $column)
			{
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
			}
			$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setSize(11);
			$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
            $brgyRepresentativeQuery = "SELECT
                    barangay_mstr.BRGYNAME,
                    barangay_representative.EMPCODE,
                    barangay_representative.FIRSTNAME,
                    barangay_representative.MIDDLENAME,
                    barangay_representative.LASTNAME,
                    barangay_representative.SUFFIXNAME,
                    barangay_representative.EMAIL,
                    barangay_representative.MOBILE,
                    position_mstr.DESCRIPTION 
                FROM
                    barangay_representative
                    INNER JOIN barangay_mstr ON barangay_mstr.BRGYCODE = barangay_representative.BRGYCODE
                    LEFT JOIN position_mstr ON position_mstr.POSITIONCODE = barangay_representative.POSITION 
                WHERE
                    1 = 1 
                ORDER BY
                    barangay_mstr.BRGYNAME ASC";
            $brgyRepresentativeResult = $db_controller->runQuery($brgyRepresentativeQuery);
            if($brgyRepresentativeResult != NULL)
            {
                foreach($brgyRepresentativeResult as $brgyRepresentativeData)
                {
                    $brgyname = $brgyRepresentativeData['BRGYNAME'];
                    $empcode = $brgyRepresentativeData['EMPCODE'];
                    $firstname = $brgyRepresentativeData['FIRSTNAME'];
                    $middlename = $brgyRepresentativeData['MIDDLENAME'];
                    $lastname = $brgyRepresentativeData['LASTNAME'];
                    $suffixname = $brgyRepresentativeData['SUFFIXNAME'];
                    $email = $brgyRepresentativeData['EMAIL'];
                    $mobile = $brgyRepresentativeData['MOBILE'];
                    $position = $brgyRepresentativeData['DESCRIPTION'];
                    
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
                                $representative = $firstname." ".substr($middleinitials[0],0,1).".".substr($middleinitials[1],01).". ".$lastname;
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
                    
                    $objPHPExcel->getActiveSheet(0)->getStyle("A".$numRows.":F".$numRows)->getFont()->setSize(9);
                    $objPHPExcel->getActiveSheet(0)->getStyle("A".$numRows.":F".$numRows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet(0)->setCellValue("A".$numRows,strtoupper($empcode));
                    $objPHPExcel->getActiveSheet(0)->setCellValue("B".$numRows,$brgyname);
                    $objPHPExcel->getActiveSheet(0)->setCellValue("C".$numRows,$representative);
                    $objPHPExcel->getActiveSheet(0)->setCellValue("D".$numRows,strtolower($email));
                    $objPHPExcel->getActiveSheet(0)->setCellValue("E".$numRows,$mobile);
                    $objPHPExcel->getActiveSheet(0)->setCellValue("F".$numRows,$position);
                    $numRows++;
                }
            }
			
			$filename = "User-Master-List_".date("Y-m-d").".xls";
			$objPHPExcel->getActiveSheet()->setTitle("User Master List");
			$objPHPExcel->setActiveSheetIndex(0);
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment;filename=".$filename);
			header("Cache-Control: max-age=0");
			header("Cache-Control: max-age=1");
			header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			header ("Cache-Control: cache, must-revalidate"); 
			header ("Pragma: public"); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
			$objWriter->save("php://output");
			exit;
		}
		
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
					$this->Image($image_file,250,12.5,25);
                }
                
                //PAGE FOOTER
				function Footer()
				{
					$this->SetY(-20);
					$this->SetX(8);
					$this->Cell(0, 10, "PREPARED BY:  ".strtoupper($_SESSION['logged_name'])."  ".date("m/d/Y"), 0, false, "L", 0, "", 1, false, "T", "M");
				}
            }
			
			$obj_pdf = new PDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", false);  
			$obj_pdf->SetCreator(PDF_CREATOR);  
			$obj_pdf->SetTitle("User Master List");  
			$obj_pdf->SetHeaderData("", "", PDF_HEADER_TITLE, PDF_HEADER_STRING);  
			$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, "", PDF_FONT_SIZE_MAIN));  
			$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, "", PDF_FONT_SIZE_DATA));  
			$obj_pdf->SetDefaultMonospacedFont("helvetica");  
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
			$obj_pdf->SetMargins("5", "35", "5"); 
			$obj_pdf->SetAutoPageBreak(TRUE, 25);  
			$obj_pdf->SetFont("helvetica", "", 9);  
			$obj_pdf->AddPage();
            $content = "";
			
			$content = '
				<strong align = "center" style = "font-size: 12px;"> 
					USER MASTER LIST 
				</strong>
                <br>
				<strong align = "center" style = "font-size: 8px;"> 
					AS OF: '.strtoupper(date("F m, Y")).'
				</strong>
				<br>
				<br>
				<br>
			';
			
			$content .= '
				<table border = "0.5" cellspacing = "0" cellpadding = "3">
					<tr align = "center" style = "font-size: 10px;">
						<th width = "25"><b> # </b></th>
						<th width = "140"><b> Employee Code </b></th>
						<th width = "125"><b> Barangay Name </b></th>
						<th width = "125"><b> Contact Name </b></th>
						<th width = "148"><b> Email Address </b></th>
						<th width = "125"><b> Mobile Number </b></th>
						<th width = "125"><b> Position </b></th>
					</tr>
			';
			$content .= userListFile();
            $content .= '
				</table>
			';
			
			$obj_pdf->writeHTML($content); 
		    $obj_pdf->Output();
		}
	}
?>