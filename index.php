<?php


	//// Globals
	global $controller;
	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', dirname(__FILE__));
	
		
	//// Load up our bootstrap (which loads config & shared files)
	require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');
	
	
	//$queryArray = array ('select_str'=>'*','as_str'=>'','from_str'=>'proxies','where_str'=>'','group_str'=>'','having_str'=>'','order_str'=>'');
	
	//$selectQuery = new DBStatement($queryArray);
	
	
	
	$inetUSA = array ('select_str'=>'INET_NTOA(ip)','as_str'=>'ip','from_str'=>'proxies','where_str'=>'country = "United States"','group_str'=>'','having_str'=>'','order_str'=>'port');
	



	$select_all = array ('select_str'=>'INET_NTOA(ip) , id','as_str'=>'ip , row_id','from_str'=>'proxies','where_str'=>'country = "Egypt"','group_str'=>'','having_str'=>'','order_str'=>'port');

	//// Most basic query SELECT * from
	//$selectStar = new modelStatement(array ('from_str'=>'proxies'));
	
	
	//// Either construct the DBStatement, pass a  query array, or use string
	//$return = $controller->addStatement($selectStar)->invoke()->fetchAll();
	//$return = $controller->addStatement('SELECT * FROM proxies')->invoke()->fetchAll();
	
	//print_r($controller);	
	
	//// Add a statement to $controller
	//$controller->addStatement($select_all);
	
	//// Execute statements
	//$controller->invoke();
	
	//// Fetch results
	//$controller->fetchAll();
	
	//$controller->getView();
	
	
	//// Loop Results
	/*
	
	echo 'Statements run: '.count($statementReturn).'<br/>';
	
	foreach ($statementReturn as $index=>$results){
		$pdoStatementObject = ($controller->model->statementArray[$index]);
		$statement = $pdoStatementObject->queryString;
		echo "Statement: $statement <br/>";
		echo 'Results: '.count($results).'<br/>';
	}
	
	print_r($statementReturn);
	
	*/
	
