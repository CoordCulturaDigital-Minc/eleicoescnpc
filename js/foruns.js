(function($) {
    $(document).ready(function(e) {

        $('.show-candidate-details, .candidate-avatar').click(function() {
			var cid = $(this).data('candidate-id');
			$('#candidate-details-'+cid).toggle();
		});

		// fechar a lista ao clicar fora da área do mapa
        $(document).click(function(event) { 
            if(!$(event.target).closest('.show-candidate-details,  .candidate-avatar').length )
                $('.candidate-details').hide();
        }); 

		$('.vote').click(function() {

			var pid = $(this).data('project_id');

			if( $('a.vote').hasClass('voted') && !$(this).hasClass('voted') ) {
				 if( !confirm("Você está alterando o seu voto. Deseja continuar?"))
			        return false;			    
			}		

			$.post(
				vars.ajaxurl,
				{
					'action':'register_vote',
					'project_id': pid,
				},
				function(data) {
					if (data.success) {
						var voted_id = data.voted_project_id;
						$('a.vote').removeClass('voted').html('Votar');
						$('#vote-for-'+voted_id).addClass('voted').html('Voto registrado');
					} else {
						alert(data.errormsg);
					}
				},
				'json'
			);

		});

		 // store the slider in a local variable
		  var $window = $(window),
		      flexslider;
		 
		  // tiny helper function to add breakpoints
		  function getGridSize() {
		    return (window.innerWidth < 600) ? 1 : 
		    (window.innerWidth < 765) ? 2 : 
		    (window.innerWidth < 970) ? 3 : 4;
		  }
		 
		  $(function() {
		     //SyntaxHighlighter.all();
		  });
		 
		  $window.load(function() {
		    $('.candidates-content').flexslider({
		      	animation: "slide",
			 	controlsContainer: ".candidates-content .navigation",
			 	selector: ".candidates > .candidate",
			 	prevText: "",
			 	nextText: "",
				itemWidth: 200,
			 	useCSS: false,
			 	minItems: 1,
			 	maxItems: 4,
			    minItems: getGridSize(), // use function to pull in initial value
			    maxItems: getGridSize(), // use function to pull in initial value
			    start: function(slider){
					flexslider = slider;
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
