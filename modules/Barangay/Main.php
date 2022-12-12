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
	<title> Barangay Master List </title>
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
                                            <li class = "breadcrumb-item active"> Manage Barangay </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Barangay Master List </h4>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col-12">
                                <div class = "card">
                                    <div class = "card-body">
                                        <div class = "text-end">
                                            <button type = "button" class = "btn btn-info" title = "Download Report via PDF File" onclick = "isBtnDownload()">
                                                <i class = "uil uil-file-download"></i>
                                                <span> Download </span> 
                                            </button>
                                        </div>
                                        <br>
                                        <div class = "table-responsive">
                                            <table id = "tblManageBarangay" class = "table table-bordered table-striped dt-responsive nowrap" style = "font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th><center> Barangay Name </center></th>
                                                        <th><center> Email Address </center></th>
                                                        <th><center> Mobile Number </center></th>
                                                        <th><center> Telephone Number </center></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
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
		<?php include $common_path."Barangay/BarangayJs.php"; ?>
	</body>
</html>