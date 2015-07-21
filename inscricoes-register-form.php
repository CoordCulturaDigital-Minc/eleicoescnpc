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
									<?php $user_tipo = isset($_POST['user_tipo']) ? $_POST['user_tipo'] : '' ?>

									<input id="tipo_eleitor" class="user_type hidden" type="radio" name="user_tipo" value="eleitor" <?php checked( $user_tipo, 'eleitor' ); ?> />
									<label for="tipo_eleitor">Sou Eleitor/a</label>
									
									<input id="tipo_candidato" class="user_type hidden" type="radio" name="user_tipo" value="candidato" <?php checked( $user_tipo, 'candidato' ); ?>/>
									<label for="tipo_candidato">Sou Candidato/a</label>

								</div>
								<p class="step__footer">Se você já se inscreveu, basta <a href="<?php echo wp_login_url( site_url( '/inscricoes/' )); ?>" title="Fazer login">fazer o login.</a></p>
							</div>
							
							<div id="step-2-register">
								<h2>Selecione seu estado e setorial</h2>
								<div class="grid__item  one-whole">
									<?php include('includes/mapa.php'); ?>
								</div>
								
								<div id="step-2-dropdown">
									<div class="grid__item  one-half">
										<label for="user_UF">UF</label>
										<?php $user_UF = isset($_POST['user_UF']) ? $_POST['user_UF'] : '' ?>
										<?php echo dropdown_states('user_UF', $user_UF, true); ?>
									</div><!--

									--><div class="grid__item  one-half">
										<label for="user_setorial">Setorial</label>
										<?php $user_setorial = isset($_POST['user_setorial']) ?  $_POST['user_setorial'] : '' ?>
										<?php echo dropdown_setoriais('user_setorial', $user_setorial, true); ?>
									</div>
								</div>	
							</div>

							<div id="step-3-register">
								<div class="grid__item  one-half">
									<label for="user_cpf">CPF</label>
									<input id="user_cpf" type="text" name="user_cpf" value="<?php echo isset($_POST['user_cpf']) ?  $_POST['user_cpf'] : '' ?>" />
									<div id="user_cpf-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-whole">
									<label for="user_name">Nome</label>
									<input id="user_name" type="text" name="user_name" value="<?php echo isset($_POST['user_name']) ?  $_POST['user_name'] : '' ?>"/>
								</div><!--

								--><div class="grid__item  one-whole">
									<label for="user_email">Seu email</label>
									<input id="user_email" type="email" name="user_email" value="<?php echo isset($_POST['user_email']) ?  $_POST['user_email'] : '' ?>" />
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
									<input id="user_birth" type="text" name="user_birth" value="<?php echo isset($_POST['user_birth']) ?  $_POST['user_birth'] : '' ?>" />
									<div id="user_birth-error" class="field__error"></div>
								</div><!--

								--><div class="grid__item  one-half"><br>
									<input id="user_confirm_informations" type="checkbox" name="user_confirm_informations" />
									<label for="user_confirm_informations">Afirmo que todos os dados citados acima são verdadeiros.</label>
									<div id="user_confirm_informations-error" class="field__error"></div>
								</div>
							</div>
						</div>
						<input type="submit" id="submit" class="button" value="Inscrever" />

					</div>
				</form>