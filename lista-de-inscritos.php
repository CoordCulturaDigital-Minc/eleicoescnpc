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

$subscriptions = list_subscriptions(
                    array('candidate-name','candidate-setorial','candidate-state','project-title','subscription_number'),
                    !current_user_can('administrator') // valid_only só se não for admin
                );
?>

<?php get_header(); ?>

    <div class="content  content--full">
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

        <div class="finder-wrapper">
            <label for="finder">Localizar projeto pelo número de inscrição</label>
            <input type="text" id="finder" class="js-finder" value="" />
        </div>

        <table class="js-sortable-table  inscritos--lista">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Candidato</th>
                    <th>Setorial</th>
                    <th>Projeto</th>
                    <th>Estado</th>
                    <th>Número</th>
                    <?php if(!current_user_can('administrator')): ?>
                        <th>Minha nota</th>
                    <?php endif; ?>
                    <?php if(current_user_can('administrator')):?>
                        <th>Situação</th>
                        <th></th>
                    <?php endif; ?>

                </tr>
            </thead>
            <tbody>
            <?php $i=1;foreach($subscriptions as $s): $subscription_number=substr($s['subscription_number'],0,8); ?>
                <tr>
                    <td class="subscription__order"><?php echo $i++;?></td>
                    <td class="subscription__candidate"><a href="<?php echo site_url("inscricoes/$subscription_number");?>"><?php echo $s['candidate-name']; ?></a></td>
                    <td class="subscription__setorial"><?php echo $s['candidate-setorial']; ?></td>
                    <td class="subscription__company"><?php echo $s['company-name']; ?></td>
                    <td class="subscription__state"><?php echo get_state_name_by_id($s['candidate-state']); ?></td>
                    <td class="subscription__id"><span class="subscription_number"><?php echo $subscription_number;?></span></td>
                    <?php if(!current_user_can('administrator')): ?>
                        <td><?php $e = load_evaluation($s['pid'], $current_user->ID);

                               echo  sprintf('%d / %d / %d', isset($e['synopsis-score']) ? $e['synopsis-score'] : '',
                                                             isset($e['notes-score']) ? $e['notes-score'] : '',
                                                             isset($e['arguments-score']) ? $e['arguments-score'] : ''
                                            );?>
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
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

<?php get_footer(); ?>
