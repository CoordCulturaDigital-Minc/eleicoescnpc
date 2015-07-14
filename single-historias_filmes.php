<?php
/**
 * The Template for displaying single movies.
 *
 * @package forunssetoriaiscnpc
 *
 */

get_header(); ?>

	<section class="content  content--sidebarless">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Read, comment and share &ldquo;%s&rdquo;', 'historias'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link( sprintf( __( '%s Edit', 'historias' ), '<i class="fa fa-pencil"></i>' ) ); ?></h2>
					<div class="entry__meta">
						<div>
							Ano de produção <span class="entry__info"><?php the_time( 'Y' ); ?></span>
						</div>

						<?php if( $director = get_post_meta($post->ID,'_meta_director', true) ) : ?>
							De <span class="entry__info"><?php echo $director ?></span>
						<?php endif; ?>

						<?php if( $region = get_post_meta($post->ID,'_meta_region', true) ) : ?>
							(<?php echo $region ?>)
						<?php endif; ?>

						<?php if( $producer = get_post_meta($post->ID,'_meta_producer', true) ) : ?>
							<div>
								<?php if( $producer_url = get_post_meta($post->ID,'_meta_producer_url', true) ) : ?>
									Produtora <a href="<?php echo $producer_url ?>" title="<?php esc_attr_e( 'Visit the producer website', 'historias' ); ?>" class="entry__info"><?php echo $producer ?></a>
								<?php else: ?>
									Produtora <span class="entry__info"><?php echo $producer ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div><!-- /entry__meta -->
				</header><!-- /entry-header -->

				<?php if ( has_excerpt() ) : ?>
					<div class="entry__summary">
						<?php the_excerpt(); ?>
					</div><!-- /entry__sumary -->
				<?php endif; ?>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry__image">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-content cf">
					<?php the_content( __( 'To be continued&hellip;', 'historias' ) ); ?>
					<?php wp_link_pages( 'before=<div class="page-link">' . __( 'Pages:', 'historias' ) . '&after=</div>' ) ?>
				</div><!-- /entry-content -->

				<footer class="entry-footer">
					<?php // historias_share(); ?>
				</footer><!-- /entry-footer -->
			</article><!-- /post-<?php the_ID(); ?> -->

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
			?>

		<?php endwhile; // end of the loop. ?>

		<?php $custom_query = new WP_Query( array( 'post_type'=> 'historias_filmes', 'orderby' => 'menu_order', 'order' => ASC, 'post__not_in' => ( array ( $post->ID ) ) ) );
		if($custom_query->have_posts()) : ?>
			<div class="related">
				<h3 class="area-title"><?php _e( 'Other Selected Movies', 'historias' ); ?></h3>
				<?php while($custom_query->have_posts()) : $custom_query->the_post(); ?>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</section><!-- /content -->

<?php get_footer(); ?>
