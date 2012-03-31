<?php
	//// Class to connect to a model and store data
	class Controller {
		protected $_model;
		public $_view;
		
		
		public function __construct($args) {
			// Create new model for the controller
			$modelClass = '';
			$baseModel = 'model';
			if (!empty($args['model'])){
				$modelClass = $args['model'];
				// Uppercase model to add as suffix to model
				//ucfirst($baseModel);
			}			
			$modelClass .= $baseModel;
			if(class_exists($modelClass)){
				$this->_model = new $modelClass($args);
			}
			// Load base model if we didn't load our modelClass
			if (empty($this->_model)){
				$this->_model = new $baseModel($args);
			}
			// Create properties for self after checking model
			if (!empty($args)){
				foreach ($args as $key=>$item){
					$this->$key = $item;
				}
			}
			$this->_view = new View($args);
		}

		//// To String
		public function __toString() {
			return (string) get_class($this);
		}
				
		//// Pass statement to model for a new ModelStatement
		public function addStatement($statement){
			$this->_model->addStatement($statement);
			return $this;
		}
		
		//// Standard prepare for model pdo
		public function prepare($statement){
			$this->_model->prepare($statement);
			return $this;
		}
		
		//// Standard bindParam for model pdo
		public function bindParams($params){
			$this->_model->bindParams($params);
			return $this;
		}
		
		//// Clear the model
		public function clear(){
			$this->_model->clear();
			return $this;
		}
		
		// Set variables
		function set($name,$value) {
			$this->_view->set($name,$value);
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
			//$this->data = $this->_model->invoke();
			$this->set('data',$this->_model->invoke());
			return $this;
		}
		
		// Execute transaction statements to model's PDO MySQL connection. (same as invoke)
		public function executeStatements(){
			$this->_model->executeStatements();
			return $this;
		}

		
		//// Fetch all results from executed statements
		public function fetchAll($fetchStyle = PDO::FETCH_CLASS){
			//$this->data = $this->_model->fetchAll($fetchStyle);
			$this->set('data',$this->_model->fetchAll($fetchStyle));
			return $this;
		}
		
		
		// Begin transaction with model's PDO MySQL connection. Statements execute only on commit.
		public function beginTransaction(){
			$this->_model->beginTransaction();
			return $this;
		}
		
		// Commit transaction to model's PDO MySQL connection.
		public function commitTransaction(){
			$this->_model->commitTransaction();
			return $this;
		}
		
		public function render(){
			// Render template
			$this->_view->render();
		}
	}
