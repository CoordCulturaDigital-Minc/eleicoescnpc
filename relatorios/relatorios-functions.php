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

function get_count_candidates() {
    global $wpdb;
    
    $count = $wpdb->get_var("SELECT COUNT(u.umeta_id) " 
                                                    ."FROM {$wpdb->posts} as p " 
                                                    ."INNER JOIN {$wpdb->postmeta} as m ON p.ID = m.post_id "
                                                    ."INNER JOIN {$wpdb->usermeta} as u ON p.post_author = u.user_id "
                                                    ."WHERE p.post_type = 'projetos' "
                                                    ."AND m.meta_key = 'subscription-valid' " 
                                                    ."AND u.meta_key = 'setorial' AND u.meta_value != '' ");
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

    $count = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->usermeta} as u "
                                                        ."INNER JOIN {$wpdb->usermeta} as um ON u.user_id = um.user_id "
                                                        ."WHERE u.meta_key = 'setorial' "
                                                        ."AND u.meta_value = %s "
                                                        ."AND um.meta_key = 'uf' "
                                                        ."AND um.meta_value != '' ", $setorial ) );
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