(function($) {
    $(document).ready(function(e) {
        $('#loginform').hide();
        $('#cadastro-toggle').click(function(){
            $('#cadastro').hide();
            $('#loginform').show();
        });

        $('#step-1-register .user_type').click(function(){
        	$('#step-1-register').hide();
            $('#step-2-register').show();
        });

        $('#user_UF, #user_setorial').change(function() {
		    if($('#user_UF').val()!="" && $('#user_setorial').val()!="" ){ 
		       	$('#step-2-register').hide();
            	$('#step-3-register').show();
            	$(".form-application input[type='submit']").show();
		    }
		});

        // mapa página do cadastro
        $("#mapa path, #mapa text").click(function(e){

            var posX = $(this).position().left, posY = $(this).position().top;

            $('.menu-setoriais-container').hide();       

            if( posY < 400)
                $(".menu-setoriais-container").css({top:(posY), bottom: 'auto', left:(posX), position: 'absolute'}).slideDown();
            else
                $(".menu-setoriais-container").css({top: 'auto', bottom:0, left:(posX), position: 'absolute'}).slideDown();

            $('html, body').animate({
                scrollTop: $(this).offset().top
            }, 500);

        });

        // fechar a lista ao clicar fora da área do mapa
        $(document).click(function(event) { 
            if(!$(event.target).closest('path, .menu-setoriais-container').length )
                $('.menu-setoriais-container').hide();
        }); 

        $(document).find('#user_cpf').mask('999.999.999-99');
        $(document).find('#user_birth').mask('99/99/9999');


    });
})(jQuery);
