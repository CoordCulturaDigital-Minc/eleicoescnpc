<?php 

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

// SIDEBARS
if(function_exists('register_sidebar')) {
    // sidebar 
    register_sidebar( array(
        'name' =>  'Home conteúdo',       
        'description' => __('Coluna esquerda na página inicial', 'consulta'),
        'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="subtitulo">',
        'after_title' => '</h3>',
    ) );
    
}

 
add_action('customize_register', 'wp_consulta_customize_register');
function wp_consulta_customize_register($wp_customize){
    
    $wp_customize->add_section('wp_consulta_publica_logo_section', array(
        'title'    => __('Logo', 'wp_consulta_publica'),
        'description' => '',
        'priority' => 40,
    ));

    $wp_customize->add_setting('wp_consulta_publica_logo]', array(
        'capability'        => 'edit_theme_options',
        'type'           => 'theme_mod',
        'default'		=> '',
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'wp_consulta_publica_logo', array(
        'label'    => __('Imagem da logo', 'wp_consulta_publica'),
        'section'  => 'wp_consulta_publica_logo_section',
        'settings' => 'wp_consulta_publica_logo',
    )));
 
}

function admin_bar() {
    remove_all_filters( 'show_admin_bar' );
    add_action('wp_footer','wp_admin_bar_render',1000);
}
add_action('init', 'admin_bar');


