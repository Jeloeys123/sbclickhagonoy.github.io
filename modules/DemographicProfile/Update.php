<?php
	date_default_timezone_set("Asia/Manila");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
    include $common_path."session_logged.php";
    $barangaycode = $_SESSION['logged_brgycode'];
    $censusyear = base64_decode($_GET['id']);
    include $modules_path."DemographicProfile/Info.php";
?>
<!DOCTYPE html>
<html lang = "en">
	<title> Demographic Profile </title>
	<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/header.php"; ?>
	<body class = "loading" data-layout-config = '{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
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
                                            <li class = "breadcrumb-item"><a href = "demographic-profile-main"> Demographic Profile </a></li>
                                            <li class = "breadcrumb-item active"> Update Demographic </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Edit Demographic Record </h4>
                                </div>
                            </div>
                        </div>     
                        <div class = "row">
                            <div class = "col-xl-8 col-lg-7">
                                <div class = "card text-center">
                                    <div class = "card-body">
                                        <div class = "table-responsive">
                                            <table id = "tblUpdateDemographicData" class = "table table-bordered table-striped dt-responsive nowrap" style = "font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th><center> Year </center></th>
                                                        <th><center> House Population </center></th>
                                                        <th><center> Number of Households </center></th>
                                                        <th><center> Average Household Size </center></th>
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
                                        <form action = "#" method = "POST" id = "fUpdateDemographicData" role = "form">
                                            <h5 class = "mb-4 text-uppercase"> <i class = "mdi mdi-database me-1"> </i> Update Demographic Data </h5>
                                            <div class = "row">
                                                <div class = "col-xl-12">
                                                    <label for = "year" class = "form-label"> Year </label>
                                                    <input type = "text" id = "txtCensusYear" name = "txtCensusYear" class = "form-control" value = "<?php echo $censusyear ?>" readonly>
                                                </div>
                                                <div class = "col-xl-12">
                                                    <label for = "housepopulation" class = "form-label"> House Population <b style = "color:red">*</b></label>
                                                    <input type = "number" id = "txtHousePopulation" name = "txtHousePopulation" class = "form-control" onkeyup = "isOnkeyupHousePopulation(this.value);" placeholder = "Enter house population" value = "<?php echo $housepopulation ?>" required>
                                                </div>
                                                <div class = "col-xl-12">
                                                    <label for = "noofhouseholds" class = "form-label"> Number of Households <b style = "color:red">*</b></label>
                                                    <input type = "number" id = "txtNumberHouseholds" name = "txtNumberHouseholds" class = "form-control" onkeyup = "isOnkeyupNumberHouseholds(this.value);" placeholder = "Enter number of households" value = "<?php echo $noofhouseholds ?>" required>
                                                </div>
                                                <div class = "col-xl-12">
                                                    <label for = "avghouseholdsize" class = "form-label"> Average Household Size </label>
                                                    <input type = "number" id = "txtAverageHousehold" name = "txtAverageHousehold" class = "form-control" value = "<?php echo $avghousehold ?>" readonly>
                                                </div>
                                            </div>
                                            <div class = "text-end">
                                                <button id = "btnSave" class = "btn btn-success mt-2" title = "Save"><i class = "mdi mdi-content-save"></i> Save </button>
                                                <button type = "button" class = "btn btn-danger mt-2" title = "Back" onclick = "isBtnBack()">
                                                    <i class = "uil uil-arrow-left"></i> Back 
                                                </button>
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
		<?php include $common_path."DemographicProfile/DemographicProfileJs.php"; ?>
	</body>
</html>