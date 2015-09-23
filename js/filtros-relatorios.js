(function($) {
    $(document).ready(function(e) {
	// usado para filtros de relatorios
	
	var atualizaFiltro = function(action, uf, setorial) {
            var uf = uf || false,
		setorial = setorial || false,
                currentPage = window.location.href.split('?')[0],
		action = action || false;

	    if (!action) { return false }

	    if (uf !== false && setorial === false) {
		// somente uf
                window.location.href = currentPage + '?page=' + action + '&uf=' + uf;
            } else if (setorial !== false && uf === false) {
		// somente setorial	
                window.location.href = currentPage + '?page=' + action + '&setorial=' + setorial;
	    } else if (setorial !== false && uf !== false) {
		// uf E setorial
                window.location.href = currentPage + '?page=' + action + '&uf=' + uf + '&setorial=' + setorial;
	    }
        }
	
	$('.select-state').change(function() {
            atualizaFiltro(this.id, this.value, false);
        });
	$('.select-setorial').change(function() {
            atualizaFiltro(this.id, false, this.value);
        });
	$('#listagem_votos_auditoria').click(function() {
            atualizaFiltro(this.id, $('#uf_listagem_votos_auditoria').val(), $('#setorial_listagem_votos_auditoria').val());
	});
    });
})(jQuery);
