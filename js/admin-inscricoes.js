jQuery(document).ready(function() { var $ = jQuery;

    $("#subscription-valid").change(function(e) {
        var subscription_number = $('#js-protocol-number').val();
        var is_valid = this.checked ? 'true' : 'false';

        $(document.body).css('cursor','wait !important');

        jQuery.post(inscricoes.ajaxurl, { 'action':'validate_subscription',
                                          'subscription_number': subscription_number,
                                          'subscription-valid': is_valid},
            function(d){
                $(document.body).css('cursor','');
            },
            'json')
    });

});
