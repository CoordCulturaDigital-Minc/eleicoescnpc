(function($) {
    $(document).ready(function(e) {

    	var setorial_uf_change = false;

    	$('#setorial, #uf' ).change(function(e) {
    		setorial_uf_change = true;
    	});

    	$("#your-profile #submit").click(function() {

    		if( setorial_uf_change ) {
	    		// verifica se o candidato tem voto
	    		var candidate_was_voted = $('#candidate_was_voted').val();

	    		if( candidate_was_voted == "true" ) {
	    			var c = confirm("Candidato, se você alterar o seu estado ou setorial os seus votos serão apagados. \n\nEsta ação não pode ser desfeita.\n\n Deseja Continuar?");
	    		}else {
	    			var c = confirm("Você está alterando sua setorial e/ou estado! \n\n Esta ação não pode ser desfeita! \n\n Deseja continuar?");
	    		}

	    		return c
	    		
	    	}
			   
		});

    });
})(jQuery);