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
    add_submenu_page('inscricoes_estatisticas', 'Inscrições por Setorial (total nacional)', 'Inscrições por Setorial (total nacional)', 'edit_published_posts', 'inscritos_setorial', 'inscritos_setorial_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Inscrições por Setorial/Estado', 'Inscrições por Setorial/Estado', 'edit_published_posts', 'inscritos_setorial_estado', 'inscritos_setorial_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Inscritos que votaram/não votaram', 'Inscritos que votaram/não votaram', 'edit_published_posts', 'votos_inscritos_votaram', 'votos_inscritos_votaram_page_callback_function');
    
    /* candidatos */    
    add_submenu_page('inscricoes_estatisticas', 'Candidatos inscritos por setorial', 'Candidatos inscritos por setorial', 'edit_published_posts', 'candidatos_setorial', 'candidatos_setorial_page_callback_function');        
    add_submenu_page('inscricoes_estatisticas', 'Candidatos inscritos - total por estado', 'Candidatos inscritos - total por estado', 'edit_published_posts', 'candidatos_estado', 'candidatos_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos inscritos por setorial/estado', 'Candidatos inscritos por setorial/estado', 'edit_published_posts', 'candidatos_setorial_estado', 'candidatos_setorial_estado_page_callback_function');        
    add_submenu_page('inscricoes_estatisticas', 'Candidatos por gênero por setorial/estado', 'Candidatos por gênero', 'edit_published_posts', 'candidatos_genero', 'candidatos_genero_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos afrodescendentes por setorial/estado', 'Candidatos afrodescendentes', 'edit_published_posts', 'candidatos_afrodescententes', 'candidatos_afrodescententes_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos inabilitados', 'Candidatos inabilitados', 'edit_published_posts', 'candidatos_inabilitados', 'candidatos_inabilitados_page_callback_function');
    
    /* votos */
    add_submenu_page('inscricoes_estatisticas', 'Total geral de votos', 'Total geral de votos', 'manage_options', 'votos_total', 'votos_total_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Total de votos por estado', 'Votos por estado', 'manage_options', 'votos_estado', 'votos_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Total de votos por setorial', 'Votos por setorial', 'manage_options', 'votos_setorial', 'votos_setorial_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Total de votos por gênero', 'Votos por gênero', 'manage_options', 'votos_genero', 'votos_genero_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Total de votos por afrodescendência', 'Votos por afrodescendência', 'manage_options', 'votos_afrodescendencia', 'votos_afrodescendencia_page_callback_function');           
    add_submenu_page('inscricoes_estatisticas', 'Votos por setorial/estado', 'Votos por setorial/estado', 'manage_options', 'votos_setorial_estado', 'votos_setorial_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Votos por gênero setorial/estado', 'Votos por gênero', 'manage_options', 'votos_genero_setorial_estado', 'votos_genero_setorial_estado_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Votos por afrodescendência setorial/estado', 'Votos por afrodescendência', 'manage_options', 'votos_afrodescendencia_setorial_estado', 'votos_afrodescendencia_setorial_estado_page_callback_function');

    /* verificacao de fraude */
    add_submenu_page('inscricoes_estatisticas', 'Auditoria: votos por setorial/estado ', 'Auditoria: votos por setorial estado', 'manage_options', 'listagem_votos_auditoria', 'listagem_votos_auditoria_page_callback_function');    
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

    <div class="wrap span-20">
    <h2>Total de inscrições:</h2>

<p>Eleitores inscritos: <?php echo $inscritos; ?></p>
<p>Candidatos inscritos: <?php echo $candidates; ?></p>
    </div>

    <h2>Lista de relatórios</h2>

	<ul class='wp-submenu wp-submenu-wrap'>
    <li><h4>Inscritos</h4></li>            
    <li><a href='admin.php?page=inscritos_estado'>Inscrições por Estado</a> <small>disponível</small></li>
    <li><a href='admin.php?page=inscritos_setorial'>Inscrições por Setorial (total nacional)</a> <small>disponível</small></li>
    <li><a href='admin.php?page=inscritos_setorial_estado'>Inscrições por Setorial/Estado</a> <small>disponível</small></li>
    <li><a href='admin.php?page=votos_inscritos_votaram'>Inscritos que votaram/não votaram</a></li>
    <li><h4>Candidatos</h4></li>        
    <li><a href='admin.php?page=candidatos_estado'>Candidatos por estado - total por estado</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_setorial'>Candidatos por setorial</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_setorial_estado'>Candidatos por setorial/estado</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_genero'>Candidatos por gênero</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_afrodescententes'>Candidatos afrodescendentes</a> <small>disponível</small></li>
    <li><a href='admin.php?page=candidatos_inabilitados'>Candidatos inabilitados</a></li>

<?php if(current_user_can('manage_options')): ?>
    <li><h4>Votos</h4></li>    
    <li><a href='admin.php?page=votos_total'>Total geral de votos</a></li>
    <li><a href='admin.php?page=votos_estado'>Votos por estado</a></li>
    <li><a href='admin.php?page=votos_setorial'>Votos por setorial</a> <small>disponível</small></li>
    <li><a href='admin.php?page=votos_setorial_estado'>Votos por setorial/estado</a> </li>    
    <li><a href='admin.php?page=votos_genero'>Votos por gênero</a> <small>disponível</small></li>
    <li><a href='admin.php?page=votos_afrodescendencia'>Votos por afrodescendência</a> <small>disponível</small></li>
    <li><a href='admin.php?page=votos_afrodescendencia_setorial_estado'>Votos por setorial/estado por afrodescendência</a> </li>
    <li><a href='admin.php?page=votos_genero_setorial_estado'>Votos por setorial/estado por gênero</a></li>    
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
                                <td class="num"><?php echo $state; ?></td>
                                <td class="num"><?php echo $users[$uf]; ?></td>
                            </tr>
                    <?php endforeach ?>
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

function inscritos_setorial_page_callback_function() {
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

function candidatos_estado_page_callback_function() {   
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
                    <th scope="col"  class="manage-column column-role num">Candidados</th>
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
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_total_estado' data_csv='<?php echo json_encode($data) ?>'>        
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
            <tbody>
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
?>
                            <?php $data[] = [$setorial, $candidates_fem, $candidates_masc, $candidates_fem, $candidates_tot]; ?>  
                            <tr class="alternate">
                                <td><?php echo $uf; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php echo $candidates_fem_perc ?>% (<?php echo $candidates_fem; ?>)</td>
                                <td class="num"><?php echo $candidates_masc_perc ?>% (<?php echo $candidates_masc; ?>)</td>
                                <td class="num"><?php echo $candidates_tot; ?></td>                    
                            </tr>
                        <?php endif; ?>
                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody><?php   
    
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
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_genero' data_csv='<?php echo json_encode($data) ?>'>
    </div>
<?php      
  }
}


function candidatos_afrodescententes_page_callback_function() {
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
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_candidatos_afrodescendencia' data_csv='<?php echo json_encode($data) ?>'>
    </div>
    
<?php } 


/***
 * VOTOS
 **/

function votos_total_page_callback_function() {
    if(!current_user_can('manage_options')){
        return false;
    }
}

function votos_estado_page_callback_function() {
    if(!current_user_can('manage_options')){
        return false;
    }    
}

function votos_setorial_estado_page_callback_function() {
    if(!current_user_can('manage_options')){
        return false;
    }
}

function votos_genero_setorial_estado_page_callback_function() {
    if(!current_user_can('manage_options')){
        return false;
    }
}

function votos_afrodescendencia_setorial_estado_page_callback_function() {
    if(!current_user_can('manage_options')){
        return false;
    }
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
    
<?php } 


function votos_afrodescendencia_page_callback_function() {   
    if(!current_user_can('manage_options')){
        return false;
    }
    $data[] = ['Estado', 'Setorial', 'Afrodescendentes', 'Outros', 'Total'];        
?>

    <div class="wrap span-20">

        <h2>Votos por afrodescendência setorial/estado</h2>

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

            <?php $states = get_all_states(); ?>
            <?php $setoriais = get_setoriais(); ?>

            <tbody>
                <?php foreach ( $states as $uf => $state ): ?>
                    <?php $votes = get_number_of_votes_setorial_race_by_uf($uf); ?>
                    <?php foreach ( $setoriais as $slug => $setorial ): ?>
                        <?php if( $votes[$slug] != 0 ) : ?>
                            <?php $page = get_page_by_path( $uf .'-'. $slug, 'OBJECT', 'foruns' ) ?>

<?php
            $votos_afro = intval(($votes[$slug]['afro'] != '') ? $votes[$slug]['afro'] : 0);
            $votos_outros = intval(($votes[$slug]['outros'] != '') ? $votes[$slug]['outros'] : 0);
            $votos_tot = $votos_afro + $votos_outros;
            $votos_afro_perc = round($votos_afro / $votos_tot * 100, 2);
            $votos_outros_perc = round($votos_outros / $votos_tot * 100, 2);
?>
                            <?php $data[] = [$uf, $setorial, $votos_afro, $votos_outros, $votos_tot]; ?>            
                            <tr class="alternate">
                                <td><?php echo $uf; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php echo $votos_afro_perc ?>% (<?php echo $votos_afro; ?>)</td>
                                <td class="num"><?php echo $votos_outros_perc ?>% (<?php echo $votos_outros; ?>)</td>
                                <td class="num"><?php echo $votos_tot; ?></td>
                             </tr>
                        <?php endif; ?>

                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody>
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_votos_afrodescendencia' data_csv='<?php echo json_encode($data) ?>'>
    </div>
    
<?php } 


function candidatos_inabilitados_page_callback_function() {   
    if(!current_user_can('edit_published_posts')){
        return false;
    }
?>

    <div class="wrap span-20">

    <h2>Candidatos inabilitados por setorial/estado</h2>

<?php } 


function total_candidatos_eleitores_page_callback_function() {   
    if(!current_user_can('edit_published_posts')){
        return false;
    }
?>

    <div class="wrap span-20">

    <h2>Total de candidatos e eleitores</h2>

<?php }

function listagem_votos_auditoria_page_callback_function() {
    
    if(!current_user_can('manage_options')){
        return false;
    }
    
    $uf_selected = $_GET['uf'];
    $setorial_selected = $_GET['setorial'];

    $states = get_all_states();
    $setoriais = get_setoriais();
    //$data[] = ['Setorial', 'Candidatos'];
    
    if (!in_array($uf_selected, array_keys($states))) {
        $uf_selected = '';
    }
    if (!in_array($setorial_selected, array_keys($setoriais))) {
        $setorial_selected = '';
    }
    
    ?>
    <h4>Selecione a UF:</h4>
    <select class="select-state-auditoria" id="uf_listagem_votos_auditoria">
      <option></option>
      <?php foreach ( $states as $uf_item => $state_item ): ?>
      <option value="<?php echo $uf_item ?>" <?php if ($uf_item == $uf_selected) { echo "selected"; } ?>><?php echo $state_item ?></option>
      <?php endforeach ?>
    </select>
      
    <h4>Selecione a Setorial:</h4>
    <select class="select-setorial-auditoria" id="setorial_listagem_votos_auditoria">
      <option></option>
      <?php foreach ( $setoriais as $slug => $setorial_item ): ?>
      <option value="<?php echo $slug ?>" <?php if ($slug == $setorial_selected) { echo "selected"; } ?>><?php echo $setorial_item ?></option>
      <?php endforeach ?>
    </select>
      <br/>
      <input type="button" value="buscar" id="listagem_votos_auditoria">
      <br/><br/>
      
<?php if ($uf_selected != '' && $setorial_selected != '') : ?>
<?php
      /*
        pegar de todos os votantes da setorial xyz e UF xy:
        nome, cpf, email, data_inscricao, candidado_votado, trocou_voto     
      */
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
<?php endif; ?>
<?php 
}
?>
