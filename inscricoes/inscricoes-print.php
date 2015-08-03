<?php


$subscription_number = get_query_var('subscription_number');
$pid = get_project_id_from_subscription_number($subscription_number);

if($pid) {
	
	$current_user_ID = get_current_user_id();
	$userID 		 = get_post_field( 'post_author', $pid );

	$user 			 = get_user_by( 'id', $userID);
	$user_meta 		 = array_map( function( $a ){ return $a[0]; }, get_user_meta( $userID ) );

	// verificar se o usuário atual tem privilégio para imprimir o documento.
	if( $current_user_ID != $userID && !current_user_can('administrator')) {
		wp_redirect(site_url('inscricoes'));
		exit;	
	}

	$step1 = load_step(1, $pid);
	$step2 = load_step(2, $pid);
	$f = array_merge($step1['fields'], $step2['fields']);


} else {
	wp_redirect(site_url('inscricoes'));
	exit;
}

	$avatar_file_id 	= get_post_meta($pid, 'candidate-avatar', true);
	$portfolio_file_id 	= get_post_meta($pid, 'candidate-portfolio', true);
	$activity_file_id 	= get_post_meta($pid, 'candidate-activity-history', true);
	$diploma_file_id 	= get_post_meta($pid, 'candidate-diploma', true);


?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title>Inscrição efetuada com sucesso</title>
	<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/stylesheets/print.css" />
	<script type="text/javascript">window.onload=function(){window.print();};</script>
</head>
<body>
	<h1>Fóruns Setoriais - CNPC</h1>
	<div>
		<?php if(isset($f['candidate-display-name'])): ?>
			<?php $name = $f['candidate-display-name']; ?>
		<?php else: ?>
			<?php $name = user_short_name($user_meta['user_name']); ?>
		<?php endif; ?>
		
		<p><?php printf( "Olá %s! Da Setorial %s do %s.", $name, get_label_setorial_by_slug( $user_meta['setorial']), $user_meta['UF'] ); ?></p>

		<p>Confirmamos sua pré candidatura nas eleições de 2015 do Conselho Nacional de Políticas Culturais (CNPC).</p>
		<p>Em breve sua inscrição será validada pela Comissão Eleitoral. Enquanto isso, participe no  <a href="<?php echo site_url('foruns/' . $user_meta['uf-setorial']); ?>">fórum de debate.</a><p> 
		<p>Confira seus dados a seguir.</p>
	</div>

	<h3>Foto</h3>
		<?php echo wp_get_attachment_image($avatar_file_id, 'avatar_candidate'); ?>
	<h3>Pré-Candidato</h3>
	<ul>
		<li><strong>Nome</strong>: <?php echo $user_meta['user_name'];?></li>
		<?php if(isset($f['candidate-display-name'])): ?>
			<li><strong>Nome Artístico</strong>: <?php echo $f['candidate-display-name'];?></li>
		<?php endif;?>
		<li><strong>Nascimento</strong>: <?php echo restore_format_date( $user_meta['date_birth'] );?></li>
		<li><strong>CPF</strong>: <?php echo $user_meta['cpf'];?></li>
		<li><strong>Setorial</strong>: <?php echo get_label_setorial_by_slug( $user_meta['setorial']); ?></li>
		<li><strong>Estado</strong>: <?php echo $user_meta['UF']; ?></li>
		<li><strong>E-mail</strong>: <?php echo $user->user_email;?></li>
		<li><strong>Telefone 1</strong>: <?php echo $f['candidate-phone-1'];?></li>
		<li><strong>Afrobrasileiro</strong>: <?php echo( $f['candidate-race'] == 'true') ? 'Sim' : 'Não';?></li>
		<li><strong>Sexo</strong>: <?php echo ucfirst($f['candidate-genre']);?></li>
		<li><strong>Breve experiência no setor</strong>: <?php echo $f['candidate-experience'];?></li>
		<li><strong>Exposição de motivos para a candidatura</strong>: <?php echo $f['candidate-explanatory'];?></li>
	</ul>

	<h3>Anexos</h3>
	<ul>
		<?php if( $portfolio_file_id ) : ?>
			<li><strong>Currículo e/ou Portfólio</strong>: <?php echo wp_get_attachment_link($portfolio_file_id );?></li>
		<?php endif; ?>

		<?php if( $activity_file_id ) : ?>
			<li><strong>Histórico de atividades realizadas no setor e/ou descrição da atuação profissional autônoma</strong>: <?php echo wp_get_attachment_link($activity_file_id );?></li>
		<?php endif; ?>

		<?php if( $diploma_file_id ) : ?>
			<li><strong>Diploma Profissional e/ou Registro profissional</strong>: <?php echo wp_get_attachment_link($diploma_file_id );?></li>
		<?php endif; ?>
	</ul>
	<p>Atenciosamente,</p>
	<p>Equipe Conselho Nacional de Políticas Culturais</p>
</body>
<html>
