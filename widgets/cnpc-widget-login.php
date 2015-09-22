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
	
	function widget ( $args, $instance ) {

		extract( $args );
		
		print $before_widget;
		
		if ( is_user_logged_in() ) { 

            global $user_ID; 

            $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_ID ) );
            
            
            printf( '<h3 class="widget__title">' . __('Olá, %s!', 'historias' ) . '</h3>', user_short_name());

        } else {
            if( !empty( $instance[ 'title' ] ) )
            {
                // print $before_head;
                print $before_title . $instance[ 'title' ] . $after_title;
                // print $after_head;
            }
        }
        echo '<div class="widget-body">';

           if ( is_user_logged_in() ) : global $user_login; ?>

                <ul id="menu-user" class="menu--user menu">


                    <?php if ( current_user_can( 'level_10' ) ) : //admin ?>
                       
                        <li><i class="fa fa-cog"></i> <a href="<?php bloginfo( 'url' ); ?>/wp-admin/">Painel</a></li>
                        <li><i class="fa fa-pencil-square-o"></i> <a href="<?php bloginfo('url'); ?>/inscricoes">Inscrições</a></li>
                        <li><i class="fa fa-check-square-o"></i> <a href="<?php bloginfo('url'); ?>/avaliacoes">Avaliações</a></li>
                    
                    <?php elseif ( current_user_can( 'curate' ) ) : //curador ou avaliador ?>
                        
                        <li><i class="fa fa-pencil-square-o"></i> <a href="<?php bloginfo('url'); ?>/inscricoes">Inscrições</a></li>
                    
                    <?php elseif ( current_user_can( 'publish_posts' ) ): //editor do site ?>
                        
                        <li><i class="fa fa-pencil-square-o"></i> <a href="<?php bloginfo('url'); ?>/inscricoes">Minha Ficha</a></li>
                        <li><i class="fa fa-cog"></i> <a href="<?php bloginfo( 'url' ); ?>/wp-admin/">Painel</a></li>
                    
                    <?php elseif ( current_user_can( 'read' ) ) : //eleitor ?>
                        <li><i class="fa fa-comments"></i> <a href="<?php echo get_link_forum_user(); ?>">Meu fórum</a></li>
                      
                        <?php if (get_user_meta($user_ID, 'e_candidato', true)): ?> 
                            <li><i class="fa fa-pencil-square-o"></i> <a href="<?php bloginfo('url'); ?>/inscricoes">Minha ficha de inscrição</a></li>
                        <?php else: ?>
                            <?php if( registration_is_open() ) : ?>
                                <li><i class="fa fa-pencil-square-o"></i> <a href="<?php bloginfo('url'); ?>/inscricoes">Quero me candidatar!</a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li><i class="fa fa-user"></i> <a href="<?php bloginfo('url'); ?>/wp-admin/profile.php">Meu perfil</a></li>
                    <li><i class="fa fa-sign-out"></i> <?php wp_loginout( get_permalink() ); ?></li>
                </ul>

            <?php else : ?>
            	
                <div class="login-form">
                <?php wp_login_form(
        	        array( 		'label_username' => __( 'E-mail ' ),
        	        			'label_password' => ('Senha'),
        	        			'label_log_in' => ('Entrar'),
        	        			'remember' => false ) );
        	    ?>
                <a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" id="lost-password"><?php _e( 'Esqueci a senha', 'historias' ); ?></a>
                 <?php if( registration_is_open() ) : ?>
                    <a href="<?php bloginfo('url'); ?>/inscricoes" id="registrar" class="button"><?php _e( 'Inscrever-me', 'historias' ); ?></a>
                <?php endif; ?>
                </div>
            <?php endif;
        echo '</div>';
		
		echo $after_widget;
	}

    
    function update ( $new_instance, $old_instance ) {

        $instance = $old_instance;
        
        if( $instance != $new_instance )
        {
            $instance = $new_instance;
        }
        return $instance;
    }

    function form ( $instance ) {
        $defaults = array(
            'title' => __( 'Entrar', 'historias' ),
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        $title = strip_tags( $instance['title'] );

        ?>
            <p>
                <label for="<?php print $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?>:</label>
                <input type="text" class="widefat" id="<?php print $this->get_field_id('title'); ?>" name="<?php print $this->get_field_name('title'); ?>" value="<?php print esc_attr( $title ); ?>"/></br>
            </p>

        <?php
    }

	function CNPC_Widget_Login () {
		parent::WP_Widget(false, $name = __('CNCP Widget Login', 'historias'));
	}
}

add_action ('widgets_init', create_function('', 'return register_widget("CNPC_Widget_Login");'));

?>
