<?php
get_header();
get_sidebar();
the_post(); ?>

	<section class="col-xs-12 col-md-8">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<header>
				<h2 class="entry-title"><?php the_title(); ?></h2>
			</header>
			
			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'historias' ) . '&after=</div>') ?>
			</div><!-- /entry-content -->
			
		</article><!-- /page-<?php the_ID(); ?> -->

		<?php comments_template('', true); ?>
	</section><!-- /content -->

<?php get_footer(); ?>
