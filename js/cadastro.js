(function($) {
    $(document).ready(function(e) {
        $form = $("#user-register");

        function scrollCadastro(e) {
            $('html, body').animate({
                scrollTop: $(e).offset().top
            }, 500);
        }
        
        $('#loginform').hide();
        $('#cadastro-toggle').click(function(){
            $('#cadastro').hide();
            $('#loginform').show();
        });

        $('#step-1-register .user_type').click(function(){
        	$('#step-1-register').hide();
            $('#step-2-register').show();

            scrollCadastro("#cadastro");
        });

        $('#user_UF, #user_setorial').change(function() {
		    if($('#user_UF').val()!="" && $('#user_setorial').val()!="" ){ 
		       	$('#step-2-register').hide();
            	$('#step-3-register').show();
            	$(".form-application input[type='submit']").show();
		    }

            scrollCadastro("#cadastro");
		});

        // mapa página do cadastro
        $("#mapa path, #mapa text").click(function(e){

            var parentPosition = getPosition(e.currentTarget);
            var posX = e.clientX - parentPosition.x;
            var posY = e.clientY - parentPosition.y;
            var state = $(this).attr('state');

            $('.menu-setoriais-container').hide();       

            if( posY < 400) {
                $(".menu-setoriais-container").css({top:(posY), bottom: 'auto', left:(posX), position: 'absolute'}).slideDown();
            
                $('html, body').animate({
                    scrollTop: $(this).offset().top
                }, 500);
                
            }
            else
                $(".menu-setoriais-container").css({top: 'auto', bottom:0, left:(posX), position: 'absolute'}).slideDown();

            $form.find('#user_UF').val( state );
        });

        function getPosition(element) {
            var xPosition = 0;
            var yPosition = 0;
              
            while (element) {
                xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
                yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
                element = element.offsetParent;
            }
            return { x: xPosition, y: yPosition };
        }

        // quando clicar na lista de setoriais do mapa
        // seleciona e mostra a próxima etapa
        $("#menu-setoriais a").click(function(e){
            var setorial = $(this).attr('id');
            $form.find('#user_setorial').val( setorial);

            $('#step-2-register').hide();
            $('#step-3-register').show();
            $(".form-application input[type='submit']").show();

            scrollCadastro("#cadastro");
              $form.find('#user_cpf').focus();
            return false;
        });
        

        // fechar a lista ao clicar fora da área do mapa
        $(document).click(function(event) { 
            if(!$(event.target).closest('path, .menu-setoriais-container').length )
                $('.menu-setoriais-container').hide();
        }); 

        // callback to verify field through
        var verify_register_field = function(e) {

            event.preventDefault();

            var $me = $(this);

            var values = {'action': 'setoriaiscnpc_register_verify_field'};
            values['user_type'] = $('input[name="user_tipo"]:checked').val();
            values[this.name] = $me.val();

            $.post(cadastro.ajaxurl, values,
                function(data) {

                    for(var field in data) {
                       
                        if(data[field] === true && $me.val().length > 0) {
                            $form.find('#'+field+'-error').hide().html('');
                            
                        } else {
                            $form.find('#'+field+'-error').html(data[field]).show(); 
                        }
                    }
                }, 'json');
        };

        $form.find(':input').blur(verify_register_field)
                            .keydown(function(e){ if(e.keyCode===13){ //enter
                                $(this).trigger('blur').focus();
                            }});

        //dados do cpf
        $form.find('#user_cpf').change(function(e) {
            
            $.post(cadastro.ajaxurl,{'action':'setoriaiscnpc_get_data_receita_by_cpf','cpf':$(this).val()},
                function(data) {
                    if(data) {
                                            
                        var obj = $.parseJSON( data );
                  
                        $form.find('#user_name').val( obj.nmPessoaFisica).prop('disabled', true);
                        // $form.find('#user_birth').val( obj.dtNascimento).prop('disabled', true);
                    }
                }, 'json');
            
        });

        $form.find("#user_password_confirm").keyup( function checkPasswordMatch() {
            var password = $form.find('#user_password').val();
            var confirmPassword = $form.find("#user_password_confirm").val();

            if (password != confirmPassword)
                $form.find("#user_password_confirm-error").html("As senhas não são iguais").show();
            else
                $form.find("#user_password_confirm-error").hide().html('');
        });

        // $form.find('#user_birth').change(function(e) {

            // var re = /(\d{2})\/(\d{2})\/(\d{4})/;

            // var birth = $(this).val().replace(re, "$3-$2-$1");

            // var diff = new Date(Date.parse(cadastro.today_server) - Date.parse(birth));
            
            // var days = diff/1000/60/60/24;
            
            // if(days < 6574 )
            //     $form.find('#user_birth-error').html('Você não possui idade mínima para ser candidato').show();

        // });

        // function check_birth( b ) {
        //     // partern
        //     var re = /(\d{2})\/(\d{2})\/(\d{4})/;

        //     b = b.replace(re, "$3-$2-$1");

        //     var diff = new Date(Date.parse(cadastro.today) - Date.parse(b));
            
        //     var days = diff/1000/60/60/24;
            
        //     if( days < 6574 )
        //         $form.find('#user_birth-error').html('Você não possui idade mínima para ser candidato').show();
        //     else (days < 5844 )
        //         $form.find('#user_birth-error').html('Você não possui idade mínima para ser eleitor').show();
        // }   
        
        // var re = /(\w+)\s(\w+)/;
        // var str = "John Smith";
        // var newstr = str.replace(re, "$2, $1");
        // console.log(newstr);

        // var date1, date2;

        // str = '17/05/1988'

        // date2 = /w3schools/i;
        // var re = /(\d{2})\/(\d{2})\/(\d{4})/;
        // var re = /([99])\s(\w+)/;
        // var newstr = date1.replace(tres, "$3-$2-$1");
       
        // alert(newstr);

        $(document).find('#user_cpf').mask('999.999.999-99');
        $(document).find('#user_birth').mask('99/99/9999');

    });
})(jQuery);
