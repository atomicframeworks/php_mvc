<?php

	class Controller {
		public $model;
		public $data;
		
		public function __construct($args) {
			if (!empty($args)){
				foreach ($args as $key=>$item){
					$this->$key = $item;
				}
			}
			//// Include the ( class . view ) action.php script
			//require_once();   		
			$controller = $this->model = new Model($args);
			
		}

				
		public function addStatement($statement){
			$this->model->addStatement($statement);
			return $this;
		}
		
		// Execute all Statements in array and passed
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
		
		
		//// Fetch all results from statements
		public function fetchAll($fetchStyle = PDO::FETCH_CLASS){
			$this->data = $this->model->fetchAll($fetchStyle);
			return $this;
		}
		
		
		//// Execute only Statements passed
		public function executeStatements($statements = array ()){
			if (!empty($statements)){
				// If array loop through
				if(is_array($statements)){
					foreach($statements as $statement){
						$this->addStatement($statement);
					}
				}
				else{
					$this->addStatement($statements);
				}
			}
			return $this;
		}
		
		public function setView($view_str = ''){
			$this->view = new $this->model.$this->view;
			return $this;  		
		}
		
		
		public function beginTransaction(){
			$this->model->beginTransaction();
			return $this;
		}
		
		public function commitTransaction(){
			$this->model->commitTransaction();
			return $this;
		}
		
		
		public function displayView(){
			$controller = $this;
			$data = $controller->data;
			$viewFile = ROOT . DS . 'application'  . DS . 'views' . DS . $this->database. DS .$this->view.'.php';
			if(file_exists($viewFile)){
				include($viewFile);
			}
		}
				
		
	}
	
	
?>