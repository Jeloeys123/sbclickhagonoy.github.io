<?php
	date_default_timezone_set("Asia/Manila");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/config/DatabaseController.php";
	$db_controller = new DBController();
?>
<!DOCTYPE html>
<html lang = "en">
	<title> CLICK HAGONOY - FORGOT PASSWORD </title>
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
                                    <h4 class = "text-dark-50 text-center mt-0 fw-bold"> Reset Password </h4>
                                    <p class = "text-muted mb-4">
                                        Enter your username to reset your password.
                                    </p>
                                </div>
                                <form action = "#" method = "POST" id = "fForgotPassword" role = "form">
                                    <div class = "mb-3">
                                        <label for = "username" class = "form-label"> Username </label>
                                        <input type = "text" id = "txtUsername" name = "txtUsername" class = "form-control" placeholder = "Enter your username" required>
                                    </div>
                                    <div class = "mb-0 text-center">
                                        <button type = "submit" class = "btn btn-primary"> Reset Password </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class = "row mt-3">
                            <div class = "col-12 text-center">
                                <p class = "text-muted"> 
                                    Back to 
                                    <a href = "login" class = "text-muted ms-1">
                                        <b> Log In </b>
                                    </a>
                                </p>
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