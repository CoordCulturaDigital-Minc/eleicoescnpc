<?php
// Dê um Find Replace (CASE SENSITIVE!) em Projetos pelo nome do seu post type 

class Projetos
{
    const NAME = 'Projetos';
    const MENU_NAME = 'Projetos';

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

    }

    static function register()
    {
        register_post_type(self::$post_type, array(
            'labels' => array(
                'name' => _x(self::NAME, 'post type general name', 'SLUG'),
                'singular_name' => _x('Projetos', 'post type singular name', 'SLUG'),
                'add_new' => _x('Adicionar Novo', 'image', 'SLUG'),
                'add_new_item' => __('Adicionar novo Projetos', 'SLUG'),
                'edit_item' => __('Editar Projetos', 'SLUG'),
                'new_item' => __('Novo Projetos', 'SLUG'),
                'view_item' => __('Ver Projetos', 'SLUG'),
                'search_items' => __('Search Projetoss', 'SLUG'),
                'not_found' => __('Nenhum Projetos Encontrado', 'SLUG'),
                'not_found_in_trash' => __('Nenhum Projetos na Lixeira', 'SLUG'),
                'parent_item_colon' => ''
            ),
            'publicly_queriable' => true,
            'show_ui' => false,
            'show_in_nav_menus' => true,
            'exclude_from_search' => true,
            //'rewrite' => array('slug' => 'Projetos'),
            'capability_type' => 'post',
            'hierarchical' => true,
            'map_meta_cap ' => true,
            'menu_position' => 6,
            'supports' => array( 'title', 'custom-fields' ),
            'has_archive' => false //se precisar de arquivo
            //'taxonomies' => array('taxonomia')
            )
        );
    }


}
Projetos::init();
