<nav class="col-xs-12 access clearfix js-access" role="navigation">        
    <?php if ( wp_is_mobile() ) :
        wp_nav_menu( array( 'theme_location' => 'mobile', 'container' => false, 'menu_class' => 'menu--mobile  menu', 'fallback_cb' => false ) );
    else : ?>
        <ul id="menu-user" class="menu--user  menu">
            <?php if ( is_user_logged_in() ) : global $user_ID ?>
                    
                    <li class="menu__title"><?php printf( __('Hello, %s!', 'historias' ), user_short_name() ); ?></li>
                    <?php if ( current_user_can( 'level_10' ) ) : ?>
                       
                        <li><a href="<?php bloginfo( 'url' ); ?>/wp-admin/">Painel</a></li>
                        <li><a href="<?php bloginfo('url'); ?>/inscricoes">Inscrições</a></li>
                        <!-- <li><a href="<?php bloginfo('url'); ?>/avaliacoes">Avaliações</a></li> -->
                    <?php elseif ( current_user_can( 'curate' ) ) : ?>
                        
                        <li><a href="<?php bloginfo('url'); ?>/avaliacoes">Avaliações</a></li>
                    
                    <?php elseif ( current_user_can( 'read' ) ): ?>
                        <li><a href="<?php echo get_link_forum_user(); ?>">Meu fórum</a></li>
                        
                        <?php if (get_user_meta($user_ID, 'e_candidato', true)): ?> 
                            <li><a href="<?php bloginfo('url'); ?>/inscricoes">Minha Inscrição</a></li>
                        <?php else: ?>
                             <?php if( registration_is_open() ) : ?>
                                <li><a href="<?php bloginfo('url'); ?>/inscricoes">Quero me candidatar</a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                            
                    <?php endif; ?>
                    <li><?php wp_loginout(home_url()); ?></li>
            <?php else: ?>
                    <li class="visible-xs-block"><a id="login" href="#">Entrar</a></li>
                    <?php if( registration_is_open() ) : ?>
                        <li><a href="<?php bloginfo('url'); ?>/inscricoes">Inscreva-se</a></li>
                    <?php endif; ?>
            <?php endif; ?>
            
        </ul>

         <div class="login-form-menu">
            <?php wp_login_form(
                array(      'label_username' => __( 'E-mail' ),
                            'label_password' => ('Senha'),
                            'label_log_in' => ('Entrar'),
                            'form_id'        => 'login-menu',
                            'remember' => false ) );
            ?>
            <a href="<?php echo wp_lostpassword_url( $_SERVER['REQUEST_URI'] ); ?>" id="lost-password"><?php _e( 'Esqueci a senha', 'historias' ); ?></a>
        </div>

        <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'menu_class' => 'menu--sub  menu', 'fallback_cb' => false ) ); ?>

        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu--main  menu', 'fallback_cb' => 'default_menu' ) ); ?>
    <?php endif; ?>
</nav>
