(function($) {
    $(document).ready(function(e) {
        $form = $("#user-register");


        function scrollCadastro(e) {
            $('html, body').animate({
                scrollTop: $(e).offset().top - 50
            }, 500);
        }

        function stepsCount(c) {
            $('#cadastro .step__count').show().find('.active').removeClass('active');
            $('#cadastro .step__count').children(c).addClass('active');
        }

        
        $('#loginform').hide();
        $('#cadastro-toggle').click(function(){
            $('#cadastro').hide();
            $('#loginform').show();
        });

        // se carregar a página mostrar o lugar correto
        if ( $( ".user_type" ).attr( "checked" ) == "checked") {
            $('#step-1-register').hide();
            $('#step-2-register').show();
        }

        if($('#user_UF').val()!="" && $('#user_setorial').val()!="" ){ 
            $('#step-2-register').hide();
            $('#step-3-register').show();
            $(".form-application input[type='submit']").show();
        }

        // etapa 1 -> etapa 2
        $('#step-1-register .user_type').click(function(){
        	$('#step-1-register').hide();
            $('#step-2-register').show();

            scrollCadastro("#cadastro");
            stepsCount('.step_2');            
        });

        // etapa 2 -> etapa 3 - desativado
        $('#user_UF, #user_setorial').change(function() {
		    if($('#user_UF').val()!="" && $('#user_setorial').val()!="" ){ 
		       	$('#step-2-register').hide();
            	$('#step-3-register').show();
            	$(".form-application input[type='submit']").show();
		    }

            scrollCadastro("#cadastro");
            stepsCount('.step_2');
		});

        // mapa página do cadastro
        $("#mapa .estado").click(function(e){
           
            var state = $(this).find('path').attr('id');
            var $setoriais = $('.menu-setoriais-container');
            var s_height = $setoriais.height();
            var s_width = $setoriais.width();

            $setoriais.hide(); 
          
            $setoriais.css({top:'50%', left:'50%', position: 'fixed', 'margin-top': -(s_height/2), 'margin-left': -(s_width/2) }).slideDown();

            $form.find('#user_UF').val( state );

            return false;
        });

        // quando clicar na lista de setoriais do mapa
        // etapa 2 -> etapa 3
        $("#menu-setoriais a").click(function(e){
            var setorial = $(this).attr('id');
            $form.find('#user_setorial').val( setorial);

            $('#step-2-register').hide();
            $('#step-3-register').show();
            $(".form-application input[type='submit']").show();

            
            scrollCadastro("#cadastro");
            stepsCount('.step_3');
            $form.find('#user_cpf').focus();
            return false;
        });

        // fechar a lista ao clicar fora da área do mapa
        $(document).click(function(event) { 
            if(!$(event.target).closest('path, .menu-setoriais-container, text').length )
                $('.menu-setoriais-container').hide();
        }); 

            //dados do cpf
       function get_dados_cpf() {
            $form.find('#user_cpf').before('<i class="fa fa-spinner fa-spin"></i>');

            $.post(cadastro.ajaxurl,{'action':'setoriaiscnpc_get_data_receita_by_cpf','cpf':$form.find('#user_cpf').val()},
                function(data) {
                    if(data) {     
                        var obj = $.parseJSON( data );
                        $form.find('#user_name').val( obj.nmPessoaFisica).prop('readonly', true);
                        $form.find('i').remove();

                        // $form.find('#user_birth').val( obj.dtNascimento).prop('readonly', true);
                    }else {

                    }
                },'json');
        };


        // callback to verify field through
        var verify_register_field = function(e) {

            var $me = $(this);

            if( $me.is('input[type="checkbox"]'))
                $me.prop("checked") ? '' : $me.val("0");

            var values = {'action': 'setoriaiscnpc_register_verify_field'};
            values['user_type'] = $('input[name="user_tipo"]:checked').val();
            values[this.name] = $me.val();

            $.post(cadastro.ajaxurl, values,
                function(data) {

                    for(var field in data) {
                       
                        if(data[field] === true && $me.val().length > 0) {
                            $form.find('#'+field+'-error').hide().html('');

                            if( field == 'user_cpf' )
                                get_dados_cpf();
                            
                        } else {
                            // $form.find('#'+field).val('');
                            $form.find('#'+field+'-error').html(data[field]).show(); 


                            // if( field == 'user_cpf' )
                            //     $form.find('#user_name').val('').prop('readonly', false);
                        }
                    }
                }, 'json');
        };

        $form.find(':input').blur(verify_register_field)
                            .keydown(function(e){ if(e.keyCode===13){ //enter
                                $(this).trigger('blur').focus();
                            }});

    
        // $form.find("#user_password_confirm").keyup( function checkPasswordMatch() {
        //     var password = $form.find('#user_password').val();
        //     var confirmPassword = $form.find("#user_password_confirm").val();

        //     if (password != confirmPassword)
        //         $form.find("#user_password_confirm-error").html("As senhas não são iguais").show();
        //     else
        //         $form.find("#user_password_confirm-error").hide().html('');
        // });

        $(document).find('#user_cpf').mask('999.999.999-99');
        $(document).find('#user_birth').mask('99/99/9999');


        // desativa o enter no formulário
        $(document).on("keypress", 'form', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });

        // enter vira tab
        $form.find(':input').keydown(function (e) {
            if (e.which === 13) {
                var index = $form.find(':input').index(this) + 1;
                $form.find(':input').eq(index).focus();
            }
        });

    });
})(jQuery);
