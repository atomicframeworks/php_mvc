<?php
	//// Class model base to hold and represent MySQL database connection
	class Model {
		public $model;

		public $host = 'localhost';
		
		public $statementArray = array ();
		
		//// Contstruction
		public function __construct($args = array ()) {
			if (!empty($args)){
				foreach ($args as $key=>$item){
					$this->$key = $item;
				}
			}
			// Connect to DB and get PDO handle
			$this->model = modelConnect($this->database,$this->username,$this->password,$this->host);		
		}

		//// Execute all statements in statementArray
		public function invoke(){
			// Loop statements and execute
			foreach ($this->statementArray as $statement){
				try {
  					$statement->execute();
  				}
  				catch(PDOException $e) {
					// Rollback changes to database on fail 
					try {
						$this->model->rollback();
					}
					catch(PDOException $ee) {
						//echo $e->getMessage();
					}
				    echo $e->getMessage();
				}
			}
		}
			
		//// Prepare & add statement string to object statement array
		public function addStatement($statement = ''){
			if (!empty($statement)){
				$statement = new modelStatement($statement);
			}
			// Prepare the statement
			try {
				$preparedStatement = $this->model->prepare($statement);
				// Add to models statement array
				array_push($this->statementArray, $preparedStatement);
	  		}
	  		catch(PDOException $e) {
				echo $e->getMessage();
			}
			return $this;
		}
		
		//// Fetch all results from statements. Push each result to array and return
		public function fetchAll($fetchStyle = PDO::FETCH_CLASS){
			$return = array ();

			if (!empty($this->statementArray)){
				foreach ($this->statementArray as $statement){
					try {
						$statementData = $statement->fetchAll($fetchStyle);
						$statementString = $statement->queryString;
						$returnArray = array ('data'=>$statementData,'statement'=>$statementString);
	  					array_push($return, $retAr);
	  				}
	  				catch(PDOException $e) {
						// Rollback changes to database on fail 
						$this->model->rollback();
					    echo $e->getMessage();
					}
				}
			}
			return $return;
		}
		
		//// Start a transaction with the DB
		public function beginTransaction(){	
			try {
				$this->model->beginTransaction();
  			}
			catch(PDOException $e) {
			    echo $e->getMessage();
			}
			
			return $this;
		}
		
		//// Commit our statements / transactions
		public function commitTransaction(){
			try {
				$this->model->commit();
  			}
			catch(PDOException $e) {
			    echo $e->getMessage();
			}
			return $this;
		}
	}
	
?>