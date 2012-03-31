<?php
	$header = 'Content-type: text/plain';
	header($header);
?>
<?php
	// Can add logic here to serve different .txts to different robots
	include_once(PUBLIC_ROOT . DS . 'robots/robots.txt');
?>