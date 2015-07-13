<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( is_search() || is_home() || is_front_page() ) : ?>
				<header>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Read, comment and share &ldquo;%s&rdquo;', 'historias'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<?php historias_the_time(); ?>
					<?php historias_the_format(); ?>
					<?php edit_post_link( sprintf( __( '%s Edit', 'historias' ), '<i class="fa fa-pencil"></i>' ) ); ?>
				</header>
				
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="featured-media">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('thumbnail'); ?></a>		
					</div>
				<?php endif;?>
				
				<?php the_excerpt(); ?>
				
				<p class="read-more"><a href="<?php the_permalink(); ?>">Leia mais ></a></p>
	<?php else : ?>

		<div class="entry-content">
			<?php the_content( __( 'To be continued&hellip;', 'historias' ) ); ?>
			<?php wp_link_pages( 'before=<div class="page-link">' . __( 'Pages:', 'historias' ) . '&after=</div>' ) ?>
		</div><!-- /entry-content -->

	<?php endif; ?>

	<footer class="entry-footer">
		
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'historias' ) );
				if ( $categories_list && historias_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'historias' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php if( get_the_tag_list() )
				echo get_the_tag_list('<span class="entry-tags"><i class="fa fa-tag"> ',', ','</i></span><!-- /entry-tags -->');
			?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if( !is_search() && !is_home() && !is_front_page() ) : ?>
			<?php historias_share(); ?>
		<?php endif; ?>
	</footer><!-- /entry-footer -->

</article><!-- /post-<?php the_ID(); ?> -->
