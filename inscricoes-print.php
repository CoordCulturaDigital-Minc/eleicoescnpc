<?php

$subscription_number = get_query_var('subscription_number');
$pid = get_project_id_from_subscription_number($subscription_number);

if($pid) {
	

	$step1 = load_step(1, $pid);
	$step2 = load_step(2, $pid);

	$f = array_merge($step1['fields'], $step2['fields']);
} else {
	wp_redirect(site_url('inscricoes'));
	exit;
}

 

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title>Inscrição efetuada com sucesso</title>
	<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/print.css" />
	<script type="text/javascript">window.onload=function(){window.print();};</script>
</head>
<body>
	<h1>Fóruns Setorias - CNPC</h1>
	<h2>O número da inscrição é <span><?php echo $subscription_number;?></span></h2>
	<h3>Pré-Candidato</h3>
	<ul>
		<li><strong>Nome</strong>: <?php echo $f['candidate-name'];?></li>

		<?php if(isset($f['candidate-display-name'])): ?>
			<li><strong>Nome Artístico</strong>: <?php echo $f['candidate-display-name'];?></li>
		<?php endif;?>
		<li><strong>Nascimento</strong>: <?php echo $f['candidate-date-birth'];?></li>
		<li><strong>CPF</strong>: <?php echo $f['candidate-cpf'];?></li>
		<li><strong>SNIIC</strong>: <?php echo $f['candidate-sniic']; ?></li>
		<li><strong>Região</strong>: <?php echo $f['candidate-region'];?></li>
		<li><strong>Estado</strong>: <?php echo get_state_name_by_id($f['candidate-state']); ?></li>
		<li><strong>E-mail</strong>: <?php echo $f['candidate-email'];?></li>
		<li><strong>Telefone 1</strong>: <?php echo $f['candidate-phone-1'];?></li>
		<li><strong>Setorial</strong>: <?php echo $f['candidate-setorial'];?></li>
	</ul>

</body>
<html>
