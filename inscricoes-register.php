<?php

if(isset($_POST['register']) && $_POST['register'] == 1) {
    
    require_once( ABSPATH . WPINC . '/registration.php' );
    
    

    $user_login = sanitize_user($_POST['user_email']);
    $user_email = $user_login;
    $user_pass = $_POST['user_password'];
    $user_cpf = $_POST['user_cpf'];
    $user_UF = $_POST['user_UF'];
    $user_setorial = $_POST['user_setorial'];
    $user_tipo = $_POST['user_tipo'];
    
    $register_errors = array();
/*
    if(username_exists($user_login)){
        $register_errors['user'] =  __('Já existe um usário com este nome no nosso sistema. Por favor, escolha outro nome.', 'tnb');
    }
*/
    if(email_exists($user_email)){
        $forgot_pass_link = site_url('wp-login.php?action=lostpassword');
        $register_errors['email'] =  __('Este e-mail já está registrado em nosso sistema. Por favor, cadastre-se com outro e-mail. <br/>(Já sou cadastrado e <a href="'.$forgot_pass_link.'">esqueci minha senha</a>)<br/>', 'tnb');
    }
    if(!filter_var( $user_email, FILTER_VALIDATE_EMAIL)){
        $register_errors['email'] =  __('O e-mail informado é inválido.<br/>', 'tnb');
    }
    
    if($user_pass != $_POST['user_password_confirm']){
        $register_errors['pass_confirm'] =  'As senhas informadas não são iguais.<br/>';
    }
    
    if(strlen($user_email)==0)
        $register_errors['email'] =  __('O e-mail é obrigatório para o cadastro no site.<br/>', 'tnb');

    if(strlen($user_pass)==0 )
        $register_errors['pass'] =  'A senha é obrigatória para o cadastro no site.<br/>';

    if( strlen($user_cpf)==0 )
        $register_errors['cpf'] = __('O cpf é obrigatório para o cadastro no site.<br/>', 'tnb');

    
    if(!sizeof($register_errors)>0){
        
        //$user_pass = wp_generate_password();

        $data['user_login'] = $user_login;
        $data['user_pass'] = $user_pass;
        $data['user_email'] =  $user_email;
        
        $data['role'] = 'subscriber' ;
        $user_id = wp_insert_user($data);

        if ( ! $user_id ) {
            if ( $errmsg = $user_id->get_error_message('blog_title') )
                echo $errmsg;
        } else {
		
			add_user_meta($user_id, 'cpf', $user_cpf);
			add_user_meta($user_id, 'UF', $user_UF);
			add_user_meta($user_id, 'setorial', $user_setorial);
			add_user_meta($user_id, 'uf-setorial', $user_UF . '-' . $user_setorial);
			
			if ($user_tipo == 'candidato')
				add_user_meta($user_id, 'e_candidato', true);
		
		}

        /*
        $options = get_option('custom_email_notices');
        
        // Mensagem inserida via admin do WP
        $message = $options['msg_novo_'.$_POST['user_type']]?$options['msg_novo_'.$_POST['user_type']]:'';

        $info  = "Nome de usuário: {$user_login}\r\n";
        $info .= "Senha: {$user_pass}\r\n\r\n";
        //$info .= "Acesse o link abaixo para ativar a conta\r\n";
        //$info .=  get_bloginfo('url')."/cadastre-se/$reg_type?action=activate&key=$key&login=" . rawurlencode($user_login) . "\r\n\r\n";

        $message = str_replace('{{INFORMACOES}}', $info, $message);

        $header = 'cc:' . get_bloginfo('admin_email');

        
        $title = 'TNB | Confirmação de Cadastro';
        if ( $message && !wp_mail($user_email, $title, $message, $header) )
            wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') );

        //wp_new_user_notification( $user_id, $user_pass );

        $msgs['success'] = 'Cadastro efetuado com sucesso';
        */
        
        // depois de fazer o registro, faz login
        
        if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
            $secure_cookie = false;
        else
            $secure_cookie = '';

        $user = wp_signon(array('user_login' => $user_login, 'user_password' => $user_pass), $secure_cookie);

        if ( !is_wp_error($user) && !$reauth ) {
            if ($user_tipo == 'candidato') {
				wp_safe_redirect(site_url('inscricoes'));
			} else {
				wp_safe_redirect(site_url('/'));
			}
            exit();
        }
        
    }
}

?>
