<!doctype html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php wp_title( '&mdash;', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta name="viewport" content="width=device-width">
	
	<?php require_once 'includes/jquery.php';?>
	<?php require_once 'includes/twitter_bootstrap.php'; ?>
	<?php require_once 'includes/font_awesome.php'; ?>

	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?ver=2">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); if( is_page_template( 'page-templates/map.php' ) ) echo 'onLoad="initialize()"'; ?>>

    <!-- barra do governo -->
    <div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;"> 
        <ul id="menu-barra-temp" style="list-style:none;">
            <li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED"><a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a></li> 
            <li><a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a></li>
        </ul>
    </div>
    <!-- fim barra do governo -->

	<?php do_action( 'before' ); ?>

	<div class="site-wrap">

	<header class="site_header">
		<a href="#main" title="<?php esc_attr_e( 'Skip to content', 'historias' ); ?>" class="assistive-text"><?php _e( 'Skip to content', 'historias' ); ?></a>

		<div class="branding">
			<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
                <?php
                    $logo = get_theme_mod('site_logo');
                    if ($logo != ''): ?>
                        <img class="custom" src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" />
                        <h1 class="site-title"><?php bloginfo('name'); ?></h1>			

		                <div class="quote">
		                    <p><?php echo get_option( 'site_tagline' ) ?></p>
		                </div>
                    <?php else : ?>
                    	<img class="template-preset" src="<?php echo get_template_directory_uri() . '/assets/cabecalho.svg'; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" />
                <?php endif; ?>
            </a>

			<form id="search" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
	            <input id="s" type="search" value="Procurar por" name="s" onfocus="if (this.value == 'Procurar por') this.value = '';" onblur="if (this.value == '') {this.value = 'Procurar por';}" />        
	            <input type="submit" value="Buscar" />
	        </form>
		</div>
		
        <nav class="access cf js-access" role="navigation">
            <?php if ( wp_is_mobile() ) :
                wp_nav_menu( array( 'theme_location' => 'mobile', 'container' => false, 'menu_class' => 'menu--mobile  menu', 'fallback_cb' => false ) );
            else : ?>
                <?php if ( is_user_logged_in() ) : global $user_login; ?>
                    <ul id="menu-user" class="menu--user  menu  cf">
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
                        <li><?php wp_loginout( get_permalink() ); ?></li>
                    </ul>    
                <?php endif; ?>
                

                <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'menu_class' => 'menu--sub  menu  cf', 'fallback_cb' => false ) ); ?>

                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu--main  menu  cf', 'fallback_cb' => 'default_menu' ) ); ?>
            <?php endif; ?>
        </nav>
    </header><!-- /site-header -->

	<div id="main" class="wrap cf">
		<?php if( !is_page() ) : ?>
			<?php $featured_posts = new WP_Query( array( 'ignore_sticky_posts' => 1, 'meta_key' => '_post2home', 'meta_value' => 1, 'posts_per_page' => '4' ) );
			if ( $featured_posts->have_posts() ) : ?>
				<div class="featured-posts  cf">
					<?php while($featured_posts->have_posts()) : $featured_posts->the_post(); ?>
						<article <?php post_class(); ?>>
							<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'medium' ); ?>
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						</article>
					<?php endwhile; ?>
				</div><!-- /featured-posts -->
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
