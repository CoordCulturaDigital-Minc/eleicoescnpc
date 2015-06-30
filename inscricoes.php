<?php

/**
 * Esta é a página de inscrições do história que ficam e tem os seguintes
 * comportamentos:
 *
 * - Ela é um formulário editável quando o usuário logado tem função de 'subscriber'.
 * - É uma lista de inscrições quando o usuário tem a função de 'curador' ou 'administrator'.
 * - É um formulário não-editável quando o usuário tem a função de 'administrator' ou 'curador' e informa na url o número da inscrição que aparecerá no formulário.
 *
 * @package forunssetoriaiscnpc
 */

include('inscricoes-register.php');

if(!isset($errors)) {
	$errors = new WP_Error();
}

$form_disabled = true;
$disabled = ' disabled';
$subscription_number = get_query_var('subscription_number');

$reviewer = get_query_var('reviewer');
$reviewer = user_can($reviewer, 'curate') ? $reviewer : 0;

if(is_user_logged_in()) {
	global $current_user;

    if ($_GET['switch_project'] == 1) {
        switch_project_to_edit();
        wp_redirect(site_url('inscricoes'));
		exit;
    }

	if(current_user_can('curate')) {
		if($subscription_number) {
			$pid = get_project_id_from_subscription_number($subscription_number);
			$is_valid = $pid && get_post_meta($pid,'subscription-valid', true);

			if(!$pid) { // happens when subscription_number does not exist
				$errors->add('subscription_not_found', __('Inscrição não encontrada.'));
				include('lista-de-inscritos.php');
				exit;
			} else if( !($is_valid || current_user_can('administrator'))) { // only admin can access invalid subscriptions
				$errors->add('subscription_not_found', __('Esta inscrição foi marcada como inválida.'));
				include('lista-de-inscritos.php');
				exit;
			}

			if(current_user_can('administrator')) {
				wp_enqueue_script('admin-inscricoes', get_setoriaiscnpc_baseurl().'js/admin-inscricoes.js', array('jquery'));
				wp_localize_script('admin-inscricoes', 'inscricoes', array('ajaxurl' => admin_url('admin-ajax.php')));
			}

			if ($reviewer || !current_user_can('adminstrator')) {
				wp_enqueue_script('jquery-ui-custom', get_setoriaiscnpc_baseurl().'js/jquery-ui-1.8.14.custom.min.js', array('jquery'));
				wp_enqueue_script('curador-inscricoes', get_setoriaiscnpc_baseurl().'js/curador-inscricoes.js', array('jquery-ui-custom'));
			}
		} else {
			include('lista-de-inscritos.php');
			exit;
		}

	} elseif($subscription_number) {

		wp_redirect(site_url('inscricoes'));
		exit;

	} else {
        $pid = get_current_user_project();
		$subscription_number = get_post_meta($pid, 'subscription_number', true);



		if(get_theme_option('inscricoes_abertas') && empty($subscription_number)) {
			$form_disabled = false;
			$disabled = '';

			wp_enqueue_script('jquery-maskMoney', get_setoriaiscnpc_baseurl().'js/jquery.maskMoney.js', array('jquery'));              // só
			wp_enqueue_script('jquery-maskedinput', get_setoriaiscnpc_baseurl().'js/jquery.maskedinput-1.3.min.js', array('jquery'));  // funciona
			wp_enqueue_script('jquery-ui-custom', get_setoriaiscnpc_baseurl().'js/jquery-ui-1.8.14.custom.min.js', array('jquery'));   // nesta
			wp_enqueue_script('inscricoes', get_setoriaiscnpc_baseurl().'js/inscricoes.js', array('jquery','jquery-ui-custom'));       // ordem
			wp_enqueue_script('ajaxupload', get_setoriaiscnpc_baseurl().'js/min/ajaxupload.min.js', array('jquery'));
			wp_localize_script('inscricoes', 'inscricoes', array('ajaxurl' => admin_url('admin-ajax.php')));
		}
	}
} elseif($subscription_number) {

	wp_redirect(site_url('inscricoes'));
	exit;

} else {
	wp_enqueue_script('cadastro', get_setoriaiscnpc_baseurl().'js/cadastro.js', array('jquery'));
}

?>

<?php get_header(); ?>

<div class="content  content--sidebarless">

	<div class="hentry">
		<?php if (current_user_can('subscriber')): ?>
			<?php echo nl2br(get_theme_option('txt_candidato')); ?>
		<?php elseif (current_user_can('curador')): ?>
			<?php echo nl2br(get_theme_option('txt_curador')); ?>
		<?php elseif (current_user_can('administrator')): ?>
			<?php echo nl2br(get_theme_option('txt_admin')); ?>
		<?php else: ?>
			<?php echo nl2br(get_theme_option('txt_visitante')); ?>
		<?php endif; ?>
	</div>

	<section id="form-area">
		<?php if(!is_user_logged_in()) : ?>

			<?php if(get_theme_option('inscricoes_abertas')) : ?>
				<div id="cadastro" class="form-step">
					<header class="step__head">
						<h3 class="step__title">Cadastro</h3>
						<div class="step__about">
							<?php echo nl2br(get_theme_option('txt_candidato_step1')); ?> Se você já fez o cadastro, basta <a href="<?php echo wp_login_url( site_url( '/inscricoes/' )); ?>" title="Fazer login">fazer o login.</a>
						</div>
					</header>
					<form id="user-register" class="inline  form-application" method="post">
						<input type="hidden" name="register" value="1" />
						<?php if (is_array($register_errors) && sizeof($register_errors) > 0): ?>
							<div class='error'>
								<?php foreach ($register_errors as $e): ?>
									<?php echo $e; ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<div class="form-step-content">
							<div class="grid">
								<div class="grid__item  one-whole">
									<label for="user_email">Seu email</label>
									<input id="user_email" type="email" name="user_email" />
								</div><!--

								--><div class="grid__item  one-half">
									<label for="user_password">Senha</label>
									<input id="user_password" type="password" name="user_password" />
								</div><!--

								--><div class="grid__item  one-half">
									<label for="user_password_confirm">Confirme a senha</label>
									<input id="user_password_confirm" type="password" name="user_password_confirm" />
								</div><!--

								--><div class="grid__item  one-half">
									<label for="user_cpf">CPF</label>
									<input id="user_cpf" type="password" name="user_cpf" />
								</div><!--

								--><div class="grid__item  one-half"></br>
									<input type="checkbox" name="user_not_cpf" value="not_cpf"> Não tenho CPF, pretendo comprovar minha identidade de outra forma.<br>
								</div>
							</div>
							<input type="submit" id="submit" class="button" value="Cadastrar" />
						</div>
					</form>
				</div>
			<?php endif; ?>

			<!-- <div class="form-not-yet">	
				<h3 class="step__title">Etapa 2/3: Candidato</h3>
			</div>
			<div class="form-not-yet">
				<h3 class="step__title">Etapa 3/3: Conferir Dados e Inscrever</h3>
			</div> -->

		<?php else: // } user logged in { ?>
		<?php
				$step1 = load_step(1,$pid); $f = $step1['fields']; ?>

			<div class="form-controls  cf">
				<?php if($subscription_number): ?>
					<a href="<?php echo site_url("inscricoes/".substr($subscription_number,0,8)."/imprimir");?>" class="button  u-pull-right  print"><?php _e('Print', 'historias'); ?></a>
				<?php else: ?>
					<a id="print-button" class="button  u-pull-right  print" style="display: none"><?php _e('Print', 'historias'); ?></a>
				<?php endif; ?>

	            <?php if (!current_user_can('curador') && !current_user_can('administrador')): ?>
	            	<div class="project-switcher">
	                	Editando <strong>Projeto <?php echo get_current_project_number(); ?></strong> <!-- <a id="switch-projects" class="button" href="<?php echo site_url('inscricoes/?switch_project=1'); ?>"><?php _e('Switch Project', 'historias'); ?></a> -->
	            	</div>
	            <?php endif; ?>
            </div>

			<form id="application-form" class="form-application  inline" method="post">

                <?php if(get_theme_option('inscricoes_abertas') == false): ?>
					<div class="error">Inscrições encerradas!</div>
				<?php endif;?>
				<div id="formstep-1" class="form-step">
					<header class="step__head">
						<h3 class="step__title">Etapa 1/2: Candidato <?php if ($step1['complete']) : ?><i class="fa fa-check"></i><span class="assistive-text"><?php _e( 'Complete!', 'historias'); ?></span><?php endif; ?></h3>
						<div class="step__about">
							<?php echo nl2br( get_theme_option( 'txt_candidato_topo' ) ); ?>
						</div>
						<div class="step-status <?php print $step1['complete']?' completo':'';?>"></div>
					</header>

					<div class="form-step-content">

                        <fieldset>
							<legend>Sobre o Pré-candidato</legend>

							<div class="grid">
								<div class="grid__item  one-whole">
									<label for="candidate-name">Nome Completo</label>
									<input<?php echo $form_disabled?' disabled':'';?> id="candidate-name" class="required" type="text" name="step1-candidate-name" value="<?php echo isset($f['candidate-name'])?$f['candidate-name']:'';?>" />
									<div class="field-status <?php print isset($f['candidate-name'])?'completo':'invalido'?>"></div>
									<div id="candidate-name-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-whole">
									<label for="candidate-display-name">Nome Artístico</label>
									<input<?php echo $form_disabled?' disabled':'';?> id="candidate-display-name" type="text" name="step1-candidate-display-name" value="<?php echo isset($f['candidate-display-name'])?$f['candidate-display-name']:'';?>" />
									<div class="field-status"></div>
								</div><!--

								--><div class="grid__item  one-half">
									<label for="candidate-date-birth">Data Nascimento</label>
									<input<?php echo $form_disabled?' disabled':'';?> id="candidate-date-birth" class="required" type="text" name="step1-candidate-date-birth" value="<?php echo isset($f['candidate-date-birth'])?$f['candidate-date-birth']:'';?>" />
									<div class="field-status <?php print isset($f['candidate-date-birth'])?'completo':'invalido'?>"></div>
									<div id="candidate-date-birth-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-half">
									<label for="candidate-cpf">CPF</label>
									<input<?php echo $form_disabled?' disabled':'';?> id="candidate-cpf" class="required" type="text" name="step1-candidate-cpf" value="<?php echo isset($f['candidate-cpf'])?$f['candidate-cpf']:'';?>" />
									<div class="field-status <?php print isset($f['candidate-cpf'])?'completo':'invalido'?>"></div>
									<div id="candidate-cpf-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-half">
									<label for="candidate-sniic">Nº SNIIC</label>
									<input<?php echo $form_disabled?' disabled':'';?> id="candidate-sniic" class="required" type="text" name="step1-candidate-sniic" value="<?php echo isset($f['candidate-sniic'])?$f['candidate-sniic']:'';?>" />
									<div class="field-status <?php print isset($f['candidate-sniic'])?'completo':'invalido'?>"></div>
									<div id="candidate-sniic-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-half">
									<label for="candidate-phone-1">Telefone</label>
									<input<?php echo $form_disabled?' disabled':'';?> id="candidate-phone-1" class="phone required" type="text" name="step1-candidate-phone-1" value="<?php echo isset($f['candidate-phone-1'])?$f['candidate-phone-1']:'';?>" />
									<div class="field-status <?php print isset($f['candidate-phone-1'])?'completo':'invalido'?>"></div>
									<div id="candidate-phone-1-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item one-half">
									<label for="candidate-setorial">Setorial</label>
									<?php echo dropdown_setoriais( 'step1-candidate-setorial', $f['candidate-setorial'], true, 'id="candidate-setorial" class="required" ' . $disabled ); ?>
									<div class="field-status <?php print isset($f['candidate-setorial'])?'completo':'invalido'?>"></div>
									<div id="candidate-setorial-error" class="field__error"></div>
                                    <div class="field__note">Escolha o seu setorial de interesse/atuação</div>
								</div><!--

								--><div class="grid__item  one-third">
									<label for="candidate-state">Estado</label>
									<?php echo dropdown_states( 'step1-candidate-state', $f['candidate-state'], true, 'id="candidate-state" class="required" ' . $disabled ); ?>
									<div class="field-status <?php print isset($f['candidate-state'])?'completo':'invalido'?>"></div>
									<div id="candidate-state-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-whole">
									<label for="candidate-email">E-mail</label>
									<input<?php echo $form_disabled?' disabled':'';?> id="candidate-email" class="required" type="text" name="step1-candidate-email" value="<?php echo isset($f['candidate-email'])?$f['candidate-email']:'';?>" />
									<div class="field-status <?php print isset($f['candidate-email'])?'completo':'invalido'?>"></div>
									<div id="candidate-email-error" class="field__error"></div>
								</div>

								<div class="grid__item  one-whole">
									<label for="candidate-experience">Breve experiência no setor e exposição de motivos para a candidatura</label>
									<textarea <?php echo $form_disabled?' disabled':'';?> id="candidate-experience" name="step1-candidate-experience" cols="50" rows="5" maxlength="600" class="limit-chars"><?php echo isset($f['candidate-experience'])?$f['candidate-experience']:'';?></textarea>
									<div class="field-status <?php print isset($f['candidate-experience'])?'completo':'invalido'?>"></div>
									<div id="candidate-experience-error" class="field__error"></div>
									<div class="field__note">Até 600 caracteres. Deve-se elencar, ....</div>
								</div>

								<?php inscricoes_file_upload_field_template($f, 1, 'Currículo e/ou Portfólio', 'candidate-portfolio', 'Faça Upload, em um único PDF, do currículo e/ou portfólio'); ?>
                                <?php inscricoes_file_upload_field_template($f, 1, 'Histórico de atividades', 'candidate-activity-history', 'Faça Upload, em um único PDF, do histórico de atividades realizadas no setor e/ou descrição da atuação profissional autônoma'); ?>
                                <?php inscricoes_file_upload_field_template($f, 1, 'Diploma Profissional', 'candidate-diploma', 'Faça Upload, em um único PDF, do diploma profissional ou certificado de profissionalização'); ?>
                                <?php inscricoes_file_upload_field_template($f, 1, 'Registro Profissional', 'candidate-profissional-register', 'Faça Upload, em um único PDF, do registro profissional no Ministério do Trabalho (DRT).'); ?>
                                <?php inscricoes_file_upload_field_template($f, 1, 'Declaração de participação', 'candidate-participation-statement', 'Faça Upload, em um único PDF, da declaração de participação ou reconhecimento de atuação emitida por entidade/comunidade representativa da área ou segmento.'); ?>

							</div>
						</fieldset>
						<?php if ( !$step1['complete'] ) : ?>
							<p class="step__advance">
								Depois de preencher todos os dados, você pode <a class="button" href="">Avançar para a próxima etapa</a>
							</p>
						<?php endif; ?>
					</div>
				</div>

				<?php if( $step1['complete'] ) : ?>
					<div id="formstep-3" class="form-step">
						<header class="step__head">
							<h3 class="step__title">Etapa 2/2: Conferir Dados e Inscrever <?php if ($step3['complete']) : ?><i class="fa fa-check"></i><span class="assistive-text"><?php _e( 'Complete!', 'historias'); ?></span><?php endif; ?></h3>
							<div class="step-status <?php print ($subscription_number)?' completo':'';?>"></div>
							<div <?php echo ($step1['complete'] )?' style="display:none"':''; ?> class="step__about">
								<?php echo nl2br(get_theme_option('txt_candidato_step3a')); ?>
							</div>
							<span id="formstep-3-error" class="form-error"></span>
						</header>
						<?php include( 'inscricoes-step3.php' ); ?>
					</div>
				<?php else : ?>
					<div class="form-not-yet">
						<h3 class="step__title">Etapa 3/3: Conferir Dados e Inscrever</h3>
					</div>
				<?php endif; ?>
			</form>
		<?php endif; ?>
	</section>
</div>

<?php get_footer(); ?>

<?php
	if(current_user_can('curate')) {
		if(current_user_can('administrator')){
			$form_disabled = true;
			$disabled = ' disabled';
			if(!$reviewer) {
				die;
			}
			include('inscricoes-avaliacao.php');
		} else {
			$form_disabled = get_theme_option('avaliacoes_abertas') != '1';
			if( $form_disabled == true )
				$disabled = ' disabled';

			$reviewer = $current_user->ID;
			include('inscricoes-avaliacao.php');
		}
	}
?>
