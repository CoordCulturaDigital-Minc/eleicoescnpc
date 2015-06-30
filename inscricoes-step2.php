<div class="form-step-content">
	<fieldset>
		<legend>Informações sobre o Projeto</legend>

		<div class="grid">
			<div class="grid__item  one-whole">
				<label for="project-title">Título do Projeto</label>
				<input<?php echo $form_disabled?' disabled':'';?> id="project-title" class="required" type="text" name="step2-project-title" value="<?php echo isset($f['project-title'])?$f['project-title']:'';?>" />
				<div class="field-status <?php print isset($f['project-title'])?'completo':'invalido'?>"></div>
				<div id="project-title-error" class="field__error"></div>
			</div><!--

			--><div class="grid__item  one-whole">
				<label for="project-synopsis">Sinopse do Projeto <span class="form-tip">(500 caracteres restantes)</span></label>
				<textarea<?php echo $form_disabled?' disabled':'';?> id="project-synopsis" class="required" name="step2-project-synopsis"><?php echo isset($f['project-synopsis'])?$f['project-synopsis']:'';?></textarea>
				<div class="field-status <?php print isset($f['project-synopsis'])?'completo':'invalido'?>"></div>
				<div id="project-synopsis-error" class="field__error"></div>
                <div class="field__note">Até 500 caracteres</div>
			</div><!--

			--><div class="grid__item  one-whole">
				<label for="project-argument">Argumento <span class="form-tip">(8000 caracteres restantes)</span></label>
				<textarea<?php echo $form_disabled?' disabled':'';?> id="project-argument" class="required" name="step2-project-argument"><?php echo isset($f['project-argument'])?$f['project-argument']:'';?></textarea>
				<div class="field-status <?php print isset($f['project-argument'])?'completo':'invalido'?>"></div>
				<div id="project-argument-error" class="field__error"></div>
				<div class="field__note">Até 8000 caracteres. Deve incluir a visão original e estratégia de abordagem</div>
			</div><!--

			--><div class="grid__item  one-whole">
				<label for="project-director-notes">Notas de intenção  do(a/os/as) diretor(a/es/as) <span class="form-tip">(3000 caracteres restantes)</span></label>
				<textarea<?php echo $form_disabled?' disabled':'';?> id="project-director-notes" class="required" name="step2-project-director-notes"><?php echo isset($f['project-director-notes'])?$f['project-director-notes']:'';?></textarea>
				<div class="field-status <?php print isset($f['project-director-notes'])?'completo':'invalido'?>"></div>
				<div id="project-director-notes-error" class="field__error"></div>
				<div class="field__note">Até 3000 caracteres. Deve-se elencar, pelo ponto de vista do(a/os/as) diretor(a/es/as), os motivos para a realização do projeto</div>
			</div><!--

			--><div class="grid__item  one-whole">
				<label for="project-producer-notes">Notas de intenção  do(a/os/as) produtor(a/es/as) <span class="form-tip">(3000 caracteres restantes)</span></label>
				<textarea<?php echo $form_disabled?' disabled':'';?> id="project-producer-notes" class="required" name="step2-project-producer-notes"><?php echo isset($f['project-producer-notes'])?$f['project-producer-notes']:'';?></textarea>
				<div class="field-status <?php print isset($f['project-producer-notes'])?'completo':'invalido'?>"></div>
				<div id="project-producer-notes-error" class="field__error"></div>
				<div class="field__note">Até 3000 caracteres. Deve-se elencar, pelo ponto de vista do(a/os/as) produtor(a/es/as), os motivos para a realização do projeto</div>
			</div><!--

			--><div class="grid__item  one-whole">
				<label for="project-writer-notes">Notas de intenção  do(a/os/as) roteirista(a/as) <span class="form-tip">(3000 caracteres restantes)</span></label>
				<textarea<?php echo $form_disabled?' disabled':'';?> id="project-writer-notes" class="required" name="step2-project-writer-notes"><?php echo isset($f['project-writer-notes'])?$f['project-writer-notes']:'';?></textarea>
				<div class="field-status <?php print isset($f['project-writer-notes'])?'completo':'invalido'?>"></div>
				<div id="project-writer-notes-error" class="field__error"></div>
				<div class="field__note">Até 3000 caracteres. Deve-se elencar, pelo ponto de vista do(a/os/as) roteirista(a/as), os motivos para a realização do projeto</div>
			</div><!--

			--><div class="grid__item  one-whole">
				<label for="project-researchlink">Material de Pesquisa já gravado</label>
				
                <?php if ($form_disabled): ?>
                    <p><?php echo isset($f['project-researchlink'])?$f['project-researchlink']:'';?></p><hr/>
                <?php else: ?>
                    <input<?php echo $form_disabled?' disabled':'';?> id="project-researchlink" class="required" type="text" name="step2-project-researchlink" value="<?php echo isset($f['project-researchlink'])?$f['project-researchlink']:'';?>" />
                <?php endif; ?>
				<div class="field-status <?php print isset($f['project-researchlink'])?'completo':'invalido'?>"></div>
				<div id="project-researchlink-error" class="field__error"></div>
                <div class="field__note">Disponibilizar, se houver, link para material de pesquisa já gravado do Projeto, teaser, compilação de entrevistas etc. com no máximo 5 (cinco) minutos de duração cada</div>
			</div>

            <?php inscricoes_file_upload_field_template($f, 2, 'Currículos', 'project-curriculums', 'Disponibilizar, em um único arquivo PDF, currículo do(a/os/as) diretor(a/es/as) e produtor(a/es/as) '); ?>

            <!--

			--><div class="grid__item  one-whole">
				<label for="project-directorlink">Portfolio diretor(a/es/as)</label>
				
                <?php if ($form_disabled): ?>
                    <p><?php echo isset($f['project-directorlink'])?$f['project-directorlink']:'';?></p><hr/>
                <?php else: ?>
                    <input<?php echo $form_disabled?' disabled':'';?> id="project-directorlink" class="required" type="text" name="step2-project-directorlink" value="<?php echo isset($f['project-directorlink'])?$f['project-directorlink']:'';?>" />
                <?php endif; ?>
				<div class="field-status <?php print isset($f['project-directorlink'])?'completo':'invalido'?>"></div>
				<div id="project-directorlink-error" class="field__error"></div>
                <div class="field__note">disponibilizar link para o portfólio do(a/os/as) diretor(a/es/as). Máximo 5 (cinco) minutos de duração cada.</div>
			</div><!--

			--><div class="grid__item  one-whole">
				<label for="project-companylink">Portfolio produtor(a/es/as)</label>
				
                <?php if ($form_disabled): ?>
                    <p><?php echo isset($f['project-companylink'])?$f['project-companylink']:'';?></p><hr/>
                <?php else: ?>
                    <input<?php echo $form_disabled?' disabled':'';?> id="project-companylink" class="required" type="text" name="step2-project-companylink" value="<?php echo isset($f['project-companylink'])?$f['project-companylink']:'';?>" />
                <?php endif; ?>
				<div class="field-status <?php print isset($f['project-companylink'])?'completo':'invalido'?>"></div>
				<div id="project-companylink-error" class="field__error"></div>
                <div class="field__note">disponibilizar link para o portfólio da produtora Proponente. Máximo 5 (cinco) minutos de duração cada.</div>
			</div>

		</div>
	</fieldset>

	<fieldset>
		<legend>Orçamento Resumido</legend>

		<div class="grid">

			<div class="grid__item  one-third">
				<label for="budget-pre-production">Pré-produção</label>
				<input<?php echo $form_disabled?' disabled':'';?> id="budget-pre-production" class="required budget" type="text" name="step2-budget-pre-production" value="<?php echo isset($f['budget-pre-production'])?$f['budget-pre-production']:'';?>" />
				<div class="field-status <?php print isset($f['budget-pre-production'])?'completo':'invalido'?>"></div>
				<div id="budget-pre-production-error" class="field__error"></div>
			</div><!--

			--><div class="grid__item  one-third">
				<label for="budget-production">Produção</label>
				<input<?php echo $form_disabled?' disabled':'';?> id="budget-production" class="required budget" type="text" name="step2-budget-production" value="<?php echo isset($f['budget-production'])?$f['budget-production']:'';?>" />
				<div class="field-status <?php print isset($f['budget-production'])?'completo':'invalido'?>"></div>
				<div id="budget-production-error" class="field__error"></div>
			</div><!--

			--><div class="grid__item  one-third">
				<label for="budget-post-production">Pós-produção</label>
				<input<?php echo $form_disabled?' disabled':'';?> id="budget-post-production" class="required budget" type="text" name="step2-budget-post-production" value="<?php echo isset($f['budget-post-production'])?$f['budget-post-production']:'';?>" />
				<div class="field-status <?php print isset($f['budget-post-production'])?'completo':'invalido'?>"></div>
				<div id="budget-post-production-error" class="field__error"></div>
			</div><!--

			--><div class="grid__item  one-whole">
				<label for="budget-total">Total</label>
				<input<?php echo $form_disabled?' disabled':'';?> id="budget-total" class="budget" type="text" name="step2-budget-total" value="<?php echo isset($f['budget-total'])?$f['budget-total']:'';?>" />
				<div class="field-status <?php print isset($f['budget-total'])?'completo':''?>"></div>
				<div id="budget-total-error" class="field__error"></div>
				<div class="field__note">O total é um campo de cálculo automático (não editável).</div>
			</div>
		</div>
	</fieldset>

    <fieldset>
		<legend>Orçamento Completo e cronograma</legend>

		<div class="grid">
			<div class="grid__item one-whole">
				<div class="field__note">&rarr; Utilize <a href="<?php echo get_theme_option('link_modelo_orcamento'); ?>">nosso arquivo modelo</a> para compor o <strong>Orçamento Completo</strong> do seu projeto. Depois de preenchido, faça o upload em PDF.</div>
			</div>

            <?php inscricoes_file_upload_field_template($f, 2, 'Orçamento Completo', 'budget-complete'); ?>

            <?php inscricoes_file_upload_field_template($f, 2, 'Plano de realização', 'project-plan', 'Anexar em um único PDF, o plano de realização com cronograma das atividades, respeitando-se o prazo de execução e as etapas de consultoria conforme cronograma disponível no site do Programa Histórias que Ficam'); ?>
		</div>
	</fieldset>

</div>
<!-- .form-step-content -->
