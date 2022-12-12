<?php
	date_default_timezone_set("Asia/Manila");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
    include $common_path."session_logged.php";
?>
<!DOCTYPE html>
<html lang = "en">
	<title> Barangay Officials </title>
	<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/header.php"; ?>
	<body class = "loading" data-layout-config = '{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <div class = "wrapper">
            <?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/leftsidebar.php"; ?>
            <div class = "content-page">
                <div class = "content">
                    <?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/navigationbar.php"; ?>
                    <div class = "container-fluid">
                        <div class = "row">
                            <div class = "col-12">
                                <div class = "page-title-box">
                                    <div class = "page-title-right">
                                        <ol class = "breadcrumb m-0">
                                            <li class = "breadcrumb-item"><a href = "main-page"> Click Hagonoy </a></li>
                                            <li class = "breadcrumb-item active"> Barangay Officials </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Create Barangay Officials </h4>
                                </div>
                            </div>
                        </div>     
                        <div class = "row">
                            <div class = "col-xl-8 col-lg-7">
                                <div class = "card text-center">
                                    <div class = "card-body">
                                        <div class = "text-end">
                                            <button type = "button" class = "btn btn-info" title = "Download Report via PDF File" onclick = "isBtnDownload()">
                                                <i class = "uil uil-file-download"></i>
                                                <span> Download </span> 
                                            </button>
                                        </div>
                                        <br>
                                        <div class = "table-responsive">
                                            <table id = "tblBarangayOfficials" class = "table table-bordered table-striped dt-responsive nowrap" style = "font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th> Name </th>
                                                        <th> Position </th>
                                                        <th> Email </th>
                                                        <th> Contact Number </th>
                                                        <th> Action </th>
                                                    </tr>
                                                </thead>
                                            </table>    
                                        </div> 
                                    </div>
                                </div> 
                            </div>
                            <div class = "col-xl-4 col-lg-5">
                                <div class = "card">
                                    <div class = "card-body">
                                        <form action = "#" method = "POST" id = "fCreateBarangayOfficials" role = "form">
                                            <h5 class = "mb-4 text-uppercase"> <i class = "mdi mdi-account-group me-1"> </i> Add Barangay Official </h5>
                                            <div class = "row">
                                                <div class = "col-xl-12">
                                                    <label for = "firstname" class = "form-label"> Firstname <b style = "color:red">*</b></label>
                                                    <input type = "text" id = "txtFirstname" name = "txtFirstname" class = "form-control" placeholder = "Enter firstname" required>
                                                </div>
                                                <div class = "col-xl-12">
                                                    <label for = "middlename" class = "form-label"> Middlename </label>
                                                    <input type = "text" id = "txtMiddlename" name = "txtMiddlename" class = "form-control" placeholder = "Enter middlename">
                                                </div>
                                                <div class = "col-xl-12">
                                                    <label for = "lastname" class = "form-label"> Lastname <b style = "color:red">*</b></label>
                                                    <input type = "text" id = "txtLastname" name = "txtLastname" class = "form-control" placeholder = "Enter lastname" required>
                                                </div>
                                                <div class = "col-xl-12">
                                                    <label for = "suffixname" class = "form-label"> Suffixname </label>
                                                    <input type = "text" id = "txtSuffixname" name = "txtSuffixname" class = "form-control" placeholder = "Enter suffixname">
                                                </div>
                                                <div class = "col-xl-12">
                                                    <label for = "position" class = "form-label"> Position <b style = "color:red">*</b></label>
                                                    <select id = "cboPosition" name = "cboPosition" class = "form-control select2" data-toggle = "select2" required>
                                                        <option value = "" selected disabled> Select </option>
                                                        <?php
                                                            $position = "";
                                                            $description = "";
                                                            $positionMstrQuery = "SELECT
                                                                    POSITIONCODE,
                                                                    DESCRIPTION 
                                                                FROM
                                                                    position_mstr 
                                                                ORDER BY
                                                                    DESCRIPTION";
                                                            $positionMstrResult = $db_controller->runQuery($positionMstrQuery);
                                                            if($positionMstrResult != NULL)
                                                            {
                                                                foreach($positionMstrResult as $positionMstrData)
                                                                {
                                                                    $position = $positionMstrData['POSITIONCODE'];
                                                                    $description = $positionMstrData['DESCRIPTION'];
                                                                    
                                                                    echo "
                                                                        <option value = ".strtoupper($position).">".$description."</option>
                                                                    ";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class = "col-xl-12">
                                                    <label for = "email" class = "form-label"> Email Address </label>
                                                    <input type = "email" id = "txtEmail" name = "txtEmail" class = "form-control" placeholder = "Enter email">
                                                </div>
                                                <div class = "col-xl-12">
                                                    <label for = "mobile" class = "form-label"> Mobile Number </label>
                                                    <input type = "text" id = "txtMobileNumber" name = "txtMobileNumber" class = "form-control" data-toggle = "input-mask" data-mask-format = "(0000) 000 0000" placeholder = "Enter mobile number">
                                                </div>
                                            </div>
                                            <div class = "text-end">
                                                <button id = "btnSave" class = "btn btn-success mt-2" title = "Save Barangay Official Record"><i class = "mdi mdi-content-save"></i> Save </button>
                                            </div>
                                        </form>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/rightsidebar.php"; ?>
        <div class = "rightbar-overlay"> </div>
		<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/footer.php"; ?>
		<?php include $common_path."BarangayOfficials/BarangayOfficialsJs.php"; ?>
	</body>
</html>