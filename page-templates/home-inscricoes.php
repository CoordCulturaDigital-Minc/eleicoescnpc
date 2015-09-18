<?php

/**
 * Template Name: Capa/Inscrições
 *
 */

wp_enqueue_script('jquery-flexslider', get_template_directory_uri().'/js/flexslider-min.js', array('jquery'));    
wp_enqueue_script( 'carrossel_home', get_template_directory_uri() . '/js/carrossel_home.js');

get_header();
the_post(); ?>

    <section class="features col-xs-12">
        <?php if ( '' != get_the_post_thumbnail() ) : ?>
            <header class="col-xs-12">
    
            <?php $posts = get_posts(array('category' => 55)); ?>
            <div class="destaques-content">
                <div class="loading">
				    <h2>Carregando...</h2>
                </div>
    
                <div class="destaques">
                <?php foreach ($posts as $post ): ?>
                    <div class="destaque">
    	              <div class="img-responsive">
                          <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0]; ?>">
                      </div>
    				  <div class="destaque-text">
                          <h1><?php echo $post->post_title; ?></h1>
                          <h3><?php echo $post->post_excerpt; ?></h3>
	                  </div>

                    </div>
                <?php endforeach; ?>
                </div> <!-- end destaques -->
                <div class="navigation"></div>
            </div> <!-- end destaques-content -->
            </header>
        
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
