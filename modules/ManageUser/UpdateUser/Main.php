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
	<title> UPDATE USER RECORD </title>
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
                                            <li class = "breadcrumb-item"><a href = "javascript: void(0);"> Manage User </a></li>
                                            <li class = "breadcrumb-item active"> Update User </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Update User Record </h4>
                                </div>
                            </div>
                        </div>     
                        <div class = "row">
                            <div class = "col-12">
                                <div class = "card">
                                    <div class = "card-body">
                                        <div class = "table-responsive">
                                            <table id = "tblUpdateUser" class = "table table-bordered table-striped dt-responsive nowrap w-100" style = "font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th style = "padding: 6px;"><center> Barangay Name </center></th>
                                                        <th style = "padding: 6px;"><center> Contact Name </center></th>
                                                        <th style = "padding: 6px;"><center> Email </center></th>
                                                        <th style = "padding: 6px;"><center> Mobile Number </center></th>
                                                        <th style = "padding: 6px;"><center> Position </center></th>
                                                        <th style = "padding: 6px;"><center> Status </center></th>
                                                        <th style = "padding: 6px;"><center> </center></th>
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
		<?php include $common_path."ManageUser/UpdateUser/UpdateUserJs.php"; ?>
	</body>
</html>