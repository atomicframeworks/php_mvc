<?php
	
	//// Check for Magic Quotes and remove them
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
	
	function getParams(){
		$return = array ();
		$query_str = substr($_SERVER['QUERY_STRING'],4);
		if (!empty($query_str)){
			// Remove possible controller / view from query str
			$query_str = explode($query_str, $_SERVER['REQUEST_URI']);
			// Remove ? from query str
			if (substr($query_str[1],0,1) == '?'){
				$query_str = substr($query_str[1], 1 );
			}
			if(is_string($query_str)){
				// parse query to vars in return array
				parse_str($query_str, $return);
			}
		}
		else {
			
		}
		return $return;
	}
	
		
	function contains_bad_str($str_to_test) {
		$bad_strings = array(
		            "content-type:",
		            "mime-version:",
		            "multipart/mixed",
		            "Content-Transfer-Encoding:",
		            "bcc:",
		            "cc:",
		            "to:"
		);
	
		foreach($bad_strings as $bad_string) {
			$bad_string = str_replace("/", "\/",$bad_string);
			if(preg_match("/(".$bad_string.")/i", strtolower($str_to_test)) != 0) {
			  return true;
			}
		}
	}

	function contains_newlines($str_to_test) {
	   if(preg_match("/(%0A|%0D|\\n+|\\r+)/i", $str_to_test) != 0) {
	     return true;
	   }
	}
	
	function check_email_input($str_to_test){
		if(contains_newlines($str_to_test) || contains_bad_str($str_to_test)){
			return false;
		}
		else{
			return true;
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
	//// Trim quotes from string
	function tQuote($val = ''){
		return trim($val,"\x22\x27");
	}

	//// Hook used to load our view and controller from url string
	function callHook (){
		// Create new global registry
		$registry = Registry::Construct();
		// Default controller that will load if none is found
		$controller_str = DEFAULT_CONTROLLER;
		//Default view that will load if none is found
		$view_str = DEFAULT_VIEW;
		$username_str = DB_USERNAME;
		$password_str = DB_PASSWORD;
		
		$registry->httpRequest = new HttpRequest();
		// check query statements
		$url = $registry->httpRequest->get('url');

		// Get url query string
		if(!empty($url)){
			// Route the URL
			Router::route($url);

			// Break to array based on directory separator
			$urlArray = explode(DIRECTORY_SEPARATOR, $url);
			// Separate controller & view strings from query
			if (!empty($urlArray[0])){
				$controller_str = $urlArray[0];
			}
			if (!empty($urlArray[1])){
				$view_str = $urlArray[1];
				//print_r( $view_str);
			}

		}
		else{
			// On controller fail either create controller & set 404 or use default controller & views above
			//$args = array('username' => DB_USERNAME, 'password' => DB_PASSWORD, 'database' => $controller_str, 'view'=>$view_str);
			//$controller = new Controller($args);
			//$controller->setHeader(DEFAULT_404_HEADER);
		}
		// Create array to hold properties for controller	
		$args = array('username' => $username_str, 'password' => $password_str, 'database' => $controller_str, 'controller' => $controller_str, 'view'=>$view_str, 'model' => $controller_str,'registry'=>$registry);
		
		// Create new controller if exists as a class
		if(class_exists($args['controller'])){
			$registry->controller = new $args['controller']($args);
		}
		elseif(class_exists('Controller')){
			// Else create default controller
			$registry->controller = new Controller($args);
		}
	
		// If view exists as a method on controller call it
		if (method_exists($registry->controller,$view_str)){
			$registry->controller->$view_str();
		}
		
		// Check query statements
		$query = $registry->httpRequest->get('query');
		if (!empty($query)){
			$queryString = urldecode($query);
			//echo "<br/> Query: $queryString <br/>";
			$registry->controller->addStatement($queryString);
			//Execute & return
			$registry->controller->invoke()->fetchAll();
		}

		$registry->controller->render();    
	}
// Start outbound buffering - Only header data will be sent until a ->render() call is made and the buffer is flushed to output
ob_start();
// Security checks
unregisterGlobals();
removeMagicQuotes();
// Hook new controllers and views
callHook();

