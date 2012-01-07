<?php
	$header = 'HTTP/1.0 404 Not Found';
	header($header);
	$header = 'Status: 404 Not Found';
	header($header);
	//print_r(get_defined_vars());
?>

ERROR: 404 <br/>

<?php echo $_SERVER['REQUEST_URI']; ?> -- Not Found!

<?php die;?>