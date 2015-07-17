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
	
	<?php require_once 'dependencies/jquery.php';?>
	<?php require_once 'dependencies/twitter_bootstrap.php'; ?>
	<?php require_once 'dependencies/font_awesome.php'; ?>

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
	<div class="header-wrap">
	<header class="clearfix row">
		<a href="#main" title="<?php esc_attr_e( 'Skip to content', 'historias' ); ?>" class="assistive-text"><?php _e( 'Skip to content', 'historias' ); ?></a>
		
		<a class="col-xs-2" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
            <img src="<?php
                $logo = get_theme_mod('site_logo');
                
                if ($logo != ''):
                	echo esc_url($logo);
                else :
                	echo get_template_directory_uri() . '/images/clear_cnpc_logo.svg';
                endif;
            ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" />	
		</a>
		
	    <a class="col-xs-6" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
                <h1 class="site-title"><?php bloginfo('name'); ?><br>
                <small>Conselho Nacional de Política Cultural<?php echo get_option( 'site_tagline' ) ?></small></h1>
        </a>
        
		<div class="col-xs-4">
		<form id="search" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
            <input id="s" type="search" value="Procurar por" name="s" onfocus="if (this.value == 'Procurar por') this.value = '';" onblur="if (this.value == '') {this.value = 'Procurar por';}" />        
            <button type="submit" value="Buscar" class="btn btn-success">
                <i class="fa fa-search"></i>
            </button>
        </form>
		</div>
    </header><!-- /site-header -->
    
    <?php require_once 'includes/navigator.php'; ?>
    
    </div>
    
    <div class="site-wrap">

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
