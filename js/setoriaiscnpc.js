/**
 * 
 */
jQuery(document).ready(function(){
	jQuery('#video-list a').click(function(){
		if(jQuery(document).data('open-video'))
			jQuery(document).data('open-video').removeClass('selected');
		
		jQuery(document).data('open-video', jQuery(this));
		
		jQuery(document).data('open-video').addClass('selected');

		jQuery.post(data.surl+'/ajax-video.php', {video: jQuery(this).attr('id')}, function(result){
			jQuery('#video-container').html(result);
		});
		
		return false;
	});
	
	jQuery('#video-list a:first').click();
	
	jQuery('#video-next').click(function(){
		var next = jQuery(document).data('open-video').parent().next();
		
		if(!next.length)
			next = jQuery('#video-list li:first');
		
		
		next.find('a').click();
		
		return false;
	});
	
	jQuery('#video-previous').click(function(){
		var prev = jQuery(document).data('open-video').parent().prev();
		if(!prev.length)
			prev = jQuery('#video-list li:last');
		
		prev.find('a').click();
		
		return false;
	});
});
