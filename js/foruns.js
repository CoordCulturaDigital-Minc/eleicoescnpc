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

			var text = '<p>Você realmente deseja votar neste candidato?</p>';

			//TODO se pode alterar voto, ativa
			if( $('a.vote').hasClass('voted') && !$(this).hasClass('voted') ) {
				text = 	'<p>Você está alterando o seu voto, deseja continuar?</p>'	    
			}

			$('<div class="dialogs"></div>').appendTo( $( ".candidates" ) )
			  .html('<div class="htl"><h3>Atenção</h3>'+text+'</div')
			  .dialog({
			      modal: true, title: '', zIndex: 10000, autoOpen: true, closeText: '<i class="fa fa-times close"></i>',
			      width: 'auto', resizable: false,
			      buttons: {
			          Não: function () {
			              $(this).dialog("close");
							return false;
			          },
			          Sim: function () {

			              	$(this).dialog("close");

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
									$('.candidate').removeClass('voted')
									$('.candidate#'+voted_id).addClass('voted');
								} else {
									alert(data.errormsg);
								}
							},
							'json'
						);

			          }
			      },
			      close: function (event, ui) {
			          $(this).remove();
			      }
			});
		});



		// carrosel na página do fórum 

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
				itemMargin: 5,
			 	useCSS: false,
			 	minItems: 1,
			 	maxItems: 4,
			    minItems: getGridSize(), // use function to pull in initial value
			    maxItems: getGridSize(), // use function to pull in initial value
			    start: function(slider){
					flexslider = slider;
					$('.candidates-content .loading').hide();
					$('.candidates-content .candidates').slideDown();

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
