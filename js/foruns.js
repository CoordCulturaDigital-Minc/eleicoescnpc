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

			$.post(
				vars.ajaxurl,
				{
					'action':'register_vote',
					'project_id': pid,
				},
				function(data) {
					if (data.success) {
						var voted_id = data.voted_project_id;
						$('a.vote').html('Votar');
						$('#vote-for-'+voted_id).html('Voto registrado');
					} else {
						alert(data.errormsg);
					}
				},
				'json'
			);

		});
		
		//slide
	    $('.candidates-content').flexslider({
				 
		 	animation: "slide",
		 	controlsContainer: ".candidates-content .navigation",
		 	selector: ".candidates > .candidate",
		 	prevText: "",
		 	nextText: "",
			itemWidth: "200",
		 	useCSS: false,
		 	minItems: 4,
		 	maxItems: 5
		 });
    });
})(jQuery);
