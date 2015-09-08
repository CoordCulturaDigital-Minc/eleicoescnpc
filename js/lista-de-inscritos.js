(function($){
	$(document).ready(function(e) {
		//table sorter
		jQuery( ".js-sortable-table" ).tablesorter();

		$("td.cancel-subscription").css('cursor','pointer').click(function(e){
			var pid = this.id.replace(/^[^0-9]+/,'');
			var $row = $(this).parent();

			if(confirm("Você realmente deseja reabrir esta inscrição?\n\nO projeto será removido desta lista e o proponente poderá voltar a editá-lo")) {
				$.post(inscricoes.ajaxurl,{'action':'cancel_subscription', 'pid':pid},function(data) {
					if(data) {
						$row.remove();
					}
				});
		   }
		});

		$( '.js-finder' ).keyup(function(e) {
			var filtro = $(this).val();
			$('.subscription__cpf').each(function() {
				if ($(this).html().match( new RegExp(filtro ))) {
					$(this).parents('tr').show();
				} else {
					$(this).parents('tr').hide();
				}
			});
		});
	});
})(jQuery);
