<?php 
	/* Template Name: Full Width */
?>
<?php get_header(); the_post(); ?>

	<section class="content content--sidebarless">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<header>
				<h2 class="entry-title"><?php the_title(); ?></h2>
			</header>
			
			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'historias' ) . '&after=</div>') ?>
			</div><!-- /entry-content -->
			
		</article><!-- /page-<?php the_ID(); ?> -->

	</section><!-- /content -->

<?php get_footer(); ?>
