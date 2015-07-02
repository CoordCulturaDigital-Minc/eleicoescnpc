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
        
    });
})(jQuery);
