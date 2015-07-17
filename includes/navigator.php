<nav class="access row clearfix js-access" role="navigation"><div class="col-xs-12">
    <?php if ( wp_is_mobile() ) :
        wp_nav_menu( array( 'theme_location' => 'mobile', 'container' => false, 'menu_class' => 'menu--mobile  menu', 'fallback_cb' => false ) );
    else : ?>
        <?php if ( is_user_logged_in() ) : global $user_login; ?>
            <ul id="menu-user" class="menu--user  menu">
                <li class="menu__title"><?php printf( __('Hello, %s!', 'historias' ), $user_login ); ?></li>
                <?php if ( current_user_can( 'level_10' ) ) : ?>
                    <li><a href="<?php bloginfo( 'url' ); ?>/wp-admin/">Painel</a></li>
                    <li><a href="<?php bloginfo('siteurl'); ?>/inscricoes">Inscrições</a></li>
                    <li><a href="<?php bloginfo('siteurl'); ?>/avaliacoes">Avaliações</a></li>
                <?php elseif ( current_user_can( 'curate' ) ) : ?>
                    <li><a href="<?php bloginfo('siteurl'); ?>/inscricoes">Inscrições</a></li>
                <?php elseif ( current_user_can( 'publish_posts' ) ): ?>
                    <li><a href="<?php bloginfo('siteurl'); ?>/inscricoes">Minha Ficha</a></li>
                    <li><a href="<?php bloginfo( 'url' ); ?>/wp-admin/">Painel</a></li>
                <?php elseif ( current_user_can( 'read' ) ) : ?>
                    <li><a href="<?php bloginfo('siteurl'); ?>/inscricoes">Minha Ficha</a></li>
                <?php endif; ?>
                <li><?php wp_loginout(); ?></li>
            </ul>
        <?php else: ?>
        	<ul id="menu-user" class="menu--user  menu">
                <li><a href="<?php bloginfo( 'url' ); ?>/wp-login/">Entrar</a></li>
            </ul>
        <?php endif; ?>

        <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'menu_class' => 'menu--sub  menu', 'fallback_cb' => false ) ); ?>

        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu--main  menu', 'fallback_cb' => 'default_menu' ) ); ?>
    <?php endif; ?>
</div></nav>
