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

        function show_step1() {
            $('#step-1-register').show();
            $('#step-2-register').hide();
            $('#step-3-register').hide();
        }

        function show_step2() {
            $('#step-1-register').hide();
            $('#step-2-register').show();
            $('#step-3-register').hide();
        }

        function show_step3() {
            $('#step-1-register').hide();
            $('#step-2-register').hide();
            $('#step-3-register').show();
            $(".form-application #submit").show();
        }

        // se recarregar a página voltar para o lugar correto
        if ( $( ".user_type" ).attr( "checked" ) == "checked" && $( "#terms_of_use" ).attr( "checked" ) == "checked") {
            show_step2();
        }

        if($('#user_UF').val()!="" && $('#user_setorial').val()!="" ){ 
           show_step3();
        }

        // etapa 1 -> etapa 2
        $('#step-1-register .user_type').click(function(){
            if ( $( "#terms_of_use" ).attr( "checked" ) == "checked") {
                
                show_step2();

                scrollCadastro("#cadastro");
                stepsCount('.step_2');

            } else {
                alert("Você deve concordar com os termos para continuar!")
                return false;
            }           
        });



        // etapa 2 -> etapa 3 - desativado
        $('#user_UF, #user_setorial').change(function() {
		    if($('#user_UF').val()!="" && $('#user_setorial').val()!="" ){
                 show_step3(); 
		       	// $('#step-2-register').hide();
          //   	$('#step-3-register').show();
          //   	$(".form-application #submit").show();
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

            show_step3();

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

        // popular nome e data de nascimento com os dados do cpf
       function get_dados_cpf() {
            $form.find('#user_cpf').before('<i class="fa fa-spinner fa-spin"></i>');

            $.post(cadastro.ajaxurl,{'action':'setoriaiscnpc_get_data_receita_by_cpf','cpf':$form.find('#user_cpf').val()},
                function(data) {
                    if(data) {     
                        var obj = $.parseJSON( data );
                        $form.find('#user_name').val( obj.nmPessoaFisica).prop('readonly', true);
                        $form.find('i').remove();

                        $form.find('#user_birth').val( obj.dtNascimento).blur();
                        // $form.find('#user_birth').val( obj.dtNascimento).prop('readonly', true).blur();
                    }else {

                    }
                },
            'json');
        };

        // verifica se o candidato é valido, se não for altera para eleitor
       function check_is_valid_candidate() {

            if( $( "#tipo_candidato" ).attr( "checked" ) == "checked" && $( "#tipo_candidato" ).val() == 'candidato' ) {
               
                $.post(cadastro.ajaxurl,{'action':'is_user_candidate_valid','cpf':$form.find('#user_cpf').val()},
                    function(data) {
        
                        if( data !== true ) {   
                            $form.find('#user_cpf-warning').html(data).show(); 
                            $form.find('#tipo_eleitor').attr('checked', true); 
                            $form.find('#tipo_candidato').attr('checked', false);  
                        }
                    },
                'json');
            }
        };

        // callback to verify field through
        var verify_register_field = function(e) {

            var $me = $(this);
            
            var values = {'action': 'setoriaiscnpc_register_verify_field'};
            values['user_type'] = $('input[name="user_tipo"]:checked').val();

            // no checkbox o ajax pega o valor mesmo sem estar selecionado
            if( $me.is('input[type="checkbox"]')) {
               if( $me.prop("checked") )
                    values[this.name] = $me.val();
            }else 
                values[this.name] = $me.val();

            // values[this.name] = $me.val();

            $.post(cadastro.ajaxurl, values,
                function(data) {

                    for(var field in data) {
                       
                        if(data[field] === true && $me.val().length > 0) {
                            $form.find('#'+field+'-error').hide().html('');

                            // se o cpf estiver com os dados válidos, popular o nome no form
                            if( field == 'user_cpf' ){
                                check_is_valid_candidate();
                                get_dados_cpf();
                            }
                            
                        } else {
                            // $form.find('#'+field).val('');
                            $form.find('#'+field+'-error').html(data[field]).show(); 

                            if( field == 'user_cpf' ) {
                                $form.find('#user_name').val('');
                                $form.find('#user_birth').val('');
                            }
                        }
                    }
                }, 'json');
        };

        $form.find(':input').blur(verify_register_field)
                            .keydown(function(e){ if(e.keyCode===13){ //enter
                                $(this).trigger('blur').focus();
                            }});

        function show_text_state_by_uf( uf, estado ) {
            var text;

            switch(uf) {
                case 'BA':
                case 'PB':
                    text = 'da';
                    break;
                case 'AL':
                case 'GO':
                case 'MT':
                case 'MS':
                case 'MG':
                case 'PE':
                case 'RO':
                case 'RR':
                case 'SC':
                case 'SP':
                case 'SE':  
                    text = 'de';
                    break;
                case 'AP':
                case 'AM':
                case 'CE':
                case 'DF':
                case 'ES':
                case 'MA':
                case 'PA':
                case 'PR':
                case 'PI':
                case 'RJ':
                case 'RN':
                case 'RS':
                case 'TO':
                    text = 'do';
                    break;
                default:
                    text = 'do';
            }
            
            return text +' '+ estado +' ('+ uf +')';
        }

        $("#user-register #submit").click(function(event) {
            
            var text, setorial, uf, estado;

            setorial = $form.find('#user_setorial option:selected').text();
            uf       = $form.find('#user_UF option:selected').val();
            estado   = $form.find('#user_UF option:selected').text();

            text = '<p>Confirma o cadastro na Setorial de '+setorial+' '+show_text_state_by_uf( uf, estado )+'?</p>';           

            $('<div class="dialogs"></div>').appendTo( $( "#user-register" ) )
              .html('<div class="htl"><h3>Atenção</h3>'+text+'</div')
              .dialog({
                    modal: true, 
                    title: '', 
                    zIndex: 10000, 
                    autoOpen: true, 
                    closeText: '<i class="fa fa-times close"></i>',
                    width: 'auto', 
                    resizable: false,
                    buttons: {
                        Não: function () {
                            $(this).dialog("close");
                            show_step2();
                        },
                        Sim: function () {
                            $form.submit();
                            $(this).dialog("close");
                        }
                  },
                  close: function (event, ui) {
                      $(this).remove();
                  }
            });
            return false;
        });

        $(document).find('#user_cpf').mask('999.999.999-99');
        $(document).find('#user_birth').mask('99/99/9999');

        $('#loginform').hide();
        $('#cadastro-toggle').click(function(){
            $('#cadastro').hide();
            $('#loginform').show();
        });


        // desativa o enter no formulário
        $(document).on("keypress", 'form', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });

        // // enter vira tab
        $form.find(':input').keydown(function (e) {
            if (e.which === 13) {
                var index = $form.find(':input').index(this) + 1;
                $form.find(':input').eq(index).focus();
            }
        });

    });
})(jQuery);
