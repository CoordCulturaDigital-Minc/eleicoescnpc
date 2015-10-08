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

			var pid  = $(this).data('project_id');
			var text = '';

			text = '<p>Você realmente deseja votar neste candidato?</p>';
			
			// se já votou
			if( $('a.vote').hasClass('voted') )
				text = '<p>Tem certeza que deseja mudar seu voto?</p>';

			// se o botao de votar for de um candidato já votado
			if( $(this).hasClass('voted') )
				return false;

			$.post(
				vars.ajaxurl,
				{
					'action':'register_vote',
					'project_id': pid,
				},
				function(data) {
					if (data.success) {
						text += '<p>' + data.msg + '</p>';

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
											'confirms_vote': true, 
										},
										function(data) {
											if (data.success) {
												var voted_id = data.voted_project_id;
												$('a.vote').removeClass('voted').html('Votar');
												$('#vote-for-'+voted_id).addClass('voted').html('Voto registrado');
												$('.candidate').removeClass('voted')
												$('.candidate#'+voted_id).addClass('voted');
												show_message('Voto registrado com sucesso!')
											} else {
												show_message(data.msg, 'erro');
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

					} else {
						show_message(data.msg, 'erro');
					}
				},
				'json'
			);
		
		});


		function show_message( text, type) {

			$('<div class="dialogs '+type+'" ></div>').appendTo( $( ".candidates" ) )
			  .html('<div class="htl"><h3>Atenção</h3><p>'+text+'</p></div')
			  .dialog({
			      modal: true, title: '', zIndex: 10000, autoOpen: true, closeText: '<i class="fa fa-times close"></i>',
			      width: 'auto', resizable: false,
			      buttons: {
			          Fechar: function () {
			              $(this).dialog("close");
							return false;
			          }
			      },
			      close: function (event, ui) {
			          $(this).remove();
			      }
			});
		}


		function parseDate(str) {
		  var m = str.match(/^(\d{4})-(\d{2})-(\d{2})$/);
		  return m[3]+"/"+m[2];
		}

		/********* carrosel na página do fórum ********/ 

		// store the slider in a local variable
		var $window = $(window),
		  flexslider;

		// tiny helper function to add breakpoints
		function getGridSize() {
			return (window.innerWidth < 650) ? 1 : 
			(window.innerWidth < 865) ? 2 : 
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
				itemWidth: 245,
				itemMargin: 7,
			 	useCSS: false,
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
