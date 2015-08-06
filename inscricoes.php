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

// arquivo que salva as informações do cadastro inicial
include( get_template_directory() . '/inscricoes/inscricoes-register.php');

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

	if(current_user_can('curate')) {
		if($subscription_number) {
			$pid = get_project_id_from_subscription_number($subscription_number);
			$is_valid = $pid && get_post_meta($pid,'subscription-valid', true);

			if(!$pid) { // happens when subscription_number does not exist
				$errors->add('subscription_not_found', __('Inscrição não encontrada.'));
				include( get_template_directory() . '/inscricoes/lista-de-inscritos.php');
				exit;
			} else if( !($is_valid || current_user_can('administrator'))) { // only admin can access invalid subscriptions
				$errors->add('subscription_not_found', __('Esta inscrição foi marcada como inválida.'));
				include( get_template_directory() . '/inscricoes/lista-de-inscritos.php');
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
			include( get_template_directory() . '/inscricoes/lista-de-inscritos.php');
			exit;
		}

	} elseif($subscription_number) {

		wp_redirect(site_url('inscricoes'));
		exit;

	} else {
        $pid = get_current_user_project(); // pega o id do projeto, se não existir salva
		$subscription_number = get_post_meta($pid, 'subscription_number', true);



		if(get_theme_option('inscricoes_abertas') && empty($subscription_number)) {
			$form_disabled = false;
			$disabled = '';
			
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
	 wp_enqueue_script( 'responsive-nav', get_template_directory_uri() . '/js/responsive-nav.min.js', array( 'jquery' ), '1.0.32', true );
	wp_enqueue_script('jquery-maskedinput', get_setoriaiscnpc_baseurl().'js/jquery.maskedinput-1.3.min.js', array('jquery'));  // funciona
	wp_enqueue_script('cadastro', get_setoriaiscnpc_baseurl().'js/cadastro.js', array('jquery'));
	wp_localize_script('cadastro', 'cadastro', array('ajaxurl' => admin_url('admin-ajax.php'), 'today' => date('Y-m-d') ));
	wp_enqueue_script( 'setoriaiscnpc', get_template_directory_uri() . '/js/setoriaiscnpc.js');
}

?>

<?php get_header(); ?>

<section id="form-area" class="col-xs-12">
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

	
	<?php if(!is_user_logged_in()) : // template de cadastro inicial ?>

		<?php if(get_theme_option('inscricoes_abertas')) : ?>
			<div id="cadastro" class="form-step">
				<div class="step__head">
					<h2 class="step__title">Inscrição</h2>
					<div class="step__about">
						<?php echo nl2br(get_theme_option('txt_visitante')); ?>
					</div>
				</div>

				<?php include( get_template_directory() . '/inscricoes/inscricoes-register-form.php' ); ?>
			</div>
		<?php endif; ?>

	<?php else: // } user logged in { ?>
		<?php 
		
		if( empty( $subscription_number ) )
	 		$userID = $current_user->ID; 
		else 
			$userID = get_post_field( 'post_author', $pid );

		// Validar se usuário é delegado nato e se possui data de nascimento válida

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
			echo "<div class='error'>Atenção! Você não pode se candidatar!<br/>";

			if( isset( $register_errors['birth'] ) )
				echo $register_errors['birth'] . "<br/>";

			if( isset( $register_errors['cpf'] ) )
				echo $register_errors['cpf'] . "<br/>"; ?>
			<?php echo "</div>" ?>
		
		<?php else : // Data nascimento válida e não é delegado ?>

			<?php if ( current_user_voter( $userID ) ) : // verifica se o usuário é eleitor, se for, perguntar se quer se candidatar?>

				<div class="form-eleitor">
					<div class="candidate-not-found">
						<i class="fa fa-question"></i>
						<p>Você já está inscrito(a) mas não é candidato(a)<br>
						Deseja se candidatar?</p>
						<a href="<?php echo get_link_forum_user(); ?>" id="return_forum" class="button secondary">Não quero me candidatar</a>
						<a href="#" id="eleitor-candidate-question" class="button primary">Candidatar</a>
					</div>
				</div>

			<?php endif; ?>

			<?php $step1 = load_step(1,$pid); $f = $step1['fields']; ?>

			<div class="form-candidato" style="<?php echo ( current_user_voter($userID) )? 'display: none' : '' ?>">
				<div class="form-controls  cf">
					<?php if($subscription_number): ?>
						<a href="<?php echo site_url("inscricoes/".substr($subscription_number,0,8)."/imprimir");?>" target="_blank" class="button  u-pull-right  print"><?php _e('Print', 'historias'); ?></a>
					
						<?php if( current_user_can( 'administrator' ) ): ?>
							<div class="form__item--inline">
								<input id="subscription-valid" type="checkbox" name="subscription-valid" id="subscription-valid" value="<?php echo $subscription_number;?>"<?php if(get_post_meta($pid, 'subscription-valid', true)) echo ' checked="checked"';?>/>
								<label for="subscription-valid">Admins: Marcar como Válida <a href="<?php bloginfo('url'); ?>/inscricoes">(e voltar para lista de inscritos)</a></label>
							</div>
							<input type="hidden" id="js-protocol-number" value="<?php echo substr($subscription_number, 0, 8);?>" />
							
						<?php endif; ?>
					<?php else: ?>
						<a id="print-button" class="button  u-pull-right  print" style="display: none"><?php _e('Print', 'historias'); ?></a>
					<?php endif; ?>
		        </div>

				<form id="application-form" class="form-application  inline" method="post">

		            <?php if(get_theme_option('inscricoes_abertas') == false): ?>
						<div class="error">Inscrições encerradas!</div>
					<?php endif;?>

					<?php if( ( $step == 'step-1' || $step == '' ) && empty( $subscription_number ) ) : ?>
						<div id="formstep-1" class="form-step">
							<header class="step__head">
								<h3 class="step__title">Candidato(a) <?php if ($step1['complete']) : ?><i class="fa fa-check"></i><span class="assistive-text"><?php _e( 'Complete!', 'historias'); ?></span><?php endif; ?></h3>
								<div class="step__about">
									<?php echo nl2br( get_theme_option( 'txt_candidato_step1' ) ); ?>
								</div>
								<div class="step-status <?php print $step1['complete']?' completo':'';?>"></div>
							</header>
							<?php include( get_template_directory() . '/inscricoes/candidate-step1.php' ); ?>

						</div><!-- #formstep-1 -->
					<?php endif; ?>

					<?php $step2 = load_step(2,$pid); $f = $step2['fields']; ?>

					<?php if( $step1['complete'] && $step == 'step-2' && empty( $subscription_number ) ) : ?>

						<div id="formstep-2" class="form-step">
							<header class="step__head">
								<h3 class="step__title">Candidato(a) <?php if ($step2['complete']) : ?><i class="fa fa-check"></i><span class="assistive-text"><?php _e( 'Complete!', 'historias'); ?></span><?php endif; ?></h3>
								<div class="step-status <?php print ($subscription_number)?' completo':'';?>"></div>
								<div class="step__about">
									<?php echo nl2br(get_theme_option('txt_candidato_step2')); ?>
								</div>
								<span id="formstep-2-error" class="form-error"></span>
							</header>

							<?php include( get_template_directory() . '/inscricoes/candidate-step2.php' ); ?>

						</div><!-- #formstep-2 -->
					<?php elseif( $step == 'step-2' ): ?>
						
						<div class="candidate-not-found">
							<i class="fa fa-exclamation"></i>
							<p>Você não preencheu a etapa anterior corretamente!<br>
							Volte, verifique os campos e tente novamente</p>
							<a href="?step=step-1" class="button">Voltar</a>
						</div>

					<?php endif; ?>


					<?php if( $step1['complete'] && $step2['complete'] && ( $step == 'step-3' || !empty( $subscription_number ) ) ) : ?>
						
						<div id="formstep-3" class="form-step">
							<header class="step__head">
								<?php if ( empty( $subscription_number ) ) : ?>
									<h3 class="step__title">Conferir dados e finalizar inscrição </h3>
								<?php else: ?>
									<h3 class="step__title">Informações da candidatura <i class="fa fa-check"></i></h3>
								<?php endif; ?>

								<div class="step-status <?php print ($subscription_number)?' completo':'';?>"></div>
								<div class="step__about">
									<?php echo nl2br(get_theme_option('txt_candidato_step3a')); ?>
								</div>
								<span id="formstep-3-error" class="form-error"></span>
							</header>
							<?php include( get_template_directory() . '/inscricoes/candidate-step3.php' ); ?>
						</div><!-- #formstep-3 -->

					<?php elseif( $step == 'step-3' ): ?>
						<div class="candidate-not-found">
							<i class="fa fa-exclamation"></i>
							<p>Você não preencheu a etapa anterior corretamente!<br>
							Volte, verifique os campos e tente novamente</p>
							<a href="?step=step-2" class="button">Voltar</a>
						</div>
					<?php endif; ?>
					<?php if ( empty( $subscription_number ) ) : ?>
						<?php show_steps( $step ); ?>
					<?php endif; ?>
				</form>
			</div><!-- .form-candidato -->
			
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
			include(get_template_directory() . '/inscricoes/inscricoes-avaliacao.php');
		} else {
			$form_disabled = get_theme_option('avaliacoes_abertas') != '1';
			if( $form_disabled == true )
				$disabled = ' disabled';

			$reviewer = $current_user->ID;
			include(get_template_directory() . '/inscricoes/inscricoes-avaliacao.php');
		}
	}
?>
