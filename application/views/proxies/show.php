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
	
		<!-- 
		<?php //print_r(get_defined_vars()); ?>
		-->

		<?php
			echo 'Queries: '.count($data).' <br/>';
			foreach($data as $index=>$queryReturn){
					echo "#: {$index} <br />";
					echo "Statement: ".$queryReturn['statement']." <br />"; 
					echo "Results: ".count($queryReturn['data'])."<br />"; 
					echo '<table id="data-table" border="1" width="100%" cellpadding="10" cellspacing="2" summary="" >';
					echo '<caption>Proxy Table</caption>';
					
					//// Table key header
					echo '<tr>';
					foreach($queryReturn['data'][0] as $key=>$something){
						echo ' <td> '.$key.' </td> ';
					};
					echo '</tr>';
					
					//// Row of data
					foreach($queryReturn['data'] as $something){
						//// Loop through properties each column
						foreach($something as $property){
							echo ' <td> '.$property.' </td> ';
						};
						echo '</tr>';
					};
					
					echo '</table>';
				}
	
		?>
		
		
	</body>
</html>

