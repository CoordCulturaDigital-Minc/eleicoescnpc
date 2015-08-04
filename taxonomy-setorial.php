<?php get_header(); ?>

	<section class="col-xs-12">

		<article id="<?php echo get_query_var('term'); ?>">
			
			<header>
				<h2 class="entry-title"><?php single_term_title('Selecione o estado da Setorial de '); ?></h2>
			</header>
			
			<div class="entry-content">
				<?php include( get_template_directory() . '/includes/mapa.php' ) ?>
			
			</div><!-- /entry-content -->
		
			<a href="<?php echo site_url(); ?>" id="term_link" class="hidden"></a>
			
		</article><!-- /page-<?php the_ID(); ?> -->
	
	</section><!-- /content -->

<?php get_footer(); ?>
