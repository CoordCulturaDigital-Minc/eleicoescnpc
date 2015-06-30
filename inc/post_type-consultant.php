<?php


/**
 * Register the consultant post type
 */
add_action( 'init', 'register_consultant' );
function register_consultant() {
    $labels = array(
        'name'               => __( 'Consultants', 'historias' ),
        'singular_name'      => __( 'Consultant', 'historias' ),
        'add_new'            => _x( 'Add New', 'Consultant', 'historias' ),
        'add_new_item'       => __( 'Add New Consultant', 'historias' ),
        'edit_item'          => __( 'Edit Consultant', 'historias' ),
        'new_item'           => __( 'New Consultant', 'historias' ),
        'all_items'          => __( 'All Consultants', 'historias' ),
        'view_item'          => __( 'View Consultant', 'historias' ),
        'search_items'       => __( 'Search Consultants', 'historias' ),
        'not_found'          => __( 'No Consultant Found', 'historias' ),
        'not_found_in_trash' => __( 'No Consultant Found in the trash', 'historias' ),
        'menu_name'          => __( 'Consultants', 'historias' )
     );

    register_post_type( 'consultant', array(
        'labels'          => $labels,
        'public'          => true,
        'capability_type' => 'post',
        'hierarchical'    => false,
        'menu_position'   => 20,
        'menu_icon'       => 'dashicons-nametag',
        'publicly_queryable' => false,
        'show_in_nav_menus' => false,
        'show_in_admin_bar' => false,
        'supports'        => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
    ) );
}

/**
 * Shortcode to list consultants
 *
 */
function historias_consultants_shortcode( $atts ) {
    ob_start();

    extract( shortcode_atts( array (
        'type' => 'consultant',
        'order' => 'ASC',
        'orderby' => 'title',
        'posts' => -1,
    ), $atts ) );

    $options = array(
        'post_type' => $type,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts,
    );

    $query = new WP_Query( $options );
    if ( $query->have_posts() ) { ?>
        <div class="media-container">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php post_class('media'); ?>>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="img">
                        <?php $thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' ); ?>
                        <div class="consultant__avatar" style="background-image:url(<?php echo $thumbnail_url[0] ?>)">
                        </div>
                    </div>
                <?php endif ?>
                <div class="bd">
                    <h3 class="consultant__name"><?php the_title(); ?></h3>
                    <?php the_content(); ?>
                    <?php edit_post_link( sprintf( __( '%s Edit', 'historias' ), '<i class="fa fa-pencil"></i>' ) ); ?>
                </div>
            </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}
add_shortcode( 'list-consultants', 'historias_consultants_shortcode' );


?>
