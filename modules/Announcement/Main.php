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
	<title> Announcement </title>
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
                                            <li class = "breadcrumb-item active"> Announcement </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Announcements List </h4>
                                </div>
                            </div>
                        </div>   
                        <div class = "row">
                            <div class = "col-12">
                                <div class = "card">
                                    <div class = "card-body">
                                        <div class = "text-end">
                                            <button type = "button" style = "background: #F77D24" class = "btn btn-dark" title = "Create New Announcement" onclick = "isBtnCreate()">
                                                <i class = "dripicons-broadcast"></i>
                                                <span> Create Announcement </span> 
                                            </button>
                                        </div>
                                        <br>
                                        <div class = "table-responsive">
                                            <table id = "tblAnnouncement" class = "table table-bordered table-striped dt-responsive nowrap" style = "font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th> Sent To <br> (Barangay Name) </th>
                                                        <th> Title </th>
                                                        <th> Description </th>
                                                        <th> End Date </th>
                                                        <th> Created Details </th>
                                                        <th> Action </th>
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
		<?php include $common_path."Announcement/AnnouncementJs.php"; ?>
	</body>
</html>