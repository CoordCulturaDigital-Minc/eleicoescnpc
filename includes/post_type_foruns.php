<?php
// Dê um Find Replace (CASE SENSITIVE!) em Foruns pelo nome do seu post type 

class Foruns
{
    const NAME = 'Foruns';
    const MENU_NAME = 'Foruns';

    /**
     * alug do post type: deve conter somente minúscula 
     * @var string
     */
    protected static $post_type;

    static function init()
    {
        // o slug do post type
        self::$post_type = strtolower(__CLASS__);

        add_action('init', array(self::$post_type, 'register'), 0);
        add_action('init', array(self::$post_type, 'create_foruns'), 10);
        add_filter( 'pre_get_posts', array(self::$post_type, 'archive_pre_filter') );
        
    }

    static function register()
    {
        register_post_type(self::$post_type, array(
            'labels' => array(
                'name' => _x(self::NAME, 'post type general name', 'SLUG'),
                'singular_name' => _x('Foruns', 'post type singular name', 'SLUG'),
                'add_new' => _x('Adicionar Novo', 'image', 'SLUG'),
                'add_new_item' => __('Adicionar novo Foruns', 'SLUG'),
                'edit_item' => __('Editar Foruns', 'SLUG'),
                'new_item' => __('Novo Foruns', 'SLUG'),
                'view_item' => __('Ver Foruns', 'SLUG'),
                'search_items' => __('Search Forunss', 'SLUG'),
                'not_found' => __('Nenhum Foruns Encontrado', 'SLUG'),
                'not_found_in_trash' => __('Nenhum Foruns na Lixeira', 'SLUG'),
                'parent_item_colon' => ''
            ),
            'public' => true,
            'rewrite' => array('slug' => 'foruns'),
            'capability_type' => 'post',
            //'hierarchical' => true,
            'menu_position' => 6,
            'has_archive' => true //se precisar de arquivo
            //'taxonomies' => array('taxonomia')
            )
        );
        
        register_taxonomy( 'estado', 'foruns', array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Estados' ),
				'singular_name' => __( 'Estado' ),
				'search_items' => __( 'Search Estados' ),
				'popular_items' => null,
				'all_items' => __( 'All Estados' ),
				'edit_item' => __( 'Edit Estado' ),
				'update_item' => __( 'Update Estado' ),
				'add_new_item' => __( 'Add New Estado' ),
				'new_item_name' => __( 'New Estado Name' ),
			)
		) );
		
		register_taxonomy( 'setorial', 'foruns', array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Setoriais' ),
				'singular_name' => __( 'Setorial' ),
				'search_items' => __( 'Search Setoriais' ),
				'popular_items' => null,
				'all_items' => __( 'All Setoriais' ),
				'edit_item' => __( 'Edit Setorial' ),
				'update_item' => __( 'Update Setorial' ),
				'add_new_item' => __( 'Add New Setorial' ),
				'new_item_name' => __( 'New Setorial Name' ),
			)
		) );
    }
    
    function create_foruns() {
		
		//rodar uma vez só
		if (get_option('foruns_inicializados') !== false)
			return;
			
		update_option('foruns_inicializados', true);
		
		$estados = get_all_states();
		
		$setoriais = get_setoriais();
		
		foreach ($estados as $uf => $estado) {
			
			wp_insert_term($estado, 'estado', array('slug' => $uf));
		
		}
		
		foreach ($setoriais as $slug => $setorial) {
				
			wp_insert_term($setorial, 'setorial', array('slug' => $slug));
				
		}
		
		foreach ($estados as $uf => $estado) {
		
		
			foreach ($setoriais as $slug => $setorial) {
			
			
				$post = array(
					'post_title' => $uf . ' - ' . $setorial,
					'post_name' => $uf . '-' . $slug,
					'post_type' => 'foruns',
					'post_status' => 'publish',
					
				);
				
				$new_post = wp_insert_post($post);
				
				
				wp_set_object_terms( $new_post, $uf, 'estado' );
				wp_set_object_terms( $new_post, $slug, 'setorial' );
			
			}
			
		
		}
		
		
	}
	
	function archive_pre_filter($query) {
		if( is_tax( 'estado' ) || is_tax( 'setorial' ) ) {
			$query->set( 'orderby', 'post_title' );
			$query->set( 'order', 'asc' );
			$query->set( 'posts_per_page', '-1' );
			return $query;
		}
	}
	
	function get_candidates($uf, $setorial) {
		global $wpdb;
		//TODO: query certa
		$ids = $wpdb->get_col(
			"SELECT ID FROM $wpdb->posts WHERE post_type = 'projetos'
			AND post_author IN (
				SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'uf-setorial' AND meta_value = '{$uf}-{$setorial}'
			) AND ID IN (
				SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='subscription-valid'
			)
			
			"
			
		);
		
		if(sizeof($ids) == 0) $ids = array(-9999);
		
		return new WP_Query(array(
			'post__in' => $ids,
			'post_type' => 'projetos',
			'orderby'   => 'rand'
		));
		
	
	}

}
Foruns::init();

