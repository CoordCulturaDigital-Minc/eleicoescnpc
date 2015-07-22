jQuery(document).ready(function() {
	jQuery('.post2home-button').click(function() {
		var meta_action;
		var post_id = jQuery(this).attr('id').replace('post2home-', '');

		if (jQuery(this).attr('checked'))
			meta_action = 'update_meta';
		else
			meta_action = 'delete_meta';

		jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'html',
            data: {
				post_id: post_id,
				action: 'post2home_handle_post_meta',
				meta_action: meta_action
            },
            complete: function(jqXHR, textStatus) {
            	if (textStatus == 'error')
                	alert('Failed to feature your post.');
            }
        });
	});
});
