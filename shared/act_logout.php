<?php
require_once './login_functions.php';

sec_session_start();

// Unset all session values
$_SESSION = array();

// Get session params
$params = session_get_cookie_params();

// Delete the actual cookie
setcookie(session_name(),
	'', time() - 42000,
	$params["path"],
	$params["domain"],
	$params["secure"],
	$params["httponly"]
);

// Destroy session
session_destroy();

// Redirect to url redirect variable if it exists, otherwise redirect to main HRODT page
if (isset($_GET['redirect'])) {
	header('Location: ' . $_GET['redirect']);
} else {
	header('Location: ../index.php');
}
?>
