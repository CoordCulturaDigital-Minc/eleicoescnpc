(function($){
    $(document).ready(function(){

        var $form = $(".hl-form");
        var formID = $form.attr('id');

        $form.children(".hl-form-submit").click(function( event ){
            event.preventDefault();

            $form.find('.hl-error-alert').hide();
            var submitOriginalValue = $form.find('.hl-form-submit').val();
            $form.find('.hl-form-submit').val('Enviando...');

            $.ajax({
                url: formvars.ajaxurl + '?send=true&action=form_process&formID='+formID+'&' + $form.serialize(),
                type: 'get',
                success: function( data ) {
                    var dataJSON = JSON.parse(data);
                    if ( dataJSON.sucesso != true ) {
                        for ( var i in dataJSON.error_messages ) {
                            var elementError = $("#" + formID).find("#error-"+ i);
                            elementError.html(dataJSON.error_messages[i]).fadeIn().delay(6000).fadeOut();
                        }
                    } else {
                        $form.find('.hl-message-alert').html("Formulário enviado com sucesso!").fadeIn().delay(3000).fadeOut();
                        if ( $form.find('input[type=submit]') ) {
                            $form.find('input, textarea').val('');
                        }
                    }
                    $form.find('.hl-form-submit').val(submitOriginalValue);
                }

            });
        });

        //Mask Tel
        var maskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        options = {
            onKeyPress: function(val, e, field, options) {
                field.mask(maskBehavior.apply({}, arguments), options);
            }
        };
        if ($('input[type=tel]').size > 0)
            $('input[type=tel]').mask(maskBehavior, options);

    });
})(jQuery);
