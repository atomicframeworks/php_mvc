<?php
	$header = 'HTTP/1.0 404 Not Found';
	header($header);
	$header = 'Status: 404 Not Found';
	header($header);
	$tTime = '1.5s';
	$transition = 'ease-in-out';
?>
<html>
	<head>
		<?php include_once(JQUERY); ?>
	
	</head>
	<body>
		<style>	
		/* font */
		@font-face {font-family: 'HelveticaNeue-Light'; src: url('<?php echo ASSET_TTF; ?>HelveticaNeue-Light.otf'); }


		body {
			text-align: center;
			color: #737CA1;
			font-family: 'HelveticaNeue-Light', 'Helvetica Neue', Helvetica, arial, sans-serif;
		}
		
		body h2 {
			margin-bottom: 5px;
			font-size: 36px;
		}
		
		body {
			background: url("<?php echo ASSET_IMG; ?>paper2.jpg");
			-moz-background-size:100% 100%; /* Firefox 3.6 */
			background-size:100% 100%;
			background-repeat:no-repeat;
		}
		
		#floater	{float:left; height:50%; margin-bottom:-120px;}
		#content	{clear:both; height:240px; position:relative;}
		/* Faded out */		
		.fade {
			-webkit-transition: opacity <?php echo $transition . ' ' . $tTime ?>;
			-moz-transition: opacity <?php echo $transition . ' ' . $tTime ?>;
		 	-o-transition: opacity <?php echo $transition . ' ' . $tTime ?>;
		 	transition: opacity <?php echo $transition . ' ' . $tTime ?>;
		 	opacity: 0;
		}
		/* Used to horizontally align table */
		.outside {
			display: table;
			height: 100%; 
			overflow: hidden;
			text-align:center;
			#position: relative; 

		}
		/* Used to vertically align table */
		 .outside .inside {
		 	display: table-cell;
		 	vertical-align: middle;
		 }
		 

		form input {
			font-family: 'HelveticaNeue-Light', 'Helvetica Neue', Helvetica, arial, sans-serif;

		    /* Set all inputs to same height */
			height: 40px;
		    
		    /* Text */
		    font-weight: bold;
		
			/* Borders */
			border-radius: 10px;
			border: 2px solid #00aeef;
		}
		/* Button class of our inputs */
		form input.button {
			/* Text */
			text-transform: uppercase;
			font-size: 14px;
			color: #ffffff;
			/* Borders */
			border: 2px solid #00aeef;
			background-color: #00aeef;
			padding: 0px 18px 0px 20px;
			/* Gradient for Submit button in form*/
			/* 100% black to 100% white 25% opacity */
			background-color: #00aeef;
			background-image: -moz-linear-gradient(top, rgba(255,255,255,0.25) 0%, rgba(0,0,0,0.25) 100%); /* FF3.6+ */
			background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.25)), color-stop(100%,rgba(0,0,0,0.25))); /* Chrome,Safari4+ */
			background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.25) 0%,rgba(0,0,0,0.25) 100%); /* Chrome10+,Safari5.1+ */
			background-image: -o-linear-gradient(top, rgba(255,255,255,0.25) 0%,rgba(0,0,0,0.25) 100%); /* Opera 11.10+ */
			background-image: -ms-linear-gradient(top, rgba(255,255,255,0.25) 0%,rgba(0,0,0,0.25) 100%); /* IE10+ */
			background-image: linear-gradient(top, rgba(255,255,255,0.25) 0%,rgba(0,0,0,0.25) 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff00aeef', endColorstr='#ff0082b3',GradientType=0 ); /* IE6-9 */
		}
		
		/* Pressed submit button in .footer form */
		form input.button.pressed {
			border: 2px solid #0089d0;
			background-color: #0089d0;
		}
		
		</style>
		<center>
		<div class="outside" style="">
    		<div class="inside">
      			<div class="container" style="">
		      		<div class="fade one">
						<h2>
						<img src="<?php echo ASSET_IMG; ?>404_img_24.png" />
							<br />
							Sorry!
						</h2>
					</div>
					<div class="fade two">
						The requested url <?php //echo $_SERVER['REQUEST_URI']; ?> was not found on this server<?php //echo ' '.$_SERVER['SERVER_NAME']; ?>.
						<br/>
						Contact Kevin for access.
						<br/>
						<br/>
						<form action="http://<?php echo $_SERVER['SERVER_NAME']; ?>" method="post">
							<input type="submit" name="submit" value="Home" class="button" />
						</form>
					</div>
   
      			</div>
   	 		</div>
  		</div>
		
		</center>

		<script type="text/javascript">

			$(document).ready(function() {
				// Fade in items in order
				$('.one').css('opacity',1).delay(800).queue(function() {
            		$('.two').css('opacity', 1);
          		});
				
				
				// Toggle pressed button class on mouse down & up
				$(".button").bind('mousedown mouseup',
					function (){
						$(this).toggleClass('pressed');
					}
				);
			
				// Remove pressed button class on mouse leave
				$(".button").bind('mouseleave',
					function (){
						$(this).removeClass('pressed');
					}
				);
			});
			
		</script>
		<img src="http://www.atomicframework.com/cm/?img=error404" style='display:none;' alt='' />
		
	</body>
</html>
<?php 
// Kill php to prevent anything else from executing
die;
?>