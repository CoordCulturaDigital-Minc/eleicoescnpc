<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title>Inscrição efetuada com sucesso</title>
	<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/print.css" />
</head>
<body>
	<h1>Histórias Que Ficam - Fundação CSN</h1>
	<h2>O seu número de inscrição é <span><?php echo $subscription_number;?></span></h2>

	<?php if(get_theme_option('txt_mail_candidato')): ?>
	<p><?php echo get_theme_option('txt_mail_candidato');?></p>
<?php endif;?>

<h3>Diretor</h3>
<ul>
	<li><strong>Nome</strong>: <?php echo $f['director-name'];?></li>

	<?php if(isset($f['director-display-name'])): ?>
	<li><strong>Nome Artístico</strong>: <?php echo $f['director-display-name'];?></li>
<?php endif;?>
<li><strong>RG</strong>: <?php echo $f['director-rg'];?></li>
<li><strong>CPF</strong>: <?php echo $f['director-cpf'];?></li>
<li><strong>Região</strong>: <?php echo $f['director-region'];?></li>
<li><strong>Estado</strong>: <?php echo get_state_name_by_id($f['director-state']); ?></li>
<li><strong>Cidade</strong>: <?php echo get_city_name_by_id($f['director-city']); ?></li>
<li><strong>CEP</strong>: <?php echo $f['director-cep'];?></li>
<li><strong>Endereço</strong>: <?php echo $f['director-address'];?></li>
<li><strong>Número</strong>: <?php echo $f['director-number'];?></li>

<?php if(isset($f['director-complement'])): ?>
	<li><strong>Complemento</strong>: <?php echo $f['director-complement'];?></li>
<?php endif;?>
<li><strong>Bairro</strong>: <?php echo $f['director-neighborhood'];?></li>
<li><strong>E-mail</strong>: <?php echo $f['director-email'];?></li>
<li><strong>Telefone 1</strong>: <?php echo $f['director-phone-1'];?></li>

<?php if(isset($f['director-phone-2'])): ?>
	<li><strong>Telefone 2</strong>: <?php echo $f['director-phone-2'];?></li>
<?php endif;?>
</ul>

<h3>Produtora Proponente</h3>
<ul>
	<li><strong>Razão Social</strong>: <?php echo $f['company-name']; ?></li>

	<?php if(isset($f['company-display-name'])): ?>
	<li><strong>Nome fantasia</strong>: <?php echo $f['company-display-name']; ?></li>
<?php endif;?>
<li><strong>CNPJ</strong>: <?php echo $f['company-cnpj']; ?></li>
<li><strong>Região</strong>: <?php echo $f['company-region']; ?></li>
<li><strong>Estado</strong>: <?php echo get_state_name_by_id($f['company-state']); ?></li>
<li><strong>Cidade</strong>: <?php echo get_city_name_by_id($f['company-city']); ?></li>
<li><strong>CEP</strong>: <?php echo $f['company-cep']; ?></li>
<li><strong>Endereço</strong>: <?php echo $f['company-address']; ?></li>
<li><strong>Número</strong>: <?php echo $f['company-number']; ?></li>
<?php if(isset($f['company-complement'])): ?>
	<li><strong>Complemento</strong>: <?php echo $f['company-complement']; ?></li>
<?php endif;?>
<li><strong>Bairro</strong>: <?php echo $f['company-neighborhood']; ?></li>
<li><strong>Nome do produtor</strong>: <?php echo $f['company-productor-name']; ?></li>
<li><strong>E-mail</strong>: <?php echo $f['company-email']; ?></li>
<li><strong>Telefone 1</strong>: <?php echo $f['company-phone-1']; ?></li>

<?php if(isset($f['company-phone-2'])): ?>
	<li><strong>Telefone 2</strong>: <?php echo $f['company-phone-2']; ?></li>
<?php endif;?>
</ul>

<h3>Projeto</h3>
<ul>
	<li><strong>Título do Projeto</strong>: <?php echo $f['project-title']; ?></li>
	<li><strong>Sinopse do Projeto</strong>: <p><?php echo $f['project-synopsis']; ?></p></li>
	<li><strong>Notas de intenção do diretor</strong>: <p><?php echo $f['project-director-notes']; ?></p></li>
	<li><strong>Argumento resumido</strong>: <p><?php echo $f['project-argument']; ?></p></li>
</ul>

<h3>Orçamento Resumido</h3>
<ul>
	<li><strong>Pré-produção</strong>: <?php echo $f['budget-pre-production']; ?></li>
	<li><strong>Produção</strong>: <?php echo $f['budget-production']; ?></li>
	<li><strong>Pós-produção</strong>: <?php echo $f['budget-post-production']; ?></li>
	<li><strong>Total</strong>: <?php echo $f['budget-total']; ?></li>
</ul>
</body>
</html>
