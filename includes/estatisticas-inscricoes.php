<?php

add_action('admin_init', 'inscricoes_estatisticas_init');
add_action('admin_menu', 'inscricoes_estatisticas_menu');

function inscricoes_estatisticas_init() {
    register_setting('inscricoes_estatisticas_options', 'inscricoes_estatisticas', 'inscricoes_estatisticas_validate_callback_function');
	wp_enqueue_script( 'filtros-relatorios', get_template_directory_uri() . '/js/filtros-relatorios.js');    
}

function inscricoes_estatisticas_menu() {


    $topLevelMenuLabel = 'Relatórios';

    /* Top level menu */
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'inscricoes_estatisticas', 'inscricoes_estatisticas_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos inscritos por setorial/estado', 'Candidatos inscritos', 'manage_options', 'candidatos_inscritos', 'candidatos_inscritos_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos por gênero por setorial/estado', 'Candidatos por gênero', 'manage_options', 'candidatos_genero', 'candidatos_genero_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos afrodescendentes por setorial/estado', 'Candidatos afrodescendentes', 'manage_options', 'candidatos_afrodescententes', 'candidatos_afrodescententes_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Votos por setorial/estado', 'Votos por setorial', 'manage_options', 'votos_setorial', 'votos_setorial_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Votos por gênero setorial/estado', 'Votos por gênero', 'manage_options', 'votos_genero', 'votos_genero_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Votos por afrodescendência setorial/estado', 'Votos por afrodescendência', 'manage_options', 'votos_afrodescendencia', 'votos_afrodescendencia_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Eleitores por faixa etária por setorial/estado', 'Eleitores por faixa etária', 'manage_options', 'eleitores_faixa_etaria', 'eleitores_faixaetaria_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos por faixa etária por setorial/estado', 'Candidatos por faixa etária', 'manage_options', 'candidatos_faixa_etaria', 'candidatos_faixaetaria_page_callback_function');
    add_submenu_page('inscricoes_estatisticas', 'Candidatos habilitados e inabilitados por setorial/estado', 'Candidatos habilitados e inabilitados', 'manage_options', 'candidatos_habilitados_inabilitados', 'candidatos_habilitados_inabilitados_page_callback_function');
   add_submenu_page('inscricoes_estatisticas', 'Eleitores e candidatos por setorial/estado', 'Eleitores e candidatos setorial/estado', 'manage_options', 'eleitores_candidatos_setorial', 'eleitores_candidatos_setorial_page_callback_function');
   add_submenu_page('inscricoes_estatisticas', 'Total de candidatos e eleitores', 'Total candidatos e eleitores', 'manage_options', 'total_candidatos_eleitores', 'total_candidatos_eleitores_page_callback_function');
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


function inscricoes_estatisticas_page_callback_function() {
    ?>
    <div class="wrap span-20">
    <h2>Lista de relatórios</h2>

    <ul>
    <li>Relatórios</li>
    <li><a href='admin.php?page=candidatos_inscritos'>Candidatos inscritos</a></li>
    <li><a href='admin.php?page=candidatos_genero'>Candidatos por gênero</a></li>
    <li><a href='admin.php?page=candidatos_afrodescententes'>Candidatos afrodescendentes</a></li>
    <li><a href='admin.php?page=votos_setorial'>Votos por setorial</a></li>
    <li><a href='admin.php?page=votos_genero'>Votos por gênero</a></li>
    <li><a href='admin.php?page=votos_afrodescendencia'>Votos por afrodescendência</a></li>
    <li><a href='admin.php?page=eleitores_faixa_etaria'>Eleitores por faixa etária</a></li>
    <li><a href='admin.php?page=candidatos_faixa_etaria'>Candidatos por faixa etária</a></li>
    <li><a href='admin.php?page=candidatos_habilitados_inabilitados'>Candidatos habilitados e inabilitados</a></li>
    <li><a href='admin.php?page=eleitores_candidatos_setorial'>Eleitores e candidatos setorial/estado</a></li>
    <li><a href='admin.php?page=total_candidatos_eleitores'>Total candidatos e eleitores</a></li>
    </ul>
    
    <?php
}

function candidatos_inscritos_page_callback_function() {   
?>

    <div class="wrap span-20">

        <h2>Inscrições</h2>
        <table class="wp-list-table widefat">
            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-posts num">Comentários</th>
                    <th scope="col"  class="manage-column column-posts num">Candidatos</th>
                    <th scope="col"  class="manage-column column-role num">Eleitores</th>
                </tr>
            </thead>

            <?php $states = get_all_states(); ?>
            <?php $setoriais = get_setoriais(); ?>

            <tbody>
                <?php foreach ( $states as $uf => $state ): ?>
                    <?php $users = get_count_users_setorias_by_uf($uf); ?>
                    <?php $candidates = get_count_candidates_setoriais_by_uf($uf); ?>

                    <?php foreach ( $setoriais as $slug => $setorial ): ?>
                        
                        <?php if( $users[$slug] != 0 ) : ?>

                            <?php $page = get_page_by_path( $uf .'-'. $slug, 'OBJECT', 'foruns' ) ?>

                            <tr class="alternate">
                                <td><?php echo $uf; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php echo $page->comment_count; ?></td>
                                <td class="num"><?php echo $candidates[$slug];?></td>
                                <td class="num"><?php echo $users[$slug]-$candidates[$slug]; ?></td>
                            </tr>
                        <?php endif; ?>

                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

<?php } 

                function candidatos_genero_page_callback_function() {
?>

    <div class="wrap span-20">
        <h2>Candidatos por gênero por setorial/estado</h2>
    <h3>Selecione o estado ou a setorial</h3>
                    
<?php
// tenta pegar UF para fazer filtros
$uf_selected = $_GET['uf'];
$states = get_all_states();
$setoriais = get_setoriais();

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
                            <tr class="alternate">
                                <td><?php echo $uf_selected; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php echo $candidates_fem_perc ?>% (<?php echo $candidates_fem; ?>)</td>
                                <td class="num"><?php echo $candidates_masc_perc ?>% (<?php echo $candidates_masc; ?>)</td>
                                <td class="num"><?php echo $candidates_tot; ?></td>                    
                            </tr>
                        <?php endif; ?>
                    <?php endforeach ?>
            </tbody><?php      
} else {
    
} ?>
                
        </table>    

<?php } 


function candidatos_afrodescententes_page_callback_function() {   
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

    
<?php } 


function votos_setorial_page_callback_function() {   
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
    </div>

    
<?php } 


function votos_genero_page_callback_function() {   
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
    </div>
    
<?php } 


function votos_afrodescendencia_page_callback_function() {   
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
    </div>
    
<?php } 


function eleitores_faixaetaria_page_callback_function() {   
?>

    <div class="wrap span-20">

    <h2>Eleitores por faixa etária por setorial/estado</h2>

<?php } 


function candidatos_faixaetaria_page_callback_function() {   
?>

    <div class="wrap span-20">

    <h2>Candidatos por faixa etária por setorial/estado</h2>

<?php } 


function candidatos_habilitados_inabilitados_page_callback_function() {   
?>

    <div class="wrap span-20">

    <h2>Candidatos habilitados e inabilitados por setorial/estado</h2>

<?php } 


function eleitores_candidatos_setorial_page_callback_function() {   
?>

    <div class="wrap span-20">

    <h2>Eleitores e candidatos por setorial/estado</h2>

<?php } 


function total_candidatos_eleitores_page_callback_function() {   
?>

    <div class="wrap span-20">

    <h2>Total de candidatos e eleitores</h2>

<?php } ?>