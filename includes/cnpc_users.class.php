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

			wp_localize_script( 
	            'cnpc_users', 
	            'vars', 
	            array(
	                'ajaxurl'   => admin_url( 'admin-ajax.php' ),
	                'nonce' => wp_create_nonce( "user_delete_account" ),
	            )
	        );

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

		    		.description.indicator-hint { clear: both; }

		    		#cnpc-loading {
						width: 20px;
						height:20px;
						background:url(../wp-admin/images/wpspin_light.gif) no-repeat center;
					}

		    	</style>";
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

			if( get_theme_option('inscricoes_abertas') )
				add_action('show_user_profile', array( &$this, 'button_user_profile_delete_account') );

			if( !current_user_can('administrator') )
				add_action('show_user_profile', array( &$this, 'hidden_fields_user_profile') );

			add_action( 'wp_ajax_current_user_delete_account', array( &$this, 'current_user_delete_account' ) ); 
		}
	}

	$CNPC_Users = new CNPC_Users();
}

// adicionar apenas no profile
if( is_admin() )
	add_action( 'init', 'CNPC_Users_init' );
	
 ?>