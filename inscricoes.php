<?php

/**
 * Esta é a página de inscrições dos candidatos e eleitores e tem os seguintes
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

	$step = isset( $_REQUEST[ 'step' ] ) ? $_REQUEST[ 'step' ] : 'step-1';

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
			
			// wp_enqueue_script('jquery-maskMoney', get_setoriaiscnpc_baseurl().'js/jquery.maskMoney.js', array('jquery'));              // só
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
	wp_enqueue_script('jquery-maskedinput', get_setoriaiscnpc_baseurl().'js/jquery.maskedinput-1.3.min.js', array('jquery'));  // funciona
	wp_enqueue_script('cadastro', get_setoriaiscnpc_baseurl().'js/cadastro.js', array('jquery'));
	wp_localize_script('cadastro', 'cadastro', array('ajaxurl' => admin_url('admin-ajax.php'), 'today' => date('Y-m-d') ));
}

?>

<?php get_header(); ?>

<section id="form-area" class="content  content--sidebarless" >
	<?php if(is_user_logged_in()) : ?>
		<div class="hentry">
			<?php if (current_user_can('subscriber')): ?>
				<?php echo nl2br(get_theme_option('txt_candidato')); ?>
			<?php elseif (current_user_can('curador')): ?>
				<?php echo nl2br(get_theme_option('txt_curador')); ?>
			<?php elseif (current_user_can('administrator')): ?>
				<?php echo nl2br(get_theme_option('txt_admin')); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	
	<?php if(!is_user_logged_in()) : ?>

		<?php if(get_theme_option('inscricoes_abertas')) : ?>
			<div id="cadastro" class="form-step">
				<div class="step__head">
					<h2 class="step__title">Inscrições</h2>
					<div class="step__about">
						<?php echo nl2br(get_theme_option('txt_visitante')); ?>
					</div>
					<div class="step__count">
						<!-- <span class='step_1 active'>Etapa 1</span>
						<span class='step_2'>Etapa 2</span>
						<span class='step_3'>Etapa 3</span> -->
						<!-- <span class='step_4'>Etapa 4</span> -->
					</div>
				</div>

				<form id="user-register" class="inline  form-application" method="post">
					<input type="hidden" name="register" value="1" />
					<?php if (is_array($register_errors) && sizeof($register_errors) > 0): ?>
						<div class='errors'>
							<p class="aligncenter">Ops! Alguns erros na sua inscrição</p>
							<?php foreach ($register_errors as $e): ?>
								<div class="error"><?php echo $e; ?></div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<div class="form-step-content">
						<div class="grid">
							<span id="register-error" class="form-error hidden"></span>
							<div id="step-1-register">
								<div class="grid__item  one-whole">

									<input id="tipo_eleitor" class="user_type hidden" type="radio" name="user_tipo" value="eleitor" />
									<label for="tipo_eleitor">Sou Eleitor/a</label>
									
									<input id="tipo_candidato" class="user_type hidden" type="radio" name="user_tipo" value="candidato" />
									<label for="tipo_candidato">Sou Candidato/a</label>

								</div>
								<p class="step__footer">Se você já se inscreveu, basta <a href="<?php echo wp_login_url( site_url( '/inscricoes/' )); ?>" title="Fazer login">fazer o login.</a></p>
							</div>
							
							<div id="step-2-register">
								<div class="grid__item  one-whole">
									<?php include('includes/mapa.php'); ?>
								</div>
								
								<div id="step-2-dropdown">
									<div class="grid__item  one-half">
										<label for="user_UF">UF</label>
										<?php echo dropdown_states('user_UF','', true); ?>
									</div><!--

									--><div class="grid__item  one-half">
										<label for="user_setorial">Setorial</label>
										<?php echo dropdown_setoriais('user_setorial','', true); ?>
									</div>
								</div>	
							</div>

							<div id="step-3-register">
								<div class="grid__item  one-half">
									<label for="user_cpf">CPF</label>
									<input id="user_cpf" type="text" name="user_cpf" />
									<div id="user_cpf-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-whole">
									<label for="user_name">Nome</label>
									<input id="user_name" type="text" name="user_name" />
								</div><!--

								--><div class="grid__item  one-whole">
									<label for="user_email">Seu email</label>
									<input id="user_email" type="email" name="user_email" />
									<div id="user_email-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-half">
									<label for="user_password">Senha</label>
									<input id="user_password" type="password" name="user_password" />
									<div id="user_password-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-half">
									<label for="user_password_confirm">Confirme a senha</label>
									<input id="user_password_confirm" type="password" name="user_password_confirm" />
									<div id="user_password_confirm-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-half">
									<label for="user_birth">Data Nascimento</label>
									<input id="user_birth" type="text" name="user_birth" />
									<div id="user_birth-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-half"><br>
									<input id="user_confirm_informations" type="checkbox" name="user_confirm_informations" />
									<label for="user_confirm_informations">Afirmo que todos os dados citados acima são verdadeiros.</label>
									<div id="user_confirm_informations-error" class="field__error"></div>
								</div>
							</div>
						</div>
						<input type="submit" id="submit" class="button" value="Cadastrar" />

					</div>
				</form>
			</div>
		<?php endif; ?>

	<?php else: // } user logged in { ?>
		<?php 

		if( empty( $subscription_number ) )
	 		$userID = $current_user->ID; 
		else 
			$userID = get_post_field( 'post_author', $pid );

		$user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $userID ) );

		$valida_user = new Validator();

		$user_birth = restore_format_date( $user_meta['date_birth'] );
		$user_cpf = $user_meta['cpf'];

        if( !empty( $user_birth ) ) {

			$valid_birth = $valida_user->validate_field( 'extra', 'user_birth', $user_birth, 'candidato');
            
            if( $valid_birth !== true ) {
            	$register_errors['birth'] = $valid_birth;
            }
		} 

		if( !empty( $user_cpf ) ) {
			$valid_cpf = $valida_user->validate_field( 'extra', 'user_cpf', $user_cpf);

			 if( $valid_cpf !== true ) {
            	$register_errors['cpf'] = $valid_cpf; 
            }
		}

		if( $valid_cpf !== true || $valid_birth !== true ) : ?>
		<?php
			echo "<div class='error'>Atenção! Você não pode se canidatar!<br/>";

			if( isset( $register_errors['birth'] ) )
				echo $register_errors['birth'] . "<br/>";

			if( isset( $register_errors['cpf'] ) )
				echo $register_errors['cpf'] . "<br/>"; ?>
			<?php echo "</div>" ?>
		<?php else : // Data nascimento válida e não é delegado ?>

			<?php $step1 = load_step(1,$pid); $f = $step1['fields']; ?>

			<div class="form-controls  cf">
				<?php if($subscription_number): ?>
					<a href="<?php echo site_url("inscricoes/".substr($subscription_number,0,8)."/imprimir");?>" target="_blank" class="button  u-pull-right  print"><?php _e('Print', 'historias'); ?></a>
				
					<?php if( current_user_can( 'administrator' ) ): ?>
						<div class="form__item--inline">
							<input id="subscription-valid" type="checkbox" name="subscription-valid" id="subscription-valid" value="<?php echo $subscription_number;?>"<?php if(get_post_meta($pid, 'subscription-valid', true)) echo ' checked="checked"';?>/>
							<label for="subscription-valid">Admins: Marcar como Válida <a href="<?php bloginfo('siteurl'); ?>/inscricoes">(e voltar para lista de inscritos)</a></label>
						</div>
					<?php endif; ?>
				<?php else: ?>
					<a id="print-button" class="button  u-pull-right  print" style="display: none"><?php _e('Print', 'historias'); ?></a>
				<?php endif; ?>
	        </div>

			<form id="application-form" class="form-application  inline" method="post">

	            <?php if(get_theme_option('inscricoes_abertas') == false): ?>
					<div class="error">Inscrições encerradas!</div>
				<?php endif;?>

				<?php if( $step == 'step-1' || $step == '' ) : ?>
					<div id="formstep-1" class="form-step">
						<header class="step__head">
							<h3 class="step__title">Candidato <?php if ($step1['complete']) : ?><i class="fa fa-check"></i><span class="assistive-text"><?php _e( 'Complete!', 'historias'); ?></span><?php endif; ?></h3>
							<div class="step__about">
								<?php echo nl2br( get_theme_option( 'txt_candidato_topo' ) ); ?>
							</div>
							<div class="step-status <?php print $step1['complete']?' completo':'';?>"></div>
						</header>
						<?php include( 'inscricoes-step1.php' ); ?>
					</div><!-- #formstep-1 -->
				<?php endif; ?>

				<?php $step2 = load_step(2,$pid); $f = $step2['fields']; ?>

				<?php if( $step1['complete'] && $step == 'step-2') : ?>

					<div id="formstep-2" class="form-step">
						<header class="step__head">
							<h3 class="step__title">Candidato <?php if ($step2['complete']) : ?><i class="fa fa-check"></i><span class="assistive-text"><?php _e( 'Complete!', 'historias'); ?></span><?php endif; ?></h3>
							<div class="step-status <?php print ($subscription_number)?' completo':'';?>"></div>
							<div <?php echo ($step1['complete'] )?' style="display:none"':''; ?> class="step__about">
								<?php echo nl2br(get_theme_option('txt_candidato_step2')); ?>
							</div>
							<span id="formstep-2-error" class="form-error"></span>
						</header>

						<?php include( 'inscricoes-step2.php' ); ?>

					</div><!-- #formstep-2 -->
				<?php endif; ?>


				<?php if( $step1['complete'] && $step2['complete'] && $step == 'step-3' ) : ?>
					
					<div id="formstep-3" class="form-step">
						<header class="step__head">
							<h3 class="step__title">Conferir Dados e Finalizar Inscrição <?php if ( $subscription_number ) : ?><i class="fa fa-check"></i><span class="assistive-text"><?php _e( 'Complete!', 'historias'); ?></span><?php endif; ?></h3>
							<div class="step-status <?php print ($subscription_number)?' completo':'';?>"></div>
							<div <?php echo ($step1['complete'] )?' style="display:none"':''; ?> class="step__about">
								<?php echo nl2br(get_theme_option('txt_candidato_step3a')); ?>
							</div>
							<span id="formstep-3-error" class="form-error"></span>
						</header>
						<?php include( 'inscricoes-step3.php' ); ?>
					</div><!-- #formstep-3 -->

				<?php endif; ?>

				<?php show_steps( $step ); ?>
			</form>

			<div class="form-controls  cf">
				<?php if($subscription_number): ?>
					<a href="<?php echo site_url("inscricoes/".substr($subscription_number,0,8)."/imprimir");?>" target="_blank" class="button  u-pull-right  print"><?php _e('Print', 'historias'); ?></a>
				
					<?php if( current_user_can( 'administrator' ) ): ?>
						<div class="form__item--inline">
							<input id="subscription-valid" type="checkbox" name="subscription-valid" id="subscription-valid" value="<?php echo $subscription_number;?>"<?php if(get_post_meta($pid, 'subscription-valid', true)) echo ' checked="checked"';?>/>
							<label for="subscription-valid">Admins: Marcar como Válida <a href="<?php bloginfo('siteurl'); ?>/inscricoes">(e voltar para lista de inscritos)</a></label>
						</div>
					<?php endif; ?>
				<?php else: ?>
					<a id="print-button" class="button  u-pull-right  print" style="display: none"><?php _e('Print', 'historias'); ?></a>
				<?php endif; ?>
	        </div>
	    <?php endif; ?>
	<?php endif; ?>
</section>


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
