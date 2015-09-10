
<?php

$register_errors = array();

if(isset($_POST['register']) && $_POST['register'] == 1) {
    
    // require_once( ABSPATH . WPINC . '/registration.php' );
    
    $user_login = sanitize_user($_POST['user_email']);
    $user_email = $user_login;
    $user_pass = $_POST['user_password'];
    $user_cpf = $_POST['user_cpf']; 
    $user_UF = $_POST['user_UF'];
    $user_setorial = $_POST['user_setorial'];
    $user_tipo = $_POST['user_tipo']; 
    $user_name = $_POST['user_name'];
    $user_birth = $_POST['user_birth'];
    $terms_of_use = $_POST['terms_of_use'];
    $user_confirm_informations = isset( $_POST['user_confirm_informations'] ) ? $_POST['user_confirm_informations'] : '';
    
    // $register_errors = array();
    $form = 'register';


     // validar antes de salvar
    if( class_exists('Validator') ) {
        $validator = new Validator();

        /* tipo de usuário*/
        if( strlen( $terms_of_use)==0 )
            $register_errors['terms_of_use'] = __('Você deve concordar com os termos para a inscrição no site.<br/>', 'tnb');    

        /* tipo de usuário*/
        if( strlen($user_tipo)==0 )
            $register_errors['user_tipo'] = __('O tipo de usuário é obrigatório para a inscrição no site.<br/>', 'tnb');    

        /* uf */
        if( strlen($user_UF)==0 )
            $register_errors['user_UF'] = __('O estado do usuário é obrigatório para a inscrição no site.<br/>', 'tnb');

        /* setorial */
        if( strlen($user_setorial)==0 )
            $register_errors['user_setorial'] = __('A setorial do usuário é obrigatório para a inscrição no site.<br/>', 'tnb');

        /* cpf */
        if( strlen($user_cpf)==0 ) {
            $register_errors['cpf'] = __('O cpf é obrigatório para a inscrição no site.<br/>', 'tnb');
        } else { 
            $valid_cpf = $validator->validate_field( $form, 'user_cpf', $user_cpf);
            if( $valid_cpf !== true )
                $register_errors['cpf'] = $valid_cpf . "<br/>";     
        }

        /* email */
        if(strlen($user_email)==0)
            $register_errors['email'] =  __('O e-mail é obrigatório para a inscrição no site.<br/>', 'tnb');
        else { 
            $valid_email = $validator->validate_field( $form, 'user_email', $user_email);
            if( $valid_email !== true )
                $register_errors['email'] = $valid_email . "<br/>";     
        }
        
        /* user name */
        if( strlen($user_name)==0 )
            $register_errors['user_name'] = __('O nome é obrigatório para a inscrição no site.<br/>', 'tnb');
        
        /* passwords */
        if(strlen($user_pass)==0 )
            $register_errors['pass'] = __('A senha é obrigatória para a inscrição no site.<br/>', 'tnb');

        if(strlen($user_pass) < 6 )
            $register_errors['pass'] = __('A senha deve ter no mínimo 6 caracteres.<br/>', 'tnb');
        
        if( $user_pass != $_POST['user_password_confirm'])
            $register_errors['pass_confirm'] = __('As senhas informadas não são iguais.<br/>', 'tnb');
        

        /* data de nascimento */
        if( strlen($user_birth)==0 )
            $register_errors['user_birth'] = __('A data de nascimento é obrigatório para a inscrição no site.<br/>', 'tnb');
        else { 
            $valid_birth = $validator->validate_field( $form, 'user_birth', $user_birth, $user_tipo);
            if( $valid_birth !== true )
                $register_errors['user_birth'] = $valid_birth . "<br/>";     
        }

        /* declaração de veracidade */
        if( strlen( $user_confirm_informations )==0)
            $register_errors['user_confirm_informations'] = __('Você precisa afirmar que os dados são verdadeiros.<br/>', 'tnb');
        
        
        if(!sizeof($register_errors)>0){

            $data['user_login'] = $user_login;
            $data['user_pass'] = $user_pass;
            $data['user_email'] =  $user_email;
            $data['first_name'] = $user_name;
            $data['display_name'] = $user_name; 
            
            $data['role'] = 'subscriber' ;
            $user_id = wp_insert_user($data);

            if ( ! $user_id ) {
                if ( $errmsg = $user_id->get_error_message('blog_title') )
                    echo $errmsg;
            } else {
    		
    			add_user_meta($user_id, 'cpf', $user_cpf);
                add_user_meta($user_id, 'terms_of_use', $terms_of_use);
                add_user_meta($user_id, 'UF', $user_UF);
                add_user_meta($user_id, 'user_name', $user_name); // checar se precisa salvar como meta e firt_name
                add_user_meta($user_id, 'date_birth', convert_format_date($user_birth)); 
                add_user_meta($user_id, 'setorial', $user_setorial);
                add_user_meta($user_id, 'uf-setorial', $user_UF . '-' . $user_setorial);
                add_user_meta($user_id, 'user_confirm_informations', $user_confirm_informations);
    			add_user_meta($user_id, 'user_register_ip', cnpc_get_the_user_ip());
                
    			if ($user_tipo == 'candidato')
    				add_user_meta($user_id, 'e_candidato', true);
    		
    		}

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
			} elseif( !empty($user_UF) && !empty($user_setorial)) {
                wp_safe_redirect(site_url('/foruns/' . $user_UF . '-' . $user_setorial));
            } else {
				wp_safe_redirect(site_url('/'));
			}
            exit();
        }
        
    }
}

?>
