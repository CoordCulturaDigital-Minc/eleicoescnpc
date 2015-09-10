(function($) {
    $(document).ready(function(e) {
       
        // permite ao candidato reabrir sua inscrição
        $("a.cancel-subscription").click(function(e){
            var pid = this.id.replace(/^[^0-9]+/,'');
    
            if(confirm("Você realmente deseja reabrir sua inscrição?\n\n"
                +"Esta opção retira seu perfil da lista de candidatos(as), \n você terá que finalizar a inscrição novamente!")) {
                $.post(vars.ajaxurl,{'action':'cancel_subscription', 'pid':pid},function(data) {
                    if(data ) {
                       window.location.replace($(this).attr('href'));
                    }else{
                        alert("Não foi possível reabrir sua inscrição");
                    }
                });
           }

           return false;
        });
    });
})(jQuery);
