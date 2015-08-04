<?php
get_header();
get_sidebar(); ?>

	<section class="col-xs-12 col-md-8">

	    <?php if ( have_posts() ) : ?>

	        <?php while ( have_posts() ) : the_post(); ?>

	        	<?php get_template_part( 'content', 'search' ); ?>

	        <?php endwhile; ?>


			<?php historias_content_nav( 'nav-below' ); ?>

	    <?php else: ?>
	    	<header>
				<h2 class="entry-title">Não encontrado</h2>
			</header>
			
	    	<div class="entry-content">
				<p>Parece que nada foi encontrado. Tente novamente!</p>
				<?php get_search_form(); ?>
			</div>


	   <?php endif; ?>

	</section><!-- /content -->

<?php get_footer(); ?>
