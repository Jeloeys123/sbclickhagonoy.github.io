<?php
	date_default_timezone_set("Asia/Manila");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
    include $common_path."session_logged.php";
    $announcementcode = base64_decode($_GET['id']);
    include $modules_path."Announcement/Info.php";
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
                                            <li class = "breadcrumb-item active"> Notification </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <div class = "row">
                            <div class = "col-12">
                                <div class = "card ribbon-box">
                                    <div class = "card-body">
                                        <div class = "ribbon ribbon-success float-end">
                                            <i class="mdi mdi-access-point me-1"></i> Announcement
                                            <br>
                                        </div>
                                        <h4 class = "text-dark float-start mt-0"> <?php echo $title ?> </h4>
                                        <?php
                                            if($updatedby == "")
                                            {
                                        ?>
                                                <span style = "font-size: 10px;"> &nbsp; posted <?php echo $datecreated ?>, <?php echo $createdtime ?> by Admin  </span>
                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                                <span style = "font-size: 10px;"> &nbsp; posted <?php echo $datecreated ?>, <?php echo $createdtime ?> by Admin &nbsp; <b> [ updated <?php echo $dateupdated ?>, <?php echo $updatedtime ?> ]</b></span>
                                        <?php
                                            }
                                        ?>
                                        <div class = "ribbon-content">
                                            <?php echo $content ?> &nbsp; <a href = "announcement-download?id=<?php echo $announcementcode ?>" style = "font-size: 12px;"><i class = "uil uil-down-arrow"></i> Download File </a>
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