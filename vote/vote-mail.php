<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title>Inscrição efetuada com sucesso</title>
	<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/stylesheets/print.css" />
</head>
<body>
	<h1>Eleições CNPC - 2015</h1>

	<div>
      <p><?php printf( "Olá %s da Setorial %s / %s.", ucwords(strtolower($user->user_name)), $setorial, $uf ); ?></p>
        <p>Confirmamos seu voto no candidato <strong></strong>.</p>
	</div>
      
	<p>Atenciosamente,</p>
	<p>Equipe Conselho Nacional de Políticas Culturais</p>
</body>
</html>