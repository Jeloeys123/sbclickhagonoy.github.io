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
	<title> USER MASTER LIST </title>
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
                                            <li class = "breadcrumb-item"><a href = "javascript: void(0);"> Manage User </a></li>
                                            <li class = "breadcrumb-item active"> View User </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> User Master List </h4>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col-12">
                                <div class = "card">
                                    <div class = "card-body">
                                        <div class = "text-end">
                                            <div class = "dropdown btn-group">
                                                <button type = "button" class = "btn btn-success dropdown-toggle" data-bs-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false">
                                                    <i class = "uil uil-export"></i> Export
                                                </button>
                                                <div class = "dropdown-menu dropdown-menu-animated">
                                                    <a class = "dropdown-item" href = "manage-user-viewdownload?type=excel" target = "_blank" title = "Download via Excel">
                                                        <i class = "mdi mdi-file-excel"></i> Excel 
                                                    </a>
                                                    <a class = "dropdown-item" href = "manage-user-viewdownload?type=pdf" target = "_blank" title = "Download via pdf"> 
                                                        <i class = "mdi mdi-file-pdf"></i> Pdf 
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <table id = "tblViewUser" class = "table table-bordered table-striped dt-responsive nowrap w-100" style = "font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th><center> Employee Code </center></th>
                                                    <th><center> Barangay Name </center></th>
                                                    <th><center> Contact Name </center></th>
                                                    <th><center> Email </center></th>
                                                    <th><center> Mobile Number </center></th>
                                                    <th><center> Position </center></th>
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
        <?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/rightsidebar.php"; ?>
        <div class = "rightbar-overlay"> </div>
		<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/footer.php"; ?>
		<?php include $common_path."ManageUser/ViewUser/ViewUserJs.php"; ?>
	</body>
</html>