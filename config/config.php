<?php
	
	//// Global config options
	define('DEVELOPMENT_ENVIRONMENT', false );
	//define('DEVELOPMENT_ENVIRONMENT', true );
	// DB Defaults
	define('DB_USERNAME', 'MyUserName!');
	define('DB_PASSWORD', 'MyDBPass!');
	define('DB_HOST', 'localhost');
	// Default controller & view
	define('DEFAULT_CONTROLLER', 'headers');	
	define('DEFAULT_VIEW', '404');
	// Defaults for header views
	define('DEFAULT_404_HEADER', '404');	
	define('DEFAULT_503_HEADER', '503');	
	define('DEFAULT_TEXT_HEADER', 'txt');
	// Where the application files are hosted
	define('APP_ROOT', ROOT . DS . 'application' . DS);
	// Where the application files are hosted
	define('PUBLIC_ROOT', ROOT . DS . 'public' . DS);
	// Where assets are hosted
	define('ASSET_HOST', 'http://' . $_SERVER['SERVER_NAME'] . DS . 'assets' . DS); // Where assets are hosted
	define('ASSET_IMG', ASSET_HOST . 'img' . DS); // Where images are hosted
	define('ASSET_JS', ASSET_HOST . 'js' . DS); // Where javascript are hosted
	define('ASSET_CSS', ASSET_HOST . 'css' . DS); // Where css are hosted
	define('ASSET_TTF', ASSET_HOST . 'ttf' . DS); // Where ttf are hosted
	// Where we host jQuery (actually script call to google hosted)
	define('JQUERY', PUBLIC_ROOT . 'assets/js/jquery.php');
	// Set timezone
	date_default_timezone_set('US/Eastern');
