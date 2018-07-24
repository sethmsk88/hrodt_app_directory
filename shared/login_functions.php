<?php
function sec_session_start() {
	$session_name = 'sec_session_id'; // Set a custom session name
	$secure = SECURE;

	// This stops JavaScript being able to access the session id
	$httponly = true;

	/* Forces sessions to only use cookies */
	if (ini_set('session.use_only_cookies', 1) === false) {
		header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
		exit();
	}

	// Get current cookies params
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"],
		$cookieParams["path"],
		$cookieParams["domain"],
		$secure,
		$httponly);

	// Set the session name to the one set above
	session_name($session_name);

	// Start the PHP session
	session_start();

	// Regenerate the session, delete the old one
	session_regenerate_id(true);
}



function getUserId($email) {
	$stmt = $conn->prepare("
		select UserId
		from user_management.users
		where email = ?
	";
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows === 0)
		return -1; // no user has that email address
	
	$row = $result->fetch_assoc();
	return $row['UserId'];
}

function login($email, $hashedPassword, $conn) {

	sec_session_start();

	/* Get user record with matching email */
	$stmt = $conn->prepare("
		SELECT UserId, Email, FirstName, LastName, Password, TempPassword, TempPasswordCreated
		FROM user_management.users
		WHERE Email = ?";
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows === 0)
		return -1; // no user has that email address
	
	$user = $result->fetch_assoc();

	// Check to see if the password in the DB matches the
	// password the user submitted
	if ($hashedPassword != $user['Password']) {
		return false; // login failed
	}

	$_SESSION['user_id'] = $user['UserId'];
	$_SESSION['login_string'] = hash('sha512', $password . $_SERVER['HTTP_USER_AGENT'];);

	// XSS protection as we might print these values
    $firstName = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $firstName);
    $lastName = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $lastName);
    $_SESSION['firstName'] = $firstName;
	$_SESSION['lastName'] = $lastName;
}

?>