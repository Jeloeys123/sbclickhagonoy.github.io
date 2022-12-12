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
	<title> CREATE NEW USER </title>
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
                                            <li class = "breadcrumb-item active"> Add User </li>
                                        </ol>
                                    </div>
                                    <h4 class = "page-title"> Create User Profile </h4>
                                </div>
                            </div>
                        </div>     
                        <div class = "row">
                            <div class = "col-xl-12 col-lg-5">
                                <div class = "card">
                                    <div class = "card-body">
                                        <form action = "#" method = "POST" id = "fAddUser" role = "form">
                                            <div class = "row">
                                                <div class = "col-md-12">
                                                    <div class = "mb-3">
                                                        <label for = "brgyname" class = "form-label"> Barangay Name <b style = "color:red">*</b></label>
                                                        <select id = "cboBarangay" name = "cboBarangay" class = "form-control select2" data-toggle = "select2" required>
                                                            <option value = "" selected disabled> Select </option>
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
                                            </div>
                                            <h5 class = "mb-4 text-uppercase"> <i class = "mdi mdi-account-circle me-1"> </i> Contact Person </h5>
                                            <div class = "row">
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "firstname" class = "form-label"> First Name <b style = "color:red">*</b></label>
                                                        <input type = "text" id = "txtFirstname" name = "txtFirstname" class = "form-control" placeholder = "Enter first name" required>
                                                    </div>
                                                </div>
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "middlename" class = "form-label"> Middle Name </label>
                                                        <input type = "text" id = "txtMiddlename" name = "txtMiddlename" class = "form-control" placeholder = "Enter middle name">
                                                    </div>
                                                </div>
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "lastname" class = "form-label"> Last Name <b style = "color:red">*</b></label>
                                                        <input type = "text" id = "txtLastname" name = "txtLastname" class = "form-control" placeholder = "Enter last name" required>
                                                    </div>
                                                </div>
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "suffixname" class = "form-label"> Suffix Name </label>
                                                        <input type = "text" id = "txtSuffixname" name = "txtSuffixname" class = "form-control" placeholder = "Enter suffix name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "gender" class = "form-label"> Gender <b style = "color:red">*</b></label>
                                                        <select id = "cboGender" name = "cboGender" class = "form-control select2" data-toggle = "select2" required>
                                                            <option value = "" selected disabled> Select </option>
                                                            <option value = "F"> Female </option>
                                                            <option value = "M"> Male </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "email" class = "form-label"> Email Address <b style = "color:red">*</b></label>
                                                        <input type = "email" id = "txtEmail" name = "txtEmail" class = "form-control" onkeyup = "this.value = this.value.toLowerCase();" placeholder = "Enter email" required>
                                                    </div>
                                                </div>
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "mobilenumber" class = "form-label"> Mobile Number </label>
                                                        <input type = "text" id = "txtMobileNumber" name = "txtMobileNumber" class = "form-control" placeholder = "Enter mobile number">
                                                    </div>
                                                </div>
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "position" class = "form-label"> Position <b style = "color:red">*</b></label>
                                                        <select id = "cboPosition" name = "cboPosition" class = "form-control select2" data-toggle = "select2" required>
                                                            <option value = "" selected disabled> Select </option>
                                                            <?php
                                                                $position = "";
                                                                $description = "";
                                                                
                                                                $positionMstrQuery = "SELECT
                                                                        POSITIONCODE,
                                                                        DESCRIPTION 
                                                                    FROM
                                                                        position_mstr 
                                                                    WHERE
                                                                        POSITIONCODE IN ( 'SK', 'BS' ) 
                                                                    ORDER BY
                                                                        DESCRIPTION";
                                                                $positionMstrResult = $db_controller->runQuery($positionMstrQuery);
                                                                if($positionMstrResult != NULL)
                                                                {
                                                                    foreach($positionMstrResult as $positionMstrData)
                                                                    {
                                                                        $position = $positionMstrData['POSITIONCODE'];
                                                                        $description = $positionMstrData['DESCRIPTION'];
                                                                        
                                                                        echo "
                                                                            <option value = ".strtoupper($position).">".$description."</option>
                                                                        ";
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-12">
                                                    <div class = "mb-3">
                                                        <label for = "address" class = "form-label"> Address </label>
                                                        <input type = "text" id = "txtAddress" name = "txtAddress" class = "form-control" placeholder = "Enter address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "text-end">
                                                <button type = "submit" class = "btn btn-success mt-2">
                                                    <i class = "mdi mdi-content-save"></i> Save 
                                                </button>
                                            </div>
                                        </form>
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
		<?php include $common_path."ManageUser/Adduser/AddUserJs.php"; ?>
	</body>
</html>