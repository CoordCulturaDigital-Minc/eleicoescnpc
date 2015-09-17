jQuery(document).ready(function() { var $ = jQuery;

	$( '#js-subscriptions-list input[name=read]' ).change(function(e) {
		var is_checked = $(this).attr('checked') == 'checked';

		$(document.body).css('cursor','wait');
		$.post(avaliacoes.ajaxurl, { 'action':'mark_as_read',
									 'status': is_checked ? 'read' : 'unread',
									 'subscription' : $(this).val() },
				function(data) {
					$(document.body).css('cursor','');
				}, 'json');
	});

	$( '.js-sortable-table' ).tablesorter();

	// filtro por setorial 
	$("select#setorial").change( function() {
        $("#filter_setorial").submit();
    });

});
