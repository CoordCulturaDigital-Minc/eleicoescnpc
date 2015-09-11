(function($) {
    $(document).ready(function(e) {
	// usado para filtros de relatorios
	
	var atualizaFiltroUf = function(action, uf) {
            var uf = uf || false,
                currentPage = window.location.href.split('?')[0],
		action = action || false;
	    
	    if (!action) { return false }
	    
	    if (uf !== false) {
                window.location.href = currentPage + '?page=' + action + '&uf=' + uf;
            }
        }
	
	$('.select-state').change(function() {
            atualizaFiltroUf(this.id, this.value);
        });	
    });
})(jQuery);
