(function($) {
    $(document).ready(function(e) {

    	$('#delete_account').click(function() {

			var text = '<p>Você realmente deseja apagar sua conta?'
			 		   +'<br>Todos seus dados serão apagados, inclusive seus votos!'
			 		   +'<br>Após concluir não será possível recuperar suas informações!</p>';

		
			$('<div class="dialogs"></div>').appendTo( $( "body" ) )
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
			          		$('#cnpc-loading').show();
			              	$(this).dialog("close");

			             	$.post(
							vars.ajaxurl,
							{
								'action':'current_user_delete_account',
								'nonce': vars.nonce,
							},
							function(data) {
								if (data.success) {
									alert("Usuário deletado com sucesso!")
									location.reload(true);
								} else {
									alert(data.errormsg);
								}

								$('#cnpc-loading').hide();
							},
							'json'
						);

			          }
			      },
			      close: function (event, ui) {
			          $(this).remove();
			      }
			});

			return false;
		});

    });
})(jQuery);