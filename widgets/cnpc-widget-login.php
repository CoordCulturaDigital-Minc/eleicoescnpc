<?php

/**
 * Copyright (c) 2015 Tiago Mergulhão
 *
 * Written by Tiago Mergulhão <me@tmergulhao.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the
 * Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *
 * Public License can be found at http://www.gnu.org/copyleft/gpl.html
 *
 * Plugin Name: CNPC Login widget
 * Plugin URI: http://homologvotacnpc.cultura.gov.br/
 * Description: Just a simple login widget for wordpress
 * Author: Tiago Mergulhão
 * Version: 2015.07.10
 * Author URI: http://tmergulhao.com/
 * License: GPL2
 */

class CNPC_Widget_Login extends WP_Widget
{
	function form ( $instance ) {}
	
	function update ( $new_instance, $old_instance ) {}
	
	function widget ( $args, $instance ) {
		extract( $args );
		
		echo $before_widget;
		
		if ( is_user_logged_in() ) : global $user_ID; ?>
        <?php $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_ID ) ); ?>
        <h3 class="widget__title"><?php printf( __('Olá, %s!', 'historias' ), $user_meta['nickname']); ?></h3>
    <?php else : ?>
        <h3 class="widget__title">Entrar</h2>
    <?php endif; ?>
	
    <?php if ( is_user_logged_in() ) : ?>

		<?php if (get_user_meta($user_ID, 'e_candidato', true)): ?>
		
           	<p>Você está inscrito como candidato!</p>
			<p>Confira a sua <a href="<?php bloginfo('siteurl'); ?>/inscricoes">ficha de inscrição</a>.</p>
		
        <?php elseif( !current_user_can( 'level_10' ) ): ?>
            
            <p><?php printf( __('O debate do setorial de %s do %s está com %s comentários', 'historias' ), $user_meta['setorial'], $user_meta['UF'], 'xx' ); ?></p>
            <p><a href="<?php echo site_url('foruns/' . $user_meta['uf-setorial']); ?>">Confira</a></p>
            <p>Você quer se candidatar?</p>
			<p><a href="<?php bloginfo('siteurl'); ?>/inscricoes">Cadastre sua candidatura</a>.</p>
            <p>Link para a discussão do seu estado e setorial:</p>
            <p><a href="<?php echo site_url('foruns/' . $user_meta['uf-setorial']); ?>">Fórum</a></p>
            
		<?php endif; ?>
		
        <?php if ( current_user_can( 'level_10' ) ) : ?>
            <p>Você é um <strong>administrador</strong>. Confira a <a href="<?php bloginfo('siteurl'); ?>/inscricoes">lista de inscritos</a> e veja como andam as <a href="<?php bloginfo('siteurl'); ?>/avaliacoes">avaliações</a>.
            Se quiser mais opções, acesse o <a href="<?php bloginfo( 'url' ); ?>/wp-admin/">Painel</a>.
        <?php elseif ( current_user_can( 'curate' ) ) : ?>
            <p>Você é um <strong>curador</strong>. Acesse a <a href="<?php bloginfo('siteurl'); ?>/inscricoes">lista de inscritos</a> para fazer suas avaliações. Obrigado pela colaboração!
        <?php elseif ( current_user_can( 'publish_posts' ) ) : ?>
            <p>Confira a sua <a href="<?php bloginfo('siteurl'); ?>/inscricoes">ficha de inscrição</a> ou acesse o <a href="<?php bloginfo( 'url' ); ?>/wp-admin/">painel</a> para publicar conteúdo.
        <?php elseif ( current_user_can( 'read' ) ) : ?>
            <!-- <p>Confira a sua <a href="<?php bloginfo('siteurl'); ?>/inscricoes">ficha de inscrição</a>. -->
        <?php endif; ?>
        <p>Para sair, <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout">clique aqui</a>.</p>
    <?php else : ?>
    	
        <div class="login-form">
        <?php wp_login_form(
	        array( 		'label_username' => __( 'Usuário ou email' ),
	        			'label_password' => ('Senha'),
	        			'label_log_in' => ('Entrar'),
	        			'remember' => false ) );
	    ?>
	    
        <a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="lost-password"><?php _e( 'Esqueci a senha', 'historias' ); ?></a>
        
        <a href="<?php bloginfo('siteurl'); ?>/inscricoes" class="button"><?php _e( 'Inscrever-me', 'historias' ); ?></a>
        </div>
    <?php endif;
		
		echo $after_widget;
	}
	
	function CNPC_Widget_Login () {
		parent::WP_Widget(false, $name = __('CNCP Widget Login', 'CNPC_Widget_Login'));
	}
}

add_action ('widgets_init', create_function('', 'return register_widget("CNPC_Widget_Login");'));

?>
