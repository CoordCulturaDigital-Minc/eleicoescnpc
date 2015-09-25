(function($) {
    $(document).ready(function(e) {
	// usado para filtros de relatorios
	
	var atualizaFiltro = function(action, uf, setorial) {
            var uf = uf || '',
		setorial = setorial || '',
                currentPage = window.location.href.split('?')[0],
		action = action || false;
	    console.log(action);
	    console.log(uf);
	    console.log(setorial);
	    if (!action) { return false }
	    
	    if (uf !== '' && setorial === '') {
		// somente uf
		console.log('somente uf');
                window.location.href = currentPage + '?page=' + action + '&uf=' + uf;
            } else if ((setorial !== '') && (uf === '')) {
		// somente setorial
		console.log('somente setorial');		
                window.location.href = currentPage + '?page=' + action + '&setorial=' + setorial;
	    } else if ((setorial !== '') && (uf !== '')) {
		// uf E setorial
		console.log('both');		
                window.location.href = currentPage + '?page=' + action + '&uf=' + uf + '&setorial=' + setorial;
	    } else {
		window.location.href = currentPage + '?page=' + action;
	    }
        }
	
	$('.select-state').change(function() {
            atualizaFiltro(this.id, this.value, false);
        });
	$('.select-setorial').change(function() {
            atualizaFiltro(this.id, false, this.value);
        });

	$('.filtrar_relatorio').click(function() {
	    atualizaFiltro(this.id, $('#filtrar_uf').val(), $('#filtrar_setorial').val());
	});
    });
})(jQuery);
