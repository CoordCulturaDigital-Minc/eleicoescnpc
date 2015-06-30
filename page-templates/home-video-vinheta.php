<?php

/**
 * Template Name: Capa - Video Vinheta
 *
 */

get_header(); the_post(); ?>

        <div class="features  features--subscriptions">
            <iframe src="//player.vimeo.com/video/121276220?title=0&amp;byline=0&amp;portrait=0" width="699" height="393" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        </div>

        <div class="asides">
            <div class="home-box  box--sidebarless  box--howto">
                <?php the_content(); ?>
            </div>

            <div class="home-box  box--sidebarless  box--user">
                <?php if ( is_user_logged_in() ) : ?>
                    <h2 class="area-title"><?php printf( __('Hello, %s!', 'historias' ), $user_login ); ?></h2>
                    <?php if ( current_user_can( 'level_10' ) ) : ?>
                        <p>Você é um <strong>administrador</strong>. Confira a <a href="<?php bloginfo('siteurl'); ?>/inscricoes">lista de inscritos</a> e veja como andam as <a href="<?php bloginfo('siteurl'); ?>/avaliacoes">avaliações</a>.
                        Se quiser mais opções, acesse o <a href="<?php bloginfo( 'url' ); ?>/wp-admin/">Painel</a>.
                    <?php elseif ( current_user_can( 'curate' ) ) : ?>
                        <p>Você é um <strong>curador</strong>. Acesse a <a href="<?php bloginfo('siteurl'); ?>/inscricoes">lista de inscritos</a> para fazer suas avaliações. Obrigado pela colaboração!
                    <?php elseif ( current_user_can( 'publish_posts' ) ) : ?>
                        <p>Confira a sua <a href="<?php bloginfo('siteurl'); ?>/inscricoes">ficha de inscrição</a> ou acesse o <a href="<?php bloginfo( 'url' ); ?>/wp-admin/">painel</a> para publicar conteúdo.
                    <?php elseif ( current_user_can( 'read' ) ) : ?>
                        <p>Confira a sua <a href="<?php bloginfo('siteurl'); ?>/inscricoes">ficha de inscrição</a>.
                    <?php endif; ?>
                    <p>Para sair, <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout">clique aqui</a>.</p>
                <?php else : ?>
                    <?php wp_login_form( array( 'label_username' => __( 'Login / Email' ), 'remember' => false ) ); ?>
                    <a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="lost-password"><?php _e( 'Lost Password', 'historias' ); ?></a>
                    <a href="<?php bloginfo('siteurl'); ?>/inscricoes" class="button  not-registered"><?php _e( 'I am not registered yet', 'historias' ); ?></a>
                <?php endif; ?>
            </div>
        </div>

<?php get_footer(); ?>
