<?php
class View {

	protected $_controller;
	protected $_view;
	protected $_viewFile;
	protected $_headers = array();
	protected $vars = array();

	function __construct($args) {
		// Set controller & view
		$this->_controller = $args['controller'];
		$this->_view = $args['view'];
		// Set non view pre headers (if any)
		if(!empty($args['header'])){
			$this->setHeader($args['header']);
		}
	}

	// Set var function
	function set($name,$value) {
		$this->vars[$name] = $value;
	}
	
	function __toString(){
		return (string) $this->_view;
	}
	
	// Set a header or array of headers
	// pushes to the non view pre header array
	public function setHeader($headersArray = array()){
		if (!empty($headersArray)){
			if(is_array($headersArray)){
				foreach ($headersArray as $header){
					$this->setHeader($header);
				}
			}
			elseif(is_string($headersArray)){
				array_push($this->_headers, $headersArray);
			}
			elseif(is_int($headersArray)){
				array_push($this->_headers, $headersArray);
			}
		}
		return $this;
	}

	// Display view
    function render() {
    	// Extract & set variable scope
		extract($this->vars);
		
		// Set view & controller vars for template
		$controller = $this->_controller;
		$view = $this->_view;

		//// Include view
		// Load view html template
		// If file exists include it
		// Else if file exists /controller/default_view  include it
		// Else set 404
		if(file_exists(APP_ROOT .  'views' . DS . $controller . DS . $view . '.php')){
			$this->_viewFile = APP_ROOT .  'views' . DS . $controller . DS . $view . '.php';
		}
		elseif(file_exists(APP_ROOT .  'views' . DS . $controller . DS . DEFAULT_VIEW . '.php')){
			$this->_viewFile = APP_ROOT .  'views' . DS . $controller . DS . DEFAULT_VIEW . '.php';
		}
		else{
			// Set 404 header if view cannot be loaded
			ErrorReporter::throwError('Could not load view: ' . $controller . DS . $view , 'warning');
			$this->setHeader(DEFAULT_404_HEADER);
			// Display the 404
		}
		
		// Display our non view headers (404, 503, etc)
		foreach ($this->_headers as $header){
			if(file_exists(APP_ROOT . 'views' . DS . 'headers' . DS . $header . '.php')){
				include_once(APP_ROOT . 'views' . DS . 'headers' . DS . $header . '.php');
			}
		}
		
		// Include view header
		if (file_exists(APP_ROOT . 'views' . DS . $controller . DS . 'header.php')) {
			include (APP_ROOT. 'views' . DS . $controller . DS . 'header.php');
		} 
		elseif (file_exists(APP_ROOT . 'views' . DS . 'headers' . DS .'default.php')){
			// If no view header include default header
			include (APP_ROOT . 'views' . DS . 'headers' . DS .'default.php');
		}
		
		// Include the main view
		include_once($this->_viewFile);
		
		// Include view footers
		if (file_exists(APP_ROOT . DS . 'views' . DS . $controller . DS . 'footer.php')) {
			include (APP_ROOT . 'views' . DS . $controller . DS . 'footer.php');
		} 
		elseif (file_exists(APP_ROOT . 'views' . DS . 'footers' . DS .'default.php')) {
			// If no view footer include default footer
			include (APP_ROOT . 'views' . DS . 'footers' . DS .'default.php');
		}
		ob_end_flush();
    }

}