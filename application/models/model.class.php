<?php
	//// Class model base to hold and represent MySQL database connection
	class Model {
		public $pdo;

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
			if (!empty($this->database)){
				$this->pdo = $this->connect($this->database,$this->username,$this->password,$this->host);		
			}
			// If pdo is empty try the default controller for database
			if(empty($this->pdo)){
				$this->pdo = $this->connect(DEFAULT_CONTROLLER,$this->username,$this->password,$this->host);		
			}
		}

		//// To String
		public function __toString() {
			return (string) get_class($this);
		}
			
		//// Execute all statements in statementArray
		public function invoke(){
			//implode(';',$this->statementArray);
			// Loop statements and execute
			foreach ($this->statementArray as $statement){
				try {
  					$statement->execute();
  				}
  				catch(PDOException $e) {
					// Rollback changes to database on fail 
					try {
						$this->pdo->rollback();
					}
					catch(PDOException $ee) {
						//echo $ee->getMessage();
					}
					ErrorReporter::throwError($e->getMessage(),'warning');
				}
			}
			return $this->statementArray;
		}
		
		//// Execute all statements in statementArray - :: SAME AS INVOKE ::
		public function executeStatements(){
			$this->invoke();
		}
		
		//// Clear the Statement array
		public function clear(){
			$this->statementArray = array();
			return $this;
		}
			
		//// Prepare & add statement string to object statement array
		public function addStatement($statement = ''){
			if (!empty($statement)){
				$statement = new modelStatement($statement);
			}
			// Make sure we have a db object
			if($this->pdo){
				// Prepare the statement
				try {
					//print_r($this);
					$preparedStatement = $this->pdo->prepare($statement);
					// Add to models statement array
					array_push($this->statementArray, $preparedStatement);
		  		}
		  		catch(PDOException $e) {
					echo $e->getMessage();
					echo '<br/>';
				}
			}
			else{
				ErrorReporter::throwError( "No PHP database object using Database: {$this->database}",'warning');
			}	
			return $this;
		}
		
		//// Standard prepare
		public function prepare($statement){
			// Make sure we have a db object
			if($this->pdo){
				// Prepare the statement
				try {
					$preparedStatement = $this->pdo->prepare($statement);
					// Add to models statement array
					array_push($this->statementArray, $preparedStatement);
		  		}
		  		catch(PDOException $e) {
					echo $e->getMessage();
					echo '<br/>';
				}
			}
			else{
				ErrorReporter::throwError( "No PHP database object using Database: {$this->database}",'warning');
			}	
			return $this;
		}
		
		// Bind array of params to the most recent of statements in model statementArray
		public function bindParams($params){
			if(is_array($params)){
				// Get last item in array and bind params
				$lastStatement = end($this->statementArray);
				// Loop params and bind
				foreach($params as $param=>$var){
					//echo 'Bind '.$param.' -> '.$var.' <br/>';
					//  ::WARNING :: ->bindParam($param, $var)
					// Unlike PDOStatement::bindValue(), the variable is bound as a reference and will only be evaluated at the time that PDOStatement::execute() is called.
					$lastStatement->bindValue($param, $var);
				}
				// Reset the statementArray to start
				//reset($this->statementArray);
			}
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
	  					array_push($return, $returnArray);
	  				}
	  				catch(PDOException $e) {
						// Rollback changes to database on fail 
						
						try { 
							$this->pdo->beginTransaction();
							$this->pdo->rollback();
						}
						catch (PDOException $ex) {
    						//print "Transaction is running (because trying another one failed)\n";
    						//echo meaning we can rollback safely
    						$this->pdo->rollback();
						}
						ErrorReporter::throwError($e->getMessage(),'warning');
					}
				}
			}
			return $return;
		}
		
		//// Start a transaction with the DB
		public function beginTransaction(){	
			try {
				$this->pdo->beginTransaction();
  			}
			catch(PDOException $e) {
			    ErrorReporter::throwError($e->getMessage(),'warning');
			}
			
			return $this;
		}
		
		//// Commit our statements / transactions
		public function commitTransaction(){
			try {
				$this->pdo->commit();
  			}
			catch(PDOException $e) {
				ErrorReporter::throwError($e->getMessage(),'warning');
			}
			return $this;
		}
	
	
		//// Connect to mysql database and return PDO handle
		private function connect($dbname = '', $user = 'root', $pass = '',$host = 'localhost'){
		//START DB connection try block
			try {
				// Connect to mysql database and return handle
			
				//// Set error mode to exception if development
				//		Silent - Default
				//		Warning - Standard issue PHP warning
				//		Exception - Allows handling of exceptions & graceful hiding of errors
				
				//// PDO ATTR - persistant
				// 		Persistent connections are not closed at the end of the script, but are cached and re-used when another script requests a connection using the same credentials.
				// 		The persistent connection cache allows you to avoid the overhead of establishing a new connection every time a script needs to talk to a database
				// 		resulting in a faster web application.
				
				if (DEVELOPMENT_ENVIRONMENT === true) {
					$PDO_ERR = PDO::ERRMODE_EXCEPTION;
				}
				elseif(DEVELOPMENT_ENVIRONMENT === false) {
					$PDO_ERR = PDO::ERRMODE_SILENT;
				}
				else{
					$PDO_ERR = PDO::ERRMODE_EXCEPTION;
				}
				$dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, array (
					 PDO::ATTR_PERSISTENT => false
				));
				$dbh->setAttribute( PDO::ATTR_ERRMODE, $PDO_ERR);
	
		    	//echo "Connection to $dbname successful <br />";
		    }
			catch(PDOException $e) {
				if (DEVELOPMENT_ENVIRONMENT === true) {
					ErrorReporter::throwError('Connection to $dbname failed ' . $e->getMessage(),'warning');
		    	}
		    }
		//END DB connection try block
			//Return $dbh if exists or false if error
			if (!empty($dbh)){
				return $dbh;
			}
		}
	
	}
	
?>