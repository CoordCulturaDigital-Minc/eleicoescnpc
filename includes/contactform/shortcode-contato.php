<?php

function add_shortcode_contato() {
	
	function contato_shortcode ($atts, $content) {
		
		ob_start();
        ?>
        <div class="row">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <form action="" id="formulario-contato" class="hl-form" method="post" role="form">

                    <div id="error-general" class="hl-message-alert"></div>

                    <div class="article--content--form--content form-group">
                        <div class="form--content--label clearfix">
                            <label for="nome" >Nome</label>
                            <div id="error-nome" class="hl-error-alert"></div>
                        </div>
                        <input id="nome" type="text" name="nome" class="form-control"/>
                    </div>

                    <div class="article--content--form--content">
                        <div class="form--content--label clearfix">
                            <label for="email" >Email</label>
                            <div id="error-email" class="hl-error-alert"></div>
                        </div>
                        <input id="email" type="email" name="email" class="form-control" />
                    </div>

                    <div class="article--content--form--content">
                        <div class="form--content--label clearfix">
                            <label for="assunto" >Assunto</label>
                            <div id="error-assunto" class="hl-error-alert"></div>
                        </div>
                        <input id="assunto" type="text" name="assunto" class="form-control" />
                    </div>

                    <div class="article--content--form--content">
                        <div class="form--content--label clearfix">
                            <label for="mensagem" >Mensagem</label>
                            <div id="error-mensagem" class="hl-error-alert"></div>
                        </div>
                        <textarea id="mensagem" name="mensagem" class="form-control" ></textarea>
                    </div>
                    
                    <input type="submit" class="hl-form-submit button alignright" value="Enviar" />

                </form>
            </div>
        
        </div>
        <?php
        
        $output = ob_get_contents();
        ob_end_clean();
        
        return $output;
        
	}
	
	add_shortcode('formulario_contato', 'contato_shortcode');
    
}

add_action('init', 'add_shortcode_contato');


?>
