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

// verifica se o usuário já votou
// retorna 0 se ainda não votou
// retorna int com o numero de vezes que ja votou
function user_already_voted($user_id) {

	$vote = get_user_meta($user_id, 'vote-project-id', true);
	if (empty($vote))
		return 0;

	return (int) get_user_meta($user_id, 'vote-counter', true);

}
function current_user_already_voted() {
	$user = wp_get_current_user();
	return user_already_voted($user->ID);
}

// verifica se o usuário pode mudar seu voto pela data de inicio da troca
function user_can_change_vote_by_date($user_id) {
	
	$data_inicio_da_troca = get_theme_option('data_inicio_da_troca'); //'2015-08-27' // pode botar no admin

	$hoje = date('Y-m-d');

	// verifica data
	if ($data_inicio_da_troca > $hoje)
		return false;

	return true;
}

// verifica se o usuário pode mudar seu voto pela quantidade permitida
function user_can_change_vote_by_counter($user_id) {

	$vote_counter = user_already_voted($user_id);

	$vezes_que_pode_mudar = get_theme_option('vezes_que_pode_mudar_voto'); // se quiser pode botar isso no admin. Isso é vezes que pode mudar, não votar. Então se é igual a 1, o vote-counter vai poder chegar até 2

	// verifica se o numero de vezes se está dentro do permitido
	if ($vote_counter > $vezes_que_pode_mudar) 
		return false;

	return true;
}


function current_user_can_change_vote_by_date() {
	$user = wp_get_current_user();
	return user_can_change_vote_by_date($user->ID);
}

function current_user_can_change_vote_by_counter() {
	$user = wp_get_current_user();
	return user_can_change_vote_by_counter($user->ID);
}


function register_vote($user_id, $project_id) {

	// verifica se pode votar
	if (!user_can_vote_in_project($user_id, $project_id))
		return false;

	// remove todos os votos
	delete_user_meta($user_id, 'vote-project-id');
	
	// registra voto
	add_user_meta($user_id, 'vote-project-id', $project_id);
	
	// incrementa um no vote-counter
	$current_count = get_user_meta($user_id, 'vote-counter', true);

	$current_count = empty($current_count) ? 0 : (int) $current_count;

	$current_count ++;

	update_user_meta($user_id, 'vote-counter', $current_count);


	return true;

}

// ajax handle
function ajax_register_vote() {

	$response = array();
	$response['success'] = true;
	$user = wp_get_current_user();
	
	if (is_votacoes_abertas()) {
		
		$canvote = false;

		if (current_user_already_voted()) {

			if (current_user_can_change_vote_by_date()) {

				if (current_user_can_change_vote_by_counter()) {
					$canvote = true;
				} else {
					$response['success'] = false;

					$response['errormsg'] = 'Erro ao registrar o voto! <br>Você atingiu o limite para troca de voto';
				}
			} else {
				$response['success'] = false;

				$response['errormsg'] = 'Erro ao registrar o voto! <br>Só é possível alterar o voto a partir do dia ' . restore_format_date( get_theme_option('data_inicio_da_troca'));
			}

		} else {
			$canvote = true;
		}

		if ($canvote) {
			if ( register_vote($user->ID, $_POST['project_id'])  ) {
			
				$response['voted_project_id'] = $_POST['project_id'];
			
			} else {
				$response['success'] = false;
				$response['errormsg'] = 'Erro ao registrar voto';
			}	
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

	$hoje = date('Y-m-d');

	if( get_theme_option('data_inicio_votacao') <= $hoje && get_theme_option('data_fim_votacao') >= $hoje )
		return true;

	return false;
	// return get_theme_option('votacoes_abertas');

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