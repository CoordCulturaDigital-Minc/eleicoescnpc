<?php get_header(); ?>

	<section class="content">

	    <?php if ( have_posts() ) : ?>

	        <?php while ( have_posts() ) : the_post(); ?>
	        	<header>
		        	<h2 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php printf( __('Read, comment and share &ldquo;%s&rdquo;', 'historias'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
							<?php the_title(); ?>
						</a>
					</h2>
				</header>

	        <?php endwhile; ?>

	    <?php endif; ?>

		<?php historias_content_nav( 'nav-below' ); ?>
	</section><!-- /content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
