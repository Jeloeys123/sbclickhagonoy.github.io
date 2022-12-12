<?php
	date_default_timezone_set("Asia/Manila");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
    include $common_path."session_logged.php";
    $employeecode = base64_decode($_GET['id']);
	include $modules_path."ManageUser/UpdateUser/Info.php";
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
                                    <h4 class = "page-title"> Edit User Profile </h4>
                                </div>
                            </div>
                        </div>    
                        <div class = "row">
                            <div class = "col-xl-4 col-lg-5">
                                <div class = "card text-center">
                                    <div class = "card-body">
                                        <img src = "assets/images/barangay/<?php echo $brgylogo ?>" class = "rounded-circle avatar-lg img-thumbnail" alt = "profile-image">
                                        <h4 class = "mb-0 mt-2"> <?php echo strtoupper($brgyname) ?> </h4>
                                        <div class = "text-start mt-3">
                                            <p class = "text-muted mb-2 font-13">
                                                <strong>
                                                    Email :
                                                </strong>
                                                <span class = "ms-2 ">
                                                    <?php echo strtolower($brgyemail) ?>
                                                </span>
                                            </p>
                                            <p class = "text-muted mb-2 font-13">
                                                <strong> 
                                                    Mobile :
                                                </strong>
                                                <span class = "ms-2">
                                                    <?php echo $brgymobile ?>
                                                </span>
                                            </p>
                                            <p class = "text-muted mb-1 font-13">
                                                <strong>
                                                    Telephone :
                                                </strong>
                                                <span class = "ms-2">
                                                    <?php echo $brgytelephone ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class = "col-xl-8 col-lg-5">
                                <div class = "card">
                                    <div class = "card-body">
                                        <form action = "#" method = "POST" id = "fUpdateUser" role = "form">
                                            <h5 class = "mb-4 text-uppercase"> <i class = "mdi mdi-account-circle me-1"> </i> Contact Person </h5>
                                            <div class = "row">
                                                <div class = "col-md-4">
                                                    <div class = "mb-3">
                                                        <label for = "firstname" class = "form-label"> First Name <b style = "color:red">*</b></label>
                                                        <input type = "text" id = "txtFirstname" name = "txtFirstname" class = "form-control" placeholder = "Enter first name" value = "<?php echo $firstname ?>" required>
                                                    </div>
                                                </div>
                                                <div class = "col-md-4">
                                                    <div class = "mb-3">
                                                        <label for = "middlename" class = "form-label"> Middle Name </label>
                                                        <input type = "text" id = "txtMiddlename" name = "txtMiddlename" class = "form-control" placeholder = "Enter middle name" value = "<?php echo $middlename ?>">
                                                    </div>
                                                </div>
                                                <div class = "col-md-4">
                                                    <div class = "mb-3">
                                                        <label for = "lastname" class = "form-label"> Last Name <b style = "color:red">*</b></label>
                                                        <input type = "text" id = "txtLastname" name = "txtLastname" class = "form-control" placeholder = "Enter last name" value = "<?php echo $lastname ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "suffixname" class = "form-label"> Suffix </label>
                                                        <input type = "text" id = "txtSuffixname" name = "txtSuffixname" class = "form-control" placeholder = "Enter suffix name" value = "<?php echo $suffixname ?>">
                                                    </div>
                                                </div>
                                                <div class = "col-md-3">
                                                    <div class = "mb-3">
                                                        <label for = "gender" class = "form-label"> Gender <b style = "color:red">*</b></label>
                                                        <select id = "cboGender" name = "cboGender" class = "form-control select2" data-toggle = "select2" required>
                                                            <option value = "" selected disabled> Select </option>
                                                            <option value = "F" <?php echo ($gender == "F") ? ' selected' : ''; ?>> Female </option>
                                                            <option value = "M" <?php echo ($gender == "M") ? ' selected' : ''; ?>> Male </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class = "col-md-6">
                                                    <div class = "mb-3">
                                                        <label for = "emailaddress" class = "form-label"> Email Address <b style = "color:red">*</b></label>
                                                        <input type = "email" id = "txtEmail" name = "txtEmail" class = "form-control" onkeyup = "this.value = this.value.toLowerCase();" placeholder = "Enter email" value = "<?php echo strtolower($email) ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-4">
                                                    <div class = "mb-3">
                                                        <label for = "mobilenumber" class = "form-label"> Mobile Number </label>
                                                        <input type = "text" id = "txtMobileNumber" name = "txtMobileNumber" class = "form-control" placeholder = "Enter mobile number" value = "<?php echo $mobile ?>">
                                                    </div>
                                                </div>
                                                <div class = "col-md-4">
                                                    <div class = "mb-3">
                                                        <label for = "position" class = "form-label"> Position <b style = "color:red">*</b></label>
                                                        <select id = "cboPosition" name = "cboPosition" class = "form-control select2" data-toggle = "select2" required>
                                                            <option value = "" selected disabled> Select </option>
                                                            <?php
                                                                $positioncode = "";
                                                                $description = "";
                                                                
                                                                $positionMstrQuery = "SELECT
                                                                        POSITIONCODE,
                                                                        DESCRIPTION 
                                                                    FROM
                                                                        position_mstr 
                                                                    WHERE
                                                                        POSITIONCODE IN ( 'BS', 'SK' ) 
                                                                    ORDER BY
                                                                        DESCRIPTION";
                                                                $positionMstrResult = $db_controller->runQuery($positionMstrQuery);
                                                                if($positionMstrResult != NULL)
                                                                {
                                                                    foreach($positionMstrResult as $positionMstrData)
                                                                    {
                                                                        $positioncode = $positionMstrData['POSITIONCODE'];
                                                                        $description = $positionMstrData['DESCRIPTION'];
                                                                        
                                                                        if($position == $positioncode)
                                                                        {
                                                                            $selected = "selected";
                                                                        }
                                                                        
                                                                        echo "
                                                                            <option value = ".strtoupper($positioncode)." $selected>".$description."</option>
                                                                        ";
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class = "col-md-4">
                                                    <div class = "mb-3">
                                                        <label for = "username" class = "form-label"> Username </label>
                                                        <input type = "text" id = "txtUsername" name = "txtUsername" class = "form-control" placeholder = "Enter username" value = "<?php echo $employeecode ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-md-12">
                                                    <div class = "mb-3">
                                                        <label for = "address" class = "form-label"> Address </label>
                                                        <input type = "text" id = "txtAddress" name = "txtAddress" class = "form-control" placeholder = "Enter address" value = "<?php echo $address ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "text-end">
                                                <button type = "submit" class = "btn btn-success mt-2">
                                                    <i class = "mdi mdi-content-save"></i> Save 
                                                </button>
                                                <button type = "button" class = "btn btn-danger mt-2" title = "Back" onclick = "isBtnBack()">
                                                    <i class = "uil uil-arrow-left"></i> Back 
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div> 
                            </div>
                            <input type = "hidden" id = "txtAccountCode" name = "txtAccountCode" value = "<?php echo strtoupper($accountcode) ?>">
                            <input type = "hidden" id = "txtBrgycode" name = "txtBrgycode" value = "<?php echo strtoupper($barangaycode) ?>">
                            <input type = "hidden" id = "txtEmpcode" name = "txtEmpcode" value = "<?php echo strtoupper($employeecode) ?>">
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