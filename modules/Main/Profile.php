<?php
	date_default_timezone_set("Asia/Manila");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
    include $common_path."session_logged.php";
    $brgycode = base64_decode($_GET['id']);
	include $modules_path."Main/Info.php";
?>
<!DOCTYPE html>
<html lang = "en">
	<title> BARANGAY PROFILE </title>
	<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/header.php"; ?>
	<body class = "loading" data-layout-config = '{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}' onload = "showGraph()">
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
                                            <li class = "breadcrumb-item"><a href = "javascript: void(0);"> Home </a></li>
                                            <li class = "breadcrumb-item active"> Profile </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Barangay Profile </h4>
                                </div>
                            </div>
                        </div>     
                        <div class = "row">
                            <div class = "col-12">
                                <div class = "card bg-primary">
                                    <div class = "card-body profile-user-box">
                                        <div class = "row">
                                            <div class = "col-sm-8">
                                                <div class = "row align-items-center">
                                                    <div class = "col-auto">
                                                        <img src = "<?php echo "assets/images/barangay/".$logo ?>" alt = "profile-image" class = "rounded-circle avatar-lg img-thumbnail">
                                                    </div>
                                                    <div class = "col">
                                                        <div>
                                                            <h4 class = "mt-1 mb-1 text-white"> <?php echo $barangayname ?> </h4>
                                                            <p class = "font-13 text-white-50"> 
                                                                Municipality of Hagonoy <br> Province of Bulacan
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col-12">
                                <div class = "card">
                                    <div class = "card-body">
                                        <h4 class = "header-title mt-0 mb-3"> Barangay Background </h4>
                                        <p class = "text-muted font-13">
                                            <?php echo $bio ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col-xl-5">
                                <div class = "card">
                                    <div class = "card-body">
                                        <h4 class = "header-title mt-0 mb-3"> Barangay Officials </h4>
                                        <div class = "table-responsive">
                                            <table id = "tblBarangayOfficials" class = "table table-bordered table-striped dt-responsive nowrap" style = "font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th><center> Fullname </center></th>
                                                        <th><center> Position </center></th>
                                                    </tr>
                                                </thead>
                                            </table> 
                                        </div>    
                                    </div>
                                </div>
                                <div class = "card">
                                    <div class = "card-body">
                                        <h4 class = "header-title mt-0 mb-3"> Contact Person </h4>
                                        <div class = "text-start">
                                            <p class = "text-muted">
                                                <strong> Fullname : </strong><span class = "ms-2"> <?php echo $fullname ?> </span>
                                            </p>
                                            <p class = "text-muted">
                                                <strong> Email Address :</strong><span class = "ms-2"> <?php echo $email ?> </span>
                                            </p>
                                            <p class = "text-muted">
                                                <strong> Mobile Number : </strong><span class = "ms-2"> <?php echo $mobile ?> </span>
                                            </p>
                                            <p class = "text-muted">
                                                <strong> Telphone Number : </strong><span class = "ms-2"> <?php echo $telephone ?> </span>
                                            </p>
                                            <p class = "text-muted mb-0" id = "tooltip-container">
                                                <strong> Social Media : </strong>
                                                <a class = "d-inline-block ms-2 text-muted" data-bs-container = "#tooltip-container" data-bs-placement = "top" data-bs-toggle = "tooltip" href = "<?php echo $facebook ?>" target = "_blank" title = "Facebook">
                                                    <i class = "mdi mdi-facebook"></i>
                                                </a>
                                                <a class = "d-inline-block ms-2 text-muted" data-bs-container = "#tooltip-container" data-bs-placement = "top" data-bs-toggle = "tooltip" href = "https://www.google.com/intl/fil/gmail/about/" target = "_blank" title = "Gmail">
                                                    <i class = "mdi mdi-gmail"></i>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class = "card">
                                    <div class = "card-body">
                                        <h4 class = "header-title mt-0 mb-3"> Location </h4>
                                        <div class = "mb-3">
                                            <iframe src = "<?php echo $location ?>" width = "425" height = "425" style = "border:0;" allowfullscreen = "" loading = "lazy" referrerpolicy = "no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-xl-7">
                                <div class = "card">
                                    <div class = "card-body">
                                        <h4 class = "header-title mb-3"> House Populations & Number Of Households </h4>
                                        <div dir = "ltr">
                                            <div style = "height: 260px;" class = "chartjs-chart">
                                                <canvas id = "chartHousehold"> </canvas>
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                                <div class = "card">
                                    <div class = "card-body">
                                        <h4 class = "header-title mb-3"> Demographic Details </h4>
                                        <table id = "tblDemographicData" class = "table table-bordered table-striped dt-responsive nowrap w-100" style = "font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th><center> YEAR </center></th>
                                                    <th><center> HOUSE POPULATIONS </center></th>
                                                    <th><center> NUMBER OF HOUSEHOLDS </center></th>
                                                    <th><center> AVERAGE HOUSEHOLD SIZE </center></th>
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
		<?php include $common_path."Main/mainJs.php"; ?>
	</body>
</html>