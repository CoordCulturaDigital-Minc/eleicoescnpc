<?php

function get_current_user_project() {

    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID ) {
        return false;
    } else {
        return get_project_id_by_user_id($current_user->ID);
    }

}

function get_project_id_by_user_id($user_id) {

    // se sou um usuário e tenho sessão pra segunda avaliação
    $project_index = get_current_project_index($user_id);

    global $wpdb;
    $project_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE"
                                         ." post_status = 'publish'"
                                         ." AND post_type = 'projetos'"
                                         ." AND post_author = %d"
                                         ." ORDER BY ID ASC LIMIT 1 OFFSET %d", $user_id, $project_index));
    if (!$project_id) {
        $p = array(
            'post_title' => $user_id . ' - ' . 'Candidato ' . $project_index,
            'post_type' => 'projetos',
            'post_status' => 'publish',
            'post_author' => $user_id
        );
        $project_id = wp_insert_post($p);
        if (is_wp_error($project_id))
            die('Erro ao criar projeto');
    }

    return $project_id;


}

function get_current_project_index($user_id = null) {

    if (is_null($user_id)) {
        $current_user = wp_get_current_user();
        if ( 0 == $current_user->ID ) {
            return false;
        } else {
           $user_id = $current_user->ID;
        }
    }

    $current = get_user_meta($user_id, '_current_project_edit', true);
    if ($current !== false)
        return $current;
    else
        return 0;

}

function get_current_project_number() {
    return get_current_project_index() + 1;
}

function switch_project_to_edit() {

    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID ) {
        return false;
    } else {
        $current = get_user_meta($current_user->ID, '_current_project_edit', true);
        if ($current !== false) {
            update_user_meta($current_user->ID, '_current_project_edit', $current == 1 ? 0 : 1);
        } else {
            update_user_meta($current_user->ID, '_current_project_edit', 0);
        }
    }

}

function get_user_by_project_id($pid) {
    global $wpdb;
    $user_id = $wpdb->get_var($wpdb->prepare("SELECT post_author FROM {$wpdb->posts} WHERE"
                                         ." ID = %d", $pid));
    return get_userdata($user_id);
}

/** get project id from subscription number (that will be an hexa) */
function get_project_id_from_subscription_number($n) {
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE"
                                         ." meta_key = 'subscription_number'"
                                         ." AND meta_value LIKE %s", $n.'%'));
}

function get_user_by_cpf($c) {
    global $wpdb;
    $user_id = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE"
                                         ." meta_key='cpf' AND meta_value=%d", $c));
    return get_userdata($user_id);
}

// retirar
function user_cpf_does_not_exist($c) {
    global $wpdb;

    $result = $wpdb->get_var($wpdb->prepare("SELECT count(1) FROM {$wpdb->usermeta} WHERE"
                                        ." meta_key='cpf' and meta_value='%s';",$c));
    
    if($result > 0) {
        return true;
    }
    return false;
}

/************************ Ajax Functions *************************************/

/** loads state from a given region */
function get_states() {
    if(isset($_POST['region'])) {
        $region = $_POST['region'];
        $output = get_states_by_region($region);

        if($output) {
            print json_encode($output);
        }
    }
    die; // or wordpress will print 0
}
add_action('wp_ajax_get_states', 'get_states');

function get_cities() {
    if(isset($_POST['state'])) {
        print json_encode(get_cities_by_state_id($_POST['state']));
    }
    die;
}
add_action('wp_ajax_get_cities', 'get_cities');

/** render html part for corresponding step */
function load_step_html() {
    $error = null;

    $valid = isset($_POST['step']);
    if($valid) {
        $step_number = intval($_POST['step']);
        $validator = new Validator();

        $valid = $step_number > 1 && $step_number <= 1+count($validator->fields_rules);
        if($valid) {

            for($i=1; $valid && $i<$step_number; $i++) {
                $valid = $valid && validate_step($i);
            }

            if($valid) {
                $step = load_step($step_number);
                $f = $step['fields'];

                // TODO: ver se alguma do wordpress já faz isso
                $file = dirname(__FILE__).sprintf('/inscricoes-step%d.php', $step_number);

                if(file_exists($file)) {
                    include($file);
                }
            }
        }
    }

    if(!$valid) {
        header("HTTP/1.1 403 Forbidden");
        print __('<span class="error">Os campos da etapa anterior nao estao preenchidos corretamente.</span>');
    }
    die;
}
add_action('wp_ajax_load_step_html', 'load_step_html');


/** save field in database, if field is valid */
function setoriaiscnpc_save_field() {
    $pid = get_current_user_project();

    if(get_user_meta($pid, 'subscription_number', true)) {
        header("HTTP/1.1 403 Forbidden");
        print __('Este projeto já teve os dados submetidos e não pode mais ser alterado.');
        die;
    }

    $reponse = array();

    if(get_theme_option('inscricoes_abertas')) {
        $filter = new Filter();
        $validator = new Validator();

        foreach($_POST as $stepfield => $value) {

            if(preg_match('/^(step\d+)-([\w-]+)$/', $stepfield, $stepfield)) {
                $step = $stepfield[1];
                $field = $stepfield[2];

                $filter->apply($step, $field, $value);

                $result = $validator->validate_field($step, $field, $value, $pid);

                $response[$field] = $result;

                if($result === true) {
                    update_post_meta($pid, $field, $value);
                } else if($validator->is_required_field($step, $field)) {
                    delete_post_meta($pid, $field);
                }
            }
        }
    } else {
        foreach($_POST as $stepfield => $value) {
            if(preg_match('/^(step\d+)-([\w-]+)$/', $stepfield, $stepfield)) {
                $field = $stepfield[2];
                $response[$field] = __('Inscrições encerradas');
            }
        }
    }

    print json_encode($response);
    die; // or wordpress will print 0
}
add_action('wp_ajax_setoriaiscnpc_save_field', 'setoriaiscnpc_save_field');


/** save field in database, if field is valid */
function setoriaiscnpc_register_verify_field() {

    $reponse = array();

    $filter = new Filter();
    $validator = new Validator();
    $type_user = isset($_POST['user_type']) ? $_POST['user_type'] : "";

    foreach($_POST as $stepfield => $value) {
      
        if( $stepfield != 'action' && $stepfield != 'user_type') {
        
            $field = $stepfield;
        
            $filter->apply('register', $field, $value);

            $result = $validator->validate_field('register', $field, $value, $type_user );

            $response[$field] = $result;
        }
    }
    print json_encode($response);
    die; // or wordpress will print 0
}
add_action('wp_ajax_setoriaiscnpc_register_verify_field', 'setoriaiscnpc_register_verify_field');
add_action('wp_ajax_nopriv_setoriaiscnpc_register_verify_field', 'setoriaiscnpc_register_verify_field');


/**  */
function setoriaiscnpc_get_data_receita_by_cpf() {

    if(!isset($_POST['cpf'])) {
         header("HTTP/1.1 403 Forbidden");
         print __('CPF vazio.');
         die;
    }

    // validar antes de fazer a consulta
    $validator = new Validator();
    
    $result = $validator->validate_field('register', 'user_cpf', $_POST['cpf']);

    if( $result === true ) {

        $cpf = preg_replace("/\D+/", "", $_POST['cpf']); // remove qualquer caracter não numérico

        //jSON URL which should be requested
        $username = 'xxxxx';  // authentication
        $password = 'xxxxx';  // authentication

        // url
        $json_url = "http://desenvweb.cultura.gov.br/pessoa-ws/servicos/pessoa_fisica/consultar/{$cpf}";

        // Initializing curl
        $ch = curl_init( $json_url );

        // Configuring curl options
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $username . ":" . $password,   // authentication
        );

        // Setting curl options
        curl_setopt_array( $ch, $options );

        $result = json_decode( curl_exec($ch) ); // Getting jSON result string

        // passa somente os dados abaixo
        $str = json_encode( array( 
            "nmPessoaFisica" => trim($result->nmPessoaFisica)
        ));        
    
    }

    if( $result ) {
        wp_send_json( $str  );
        die;
    }else {
        wp_send_json(curl_error($ch));
        die;
    }

    curl_close($ch);
       
    
}   
add_action('wp_ajax_setoriaiscnpc_get_data_receita_by_cpf', 'setoriaiscnpc_get_data_receita_by_cpf');
add_action( 'wp_ajax_nopriv_setoriaiscnpc_get_data_receita_by_cpf', 'setoriaiscnpc_get_data_receita_by_cpf' );

/**
 * The store_data_to_hash() will concat strings from
 * field name and field value during form validation
 * and store in this variable, so subscribe_project()
 * generates a hash from this var and clear its content
 * after use.
 *
 * @var String
 */
static $hashhqf = '';


/** calculate hash from filled form and store in db as subscription number */
function subscribe_project() {
    global $hashhqf;
    $pid = get_current_user_project();
    $response = array();
    $response['subscription_number'] = get_post_meta($pid, 'subscription_number', true);

    if($response['subscription_number']) {
        $response['status'] = 'warning';
        $response['message'] = __('Você já fez uma inscrição. Este é o seu número de inscrição');
    } elseif(!get_theme_option('inscricoes_abertas')) {
        $response['status'] = 'warning';
        $response['message'] = __('Inscrições encerradas.');
    } else {
        if(validate_step(1,'store_data_to_hash')) {
            $subscription_number = md5($hashhqf);
            $response['subscription_number'] = $subscription_number;

            add_post_meta( $pid, 'subscription_number', $response['subscription_number'], true);
            $response['status'] = 'success';
            $response['message'] = nl2br(get_theme_option('txt_candidato_step4'));


            do_action('setoriaiscnpc_subscription_done', $subscription_number, $pid);
        } else {
            header("HTTP/1.1 403 Forbidden");
            $response =  __('O formul&aacute;rio n&atilde;o foi preenchido corretamente. Confira as etapas novamente.');
        }
        $hashhqf = '';
        unset($hashhqf);
    }

    print json_encode($response);
    die;
}
add_action('wp_ajax_subscribe_project', 'subscribe_project');

/** cancel subscription by user id */
function cancel_subscription() {
    if(current_user_can('administrator')) {
        $pid = sprintf("%d", $_POST['pid']);
        if(delete_post_meta($pid, 'subscription_number')) {
            print 'true';
            die;
        }
    }
    print 'false';
    die;
}
add_action('wp_ajax_cancel_subscription', 'cancel_subscription');

/**
 * Mark a subscrition as valid. It expects the subscription number in $_POST['subscription_number']
 * and 'true' OR 'false' in $_POST['subscription-valid']
 */
function validate_subscription() {
    global $current_user;
    if(current_user_can('administrator')) {
        // the subscriber id
        $pid = get_project_id_from_subscription_number($_POST['subscription_number']);

        if($_POST['subscription-valid'] === 'false') {
            if(delete_post_meta($pid, 'subscription-valid')) {
                die('true');
            }
        } elseif ($_POST['subscription-valid'] === 'true') {
            // aid = admin id
            $responsable = array('aid' => $current_user->ID, 'timestamp' => time());
            if(update_post_meta($pid, 'subscription-valid', $responsable)) {
                die('true');
            }
        }
    }
    print 'false';
    die;
}
add_action('wp_ajax_validate_subscription', 'validate_subscription');


function evaluate_subscription() {
    global $current_user;

    if(get_theme_option('avaliacoes_abertas') && current_user_can('curate') && !current_user_can('administrator')) {
        $pid = get_project_id_from_subscription_number($_POST['subscription']);

        if($pid > 0) {
            $expected_comments = array('arguments-comment', 'notes-comment', 'synopsis-comment', 'budget-comment', 'remarks-comment');
            $expected_scores = array('arguments-score', 'notes-score', 'synopsis-score');

            $evaluation = array();

            foreach($expected_scores as $es) {
                if(isset($_POST[$es]) && is_numeric($_POST[$es]) && $_POST[$es] >= 1 && $_POST[$es] <= 5) {
                    $evaluation[$es] = $_POST[$es];
                } else {
                    $evaluation[$es] = 0;
                }
            }

            foreach($expected_comments as $ec) {
                if(isset($_POST[$ec])) {
                    $evaluation[$ec] = $_POST[$ec];
                }
            }

            $meta_key = sprintf('evaluation_of_%d', $pid);
            $ok = update_user_meta($current_user->ID, $meta_key, $evaluation);

            if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                die($ok ? 'true' : 'false');
            } else {
                wp_redirect(site_url('inscricoes?msg=avaliacao-salva'));
            }
        }
    } else {
        wp_redirect(site_url('inscricoes'));
    }
}
add_action('wp_ajax_evaluate_subscription', 'evaluate_subscription');


function mark_as_read() {
    global $current_user;

    if(current_user_can('administrator')) {
        $pid = get_project_id_from_subscription_number($_POST['subscription']);
        if($pid) {
            if($_POST['status'] === 'read') {
                die(update_post_meta($pid, 'admin_'.$current_user->ID.'_read', true)?'true':'false');
            } else if($_POST['status'] === 'unread') {
                die(delete_post_meta($pid, 'admin_'.$current_user->ID.'_read')?'true':'false');
            }
        }
    }
    die('false');
}
add_action('wp_ajax_mark_as_read', 'mark_as_read');

function inscricoes_handle_ajax_upload() {

    $pid = get_current_user_project();

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	// VALIDATE UPLOAD

	$attachment_id = media_handle_upload( 'file-upload', $pid );

    $return = array('error' => false, 'success' => '');

    if ( is_wp_error( $attachment_id ) ) {
		$return['error'] = $attachment_id->get_error_message();
	} else {
		$return['success'] = array(
            'id' => $attachment_id,
            'html' => inscricoes_get_uploaded_template($attachment_id)
        );
	}

    header('Content-Type: application/json');
    echo json_encode($return);

    die;
}
add_action('wp_ajax_inscricoes_file_upload', 'inscricoes_handle_ajax_upload');

/***************** End of Ajax Functions *************************************/

function inscricoes_get_uploaded_template($attachment_id) {

    $url = wp_get_attachment_url($attachment_id);
    return '<a href="' . $url . '">Baixar arquivo</a>';

}

function inscricoes_file_upload_field_template($f, $step, $label, $field, $description = '') {

    ?>
    <div class="grid__item  one-whole">
        <label><?php echo $label; ?> <span class="js-current"><?php if (isset($f[$field])) echo inscricoes_get_uploaded_template($f[$field]); ?></span></label>
        <input id="<?php echo $field; ?>" class="" type="hidden" name="step<?php echo $step; ?>-<?php echo $field; ?>" value="<?php echo isset($f[$field])?$f[$field]:'';?>" />
        <div class="field-status <?php print isset($f[$field])?'completo':''?>"></div>

        <div id="<?php echo $field; ?>-upload" class="file-upload" data-field="<?php echo $field; ?>">
            <div class="js-upload-button  u-pull-left  button"><?php _e('Select File', 'historias'); ?></div>
            <div class="js-feedback  feedback  u-pull-right"></div>
        </div>
        <!-- <div id="<?php echo $field; ?>-error" class="field__error"></div> -->
        <div class="field__note"><?php echo $description; ?></div>
    </div>
    <?php

}

function store_data_to_hash($f, $v) {
    global $hashhqf;
    $line = sprintf("%s => %s\n", $f, $v);
    $hashhqf .= $line;
}

function mail_new_subscription($subscription_number, $pid) {
    $step1 = load_step(1, $pid);
    $step2 = load_step(2, $pid);
    $user = get_user_by_project_id($pid);
    $f = array_merge($step1['fields'], $step2['fields']);
    $subscription_number = substr($subscription_number, 0, 8);

    ob_start();
    include('inscricoes-mail.php');
    $mail_content = ob_get_contents();
    ob_end_clean();

    $from = sprintf("%s <%s>", get_bloginfo('admin_email'), get_bloginfo('admin_email'));
    $to = array($user->user_email, get_bloginfo('admin_email')) ;

    $header = "From: $from\r\n";
    $header .= "Content-Type: text/html\r\n";

    wp_mail($to, 'Confirmação de inscrição', $mail_content, $header);
}
add_action('setoriaiscnpc_subscription_done', 'mail_new_subscription', 10, 2);


/**
 * @param $fields An array with 'meta_key's name
 * @return An matrix that map user_id to a set of 'meta_value's
 */
function list_subscriptions($fields=null, $valid_only=true) {
    global $wpdb;

    if($fields === null) {
        $fields = array('project-title','subscription_number');
    }

    $list_query = "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='subscription_number'";

    if($valid_only === true) {
        // pelo desenho do sistema, não é possível que haja 'subscription-valid' sem 'subscription_number'
        $list_query = "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='subscription-valid'";
    } else {
        $fields[] = 'subscription-valid';
    }

    $op = '';
    $where = '(';
    foreach($fields as $f) {
        $where .= $op . "meta_key='{$f}'";
        $op = ' OR ';
    }
    $where .= ')';

    $projects = $wpdb->get_col($list_query);
    $records = array();

    foreach($projects as $pid) {
        $results = $wpdb->get_results("SELECT meta_key, meta_value FROM {$wpdb->postmeta} WHERE {$where} AND post_id={$pid}");
        $record = array();

        $record['pid'] = $pid;
        foreach($results as $r) {
            $record[$r->meta_key] = $r->meta_value;
        }
        $records[] = $record;
    }
    return $records;
}


// não sei pq funciona, mas os valores de cidades e estados não estão utf8 na base

/** get states from a given region */
function get_states_by_region($region) {
    $regions = array(
        'nortecentroeste' => array(
            array('id'=>'12', 'nome'=>'Acre'),                  //
            array('id'=>'13', 'nome'=>'Amazonas'),               //
            array('id'=>'16', 'nome'=>'Amapá'),                  //
            array('id'=>'15', 'nome'=>'Pará'),                   // norte
            array('id'=>'11', 'nome'=>'Rondônia'),               //
            array('id'=>'14', 'nome'=>'Roraima'),                //
            array('id'=>'17', 'nome'=>'Tocantins'),               //

            array('id'=>'53', 'nome'=>'Distrito Federal'),      //
            array('id'=>'52', 'nome'=>'Goiás'),                  // centroeste
            array('id'=>'50', 'nome'=>'Mato Grosso do Sul'),     //
            array('id'=>'51', 'nome'=>'Mato Grosso'),             //
        ),
        'nordeste'=>array(
            array('id'=>'27', 'nome'=>'Alagoas'),
            array('id'=>'29', 'nome'=>'Bahia'),
            array('id'=>'23', 'nome'=>'Ceará'),
            array('id'=>'21', 'nome'=>'Maranhão'),
            array('id'=>'25', 'nome'=>'Paraíba'),
            array('id'=>'26', 'nome'=>'Pernambuco'),
            array('id'=>'22', 'nome'=>'Piauí'),
            array('id'=>'24', 'nome'=>'Rio Grande do Norte'),
            array('id'=>'28', 'nome'=>'Sergipe')
        ),
        'sudeste'=>array(
            array('id'=>'32', 'nome'=>'Espírito Santo'),
            array('id'=>'31', 'nome'=>'Minas Gerais'),
            array('id'=>'33', 'nome'=>'Rio de Janeiro'),
            array('id'=>'35', 'nome'=>'São Paulo')
        ),
        'sul'=>array(
            array('id'=>'41', 'nome'=>'Paraná'),
            array('id'=>'43', 'nome'=>'Rio Grande do Sul'),
            array('id'=>'42', 'nome'=>'Santa Catarina')
        )
    );

    if(isset($regions[$region])) {
        return $regions[$region];
    }
}

/** loads cities from a given state */
function get_cities_by_state_id($state_id, $except=null) {
    global $wpdb;
    return $wpdb->get_results($wpdb->prepare('SELECT id, nome FROM municipio WHERE ufid = %d and id <> %d ORDER BY nome', $state_id, $except));
}

/** get city name from given id */
function get_city_name_by_id($id) {
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare('SELECT nome FROM municipio WHERE id = %d', $id));
}

/** get city from given id */
function get_city_by_id($id) {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare('SELECT id, nome FROM municipio WHERE id = %d', $id));
}

/** get state from given id */
function get_state_name_by_id($id) {
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare('SELECT nome FROM uf WHERE id = %d', $id));
}

/** get state from given id */
function get_state_by_id($id) {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare('SELECT id, nome FROM uf WHERE id = %d', $id));
}

/** get user from subscription number (that will be an hexa) */
function get_user_from_subscription_number($n) {
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE"
                                         ." meta_key = 'subscription_number'"
                                         ." AND meta_value LIKE %s", $n.'%'));
}

/**
 * Return an array with status and fields of specified step
 */
function load_step($n, $pid=null) {
    global $current_user;

    if($pid === null) {
        $pid = get_current_user_project();
    }

    $complete = true;
    $fields = array();
    $step = sprintf("step%d", $n);

    $validator = new Validator();

    if(isset($validator->fields_rules[$step])) {
        foreach($validator->fields_rules[$step] as $field => $func_array) {
            $value = get_post_meta($pid, $field, true);
            if($value) {
                $valid_field = ($validator->validate_field($step, $field, $value, $pid) === true);
                if($valid_field) {
                    $fields[$field] = esc_attr($value);
                }
                $complete = $complete && ($valid_field || ! $validator->is_required_field($step, $field));
            } else if($validator->is_required_field($step, $field)) {
                $complete = false;
            }
        }
    } else {
        $complete = false;
    }
    return array('complete' => $complete, 'fields' => $fields);
}

function load_evaluation($pid, $curator=null) {
    global $current_user;

    if(is_null($curator)) {
        $curator = $current_user->ID;
    }

    if(user_can($curator, 'curate')) {
        $meta_key = sprintf('evaluation_of_%d', $pid);
        $eval = get_user_meta($curator, $meta_key, true);

        if($eval) {
            foreach($eval as $key => $value) {
                if(strpos($key, '-comment') > 0) {
                    $eval[$key] = esc_attr($value);
                }
            }
        }
        
        if (!isset($eval["synopsis-score"]))
            $eval["synopsis-score"] = 0;
        
        if (!isset($eval["arguments-score"]))
            $eval["arguments-score"] = 0;
        
        if (!isset($eval["notes-score"]))
            $eval["notes-score"] = 0;
        
        
        return $eval;
    }
    return false;
}

/** validate all fields from subscription form by given step number */
function validate_step($n,$hook=null) {
    $pid = get_current_user_project();

    $step = sprintf("step%d", $n);
    $validator = new Validator();

    $valid = isset($validator->fields_rules[$step]);
    if($valid) {
        $fields = array_keys($validator->fields_rules[$step]);

        foreach($fields as $field) {
            $value = get_post_meta($pid, $field, true);

            if($hook && is_callable($hook) && $validator->is_required_field($step, $field)) {
                call_user_func($hook, $field, $value);
            }

            $valid = (true === $validator->validate_field($step, $field, $value, $pid))
                     || ! $validator->is_required_field($step, $field);

            if(!$valid) break;
        }
    }
    return $valid;
}


function user_is_a_valid_cpf($cpf) {
    $error = false;
    $cpf = preg_replace('/[^0-9]/','',$cpf);

    if(strlen($cpf) !=  11 || preg_match('/^([0-9])\1+$/', $cpf)) {
        return $error;
    }

    // 9 primeiros digitos do cpf
    $digit = substr($cpf, 0, 9);

    // calculo dos 2 digitos verificadores
    for($j=10; $j <= 11; $j++){
        $sum = 0;
        for($i=0; $i< $j-1; $i++) {
            $sum += ($j-$i) * ((int) $digit[$i]);
        }

        $summod11 = $sum % 11;
        $digit[$j-1] = $summod11 < 2 ? 0 : 11 - $summod11;
    }

    if($digit[9] == ((int)$cpf[9]) && $digit[10] == ((int)$cpf[10])) {
        return true;
    } else {
        return $error;
    }
}

function is_a_valid_birth($d) {

    $format = "d/m/Y";

    $dateTime = DateTime::createFromFormat($format, $d);
    
    $errors = DateTime::getLastErrors();
    if (!empty($errors['warning_count'])) {
        return false;
    }
    return true;
}

function convert_format_date( $d ) {
    $format = "d/m/Y";
    $dateTime = DateTime::createFromFormat($format, $d);
    return $dateTime->format("Y-m-d");  
}

function restore_format_date( $d ) {
    $format = "Y-m-d";
    $dateTime = DateTime::createFromFormat($format, $d);
    return $dateTime->format("d/m/Y");  
}

/**
 * Instead valitade, this class should apply a chain of filters over
 * a filter to change its value.
 */
class Filter {
    public $fields_rules = array(
        'step1' => array(
            'candidate-phone-1' => array('remove_empty_mask','trim_spaces_and_undescore')
        ),
        'register' => array(
            'user_birth' => array('remove_empty_mask','trim_spaces_and_undescore'),
            'user_cpf' => array('remove_empty_mask','trim_spaces_and_undescore')
        )
    );

    public function apply($s, $f, &$v) {
        if(isset($this->fields_rules[$s]) && isset($this->fields_rules[$s][$f])) {
            foreach($this->fields_rules[$s][$f] as $function) {
                $v = call_user_func(array($this, $function), $v);
            }
            return true;
        }
        return false;;
    }

    static function trim_spaces_and_undescore($v) {
        return preg_replace('/(^[ _]*|[ _]*$)/', '', $v);
    }

    static function remove_empty_mask($v) {
        if(preg_match('/^\(__\) ____+/', $v)) {
            return '';
        }
        return $v;
    }
}

class Validator {
    public $fields_rules = array(
        'step1' => array(
            'candidate-display-name' => array(),
            'candidate-phone-1' => array('not_empty','is_a_valid_phone'),
            'candidate-avatar' => array('not_empty'),
            'candidate-portfolio' => array('not_empty'),
            'candidate-activity-history' => array('not_empty'),
            'candidate-diploma' => array('not_empty'),
            'candidate-profissional-register' => array('not_empty'),
            'candidate-participation-statement' => array('not_empty'),
            'candidate-experience' => array('not_empty'),
            'candidate-explanatory' => array('not_empty')
        ),
        'register' => array(
            'user_cpf' => array('not_empty','is_a_valid_cpf', 'user_cpf_does_not_exist'),
            'user_name' => array('not_empty'),
            'user_email' => array('not_empty','is_valid_email','is_email_does_not_exist'),
            'user_password' => array('not_empty'),
            'user_birth' => array('not_empty','is_a_valid_date','is_a_valid_birth')
        )
    );

    /**
    * Return 'true' if field is valid, an error message if field is invalid
    * or 'null' if field is not recognized
    *
    * @param String $s the step
    * @param String $f the field
    * @param String $v the values ...
    */
    function validate_field($s, $f, $v) {
        $args_v = array_slice(func_get_args(), 2);

        if(isset($this->fields_rules[$s]) && isset($this->fields_rules[$s][$f])) {
            foreach($this->fields_rules[$s][$f] as $function) {
                $result = call_user_func_array(array($this, $function), $args_v);

                if($result !== true) {
                    return $result;
                }
            }
            return true;
        }
        return null;
    }

    /** @return true if field is require and false otherwise */
    function is_required_field($s, $f) {
        return isset($this->fields_rules[$s])
               && isset($this->fields_rules[$s][$f])
               && in_array('not_empty',($this->fields_rules[$s][$f]));
    }

    /** Return true if parameter is not empty or a message otherwise */
    static function not_empty($v) {
        if(!isset($v) || empty($v)) {
            return __('Este campo não pode ser vazio');
        }
        return true;
    }

    /** Return true if supplied email is valid or give an error message otherwise */
    static function is_valid_email($e) {
        if(filter_var($e, FILTER_VALIDATE_EMAIL) === $e) {
            return true;
        }
        return __('O email não tem um formato válido');
    }

    /** Return true if supplied email is valid or give an error message otherwise */
    static function is_email_does_not_exist($e) {

        if( email_exists( $e ) ) {
            return __('Já existe um usuário com o email informado'); 
        }
        return true;
       
    }

    /** Return true if supplied cpf is valid or give an error message otherwise */
    static function is_a_valid_cpf($cpf) {
        $error = __("O CPF fornecido é inválido.");
        $cpf = preg_replace('/[^0-9]/','',$cpf);

        if(strlen($cpf) !=  11 || preg_match('/^([0-9])\1+$/', $cpf)) {
            return $error;
        }

        // 9 primeiros digitos do cpf
        $digit = substr($cpf, 0, 9);

        // calculo dos 2 digitos verificadores
        for($j=10; $j <= 11; $j++){
            $sum = 0;
            for($i=0; $i< $j-1; $i++) {
                $sum += ($j-$i) * ((int) $digit[$i]);
            }

            $summod11 = $sum % 11;
            $digit[$j-1] = $summod11 < 2 ? 0 : 11 - $summod11;
        }

        if($digit[9] == ((int)$cpf[9]) && $digit[10] == ((int)$cpf[10])) {
            return true;
        } else {
            return $error;
        }
    }

    static function cpf_does_not_exist($c,$pid) {
        global $wpdb;
        $result = $wpdb->get_var($wpdb->prepare("select count(1) from {$wpdb->postmeta} where meta_key='candidate-cpf' and post_id<>%d and meta_value='%s';",$pid,$c));
        if($result > 0) {
            return __('Já existe um candidato cadastrado com este CPF.');
        }
        return $result == 0; // $result provavelmente é String
    }

    function user_cpf_does_not_exist($c) {
        global $wpdb;

        $result = $wpdb->get_var($wpdb->prepare("SELECT count(1) FROM {$wpdb->usermeta} WHERE"
                                            ." meta_key='cpf' and meta_value='%s';",$c));
        
        if($result > 0) {
            return __('Já existe um usuário cadastrado com este CPF.');
        }
        return $result == 0; // $result provavelmente é String
    }

    /** Return true if supplied cpf is valid or give an error message otherwise */
    static function is_a_valid_cnpj($cnpj) {
        $error = __("O CNPJ fornecido é inválido.");
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if(strlen($cnpj) != 14) {
            return $error;
        }

        $mask = array(6,5,4,3,2,9,8,7,6,5,4,3,2);

        $a = array();
        $b = 0;
        for($i=0; $i < 12; $i++) {
            $a[] = (int) $cnpj[$i];
            $b += $a[$i] * $mask[$i+1];
        }

        $x = $b % 11;
        if($x < 2) {
            $a[12] = 0;
        } else {
            $a[12] = 11 - $x;
        }

        $b = 0;
        for($i=0; $i < 13; $i++) {
            $b += $a[$i] * $mask[$i];
        }

        $x = $b % 11;
        if($x < 2) {
            $a[13] = 0;
        } else {
            $a[13] = 11 - $x;
        }

        if($cnpj[12] == $a[12] && $cnpj[13] == $a[13]) {
            return true;
        }
        return $error;
    }

    static function cnpj_does_not_exist($c,$pid) {
        global $wpdb;
        $result = $wpdb->get_var($wpdb->prepare("select count(1) from {$wpdb->postmeta} where meta_key='company-cnpj' and post_id<>%d and meta_value='%s';",$pid,$c));
        if($result > 0) {
            return __('Já existe um projeto cadastrado com este CNPJ.');
        }
        return $result == 0; // $result provavelmente é String
    }

    static function maximum_2_projects_with_same_cnpj($c,$pid) {
        global $wpdb;

        // corta o cnpj antes da /
        $c = substr($c, 0, strrpos($c, '/'));

        $result = $wpdb->get_var($wpdb->prepare("select count(1) from {$wpdb->postmeta} where meta_key='company-cnpj' and post_id<>%d and meta_value like '%s';",$pid,$c.'%'));
        if($result > 1) {
            return __('Já existem dois projetos cadastrados com este CNPJ.');
        }
        return true; // $result provavelmente é String
    }

    static function is_a_valid_cep($c) {
        if(preg_match('/^\d\d\d\d\d-\d\d\d$/', $c)) {
            return true;
        }
        return __('O CEP fornecido é invalido');
    }

    static function is_a_valid_phone($p) {
        if(empty($p) || preg_match('/^\(\d\d\) \d{6,9}$/', $p)) {
            return true;
        }
        return __('O número do telefone é invalido');
    }

    static function is_brl_money_format($v) {
        if(preg_match('/^R\$ \d\d?\d?(\.\d\d\d)*,\d\d$/', $v)){
            return true;
        }
        return __('Formato inválido para o valor. Por favor apague e comece novamente.');
    }

    static function is_non_zero_money_ammount($v) {
        if(preg_match('/^R\$ 0+(\.000)*,00*$/', $v)){
            return __('O valor não pode ser zero.');
        }
        return true;
    }

    static function is_a_valid_date($d) {

        $format = "d/m/Y";

        $dateTime = DateTime::createFromFormat($format, $d);
        
        $errors = DateTime::getLastErrors();
        if (!empty($errors['warning_count'])) {
            return __( 'Formato de data inválido. Por favor apague e tente novamente.');
        }
        return true;
    }

    static function is_a_valid_birth( $d, $user_type=null) {

        $today = gmdate( 'Y-m-d', ( time() + ( get_option( 'gmt_offset' ) * 3600 ) ));
        $birth = preg_replace( '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', '$3-$2-$1', $d );

        $interval = date_diff( date_create($birth), date_create($today) );

        if($interval->format("%a") < 6574 && $user_type == 'candidato' )
            return __( 'A idade mínima para candidado é de 18 anos.');
        else if($interval->format("%a") < 5844 && $user_type == 'eleitor')
            return __( 'A idade mínima para eleitor é de 16 anos.');

        return true;
    }
   
    static function total_budget_is_valid($total, $pid=null) {
        if(!is_null($pid) && is_numeric($pid)) {
            $values = array(
                get_post_meta($pid,'budget-pre-production', true),
                get_post_meta($pid,'budget-production', true),
                get_post_meta($pid,'budget-post-production', true),
                '-'.$total
            );
            $sum = 0.00;
            foreach($values as $v) {
                if(preg_match('/^(-)?R\$ ([1-9]\d?\d?(\.\d\d\d)*,\d\d)$/', $v, $m)){
                    $m = $m[1] . str_replace('.','',$m[2]);
                    $m = str_replace(',','.',$m);
                    $sum += floatval($m); // round to intval could be a good idea
                }
            }
            if($sum < 0.01) {
                return true;
            } else {
                return __('O valor total não condiz com os valores da pré-produção, produção e pós-produção.');
            }
        } else {
            return __('Não é possível calcular o orçamento total através de um usuário inválido.');
        }
    }
    
    static function total_budget_is_less_than_limit($total, $pid=null) {
        if(!is_null($pid) && is_numeric($pid)) {
            $limit = get_theme_option('limite_orcamento');
            
            if ($limit && is_numeric($limit))
                $limit = intval($limit);
            else
                $limit = 330000;
            
            if(preg_match('/^(-)?R\$ ([1-9]\d?\d?(\.\d\d\d)*,\d\d)$/', $total, $m)){
                $m = $m[1] . str_replace('.','',$m[2]);
                $m = str_replace(',','.',$m);
                $total += floatval($m); // round to intval could be a good idea
            }
            
            if($total <= $limit) {
                return true;
            } else {
                return __('O valor total não pode ser superior a R$'.$limit.',00');
            }
        } else {
            return __('Não é possível calcular o orçamento total através de um usuário inválido.');
        }
    }

    static function str_length_less_than_600($v) {
        if(strlen(utf8_decode($v)) > 600) { // php não sabe contar utf8
            return __('O texto não deve exceder 600 caracteres.');
        }
        return true;
    }

    static function str_length_less_than_3000($v) {
        if(strlen(utf8_decode($v)) > 3000) {
            return __('O texto não deve exceder 4000 caracteres.');
        }
        return true;
    }

    static function str_length_less_than_4000($v) {
        if(strlen(utf8_decode($v)) > 4000) {
            return __('O texto não deve exceder 4000 caracteres.');
        }
        return true;
    }

    static function str_length_less_than_8000($v) {
        if(strlen(utf8_decode($v)) > 8000) {
            return __('O texto não deve exceder 8000 caracteres.');
        }
        return true;
    }
}
