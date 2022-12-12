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
?>
<!DOCTYPE html>
<html lang = "en">
	<title> CREATE BARANGAY BACKGROUND </title>
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
                                            <li class = "breadcrumb-item active"> Barangay Background </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Create Barangay Background </h4>
                                </div>
                            </div>
                        </div>     
                        <div class = "row">
                            <div class = "col-xl-4 col-lg-5">
                                <div class = "card text-center">
                                    <div class = "card-body">
                                        <img id = "txtBarangayProfile" src = "assets/images/barangay/Hagonoy.png" class = "rounded-circle avatar-xl img-thumbnail" alt = "profile-image">
                                        <br>
                                        <br>
                                        <input type = "file" id = "file" name = "file" class = "form-control" accept = "image/*">
                                        <br>
                                        <button id = "btnUpload" class = "btn btn-primary btn-icon-split" title = "Upload">
                                            <span class = "icon text-white-50">
                                                <i class = "fas fa-upload"> </i>
                                            </span>
                                            <span class = "text"> 
                                                Upload 
                                            </span>
                                        </button>
                                    </div>
                                </div> 
                            </div>
                            <div class = "col-xl-8 col-lg-7">
                                <div class = "card">
                                    <div class = "card-body">
                                        <form action = "#" method = "POST" id = "fBarangayBackground" role = "form">
                                            <h5 class = "mb-4 text-uppercase"> <i class = "mdi mdi-office-building me-1"> </i> Barangay Info </h5>
                                            <div class = "row">
                                                <div class = "col-md-6">
                                                    <div class = "mb-3">
                                                        <label for = "emailaddress" class = "form-label"> Email Address <b style = "color:red">*</b></label>
                                                        <input type = "email" id = "txtEmail" name = "txtEmail" class = "form-control" placeholder = "Enter barangay email address" required>
                                                    </div>
                                                </div>
                                                <div class = "col-md-6">
                                                    <div class = "mb-3">
                                                        <label for = "mobile" class = "form-label"> Mobile Number <b style = "color:red">*</b></label>
                                                        <input type = "text" id = "txtMobileNumber" name = "txtMobileNumber" class = "form-control" placeholder = "Enter barangay mobile number" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-6">
                                                    <div class = "mb-3">
                                                        <label for = "telephone" class = "form-label"> Telephone Number </label>
                                                        <input type = "text" id = "txtTelephoneNumber" name = "txtTelephoneNumber" class = "form-control" placeholder = "Enter barangay telephone number">
                                                    </div>
                                                </div>
                                                <div class = "col-md-6">
                                                    <div class = "mb-3">
                                                        <label for = "bio" class = "form-label"> Facebook </label>
                                                        <div class = "input-group">
                                                            <span class = "input-group-text">
                                                                <i class = "mdi mdi-facebook"> </i>
                                                            </span>
                                                            <input type = "text" id = "txtFacebook" name = "txtFacebook" class = "form-control" placeholder = "Url">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-12">
                                                    <div class = "mb-3">
                                                        <label for = "bio" class = "form-label"> Barangay History <b style = "color:red">*</b></label>
                                                        <textarea id = "txtBarangayBackground" name = "txtBarangayBackground" class = "form-control" rows = "6" placeholder = "Enter some brief about your barangay" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "text-end">
                                                <button id = "btnSave" class = "btn btn-success mt-2" title = "Save Barangay Information"><i class = "mdi mdi-content-save"></i> Save </button>
                                            </div>
                                        </form>
                                    </div>
                                </div> 
                            </div>
                            <input type = "hidden" name = "txtBarangaycode" id = "txtBarangaycode" value = "<?php echo strtoupper($barangaycode) ?>">
                            <input type = "hidden" name = "txtBarangayPicture" id = "txtBarangayPicture">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/rightsidebar.php"; ?>
        <div class = "rightbar-overlay"> </div>
		<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/footer.php"; ?>
		<?php include $common_path."BarangayBackground/AddBackground/AddBackgroundJs.php"; ?>
	</body>
</html>