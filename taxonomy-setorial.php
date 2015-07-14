<?php get_header(); ?>
	<section class="content">
		<article id="<?php echo get_query_var('term'); ?>">
			<div class="hentry-wrap">
				<h1 class="entry-title"><?php single_term_title('Selecione o estado da Setorial de '); ?></h1>
				<div class="entry-content">
					<?php include( get_template_directory() . '/includes/mapa.php' ) ?>
				</div><!-- /entry-content -->
				<a href="<?php echo site_url(); ?>" id="term_link" class="hidden"></a>
			</div>
		</article><!-- /page-<?php the_ID(); ?> -->
	</section><!-- /content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
