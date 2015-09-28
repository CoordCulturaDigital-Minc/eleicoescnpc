<?php

add_action('admin_init', 'inscricoes_estatisticas_init');
add_action('admin_menu', 'inscricoes_estatisticas_menu');


function inscricoes_estatisticas_init() {
    register_setting('inscricoes_estatisticas_options', 'inscricoes_estatisticas', 'inscricoes_estatisticas_validate_callback_function');
	wp_enqueue_script( 'filtros-relatorios', get_template_directory_uri() . '/js/filtros-relatorios.js');
    wp_enqueue_style('admin', get_template_directory_uri().'/admin.css');
}

function inscricoes_estatisticas_menu() {
    $topLevelMenuLabel = 'Relatórios';
    
    /* Top level menu */
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'edit_published_posts', 'inscricoes_estatisticas', 'relatorios_sumario_page_callback_function');
    
    /* inscritos */
    add_submenu_page('inscricoes_estatisticas', 'Inscrições por Estado', 'Inscrições por Estado', 'edit_published_posts', 'inscritos_estado', 'inscritos_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Inscrições por Estado - listagem', 'Inscrições por Estado - listagem', 'edit_published_posts', 'inscritos_estado_total', 'inscritos_estado_total_page_callback_function');    
    add_submenu_page('inscricoes_estatisticas', 'Inscrições por Setorial - listagem', 'Inscrições por Setorial - listagem', 'edit_published_posts', 'inscritos_setorial_total', 'inscritos_setorial_total_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Inscrições por Setorial/Estado', 'Inscrições por Setorial/Estado', 'edit_published_posts', 'inscritos_setorial_estado', 'inscritos_setorial_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Inscritos que votaram/não votaram', 'Inscritos que votaram/não votaram', 'edit_published_posts', 'votos_inscritos_votaram', 'votos_inscritos_votaram_page_callback_function');
    
    /* candidatos */    
    add_submenu_page('inscricoes_estatisticas', 'Candidatos inscritos por setorial', 'Candidatos inscritos por setorial', 'edit_published_posts', 'candidatos_setorial', 'candidatos_setorial_page_callback_function');        
    add_submenu_page('inscricoes_estatisticas', 'Candidatos inscritos - total por estado', 'Candidatos inscritos - total por estado', 'edit_published_posts', 'candidatos_estado_total', 'candidatos_estado_total_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos inscritos por setorial/estado', 'Candidatos inscritos por setorial/estado', 'edit_published_posts', 'candidatos_setorial_estado', 'candidatos_setorial_estado_page_callback_function');        
    add_submenu_page('inscricoes_estatisticas', 'Candidatos por gênero por setorial/estado', 'Candidatos por gênero por setorial/estado', 'edit_published_posts', 'candidatos_genero', 'candidatos_genero_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos por gênero por estado - listagem', 'Candidatos por gênero por estado - listagem', 'edit_published_posts', 'candidatos_genero_estado_total', 'candidatos_genero_estado_total_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos afrodescendentes por setorial/estado', 'Candidatos afrodescendentes', 'edit_published_posts', 'candidatos_afrodesc', 'candidatos_afrodesc_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos afrodescendentes por setorial/estado', 'Candidatos afrodescendentes por estado', 'edit_published_posts', 'candidatos_afrodesc_estado_total', 'candidatos_afrodesc_estado_total_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos inabilitados', 'Candidatos inabilitados', 'edit_published_posts', 'candidatos_inabilitados', 'candidatos_inabilitados_page_callback_function');
    
    /* votos
    add_submenu_page('inscricoes_estatisticas', 'Total geral de votos', 'Total geral de votos', 'manage_options', 'votos_total', 'votos_total_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Total de votos por estado - listagem', 'Total de votos por estado - listagem', 'manage_options', 'votos_estado_total', 'votos_estado_total_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Total de votos por setorial', 'Votos por setorial', 'manage_options', 'votos_setorial', 'votos_setorial_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Total de votos por gênero por estado - listagem', 'Votos por gênero - listagem', 'manage_options', 'votos_genero_estado_total', 'votos_genero_estado_total_page_callback_function');    
    add_submenu_page('inscricoes_estatisticas', 'Total de votos por afrodescendência', 'Votos por afrodescendência', 'manage_options', 'votos_afrodesc_total', 'votos_afrodesc_total_page_callback_function');           
    add_submenu_page('inscricoes_estatisticas', 'Votos por setorial/estado', 'Votos por setorial/estado', 'manage_options', 'votos_setorial_estado', 'votos_setorial_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Votos por gênero setorial/estado', 'Votos por gênero', 'manage_options', 'votos_genero_setorial_estado', 'votos_genero_setorial_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Votos por afrodescendência setorial/estado', 'Votos por afrodescendência', 'manage_options', 'votos_afrodesc_setorial_estado', 'votos_afrodesc_setorial_estado_page_callback_function');
    */
    add_submenu_page('inscricoes_estatisticas', 'Candidatos mais votados por setorial e estado', 'Mais votados por setorial e estado', 'manage_options', 'maisvotados_setorial_estado', 'maisvotados_setorial_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Resumo das setoriais', 'Resumo das setoriais', 'manage_options', 'maisvotados_setorial_estado', 'maisvotados_setorial_estado_page_callback_function');
    
    /* verificacao de fraude */
    add_submenu_page('inscricoes_estatisticas', 'Auditoria: votos por setorial/estado ', 'Auditoria: votos por setorial estado', 'manage_options', 'resumo_setoriais', 'resumo_setoriais_page_callback_function');
}

    // $norte = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-region' and meta_value = 'nortecentroeste'");
    // $sul = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-region' and meta_value = 'sul'");
    // $sudeste = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-region' and meta_value = 'sudeste'");
    // $nordeste = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-region' and meta_value = 'nordeste'");
    
    // $enviados = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'subscription_number'");
    
    // $excluiEnviadosSQL = "AND post_id NOT IN (SELECT post_id from $wpdb->postmeta where meta_key = 'subscription_number')";
    
    // $orcamento_completo = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'budget-complete' $excluiEnviadosSQL");
    // $orcamento = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'budget-total' $excluiEnviadosSQL");
    // $titulo = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'project-title' $excluiEnviadosSQL");
    // $nome_diretor = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'director-name' $excluiEnviadosSQL");
    // $nome_produtora = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-name' $excluiEnviadosSQL");


function relatorios_sumario_page_callback_function() {
    if(!current_user_can('edit_published_posts')){
        return false;
    }
    
    ?>
    <div class="wrap span-20">
<?php $inscritos = get_count_subscriptions(); ?>
<?php $candidates = get_count_candidates(); ?>
<?php $votes = get_count_votes(); ?>    

    <div class="wrap span-20">
    <h2>Total de inscrições:</h2>
<?php if(current_user_can('manage_options')): ?>
<h4>Eleitores inscritos: <?php echo $inscritos; ?></h4>
<?php endif; ?>                                              
<h4>Candidatos inscritos: <?php echo $candidates; ?></h4>
<h4>Total de votos: <?php echo $votes; ?></h4>
    </div>

    <h2>Lista de relatórios</h2>

	<ul class='wp-submenu wp-submenu-wrap'>
    <li><h3>Inscritos</h3></li>            
    <li><a href='admin.php?page=inscritos_estado'>Inscrições por Estado</a> <small>disponível</small></li>
    <li><a href='admin.php?page=inscritos_estado_total'>Inscrições por Estado - total por estado</a> <small>disponível</small></li>
    <li><a href='admin.php?page=inscritos_setorial_total'>Inscrições por Setorial - total por setorial</a> <small>disponível</small></li>
    <li><a href='admin.php?page=inscritos_setorial_estado'>Inscrições por Setorial/Estado</a> <small>disponível</small></li>
    <li><a href='admin.php?page=votos_inscritos_votaram'>Inscritos que votaram/não votaram</a> <small>disponível</small></li>

    <li><h3>Candidatos</h3></li>        
    <li><a href='admin.php?page=candidatos_estado_total'>Candidatos por estado - total por estado</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_setorial'>Candidatos por setorial</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_setorial_estado'>Candidatos por setorial/estado</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_inabilitados'>Candidatos inabilitados</a> <small>disponível</small></li>
    <li><h5>Por gênero</h5></li>
    <li><a href='admin.php?page=candidatos_genero'>Candidatos por gênero</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_genero_estado_total'>Candidatos por gênero por estado - listagem</a> <small>disponível</small></li>
    <li><h5>Por afrodescendência</h5></li>
    <li><a href='admin.php?page=candidatos_afrodesc'>Candidatos afrodescendentes</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_afrodesc_estado_total'>Candidatos afrodescendentes por estado - listagem</a> <small>disponível</small></li>

<?php if(current_user_can('manage_options')): ?>
    <li><h3>Votos</h3></li>
    <li><a href='admin.php?page=maisvotados_setorial_estado'>Candidatos mais votados por setorial e estado</a></li>
    <li><a href='admin.php?page=resumo_setoriais'>Resumo das setoriais</a></li>
<!--
    <li><a href='admin.php?page=votos_estado_total'>Votos por estado - listagem</a> <small>disponível</small></li>
    <li><a href='admin.php?page=votos_setorial'>Votos por setorial</a> <small>disponível</small></li>
    <li><a href='admin.php?page=votos_setorial_estado'>Votos por setorial/estado</a> <small>disponível</small></li>
    <li><h5>Por gênero</h5></li>
    <li><a href='admin.php?page=votos_genero_estado_total'>Votos por gênero - listagem</a> <small>disponível</small></li>
    <li><a href='admin.php?page=votos_genero_setorial_estado'>Votos por setorial/estado por gênero</a></li>
    <li><h5>Por afrodescendência</h5></li>
    <li><a href='admin.php?page=votos_afrodesc'>Votos por afrodescendência</a> </li>
    <li><a href='admin.php?page=votos_afrodesc_setorial_estado'>Votos por setorial/estado por afrodescendência</a> <small>disponível</small></li>
-->
    <li><h4>Auditoria</h4></li>
    <li><a href='admin.php?page=listagem_votos_auditoria'>Auditoria: votos por setorial e estado</a> <small>disponível</small></li>
<?php endif ?>
    </ul>
    
    <?php
}

/***
 * INSCRITOS 
 ***/


function inscritos_setorial_estado_page_callback_function() {
    if(!current_user_can('edit_published_posts')){
        return false;
    }
    
    $setorial_selected = $_GET['setorial'];
    $setoriais = get_setoriais();
    $states = get_all_states();
    $data[] = ['Estado', 'Inscritos'];
    $total_nacional = 0;
    
    if (!in_array($setorial_selected, array_keys($setoriais))) {
        $setorial_selected = '';
    }
    
?>            
    <h4>Selecione a setorial:</h4>
    <select class="select-setorial" id="inscritos_setorial_estado">
      <option></option>
      <?php foreach ( $setoriais as $slug => $setorial_item ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial_item ?></option>
      <?php endforeach ?>
    </select>
      
<?php if ($setorial_selected != '') : ?>      
    <div class="wrap span-20">
      <h2>Total de inscritos nos estados por setorial: <em><?php echo $setoriais[$setorial_selected] ?></em></h2>
      
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-role num">Inscritos</th>
                </tr>
            </thead>      
            <tbody>
                    <?php $users = get_count_users_by_setorial($setorial_selected); ?>
                    <?php foreach ( $states as $uf => $state ): ?>
                          <?php $page = get_page_by_path( $uf .'-'. $slug, 'OBJECT', 'foruns' ) ?>
                          <?php $data[] = [$state, $users[$uf]]; ?>
                            <tr class="alternate">
                                <td><?php echo $state; ?></td>
                                <td class="num"><?php echo $users[$uf]; ?></td>
                            </tr>
                            <?php $total_nacional += $users[$uf]; ?>
                    <?php endforeach ?>
                            <tr class="alternate">
                                <td><strong>Brasil</strong></td>
                                <td class="num"><?php echo $total_nacional; ?></td>
                            </tr>                          
             </tbody> 
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_inscritos_setorial_estado' data_csv='<?php echo json_encode($data) ?>'>    
    </div>
<?php endif; ?>
    <?php
}

function inscritos_estado_page_callback_function() {
    if(!current_user_can('edit_published_posts')){
        return false;
    }
    
    $uf_selected = $_GET['uf'];
    $states = get_all_states();
    $setoriais = get_setoriais();
    $data[] = ['Estado', 'Setorial', 'Inscritos'];
    
    if (!in_array($uf_selected, array_keys($states))) {
        $uf_selected = '';
    }
?>            
    <h4>Selecione a UF:</h4>
    <select class="select-state" id="inscritos_estado">
      <option></option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
    </select>

<?php if ($uf_selected != '') : ?>
    <?php $total_inscritos_estado = get_count_users_states_by_uf($uf_selected); ?>
    <div class="wrap span-20">
      <h2>Total de inscritos por estado: <em><?php echo $states[$uf_selected] ?></em></h2>
         <h4>Total de inscritos em <?php echo $uf_selected; ?>: <?php echo $total_inscritos_estado; ?></h4>
                            
    
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-role num">Inscritos</th>
                </tr>
            </thead>      
            <tbody>
                    <?php $users = get_count_users_setoriais_by_uf($uf_selected); ?>

                    <?php foreach ( $setoriais as $slug => $setorial ): ?>
                        
                            <?php $page = get_page_by_path( $uf .'-'. $slug, 'OBJECT', 'foruns' ) ?>
                            <?php $data[] = [$uf_selected, $setorial, $users[$slug]]; ?>
                            <tr class="alternate">
                                <td class="num"><?php echo $uf_selected; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php echo $users[$slug]; ?></td>
                            </tr> 
                        <?php $count_states += $users[$slug]; ?>
                    <?php endforeach ?>
                            <tr class="alternate">
                                <td class="num"><strong>Total <?php echo $uf_selected; ?></strong></td>
                                <td>&nbsp;</td>
                                <td class="num"><strong><?php echo $count_states; ?></strong></td>
                            </tr>
            </tbody> 
       </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_inscritos_estado' data_csv='<?php echo json_encode($data) ?>'>
        </div>
<?php endif; ?>
    <?php
}

function inscritos_estado_total_page_callback_function() {
    if(!current_user_can('edit_published_posts')){
        return false;
    }

    $data[] = ['UF', 'Inscritos'];
    $total_nacional = 0;
?>
    <div class="wrap span-20">
    
    <h2>Total de inscritos nos estados</h2>
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-posts">Estado</th>
                    <th scope="col"  class="manage-column column-role num">Inscritos</th>
                </tr>
            </thead>
    
            <?php $states = get_all_states(); ?>
            <tbody>
            <?php foreach ( $states as $uf => $state ): ?>
                            <?php $user_count = get_count_users_states_by_uf($uf); ?>
                            <?php $data[] = [$state, $user_count]; ?>
                            <?php $total_nacional += $user_count; ?>
                            <tr class="alternate">
                                <td><?php echo $state; ?></td>                            
                                <td class="num"><?php echo $user_count; ?></td>
                            </tr>
            <?php endforeach ?>
                            <?php $data[] = ['Brasil', $total_nacional]; ?>
                            <tr class="alternate">
                                <td><strong>Brasil</strong></td>                            
                                <td class="num"><?php echo $total_nacional; ?></td>
                            </tr>                            
            </tbody>
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_inscritos_estado_listagem' data_csv='<?php echo json_encode($data) ?>'>                
    </div>
<?php     
}

function inscritos_setorial_total_page_callback_function() {
    if(!current_user_can('edit_published_posts')){
        return false;
    }

    $data[] = ['Setorial', 'Inscritos'];
?>
    <div class="wrap span-20">
    
    <h2>Total de inscritos nas setoriais (acumulado nacional)</h2>
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-role num">Inscritos</th>
                </tr>
            </thead>
    
            <?php $setoriais = get_setoriais(); ?>

            <tbody>
                    <?php $users = get_count_users_setoriais(); ?>
                    <?php foreach ( $users as $slug => $user_count ): ?>
                            <?php $data[] = [$setorial, $users]; ?>                                    
                            <tr class="alternate">
                                <td><?php echo $setoriais[$slug]; ?></a></td>
                                <td class="num"><?php echo $user_count; ?></td>
                            </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_inscritos_setoriais' data_csv='<?php echo json_encode($data) ?>'>                
    </div>
<?php 
}

function votos_inscritos_votaram_page_callback_function() {
    if(!current_user_can('manage_options')){
        return false;
    }

    $uf_selected = $_GET['uf'];    
    $setorial_selected = $_GET['setorial'];
    $states = get_all_states();
    $setoriais = get_setoriais();
    $data[] = ['Votaram', 'Não votaram', 'Total'];
    
    if (!in_array($setorial_selected, array_keys($setoriais))) {
        $setorial_selected = '';
    }
    if (!in_array($uf_selected, array_keys($states))) {
        $uf_selected = '';
    }    
    
    ?>
    <div class="wrap span-20">
    
    <h4>Selecione a UF:</h4>
    <select class="select-state-v" id="filtrar_uf">
      <option value="">Todas</option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
    </select>
      
    <h4>Selecione a Setorial:</h4>
    <select class="select-setorial-v" id="filtrar_setorial">
      <option value="">Todas</option>
      <?php foreach ( $setoriais as $slug => $setorial_item ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial_item ?></option>
      <?php endforeach ?>
    </select>
      <br/>
      <input type="button" value="buscar" id="votos_inscritos_votaram" class="filtrar_relatorio">
      <br/><br/>    
    <?php

      if ($uf_selected || $setorial_selected) {
          $inscritos_total = get_count_users_setorial_uf($uf_selected, $setorial_selected);
          $inscritos_votaram = get_votos_inscritos_votaram_uf_setorial($uf_selected, $setorial_selected);
      } else {
          $inscritos_total = get_count_users_setorial_uf();
          $inscritos_votaram = get_votos_inscritos_votaram_uf_setorial();
      }
      
      $inscritos_nao_votaram = $inscritos_total - $inscritos_votaram;
      if ($inscritos_votaram == 0 || $inscritos_total == 0) {
          $inscritos_votaram_perc = 0;
          $inscritos_nao_votaram_perc = 0;
      } else {
          $inscritos_votaram_perc = round($inscritos_votaram / $inscritos_total * 100, 2);
          $inscritos_nao_votaram_perc = round($inscritos_nao_votaram / $inscritos_total * 100, 2);
      }
      $data[] = [$inscritos_votaram, $inscritos_nao_votaram, $inscritos_total];
    ?>
    <h2>Inscritos que votaram e não votaram:</h2>
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-posts">Votaram</th>
                    <th scope="col"  class="manage-column column-role num">Não votaram</th>
                    <th scope="col"  class="manage-column column-role num">Total</th>
                </tr>
            </thead>    
            <tbody>
                           <tr class="alternate">
    <td class="num"><?php echo $inscritos_votaram;?> (<?php echo $inscritos_votaram_perc; ?>%)</td>
    <td class="num"><?php echo $inscritos_nao_votaram;?> (<?php echo $inscritos_nao_votaram_perc; ?>%)</td>
    <td class="num"><strong><?php echo $inscritos_total;?></strong></td>    
                            </tr>
            </tbody>
      </table>
      <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_votos_inscritos_votaram' data_csv='<?php echo json_encode($data) ?>'>                </div>
<?php
    
}

/**
 * CANDIDATOS
 **/

function candidatos_setorial_page_callback_function() {   
    if(!current_user_can('edit_published_posts')){
        return false;
    }
       
    $setorial_selected = $_GET['setorial'];
    $states = get_all_states();
    $setoriais = get_setoriais();
    $data[] = ['Estado', 'Candidatos'];

    if (!in_array($setorial_selected, array_keys($setoriais))) {
        $setorial_selected = '';
    }
?>            
    <h4>Selecione a Setorial:</h4>
    <select class="select-setorial" id="candidatos_setorial">
      <option></option>
      <?php foreach ( $setoriais as $slug => $setorial ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial ?></option>
      <?php endforeach ?>
    </select>

<?php if ($setorial_selected != '') : ?>
    <div class="wrap span-20">

        <h2>Candidatos por setorial</h2>

        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-posts">Estado</th>
                    <th scope="col"  class="manage-column column-posts num">Candidatos</th>
                </tr>
            </thead>

            <tbody>
                    <?php $candidates = get_count_candidates_by_setorial($setorial_selected); ?>
                    <?php foreach ( $states as $uf => $state ): ?>
                            <?php $data[] = [$uf, $candidates[$uf]]; ?>                                    
                            <tr class="alternate">
                                <td class="num"><?php echo $uf;?></td>                    
                                <td class="num"><?php echo $candidates[$uf];?></td>
                            </tr>
                    <?php endforeach ?>
            </tbody>
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_setorial' data_csv='<?php echo json_encode($data) ?>'>    
    </div>
<?php endif ?>
<?php
}

function candidatos_estado_total_page_callback_function() {   
    if(!current_user_can('edit_published_posts')){
        return false;
    }
    $data[] = ['Estado', 'Candidatos'];
?>
    <div class="wrap span-20">
      <h2>Total de candidatos - total por estados</em></h2>      
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-role num">Candidatos</th>
                </tr>
            </thead>      
            <tbody>
            <tbody>
            <?php $candidates = get_count_candidates_states(); ?>
                    <?php foreach ( $candidates as $uf => $candidate_count ): ?>
                            <?php $count_brasil += $candidate_count; ?>
                            <?php $data[] = [$uf, $candidate_count]; ?>                                        
                            <tr class="alternate">
                                <td class="num"><?php echo $uf; ?></td>
                                <td class="num"><?php echo $candidate_count; ?></td>
                            </tr>
                    <?php endforeach ?>
                            <tr class="alternate">
                                <td class="num"><strong>Brasil</strong></td>
                                <td class="num"><Strong><?php echo $count_brasil; ?></strong></td>
                            </tr>                            
            </tbody> 
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_estado_total' data_csv='<?php echo json_encode($data) ?>'>        
    </div>

<?php } 


function candidatos_setorial_estado_page_callback_function() {   
    if(!current_user_can('edit_published_posts')){
        return false;
    }
    
    
    $uf_selected = $_GET['uf'];
    $states = get_all_states();
    $setoriais = get_setoriais();
    $data[] = ['Setorial', 'Candidatos'];
    
    if (!in_array($uf_selected, array_keys($states))) {
        $uf_selected = '';
    }
?>            
    <h4>Selecione a UF:</h4>
    <select class="select-state" id="candidatos_setorial_estado">
      <option></option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
    </select>

<?php if ($uf_selected != '') : ?>
    <div class="wrap span-20">

        <h2>Candidatos inscritos</h2>
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-posts num">Candidatos</th>
                </tr>
            </thead>

            <tbody>
                    <?php $candidates = get_count_candidates_setoriais_by_uf($uf_selected); ?>
                    <?php foreach ( $setoriais as $slug => $setorial ): ?>
                            <?php $data[] = [$setorial, $candidates[$slug]]; ?>  
                            <?php $page = get_page_by_path( $uf .'-'. $slug, 'OBJECT', 'foruns' ) ?>

                            <tr class="alternate">
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                            <td class="num"><?php echo $candidates[$slug];?></td>
                            </tr>
                    <?php endforeach ?>
            </tbody>
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_setorial' data_csv='<?php echo json_encode($data) ?>'>
        </div>
<?php endif ?>

<?php }

 function candidatos_genero_estado_total_page_callback_function() {
    if(!current_user_can('edit_published_posts')){
        return false;
    }
?>
    <div class="wrap span-20">
       <h2>Candidatos por gênero por estado - listagem</h2>
            <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts num">Mulheres</th>
                    <th scope="col"  class="manage-column column-posts num">Homens</th>
                    <th scope="col"  class="manage-column column-posts num">Total</th>    
                </tr>
            </thead>
     <?php
     $states = get_all_states();
     $homens_nacional = 0;
     $mulheres_nacional = 0;
     ?>
     <?php foreach ( $states as $uf => $state): ?>
<?php $candidates = get_count_candidates_setoriais_genre_uf($uf); ?>
<?php
$candidates_masc = intval(($candidates['masculino'] != '') ? $candidates['masculino'] : 0);
$candidates_fem = intval(($candidates['feminino'] != '') ? $candidates['feminino'] : 0);
$candidates_tot = $candidates_masc + $candidates_fem;

if ($candidates_tot == 0) {
    $candidates_masc_perc = 0;
    $candidates_fem_perc = 0;
} else {
    $candidates_masc_perc = round($candidates_masc / $candidates_tot * 100, 2);
    $candidates_fem_perc = round($candidates_fem / $candidates_tot * 100, 2);
}
$data[] = [$uf, $setorial, $candidates_fem, $candidates_masc, $candidates_tot];
$homens_nacional += $candidates_masc;
$mulheres_nacional += $candidates_fem;
?>           
                <tr class="alternate">
                    <td><?php echo $state; ?></td>
                    <td class="num"><?php echo $candidates_fem_perc ?>% (<?php echo $candidates_fem; ?>)</td>
                    <td class="num"><?php echo $candidates_masc_perc ?>% (<?php echo $candidates_masc; ?>)</td>
                    <td class="num"><?php echo $candidates_tot; ?></td>                    
                </tr>
     <?php endforeach; ?>
<?php
$total_nacional = $homens_nacional + $mulheres_nacional;
$mulheres_nacional_perc = round($mulheres_nacional / $total_nacional * 100, 2);
$homens_nacional_perc = round($homens_nacional / $total_nacional * 100, 2);
?>
                <tr class="alternate">
                    <td><strong>Brasil</strong></td>
                    <td class="num"><?php echo $mulheres_nacional_perc ?>% (<?php echo $mulheres_nacional; ?>)</td>
                    <td class="num"><?php echo $homens_nacional_perc ?>% (<?php echo $homens_nacional; ?>)</td>
                   <td class="num"><?php echo $total_nacional; ?></td>                    
                </tr>

            </tbody>
        </table>
     <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_genero_total' data_csv='<?php echo json_encode($data) ?>'>
<?php
 }

 function candidatos_genero_page_callback_function() {
    if(!current_user_can('edit_published_posts')){
        return false;
    }
?>

    <div class="wrap span-20">
        <h2>Candidatos por gênero por setorial/estado</h2>
    <h3>Selecione o estado ou a setorial</h3>
                    
<?php
// tenta pegar UF para fazer filtros
$uf_selected = $_GET['uf'];
$states = get_all_states();
$setoriais = get_setoriais();
$data[] = ['Estado', 'Setorial', 'Homens', 'Mulheres', 'Total'];

if (!in_array($uf_selected, array_keys($states))) {
    if ($uf_selected != 'all') {
        $uf_selected = '';
    }
}
?>                    
    <h4>Selecione a UF:</h4>
    <select class="select-state" id="candidatos_genero">
      <option></option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
      <option value="all">TODOS (lento)</option>
    </select>
      <br/><br/>
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-posts num">Mulheres</th>
                    <th scope="col"  class="manage-column column-posts num">Homens</th>
                    <th scope="col"  class="manage-column column-posts num">Total</th>    
                </tr>
            </thead>
<?php
if ($uf_selected == 'all') {
?>
<!--  TODO: listagem completa dará saída somente dos dados raw / csv -->
            <?php foreach ( $states as $uf => $state ): ?>
                    <?php $candidates = get_count_candidates_setoriais_genre_by_uf($uf); ?>
                    <?php foreach ( $setoriais as $slug => $setorial ): ?>
                    <?php if( !empty($candidates[$slug]) ) : ?>
<?php
$candidates_masc = intval(($candidates[$slug]['masculino'] != '') ? $candidates[$slug]['masculino'] : 0);
$candidates_fem = intval(($candidates[$slug]['feminino'] != '') ? $candidates[$slug]['feminino'] : 0);
$candidates_tot = $candidates_masc + $candidates_fem;
$candidates_masc_perc = round($candidates_masc / $candidates_tot * 100, 2);
$candidates_fem_perc = round($candidates_fem / $candidates_tot * 100, 2);
$data[] = [$uf, $setorial, $candidates_fem, $candidates_masc, $candidates_tot];
?>  
                        <?php endif; ?>
                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody>
         </table>
         <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_genero' data_csv='<?php echo json_encode($data) ?>'>
<?php   
    
  } else if ($uf_selected != '') {
?>         <tbody>
                    <?php $candidates = get_count_candidates_setoriais_genre_by_uf($uf_selected); ?>
                    <?php foreach ( $setoriais as $slug => $setorial ): ?>
                    <?php if( !empty($candidates[$slug]) ) : ?>
<?php
            $candidates_masc = intval(($candidates[$slug]['masculino'] != '') ? $candidates[$slug]['masculino'] : 0);
            $candidates_fem = intval(($candidates[$slug]['feminino'] != '') ? $candidates[$slug]['feminino'] : 0);
            $candidates_tot = $candidates_masc + $candidates_fem;
            $candidates_masc_perc = round($candidates_masc / $candidates_tot * 100, 2);
            $candidates_fem_perc = round($candidates_fem / $candidates_tot * 100, 2);
?>
                            <?php $data[] = [$uf_selected, $candidates_fem, $candidates_masc, $candidates_fem, $candidates_tot]; ?>              
                            <tr class="alternate">
                                <td><?php echo $uf_selected; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php echo $candidates_fem_perc ?>% (<?php echo $candidates_fem; ?>)</td>
                                <td class="num"><?php echo $candidates_masc_perc ?>% (<?php echo $candidates_masc; ?>)</td>
                                <td class="num"><?php echo $candidates_tot; ?></td>                    
                            </tr>
                        <?php endif; ?>
                    <?php endforeach ?>
            </tbody>
        </table>
<?php if (sizeof($data) > 1): ?>
         <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_genero' data_csv='<?php echo json_encode($data) ?>'>
<?php else: ?>
         <strong>Sem resultados</strong>
<?php endif ?>                    
    </div>
<?php      
  }
}


function candidatos_afrodesc_estado_total_page_callback_function() {
    if(!current_user_can('edit_published_posts')){
        return false;
    }
       
    $uf_selected = $_GET['uf'];    
    $setorial_selected = $_GET['setorial'];
    $states = get_all_states();
    $setoriais = get_setoriais();
    $data[] = ['Estado', 'Setorial', 'Afrodescendentes', 'Outros', 'Total'];
    
    if (!in_array($setorial_selected, array_keys($setoriais))) {
        $setorial_selected = '';
    }
    if (!in_array($uf_selected, array_keys($states))) {
        $uf_selected = '';
    }
    
    ?>
    <h4>Selecione a UF:</h4>
    <select class="select-state-v" id="filtrar_uf">
      <option value="">Todas</option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
    </select>
      
    <h4>Selecione a Setorial:</h4>
    <select class="select-setorial-v" id="filtrar_setorial">
      <option value="">Todas</option>
      <?php foreach ( $setoriais as $slug => $setorial_item ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial_item ?></option>
      <?php endforeach ?>
    </select>
      <br/>
      <input type="button" value="buscar" id="candidatos_afrodesc_estado_total" class="filtrar_relatorio">
      <br/><br/>

    <div class="wrap span-20">

        <h2>Candidatos afrodescendentes por setorial/estado</h2>
        <?php if ($uf_selected) { echo " <h4>" . $states[$uf_selected] . "</h4> "; } ?>
        <?php if ($setorial_selected) { echo " <h4>" . $setoriais[$setorial_selected] . "</h4>"; } ?>

    <div class="wrap span-20">
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-posts num">Afrodescendentes</th>
                    <th scope="col"  class="manage-column column-posts num">Outros</th>
                    <th scope="col"  class="manage-column column-posts num">Total</th>          
                      </tr>
            </thead>
      
<?php $candidates = get_count_candidates_afrodesc_setoriais_uf($uf_selected, $setorial_selected); ?>
<?php
            $candidates_afro = intval(($candidates['afro'] != '') ? $candidates['afro'] : 0);
            $candidates_outros = intval(($candidates['outros'] != '') ? $candidates['outros'] : 0);
            $candidates_total = $candidates_afro + $candidates_outros;
            
            if ($candidates_total > 0) {
                $candidates_afro_perc = round($candidates_afro / $candidates_total * 100, 2);
                $candidates_outros_perc = round($candidates_outros / $candidates_total * 100, 2);
            } else {
                $candidates_afro_perc = 0;
                $candidates_outros_perc = 0;
            }
            $data[] = [$states[$uf], $setoriais[$setorial_selected], $candidates_afro, $candidates_outros, $candidates_total];
    ?>
                <tr class="alternate">
                    <td><?php echo $states[$uf_selected];?></td>
                    <td><?php echo $setoriais[$setorial_selected];?></td>                      
                    <td class="num"><?php echo $candidates_afro;?> (<?php echo $candidates_afro_perc; ?>%)</td>
                    <td class="num"><?php echo $candidates_outros;?> (<?php echo $candidates_outros_perc; ?>%)</td>
                    <td class="num"><strong><?php echo $candidates_total;?></strong></td>    
                </tr>
            </tbody>
      </table>
      <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_afrodesc_estado_total' data_csv='<?php echo json_encode($data) ?>'>              
<?php    
}


function candidatos_afrodesc_page_callback_function() {
    if(!current_user_can('edit_published_posts')){
        return false;
    }
    $data[] = ['Estado', 'Setorial', 'Afrodescendentes', 'Outros', 'Total'];
?>

    <div class="wrap span-20">

        <h2>Candidatos afrodescendentes por setorial/estado</h2>

    <div class="wrap span-20">

        <table class="wp-list-table widefat">

            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-posts num">Afrodescendentes</th>
                    <th scope="col"  class="manage-column column-posts num">Outros</th>
                    <th scope="col"  class="manage-column column-posts num">Total


    </th>    
                </tr>
            </thead>

            <?php $states = get_all_states(); ?>
            <?php $setoriais = get_setoriais(); ?>

            <tbody>
                <?php foreach ( $states as $uf => $state ): ?>
                    <?php $candidates = get_count_candidates_setoriais_afrodesc_by_uf($uf); ?>

                    <?php foreach ( $setoriais as $slug => $setorial ): ?>
            
                    <?php if( !empty($candidates[$slug]) ) : ?>
<?php
            $candidates_afro = intval(($candidates[$slug]['afro'] != '') ? $candidates[$slug]['afro'] : 0);
            $candidates_outros = intval(($candidates[$slug]['outros'] != '') ? $candidates[$slug]['outros'] : 0);
            $candidates_tot = $candidates_afro + $candidates_outros;
            $candidates_afro_perc = round($candidates_afro / $candidates_tot * 100, 2);
            $candidates_outros_perc = round($candidates_outros / $candidates_tot * 100, 2);
?>
                            <?php $data[] = [$uf, $setorial, $candidates_afro, $candidates_outros, $candidates_tot]; ?>              
                            <tr class="alternate">
                                <td><?php echo $uf; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php echo $candidates_afro_perc ?>% (<?php echo $candidates_afro; ?>)</td>
                                <td class="num"><?php echo $candidates_outros_perc ?>% (<?php echo $candidates_outros; ?>)</td>
                                <td class="num"><?php echo $candidates_tot; ?></td>    
                            </tr>
                        <?php endif; ?>

                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody>
                
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_afrodesc' data_csv='<?php echo json_encode($data) ?>'>
    </div>
    
<?php } 


/***
 * VOTOS
 **/

function votos_estado_total_page_callback_function() {
    if(!current_user_can('manage_options')){
        return false;
    }
    
    $data[] = ['Estado', 'Total de votos'];
    $count_brasil = 0;
?>
    <div class="wrap span-20">
      <h2>Total de votos por estados - listagem acumulada de todas as setoriais</em></h2>      
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-role num">Total de votos</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
            <?php $states = get_all_states(); ?>
            <?php foreach ( $states as $uf => $state ): ?>
                <?php $vote_count = get_total_votes_by_uf($uf); ?>
                <?php $count_brasil += $vote_count; ?>
                <?php $data[] = [$uf, $vote_count]; ?>                                        
                            <tr class="alternate">
                                <td class="num"><?php echo $uf; ?></td>
                                <td class="num"><?php echo $vote_count; ?></td>
                            </tr>
            <?php endforeach ?>
                            <tr class="alternate">
                                <td class="num"><strong>Brasil</strong></td>
                                <td class="num"><Strong><?php echo $count_brasil; ?></strong></td>
                            </tr>
            </tbody> 
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_votos_estado_total' data_csv='<?php echo json_encode($data) ?>'>        
    </div>

<?php    
    
}

function votos_setorial_estado_page_callback_function() {
    if(!current_user_can('manage_options')){
        return false;
    }

    $uf_selected = $_GET['uf'];
    $setorial_selected = $_GET['setorial'];

    $states = get_all_states();
    $setoriais = get_setoriais();
    $data[] = ['UF', 'Setorial', 'Total de votos'];
    
    if (!in_array($uf_selected, array_keys($states))) {
        $uf_selected = '';
    }
    if (!in_array($setorial_selected, array_keys($setoriais))) {
        $setorial_selected = '';
    }
    
    ?>
    <h4>Selecione a UF:</h4>
    <select class="select-state-v" id="filtrar_uf">
      <option>Todas</option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
    </select>
      
    <h4>Selecione a Setorial:</h4>
    <select class="select-setorial-v" id="filtrar_setorial">
      <option value="">Todas</option>
      <?php foreach ( $setoriais as $slug => $setorial_item ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial_item ?></option>
      <?php endforeach ?>
    </select>
      <br/>
      <input type="button" value="buscar" id="votos_setorial_estado" class="filtrar_relatorio">
      <br/><br/>
      
<?php $votes = get_votos_estado_setorial($uf_selected, $setorial_selected); ?>
<?php
      $setorial_selected = ($setorial_selected == '') ? 'Todas as setoriais' : $setorial_selected;
      $uf_selected = ($uf_selected == '') ? 'Total nacional' : $uf_selected;
      
      ?>      
<?php if ($votes > 0) : ?>    
      <div class="wrap span-20">

      <h2>Votos por setorial/estado</h2>

      <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-posts num">Votos</th>
                </tr>
            </thead>
<?php $data[] = [$uf_selected, $setorial_selected, $votes]; ?>
                <tr class="alternate">
                    <td><?php echo $uf_selected; ?></td>
                    <td><?php echo $setorial_selected; ?></a></td>
                    <td class="num"><?php echo $votes;?></td>
                </tr>
            </tbody>
        </table>
    <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='<?php echo "relatoroi_votos_estado_setorial"; ?>' data_csv='<?php echo json_encode($data) ?>'>
    </div>
<?php else: ?>
    Sem resultados
<?php endif; ?>
<?php     
}

function votos_setorial_page_callback_function() {   
    if(!current_user_can('manage_options')){
        return false;
    }
    $data[] = ['Estado', 'Setorial', 'Votos'];    
?>

    <div class="wrap span-20">

        <h2>Votos por setorial/estado</h2>

        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-posts num">Votos</th>
                </tr>
            </thead>

            <?php $states = get_all_states(); ?>
            <?php $setoriais = get_setoriais(); ?>

            <tbody>
                <?php foreach ( $states as $uf => $state ): ?>
                    <?php $votes = get_number_of_votes_setorial_by_uf($uf); ?>
                    <?php foreach ( $setoriais as $slug => $setorial ): ?>
                        <?php if( $votes[$slug] != 0 ) : ?>
                            <?php $page = get_page_by_path( $uf .'-'. $slug, 'OBJECT', 'foruns' ) ?>
                            <?php $data[] = [$uf, $setorial, $votes[$slug]]; ?>              
                            <tr class="alternate">
                                <td><?php echo $uf; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php echo $votes[$slug];?></td>
                            </tr>
                        <?php endif; ?>

                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody>
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_votos_setoriais' data_csv='<?php echo json_encode($data) ?>'>
    </div>

    
<?php }


function votos_genero_estado_total_page_callback_function() {   
    if(!current_user_can('manage_options')){
        return false;
    }

?>
    <div class="wrap span-20">
       <h2>Votos por gênero por estado - listagem</h2>
            <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts num">Mulheres</th>
                    <th scope="col"  class="manage-column column-posts num">Homens</th>
                    <th scope="col"  class="manage-column column-posts num">Total</th>    
                </tr>
            </thead>
     <?php
     $states = get_all_states();
     $homens_nacional = 0;
     $mulheres_nacional = 0;
     ?>
     <?php foreach ( $states as $uf => $state): ?>
<?php $votes = get_count_votes_genre_uf($uf); ?>
<?php
$votes_masc = intval(($votes['masculino'] != '') ? $votes['masculino'] : 0);
$votes_fem = intval(($votes['feminino'] != '') ? $votes['feminino'] : 0);
$votes_tot = $votes_masc + $votes_fem;

if ($votes_tot == 0) {
    $votes_masc_perc = 0;
    $votes_fem_perc = 0;
} else {
    $votes_masc_perc = round($votes_masc / $votes_tot * 100, 2);
    $votes_fem_perc = round($votes_fem / $votes_tot * 100, 2);
}
$data[] = [$uf, $setorial, $votes_fem, $votes_masc, $votes_tot];
$homens_nacional += $votes_masc;
$mulheres_nacional += $votes_fem;
?>           
                <tr class="alternate">
                    <td><?php echo $state; ?></td>
                    <td class="num"><?php echo $votes_fem_perc ?>% (<?php echo $votes_fem; ?>)</td>
                    <td class="num"><?php echo $votes_masc_perc ?>% (<?php echo $votes_masc; ?>)</td>
                    <td class="num"><?php echo $votes_tot; ?></td>                    
                </tr>
     <?php endforeach; ?>
<?php
$total_nacional = $homens_nacional + $mulheres_nacional;
$mulheres_nacional_perc = round($mulheres_nacional / $total_nacional * 100, 2);
$homens_nacional_perc = round($homens_nacional / $total_nacional * 100, 2);
?>
                <tr class="alternate">
                    <td><strong>Brasil</strong></td>
                    <td class="num"><?php echo $mulheres_nacional_perc ?>% (<?php echo $mulheres_nacional; ?>)</td>
                    <td class="num"><?php echo $homens_nacional_perc ?>% (<?php echo $homens_nacional; ?>)</td>
                   <td class="num"><?php echo $total_nacional; ?></td>                    
                </tr>

            </tbody>
        </table>
     <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_genero_total' data_csv='<?php echo json_encode($data) ?>'>
<?php    
}

function votos_genero_page_callback_function() {   
    if(!current_user_can('manage_options')){
        return false;
    }
    $data[] = ['Estado', 'Setorial', 'Mulheres', 'Homens', 'Total'];    
?>

    <div class="wrap span-20">

        <h2>Votos por gênero setorial/estado</h2>

        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-posts num">Mulheres</th>
                    <th scope="col"  class="manage-column column-posts num">Homens</th>
                    <th scope="col"  class="manage-column column-posts num">Total</th>        
                </tr>
            </thead>

            <?php $states = get_all_states(); ?>
            <?php $setoriais = get_setoriais(); ?>

            <tbody>
                <?php foreach ( $states as $uf => $state ): ?>
                    <?php $votes = get_number_of_votes_setorial_genre_by_uf($uf); ?>
                    <?php foreach ( $setoriais as $slug => $setorial ): ?>
                        <?php if( $votes[$slug] != 0 ) : ?>
                            <?php $page = get_page_by_path( $uf .'-'. $slug, 'OBJECT', 'foruns' ) ?>
<?php
            $votos_masc = intval(($votes[$slug]['masculino'] != '') ? $votes[$slug]['masculino'] : 0);
            $votos_fem = intval(($votes[$slug]['feminino'] != '') ? $votes[$slug]['feminino'] : 0);
            $votos_tot = $votos_fem + $votos_masc;
            $votos_masc_perc = round($votos_masc / $votos_tot * 100, 2);
            $votos_fem_perc = round($votos_fem / $votos_tot * 100, 2);
?>
                            <?php $data[] = [$uf, $setorial, $votos_fem, $votos_masc, $votos_tot]; ?>                      
                            <tr class="alternate">
                                <td><?php echo $uf; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php echo $votos_fem_perc ?>% (<?php echo $votos_fem; ?>)</td>
                                <td class="num"><?php echo $votos_masc_perc ?>% (<?php echo $votos_masc; ?>)</td>
                                <td class="num"><?php echo $votos_tot; ?></td>
                            </tr>
                        <?php endif; ?>

                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody>
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_votos_genero' data_csv='<?php echo json_encode($data) ?>'>
    </div>
    
<?php
} 

function votos_afrodesc_total_page_callback_function() {
    if(!current_user_can('manage_options')){
        return false;
    }

?>
    <div class="wrap span-20">
       <h2>Votos em candidatos afrodescendentes por estado - listagem</h2>
            <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts num">Afrodescendentes</th>
                    <th scope="col"  class="manage-column column-posts num">Outros</th>
                    <th scope="col"  class="manage-column column-posts num">Total</th>    
                </tr>
            </thead>
     <?php
     $data[] = ['Estado', 'Afrodescendentes', 'Outros']; 
     $states = get_all_states();
     $afro_nacional = 0;
     $outros_nacional = 0;
     ?>
     <?php foreach ( $states as $uf => $state): ?>
<?php $votes = get_count_votes_afrodesc_uf($uf); ?>
<?php
$votes_afro = intval(($votes['afro'] != '') ? $votes['afro'] : 0);
$votes_outros = intval(($votes['outros'] != '') ? $votes['outros'] : 0);
$votes_tot = $votes_afro + $votes_outros;

if ($votes_tot == 0) {
    $votes_afro_perc = 0;
    $votes_outros_perc = 0;
} else {
    $votes_afro_perc = round($votes_afro / $votes_tot * 100, 2);
    $votes_outros_perc = round($votes_outros / $votes_tot * 100, 2);
}
$data[] = [$uf, $votes_afro, $votes_outros, $votes_tot];
$afro_nacional += $votes_afro;
$outros_nacional += $votes_outros;
?>           
                <tr class="alternate">
                    <td><?php echo $state; ?></td>
                    <td class="num"><?php echo $votes_afro_perc ?>% (<?php echo $votes_afro; ?>)</td>
                    <td class="num"><?php echo $votes_outros_perc ?>% (<?php echo $votes_outros; ?>)</td>
                    <td class="num"><?php echo $votes_tot; ?></td>                    
                </tr>
     <?php endforeach; ?>
<?php
$total_nacional = $afro_nacional + $outros_nacional;
$outrosnacional_perc = round($outrosnacional / $total_nacional * 100, 2);
$homens_nacional_perc = round($homens_nacional / $total_nacional * 100, 2);
?>
                <tr class="alternate">
                    <td><strong>Brasil</strong></td>
                    <td class="num"><?php echo $afro_nacional_perc ?>% (<?php echo $afro_nacional; ?>)</td>
                    <td class="num"><?php echo $outros_nacional_perc ?>% (<?php echo $outros_nacional; ?>)</td>
                   <td class="num"><?php echo $total_nacional; ?></td>                    
                </tr>

            </tbody>
        </table>
     <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_genero_total' data_csv='<?php echo json_encode($data) ?>'>
<?php        
}

// ultimo
function votos_afrodesc_setorial_estado_page_callback_function() {   
    if(!current_user_can('manage_options')){
        return false;
    }
    
    $uf_selected = $_GET['uf'];    
    $setorial_selected = $_GET['setorial'];
    $states = get_all_states();
    $setoriais = get_setoriais();
    $data[] = ['Estado', 'Setorial', 'Afrodescendentes', 'Outros', 'Total'];
    
    if (!in_array($setorial_selected, array_keys($setoriais))) {
        $setorial_selected = '';
    }
    if (!in_array($uf_selected, array_keys($states))) {
        $uf_selected = '';
    }
    
    ?>
    <h4>Selecione a UF:</h4>
    <select class="select-state-v" id="filtrar_uf">
      <option value="">Todas</option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
    </select>
      
    <h4>Selecione a Setorial:</h4>
    <select class="select-setorial-v" id="filtrar_setorial">
      <option value="">Todas</option>
      <?php foreach ( $setoriais as $slug => $setorial_item ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial_item ?></option>
      <?php endforeach ?>
    </select>
      <br/>
      <input type="button" value="buscar" id="votos_afrodesc_setorial_estado" class="filtrar_relatorio">
      <br/><br/>
    <div class="wrap span-20">

        <h2>Votos por afrodescendência setorial/estado</h2>

        <table class="wp-list-table widefat">
            <thead>
                <tr>
<?php if ($uf_selected): ?>
                    <th scope="col"  class="manage-column column-role">Estado</th>
<?php endif; ?>
<?php if ($setorial_selected): ?>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
<?php endif; ?>
                    <th scope="col"  class="manage-column column-posts num">Afrodescendentes</th>
                    <th scope="col"  class="manage-column column-posts num">Outros</th>
                    <th scope="col"  class="manage-column column-posts num">Total</th>        
                </tr>
            </thead>

            <?php $states = get_all_states(); ?>
            <?php $setoriais = get_setoriais(); ?>

            <tbody>
               <?php $votes = get_votos_afrodesc_estado_setorial($uf_selected, $setorial_selected); ?>
<?php
            $votos_afro = intval(($votes['afrodesc'] != '') ? $votes['afrodesc'] : 0);
            $votos_outros = intval(($votes['outros'] != '') ? $votes['outros'] : 0);
            $votos_tot = $votos_afro + $votos_outros;
            $votos_afro_perc = round($votos_afro / $votos_tot * 100, 2);
            $votos_outros_perc = round($votos_outros / $votos_tot * 100, 2);
?>
                            <?php $data[] = [$uf, $setorial, $votos_afro, $votos_outros, $votos_tot]; ?>            
                            <tr class="alternate">
<?php if ($uf_selected != ''): ?>
                                <td><?php echo $states[$uf_selected]; ?></td>
<?php endif; ?>
<?php if ($setorial_selected != ''): ?>            
                                <td><?php echo $setoriais[$setorial_selected]; ?></td>
<?php endif; ?>
                                <td class="num"><?php echo $votos_afro_perc ?>% (<?php echo $votos_afro; ?>)</td>
                                <td class="num"><?php echo $votos_outros_perc ?>% (<?php echo $votos_outros; ?>)</td>
                                <td class="num"><?php echo $votos_tot; ?></td>
                             </tr>
            </tbody>
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_votos_afrodesc' data_csv='<?php echo json_encode($data) ?>'>
    </div>
    
<?php } 


function candidatos_inabilitados_page_callback_function() {   
    if(!current_user_can('edit_published_posts')){
        return false;
    }

    $uf_selected = $_GET['uf'];    
    $setorial_selected = $_GET['setorial'];
    $states = get_all_states();
    $setoriais = get_setoriais();
    $data[] = ['Habilitados', 'Inabilitados', 'Total'];
    
    if (!in_array($setorial_selected, array_keys($setoriais))) {
        $setorial_selected = '';
    }
    if (!in_array($uf_selected, array_keys($states))) {
        $uf_selected = '';
    }
    
    ?>
    <h4>Selecione a UF:</h4>
    <select class="select-state-v" id="filtrar_uf">
      <option value="">Todas</option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
    </select>
      
    <h4>Selecione a Setorial:</h4>
    <select class="select-setorial-v" id="filtrar_setorial">
      <option value="">Todas</option>
      <?php foreach ( $setoriais as $slug => $setorial_item ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial_item ?></option>
      <?php endforeach ?>
    </select>
      <br/>
      <input type="button" value="buscar" id="candidatos_inabilitados" class="filtrar_relatorio">
      <br/><br/>    
    <?php
      if ($uf_selected || $setorial_selected) {
          // por uf ou setorial
          $candidatos_total = get_count_candidates($uf_selected, $setorial_selected, false);
          $candidatos_habilitados = get_count_candidates($uf_selected, $setorial_selected);
      } else {
          // total
          $candidatos_total = get_count_candidates(false, false, false);
          $candidatos_habilitados = get_count_candidates();
      }
      
      $candidatos_inabilitados = $candidatos_total - $candidatos_habilitados;
      if ($candidatos_habilitados == 0 || $candidatos_total == 0) {
          $candidatos_habilitados_perc = 0;
          $candidatos_inabilitados_perc = 0;
      } else {
          $candidatos_habilitados_perc = round($candidatos_habilitados / $candidatos_total * 100, 2);
          $candidatos_inabilitados_perc = round($candidatos_inabilitados / $candidatos_total * 100, 2);
      }
      $data[] = [$candidatos_habilitados, $candidatos_inabilitados, $candidatos_total];
    ?>
    <h2>Candidatos habilitados e inabilitados:</h2>
        <?php if ($uf_selected) { echo " <h4>" . $states[$uf_selected] . "</h4> "; } ?>
        <?php if ($setorial_selected) { echo " <h4>" . $setoriais[$setorial_selected] . "</h4>"; } ?>
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-posts">Habilitados</th>
                    <th scope="col"  class="manage-column column-role num">Inabilitados</th>
                    <th scope="col"  class="manage-column column-role num">Total</th>
                </tr>
            </thead>    
            <tbody>
                           <tr class="alternate">
    <td class="num"><?php echo $candidatos_habilitados;?> (<?php echo $candidatos_habilitados_perc; ?>%)</td>
    <td class="num"><?php echo $candidatos_inabilitados;?> (<?php echo $candidatos_inabilitados_perc; ?>%)</td>
    <td class="num"><strong><?php echo $candidatos_total;?></strong></td>    
                            </tr>
            </tbody>
      </table>
      <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_habilitados_inabilitados' data_csv='<?php echo json_encode($data) ?>'>                    
?>

    <div class="wrap span-20">

    <h2>Candidatos inabilitados por setorial/estado</h2>

<?php } 


function listagem_votos_auditoria_page_callback_function() {
    
    if(!current_user_can('manage_options')){
        return false;
    }
    
    $uf_selected = $_GET['uf'];
    $setorial_selected = $_GET['setorial'];

    $states = get_all_states();
    $setoriais = get_setoriais();
    
    if (!in_array($uf_selected, array_keys($states))) {
        $uf_selected = '';
    }
    if (!in_array($setorial_selected, array_keys($setoriais))) {
        $setorial_selected = '';
    }
    
    ?>
    <h4>Selecione a UF:</h4>
    <select class="select-state-v" id="filtrar_uf">
      <option></option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
    </select>
      
    <h4>Selecione a Setorial:</h4>
    <select class="select-setorial-v" id="filtrar_setorial">
      <option></option>
      <?php foreach ( $setoriais as $slug => $setorial_item ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial_item ?></option>
      <?php endforeach ?>
    </select>
      <br/>
      <input type="button" value="buscar" id="listagem_votos_auditoria" class="filtrar_relatorio">
      <br/><br/>
      
<?php if ($uf_selected != '' && $setorial_selected != '') : ?>
<?php
      $data[] = ['nome', 'cpf', 'email', 'data de inscrição', 'candidato votado', 'qtd vezes trocou de voto']; 
      $votes = get_listagem_votos_auditoria($uf_selected, $setorial_selected);
    
      foreach ($votes as $vote) {

          $data[] = [
              $vote->nome,
              $vote->cpf,
              $vote->email,
              $vote->data_inscricao,
              $vote->candidato_votado,
              $vote->trocou
          ];
      }
    
?>     
      <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='<?php echo "auditoria-$uf_selected-$setorial_selected"; ?>' data_csv='<?php echo json_encode($data) ?>'>
<?php else: ?>
    Sem resultados.
<?php endif; ?>
<?php 
}


// somente exportação de csv
function maisvotados_setorial_estado_page_callback_function() {
    // candidato, no_votos, genero, raça
    
    if(!current_user_can('manage_options')){
        return false;
    }

    $data[] = ['candidato', 'num_votos', 'genero', 'afrodescendente']; 
    $uf_selected = $_GET['uf'];
    $setorial_selected = $_GET['setorial'];
    
    $states = get_all_states();
    $setoriais = get_setoriais();
    
    if (!in_array($uf_selected, array_keys($states))) {
        if ($uf_selected != 'todos') {
            $uf_selected = '';
        }
    } else {
        $data[] = 'uf';
    }
    if (!in_array($setorial_selected, array_keys($setoriais))) {
        if ($setorial_selected != 'todos') {
            $setorial_selected = '';
        }
    } else {
        $data[] = 'setorial';
    }
    
    ?>
    <h4>Selecione a UF:</h4>
    <select class="select-state-v" id="filtrar_uf">
      <option></option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
      <option value="todos" <?php if ($uf_selected == 'todos') { echo "selected"; } ?>>TODOS</option>
    </select>
      
    <h4>Selecione a Setorial:</h4>
    <select class="select-setorial-v" id="filtrar_setorial">
      <option></option>
      <?php foreach ( $setoriais as $slug => $setorial_item ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial_item ?></option>
      <?php endforeach ?>
      <option value="todos" <?php if ($setorial_selected == 'todos') { echo "selected"; } ?>>TODOS</option>      
    </select>
      <br/>
      <input type="button" value="buscar" id="maisvotados_setorial_estado" class="filtrar_relatorio">
      <br/><br/>
      
<?php
      if ($uf_selected || $setorial_selected) {
          
          if ($uf_selected == 'todos') {
              $uf_selected = '';
          }
          if ($setorial_selected == 'todos') {
              $setorial_selected = '';
          }
          
          $votes = get_maisvotados_setorial_estado($uf_selected, $setorial_selected);
          
          foreach ($votes as $vote) {
              
              $data[] = [
                  $vote->candidato,
                  $vote->num_votos,
                  $vote->genero,
                  $vote->afrodescendente,
                  $vote->uf,
                  $vote->setorial
              ];
          }
          
          $nome_relatorio = "";
          if ($uf_selected && $setorial_selected) {
              $nome_relatorio = "apuracao-$uf_selected-$setorial_selected";
          } else if ($uf_selected && !$setorial_selected) {
              $nome_relatorio = "apuracao-resumo-$uf_selected";
          } else if (!$uf_selected && $setorial_selected) {
              $nome_relatorio = "apuracao-resumo-$setorial_selected";
          } else {
              $nome_relatorio = "apuracao-resumo-nacional";
          }
?>     
          <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='<?php echo $nome_relatorio; ?>' data_csv='<?php echo json_encode($data) ?>'>
          
<?php 
      }   
}



// somente exportação de csv
function resumo_setoriais_page_callback_function() {
    
}



?>
