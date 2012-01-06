<?php
	//// Class to connect to a model and store data
	class Controller {
		public $model;
		public $data;
		
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
		
		public function displayView(){
			// Set controller scope
			$controller = $this;
			// Set data scope
			$data = $controller->data;
			// Load view html template
			$viewFile = ROOT . DS . 'application'  . DS . 'views' . DS . $this->database. DS .$this->view.'.php';
			// Include it
			if(file_exists($viewFile)){
				include($viewFile);
			}
		}	
	}
?>