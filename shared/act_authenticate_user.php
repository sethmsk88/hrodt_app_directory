<?php
// This authenticates the user's login info
// Returns a 1 to indicate success, or 0 to indicate failure
// NOTE: The return values are not actually returned, but echoed so that they can be received
//	in the form of an AJAX response.
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/apps/shared/login_functions.php';;

if (isset($_POST['email'], $_POST['p'])) {
	$email = $_POST['email'];
	$hashedPassword = $_POST['p'];

	if (login($email, $hashedPassword, $conn) == true) {
		echo 1;
	}
	else {
		echo 0;
	}
}

?>