<?php
/*
 * O candidato tem dois registros no banco
 * 
 * 1. o usuário dele
 * 2. o projeto dele
 * 
 * O usuário tem os metadados básicos de nome, cpf, uf e setorial
 * 
 * O projeto tem a ficha de candidatura dele
 * 
 * Os votos são registrados contra o projeto, não contra o usuário
 * 
 */ 


// verifica se usuario atual pode votar no candidato, batendo com ID do post da inscricao do candidato
function current_user_can_vote_in_project($project_id) {
	$user = wp_get_current_user();
	return user_can_vote_in_project($user->ID, $project_id);
}

function user_can_vote_in_project($user_id, $project_id) {
	global $wpdb;
	$candidate_id = $wpdb->get_var( $wpdb->prepare("SELECT post_author FROM $wpdb->posts WHERE ID = %s", $project_id) );
	return user_can_vote_in_user($user_id, $candidate_id);
}

// verifica se usuario atual pode votar no candidato, batendo com ID do usuario do candidato
function current_user_can_vote_in_user($candidate_id) {
	$user = wp_get_current_user();
	return user_can_vote_in_user($user->ID, $candidate_id);
	
}

function user_can_vote_in_user($user_id, $candidate_id) {
	$user_area = get_user_meta($user_id, 'uf-setorial', true);
	$candidate_area = get_user_meta($candidate_id, 'uf-setorial', true);
	
	//var_dump($candidate_id, $user_id, $user_area, $candidate_area);
	
	return $user_area == $candidate_area;
}


function register_vote($user_id, $project_id) {

	// verifica se pode votar
	if (!user_can_vote_in_project($user_id, $project_id))
		return false;

	// remove todos os votos
	delete_user_meta($user_id, 'vote-project-id');
	
	// registra voto
	add_user_meta($user_id, 'vote-project-id', $project_id);
	
	return true;

}

// ajax handle
function ajax_register_vote() {

	$response = array();
	$response['success'] = true;
	$user = wp_get_current_user();
	
	if (is_votacoes_abertas()) {
		

		if ( register_vote($user->ID, $_POST['project_id'])  ) {
		
			$response['voted_project_id'] = $_POST['project_id'];
		
		} else {
			$response['success'] = false;
			$response['errormsg'] = 'Erro ao registrar voto';
		}

		
	} else {
		$response['success'] = false;
		$response['errormsg'] = 'A votação não está aberta';
	}
	
	echo json_encode($response);
	
	die;

}

add_action('wp_ajax_register_vote', 'ajax_register_vote');

function is_votacoes_abertas() {

	return get_theme_option('votacoes_abertas');

}

function get_current_user_vote() {
	$user = wp_get_current_user();
	return get_user_meta($user->ID, 'vote-project-id', true);

}

function get_number_of_votes_by_project($project_id) {
	global $wpdb;
	return $wpdb->get_var("SELECT COUNT(user_id) FROM $wpdb->usermeta WHERE meta_key = 'vote-project-id' AND meta_value = $project_id");
}

// verifica se o usuário atual é deste estado e setorial
function is_user_this_uf_setorial( $uf_setorial ) {
	$user = wp_get_current_user();
	$user_uf_setorial = strtolower( get_user_meta($user->ID, 'uf-setorial', true) );
	
	if( $user_uf_setorial == $uf_setorial )
		return true;

	return false;
}