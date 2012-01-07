<?php
	//// Class to connect to a model and store data
	class Controller {
		public $model;
		public $data;
		public $headersArray = array ();
		
		public function __construct($args) {
			if (!empty($args)){
				foreach ($args as $key=>$item){
					$this->$key = $item;
				}
			}
			// Create new model for the controller		
			$controller = $this->model = new Model($args);
		}
		
		//// Pass statement to model
		public function addStatement($statement){
			$this->model->addStatement($statement);
			return $this;
		}
		
		//// Execute all statements in array and passed
		public function invoke($statements = array ()){
			if (!empty($statements)){
				// If array loop through each statement
				if(is_array($statements)){
					foreach($statements as $statement){
						$this->addStatement($statement);
					}
				}
				else{
					$this->addStatement($statements);
				}
			}
			$this->model->invoke();
			return $this;
		}
		
		//// Fetch all results from executed statements
		public function fetchAll($fetchStyle = PDO::FETCH_CLASS){
			$this->data = $this->model->fetchAll($fetchStyle);
			return $this;
		}
		
		// Begin transaction with model's PDO MySQL connection. Statements execute only on commit.
		public function beginTransaction(){
			$this->model->beginTransaction();
			return $this;
		}
		
		// Commit transaction to model's PDO MySQL connection.
		public function commitTransaction(){
			$this->model->commitTransaction();
			return $this;
		}
		
		public function setHeader($headersArray = array()){
			// Start output buffering to show headers first always
			ob_start();
			if (!empty($headersArray)){
				if(is_array($headersArray)){
					foreach ($headersArray as $header){
						$this->setHeader($header);
					}
				}
				elseif(is_string($headersArray)){
					array_push($this->headersArray, $headersArray);
				}
				elseif(is_int($headersArray)){
					array_push($this->headersArray, $headersArray);
				}
			}
			return $this;
		}
		
		public function displayHeaders(){
			foreach ($this->headersArray as $header){
				// Load & include header view template
				// Avoid creating an exposed variable here $headerFile
				if(file_exists(ROOT . DS . 'application'  . DS . 'views' . DS . 'headers' . DS . $header . '.php')){
					include(ROOT . DS . 'application'  . DS . 'views' . DS . 'headers' . DS . $header . '.php');
				}
			}
		}
		
		public function displayView(){
			// Set controller scope
			$controller = $this;
			// Set data scope
			$data = $controller->data;
			// Load view html template
			// If file exists include it
			// Avoid creating an exposed variable here for $viewFile
			if(file_exists(ROOT . DS . 'application'  . DS . 'views' . DS . $this->database . DS . $this->view . '.php')){
				// Display headers before the view
				$controller->displayHeaders();
				include(ROOT . DS . 'application'  . DS . 'views' . DS . $this->database . DS . $this->view . '.php');
			}
			else{
				// Set 404 header if view cannot be loaded
				$controller->setHeader('404');
				// Display the 404
				$controller->displayHeaders();
			}
			ob_end_flush();
		}	
	}
?>