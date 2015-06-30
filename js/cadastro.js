(function($) {
    $(document).ready(function(e) {
        $('#loginform').hide();
        $('#cadastro-toggle').click(function(){
            $('#cadastro').hide();
            $('#loginform').show();
        });
    });
})(jQuery);
