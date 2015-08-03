
<div class="form-step-content">
	<fieldset>
		<div class="row">
			<div class="col-md-12 col-xs-12 grid__item">
				<h2>
					<?php printf("Olá %s, vamos completar sua inscrição?", user_short_name( $user_meta['first_name'] ) )?>
				</h2>
			</div>
			
			<div class="col-md-3 col-xs-12 grid__item avatar">
				<?php inscricoes_file_upload_field_template($f, 1, '', 'candidate-avatar', '','Envie sua foto',true); ?>
			</div>

			<div class="col-md-9 col-xs-12">
				<div class="col-md-12 col-xs-12 grid__item form__item--inline">
	            	
	            	<input<?php echo $form_disabled?' disabled':'';?> id="candidate-confirm-infos" type="checkbox" class="required" name="step1-candidate-confirm-infos" value="true" <?php if( isset($f['candidate-confirm-infos']) ) echo 'checked="checked"';?>/>
					<label for="candidate-confirm-infos">Declaro que todas as informações são verdadeiras <span>(Obrigatório)</span></label>
					<div class="field-status <?php print isset($f['candidate-confirm-infos'])?'completo':'invalido'?>"></div>

					<div id="candidate-confirm-infos-error" class="field__error"></div>
	            </div><!--

				--><div class="col-md-12 col-xs-12 grid__item">
					<label for="candidate-display-name">Nome Artístico</label>
					<input<?php echo $form_disabled?' disabled':'';?> id="candidate-display-name" type="text" name="step1-candidate-display-name" value="<?php echo isset($f['candidate-display-name'])?$f['candidate-display-name']:'';?>" />
					<div class="field-status <?php print isset($f['candidate-display-name'])?'completo':'invalido'?>"></div>
					<div id="candidate-display-name-error" class="field__error"></div>
				</div><!--

				--><div class="col-md-12 col-xs-12 grid__item">
					<label for="candidate-phone-1">Telefone</label>
					<input<?php echo $form_disabled?' disabled':'';?> id="candidate-phone-1" class="phone required" type="text" name="step1-candidate-phone-1" value="<?php echo isset($f['candidate-phone-1'])?$f['candidate-phone-1']:'';?>" />
					<div class="field-status <?php print isset($f['candidate-phone-1'])?'completo':'invalido'?>"></div>
					<div id="candidate-phone-1-error" class="field__error"></div>
				</div><!--

				--><div class="col-md-3 col-xs-5 grid__item">
					<label for="candidate-genre">Sexo</label>
				</div>
				<div class="col-md-7 col-xs-7 grid__item">
					<?php $candidate_genre = isset($f['candidate-genre'])?$f['candidate-genre']:'' ?>
					<label for="genre_f"><input <?php echo $form_disabled?' disabled':'';?> id="genre_f" type="radio" class="required" name="step1-candidate-genre" value="feminino" <?php checked( $candidate_genre, 'feminino' ); ?>  />Feminino
					</label>
					<label class="col-sm-offset-2" for="genre_m"><input <?php echo $form_disabled?' disabled':'';?> id="genre_m" type="radio" name="step1-candidate-genre" value="masculino" <?php checked( $candidate_genre, 'masculino' ); ?>  />Masculino
					</label>
					<div class="field-status <?php print isset($f['candiate-genre'])?'completo':'invalido'?>"></div>
					<div id="candidate-genre-error" class="field__error"></div>
				</div><!--

				--><div class="col-md-3 col-xs-5 grid__item">
					<label>Afrobrasileiro</label>
				</div>
				<div class="col-md-7 col-xs-7 grid__item">
					<?php $candidate_race = isset(  $f['candidate-race'] ) ?  $f['candidate-race'] : ''; ?>
					<input <?php echo $form_disabled?' disabled':'';?> id="race-true" type="radio" name="step1-candidate-race" value="true" <?php checked( $candidate_race, 'true' ); ?>  />
					<label for="race-true">Sim</label>
					<span class="col-sm-offset-3">
					<input <?php echo $form_disabled?' disabled':'';?> id="race-false" type="radio" name="step1-candidate-race" class="required" value="false" <?php checked( $candidate_race, 'false' ); ?>  />
					<label for="race-false">Não</label>
					<div class="field-status <?php print isset($f['candidate-race'])?'completo':'invalido'?>"></div>
					<div id="candidate-race-error" class="field__error"></div>
				</div>
			</div><!--

			--><div class="grid__item  col-md-12 col-xs-12">
				<label for="candidate-experience">Breve experiência no setor <span class="form-tip">(400 caracteres restantes)</span></label>
				<textarea <?php echo $form_disabled?' disabled':'';?> id="candidate-experience" name="step1-candidate-experience" cols="50" rows="3" maxlength="400" class="required"><?php echo isset($f['candidate-experience'])?$f['candidate-experience']:'';?></textarea>
				<div class="field-status <?php print isset($f['candidate-experience'])?'completo':'invalido'?>"></div>
				<div id="candidate-experience-error" class="field__error"></div>
				<div class="field__note">Até 400 caracteres.</div>
			</div><!--

			--><div class="grid__item  col-md-12 col-xs-12">
				<label for="candidate-explanatory">Exposição de motivos para a candidatura <span class="form-tip">(400 caracteres restantes)</span></label>
				<textarea <?php echo $form_disabled?' disabled':'';?> id="candidate-explanatory" name="step1-candidate-explanatory" cols="50" rows="3" maxlength="400" class="required"><?php echo isset($f['candidate-explanatory'])?$f['candidate-explanatory']:'';?></textarea>
				<div class="field-status <?php print isset($f['candidate-explanatory'])?'completo':'invalido'?>"></div>
				<div id="candidate-explanatory-error" class="field__error"></div>
				<div class="field__note">Até 400 caracteres.</div>
			</div>
		</div>		

	</fieldset>
	<span class="prepend-1 form-error error"></span>

	<?php// if ( !$step1['complete'] ) : ?>
		<p class="step__advance">
			Depois de preencher os campos obrigatórios, você pode <a class="button toggle disabled" href="?step=step-2">Avançar para a próxima etapa</a>
		</p>
		
	<?php //endif; ?>

</div>
<!-- #formstep-1 -->