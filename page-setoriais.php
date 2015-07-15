<?php 
	/* Template Name: Mapa setoriais */
?>
<?php get_header(); the_post(); ?>

	<section class="content content--sidebarless">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="hentry-wrap">
				<h2 class="entry-title"><?php the_title(); ?></h2>
				<div class="entry-content">
					<?php include( get_template_directory() . '/includes/mapa.php' ) ?>
				</div><!-- /entry-content -->
			</div>
		</article><!-- /page-<?php the_ID(); ?> -->

	</section><!-- /content -->

<?php get_footer(); ?>
