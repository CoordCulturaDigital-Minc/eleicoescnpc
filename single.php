<?php
/**
 * The Template for displaying all single posts.
 *
 * @package forunssetoriaiscnpc
 *
 */

get_header();
get_sidebar(); ?>

		<section class="col-xs-12 col-md-8">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>

			<?php historias_content_nav( 'nav-below' ); ?>

		</section><!-- #content .site-content --><!-- #primary .content-area -->

<?php get_footer(); ?>
