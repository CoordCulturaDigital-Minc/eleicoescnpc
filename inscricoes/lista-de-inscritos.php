<?php

/**
 * Aparece na página de inscrições para os curadores e administradores.
 *
 * @package forunssetoriaiscnpc
 */

if(!isset($errors)) {
    $errors = new WP_Error();
}

$notice_msg = array();
$success_msg = array();
if(isset($_GET['msg']) && $_GET['msg'] === 'avaliacao-salva') {
    $success_msg[] = "A avaliação foi salva com sucesso";
}

if(get_theme_option('avaliacoes_abertas') != '1') {
    $notice_msg[] = 'O período para avaliação encerrou.';
}

wp_enqueue_script('lista-de-inscritos', get_setoriaiscnpc_baseurl().'js/lista-de-inscritos.js', array('jquery', 'tablesorter'));
wp_localize_script('lista-de-inscritos', 'inscricoes', array('ajaxurl' => admin_url('admin-ajax.php')));

wp_enqueue_script('tablesorter', get_setoriaiscnpc_baseurl().'js/jquery.tablesorter.min.js', array('jquery'));
wp_enqueue_style('admin', get_template_directory_uri().'/admin.css');
wp_enqueue_script('filtros-relatorios', get_template_directory_uri() . '/js/filtros-relatorios.js');

$setorial = isset( $_POST['setorial'] ) ? $_POST['setorial'] : "arquitetura-urbanismo";

if( current_user_can('curate') && !current_user_can('administrator') )
    $setorial = get_user_meta( get_current_user_id(),'setorial_curate',true);

$subscriptions = list_candidates_by_setorial(
                    array('candidate-name','candidate-setorial','candidate-state','project-title','subscription_number'),
                    !current_user_can('administrator'), $setorial // valid_only só se não for admin
                );
?>

<?php get_header(); ?>

    <section class="col-xs-12">
        <?php if(count($errors->errors) > 0): ?>
            <ul class="error">
            <?php foreach($errors->get_error_messages() as $message): ?>
                <li><?php echo $message;?></li>
            <?php endforeach;?>
            </ul>
        <?php endif;?>

        <?php if($success_msg): ?>
            <ul class="success">
            <?php foreach($success_msg as $msg) :?>
                <li><?php echo $msg;?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if($notice_msg): ?>
            <ul class="notice">
            <?php foreach($notice_msg as $msg) :?>
                <li><?php echo $msg;?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <h2 class="page__title">Lista de inscritos</h2>

        <?php if( !current_user_can('curate') || current_user_can('administrator') ) : ?>
            <form method="post" id="filter_setorial">    
                <label for="setorial">Selecione a setorial:</label>
                <?php echo dropdown_setoriais('setorial', $setorial, true) ?>
            </form>
        <?php endif; ?>

        <div class="finder-wrapper">
            <label for="finder">Localizar projeto pelo número do CPF</label>
            <input type="text" id="finder" class="js-finder" value="" />
        </div>

        <table class="js-sortable-table  inscritos--lista">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Candidato</th>
                    <th>Setorial</th>
                    <th>Estado</th>
                    <th>CPF</th>
                    <?php if(current_user_can('administrator')): ?>
                        <th>Votos</th>
                    <?php endif; ?>
                    <?php if(!current_user_can('administrator')): ?>
                        <th>Avaliação</th>
                    <?php endif; ?>
                    <?php if(current_user_can('administrator')):?>
                        <th>Situação</th>
                        <th></th>
                    <?php endif; ?>

                </tr>
            </thead>
            <tbody>
            <?php if( !empty($subscriptions) ) : ?>
                <?php $data[] = ['Candidato', 'Setorial', 'Estado', 'CPF', 'Votos', 'Situação']; ?>
                <?php $i=1;foreach($subscriptions as $s): $subscription_number=substr($s['subscription_number'],0,8); ?>
                    
                    <?php $userID = get_post_field( 'post_author', $s['pid'] ); ?>
                    <?php $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $userID ) ); ?>
                    <?php $uf_setorial = isset( $user_meta['uf-setorial'] ) ? $user_meta['uf-setorial'] : ''; ?>
                    <?php if(current_user_can('administrator')) $number_votes = get_number_of_votes_by_project($s['pid']); ?>

                    <tr>
                        <td class="subscription__order"><?php echo $i++;?></td>
                        <td class="subscription__candidate"><a href="<?php echo site_url("inscricoes/$subscription_number");?>" title="Ver a ficha do candidato"><?php echo isset( $user_meta['user_name'] ) ? $user_meta['user_name'] : ''; ?></a></td>
                        <td class="subscription__setorial"><a href='<?php echo site_url("foruns/$uf_setorial");?>' title="Ver fórum deste candidato"><?php echo isset( $user_meta['setorial'] ) ? get_label_setorial_by_slug($user_meta['setorial']) : ''; ?></a></td>
                        <td class="subscription__state"><?php echo isset( $user_meta['UF'] ) ? $user_meta['UF'] : ''; ?></td>
                        <td class="subscription__cpf"><?php echo isset( $user_meta['cpf'] ) ? $user_meta['cpf'] : ''; ?></td>
                        <?php if(current_user_can('administrator')): ?>
                            <td class="subscription__id text-center"><a href="<?php echo site_url("inscricoes/$subscription_number");?>" title="Ver a ficha do candidato"><span class="subscription_number"><?php echo $number_votes; ?></span></a></td>
                        <?php endif; ?>
                        <?php if(!current_user_can('administrator')): ?>
                            <td><?php $e = load_evaluation($s['pid']);

                                   echo isset( $e["evaluation-status"] ) ? label_status_candidate($e["evaluation-status"]) : '';
                                   echo "<br>";
                                   echo isset( $e["remarks-comment"]) ? $e["remarks-comment"] : '';
                                ?>
                            </td>
                        <?php endif; ?>
                    <?php if(current_user_can('administrator')): ?>
                        <?php if(isset($s['subscription-valid'])):?>
                            <td id="user-<?php echo $s['pid'];?>" class="subscription__status subscription__status--valid"><a href="<?php echo site_url("inscricoes/$subscription_number");?>" title="<?php _e( 'Valid!', 'historias'); ?>"><i class="fa fa-check"></i><span class="assistive-text"><?php _e( 'Valid!', 'historias'); ?></a></td>
                        <?php else: ?>
                            <td id="user-<?php echo $s['pid'];?>" class="subscription__status  subscription__status--invalid"><a href="<?php echo site_url("inscricoes/$subscription_number");?>" title="<?php _e( 'Invalid!', 'historias'); ?>"><i class="fa fa-times"></i><span class="assistive-text"><?php _e( 'Invalid!', 'historias'); ?></span></a></td>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(current_user_can('administrator')):?>
                        <td id="pid-<?php echo $s['pid'];?>" class="cancel-subscription"><i class="fa fa-unlock" title="<?php _e( 'Reopen Subscription', 'historias'); ?>"></i></td>
                    <?php endif;  ?>
                    </tr>
<?php $data[] = [
    (isset( $user_meta['user_name'] ) ? $user_meta['user_name'] : ''),
    (isset( $user_meta['setorial'] ) ? $user_meta['setorial'] : ''),
    (isset( $user_meta['UF'] ) ? $user_meta['UF'] : ''),
    (isset( $user_meta['cpf'] ) ? $user_meta['cpf'] : ''),
    (isset( $number_votes ) ? $number_votes :''),
    (isset( $e["evaluation-status"] ) ? label_status_candidate($e["evaluation-status"]) : '')
]; ?>                                       
                <?php endforeach;?>
            <?php else : ?>
                <tr align="center">
                    <td colspan="6">Nenhum resultado</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <iframe id="iframeExportar" frameborder="0" src="<?php echo get_template_directory_uri(); ?>/baixar-csv.php" data_filename='relatorio_inscritos_setorial' data_csv='<?php echo json_encode($data) ?>'>
        </iframe>
    </section>

<?php get_footer(); ?>
