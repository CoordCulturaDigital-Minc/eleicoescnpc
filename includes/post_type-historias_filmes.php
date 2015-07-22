<?php
/**
 * Custom class for creating & defining a post type
 *
 */
class CustomPostType {

    public static $custom_meta_fields;

    static function init() {

    	$prefix = '_meta_';

	    self::$custom_meta_fields = array(
			array(
				'label'			=> __( 'Director', 'historias' ),
				'description'  	=> '',
				'id'    		=> $prefix . 'director',
				'type'  		=> 'text'
			),
			array(
				'label'			=> __( 'Region', 'historias' ),
				'description'  	=> '',
				'id'    		=> $prefix . 'region',
				'type'  		=> 'text'
			),
			array(
				'label'			=> __( 'Producer','historias' ),
				'description'  	=> '',
				'id'    		=> $prefix . 'producer',
				'type'  		=> 'text'
			),
			array(
				'label'			=> __( 'Producer URL','historias' ),
				'description'  	=> '',
				'id'    		=> $prefix . 'producer_url',
				'type'  		=> 'text'
			)
	    );

        add_action( 'init', array( __CLASS__, 'register' ) );
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
        add_action( 'save_post', array( __CLASS__, 'save_postdata' ) );

    }


    /**
     * Post Type registration
     *
     */
    static function register() {

        $labels = array(
			'name'               => __( 'Movies', 'historias' ),
			'singular_name'      => __( 'Movie', 'historias' ),
			'add_new'            => _x( 'Add New', 'historias_filmes', 'historias' ),
			'add_new_item'       => __( 'Add New Movie', 'historias' ),
			'edit_item'          => __( 'Edit Movie', 'historias' ),
			'new_item'           => __( 'New Movie', 'historias' ),
			'all_items'          => __( 'All Movies', 'historias' ),
			'view_item'          => __( 'View Movie', 'historias' ),
			'search_items'       => __( 'Search Movies', 'historias' ),
			'not_found'          =>  __( 'No Movie Found', 'historias' ),
			'not_found_in_trash' => __( 'No Movie Found in the trash', 'historias' ),
			'menu_name'          => __( 'Movies', 'historias' )
         );

        register_post_type( 'historias_filmes', array(
			'labels'          => $labels,
			'public'          => true,
			'rewrite'         => array( 'slug' => 'filmes' ),
			'capability_type' => 'post',
			'hierarchical'    => true,
			'menu_position'   => 6,
            'menu_icon'       => 'dashicons-video-alt',
			'has_archive'     => true,
			'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' )
        ) );

    }


    /**
     * Post Type meta box
     *
     */
    static function add_meta_box() {

	    add_meta_box(
	        'historias-movie',
	        __( 'About the Movie', 'historias' ),
	        array( __CLASS__,'meta_box_cb' ),
	        'historias_filmes',
	        'side'
	    );

    }


    /**
     * Meta box callback
     *
     */
    static function meta_box_cb( $post ) {

        // Cria o nonce para verificação
        wp_nonce_field( 'save_meta', 'meta_noncename' );


        foreach ( self::$custom_meta_fields as $field ) {

	        // Recebe os metadados
	        $meta_value =  get_post_meta( $post->ID, $field['id'], true );

	        // Cria a estrutura
	        echo '<p><label for="' . $field['id'] . '">' . $field['label'] . ':</label><br/>';

	        switch ( $field['type'] ) {

	        	// Texto
	        	case 'text':
			        echo '<input type="text" id="' . $field['id'] . '" class="widefat" name="' . $field['id'] . '" value="' . esc_attr( $meta_value ) . '" size="25" />';
			    break;

			    // Dropdown
				case 'select':
					echo '<select class="widefat" name="' . $field['id'] . '" id="' . $field['id'] . '">';
					foreach ( $field['options'] as $option ) {
						echo '<option value="' . $option['value'] . '"' , $meta_value == $option['value'] ? ' selected="selected"' : '' , '>' . $option['label'] . '</option>';
					}
					echo '</select>';
				break;

				// Upload
				case 'upload':
					echo '<input type="text" id="' . $field['id'] . '" class="widefat custom-uploader" name="' . $field['id'] . '" value="' . esc_attr( $meta_value ) . '" size="25" />';
					echo '<br/><br/>';
					echo '<a href="#" id="set-default-image" class="custom-uploader-button button thickbox">Fazer upload</a>';
				break;

			}

			if ( $field['description'] )
				echo '<br/><br/><span class="description">' . $field['description'] . '</span>';

			echo '</p>';

        }

    }


    /**
     * Save custom fields
     *
     */
    function save_postdata( $post_id ) {

    	global $post;

    	if ( wp_is_post_revision( $post_id ) )
    		return;

        // Verifica o autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		  return;

		// Não salva o campo caso seja uma revisão
		if ( $post->post_type == 'revision' )
			return;

		// Verifica o nonce
        if ( ! wp_verify_nonce( $_POST['meta_noncename'], 'save_meta' ) )
            return;

        // Permissões
        if ( $post->post_type == 'historias_filmes' )
		{
			if ( ! current_user_can( 'edit_post', $post_id ) )
		    	return;
		}

		foreach ( self::$custom_meta_fields as $field )
		{
			$old = get_post_meta( $post_id, $field['id'], true );
			$new = $_POST[$field['id']];

			if ( $new && $new != $old )
			    update_post_meta( $post_id, $field['id'], $new );
			elseif ( $new == '' && $old )
				delete_post_meta( $post_id, $field['id'], $old );
	    }
    }

}

CustomPostType::init();

/**
 * Filters the query on the post type archive
 *
 */
function historias_archive_order( $query ) {
  if( is_post_type_archive( 'historias_filmes' ) && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'orderby', 'menu_order' );
    $query->set( 'order', 'asc' );
	  return $query;
	}
}
add_filter( 'pre_get_posts', 'historias_archive_order' );


?>
