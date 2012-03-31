<?php
	// Regex routes
	$routes = array(
		'/admin\/(.*?)\/(.*)/' => 'admin/\1_\2/\3',
		'/robots.txt(.*)/' => 'headers/robots'
	);
	
	// /admin/controller/extra/something 
	// will become
	// admin/controller_extra/something/
	
	// /robots.txt 
	//  will become
	// headers/robots