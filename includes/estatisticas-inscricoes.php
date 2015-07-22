<?php

add_action('admin_init', 'inscricoes_estatisticas_init');
add_action('admin_menu', 'inscricoes_estatisticas_menu');

function inscricoes_estatisticas_init() {
    register_setting('inscricoes_estatisticas_options', 'inscricoes_estatisticas', 'inscricoes_estatisticas_validate_callback_function');
}

function inscricoes_estatisticas_menu() {


    $topLevelMenuLabel = 'Número de Inscrições';
    $page_title = 'Número de Inscrições';
    $menu_title = 'Número de Inscrições';

    /* Top level menu */
    add_submenu_page('inscricoes_estatisticas', $page_title, $menu_title, 'manage_options', 'inscricoes_estatisticas', 'inscricoes_estatisticas_page_callback_function');
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'inscricoes_estatisticas', 'inscricoes_estatisticas_page_callback_function');


}

function inscricoes_estatisticas_page_callback_function() {

    global $wpdb;
    $norte = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-region' and meta_value = 'nortecentroeste'");
    $sul = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-region' and meta_value = 'sul'");
    $sudeste = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-region' and meta_value = 'sudeste'");
    $nordeste = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-region' and meta_value = 'nordeste'");
    
    $enviados = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'subscription_number'");
    
    $excluiEnviadosSQL = "AND post_id NOT IN (SELECT post_id from $wpdb->postmeta where meta_key = 'subscription_number')";
    
    $orcamento_completo = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'budget-complete' $excluiEnviadosSQL");
    $orcamento = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'budget-total' $excluiEnviadosSQL");
    $titulo = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'project-title' $excluiEnviadosSQL");
    $nome_diretor = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'director-name' $excluiEnviadosSQL");
    $nome_produtora = $wpdb->get_var("select COUNT(meta_id) from $wpdb->postmeta where meta_key = 'company-name' $excluiEnviadosSQL");
    

?>
  <div class="wrap span-20">
    <h2>Número de Inscrições</h2>

    
    <table class="wp-list-table widefat">
    
        <tr class="alternate">
            <td><b>Projetos Enviados</b></td>
            <td><?php echo $enviados; ?></td>
        </tr>
        <tr class="alternate">
            <td colspan="2"><b>Projetos em Andamento (não inclui os enviados)</b></td>
        </tr>
        <tr class="alternate">
            <td>já preencheram o Nome da produtora</td>
            <td><?php echo $nome_produtora; ?></td>
        </tr>
        <tr class="alternate">
            <td>já preencheram o nome do diretor</td>
            <td><?php echo $nome_diretor; ?></td>
        </tr>
        <tr class="alternate">
            <td> já preencheram o titulo do projeto</td>
            <td><?php echo $titulo; ?></td>
        </tr>
        <tr class="alternate">
            <td>ja tem o orcamento total</td>
            <td><?php echo $orcamento; ?></td>
        </tr>
        <tr class="alternate">
            <td> ja anexaram o orcamento completo em pdf</td>
            <td><?php echo $orcamento_completo; ?></td>
        </tr>
        <tr class="alternate">
            <td colspan="2"><b>Projetos por região da produtora (enviados e não enviados)</b></td>
        </tr>
        <tr class="alternate">
            <td>Sul</td>
            <td><?php echo $sul; ?></td>
        </tr>
        <tr class="alternate">
            <td>Sudeste</td>
            <td><?php echo $sudeste; ?></td>
        </tr>
        <tr class="alternate">
            <td>Nordeste</td>
            <td><?php echo $nordeste; ?></td>
        </tr>
        <tr class="alternate">
            <td>Norte/Centro-Oeste</td>
            <td><?php echo $norte; ?></td>
        </tr>
    
    </table>
    
    
  </div>

<?php } ?>
