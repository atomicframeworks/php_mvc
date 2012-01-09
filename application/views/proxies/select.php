<?php
	//print_r(get_defined_vars());
	//echo $controller->database . DS . $controller->view;
?>
<html>
	<body>
	
		<style>
		
		/* Every Other */
		#data-table tr:nth-child(2n+0){
			background-color:rgb(237, 236, 999);
		}
		#data-table tr:nth-child(2n-1){
			background-color:#CCCCFF;
		}
		/* Top row */
		#data-table tr:nth-child(+1){
			background-color:rgb(237, 236, 236);
		}
		</style>
		<form method="get" action="<?php echo ASSET_HOST . DS . 'mvc' . DS . $controller->database . DS ;?>show">
			Query: <input type="text" size="100" maxlength="100" name="query" value='select INET_NTOA(ip) as ip, id, port, http_code, last_update from proxies where country = "China"'> <br />
			<input type="submit" value="query">
		</form>	
		
		
	</body>
</html>

