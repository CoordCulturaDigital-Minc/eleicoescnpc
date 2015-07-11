<div class="form-step-content">
	<div class="grid__item one-whole">

		<?php if( $subscription_number ) : ?>
			<p id="protocol-number">
				&mdash; Inscrição Número &mdash;
				<strong id="js-protocol-number"><?php echo substr($subscription_number, 0, 8);?></strong>
			</p>

			<div class="step__about">
				<?php echo nl2br( get_theme_option( 'txt_candidato_step4' ) ); ?>
			</div>

			<?php if( current_user_can( 'administrator' ) ): ?>
				<div class="form__item--inline">
					<input id="subscription-valid" type="checkbox" name="subscription-valid" id="subscription-valid" value="<?php echo $subscription_number;?>"<?php if(get_post_meta($pid, 'subscription-valid', true)) echo ' checked="checked"';?>/>
					<label for="subscription-valid">Admins: Marcar como Válida <a href="<?php bloginfo('siteurl'); ?>/inscricoes">(e voltar para lista de inscritos)</a></label>
				</div>
			<?php endif; ?>
		<?php elseif(get_theme_option('inscricoes_abertas')): ?>
			<p class="step-text  notice">
				<?php echo nl2br(get_theme_option('txt_candidato_step3')); ?>
			</p>

			<p id="submit-button" class="enabled  button">Inscrever meu projeto</p>
		<?php else: ?>
			<div class="form__item--inline">

				<p id="submit-button" class="button">Inscrever meu projeto</p>
				
			</div>
		<?php endif; ?>

	</div>
</div>
