<?php
	$header = 'HTTP/1.0 404 Not Found';
	header($header);
	$header = 'Status: 404 Not Found';
	header($header);
	//print_r(get_defined_vars());
?>
<html>
	<body>
		<style>
		</style>

		<h2>
			ERROR 404: Not Found
		</h2>
		The requested url <?php echo $_SERVER['REQUEST_URI']; ?> was not found on this server.
	</body>
</html>



<?php die;?>