<?php
final class HttpRequest {
	protected $_filter;
	
	// When checking queries using arrays with defaults
	// Force default ( set default even if query param ISN't passed)
	// Normally the default is set only if the param is passed AND empty.
	protected $forceDefault = false;
	
    function __construct(){
    	return $this;
    }
    
      
    // Get requests
    // Pass the param (or none for all) and optional filter type
    function get($_parameter = null, $forceDefault = null, $_filter = null){
    	return $this->checkInput($_parameter, 'get', $forceDefault, $_filter);
    }
    
    // Post requests
    function post($_param = null, $_filter = null){
   		return $this->checkInput($_parameter, 'post', $_filter);
    }
    
    // Cookies
    function cookie($_param = null, $_filter = null){
   		return $this->checkInput($_parameter, 'cookie', $_filter);
    }
    
    // Server
    function server($_param = null, $_filter = null){
   		return $this->checkInput($_parameter, 'server', $_filter);
    }
    
    
    // REQUEST = GET & POST -  No Cookies
	function request($_param = null, $_filter = null){
    	// Check for a single param
    	if (!empty($_param)){
    		$return = $this->filterRequest($_param, INPUT_GET, $_filter);
    		// If get empty check post
    		if (empty($return)){
    			$return = $this->filterRequest($_param, INPUT_POST, $_filter);
    		}	
    	}
    	else{
    		// Create return array with empty GET and POST arrays
    		$return = array('GET'=>array(),'POST'=>array());
    		// Combine GET & POST to array
    		$_request = array_merge($_GET, $_POST);
    		foreach($_REQUEST as $_param=>$_input){
    			$val =  $this->filterRequest($_param, INPUT_GET, $_filter);
    			// If empty check post
    			if(empty($val)){
    				$val =  $this->filterRequest($_param, INPUT_POST, $_filter);
    			   	$return['POST'][$_param] = $val;
    			}
    			else{
    				// val not empty set to GET
    			   	$return['GET'][$_param] = $val;
    			}
    		}
    	}
    	return $return;
	}
    
    // Clean if magic quotes
   	private function _clean($_){
        // For arrays
        if(is_array($_)){
            $tmp = array();
            foreach($_ as $key => $val){
                //Check the $key is valid here if you wish
                $tmp[$key] = $this->_clean($val);
            }
            $_ = $tmp;
        }
        else{
			// Non array
	        if(get_magic_quotes_gpc()){
	            $_ = stripslashes($_);
	        }
        }
    	return $_;
    }
    
    public function forceDefault($forceDefault = true){
    	if (is_bool($forceDefault)){
    		$this->forceDefault = $forceDefault;
    	}
    	else{
    		ErrorReporter::ThrowError('forceDefault must be a boolean.','warning');
    	}
    }
 	
 	// Function to set filter type
 	function setFilter($filter){
 		$this->_filter = $filter;
 	}
 	
	protected function checkInput($_parameter = null, $inputType, $forceDefault = null, $_filter = null){
 		// Determine input type (only check if string)
 		if (gettype( $inputType ) == 'string' ){ 		
	 		switch (strtolower($inputType)){
	 			case "get":
	 				$inputType = INPUT_GET;
	 				$inputRef = $_GET;
	 			break;
	 			case "post":
	 				$inputType = INPUT_POST;
	 				$inputRef = $_POST;
	 			break;
	 			case "cookie":
	 				$inputType = INPUT_COOKIE;
	 				$inputRef = $_COOKIE;
	 			break;
	 			case "server":
	 				$inputType = INPUT_SERVER;
	 				$inputRef = $_SERVER;
	 			break;
	 		}
 		}
 		if (!empty($_parameter)){
    		if(is_array($_parameter)){
	    		$return = array();
	    		// loop param array and check filter request for param
	    		foreach($_parameter as $_param=>$_input){
	    			// If the item is associative (ex. 'queryParam'=>'default' )
	    			// the key is the query param we are looking for and the input is default value
	    			if (is_string($_param)){
	    				// Filter by the param the input is default
	    				$return[$_param] = $this->filterRequest($_param, $inputType, $_filter);
	    				// When checking queries using arrays with defaults
	    				// If param is empty & param is sent use default input  
	    				// OR if forceDefault set default EVEN if query param ISN't passed
						// Normally the default is set only if the param is passed AND empty.
	    				if(empty($return[$_param])){
	    					if(array_key_exists($_param,$inputRef) || ($this->forceDefault === true && $forceDefault !== false) || $forceDefault == true){
	    						$return[$_param] = $_input;
	    					}
	    				}
	    			}
	    			else{
	    				// Non associative item in array  (ex. 0=>'queryParam')
	    				// Just look for the query param
	    				$return[$_input] = $this->filterRequest($_input, $inputType, $_filter);
	    			}
	    		}
    		}
    		else{
    			// Param is not array just check for it
    			$return = $this->filterRequest($_parameter, $inputType, $_filter);
    		}
    	}
    	else{
    		// Param is empty...
    		// Loop all for input type and filter
    		$return = array();
    		foreach($_GET as $_param=>$_input){
    			$return[$_param] = $this->filterRequest($_param, $inputType, $_filter);
    		}
    	}
    	return $return;
 		
 	}
  
 	
    // Filter the param for request by filter type
    function filterRequest($_param, $_request, $_filter = null){
    	// If temp filter is empty use objects
    	if (empty($_filter)){
    		$_filter = $this->_filter;
    	}
    	// If object filter is empty use none
    	if (empty($_filter)){
    		$return = $this->_clean(filter_input($_request, $_param));
    	}
    	else{
    		$return = $this->_clean(filter_input($_request, $_param, $_filter));
    	}
    	return $return;
    }
    
}