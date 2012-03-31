<?php
	//// Load config definitions
	require_once (ROOT . DS . 'config' . DS . 'config.php');
	//// Load routes url redirects
	require_once (ROOT . DS . 'config' . DS . 'routes.php');
	//// Load library classes
	require_once (ROOT . DS . 'library' . DS . 'bootclasses.php');
	// Register our error reporting & handler function
	ErrorReporter::register();
	// Register our autoloader functions
	Autoloader::register();
	//// Load shared files
	require_once (ROOT . DS . 'library' . DS . 'shared.php');