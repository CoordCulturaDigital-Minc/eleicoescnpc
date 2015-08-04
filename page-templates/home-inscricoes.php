<?php

/**
 * Template Name: Capa/Inscrições
 *
 */
    
get_header();
the_post(); ?>

    <section class="features col-xs-12">
        <?php if ( '' != get_the_post_thumbnail() ) : ?>
            <?php if( $featureurl = get_post_meta($post->ID,'_meta_feature-url', true) ) : ?>
                <a href="<?php echo $featureurl ?>">
            <?php endif; ?>
            
            <header class="col-xs-12">
				<?php if( $status = get_post_meta( $post->ID,'_meta_feature-text', true ) ) : ?>
                    <h1><?php the_title(); ?></h1>
                <?php endif; ?>
                <?php if( $status = get_post_meta( $post->ID,'_meta_feature-text', true ) ) : ?>
                    <p><?php echo $status ?></p>
                <?php endif; ?>
            	<h1>Alguma coisa</h1>
				<p>Alguma coisa</p>
            </header>
			<div class="img-wrap img-responsive">
            <?php the_post_thumbnail( 'full' ); ?>  <!-- array('class' => 'img-responsive') -->
			</div>
        
            <?php if( $featureurl = get_post_meta($post->ID,'_meta_feature-url', true) ) : ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    </section>
	
	<?php get_sidebar(); ?>
	
    <section class="col-xs-12 col-md-8">

        <?php 
        
        $paged = (get_query_var('page')) ? get_query_var('page') : 1;

        $args = array(
            'posts_per_page' => 6,
            'orderby'=> 'date',
            'order' => 'DESC',
            'paged' => $paged
        );

        // the query
        $the_query = new WP_Query(  $args ); 
        ?>

        <?php if ( $the_query->have_posts() ) : ?>

        <?php while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
            <?php get_template_part( 'content', false ); ?>
        <?php endwhile; ?>

        

        <div class="section-foot">
            <div class="pagination alignright">
                <?php if( function_exists( 'wp_pagenavi' ) ) : ?>
                    <?php wp_pagenavi( array( 'query' => $the_query ) );?>
                <?php else : ?>
                    <?php
                        // next_posts_link() usage with max_num_pages
                        next_posts_link( 'Older Entries', $the_query->max_num_pages );
                        previous_posts_link( 'Newer Entries',  $the_query->max_num_pages );
                    ?>
                <?php endif; ?>
            </div>
        </div>

        <?php  wp_reset_postdata();  ?>

        <?php else:  ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif; ?>

    </section>
     
<?php get_footer(); ?>
