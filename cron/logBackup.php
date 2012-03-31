<?php

	define('DS', DIRECTORY_SEPARATOR);
	// Double dirname to go back 2 levels
	define('ROOT',dirname(dirname(__FILE__)));

	// Glob & require everything in tmp logs folder that ends in .log
	$pattern = ROOT . DS . 'tmp'. DS .'logs'. DS . '*.log';
	
	$files = glob($pattern);
	
	$dateTime = date('M_d_Y');
	$backupDir = 'backup';
	$fileNameSplitter = '.';
	
	// loop logs
	foreach($files as $filename){
		
		// Explode full file name to get last part
		$fileArray = explode('/',$filename);

		// split file name by the splitter (a . )
		$fileSplit =  explode($fileNameSplitter,array_pop($fileArray));

		$fileBackupName = $backupDir.DS.$fileSplit[0].'_'.$dateTime.'.'.$fileSplit[1];
		// Create new array for backup filename
		$backupFileArray = $fileArray;
		
		// Implode the filename back together
		array_push($fileArray,implode($fileNameSplitter,$fileSplit));
		$filename = implode('/',$fileArray);
		// Implode the backup name together
		array_push($backupFileArray,$fileBackupName);
		$backupName = implode('/',$backupFileArray);
		
		try{
			echo "Backing up $filename ...<br/>";

			copy($filename, $backupName);
			// Clear log file
			$fh = fopen($filename, 'w');
			fclose($fh);
			// Remove and create fresh log file
			//echo unlink($filename);
			//file_put_contents($filename,'');
		}
		catch (Exception $e) {
			echo "Error...<br/>";
            echo $e->getMessage();
        }
	};
	