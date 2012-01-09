	$(document).ready(function() {
		// New array to hold preloaded images
		var imageSrcArray = [];
		
		// Populate image array
		// Foreach element in list -- push img reference to imageSrcArray
		$(".active").parent().children().each(
    		function(){
       			 //access to form element via $(this)
       			 var src = $(this).attr("data-imgref");
       			 imageSrcArray.push(src);
   			 }
		);
		// Preload image our populated image array
		preload(imageSrcArray);
		
		// Replace imgref attr with our preloaded image array [index]
		$(".active").parent().children().each(
    		function(index){
       			 //access to form element via $(this)
       			 //console.log(imageSrcArray[index]);
       			 $(this).attr("data-imgref",imageSrcArray[index]);
   			 }
		);
		
		$activeElement = $(".active");
			$("li").click( function(){
				clickDot(this);
			});
			// Start slideShow
			loopShow($activeElement);
	});
	
	// Time before initiating next slide click
	var waitTime = 7000;
	
	// Time to complete fade
	var fadeTime = 333;

	var next;
	function loopShow(eleIn){
		//console.log('Starting loop: '+eleIn);
		setTimeout(function (){loop(eleIn.next())},waitTime);
	}
	
	// Recursive Loop Function -
		// Trigger click on next element. Set new next element. Loop.
	function loop(eleIn){
		//console.log('Continue loop: '+eleIn);
		eleIn.trigger('click');
		next = eleIn.next();
		
		// Check if last element
		if (next.length == 0){
			// Get the first element of our parent container
			next = $(".active").parent().children(":first");
			//console.log('End of elements. Setting to first.');
		}
		// Continue loop
		setTimeout(function (){loop(next)},waitTime);
	}
	
	// slideShow Nav - li - Click event function
	function clickDot(clickEleIn){
		// Wrap clicked element
		eleIn = $(clickEleIn);
		
		// Check if clicking already active 
		if (eleIn.attr("class") === 'active'){
			return;
		}
			
		// Set next in loop
		next = eleIn.next();
		if (next.length == 0){
			// Get the first element of our parent container
			next = $(".active").parent().children(":first");
			//console.log('End of elements. Setting next element to first in sequence.');
		}
		
		// Deactivate current
		$('.active').attr("class", "");
		// Activate new
		eleIn.attr("class", "active");
		
		// Fade out current
		$(".slideShow").fadeOut(fadeTime, 'swing',  function() {
	    	// Swap img src
	    	$(".slideShow").attr("src",eleIn.attr("data-imgref"));
			// Fade in new
			$(".slideShow").fadeIn(fadeTime, 'swing', function() {
		  	});
	
	  	});
	}
	
	function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
    });
}