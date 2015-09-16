<?php

/*
 * "Inclusion of files"
 */
// include('validation.php'); //Validation of values
include('form.class.php'); //Validation of values

/*
 * Flame and includes the JavaScript file,
 * responsible for sending the data via AJAX
 */
add_action('wp_print_scripts', 'form_modular');
function form_modular() {
    wp_enqueue_script('form', get_stylesheet_directory_uri().'/includes/contactform/form.js', array('jquery'));

    wp_enqueue_style('form', get_stylesheet_directory_uri().'/includes/contactform/css/form.css');

    wp_localize_script('form', 'formvars', array ( 'ajaxurl' => admin_url('admin-ajax.php')) );
}

/*
 * Proccess Data
 */
function form_process () {
    if ( isset($_GET['send']) ) :
        $validation = new Validator();

        $struct = array(
            'sucesso' => true,
            'error_messages' => array(),
            'fields' => array()
        );

        $formID = $_GET['formID'];
        $emailMsg = '';
        
        global $congeladoForm;
        $form = $congeladoForm->forms;
        
        if (isset($form[$formID]) && is_array($form[$formID])) {
            
            $formFields = $form[$formID];
            
            foreach ($formFields as $fieldname => $fieldrules) :
                
                $fieldvalue = isset($_GET[$fieldname]) ? $_GET[$fieldname] : '';
                
                $valid = $validation->validate_field($formID, $fieldname, $fieldvalue);
                
                if ($valid === true) :
                    $struct['fields'][$fieldname] = $fieldvalue;
                    $emailMsg .= $fieldname . ': ' . $fieldvalue . "\n\n";
                else :
                    $struct['sucesso'] = false;
                    $struct['error_messages'][$fieldname] = $valid;
                endif;

            endforeach;
        
        }
        
        

        //Callback with the value chain ready for use
        if ( $struct['sucesso'] ) :

            //Values of ADMIN
            $opcoes = get_option( 'congeladoform' );

            if ( is_array($opcoes) && isset($opcoes[$formID]) && is_array($opcoes[$formID])  && isset($opcoes[$formID]['email']) && !empty($opcoes[$formID]['email'])) :
                $emailTo = $opcoes[$formID]['email'];
            else :
                $emailTo = get_option('admin_email');
            endif;

            if ( is_array($opcoes) && isset($opcoes[$formID]) && is_array($opcoes[$formID])  && isset($opcoes[$formID]['assunto']) && !empty($opcoes[$formID]['assunto'])) :
                $subjectTo = $opcoes[$_GET['formID']]['assunto'];
            else :
                $subjectTo = get_option('assunto');
            endif;
            
            //save
            
            if ( is_array($opcoes) && isset($opcoes[$formID]) && is_array($opcoes[$formID])  && isset($opcoes[$formID]['save']) && $opcoes[$formID]['save'] == 1 ) {
            
                $rows = get_option('congeladoform_saved_' . $formID);
                if (!is_array($rows))
                    $rows = array();
                
                array_push($rows, $struct['fields']);
                
                delete_option('congeladoform_saved_' . $formID);
                
                add_option('congeladoform_saved_' . $formID, $rows, '', 'no');
            
            }
            
            $struct['sucesso'] = wp_mail($emailTo, $subjectTo, $emailMsg);

            if (!$struct['sucesso']) :
                $struct['error_messages']['general'] = 'Falha ao enviar o e-mail';
            endif;

        endif;
        //returns true and clears the form in JS
        print json_encode($struct);
    else :
        header("HTTP/1.1 400 Bad Request");
    endif;
    die;
}
add_action('wp_ajax_form_process', 'form_process');
add_action('wp_ajax_nopriv_form_process', 'form_process');
