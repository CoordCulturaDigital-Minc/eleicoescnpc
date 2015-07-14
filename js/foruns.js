(function($) {
    $(document).ready(function(e) {

        $('.show-candidate-details').click(function() {
			var cid = $(this).data('candidate-id');
			$('#candidate-details-'+cid).toggle();
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
		
		// fechar a lista ao clicar fora da área do mapa
        $(document).click(function(event) { 
            if(!$(event.target).closest('.show-candidate-details').length )
                $('.candidate-details').hide();
        }); 


		//slide
		 $('.candidates-content').flexslider({
			 
		 	animation: "slide",
		 	controlsContainer: ".candidates-content .navigation",
		 	selector: ".candidates > .candidate",
		 	prevText: "",
		 	nextText: "",
		 	direction:"horizontal",
			itemWidth: "250",
		 	randomize: true,
		 	 useCSS: false,
		 	minItems: 4,
		 	maxItems: 1,
		 	// namespace: ""
		 });

    });
})(jQuery);
