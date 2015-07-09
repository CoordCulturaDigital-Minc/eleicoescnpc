<?php 
	/* Template Name: Mapa setoriais */
?>
<?php get_header(); the_post(); ?>

	<div class="content  content--sidebarless">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="hentry-wrap">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="entry-content">
					<?php include('includes/mapa.php') ?>
				</div><!-- /entry-content -->
			</div>
		</article><!-- /page-<?php the_ID(); ?> -->

		<?php comments_template('', true); ?>
	</div><!-- /content -->

<?php get_footer(); ?>