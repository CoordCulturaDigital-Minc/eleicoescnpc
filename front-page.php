<?php

/**
 * Template Name: Capa/Inscrições
 *
 */
    
get_header(); the_post(); ?>

        <div class="features  features--subscriptions">
             
            <?php if ( '' != get_the_post_thumbnail() ) : ?>
                <?php if( $featureurl = get_post_meta($post->ID,'_meta_feature-url', true) ) : ?>
                    <a href="<?php echo $featureurl ?>">
                <?php endif; ?>

                    <div class="featured__image">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                    <?php if( $status = get_post_meta( $post->ID,'_meta_feature-text', true ) ) : ?>
                        <h1 class="feature__title"><?php the_title(); ?></h1>
                    <?php endif; ?>
                    <?php if( $status = get_post_meta( $post->ID,'_meta_feature-text', true ) ) : ?>
                        <p class="feature__status"><?php echo $status ?></p>
                    <?php endif; ?>
            
                <?php if( $featureurl = get_post_meta($post->ID,'_meta_feature-url', true) ) : ?>
                    </a>
                <?php endif; ?>
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
