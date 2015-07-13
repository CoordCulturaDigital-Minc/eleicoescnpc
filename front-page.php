<?php

/**
 * Template Name: Capa/Inscrições
 *
 */
    
get_header(); the_post(); ?>

        <div class="features  features--subscriptions">
            <?php if ( '' != get_the_post_thumbnail() ) : ?>
                <div class="featured__image">
                    <?php if( $featureurl = get_post_meta($post->ID,'_meta_feature-url', true) ) : ?>
                        <a href="<?php echo $featureurl ?>">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </a>
                    <?php else : ?>
                        <?php the_post_thumbnail( 'large' ); ?>
                    <?php endif; ?>
                </div>
                <?php if( $status = get_post_meta( $post->ID,'_meta_feature-text', true ) ) : ?>
                    <p class="feature__status"><?php echo $status ?></p>
                <?php endif; ?>
            <?php //else : ?>
                <?php //if ( is_user_logged_in() && current_user_can( 'level_10' ) ) : ?>
                    <!-- <p class="no-results"><?php _e( 'Please set a Thumbnail Image for this page.', 'historias' ); ?></p> -->
                <?php //endif; ?>
            <?php endif; ?>
        </div>

        <?php get_sidebar(); ?>

        <?php 
	        
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array(
                'posts_per_page' => 10,
                'orderby'=> 'date',
                'order' => 'DESC',
                'paged' => $paged
            );

            
            $query = new WP_Query( $args ); ?>

            <section class="content">

                <?php if ( $query->have_posts() ) : ?>

                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                        <?php get_template_part( 'content', false ); ?>

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>
                    
                <?php endif; ?>

                <?php historias_content_nav( 'nav-below' ); ?>
            </section>


<?php get_footer(); ?>
