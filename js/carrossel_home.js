(function($) {
    $(document).ready(function(e) {
	/********* carrosel na home ********/ 
	
	// store the slider in a local variable
	var $window = $(window),
	    flexslider;
	
	// tiny helper function to add breakpoints
	function getGridSize() {
	    return (window.innerWidth < 600) ? 1 : 
		(window.innerWidth < 765) ? 2 : 
		(window.innerWidth < 970) ? 3 : 4;
	}
	
	$window.load(function() {
	    $('.destaques-content').flexslider({
		animation: "slide",
	 	selector: ".destaques > .destaque",		
		slideshow: true,	
		slideshowSpeed: 7000,
		prevText: "",
		nextText: "",
		useCSS: false,
		minItems: 1,
		maxItems: 4,
		start: function(slider){
		    flexslider = slider;
		    $('.destaques-content .loading').hide();		    
		    $('.destaques-content .destaques').slideDown();
		    
		}
	    });
	});
	
	// check grid size on resize event
	$window.resize(function() {
	    var gridSize = getGridSize();
	    
	    flexslider.vars.minItems = gridSize;
	    flexslider.vars.maxItems = gridSize;
	});	
    });
})(jQuery);		    
