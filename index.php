<?php get_header(); ?>

	<div class="content">

	    <?php if ( have_posts() ) : ?>

	        <?php while ( have_posts() ) : the_post(); ?>

	        	<?php get_template_part( 'content', get_post_format() ); ?>

	        <?php endwhile; ?>

	    <?php endif; ?>

		<?php historias_content_nav( 'nav-below' ); ?>
	</div><!-- /content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
