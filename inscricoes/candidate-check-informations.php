<?php 
/**
* 	Este template mostra todos os dados do candidato
*	ele é chamado no arquivo inscricoes-step3.php
**/

if( !$pid)
	return false;

$current_user_ID = get_current_user_id();

// verificar se o usuário atual tem privilégio para imprimir o documento.
if( $current_user_ID != $userID && !current_user_can('curate')) {
	// wp_redirect(site_url('inscricoes'));
	return false;	
}

	$avatar_file_id 	= get_post_meta($pid, 'candidate-avatar', true);
	$portfolio_file_id 	= get_post_meta($pid, 'candidate-portfolio', true);
	$activity_file_id 	= get_post_meta($pid, 'candidate-activity-history', true);
	$diploma_file_id 	= get_post_meta($pid, 'candidate-diploma', true);

	$step1 = load_step(1, $pid);
	$step2 = load_step(2, $pid);
	$f = array_merge($step1['fields'], $step2['fields']);

	$current_user_ID = get_current_user_id();
	$userID 		 = get_post_field( 'post_author', $pid );

	$user 			 = get_user_by( 'id', $userID);
	$user_meta 		 = array_map( function( $a ){ return $a[0]; }, get_user_meta( $userID ) );

 ?>

<div class="form-step-content">
	<fieldset>
		<div class="row">
			
			<div class="col-md-3 col-xs-12">
				<strong>Foto:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo wp_get_attachment_image($avatar_file_id, 'avatar_candidate'); ?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Nome:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo $user_meta['user_name'];?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Nome do candidato:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo isset( $f['candidate-display-name'] ) ? $f['candidate-display-name'] : "Não informado"; ?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Nascimento:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo restore_format_date( $user_meta['date_birth'] );?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>CPF:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo $user_meta['cpf'];?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Setorial:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo get_label_setorial_by_slug($user_meta['setorial']); ?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Estado:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo $user_meta['UF']; ?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>E-mail:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo $user->user_email;?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Telefone 1:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo $f['candidate-phone-1'];?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Afro-brasileiro:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo( $f['candidate-race'] == 'true') ? 'Sim' : 'Não';?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Sexo:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo ucfirst($f['candidate-genre']);?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Breve experiência no setor:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo $f['candidate-experience'];?>
			</div>

			<div class="col-md-3 col-xs-12">
				<strong>Exposição de motivos para a candidatura:</strong>
			</div>
			<div class="col-md-9 col-xs-12">
				<?php echo $f['candidate-explanatory'];?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-xs-12"> 
				<strong>Currículo e/ou Portfólio:</strong>
			</div>
			<div class="col-md-9 col-xs-12 file">
				<?php if( $portfolio_file_id ) : ?>
					<?php  $filename = clear_pdf_file_name( $portfolio_file_id ); ?>
					<?php echo wp_get_attachment_link($portfolio_file_id,'','','',$filename );?>
				<?php else : ?>
					Não enviado
				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-xs-12"> 
				<strong>Histórico de atividades realizadas no setor e/ou descrição da atuação profissional autônoma:</strong>
			</div>
			<div class="col-md-9 col-xs-12 file">
				<?php if( $activity_file_id  ) : ?>
					<?php  $filename = clear_pdf_file_name( $activity_file_id ); ?>
					<?php echo wp_get_attachment_link( $activity_file_id,'','','',$filename );?>
				<?php else : ?>
					Não enviado
				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-xs-12"> 
				<strong>Diploma Profissional e/ou Registro profissional:</strong>
			</div>
			<div class="col-md-9 col-xs-12 file">
				<?php if( $diploma_file_id ) : ?>
					<?php  $filename = clear_pdf_file_name( $diploma_file_id ); ?>
					<?php echo wp_get_attachment_link($diploma_file_id,'','','',$filename );?>
				<?php else : ?>
					Não enviado
				<?php endif; ?>
				
			</div>

		</div>		

	</fieldset>

</div>
<!-- #formstep-1 -->