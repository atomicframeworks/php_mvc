<?php
class ErrorReporter {

	//// Set error display function
	public static function setReporting() {
		if (DEVELOPMENT_ENVIRONMENT == true) {
			error_reporting(E_STRICT);
			ini_set('display_errors','On');
		}
		else {
			error_reporting(E_ALL);
			ini_set('display_errors','Off');
		}
		// Always log errors
		ini_set('log_errors', 'On');
		ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS. 'error.log');
	}
	// Function to throw errors
	public static function throwError($message, $level = 'warning') {
	    //Get the caller of the calling function and details about it
	    $callee = debug_backtrace();
	    $callee = next($callee);
	    if (strtolower($level) == 'error'){
	    	$level = E_USER_ERROR;
	    }
	    elseif(strtolower($level) == 'warning'){
	   		$level = E_USER_WARNING;
	    }
	    elseif(strtolower($level) == 'notice'){
	    	$level = E_USER_NOTICE;
	    }
	    
	    //Trigger appropriate error
		trigger_error($message, $level);
	}
	
	// Our custom error handling function
	public static function errorHandler($level, $message, $file, $line, $context) {
		// Timestamp for the error entry
	    $dt = date("Y-m-d H:i:s (T)");
	    // Filter any messages sent to browser
		$message = htmlentities($message);
	    // Array of strings to represent error levels
	    $errortype = array (
	                E_ERROR              => 'Error',
	                E_WARNING            => 'Warning',
	                E_PARSE              => 'Parsing Error',
	                E_NOTICE             => 'Notice',
	                E_CORE_ERROR         => 'Core Error',
	                E_CORE_WARNING       => 'Core Warning',
	                E_COMPILE_ERROR      => 'Compile Error',
	                E_COMPILE_WARNING    => 'Compile Warning',
	                E_USER_ERROR         => 'User Error',
	                E_USER_WARNING       => 'User Warning',
	                E_USER_NOTICE        => 'User Notice',
	                E_STRICT             => 'Runtime Notice',
	                E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
	                );
	    // Set of errors for which args will be saved
	    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
		
		// Create log entry
		$paper = "\n<error>\n";
	    $paper .= "\t<datetime>" . $dt . "</datetime>\n";
	    $paper .= "\t<errortype>" . $errortype[$level] . "</errortype>\n";
	    $paper .= "\t<errormsg>" . $message . "</errormsg>\n";
	    $paper .= "\t<errornum>" . $level . "</errornum>\n";
		if (!empty($context['callee'])){
			$file = $context['callee']['file'];
			$line = $context['callee']['line'];
	    	$paper .= "\t<class>" .  $context['callee']['class'] . "</class>\n";
	    	$paper .= "\t<function>" . $context['callee']['function'] . "</function>\n";
	    }	    
		// If user error check for context callee args 
		if (in_array($level, $user_errors)) {
	        $paper .= "\t<arguments>";
			if(!empty($context['callee']['args'])){
				try {
					$paper .= wddx_serialize_value($context['callee']['args']);
				} 
				catch (Exception $e) {
					echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
			}
	        $paper .= "</arguments>\n";
	    }
	   	$paper .= "\t<scriptname>" . $file . "</scriptname>\n";
	   	$paper .= "\t<scriptlinenum>" . $line . "</scriptlinenum>\n";
	   	$paper .= "</error>\n\n";

	   	// Handle user errors, warnings, and notices ourself
	   	switch ($level) {
			case E_USER_ERROR:
				// E-mail if there is a critical user error
        		//mail("phpdev@example.com", "Critical User Error", $paper );
			    $message = "<strong>Error:</strong> " . $message;
			    break;
			
			case E_USER_WARNING:
			    $message = "<strong>Warning:</strong> " . $message;
	        	break; 
			
			case E_USER_NOTICE:
			    $message = "<strong>Notice:</strong> " . $message;
			    break;
			
			default:
			    $message = "Unknown error type: [$level] $message";
		}
		// If we are developing display errors
		if (DEVELOPMENT_ENVIRONMENT){
			echo $message . '<br />';
		}
		//print_r($paper);
		//die;
		error_log($paper, $level);
		// Prevent the PHP error handler from continuing
	    return true;  
	}
	
	public static function shutdown(){ 
	    $error=error_get_last(); 
	    if($error !==null){
	   		//Trigger appropriate error
			trigger_error($error['message'], E_USER_ERROR);
	    }  
    } 
		
	public static function register(){
		set_error_handler('ErrorReporter::errorHandler');
		ErrorReporter::setReporting();
		register_shutdown_function('ErrorReporter::shutdown');
	}

}