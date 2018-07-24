<?php
	// Associative array containing the DB connection info
	$dbInfo = Array();
	$dbInfo['user'] = 'user_dev';
	$dbInfo['password'] = '$3thFDBC0des';
	$dbInfo['dbName'] = 'hrodt';
	$dbInfo['dbIP'] = 'localhost';

	define("HOST", "localhost");
	define("DB_USER", "user_dev");
	define("DB_PASSWORD", "$3thFDBC0des");
	define("DB_SECURE_LOGIN", "secure_login");
	define("DB_HRODT", "hrodt");

	define("CAN_REGISTER", "any");
	define("DEFAULT_ROLE", "user");

	define("SECURE", false); // For development only
?>
