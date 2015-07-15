<div class="form-step-content">
	<fieldset>
		<div class="grid">
			<div class="grid__item  one-whole">
				<label for="candidate-experience">Breve experiência no setor <span class="form-tip">(400 caracteres restantes)</span></label>
				<textarea <?php echo $form_disabled?' disabled':'';?> id="candidate-experience" name="step2-candidate-experience" cols="50" rows="5" maxlength="400" class="required"><?php echo isset($f['candidate-experience'])?$f['candidate-experience']:'';?></textarea>
				<div class="field-status <?php print isset($f['candidate-experience'])?'completo':'invalido'?>"></div>
				<div id="candidate-experience-error" class="field__error"></div>
				<div class="field__note">Até 400 caracteres.</div>
			</div><!--

			--><div class="grid__item  one-whole">
				<label for="candidate-explanatory">Exposição de motivos para a candidatura <span class="form-tip">(400 caracteres restantes)</span></label>
				<textarea <?php echo $form_disabled?' disabled':'';?> id="candidate-explanatory" name="step2-candidate-explanatory" cols="50" rows="5" maxlength="400" class="required"><?php echo isset($f['candidate-explanatory'])?$f['candidate-explanatory']:'';?></textarea>
				<div class="field-status <?php print isset($f['candidate-explanatory'])?'completo':'invalido'?>"></div>
				<div id="candidate-explanatory-error" class="field__error"></div>
				<div class="field__note">Até 400 caracteres.</div>
			</div>

			<div class="grid__item  one-whole">
				<label for="candidate-confirm-data"> 
					<input<?php echo $form_disabled?' disabled':'';?> id="candidate-confirm-data" type="checkbox" name="step2-candidate-confirm-data" value="true" <?php if( isset($f['candidate-confirm-data']) ) echo 'checked="checked"';?>/>
					Não ocupo cargo comissionado nos poderes executivo, legislativo ou judiciário na administração pública federal, estadual, municipal ou distrital.</label>
				<div class="field-status <?php print isset($f['candidate-confirm-data'])?'completo':'invalido'?>"></div>
				<div id="candidate-confirm-data-error" class="field__error"></div>
			</div>	
		</div>
	</fieldset>
	<?php if ( !$step2['complete'] ) : ?>
		<p class="step__advance">
			Depois de preencher todos os dados, você pode <a class="button" href="">Avançar para a próxima etapa</a>
		</p>
	<?php endif; ?>
</div>
<!-- .form-step-content -->
