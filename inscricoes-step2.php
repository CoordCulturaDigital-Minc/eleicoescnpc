<div class="form-step-content">
	<fieldset>
		<div class="row">
			<div class="grid__item col-xs-12">
				<legend>Anexos</legend>
			</div>

			<div class="grid__item col-xs-12">
				<?php inscricoes_file_upload_field_template($f, 2, 'Currículo e/ou Portfólio (obrigatório)', 'candidate-portfolio', 'Faça Upload, em um único PDF, do currículo e/ou portfólio'); ?>
            </div><!--

			--><div class="grid__item col-xs-12">
            	<?php inscricoes_file_upload_field_template($f, 2, 'Histórico de atividades realizadas no setor e/ou descrição da atuação profissional autônoma', 'candidate-activity-history', 'Faça Upload, em um único PDF, do histórico de atividades realizadas no setor e/ou descrição da atuação profissional autônoma'); ?>
            </div><!--

			--><div class="grid__item col-xs-12">
            	 <?php inscricoes_file_upload_field_template($f, 2, 'Diploma Profissional e/ou Registro profissional', 'candidate-diploma', 'Faça Upload, em um único PDF, do diploma profissional ou certificado de profissionalização'); ?>
            </div>


			<div class="grid__item col-xs-12">
				<legend>Declaração</legend>
			</div>

			<div class="col-xs-12">
            	<label for="candidate-confirm-data"> 
					<input<?php echo $form_disabled?' disabled':'';?> id="candidate-confirm-data" type="checkbox" name="step2-candidate-confirm-data" value="true" <?php if( isset($f['candidate-confirm-data']) ) echo 'checked="checked"';?>/>
					Não ocupo cargo comissionado nos poderes executivo, legislativo ou judiciário na administração pública federal, estadual, municipal ou distrital.</label>
				<div class="field-status <?php print isset($f['candidate-confirm-data'])?'completo':'invalido'?>"></div>
				<div id="candidate-confirm-data-error" class="field__error"></div>
            </div>
        </div> <!-- row -->

        <br><br>

        <?php //if ( !$step2['complete'] ) : ?>
		<p class="step__advance alignleft">
			<a class="button" href="<?php print "?step=step-1"; ?>">Voltar para etapa anterior</a>
		</p>
		<p class="step__advance alignright">
			Depois de preencher os campos obrigatórios, você pode <a class="button" href="<?php print "?step=step-3"; ?>">Avançar para a próxima etapa</a>
		</p>
		<div class="prepend-1 form-error"></div>

		<div class="form__item--inline">

				<p id="submit-button" class="button">Inscrever candidatura</p>
				
			</div>
	<?php //endif; ?>

	</fieldset>
	
</div>
<!-- .form-step-content -->
