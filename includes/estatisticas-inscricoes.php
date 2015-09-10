<?php

add_action('admin_init', 'inscricoes_estatisticas_init');
add_action('admin_menu', 'inscricoes_estatisticas_menu');

function inscricoes_estatisticas_init() {
    register_setting('inscricoes_estatisticas_options', 'inscricoes_estatisticas', 'inscricoes_estatisticas_validate_callback_function');
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


/*
  3) candidatos genero setorial estado - ok
  4) candidatos afrodescendencia setorial estado - ok
  5) votos setorial estado - ok
  6) votos setorial estado genero - ok
  7) votos setorial estado afrodescendencia - ok
  8) faixa estaria setorial estado
  10) inscritos habilitados e inabilitados estado
  11) numero de eleitores e candidados por setorial nacional
  relatorio de usuarios: mostrar no perfil do eleitor o estado e setorial
  total inscricoes e total inscricoes candidatos
  tornar menu relatorios visualizavel pelo perfil de editora / membro da comissao eleitoral
 */

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

        <table class="wp-list-table widefat">

            <thead>
                <tr>
                    <th scope="col"  class="manage-column column-role">Estado</th>
                    <th scope="col"  class="manage-column column-posts">Setorial</th>
                    <th scope="col"  class="manage-column column-posts num">Mulheres</th>
                    <th scope="col"  class="manage-column column-posts num">Homens</th>    
                </tr>
            </thead>

            <?php $states = get_all_states(); ?>
            <?php $setoriais = get_setoriais(); ?>

            <tbody>
                <?php foreach ( $states as $uf => $state ): ?>
                    <?php $candidates = get_count_candidates_setoriais_genre_by_uf($uf); ?>

                    <?php foreach ( $setoriais as $slug => $setorial ): ?>

                    <?php if( !empty($candidates[$slug]) ) : ?>
                            <tr class="alternate">
                                <td><?php echo $uf; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php $votes = ($candidates[$slug]['feminino'] != '') ? $candidates[$slug]['feminino'] : 0; echo $votes; ?></td>
                                <td class="num"><?php $votes = ($candidates[$slug]['masculino'] != '') ? $candidates[$slug]['masculino'] : 0; echo $votes; ?></td>

                            </tr>
                        <?php endif; ?>

                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody>
                
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
                </tr>
            </thead>

            <?php $states = get_all_states(); ?>
            <?php $setoriais = get_setoriais(); ?>

            <tbody>
                <?php foreach ( $states as $uf => $state ): ?>
                    <?php $candidates = get_count_candidates_setoriais_afrodesc_by_uf($uf); ?>

                    <?php foreach ( $setoriais as $slug => $setorial ): ?>

                    <?php if( !empty($candidates[$slug]) ) : ?>
                            <tr class="alternate">
                                <td><?php echo $uf; ?></td>
                                <td><a href="<?php echo site_url('foruns/' . $uf .'-'. $slug); ?>"><?php echo $setorial; ?></a></td>
                                <td class="num"><?php $votes = ($candidates[$slug]['afro'] != '') ? $candidates[$slug]['afro'] : 0; echo $votes; ?></td>
                                <td class="num"><?php $votes = ($candidates[$slug]['outros'] != '') ? $candidates[$slug]['outros'] : 0; echo $votes; ?></td>

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

<?php } 


function votos_afrodescendencia_page_callback_function() {   
?>

    <div class="wrap span-20">

        <h2>Votos por afrodescendência setorial/estado</h2>

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