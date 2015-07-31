<?php

function get_setoriaiscnpc_baseurl() {
	return get_bloginfo('stylesheet_directory') . '/';
}

function get_theme_image($name) {
	return get_bloginfo('stylesheet_directory') . '/images/' . $name;
}

function theme_image($name, $params = null) {
	$extra = '';

	if(is_array($params)) {
		foreach($params as $param=>$value){
			$extra.= " $param=\"$value\" ";
		}
	}

	echo '<img src="', get_theme_image($name), '" ', $extra ,' />';
}


function get_setoriaiscnpc_rules($wp_rewrite) {
	$rules = array(
		'inscricoes/?$' => 'index.php?setoriaiscnpc_tpl=inscricoes',
		'inscricoes/([a-zA-Z0-9]{8,})/?$' => 'index.php?setoriaiscnpc_tpl=inscricoes&subscription_number=' . $wp_rewrite->preg_index(1),
		'inscricoes/([a-zA-Z0-9]{8,})/imprimir/?$' => 'index.php?setoriaiscnpc_tpl=inscricoes-print&subscription_number=' . $wp_rewrite->preg_index(1),

		'avaliacoes/?$' => 'index.php?setoriaiscnpc_tpl=avaliacoes',
		'avaliacoes/([a-zA-Z0-9]{8,})/reviewer/([0-9]+)/?$' => 'index.php?setoriaiscnpc_tpl=inscricoes&subscription_number='.$wp_rewrite->preg_index(1)
		. '&reviewer='.$wp_rewrite->preg_index(2),
		);

	$wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
add_action('generate_rewrite_rules', 'get_setoriaiscnpc_rules');

function template_redirect_intercept(){
	global $wp_query;
	if ( $wp_query->get('setoriaiscnpc_tpl') == 'inscricoes' ) {
		if (file_exists( TEMPLATEPATH . '/inscricoes.php' )) {
			include( TEMPLATEPATH . '/inscricoes.php' );
			exit;
		}
	} elseif ( $wp_query->get('setoriaiscnpc_tpl') == 'inscricoes-print' ) {
		if (file_exists( TEMPLATEPATH . '/inscricoes/inscricoes-print.php' )) {
			include( TEMPLATEPATH . '/inscricoes/inscricoes-print.php' );
			exit;
		}
	} elseif ( $wp_query->get('setoriaiscnpc_tpl') == 'avaliacoes' ) {
		if (file_exists( TEMPLATEPATH . '/inscricoes/avaliacoes.php' )) {
			include( TEMPLATEPATH . '/inscricoes/avaliacoes.php' );
			exit;
		}
	}
}
add_action('template_redirect', 'template_redirect_intercept');


function get_setoriaiscnpc_query_vars($public_query_vars) {
	$public_query_vars[] = "subscription_number";
	$public_query_vars[] = "setoriaiscnpc_tpl";
	$public_query_vars[] = "reviewer";
	return $public_query_vars;
}
add_filter('query_vars', 'get_setoriaiscnpc_query_vars');


/** Traz usuário sem os meta */
function get_basic_userdata( $user_id ) {
	global $wpdb;
	if ( ! is_numeric( $user_id ) )
		return false;
	$user_id = absint( $user_id );
	if ( ! $user_id )
		return false;
	$user = wp_cache_get( $user_id, 'users' );
	if ( $user )
		return $user;
	if ( ! $user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->users WHERE ID = %d LIMIT 1", $user_id ) ) )
		return false;
	return $user;
}

if (!get_option('curador_criado') == 1){
    update_option('curador_criado', 1);
	add_role('curador', 'Curador', array(
		'read' => true,
		'curate' => true,
		));
	$admin = get_role('administrator');
	$admin->add_cap('curate');
}


?>
