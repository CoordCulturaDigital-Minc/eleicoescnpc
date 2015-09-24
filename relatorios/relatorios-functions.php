<?php

/* relatórios */

function get_count_users_states() {

    global $wpdb;

    $states = get_all_states();

    $count = array();

    foreach( $states as $key => $state )
    {   
         $count[$key] = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->usermeta} WHERE meta_key = 'uf' AND meta_value = %s", $key ) );
    }

    return $count;
}

function get_count_users_states_by_uf($uf){ 

    global $wpdb;
    
    $count = $wpdb->get_var( $wpdb->prepare( "SELECT count(u.user_id) FROM {$wpdb->usermeta} as u "
                                                  ."INNER JOIN {$wpdb->usermeta} as um ON u.user_id = um.user_id "
                                                  ."WHERE um.meta_key = 'uf'"
                                                  ."AND u.meta_key = 'UF'"    
                                                  ."AND um.meta_value = %s", $uf ) );
    
    return $count;
}

function get_count_users_setorial_uf($uf = false, $setorial = false) {
    global $wpdb;
    
    $inner = '';
    $where = '';
    $args = [];

    if ($uf) {
        $inner .= "INNER JOIN {$wpdb->usermeta} um1 ON um1.user_id = u.ID ";
        $where .= "AND um1.meta_key = 'UF' AND um1.meta_value = %s ";
        $args[] = $uf;
    }
    if ($setorial) {
        $inner .= "INNER JOIN {$wpdb->usermeta} um2 ON um2.user_id = u.ID ";
        $where .= "AND um2.meta_key = 'setorial' AND um2.meta_value = %s ";
        $args[] = $setorial;
    }
    
    
    $results = $wpdb->get_var($wpdb->prepare("SELECT count(u.ID) "
                                            ."FROM {$wpdb->users} u "
                                            . $inner
                                            ."WHERE 1=1 "
                                            . $where, $args));
    return $results;
}

function get_count_candidates_setoriais_by_uf($uf) {
    global $wpdb;

    if( empty($uf) )
        return false;

    $setorais = get_setoriais();

    $count = array();

    foreach( $setorais as $key => $setorial )
    {   
         // $count[$key] = $wpdb->get_var( $wpdb->prepare("SELECT count(u.umeta_id) FROM {$wpdb->usermeta} AS u INNER JOIN {$wpdb->usermeta} AS us ON u.user_id = us.user_id where u.meta_key = 'uf' AND u.meta_value = %s AND us.meta_key = 'e_candidato'", $key ) );
    
        $count[$key] = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(u.umeta_id)" 
                                                    ."FROM {$wpdb->posts} as p " 
                                                    ."INNER JOIN {$wpdb->postmeta} as m ON p.ID = m.post_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as u ON p.post_author = u.user_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as um ON p.post_author = um.user_id "
                                                    ."WHERE p.post_type = 'projetos' "
                                                    ."AND m.meta_key = 'subscription-valid' " 
                                                    ."AND u.meta_key = 'setorial' AND u.meta_value = %s "
                                                    ."AND um.meta_key = 'uf' AND um.meta_value = %s", $key, $uf ) );
    }

    return $count;
}


function get_count_candidates_by_setorial($setorial) {
    global $wpdb;

    if( empty($setorial) )
        return false;

    $states = get_all_states();
    
    $count = array();

    foreach($states as $uf => $state )
    {   
        $count[$uf] = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(u.umeta_id)" 
                                                    ."FROM {$wpdb->posts} as p " 
                                                    ."INNER JOIN {$wpdb->postmeta} as m ON p.ID = m.post_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as u ON p.post_author = u.user_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as um ON p.post_author = um.user_id "
                                                    ."WHERE p.post_type = 'projetos' "
                                                    ."AND m.meta_key = 'subscription-valid' " 
                                                    ."AND u.meta_key = 'setorial' AND u.meta_value = %s "
                                                    ."AND um.meta_key = 'uf' AND um.meta_value = %s", $setorial, $uf ) );
    }
    
    return $count;
}


function get_count_candidates($uf = false, $setorial = false, $only_subscription_valid = true) {
    global $wpdb;
    
    $inner = '';
    $where = '';
    $args = [];
    
    if ($uf) {
        $inner .= "INNER JOIN {$wpdb->usermeta} um2 ON um2.user_id = u.user_id ";
        $where .= "AND um2.meta_key = 'UF' AND um2.meta_value = %s ";
        $args[] = $uf;
    }
    if ($setorial) {
        $inner .= "INNER JOIN {$wpdb->usermeta} um3 ON um3.user_id = u.user_id ";
        $where .= "AND um3.meta_key = 'setorial' AND um3.meta_value = %s ";
        $args[] = $setorial;
    }

    $inner .= "INNER JOIN {$wpdb->postmeta} as pm ON p.ID = pm.post_id ";
    if ($only_subscription_valid) {
        $where .= "AND pm.meta_key = 'subscription-valid' ";
    } else {
        $where .= "AND pm.meta_key = 'candidate-confirm-infos' ";
    }
    
    $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(u.umeta_id) " 
                                                    ."FROM {$wpdb->posts} as p " 
                                                    ."INNER JOIN {$wpdb->usermeta} as u ON p.post_author = u.user_id "
                                                    . $inner
                                                    ."WHERE p.post_type = 'projetos' "
                                                    ."AND u.meta_key = 'setorial' AND u.meta_value != '' "
                                                    . $where,
    $args));
    
    return $count;
}


function get_count_users_setoriais_by_uf( $uf ) {

    global $wpdb;

    if( empty( $uf ) )
        return false;

    $setoriais = get_setoriais();

    $count = array();

    foreach( $setoriais as $key => $setorial )
    {   
         $count[$key] = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->usermeta} as u "
                                                        ."INNER JOIN {$wpdb->usermeta} as um ON u.user_id = um.user_id "
                                                        ."WHERE u.meta_key = 'setorial' "
                                                        ."AND u.meta_value = %s"
                                                        ."AND um.meta_key = 'uf'"
                                                        ."AND um.meta_value = %s", $key, $uf ) );
    }
    
    return $count;
}


function get_count_users_by_setorial( $setorial ) {

    global $wpdb;

    if( empty( $setorial ) )
        return false;
    $states = get_all_states();
    
    $count = array();
    foreach($states as $uf => $state ) {   
        $count[$uf] = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->usermeta} as u "
                                                        ."INNER JOIN {$wpdb->usermeta} as um ON u.user_id = um.user_id "
                                                        ."WHERE u.meta_key = 'setorial' "
                                                        ."AND u.meta_value = %s "
                                                        ."AND um.meta_key = 'uf' "
                                                        ."AND um.meta_value = '%s' ", $setorial, $uf ) );
    }
    return $count;
}


function get_count_candidates_states() {

    global $wpdb;

    $states = get_all_states();

    $count = array();

    foreach( $states as $key => $state )
    {   
         // $count[$key] = $wpdb->get_var( $wpdb->prepare("SELECT count(u.umeta_id) FROM {$wpdb->usermeta} AS u INNER JOIN {$wpdb->usermeta} AS us ON u.user_id = us.user_id where u.meta_key = 'uf' AND u.meta_value = %s AND us.meta_key = 'e_candidato'", $key ) );
    
        $count[$key] = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(u.umeta_id)" 
                                                    ."FROM {$wpdb->posts} as p " 
                                                    ."INNER JOIN {$wpdb->postmeta} as m ON p.ID = m.post_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as u ON p.post_author = u.user_id "
                                                    ."WHERE p.post_type = 'projetos' "
                                                    ."AND m.meta_key = 'subscription-valid' " 
                                                    ."AND u.meta_key = 'uf' AND u.meta_value = %s", $key ) );
    }

    return $count;
}


function get_count_users_setoriais() {

    global $wpdb;

    $setoriais = get_setoriais();

    $count = array();

    foreach( $setoriais as $key => $setorial )
    {   
         $count[$key] = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->usermeta} WHERE meta_key = 'setorial' AND meta_value = %s", $key ) );
    }
    
    return $count;
}


function get_count_candidates_setoriais_genre_by_uf($uf) {
    global $wpdb;

    if( empty($uf) )
        return false;

    $setorais = get_setoriais();

    $count = array();
    $results = array();

    foreach( $setorais as $key => $setorial )
    {   
        $count[$key] = $wpdb->get_results( $wpdb->prepare("SELECT COUNT(u.umeta_id) as count,"
                                                    ."mm.meta_value AS genre "                 
                                                    ."FROM {$wpdb->posts} as p " 
                                                    ."INNER JOIN {$wpdb->postmeta} as m ON p.ID = m.post_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as u ON p.post_author = u.user_id "
                                                    ."INNER JOIN {$wpdb->postmeta} as mm ON p.ID = mm.post_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as uu ON p.post_author = uu.user_id "        
                                                    ."WHERE p.post_type = 'projetos' "
                                                    ."AND m.meta_key = 'subscription-valid' " 
                                                    ."AND u.meta_key = 'setorial' AND u.meta_value = %s "
                                                    ."AND mm.meta_key = 'candidate-genre'"
                                                    ."AND uu.meta_key = 'uf' AND uu.meta_value = %s"
                                                    ."GROUP BY genre", $key, $uf) );
        if (!empty($count[$key])) {
            foreach($count[$key] as $item) {
                if ($item->genre == 'masculino') {
                    $results[$key]['masculino'] = $item->count;
                } else if ($item->genre == 'feminino')  {
                    $results[$key]['feminino'] = $item->count;
                }
            }
        }
    }
    
    return $results;
}


function get_count_candidates_setoriais_afrodesc_by_uf($uf) {
    global $wpdb;

    if( empty($uf) )
        return false;

    $setorais = get_setoriais();

    $count = array();
    $results = array();
    
    foreach( $setorais as $key => $setorial )
    {   
        $count[$key] = $wpdb->get_results( $wpdb->prepare("SELECT COUNT(u.umeta_id) as count,"
                                                    ."mm.meta_value AS race "                 
                                                    ."FROM {$wpdb->posts} as p " 
                                                    ."INNER JOIN {$wpdb->postmeta} as m ON p.ID = m.post_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as u ON p.post_author = u.user_id "
                                                    ."INNER JOIN {$wpdb->postmeta} as mm ON p.ID = mm.post_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as uu ON p.post_author = uu.user_id "        
                                                    ."WHERE p.post_type = 'projetos' "
                                                    ."AND m.meta_key = 'subscription-valid' " 
                                                    ."AND u.meta_key = 'setorial' AND u.meta_value = %s "
                                                    ."AND mm.meta_key = 'candidate-race'"
                                                    ."AND uu.meta_key = 'uf' AND uu.meta_value = %s"
                                                    ."GROUP BY race", $key, $uf) );
        if (!empty($count[$key])) {

            foreach($count[$key] as $item) {
                if ($item->race == 'true') {                  
                    $results[$key]['afro'] = $item->count;
                } else {
                    $results[$key]['outros'] = $item->count;
                }
            }
        }        
    }
    
    return $results;
}

function get_listagem_votos_auditoria($uf, $setorial) {
    global $wpdb;

    if( empty($uf) || empty($setorial) ) {
        return false;
    }
    
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT "
        ."u.display_name AS 'nome', "
        ."um1.meta_value AS 'cpf', "
        ."u.user_email AS 'email', "
        ."u.user_registered AS 'data_inscricao', "
        ."p.post_title AS 'candidato_votado', "
        ."um2.meta_value AS 'uf', "
        ."um3.meta_value AS 'voto_em', "
        ."um4.meta_value AS 'trocou', "
        ."um5.meta_value AS 'setorial' "
        
        ."FROM "
        ."{$wpdb->users} u "
        ."INNER JOIN {$wpdb->usermeta} um1 ON um1.user_id = u.ID "
        ."INNER JOIN {$wpdb->usermeta} um2 ON um2.user_id = u.ID "
        ."INNER JOIN {$wpdb->usermeta} um3 ON um3.user_id = u.ID "
        ."INNER JOIN {$wpdb->usermeta} um4 ON um4.user_id = u.ID "
        ."INNER JOIN {$wpdb->usermeta} um5 ON um5.user_id = u.ID "
        ."INNER JOIN {$wpdb->posts} p ON p.ID = um3.meta_value "
        
        ."WHERE "
        ."um1.meta_key = 'cpf' AND "
        ."um2.meta_key = 'UF' AND "
        ."um3.meta_key = 'vote-project-id' AND "
        ."um4.meta_key = 'vote-counter' AND "
        ."um5.meta_key = 'setorial' AND "
        ."um2.meta_value = %s AND "
        ."um5.meta_value = %s "   
        
        ."ORDER BY candidato_votado ASC"
        , $uf, $setorial));

    return $results;
}