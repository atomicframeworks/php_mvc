<?php
	global $controller;

	//// Set error display 

	function setReporting() {
		if (DEVELOPMENT_ENVIRONMENT == true) {
			error_reporting(E_ALL);
			ini_set('display_errors','On');
		}
		else {
			error_reporting(E_ALL);
			ini_set('display_errors','Off');
			ini_set('log_errors', 'On');
			ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
		}
	}
	
	/** Check for Magic Quotes and remove them **/

	function stripSlashesDeep($value) {
		$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
		return $value;
	}

	function removeMagicQuotes() {
		// Escape if magic quotes are enabled
		if ( get_magic_quotes_gpc() ) {
			$_GET = stripSlashesDeep($_GET);
			$_POST = stripSlashesDeep($_POST);
			$_COOKIE= stripSlashesDeep($_COOKIE);
		}
	}


	//// Check register globals and remove them
	
	function unregisterGlobals() {
	    if (ini_get('register_globals')) {
	        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
	        foreach ($array as $value) {
	            foreach ($GLOBALS[$value] as $key => $var) {
	                if ($var === $GLOBALS[$key]) {
	                    unset($GLOBALS[$key]);
	                }
	            }
	        }
	    }
	}
	

	//// Autoload any classes

	function autoload($className) {
		
		if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . strtolower($className) . '.class.php')) {
			require_once(ROOT . DS . 'application' . DS . 'views' . DS . strtolower($className) . '.class.php');
		} 
		if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.class.php')) {
			require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.class.php');
		} 
		if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.class.php')) {
			require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.class.php');
		}
		if (file_exists(ROOT . DS . 'application' . DS . 'includes' . DS . strtolower($className) . 'connect.inc.php')) {
			require_once(ROOT . DS . 'application' . DS . 'includes' . DS . strtolower($className) . 'connect.inc.php');
		}
		if (file_exists(ROOT . DS . 'application' . DS . 'includes' . DS . strtolower($className) . 'statement.class.php')) {
			require_once(ROOT . DS . 'application' . DS . 'includes' . DS . strtolower($className) . 'statement.class.php');
		}  
		
	}
	
	function tQuote($val = ''){
		return trim($val,"\x22\x27");
	}
	
	function callHook (){
		//// Get url query string
		$url = $_GET['url'];
		//// Break to array based on directory separator
		$urlArray = explode(DIRECTORY_SEPARATOR, $url);
		//// Separate controller & view strings from query
		$controller_str = $urlArray[0];
		$view_str = $urlArray[1];
		
		
		//// Load files needed for controller & view
		//echo "Controller: {$controller_str} <br/>";		
		autoLoad($controller_str);
		//echo "View: {$view_str} <br/>";
		autoLoad($view_str);
							
		$args = array('username' => DB_USERNAME, 'password' => DB_PASSWORD, 'database' => $controller_str, 'view'=>$view_str);
		
		global $controller;
		$controller = new Controller($args);
		
						
		$queryArray= explode('?query=',$_SERVER['REQUEST_URI']);
		if(!empty($queryArray[1])){
			$queryString = $queryArray[1];
			$queryString = urldecode(tQuote($queryString));
		//echo "<br/> Query: $queryString <br/>";
		$controller->addStatement($queryString)->invoke()->fetchAll();
		}
				$controller->displayView();

		
	}

	
setReporting();
unregisterGlobals();
removeMagicQuotes();
//// Load base controller and model classes
autoLoad('controller');
autoLoad('model');

// Load new controllers and views
callHook();

