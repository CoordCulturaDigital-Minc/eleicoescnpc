/**
 * 
 */
(function($) {
	$(document).ready(function(e) {
	// jQuery('#video-list a').click(function(){
	// 	if(jQuery(document).data('open-video'))
	// 		jQuery(document).data('open-video').removeClass('selected');
		
	// 	jQuery(document).data('open-video', jQuery(this));
		
	// 	jQuery(document).data('open-video').addClass('selected');

	// 	jQuery.post(data.surl+'/ajax-video.php', {video: jQuery(this).attr('id')}, function(result){
	// 		jQuery('#video-container').html(result);
	// 	});
		
	// 	return false;
	// });
	
	// jQuery('#video-list a:first').click();
	
	// jQuery('#video-next').click(function(){
	// 	var next = jQuery(document).data('open-video').parent().next();
		
	// 	if(!next.length)
	// 		next = jQuery('#video-list li:first');
		
		
	// 	next.find('a').click();
		
	// 	return false;
	// });
	
	// jQuery('#video-previous').click(function(){
	// 	var prev = jQuery(document).data('open-video').parent().prev();
	// 	if(!prev.length)
	// 		prev = jQuery('#video-list li:last');
		
	// 	prev.find('a').click();
		
	// 	return false;
	// });

	// mapa página do cadastro
    $(".page #mapa .estado").click(function(e){
       
        var state = $(this).find('path').attr('id');
       
        $('.menu-setoriais-container').hide(); 

        // $('#menu-setoriais li a').attr("href").replace('/uf-','/'+state+'-');
        $('#menu-setoriais li a').each(function(){
        	var href = $(this).attr('href');
			var regex = /\/[\w]{2}-/;
			href  = href .replace(regex, '/'+state+'-');

		   $(this).attr('href',href);
		});

        $(".menu-setoriais-container").css({top:'10%', left:'45%', position: 'fixed'}).slideDown();

        return false;
    });

    // fechar a lista ao clicar fora da área do mapa
    $(document).click(function(event) { 
        if(!$(event.target).closest('path, .menu-setoriais-container, text').length )
            $('.menu-setoriais-container').hide();
    }); 

	
	});
})(jQuery);