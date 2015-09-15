(function($) {
    $(document).ready(function(e) {
	// usado para filtros de relatorios
	
	var atualizaFiltro = function(action, uf, setorial) {
            var uf = uf || false,
		setorial = setorial || false,
                currentPage = window.location.href.split('?')[0],
		action = action || false;
	    
	    if (!action) { return false }
	    
	    if (uf !== false) {
                window.location.href = currentPage + '?page=' + action + '&uf=' + uf;
            }
	    if (setorial !== false) {
                window.location.href = currentPage + '?page=' + action + '&setorial=' + setorial;
	    }
        }
	
	$('.select-state').change(function() {
            atualizaFiltro(this.id, this.value, false);
        });
	$('.select-setorial').change(function() {
            atualizaFiltro(this.id, false, this.value);
        });	
    });
})(jQuery);
