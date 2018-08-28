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

function getUserId($email, $conn) {
	$stmt = $conn->prepare("
		select UserId
		from user_management.users
		where email = ?
	");
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
		WHERE Email = ?");
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows === 0)
		return false; // no user has that email address
	
	$user = $result->fetch_assoc();

	// Check to see if the password in the DB matches the
	// password the user submitted
	if ($hashedPassword != $user['Password']) {
		return false; // login failed
	}

	$_SESSION['user_id'] = $user['UserId'];
	$_SESSION['login_string'] = hash('sha512', $user['Password'] . $_SERVER['HTTP_USER_AGENT']);

	// XSS protection as we might print these values
    $_SESSION['firstName'] = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $user['FirstName']);
    $_SESSION['lastName'] = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $user['LastName']);

	return true;
}

// Get the login status and access level of the current user for this app
function login_check($appId, $conn) {
	$accessLevel = null; // Default access level is Guest
	$GLOBALS['ACCESS_LEVEL'] = $accessLevel;
	$GLOBALS['LOGGED_IN'] = false;
	$GLOBALS['LOGIN_CHECK_ERRORS'] = [];

	try {
		// If the user isn't logged in, return the default array with guest level access
		if (!isset($_SESSION['user_id'])) {
			return;
		}

		// Check to see if the user is logged in
		if (!$stmt = $conn->prepare("
			select Password
			from user_management.users
			where UserId = ?
		")) {
			throw new Exception($conn->error);
		} else if (!$stmt->bind_param("i", $_SESSION['user_id'])) {
			throw new Exception($conn->error);
		} else if (!$stmt->execute()) {
			throw new Exception($conn->error);
		}
		
		$result = $stmt->get_result();
		if ($result->num_rows === 0) {
			throw new Exception('Login Check Failed - No user exists with this User ID');
		}
		$user = $result->fetch_assoc();

		// Make sure required session variable exists
		if (!isset($_SESSION['login_string'])) {
			throw new Exception("Login Check Failed - Missing required session variable"); // login failed
		}

		$login_string = hash('sha512', $user['Password'] . $_SERVER['HTTP_USER_AGENT']);
		if ($login_string != $_SESSION['login_string']) {
			throw new Exception("Invalid login string");
		} else {
			$GLOBALS['LOGGED_IN'] = true;
		}

		// Get user access info
		$stmt = $conn->prepare("
			select u.UserId, a.AppId, au.AccessLevel, concat(u.FirstName, ' ', u.LastName) FullName
			from user_management.users u
			left join user_management.apps_users au on au.UserId = u.UserId
			left join user_management.apps a on a.AppId = au.AppId
			where u.UserId = ? and a.AppId = ?"
		);
		$stmt->bind_param("ii", $_SESSION['user_id'], $appId);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows === 0) {
			$GLOBALS['ACCESS_LEVEL'] = null; // User has guest-level access to this app
		} else {
			$userAccess = $result->fetch_assoc();
			$GLOBALS['ACCESS_LEVEL'] = $userAccess['AccessLevel'];
		}

	} catch (Exception $e) {
		array_push($GLOBALS['LOGIN_CHECK_ERRORS'], $e->getMessage());
	}
}
?>