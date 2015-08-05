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
		<div class="row">
			<span id="register-error" class="form-error hidden"></span>
			<div id="step-1-register">

				<div id="terms" class="grid__item  col-md-12 col-xs-12">
					<div class="term">
						<?php $terms_of_use = isset( $_POST['terms_of_use'] ) ? $_POST['terms_of_use'] : '' ?>
						<input id="terms_of_use" class="" type="checkbox" name="terms_of_use" value="concordo" <?php checked( $terms_of_use, 'concordo' ); ?> />
						<label for="terms_of_use"></label>
					</div>
					<label class="terms_label" for="terms_of_use">Eu concordo com os <a href="<?php echo site_url('/termos-de-uso/'); ?> " target="_blank">termos de uso</a> das eleições</label>
				</div>

				<div id="user_type" class="grid__item  col-md-12 col-xs-12">
					<?php $user_tipo = isset($_POST['user_tipo']) ? $_POST['user_tipo'] : '' ?>

					<input id="tipo_eleitor" class="user_type hidden" type="radio" name="user_tipo" value="eleitor" <?php checked( $user_tipo, 'eleitor' ); ?> />
					<label for="tipo_eleitor">Sou Eleitor(a)</label>
					
					<input id="tipo_candidato" class="user_type hidden" type="radio" name="user_tipo" value="candidato" <?php checked( $user_tipo, 'candidato' ); ?>/>
					<label for="tipo_candidato">Sou Candidato(a)</label>

				</div>
				<!-- <p class="step__footer">Se você já se inscreveu, basta <a href="<?php echo wp_login_url( site_url( '/inscricoes/' )); ?>" title="Fazer login">fazer o login.</a></p> -->
			</div>
			
			<div id="step-2-register">
				<h2>Selecione seu estado e setorial</h2>
				<div class="grid__item  col-md-12 col-xs-12 hidden-xs">
					<?php include( get_template_directory() . '/includes/mapa.php'); ?>
				</div>
				
				<div id="step-2-dropdown" class="visible-xs-block">
					<div class="grid__item col-xs-2">
						<label for="user_UF">UF</label>
					</div>
					<div class="grid__item col-xs-10">
						<?php $user_UF = isset($_POST['user_UF']) ? $_POST['user_UF'] : '' ?>
						<?php echo dropdown_states('user_UF', $user_UF, true); ?>
					</div><!--

					--><div class="grid__item col-xs-2">
						<label for="user_setorial">Setorial</label>
					</div>
					<div class="grid__item col-xs-10">
						<?php $user_setorial = isset($_POST['user_setorial']) ?  $_POST['user_setorial'] : '' ?>
						<?php echo dropdown_setoriais('user_setorial', $user_setorial, true); ?>
					</div>
				</div>	
			</div>

			<div id="step-3-register">
				<div class="grid__item  col-md-6 col-xs-12">
					<label for="user_cpf">CPF</label>
					<input id="user_cpf" type="text" name="user_cpf" value="<?php echo isset($_POST['user_cpf']) ?  $_POST['user_cpf'] : '' ?>" />
					<div id="user_cpf-error" class="field__error"></div>

				</div><!--

				--><div class="grid__item  col-md-12 col-xs-12">
					<label for="user_name">Nome</label><div class="field__note" >Seu nome será preenchido automaticamente com dados da Receita Federal, conforme <a href="<?php echo site_url('/termos-de-uso/'); ?> " target="_blank">Termos de Uso</a></div>
					<input id="user_name" type="text" name="user_name" value="<?php echo isset($_POST['user_name']) ?  $_POST['user_name'] : '' ?>" readonly/>
				</div><!--

				--><div class="grid__item  col-md-12 col-xs-12">
					<label for="user_email">Seu e-mail</label>
					<input id="user_email" type="email" name="user_email" value="<?php echo isset($_POST['user_email']) ?  $_POST['user_email'] : '' ?>" />
					<div id="user_email-error" class="field__error"></div>
				</div><!--

				--><div class="grid__item  col-md-6 col-xs-12">
					<label for="user_password">Senha</label>
					<span class="field__note"> Sua senha deve ter no mínimo 6 caracteres</span>
					<input id="user_password" type="password" name="user_password" />
					<div id="user_password-error" class="field__error"></div>

				</div><!--

				--><div class="grid__item  col-md-6 col-xs-12">
					<label for="user_password_confirm">Confirme a senha</label>
					<input id="user_password_confirm" type="password" name="user_password_confirm" />
					<div id="user_password_confirm-error" class="field__error"></div>
				</div><!--

				--><div class="grid__item  col-md-6 col-xs-12">
					<label for="user_birth">Data de Nascimento</label>
					<input id="user_birth" type="text" name="user_birth" value="<?php echo isset($_POST['user_birth']) ?  $_POST['user_birth'] : '' ?>" />
					<div id="user_birth-error" class="field__error"></div>
				</div><!--

				--><div class="grid__item  col-md-6 col-xs-12 form__item--inline"><br>
					<?php $user_confirm_informations = isset($_POST['user_confirm_informations']) ? $_POST['user_confirm_informations'] : '' ?>
					<input id="user_confirm_informations" type="checkbox" name="user_confirm_informations" value="afirmo" <?php checked( $user_confirm_informations, 'afirmo' ); ?> />
					<label for="user_confirm_informations">Afirmo que todos os dados citados acima são verdadeiros.</label>
					<div id="user_confirm_informations-error" class="field__error"></div>
				</div>
			</div>
		</div>
		<input type="submit" id="submit" class="button" value="Inscrever" />

	</div>
</form>