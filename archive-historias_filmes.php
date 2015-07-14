<?php get_header(); ?>
<section class="content  content--sidebarless  media-container">
	<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'media cf' ); ?>>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="img">
				<?php the_post_thumbnail( 'medium' ); ?>
			</div>
		<?php endif; ?>

		<div class="bd">
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __( 'More about &ldquo;%s&rdquo;', 'historias' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link( sprintf( __( '%s Edit', 'historias' ), '<i class="fa fa-pencil"></i>' ) ); ?></h2>
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
							Produtora <span class="entry__info"><?php echo $producer ?></span>
						</div>
					<?php endif; ?>
				</div><!-- /entry__meta -->
			</header><!-- /entry-header -->

			<?php if ( has_excerpt() ) : ?>
				<div class="entry__summary">
					<?php the_excerpt(); ?>
				</div><!-- /entry-content -->
			<?php endif; ?>
		</div>
	</article><!-- /post-<?php the_ID(); ?> -->
	<?php endwhile; ?>
	<?php endif; ?>

</section><!-- /content -->
<?php get_footer(); ?>
