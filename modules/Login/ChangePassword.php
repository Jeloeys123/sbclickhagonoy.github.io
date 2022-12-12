<?php
	date_default_timezone_set("Asia/Manila");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
    $empcode = base64_decode($_GET['id']);
?>
<!DOCTYPE html>
<html lang = "en">
	<title> CLICK HAGONOY - CHANGE PASSWORD </title>
	<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/header.php"; ?>
	<body class = "loading authentication-bg" data-layout-config = '{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <div class = "account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class = "container">
                <div class = "row justify-content-center">
                    <div class = "col-xxl-4 col-lg-5">
                        <div class = "text-center">
                            <a href = "login">
                                <span>
                                    <img src = "assets/images/KasangguniLogo.png" alt = "" height = "103">
                                </span>
                            </a>
                        </div>
                        <br>
                        <div class = "card">
                            <div class = "card-body p-4">
                                <div class = "text-center w-75 m-auto">
                                    <h4 class = "text-dark-50 text-center mt-0 fw-bold"> Change Password </h4>
                                    <p class = "text-muted mb-4">
                                        Enter your new password to change your password.
                                    </p>
                                </div>
                                <form action = "#" method = "POST" id = "fChangePassword" role = "form">
                                    <div class = "mb-3">
                                        <label for = "newpassword" class = "form-label"> New Password </label>
                                        <div class = "input-group input-group-merge">
                                            <input type = "password" id = "txtNewPassword" name = "txtNewPassword" class = "form-control" placeholder = "Enter your new password" required>
                                            <div class = "input-group-text" data-password = "false">
                                                <span class = "password-eye"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type = "hidden" id = "txtEmpcode" name = "txtEmpcode" value = "<?php echo $empcode ?>">
                                    <div class = "mb-0 text-center">
                                        <button type = "submit" class = "btn btn-primary"> Change Password </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/footer.php"; ?>
		<?php include $common_path."Login/LoginJs.php"; ?>
	</body>
</html>