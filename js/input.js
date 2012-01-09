$(document).ready(function() {

	// Set input box to clear and focus 
	$(".inputBox").click(function (){$(this).val('');$(this).focus();});
	// Set input box to reset if empty on blur
	$(".inputBox").blur(function (){ if ($(this).val() === ''){$(this).val('Enter Email');}});
	
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