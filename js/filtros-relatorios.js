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
	
	$('#exportarCSV').click(function() {
	    var data_csv = $('#exportarCSV').attr('data_csv'),
		filename = $('#exportarCSV').attr('data_filename'),
		url = window.location.href,
		replace_str = '';
	    
	    if (url.search('wp-admin') > 0) {
		replace_str = 'wp-admin';
	    } else if (url.search('inscricoes') > 0) {
		replace_str = 'inscricoes';
	    }
	    url = window.location.href.split(replace_str)[0] + 'wp-content/themes/eleicoescnpc/relatorios/baixar-csv.php?filename=' + filename + '&data_csv=' + data_csv;
	    var iframe = $("<iframe/>").attr({
                    src: url,
                    style: "visibility:hidden;display:none"
		}).appendTo('#exportarCSV');		    
	});	
    });
})(jQuery);
