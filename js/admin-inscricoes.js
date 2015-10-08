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


    $("#elected-candidate").change(function(e) {
        var subscription_number = $('#js-protocol-number').val();
        var is_elected = this.checked ? 'true' : 'false';

        $(document.body).css('cursor','wait !important');

        jQuery.post(inscricoes.ajaxurl, { 'action':'elect_candidate',
                                          'subscription_number': subscription_number,
                                          'elected-candidate': is_elected},
            function(d){
                $(document.body).css('cursor','');
            },
            'json')
    });

});
