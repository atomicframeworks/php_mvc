<?php
	// Glob & require everything in library folder that ends in .class.php	
	foreach(glob(ROOT . DS . "library/*.class.php") as $filename){
		require_once($filename);
	};