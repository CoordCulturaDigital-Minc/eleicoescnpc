<?php 
class Validator {
    public $fields_rules = array(
        'register' => array(
            'user_cpf' => array('not_empty','is_a_valid_cpf', 'user_cpf_does_not_exist', 'cpf_not_in_blacklist', 'cpf_not_in_list_two_years', 'cpf_exists_in_receita'),
            'user_name' => array('not_empty'),
            'user_email' => array('not_empty','is_valid_email','is_email_does_not_exist'),
            'user_password' => array('not_empty'),
            'user_birth' => array('not_empty','is_a_valid_date','is_a_valid_birth'),
            'user_confirm_informations' => array('not_empty')
        ),
        'step1' => array(
            'candidate-confirm-infos' => array('not_empty'),
            'candidate-display-name' => array(),
            'candidate-phone-1' => array('not_empty','is_a_valid_phone'),
            'candidate-race' => array('not_empty'),
            'candidate-genre' => array('not_empty'),
            'candidate-avatar' => array('not_empty'),
            'candidate-experience' => array('not_empty','str_length_less_than_400'),
            'candidate-explanatory' => array('not_empty','str_length_less_than_400')
        ),
        'step2' => array(
            'candidate-portfolio' => array('not_empty'),
            'candidate-activity-history' => array(),
            'candidate-diploma' => array(),
            'candidate-confirm-data' => array('not_empty')
        ),
        'extra' => array(
            'user_cpf' => array('cpf_not_in_blacklist', 'cpf_not_in_list_two_years'),
            'user_birth' => array('is_a_valid_date','is_a_valid_birth')
        ),
        'formulario-contato' => array(
            'nome' => array('not_empty'),
            'email' => array('not_empty','is_valid_email'),
            'mensagem' => array('not_empty'),
            'assunto' => array()
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
        return __('O e-mail não tem um formato válido');
    }

    /** Return true if supplied email is valid or give an error message otherwise */
    static function is_email_does_not_exist($e) {

        if( email_exists( $e ) ) {
            return __('Já existe um usuário com o e-mail informado'); 
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

    static function user_cpf_does_not_exist($c) {
        global $wpdb;

        $result = $wpdb->get_var($wpdb->prepare("SELECT count(1) FROM {$wpdb->usermeta} WHERE"
                                            ." meta_key='cpf' and meta_value='%s';",$c));
        
        if($result > 0) {
            return __('Já existe um usuário cadastrado com este CPF.');
        }
        return $result == 0; // $result provavelmente é String
    }

    static function cpf_exists_in_receita($c) {

        if (!defined('VERIFICA_CPF_RECEITA') || VERIFICA_CPF_RECEITA !== true)
            return true;

        if( empty( $c ) )
            return __('CPF não informado.');

        $result = get_cpf_data_in_receita($c);

        if (isset( $result->errors)) {
            if ( strcmp( $result->errors, "Transaction rolled back") == 0 ) {
                return __('Este cpf não está cadastrado na base da receita federal.');
            }else
                return $result->errors;
        }

        return true;
    }
    
    static function cpf_not_in_blacklist($c, $user_type=null) {
     
        if( $user_type == 'eleitor')
            return true;

        if( empty($c) )
            return 'Cpf não informado';

        $blacklist = get_theme_option('candidatos_blacklist');

        if( !empty( $blacklist) ) {

            if( in_array($c, $blacklist) )
                return 'Você já é delegado nato na etapa nacional';
        }
		
        return true; 
	}

    static function cpf_not_in_list_two_years($c, $user_type=null) {
     
        if( $user_type == 'eleitor')
            return true;

        if( empty($c) )
            return 'Cpf não informado';

        $blacklist = get_theme_option('delegates_two_years');

        if( !empty( $blacklist) ) {

            if( in_array($c, $blacklist) )
                return 'Conforme item x(2 anos), do edital, você não pode se candidatar!'; //TODO alterar o texto
        }
        
        return true; 
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

        if( $user_type !== 'candidato' && $user_type !== 'eleitor')
            $user_type = 'candidato';

        $today = gmdate( 'Y-m-d', ( time() + ( get_option( 'gmt_offset' ) * 3600 ) ));
        $birth = preg_replace( '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', '$3-$2-$1', $d );

        $interval = date_diff( date_create($birth), date_create($today) );

        if($interval->format("%a") < 6574 && $user_type == 'candidato' )
            return __( 'A idade mínima para ser candidato é de 18 anos.');
        else if($interval->format("%a") < 5844 && $user_type == 'eleitor')
            return __( 'A idade mínima para ser eleitor é de 16 anos.');

        return true;
    }
   
    static function str_length_less_than_400($v) {
        if(strlen(utf8_decode($v)) > 400) { // php não sabe contar utf8
            return __('O texto não deve exceder 400 caracteres.');
        }
        return true;
    }

}

 ?>