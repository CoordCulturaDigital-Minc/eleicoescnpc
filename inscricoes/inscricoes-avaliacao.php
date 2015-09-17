<?php

/**
 * Aparece durante o período de avaliações para administradores e curadores.
 *
 * @package forunssetoriaiscnpc
 */

$eval = load_evaluation($pid, $reviewer); ?>

<div id="evaluation-area">
    <div class="evaluation__title"><button class="js-evaluation__toggle  evaluation__toggle"><?php _e( 'Evaluation Panel', 'historias' ); ?></button></div>
    <form action="<?php echo admin_url('admin-ajax.php');?>" method="post" id="evaluation-tabs">
        <input<?php echo $form_disabled?' disabled':'';?> type="hidden" name="action" value="evaluate_subscription"/>
        <input<?php echo $form_disabled?' disabled':'';?> type="hidden" name="subscription" value="<?php echo $subscription_number;?>"/>

        <ul>
            <li><a href="#evaluation-remarks">Avaliação</a></li>
        </ul>
        
        <?php if(!$form_disabled): ?>
            <button class="finish-eval  button" id="submit-button" type="submit"><?php _e( 'Finish Evaluation', 'historias' ); ?></button>
        <?php endif; ?>

        <div class="evaluation__tab" id="evaluation-remarks">
            <div class="evaluation__status">
                <div>Situação</div>
                <div class="status-box valid">
                    <label for="evaluation-status-valid">Habilitado</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="evaluation-status" id="evaluation-status-valid" value="valid"<?php echo isset($eval['evaluation-status']) && $eval['evaluation-status'] == 'valid' ? ' checked':'';?>/>
                </div>
                <div class="status-box invalid">
                    <label for="evaluation-status-invalid">Inabilitado</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="evaluation-status" id="evaluation-status-invalid" value="invalid"<?php echo isset($eval['evaluation-status']) && $eval['evaluation-status'] == 'invalid' ? ' checked':'';?>/>
                </div>
            </div>
            <div class="evaluation__comments">
                <label for="remarks-comment"><?php _e( 'Remarks', 'historias' ); ?></label>
                <textarea<?php echo $form_disabled?' disabled':'';?> name="remarks-comment" id="remarks-comment"><?php echo isset($eval["remarks-comment"]) ? $eval["remarks-comment"] : '';?></textarea>
            </div>
        </div>
    </form>
</div>
