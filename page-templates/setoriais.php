<?php 
	/* Template Name: Mapa setoriais */
?>
<?php get_header(); the_post(); ?>

	<section class="col-xs-12">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<header>
				<h2 class="entry-title"><?php the_title(); ?></h2>
			</header>
			
			<div class="entry-content">
				<?php include( get_template_directory() . '/includes/mapa.php' ) ?>
			</div><!-- /entry-content -->

		</article><!-- /page-<?php the_ID(); ?> -->

	</section><!-- /content -->

<?php get_footer(); ?>
