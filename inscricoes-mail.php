<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title>Inscrição efetuada com sucesso</title>
	<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/stylesheets/print.css" />
</head>
<body>
	<h1>Eleições CNPC - 2015</h1>

	<?php if(get_theme_option('txt_mail_candidato')): ?>
	<p><?php echo get_theme_option('txt_mail_candidato');?></p>
<?php endif;?>

<?php

$userID = get_post_field( 'post_author', $pid );
$user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $userID ) );
$user = get_user_by( 'id', $userID);

$avatar_file_id 	= get_post_meta($pid, 'candidate-avatar', true);
$portfolio_file_id 	= get_post_meta($pid, 'candidate-portfolio', true);
$activity_file_id 	= get_post_meta($pid, 'candidate-activity-history', true);
$diploma_file_id 	= get_post_meta($pid, 'candidate-diploma', true);

 ?>
	<h3>Pré-Candidato</h3>
	<ul>
		<li><strong>Nome</strong>: <?php echo $user_meta['user_name'];?></li>
		<?php if(isset($f['candidate-display-name'])): ?>
			<li><strong>Nome Artístico</strong>: <?php echo $f['candidate-display-name'];?></li>
		<?php endif;?>
		<li><strong>Nascimento</strong>: <?php echo restore_format_date( $user_meta['date_birth'] );?></li>
		<li><strong>CPF</strong>: <?php echo $user_meta['cpf'];?></li>
		<li><strong>Setorial</strong>: <?php echo $user_meta['setorial']; ?></li>
		<li><strong>Estado</strong>: <?php echo $user_meta['UF']; ?></li>
		<li><strong>E-mail</strong>: <?php echo $user->user_email;?></li>
		<li><strong>Telefone 1</strong>: <?php echo $f['candidate-phone-1'];?></li>
		<li><strong>Afrodescendente</strong>: <?php echo( $f['candidate-race'] == 'true') ? 'Sim' : 'Não';?></li>
		<li><strong>Sexo</strong>: <?php echo $f['candidate-genre'];?></li>
		<li><strong>Breve experiência no setor</strong>: <?php echo $f['candidate-experience'];?></li>
		<li><strong>Exposição de motivos para a candidatura</strong>: <?php echo $f['candidate-explanatory'];?></li>
	</ul>

	<h3>Anexos</h3>
	<ul>
		<li><strong>Currículo e/ou Portfólio</strong>: <?php echo wp_get_attachment_link($portfolio_file_id 	);?></li>
		<li><strong>Histórico de atividades realizadas no setor e/ou descrição da atuação profissional autônoma</strong>: <?php echo wp_get_attachment_link($activity_file_id );?></li>
		<li><strong>Diploma Profissional e/ou Registro profissional</strong>: <?php echo wp_get_attachment_link($diploma_file_id );?></li>
	</ul>
</body>
</html>
