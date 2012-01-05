<!-- 
<?php header("Content-type: text/plain"); ?> 
-->

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
	

		<form method="get" action="./show">
			Query: <input type="text" size="50" maxlength="50" name="query" value='select * from proxies where country = "China"'> <br />
			<input type="submit" value="query">
		</form>	
		
		
	</body>
</html>

