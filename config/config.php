<?php

	//// Global config options
	define('DEVELOPMENT_ENVIRONMENT',false);
	
	define('DB_USERNAME', 'username');
	define('DB_PASSWORD', 'password');
	define('DB_HOST', 'localhost');

	define('DEFAULT_CONTROLLER', 'proxies');	
	define('DEFAULT_VIEW', 'select');
	
	define('DEFAULT_404_HEADER', '404');	
	define('DEFAULT_503_HEADER', '503');	
	define('DEFAULT_TEXT_HEADER', 'txt');
	
	define('DEFAULT_JQUERY', ROOT . DS . 'application' . DS . 'includes/jquery.php');

	define('ASSET_HOST', 'http://'.$_SERVER['HTTP_HOST']);