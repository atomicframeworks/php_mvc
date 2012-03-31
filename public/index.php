<?php
	//// Globals
	define('DS', DIRECTORY_SEPARATOR);
	// Double dirname to go back 2 levels
	define('ROOT',dirname(dirname(__FILE__)));
	//// Load up our bootstrap (which loads config & shared files)
	require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');