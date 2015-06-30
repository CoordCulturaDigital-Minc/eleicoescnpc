<?php

/**
 * Template Name: Capa/Divulgação
 *
 */

get_header(); the_post(); ?>

    <?php $featured_query = new WP_Query( array( 'post_type'=> 'historias_filmes', 'orderby' => 'menu_order', 'order' => ASC ) );
    if ( $featured_query->have_posts() ) : ?>
        <div class="features  features--promotion  swiper  js-swiper">
            <div class="features-wrap  swiper-wrapper">
                <?php while($featured_query->have_posts()) : $featured_query->the_post(); ?>
                    <article <?php post_class( 'swiper__slide' ); ?>>
                        <?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large' ); ?>
                        <div class="feature__info">
                            <h1 class="entry-title  feature-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                            <?php if( $director = get_post_meta($post->ID,'_meta_director', true) ) : ?>
                                <div class="feature__author"><?php printf( __('By %s', 'historias' ), $director ); ?></div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="swiper__pagination"></div>
        </div>
        <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="features">
                <div class="features-wrap">
                    <?php if ( is_user_logged_in() && current_user_can( 'level_10' ) ) : ?>
                        <p class="no-results"><?php _e( 'There are no films to show! Please add some.', 'historias' ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
    <?php endif; ?>

    <div class="row  cf">
        <div class="box  box--about">
            <h3 class="area-title"><a href="<?php echo get_post_type_archive_link( 'historias_filmes' ); ?>">Filmes selecionados</a></h3>
            <?php if( $text = get_post_meta($post->ID,'_meta_feature-text', true) ) : ?>
                <div><?php echo $text ?></div>
            <?php endif; ?>
        </div>
        <div class="box  box--mostra">
            <?php $mostra_query = new WP_Query( 'pagename=mostra-itinerante' );
            if ( $mostra_query->have_posts() ) : while($mostra_query->have_posts()) : $mostra_query->the_post(); ?>

                <h3 class="area-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <div><?php the_excerpt(); ?></div>

            <?php endwhile; else : ?>
                <?php if ( is_user_logged_in() && current_user_can( 'level_10' ) ) : ?>
                    <p class="no-results"><?php _e( 'Please create a page called "Mostra Itinerante".', 'historias' ); ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <div class="home-box  box  box--news">
            <h3 class="area-title"><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><?php _e( 'Latest News', 'historias' ); ?></a></h3>
            <?php $news_query = new WP_Query( array( 'posts_per_page' => 1 ) );
            while($news_query->have_posts()) : $news_query->the_post(); ?>

                <article <?php post_class(); ?>>
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </article>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>

<?php get_footer(); ?>
