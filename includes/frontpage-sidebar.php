<div class="asides">
<!-- widget widget--negative widget_categories -->

<aside class="widget">
	<?php if ( is_user_logged_in() ) : global $user_ID; ?>
        <?php $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_ID ) ); ?>
        <h3 class="widget__title"><?php printf( __('Hello, %s!', 'historias' ), $user_meta['nickname']); ?></h2>
    <?php else : ?>
        <h3 class="widget__title">Login/Inscrição</h2>
    <?php endif; ?>
	
    <?php if ( is_user_logged_in() ) : ?>

		<?php if (get_user_meta($user_ID, 'e_candidato', true)): ?>
           	Você está inscrito como candidato!<br>
			<p>Confira a sua <a href="<?php bloginfo('siteurl'); ?>/inscricoes">ficha de inscrição</a>.
		
        <?php elseif( !current_user_can( 'level_10' ) ): ?>
            <p><?php printf( __('O debate do setorial de %s do %s está com %s comentários', 'historias' ), $user_meta['setorial'], $user_meta['UF'], 'xx' ); ?><br>

            <a href="<?php echo site_url('foruns/' . $user_meta['uf-setorial']); ?>">Confira</a></p>
            <p>Você quer se candidatar?<br>
			<a href="<?php bloginfo('siteurl'); ?>/inscricoes">Cadastre sua candidatura</a>.

            <p>Link para a discussão do seu estado e setorial:
            <a href="<?php echo site_url('foruns/' . $user_meta['uf-setorial']); ?>">Fórum</a></p>

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
        <?php wp_login_form( array( 'label_username' => __( 'Login / Email' ), 'remember' => false ) ); ?>
        <a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="lost-password"><?php _e( 'Lost Password', 'historias' ); ?></a>
        <a href="<?php bloginfo('siteurl'); ?>/inscricoes" class="button  not-registered"><?php _e( 'I am not registered yet', 'historias' ); ?></a>
    <?php endif; ?>
</aside>

<?php if ( is_active_sidebar( 'primary-widget-area' ) )
	dynamic_sidebar( 'primary-widget-area' );
?>

</div>
