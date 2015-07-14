/**
 * 
 */
(function($) {
	$(document).ready(function(e) {
		
		// mapa nas páginas
	    $(".page #mapa .estado").click(function(e){

	        var state = $(this).find('path').attr('id');
	       
	        $('.menu-setoriais-container').hide(); 

	        $('#menu-setoriais li a').each(function(){
			   $(this).attr('href', $(this).attr('href').replace(/\/[\w]{2}-/, '/'+state+'-'));
			});

	        $(".menu-setoriais-container").css({top:'10%', left:'45%', position: 'fixed'}).slideDown();

	        return false;
	    });

	    // fechar a lista ao clicar fora da área do mapa
	    $(document).click(function(event) { 
	        if(!$(event.target).closest('path, .menu-setoriais-container, text').length )
	            $('.menu-setoriais-container').hide();
	    }); 

	    // widget de login
	    $('.widget_cnpc_login .widget-body').hide();
	    $('.widget_cnpc_login .widget__title').click( function(e) {
	    	$('.widget_cnpc_login .widget-body').slideToggle();
	    });

	   $('#mapa a.estado').each(function(){
	   		var term_link	= $('#term_link').attr('href');
	   		var estado 		= $(this).find('path').attr('id');
		 	var setorial 	= $('.content article').attr('id');
			 
			$(this).attr('xlink:href', term_link + '/foruns/' + estado + '-' + setorial );
		});
	
	});
})(jQuery);