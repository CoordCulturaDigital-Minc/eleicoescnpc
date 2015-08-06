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
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	
	<?php// require_once 'dependencies/jquery.php';?>
	<?php require_once 'dependencies/twitter_bootstrap.php'; ?>
	<?php require_once 'dependencies/font_awesome.php'; ?>

	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?ver=2">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); if( is_page_template( 'page-templates/map.php' ) ) echo 'onLoad="initialize()"'; ?>>

	<?php require_once 'includes/barra_brasil.php'; ?>

	<?php do_action( 'before' ); ?>
	<div class="site-wrap">

		<header id="header" class="clearfix row">
			<a href="#main" title="<?php esc_attr_e( 'Skip to content', 'historias' ); ?>" class="assistive-text"><?php _e( 'Skip to content', 'historias' ); ?></a>
			
			<div class="col-md-8 col-xs-12">
				<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
		            <img src="<?php
		                $logo = get_theme_mod('site_logo');
		                
		                if ($logo != ''):
		                	echo esc_url($logo);
		                else :
		                	echo get_template_directory_uri() . '/images/template_header.png';
		                endif;
		            ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" />	

		                <h1 class="site-title"><?php bloginfo('name'); ?><br>
		                <small>Conselho Nacional de Política Cultural<?php echo get_option( 'site_tagline' ) ?></small></h1>
		        </a>
		    </div>
	        
			<div class="col-md-4 col-xs-12">
			<div class="contact">
				<a href="<?php bloginfo('url'); ?>/fale-conosco">Fale Conosco <i class="fa fa-envelope"></i></a>
			</div>
			<form id="search" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
	            <input id="s" type="search" value="Procurar por" name="s" onfocus="if (this.value == 'Procurar por') this.value = '';" onblur="if (this.value == '') {this.value = 'Procurar por';}" />        
	            <button type="submit" value="Buscar" >
	                <i class="fa fa-search"></i>
	            </button>
	        </form>
			</div>
	    </header><!-- /site-header -->  
	
	<?php require_once 'includes/navigator.php'; ?>
	    
		<?php if( !is_page() ) : ?>
			<?php $featured_posts = new WP_Query( array( 'ignore_sticky_posts' => 1, 'meta_key' => '_post2home', 'meta_value' => 1, 'posts_per_page' => '4' ) );
			if ( $featured_posts->have_posts() ) : ?>
				<div class="featured-posts clearfix">
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
		
		
