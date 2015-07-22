/**
 * 
 */
(function($) {
	$(document).ready(function(e) {
		
		// mapa nas páginas
	    $(".page #mapa .estado").click(function(e){

	        var state = $(this).find('path').attr('id');
	       	var $setoriais = $('.menu-setoriais-container');
	       	var s_height = $setoriais.height();
	       	var s_width = $setoriais.width();

	        $setoriais.hide(); 

	        $('#menu-setoriais li a').each(function(){
			   $(this).attr('href', $(this).attr('href').replace(/\/[\w]{2}-/, '/'+state+'-'));
			});

	        $setoriais.css({top:'50%', left:'50%', position: 'fixed', 'margin-top': -(s_height/2), 'margin-left': -(s_width/2) }).slideDown();

	        return false;
	    });

	    $('#login').click(function(e) {
	    	 $('.login-form-menu').show();
	    	 return false;
	    });

	    // fechar ao clicar fora da área do mapa
	    $(document).click(function(event) { 
	        if(!$(event.target).closest('path, .menu-setoriais-container, text').length )
	            $('.menu-setoriais-container').hide();

	        if(!$(event.target).closest('#login-menu').length )
	            $('.login-form-menu').hide();

	    }); 

	    // widget de login
	    // $('.widget_cnpc_login .widget-body').hide();
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