<?php
	date_default_timezone_set("Asia/Manila");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
    include $common_path."session_logged.php";
    $currentyear = date("Y");
?>
<!DOCTYPE html>
<html lang = "en">
	<title> Home </title>
	<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/header.php"; ?>
	<body class = "loading" id = "authentication-bg" data-layout-config = '{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <div class = "wrapper">
            <?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/leftsidebar.php"; ?>
            <div class = "content-page">
                <div class = "content">
                    <?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/navigationbar.php"; ?>
                    <div class = "container-fluid">
                        <br>
                        <?php
                            if($usertype == "Administrator")
                            {
                        ?>
                                <div class = "row">
                                    <div class = "col-12">
                                        <div class = "card">
                                            <div class = "card-header pb-0 pb-0">
                                                <h5> Barangays </span></h5>
                                            </div>
                                            <div class = "card-body">
                                                <div class = "row col-md-12">
                                                    <?php
                                                        $brgycode = "";
                                                        $brgyname = "";
                                                        $brgylogo = "";
                                                        $censusyear = "";
                                                        $householdpop = "";
                                                        $avghousehold = "";
                                                        $brgyMstrQuery = "SELECT
                                                                BRGYCODE,
                                                                BRGYNAME,
                                                                BRGYLOGO 
                                                            FROM
                                                                barangay_mstr 
                                                            ORDER BY
                                                                BRGYNAME";
                                                        $brgyMstrResult = $db_controller->runQuery($brgyMstrQuery);
                                                        if($brgyMstrResult != NULL)
                                                        {
                                                            foreach($brgyMstrResult as $brgyMstrData)
                                                            {
                                                                $brgycode = $brgyMstrData['BRGYCODE'];
                                                                $brgyname = $brgyMstrData['BRGYNAME'];
                                                                $brgylogo = $brgyMstrData['BRGYLOGO'];
                                                                
                                                                $demographicMstrQuery = "SELECT
                                                                        CENSUSYEAR,
                                                                        HOUSEHOLD_POPULATION,
                                                                        AVERAGE_HOUSEHOLD 
                                                                    FROM
                                                                        demographic_mstr 
                                                                    WHERE
                                                                        UPPER( BRGYCODE ) = '$brgycode' 
                                                                        AND CENSUSYEAR = '$currentyear'";
                                                                $demographicRowResult = $db_controller->numRows($demographicMstrQuery);
                                                                $demographicMstrResult = $db_controller->runQuery($demographicMstrQuery);
                                                                if($demographicRowResult == 0)
                                                                {
                                                                    $demographic2020Query = "SELECT
                                                                            CENSUSYEAR,
                                                                            HOUSEHOLD_POPULATION,
                                                                            AVERAGE_HOUSEHOLD 
                                                                        FROM
                                                                            demographic_mstr 
                                                                        WHERE
                                                                            UPPER( BRGYCODE ) = '$brgycode' 
                                                                            AND CENSUSYEAR = '2020'";
                                                                    $demographic2020Result = $db_controller->runQuery($demographic2020Query);
                                                                    if($demographic2020Result != NULL)
                                                                    {
                                                                        $censusyear = $demographic2020Result[0]['CENSUSYEAR'];
                                                                        $householdpop = $demographic2020Result[0]['HOUSEHOLD_POPULATION'];
                                                                        $avghousehold = $demographic2020Result[0]['AVERAGE_HOUSEHOLD'];
                                                    ?>
                                                                        <div class = "col-md-4 hover-8">
                                                                            <div class = "blog-box blog-grid">
                                                                                <div class = "blog-wrraper">
                                                                                    <a href = "#" class = "isBtnBarangay" id = "<?php echo $brgycode ?>">
                                                                                        <img src = "<?php echo "assets/images/barangay/".$brgylogo ?>" alt = "" height = "250">
                                                                                    </a>
                                                                                </div>
                                                                                <div class = "blog-details-second">
                                                                                    <a href = "#" class = "isBtnBarangay" id = "<?php echo $brgycode ?>">
                                                                                        <h6 class = "blog-bottom-details">
                                                                                            <?php echo strtoupper($brgyname) ?>
                                                                                        </h6>
                                                                                    </a>
                                                                                    <p>
                                                                                        <b> <?php echo $brgyname ?> </b> is a barangay in the municipality of Hagonoy, in the province of Bulacan. Its population as determined by the <?php echo $censusyear ?> Census was <?php echo number_format($householdpop) ?>. This represented <?php echo $avghousehold ?>% of the total population of Hagonoy.
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                    <?php
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    $censusyear = $demographicMstrResult[0]['CENSUSYEAR'];
                                                                    $householdpop = $demographicMstrResult[0]['HOUSEHOLD_POPULATION'];
                                                                    $avghousehold = $demographicMstrResult[0]['AVERAGE_HOUSEHOLD'];
                                                    ?>
                                                                    <div class = "col-md-4 hover-8">
                                                                        <div class = "blog-box blog-grid">
                                                                            <div class = "blog-wrraper">
                                                                                <a href = "#" class = "isBtnBarangay" id = "<?php echo $brgycode ?>">
                                                                                    <img src = "<?php echo "assets/images/barangay/".$brgylogo ?>" alt = "" height = "250">
                                                                                </a>
                                                                            </div>
                                                                            <div class = "blog-details-second">
                                                                                <a href = "#" class = "isBtnBarangay" id = "<?php echo $brgycode ?>">
                                                                                    <h6 class = "blog-bottom-details">
                                                                                        <?php echo strtoupper($brgyname) ?>
                                                                                    </h6>
                                                                                </a>
                                                                                <p>
                                                                                    <b> <?php echo $brgyname ?> </b> is a barangay in the municipality of Hagonoy, in the province of Bulacan. Its population as determined by the <?php echo $censusyear ?> Census was <?php echo number_format($householdpop) ?>. This represented <?php echo $avghousehold ?>% of the total population of Hagonoy.
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/rightsidebar.php"; ?>
        <div class = "rightbar-overlay"> </div>
		<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/footer.php"; ?>
		 <?php include $common_path."Main/MainJs.php"; ?> 
	</body>
</html>