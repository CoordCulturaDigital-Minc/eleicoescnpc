<?php 

function historias_contextual_help() {
    global $post_ID;
    
    $screen = get_current_screen();
    
    // Get the Front Page's ID
    $front_page_id = get_option( 'page_on_front' );
    
    if( $post_ID == $front_page_id ) :

        $screen->add_help_tab( array(
            'id' => 'historias_front_page_templates',
            'title' => __( 'Front Page Templates', 'historias' ),
            'content' => implode( '', file( get_template_directory() . '/help/front-page-templates.htm' ) ),
        ));

    endif;
}
add_action('admin_head', 'historias_contextual_help');
?>
