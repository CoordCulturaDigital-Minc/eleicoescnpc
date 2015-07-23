<?php

session_start();

if ( ! isset( $content_width ) )
	$content_width = 1000;

add_action( 'after_setup_theme', 'historias_setup' );
function historias_setup() {

	/**
	 * Handle the custom post types
	 */
	//require_once( get_template_directory() . '/includes/post_type-historias_filmes.php' );
    require_once( get_template_directory() . '/includes/post_type_projetos.php' );
    //require_once( get_template_directory() . '/includes/post_type-consultant.php' );
    require_once( get_template_directory() . '/includes/post_type_foruns.php' );

	/**
	 * We need these for the inscricoes
	 */
    require_once( get_template_directory() . '/includes/theme-options.php' );
	require_once( get_template_directory() . '/inscricoes-functions.php' );
	require_once( get_template_directory() . '/vote-functions.php' );
	require_once( get_template_directory() . '/includes/shame.php' );
    require_once( get_template_directory() . '/includes/customizr.php' );
    require_once( get_template_directory() . '/includes/contextual-help.php' );
	require_once( get_template_directory() . '/includes/post2home/post2home.php' );
	require_once( get_template_directory() . '/includes/estatisticas-inscricoes.php' );
	// require_once( get_template_directory() . '/includes/admin-cpfs-cnpjs.php' );

	// widgets
	require_once( get_template_directory() . '/widgets/cnpc-widget-custom-page.php' );
	require_once( get_template_directory() . '/widgets/cnpc-widget-setoriais-menu.php' );
	require_once( get_template_directory() . '/widgets/cnpc-widget-login.php' );
	


	// torna o tema traduzível
	load_theme_textdomain( 'historias', get_template_directory() . '/languages' );


	// os arquivos de tradução ficam na pasta /languages/
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );


	// adiciona estilo ao editor
	add_editor_style();


	// adiciona os links pros feeds padrão
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Add excerpt to pages
	 */
	add_post_type_support( 'page', 'excerpt' );


	// adiciona o suporte aos formatos de post
	add_theme_support( 'post-formats', array( 'aside', 'chat', 'image', 'gallery', 'link', 'video', 'quote', 'audio', 'status' ) );


	// adiciona suporte a imagens destacadas
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'avatar_candidate', 200, 200, true );
	
	// registra o menu
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'historias' ),
		'secondary' => __( 'Secondary Menu', 'historias' ),
        'mobile' => __( 'Mobile Menu', 'historias' )
	) );


	// chama os javascripts
	add_action( 'template_redirect', 'historias_load_scripts' );


    add_action( 'wp_enqueue_scripts', 'historias_enqueue_styles' );


	// registra as áreas de widgets
	add_action( 'widgets_init', 'historias_register_sidebars' );


	// adiciona o suporte a fundo personalizado
	$bg_args = array(
		'default-color' => 'fff',
		// 'default-image' => get_template_directory_uri() . '/images/default_bg.png',
	);
	add_theme_support( 'custom-background', $bg_args );


	// remove o estilo padrão das galerias
	add_filter( 'use_default_gallery_style', '__return_false' );


	// filtra os padroes dos uploads
	update_option( 'image_default_align','center' );


    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, icons, and column width.
     */
    add_editor_style( array( 'editor-style.css', str_replace( ',', '%2C', 'http://fonts.googleapis.com/css?family=Sanchez:400italic,400' ) ) );
}


function custom_attachment_link( $link ) {

	$link = preg_replace("/('>){1}/", "' target='_blank'>", $link );

	return $link;
}
add_filter( 'wp_get_attachment_link', 'custom_attachment_link', 999);


function custom_excerpt_length( $length ) {
    return 50;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Enqueue custom JS using wp_enqueue_script()
 *
 */
function historias_load_scripts() {

	/**
	 * Respond.js
	 * Media queries polyfill
	 */
	wp_enqueue_script( 'respond', get_template_directory_uri() . '/js/respond.js', '', '1.1.0' );

    wp_enqueue_script( 'responsive-nav', get_template_directory_uri() . '/js/responsive-nav.min.js', array( 'jquery' ), '1.0.32', true );

	/* Modernizr */
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', '', '2.6.2' );

	/* Slider */
	// if ( is_page_template( 'page-templates/home-divulgacao.php' ) )
 //        wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/idangerous.swiper-2.1.min.js', array( 'jquery' ), '2.1', true );

	/* Load the comment reply JavaScript. */
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
		wp_enqueue_script( 'comment-reply' );
		
	/* Foruns de discussão e votação */
	if ( is_single() ) {
		wp_enqueue_script('jquery-flexslider', get_template_directory_uri().'/js/flexslider-min.js', array('jquery'));
		wp_enqueue_script( 'foruns', get_template_directory_uri() . '/js/foruns.js');
		wp_localize_script('foruns', 'vars', array('ajaxurl' => admin_url('admin-ajax.php')));
	}

	/* Para todo o tema */
	wp_enqueue_script( 'setoriaiscnpc', get_template_directory_uri() . '/js/setoriaiscnpc.js');
		
}


/**
 * Chama as funções
 *
 */
function historias_footer_scripts() {

}
add_action( 'wp_footer', 'historias_footer_scripts', 99 );


function historias_enqueue_styles() {

    /* Lovely Google Fonts for body and titles */
    // wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Sanchez:400italic,400' ) ;

    /* JUDO Font Awesome for the icons */
    wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );

}


function historias_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'historias' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'historias_wp_title', 10, 2 );


function historias_share() {
	global $post; ?>
		<div class="entry-share  cf">
            <input type="text" class="share-shortlink" value="<?php echo wp_get_shortlink( get_the_ID() ); ?>" onclick="this.focus(); this.select();" readonly="readonly" />

            <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                <a href="<?php comments_link(); ?>" class="comments-link"><i class="fa fa-comment"></i> <?php echo comments_number( __('Leave a reply','historias'), __('One comment','historias'), __('% comments','historias') ); ?></a>
            <?php endif; ?>
    	</div>
   	<?php
}


function historias_postedby() {
	global $post;
?>
	<span class="author vcard">
        <?php if ( is_multi_author() ) {
        	the_author_posts_link();
        } else {
        	the_author();
        } ?>
    </span>
   	<?php
}


// filtra a data para que o human_time_diff apenas apareça em posts com menos de um mês
function historias_the_time() {
	global $post;

	$time = mysql2date( 'G', $post->post_date );
	$time_diff = time() - $time; ?>

	<span class="entry-date">
		<?php if ( ! is_single() && ( $time_diff > 0 && $time_diff < 30*24*60*60 ) )
			printf( __( '%s ago', 'historias' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
		else
			the_time( get_option( 'date_format' ) );
		?>
	</span>
<?php }


function historias_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'paging-navigation';
	if ( is_single() )
		$nav_class = 'post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'historias' ); ?></h1>
	<?php if ( is_single() ) : ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<i class="fa fa-arrow-left"></i> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '<i class="fa fa-arrow-right"></i> %title' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>

		<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( sprintf( __('%s Older posts', 'historias' ), '<i class="fa fa-arrow-left"></i>' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( sprintf( __('%s Newer posts', 'historias' ), '<i class="fa fa-arrow-right"></i>' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- /<?php echo $nav_id; ?> -->
	<?php
}


// ativa as áreas de widgets
function historias_register_sidebars() {
	// lateral 1
  	register_sidebar( array (
  		'name' => __( 'Primary Widget Area','historias' ),
  		'description' => __( 'Its the coloured one.','historias' ),
  		'id' => 'primary-widget-area',
  		'before_widget' => '<aside id="%1$s" class="widget widget--negative %2$s">',
  		'after_widget' => "</aside>",
  		'before_title' => '<h3 class="widget__title">',
  		'after_title' => '</h3>',
  	) );

  	register_sidebar( array (
  		'name' => __( 'Front Page Widget Area','historias' ),
  		'description' => __( 'Front page.','historias' ),
  		'id' => 'front-page-widget-area',
  		'before_widget' => '<aside id="%1$s" class="widget widget--negative %2$s">',
  		'after_widget' => "</aside>",
  		'before_title' => '<h3 class="widget__title">',
  		'after_title' => '</h3>',
  	) );
}



/**
 * Adiciona os favicons aos pingbacks & trackbacks
 *
 */
function historias_get_favicon( $url = '' ) {
	if ( ! empty ( $url ) )
		$url = parse_url( $url );

	$url = 'http://www.google.com/s2/favicons?domain=' . $url['host'];

	return $url;
}


function historias_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="pingback">
       	<?php if(function_exists('historias_get_favicon')) { ?><img src="<?php echo historias_get_favicon( $comment->comment_author_url ); ?>" alt="Favicon" class="favicon" /><?php } ?><?php comment_author_link(); ?><?php edit_comment_link( sprintf( __( '%s Edit', 'historias' ), '<i class="fa fa-pencil"></i>' ) ); ?>
    <?php
            break;
        default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment-container">
            <div class="vcard">
				<div class="comment-author-avatar">
					<?php echo get_avatar( $comment, 96 ); ?>
				</div>
			</div>
			
			<header class="comment-meta">
            	<cite class="fn">
	            	<span class="entry-author"><?php echo get_comment_author_link(); ?></span>
	            	<span class="entry-date"><?php echo get_the_date(); ?></span>
            	</cite>
            	<?php comment_reply_link( array_merge( $args, array( 'reply_text' => 'Responder', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            	<?php edit_comment_link( sprintf( __( '%s Edit', 'historias' ), '<i class="fa fa-pencil"></i>' ) ); ?>
            </header>
			
			<div class="comment-content">
            	<?php comment_text(); ?>
            </div><!-- /comment-content -->

            <?php if ( $comment->comment_approved == '0' ) : ?>
            	<em class="comment-on-hold"><?php _e( 'Your comment is awaiting moderation.', 'historias' ); ?></em>
            <?php endif; ?>
        </article><!-- /comment -->

    <?php
            break;
    endswitch;
}


add_filter('img_caption_shortcode', 'historias_img_caption_shortcode',10,3);
function historias_img_caption_shortcode($val, $attr, $content = null) {
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $val;

	$capid = '';
	if ( $id ) {
		$id = esc_attr($id);
		$capid = 'id="figcaption_'. $id . '" ';
		$id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
	}

	return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '">' . do_shortcode( $content ) . '<figcaption ' . $capid
	. 'class="wp-caption-text">' . $caption . '</figcaption></figure>';
}


/**
 * Returns true if a blog has more than 1 category
 *
 * @since Jecebel 3.0
 */
function historias_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so historias_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so historias_categorized_blog should return false
		return false;
	}
}


/**
 * Flush out the transients used in historias_categorized_blog
 *
 * @since Jecebel 3.0
 */
function historias_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'historias_category_transient_flusher' );
add_action( 'save_post', 'historias_category_transient_flusher' );


/**
 * Retorna os logins digitados dentro do custom field
 *
 */
function historias_get_users() {
	global $post;

	$equipe = get_post_meta( $post->ID, 'historias_users', true );

	if ( $equipe ) {

		// Transforma em minúsculas e cria um array
		$equipe = strtolower( $equipe );
		$equipe = explode( ',', $equipe );

		return $equipe;
	}
}


/**
 * Verifica se o usuário preencheu sua descrição e só então a mostra
 *
 */
function historias_user_description( $description ) {

	if ( !empty( $description ) ) {

		$output = '<div class="member-description">';
		$output .= $description;
		$output .= '</div>';

		echo $output;

	}
}

/**
 * Return the post format (if not Standard)
 *
 */
function historias_the_format() {

	global $post;

	$format = get_post_format();
	$pretty_format = get_post_format_string($format);
	$permalink = get_permalink();

	if( $format ) echo '<a href="' . $permalink . '" class="entry-format">' . $pretty_format . '</a>';

}


/**
 * Add an option to gallery images with no links
 */
add_shortcode( 'gallery', 'new_gallery_shortcode' );
function new_gallery_shortcode($attr) {
	global $post, $wp_locale;

	$output = gallery_shortcode($attr);

	if($attr['link'] == "none") {
		$output = preg_replace(array('/<a[^>]*>/', '/<\/a>/'), '', $output);
	}

	return $output;
}

/**
 * A default menu for when they don't have one set.
 * Everybody sees a page list + the admins see a message about setting up the
 * menus in admin
 *
 */
function default_menu() { ?>

    <ul id="menu-main" class="menu--main  menu  cf">
        <?php if ( is_user_logged_in() && current_user_can( 'level_10' ) ) : ?>
            <li><a href="<?php bloginfo('url'); ?>/wp-admin/nav-menus.php"><?php _e('Hey admin, don\'t forget to set up a menu!', 'historias' ); ?></a></li>
        <?php endif; ?>
        <?php wp_list_pages('title_li='); ?>
        <?php wp_list_categories('title_li='); ?>
    </ul>

<?php }

/**
 * Load Meta Box for the "Capa/Inscricoes" Template
 */
require get_template_directory() . '/includes/meta_box-feature-url.php';

/**
 * Load Meta Box for the Front Page
 */
require get_template_directory() . '/includes/meta_box-feature-text.php';

/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// EMAILS SENDER  /////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

add_filter( 'wp_mail_from_name', 'hqf_mail_sender_name' );
function hqf_mail_sender_name($from_name) {
    return get_option('blogname');
}
add_filter( 'wp_mail_from', 'hqf_mail_sender' );
function hqf_mail_sender($from_name) {
    return get_option('admin_email');
}


function get_all_states() {

    return array(
        'AC'=>'Acre',                 
        'AL'=>'Alagoas',
        'AM'=>'Amazonas',              
        'AP'=>'Amapá',                  
        'BA'=>'Bahia',
        'CE'=>'Ceará',
        'DF'=>'Distrito Federal',      
        'ES'=>'Espírito Santo',
        'GO'=>'Goiás',                  
        'MA'=>'Maranhão',
        'MT'=>'Mato Grosso',             
        'MS'=>'Mato Grosso do Sul',    
        'MG'=>'Minas Gerais',
        'PA'=>'Pará',                  
        'PB'=>'Paraíba',
        'PR'=>'Paraná',
        'PE'=>'Pernambuco',
        'PI'=>'Piauí',
        'RJ'=>'Rio de Janeiro',
        'RN'=>'Rio Grande do Norte',
        'RS'=>'Rio Grande do Sul',
        'RO'=>'Rondônia',               
        'RR'=>'Roraima',                
        'SC'=>'Santa Catarina',
        'SP'=>'São Paulo',
        'SE'=>'Sergipe',     
        'TO'=>'Tocantins'              
    );

}


function dropdown_states( $name, $selected = null, $all = false, $extra = null )
{
    $states = get_all_states();
    
    $output = "<select id='{$name}' name='{$name}' {$extra}>";

    if( $all )
        $output .= "<option value=''>----------</option>";

    foreach( $states as $acronym => $state )
    {
    	$att = '';
        
        if( $acronym == $selected )
            $att = 'selected="selected"';

        $output .= "<option value='{$acronym}' {$att}>{$state}</option>";
    }

    $output .= "</select>";

    return $output;
}

function get_state_name_by_uf( $uf ) {

    $states = get_all_states();

    if( isset( $states[$uf] ) )
        return $states[$uf];
}


function get_setoriais() {

	return array(
        'arquitetura-urbanismo'     => 'Aquitetura e Urbanismo',
        'arquivos'                  => 'Arquivos',
        'arte-digital'              => 'Arte Digital',
        'artes-visuais'             => 'Artes Visuais',
        'artesanato'                => 'Artesanato',
        'audiovisual'               => 'Audiovisual',
        'circo'                     => 'Circo',
        'afro-brasileiro'           => 'Culturas Afro-Brasileiras',
        'culturas-populares'        => 'Culturas Populares',
        'danca'                     => 'Dança',
        'design'                    => 'Design',
        'literatura-livro-leitura'  => 'Literatura, Livro e Leitura',
        'moda'                      => 'Moda',
        'musica'                    => 'Música',
        'patrimonio-imaterial'      => 'Patrimônio Imaterial',
        'patrimonio-material'       => 'Patrimônio Material',
        'teatro'                    => 'Teatro'
    );
}

function get_label_setorial_by_slug( $slug ) {

    $states = get_setoriais();

    if( isset( $states[$slug] ) )
        return $states[$slug];
}


/**
 * show a menu dropdown from the setorial
 *
 * @name    dropdown_states
 * @return  string
 */
function dropdown_setoriais( $name, $selected = null, $all = false, $extra = null )
{
    $setoriais = get_setoriais();

    $output = "<select id='{$name}' name='{$name}' {$extra}>";

    if( $all )
        $output .= "<option value=''>----------</option>";

    foreach( $setoriais as $acronym => $setorial )
    {
    	$att = '';

        if( $acronym == $selected )
            $att= 'selected="selected"';

        $output .= "<option value='{$acronym}' {$att}>{$setorial}</option>";
    }

    $output .= "</select>";

    return $output;
}

/**
 * return races
 *
 * @name    get_races
 * @return  array
 */
function get_races() {

	return array(
        'branco' => 'Branco',
        'preto'  => 'Preto',
        'pardo'	 => 'Pardo',
        'amarelo' => 'Amarelo',
        'indigena' => 'Indigena',
        'sem-declaracao' => 'Sem declaração'
    );
}

/**
 * show a menu dropdown from the setorial
 *
 * @name    dropdown_states
 * @return  select
 */
function dropdown_races( $name, $selected = null, $all = false, $extra = null ) {
    $races = get_races();

    $output = "<select id='{$name}' name='{$name}' {$extra}>";

    if( $all )
        $output .= "<option value=''>----------</option>";

    foreach( $races as $acronym => $race )
    {
    	$att = '';

        if( $acronym == $selected )
            $att= 'selected="selected"';

        $output .= "<option value='{$acronym}' {$att}>{$race}</option>";
    }

    $output .= "</select>";

    return $output;
}


/**
 * return genres
 *
 * @name    get_generos
 * @return  array
 */
function get_genres() {

	return array(
        'masculino' => 'Masculino',
        'feminino'  => 'Feminino'
    );
}

/**
 * show a menu dropdown of genre
 *
 * @name    dropdown_genres
 * @return  select
 */
function dropdown_genres( $name, $selected = null, $all = false, $extra = null )
{
    $genres = get_genres();

    $output = "<select id='{$name}' name='{$name}' {$extra}>";

    if( $all )
        $output .= "<option value=''>----------</option>";

    foreach( $genres as $acronym => $genre )
    {
    	$att = '';

        if( $acronym == $selected )
            $att= 'selected="selected"';

        $output .= "<option value='{$acronym}' {$att}>{$genre}</option>";
    }

    $output .= "</select>";

    return $output;

}
?>
