<?php
	//// Connect to mysql database and return PDO handle
	function modelConnect($dbname = '', $user = 'root', $pass = '',$host = 'localhost'){
	//START DB connection try block
		try {
			// Connect to mysql database and return handle
		
			//// Set error mode to exception if development
			//		Silent - Default
			//		Warning - Standard issue PHP warning
			//		Exception - Allows handling of exceptions & graceful hiding of errors
			if (DEVELOPMENT_ENVIRONMENT === true) {
				$PDO_ERR = PDO::ERRMODE_EXCEPTION;
			}
			elseif(DEVELOPMENT_ENVIRONMENT === false) {
				$PDO_ERR = PDO::ERRMODE_SILENT;
			}
			else{
				$PDO_ERR = PDO::ERRMODE_EXCEPTION;
			}
			$dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
			$dbh->setAttribute( PDO::ATTR_ERRMODE, $PDO_ERR);

	    	//echo "Connection to $dbname successful <br />";
	    }
		catch(PDOException $e) {
			if (DEVELOPMENT_ENVIRONMENT === true) {
		    	echo "Connection to $dbname failed <br />";
	    		echo $e->getMessage();
	    	}
	    }
	//END DB connection try block
		//Return $dbh if exists or false if error
		if (!empty($dbh)){
			return $dbh;
		}
	}
?>