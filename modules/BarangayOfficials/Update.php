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
    $fname = base64_decode($_GET['fname']);
    $lname = base64_decode($_GET['lname']);
    $poscode = base64_decode($_GET['posid']);
    include $modules_path."BarangayOfficials/Info.php";
?>
<!DOCTYPE html>
<html lang = "en">
	<title> Barangay Officials </title>
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
                                            <li class = "breadcrumb-item"><a href = "barangay-officials-main"> Barangay Officials </a></li>
                                            <li class = "breadcrumb-item active"> Update Barangay Officials </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Edit Barangay Officials Record </h4>
                                </div>
                            </div>
                        </div>     
                        <div class = "row">
                            <div class = "col-xl-12">
                                <div class = "card">
                                    <div class = "card-body">
                                        <form action = "#" method = "POST" id = "fUpdateBarangayOfficials" role = "form">
                                            <h5 class = "mb-4 text-uppercase"> <i class = "mdi mdi mdi-account-group me-1"> </i> Update Barangay Official </h5>
                                            <div class = "row">
                                                <div class = "col-md-4">
                                                    <div class = "form-floating mb-3">
                                                        <input type = "text" id = "txtFirstname" name = "txtFirstname" class = "form-control" placeholder = "Enter firstname" value = "<?php echo $firstname ?>" required>
                                                        <label for = "floatingFirstname"> 
                                                            Firstname <b style = "color:red"> * </b>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class = "col-md-4">
                                                    <div class = "form-floating mb-3">
                                                        <input type = "text" id = "txtMiddlename" name = "txtMiddlename" class = "form-control" placeholder = "Enter middlename" value = "<?php echo $middlename ?>">
                                                        <label for = "floatingMiddlename"> 
                                                            Middlename 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class = "col-md-4">
                                                    <div class = "form-floating mb-3">
                                                        <input type = "text" id = "txtLastname" name = "txtLastname" class = "form-control" placeholder = "Enter lastname"  value = "<?php echo $lastname ?>"required>
                                                        <label for = "floatingLastname"> 
                                                            Lastname <b style = "color:red"> * </b>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-4">
                                                    <div class = "form-floating mb-3">
                                                        <input type = "text" id = "txtSuffixname" name = "txtSuffixname" class = "form-control" placeholder = "Enter suffixname" value = "<?php echo $suffixname ?>">
                                                        <label for = "floatingSuffixname"> 
                                                            Suffixname 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class = "col-md-4">
                                                    <div class = "form-floating mb-3">
                                                        <input type = "email" id = "txtEmail" name = "txtEmail" class = "form-control" placeholder = "Enter email" value = "<?php echo $email ?>">
                                                        <label for = "floatingEmail"> 
                                                            Email Address 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class = "col-md-4">
                                                    <div class = "form-floating mb-3">
                                                        <input type = "text" id = "txtMobileNumber" name = "txtMobileNumber" class = "form-control" data-toggle = "input-mask" data-mask-format = "(0000) 000 0000" placeholder = "Enter mobile number" value = "<?php echo $mobile ?>">
                                                        <label for = "floatingMobile"> 
                                                            Mobile Number 
                                                        </label>
                                                    </div>
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
                            <input type = "hidden" id = "txtFirstnameVal" name = "txtFirstnameVal" value = "<?php echo $fname ?>">
                            <input type = "hidden" id = "txtLastnameVal" name = "txtLastnameVal" value = "<?php echo $lname ?>">
                            <input type = "hidden" id = "txtPositionVal" name = "txtPositionVal" value = "<?php echo strtoupper($poscode) ?>">
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