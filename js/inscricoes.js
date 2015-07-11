(function($) {
    $(document).ready(function(e) {
        $form = $("#application-form");

        // a little helper to toggle classes
        $form.set_status = function(f, s) {
            if(s === 'valid') {
                $form.find("#"+f+" + div .field-status").removeClass("espera invalido").addClass("completo");
            } else if(s === 'invalid') {
                $form.find("#"+f+" + div .field-status").removeClass("espera completo").addClass("invalido");
            } else if(s === 'wait'){
                $form.find("#"+f+" + div .field-status").removeClass("completo invalido").addClass("espera");
            } else {
                $form.find("#"+f+" + div .field-status").removeClass("completo invalido espera");
            }
        }

//callbacks {
        // callback to cancel events
        var return_false = function(){return false};

        // callback to calculate values for budget inputs
        // var calculate_total = function(e) {
        //     var values = [$('#budget-pre-production').val()||'',
        //                   $('#budget-production').val()||'',
        //                   $('#budget-post-production').val()||''];
        //     var total = 0;
        //     for(var i = 0; i < values.length; i++) {
        //         var m = values[i].match(/\d+(\.\d\d\d)*,\d\d$/);
        //         if(m) {
        //             total += parseFloat( m[0].replace(/\./g,'').replace(/,/,'.') );
        //         }
        //     }
        //     total = (total+'.').split('.');
        //     total = total[0] + '.' + (total[1]+"00").slice(0,2);
        //     $("#budget-total").val(total).trigger('mask');
        // };

        // callback to verify and save field through
        var verify_and_save_field = function(e) {
            var $me = $(this);
            var $step_status = $me.parents('div.form-step')
                                  .find('div.step-status');
            
            if( $me.is('input[type="checkbox"]'))
                $me.prop("checked") ? '' : $me.val("0");
            
            var values = {'action': 'setoriaiscnpc_save_field'};
            values[this.name] = $me.val();

            $form.set_status(this.id, 'wait');
            $.post(inscricoes.ajaxurl, values,
                function(data) {
                    for(var field in data) {
                        if(data[field] === true && $me.val().length > 0) {
                            $form.set_status(field, 'valid');
                            $form.find('#'+field+'-error').hide().html('');
                            if($me.parents('div.form-step').find('.required + div .invalido').length == 0) {
                                $step_status.addClass('completo');
                            }
                        } else {
                            $form.find('#'+field+'-error').html(data[field]).show();
                            if($me.hasClass('required')) {
                                $form.set_status(field, 'invalid');
                                $step_status.removeClass('completo');
                            } else {
                                $form.set_status(field);
                            }
                        }
                    }
                    block_formstep.call($me.get(0), e);
                },
            'json');
        };

        // callback to remove a formstep if the previous one is invalid
        var block_formstep = function(e) {
            var $div = $(this).parents('div.form-step');
            if($div.find('.required + div .invalido').length > 0) {
                $div.find('~ .form-step').find('.form-step-content').remove();
                $div.find('~ .form-step').find('a.toggle').show();
                $div.find('~ .form-step').find('p').show();
            }
        }

        // callback to submit the whole subscription
        var submit_subscription = function(e) {
            $parent = $(this).parent();
            $.post(inscricoes.ajaxurl,{'action':'subscribe_project'},
                function(data) {
                    $parent.find('p').remove();
                    $('<p class="textcenter">').html(data['message']).appendTo($parent);
                    $('<p id="protocol-number">').html('&mdash; Inscrição Número &mdash;<strong>' + data['subscription_number'].substring(0,8) + '</strong>').appendTo($parent);
                    $('#application-form :input').unbind().attr('disabled',true);
                    $('#print-button').attr('href',data['subscription_number'].substring(0,8)+"/imprimir/").show();
                }, 'json')
                .error(function(e) {
                    $parent.find('.textcenter').remove();
                    $('<p class="textcenter">').html(e.responseText).appendTo($parent);
            });
        };

        // callback to count character on textareas
        var display_text_length = function() {
            var $me = $(this);
            var m = $me.html().match(/(\d+)/);
            if(m.length === 2) {
                m = parseInt(m[1]);
                $me.parent().find('+ textarea').keyup(function(e) {
                    var c = m - $(this).val().length;
                    $me.html($me.html().replace(/[+-]?\d+/,c));
                    if(c < 1) {
                        $me.css('color','#bf0000');
                    } else {
                        $me.css('color','');
                    }
                }).keyup();
            }
        }
//callbacks }

// event assignment {

        // *** the order of assignment events is important *** //

        // attach calculate_total to budget fields, except total field
        // $('input.budget[id!=budget-total]').blur(function(e) {
        //         calculate_total.call(this,e);
        //         $('#budget-total').each(function(){
        //             verify_and_save_field.call(this, e);
        //         })
        // });
        // this disable the #budget-total input
        // $('#budget-total').bind('keydown keyup', function(e){
        //     return e.keyCode === 9;
        // }).focus(function(e){$(this).blur();});

        $form.find(':input').blur(verify_and_save_field)
                            .keydown(function(e){ if(e.keyCode===13){ //enter
                                $(this).trigger('blur').focus();
                            }});
		
		// Hook pra salvar e verificar o CPF quando carregar o formulário
		$('#candidate-cpf').blur();
		
        // load next form step when user click in 'Preencher'
        $('div.form-step a.toggle').click(function(e) {
            var $div = $(this).parents('div.form-step');
            var step = $div.attr('id').replace(/^[^-]+-/,'');

            $.post(inscricoes.ajaxurl, {'action': 'load_step_html', 'step': step},
                function(html) {
                    $div.find('div.form-step-content').remove();
                    $div.find('p').hide();
                    $div.append(html);

                    // *** this assignments affects fields loaded throught ajax *** //

                    // reassign calculate_total to budget fields
                    $div.find('input.budget[id!=budget-total]').blur(function(e) {
                            calculate_total.call(this,e);
                            $('#budget-total').each(function(){
                                verify_and_save_field.call(this, e);
                            })
                    });
                    // this disable the #budget-total input, again
                    $div.find('#budget-total').bind('keydown keyup', function(e){
                        return e.keyCode === 9;
                    }).focus(function(e){$(this).blur();});

                    // reassign verify_and_save_field to inputs
                    $div.find(':input').blur(verify_and_save_field)
                                       .keydown(function(e){ if(e.keyCode===13){ //enter
                                            $(this).trigger('blur').focus();
                                        }});
                    // mask for money
                    $div.find('input.budget').maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
                    // character counter for textarea
                    $div.find('label .form-tip').each(display_text_length);
                    // the submit
                    $div.find('#submit-button').click(submit_subscription);

                    $div.find('span.form-error').html('');
                }, 'html'
            ).error(function(e){
                // some messages come from 403. use e.responseText to see them
                $div.find('span.form-error').html(e.responseText);
            });
            return false;
        });

        // *** this assignments does <em>NOT</em> affect fields loaded throught ajax ** //

        // load states from when user selects a region
        // $form.find('#candidate-region').change(function(e) {
        //     $.post(inscricoes.ajaxurl,{'action':'get_states','region':$(this).val()},
        //         function(data) {
        //             if(data) {
        //                 // reset
        //                 $('#candidate-state,#company-state').html('<option value="">------</option>').trigger('blur');
        //                 $('#candidate-city,#company-city').html('<option value="">------</option>').trigger('blur');
        //                 // load states to fill #candidate-state and #company-state together
        //                 for(var i=0; i < data.length; i++) {
        //                     $('<option>').val(data[i].id).html(data[i].nome)
        //                         .appendTo('#candidate-state');
        //                 }
        //             }
        //         },'json');
        //     // $(this).trigger('blur');
        //     // $('#candidate-region').val($(this).val()).trigger('blur'); // bind #company-region
        // });

        // load cities from selected state to fill $candidate-city and #company-city individually
        // $form.find('#candidate-state,#company-state').change(function(e) {
        //     var section = this.id.replace(/-state$/,'');
        //     $.post(inscricoes.ajaxurl,{'action':'get_cities','state':$(this).val()},
        //         function(data) {
        //             if(data) {
        //                 $('#'+section+'-city').html('<option value="">------</option>');
        //                 for(var i=0; i < data.length; i++) {
        //                     $('<option>').val(data[i].id).html(data[i].nome)
        //                         .appendTo('#'+section+'-city');
        //                 }
        //             }
        //         },'json');
        // });

        // lock company region dropdown
        // $form.find('#candidate-region').change(function(){
        //     $(this).val($('#company-region').val());
        // });

        // character counter for textareas
        $('label .form-tip').each(display_text_length);
        $('#submit-button').click(submit_subscription);
        // event assignment }


        // UPLOADS
        $('.file-upload').each(function() {

            var $self = $(this);

            $self.find('.js-upload-button').ajaxUpload({
                url: inscricoes.ajaxurl + '?action=inscricoes_file_upload',
                name: 'file-upload',
                onSubmit: function(a) {
                    $self.find('.js-feedback').html('Fazendo Upload').fadeIn();
                }, onComplete: function(result) {
                    result = JSON.parse(result);
                    if (result.error) {
                        $self.find('.js-feedback').html(result.error).fadeIn().delay(1000).fadeOut();
                    } else {
                        $('#' + $self.data('field')).val(result.success.id).trigger('blur'); //trigger save
                        $self.parents('.grid__item').find('.js-current').html(result.success.html);
                        $self.find('.js-feedback').html('Upload feito com sucesso!').fadeIn().delay(1000).fadeOut();
                    }
                }
            });

        });



        /**** Masks ****/
        // $form.find('#candidate-cpf').mask('999.999.999-99');
        // $form.find('#candidate-date-birth').mask('99/99/9999');
        // $form.find('input.cep').mask('99999-999');
        $form.find('input.phone').mask('(99) 999999?999');
        // $form.find('#company-cnpj').mask('99.999.999/9999-99');
    });
})(jQuery);
