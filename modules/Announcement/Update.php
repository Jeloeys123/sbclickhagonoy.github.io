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
?>
<!DOCTYPE html>
<html lang = "en">
	<title> Announcement </title>
	<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/header.php"; ?>
	<body class = "loading" data-layout-config = '{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}' onload = "showAnnouncement();">
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
                                            <li class = "breadcrumb-item"><a href = "announcement-main"> Announcement </a></li>
                                            <li class = "breadcrumb-item active"> Update Announcement </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Edit Announcement Record </h4>
                                </div>
                            </div>
                        </div>     
                        <div class = "row">
                            <div class = "col-12">
                                <div class = "card">
                                    <div class = "card-body">
                                        <form action = "#" method = "POST" id = "fUpdateAnnouncement" role = "form">
                                            <div class = "row">
                                                <div class = "col-md-8">
                                                    <div class = "mb-3">
                                                        <label for = "selectBarangay" class = "form-label"> Barangay <b style = "color:red">*</b></label>
                                                        <select id = "cboBarangay"  name = "barangay[]" class = "select2 form-control select2-multiple" data-toggle = "select2" multiple = "multiple" data-placeholder = "Choose ..." required>
                                                            <option value = "ALL"> All Barangay </option>
                                                            <?php
                                                                $brgycode = "";
                                                                $brgyname = "";
                                                                $barangayMstrQuery = "SELECT
                                                                        BRGYCODE,
                                                                        BRGYNAME 
                                                                    FROM
                                                                        barangay_mstr 
                                                                    ORDER BY
                                                                        BRGYNAME";
                                                                $barangayMstrResult = $db_controller->runQuery($barangayMstrQuery);
                                                                if($barangayMstrResult != NULL)
                                                                {
                                                                    foreach($barangayMstrResult as $barangayMstrData)
                                                                    {
                                                                        $brgycode = $barangayMstrData['BRGYCODE'];
                                                                        $brgyname = $barangayMstrData['BRGYNAME'];
                                                                        
                                                                        echo "
                                                                            <option value = ".strtoupper($brgycode).">".$brgyname."</option>
                                                                        ";
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class = "col-md-4">
                                                    <div class = "mb-3">
                                                        <label class = "form-label"> File Input </label>
                                                        <input type = "file" id = "file" name = "file" class = "form-control" accept = ".doc, .docx, .txt, .pdf, image/*"> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-6">
                                                    <div class = "form-floating mb-3">
                                                        <input type = "text" id = "txtTitle" name = "txtTitle" class = "form-control" required>
                                                        <label for = "floatingTitle"> 
                                                            Announcement Title <b style = "color:red"> * </b>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class = "col-md-3">
                                                    <div class = "form-floating mb-3 position-relative" id = "datepicker1">
                                                        <input type = "text" id = "txtStartdate" name = "txtStartdate" class = "form-control" data-provide = "datepicker" data-date-container = "#datepicker1" data-date-autoclose = "true" data-toggle = "input-mask" data-mask-format = "00/00/0000" required>
                                                        <label for = "floatingStartdate"> 
                                                            Start Date <b style = "color:red"> * </b>
                                                            <span class = "font-12 text-muted"> e.g "MM/DD/YYYY" </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class = "col-md-3">
                                                    <div class = "form-floating mb-3 position-relative" id = "datepicker2">
                                                        <input type = "text" id = "txtEnddate" name = "txtEnddate" class = "form-control" data-provide = "datepicker" data-date-container = "#datepicker2" data-date-autoclose = "true" data-toggle = "input-mask" data-mask-format = "00/00/0000" required>
                                                        <label for = "floatingEnddate"> 
                                                            End Date <b style = "color:red"> * </b> 
                                                            <span class = "font-12 text-muted"> e.g "MM/DD/YYYY" </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-12">
                                                    <div class = "form-floating mb-3">
                                                        <textarea id = "txtContent" name = "txtContent" class = "form-control" data-toggle = "maxlength" maxlength = "5000" placeholder = "Enter some brief about announcement.." style = "height: 100px;" required></textarea>
                                                        <label for = "floatingContent"> Content <b style = "color:red">*</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "text-end">
                                                <button id = "btnUpdate" class = "btn btn-success" title = "Update Announcement">
                                                    <i class = "mdi mdi-update"></i> Update 
                                                </button>
                                                <button type = "button" class = "btn btn-danger" title = "Back" onclick = "isBtnBack()">
                                                    <i class = "uil uil-arrow-left"></i> Back 
                                                </button>
                                            </div>
                                        </form>
                                        <input type = "hidden" name = "txtAnnouncementcode" id = "txtAnnouncementcode" value = "<?php echo strtoupper($announcementcode) ?>">
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