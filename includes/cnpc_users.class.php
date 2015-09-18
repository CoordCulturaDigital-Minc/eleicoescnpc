<?php 

function CNPC_Users_init() {
	class CNPC_Users
	{	
		
		// ATRIBUTES /////////////////////////////////////////////////////////////////////////////////////
		var $slug  = 'cnpc_users';
		var $dir   = '';
		var $url   = '';
		var $error = array();


		// METHODS ///////////////////////////////////////////////////////////////////////////////////////
		/**
		 * load cnpc users scripts
		 *
		 * @name    scripts
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @return  void
		 */
		function scripts()
		{
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_script( 'cnpc_users', $this->url . '/js/cnpc-users.js', array( 'jquery-ui-dialog' ) );

	        wp_enqueue_style("wp-jquery-ui-dialog");
		}

		/**
		 * button delete account
		 *
		 * @name   	button_user_profile_delete_account
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @return  html
		 */
		function button_user_profile_delete_account() {
			?>	
			<table class="form-table wp-core-ui">
				<tr class="user_delete_account">
					<th ><label for="address"><?php _e("Deletar conta"); ?></label></th>
					<td>
						<a href="" id="delete_account" class="button button-secondary">Deletar minha conta</a>
						<div id="cnpc-loading" style="display:none;"></div>
						<p class="description">Esta ação não pode ser desfeita, todos os seus dados serão apagados, inclusive os votos.</p>
					</td>
				</tr>
			</table>

			<?php
		}

		/**
		 * delete user
		 *
		 * @name    current_user_delete_account
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @return  mixed
		 */
		function current_user_delete_account() {

			$response = array();
			$response['success'] = true;

			// verifica tem um usuário logado
		    if( !is_user_logged_in() ) {
		    	$response['success'] = false;
				$response['errormsg'] = 'Erro, nenhum usuário!';
		    }

		    // verifica se as inscricoes estão encerradas
		    if( !get_theme_option('inscricoes_abertas') ) {
		    	$response['success'] = false;
				$response['errormsg'] = 'Erro, as incrições estão encerradas!<br> Não é possível excluir a conta!';
		    }

		    // não deixar administradores excluir por aqui
		    if( current_user_can('administrator') ) {
		    	$response['success'] = false;
				$response['errormsg'] = 'Você é admin, sua conta não será deletada!';
		    }

		   	check_ajax_referer( 'user_delete_account', 'nonce' );

		    if( $response['success'] == true ) {

		    	require_once(ABSPATH.'wp-admin/includes/user.php' );
			    $current_user = wp_get_current_user();

			    $this->send_mail_deleted_account( $current_user->ID );

			    wp_delete_user( $current_user->ID );
		    }
		    
		    echo json_encode($response);
			die;
		}

		/**
		 * Pega o ip do usuário
		 *
		 * @name    get_the_user_ip
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @return  mixed
		 */
		function get_the_user_ip() {

			if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
				//check ip from share internet
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
				//to check ip is pass from proxy
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}

			return apply_filters( 'wpb_get_ip', $ip );
		}

		/**
		 * Campos extras no perfil do usuário
		 *
		 * @name    edit_user_details
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @return  mixed
		 */
		function edit_user_details($user) {
			?> 
			<table class="form-table">
				 <tr>
			        <th>
			        	<label>CPF</label>
			        </th>
			        <td>
			       		<input id="cpf" type="text" name="cpf" value="<?php echo esc_attr(get_user_meta($user->ID, 'cpf', true)); ?>" disabled="disabled" />
			       		<span class="description">Não é possível alterar</span>
			        </td>
			    </tr>

			    <tr>
			        <th><label>Nome completo</label></th>
			        <td>
			           <input type="text" class="regular-text" name="user_name" value="<?php echo esc_attr(get_user_meta($user->ID, 'user_name', true)); ?>" disabled="disabled" />
			        	<span class="description">Não é possível alterar</span>
			        </td>
			    </tr>

			    <tr>
			        <th><label>Data nascimento</label></th>
			        <td>
			           <input type="text" name="date_birth" value="<?php echo restore_format_date(esc_attr(get_user_meta($user->ID, 'date_birth', true))); ?>" disabled="disabled"/>
			        	<span class="description">Não é possível alterar</span>
			        </td>
			    </tr>
			    <?php $disabled = ''; ?>
			    <?php $disabled = ( $this->user_can_change_setorial_uf( $user->ID ) && $this->user_can_change_uf( $user->ID ) ) ? '': 'disabled="disabled"'; ?>

			    <tr>
			        <th><label>Estado</label></th>
			        <td>
			           <?php echo dropdown_states( 'uf', get_user_meta($user->ID, 'UF', true), true, $disabled); ?>
			           <span class="description">Só pode alterar uma vez</span>
			        </td>
			    </tr>

			    <?php $disabled = ( $this->user_can_change_setorial_uf( $user->ID ) && $this->user_can_change_setorial( $user->ID ) ) ? '': 'disabled="disabled"'; ?>

			    <tr>
			        <th><label>Setorial</label></th>
			        <td>
			           <?php echo dropdown_setoriais( 'setorial', get_user_meta($user->ID, 'setorial', true), true, $disabled); ?>
			        	<span class="description">Só pode alterar uma vez</span>
			        </td>
			    </tr>
			    <tr>
			    	<th></th>
				    <td>
				    	<?php if( $this->user_is_candidate_was_voted( $user->ID ) ) : ?>
				    		<input type="hidden" id="candidate_was_voted" value="true" />
					    	<span class="description warning">Candidato, se você alterar o seu estado ou setorial os seus votos serão apagados. <br> Esta ação não pode ser desfeita.</span>
					    <?php endif; ?>
					</td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Save_user_details
		 *
		 * @name    save_user_details
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @param int $user_id
		 * @return null
		 */
		function save_user_details($user_id) {

			$current_uf 		= get_user_meta($user_id, 'UF', true);
			$current_setorial 	= get_user_meta($user_id, 'setorial', true);

			$uf		  = isset( $_POST['uf'] ) ? $_POST['uf'] : $current_uf;
			$setorial = isset( $_POST['setorial'] ) ? $_POST['setorial'] : $current_setorial;

			// se mudar UF ou Setorial
			if( $uf !== $current_uf || $setorial !== $current_setorial ) {

				// verifica o prazo para alterações
				if( !$this->user_can_change_by_date() ) 
					wp_die('O prazo para alterar estado ou setorial já expirou.', '', array( 'back_link' => true ) );
				

				// se for candidato
				// if( is_valid_candidate( $user_id ) ) 
				// 	wp_die('Você é candidato, não pode alterar seu estado e/ou setorial.', '', array( 'back_link' => true ) );
				
				/* 
				 *	Se alterar o estado
				 */

				if( $uf !== $current_uf ) {

					if( !$this->user_can_change_uf( $user_id ) )
						wp_die('Você não pode mais alterar o seu estado.', '', array( 'back_link' => true ) ); 

					$current_count_uf = get_user_meta($user_id, 'uf-counter', true);

					$current_count_uf = empty($current_count_uf) ? 0 : (int) $current_count_uf;

					$current_count_uf ++;

					update_user_meta($user_id, 'UF', $uf);

					if( !current_user_can('administrator') )
						update_user_meta($user_id, 'uf-counter', $current_count_uf);
				}

				/* 
				 *	Se alterar a setorial
				*/

				if( $setorial !== $current_setorial ) {

					if( !$this->user_can_change_setorial( $user_id ) )
						wp_die('Você não pode mais alterar a sua setorial.', '', array( 'back_link' => true ) ); 
					
					$current_count_setorial = get_user_meta($user_id, 'setorial-counter', true);

					$current_count_setorial = empty($current_count_setorial) ? 0 : (int) $current_count_setorial;

					$current_count_setorial ++;

					update_user_meta($user_id, 'setorial', $setorial);

					if( !current_user_can('administrator') )
						update_user_meta($user_id, 'setorial-counter', $current_count_setorial);
				}

				/*
				 * Verifica se o usuário possui algum projeto com voto
				 * No requisito pede que quando um candidato trocar de setorial e tiver voto, 
				 * ele deverá aparecerá na lista anterior com a mensagem "Esta candidatura foi retirada"
				 * Como o usuário pode alterar mais de uma vez, ele deverá aparecer em todas que teve voto.
				 * Adiciona o metadado 'uf-setorial-previous'
				 */

				if( $this->user_is_candidate_was_voted( $user_id )) {
					
					// salva com a quantidade de alterações para não sobscrever setoriais anteriores
					$count = $current_count_uf + $current_count_setorial;

					update_user_meta( $user_id, 'uf-setorial-previous-' . $count,  $current_uf . '-' . $current_setorial);

					/*
					 * adiciona canceled no valor do voto nos usuários que já votaram neste candidato(projeto)
					 */

					// pega o projeto do candidato
					$project_id = cnpc_get_project_id_by_user_id( $user_id );

					// pega o id dos usuários que votaram no candidato
					$users_voted = get_id_of_users_voted_project($project_id);

					// roda um loop para alterar o id do projeto nos usuário que votaram neste candidato
					foreach ($users_voted as $user) {
						update_user_meta($user->user_id, 'vote-project-id','canceled-'.$project_id);
					}

				}

				update_user_meta($user_id, 'uf-setorial', $uf . '-' . $setorial);
			}
			
		}

		/**
		 *  Verifica se o pode alterar a setorial ou estado
		 *
		 * @name    user_can_change_setorial_uf
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @param int $user_id
		 * @return null
		 */
		function user_can_change_setorial_uf( $user_id ) {

			if( current_user_can('administrator'))
				return false;
			
			// if( is_valid_candidate( $user_id ) ) 
			// 	return false;

			// if( $this->user_is_candidate_was_voted( $user_id ))
			// 	return false;

			if( !$this->user_can_change_by_date() ) 
				return false;

			return true;
		}


		/**
		 * Enviar email para o admin da conta deletada
		 *
		 * @name    send_mail_deleted_account
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @return  mixed
		 */
		function send_mail_deleted_account( $user_id ) {

			if( empty( $user_id ) )
				return false;

			$user_info = get_userdata($user_id);
			$user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );

			$from = get_bloginfo('admin_email');
		    $to = array( get_bloginfo('admin_email') );
		    $subject = 'Usuário deletado - ' . $user_info->display_name;

		    $message = "From: $from\r\n";
		    $message .= "Content-Type: text/html\r\n";
	
		    $message .= '<br />ID: ' . $user_info->ID . '<br />';
			$message .= 'Nome de usuário: ' . $user_info->user_login . '<br />';
		    $message .= 'Email: ' . $user_info->user_email . '<br />';
		    $message .= 'Display Name: ' . $user_info->display_name . '<br />';
		    $message .= 'Nascimento: ' . restore_format_date( $user_meta['date_birth'] ) . '<br />';
		    $message .= 'CPF: ' . $user_meta['cpf'] . '<br />';
		    $message .= 'Setorial: ' . $user_meta['setorial'] .'<br />';
		    $message .= 'Estado: ' . $user_meta['UF'] .'<br />'; 

		    $project_id = cnpc_get_project_id_by_user_id( $user_id );
		    $p = array();

		    if( !empty( $project_id ) ) {
		   		$p = array_map( function( $a ){ return $a[0]; }, get_post_meta( $project_id ) );
		    	$message .= 'Dados da candidatura <br />'; 
			    $message .= 'Afro-brasileiro: '; 
			    $message .= ( $p['candidate-race'] == 'true') ? 'Sim' : 'Não'; 
			    $message .= '<br />Sexo: ' . ucfirst($p['candidate-genre']) .'<br />'; 
			    $message .= 'Breve experiência no setor: ' . $p['candidate-experience'].'<br />';
			    $message .= 'Exposição de motivos para a candidatura: ' . $p['candidate-explanatory'].'<br />';
		    }


		    if( !empty( $this->get_the_user_ip() ) )
		    	$message .= 'Ip: ' . $this->get_the_user_ip();

			wp_mail( $to, $subject, $message );
		}

	
		/**
		 * Verifica se o usuário pode alterar a uf
		 *
		 * @name    user_can_change_uf
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-09-08
		 * @updated 2015-09-08
		 * @return  boolean
		 */
		function user_can_change_uf($user_id) {

			$uf_counter = $this->user_already_changed_uf($user_id);

			$vezes_que_pode_alterar = (int) get_theme_option('vezes_que_pode_mudar_uf_e_setorial');

			if ($uf_counter >= $vezes_que_pode_alterar) 
				return false;

			return true;
			
		}


		/**
		 * Verifica se o usuário pode alterar a setorial
		 *
		 * @name    user_can_change_setorial
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-09-08
		 * @updated 2015-09-08
		 * @return  boolean
		 */
		function user_can_change_setorial($user_id) {

			$setorial_counter = $this->user_already_changed_setorial($user_id);

			$vezes_que_pode_alterar = (int) get_theme_option('vezes_que_pode_mudar_uf_e_setorial');

			if ($setorial_counter >= $vezes_que_pode_alterar) 
				return false;

			return true;
			
		}


		/**
		 * Quantas vezes o usuário já alterou o estado
		 *
		 * @name    user_already_changed_uf
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-09-08
		 * @updated 2015-09-08
		 * @return  int
		 */
		function user_already_changed_uf($user_id) {

			return (int) get_user_meta($user_id, 'uf-counter', true);
			
		}

		/**
		 * Quantas vezes o usuário já alterou a setorial
		 *
		 * @name    user_already_changed_setorial
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-09-08
		 * @updated 2015-09-08
		 * @return  int
		 */
		function user_already_changed_setorial($user_id) {

			return (int) get_user_meta($user_id, 'setorial-counter', true);
		}

		/**
		 * Verifica o período que oo usuário pode alterar Setorial e UF
		 *
		 * @name    user_can_change_by_date
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-09-08
		 * @updated 2015-09-08
		 * @return  boolean
		 */
		function user_can_change_by_date() {

			$data_fim_da_troca = get_theme_option('data_fim_troca_uf_setorial'); //'2015-09-26'

			$hoje = date('Y-m-d');

			// verifica data
			if ($data_fim_da_troca < $hoje)
				return false;

			return true;
			
		}

		/**
		 * Esconde alguns campos dos usuários
		 *
		 * @name    hidden_fields_user_profile
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @return  css
		 */
		function hidden_fields_user_profile() {

		    echo "<style type='text/css'>
		    		.form-table .user-rich-editing-wrap,
		    		.form-table .user-admin-color-wrap,
		    		.form-table .user-comment-shortcuts-wrap,
		    		.form-table .show-admin-bar.user-admin-bar-front-wrap,
		    		.form-table .user-url-wrap,
		    		.form-table .user-description-wrap,
		    		.form-table .user-first-name-wrap,
		    		.form-table .user-last-name-wrap,
		    		.form-table .user-user-login-wrap  { display: none; } 

		    		.form-table .warning { color: red; font-weight: bold;}

		    		.description.indicator-hint { clear: both; }

		    		#cnpc-loading {
						width: 20px;
						height:20px;
						background:url(../wp-admin/images/wpspin_light.gif) no-repeat center;
					}

		    	</style>";
		}


		/**
		 * Verifica se o usuário possui projeto com voto
		 *
		 * @name    user_is_candidate_was_voted
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @return  boolean
		 */
		function user_is_candidate_was_voted( $user_id ) {

			// pega o projeto do usuário
			$project_id = cnpc_get_project_id_by_user_id( $user_id );

			// busca a quantidade de votos
			$votos = get_number_of_votes_by_project($project_id);

			if( $votos > 0 )
				return true;

			return false;

		}

		// CONSTRUCTOR ///////////////////////////////////////////////////////////////////////////////////
		/**
		 * @name    Construct
		 * @author  Cleber Santos <oclebersantos@gmail.com>
		 * @since   2015-08-31
		 * @updated 2015-08-31
		 * @return  void
		 */
		function __construct() {

			$this->url = get_template_directory_uri();

			add_action( 'admin_enqueue_scripts', array( &$this, 'scripts' ) );

			// alterar estado e setorial
			add_action('edit_user_profile', array( &$this, 'edit_user_details')); // para os admins
			add_action('profile_personal_options', array( &$this, 'edit_user_details')); // somente para o usuário

			// add_action('edit_user_profile_update', array( &$this, 'save_user_details')); // admins podem salvar
			add_action('personal_options_update', array( &$this, 'save_user_details')); // somente o usuário pode salvar

			if( !current_user_can('administrator') )
				add_action('show_user_profile', array( &$this, 'hidden_fields_user_profile') );

			// add_action( 'wp_ajax_current_user_delete_account', array( &$this, 'current_user_delete_account' ) );  // TODO deletar usuario
		}
	}

	$CNPC_Users = new CNPC_Users();
}

// adicionar apenas no profile
if( is_admin() )
	add_action( 'init', 'CNPC_Users_init' );
	
 ?>