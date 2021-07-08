<?php
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
	$admin_info = $_SESSION['admin_info'];
	$admin_email = $admin_info->admin_email;
	$admin_login_verification = "SELECT  `admin_email` FROM `admin_users` WHERE `admin_email`='$admin_email'";
	$admin_login_verification_result = mysqli_query($connection_string, $admin_login_verification);
	if (!$admin_login_verification_result) {
		header('Location:../../log_out.php');
	}
} else {
	header('Location:../../log_out.php');
}