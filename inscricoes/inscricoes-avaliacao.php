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
            <li><a href="#evaluation-budget"><?php _e( 'Budget', 'historias' ); ?></a></li>
            <li><a href="#evaluation-synopsis"><?php _e( 'Merit', 'historias' ); ?></a></li>
            <li><a href="#evaluation-notes"><?php _e( 'Viability', 'historias' ); ?></a></li>
            <li><a href="#evaluation-arguments"><?php _e( 'Qualification', 'historias' ); ?></a></li>
            <li><a href="#evaluation-remarks"><?php _e( 'Remarks', 'historias' ); ?></a></li>
        </ul>
        
        <?php if(!$form_disabled): ?>
            <button class="finish-eval  button" id="submit-button" type="submit"><?php _e( 'Finish Evaluation', 'historias' ); ?></button>
        <?php endif; ?>

        <div class="evaluation__tab" id="evaluation-budget">
            <div class="evaluation__comments">
                <label for="budget-comment"><?php _e( 'Comments on the Budget', 'historias' ); ?></label>
                <textarea<?php echo $form_disabled?' disabled':'';?> name="budget-comment" id="budget-comment"><?php echo isset($eval["budget-comment"]) ? $eval["budget-comment"] : '';?></textarea>
            </div>
        </div>

        <div class="evaluation__tab" id="evaluation-synopsis">
            <div class="evaluation__score">
                <div><?php _e( 'Merit Score', 'historias' ); ?></div>
                <div class="score-box">
                    <label for="synopsis-score-1">1</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="synopsis-score" id="synopsis-score-1" value="1"<?php echo isset($eval['synopsis-score']) && $eval['synopsis-score'] == 1 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="synopsis-score-2">2</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="synopsis-score" id="synopsis-score-2" value="2"<?php echo isset($eval['synopsis-score']) && $eval['synopsis-score'] == 2 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="synopsis-score-3">3</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="synopsis-score" id="synopsis-score-3" value="3"<?php echo isset($eval['synopsis-score']) && $eval['synopsis-score'] == 3 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="synopsis-score-4">4</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="synopsis-score" id="synopsis-score-4" value="4"<?php echo isset($eval['synopsis-score']) && $eval['synopsis-score'] == 4 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="synopsis-score-5">5</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="synopsis-score" id="synopsis-score-5" value="5"<?php echo isset($eval['synopsis-score']) && $eval['synopsis-score'] == 5 ? ' checked':'';?>/>
                </div>
            </div>
            <div class="evaluation__comments">
                <label for="synopsis-comment"><?php _e( 'Comments on Merit', 'historias' ); ?></label>
                <textarea<?php echo $form_disabled?' disabled':'';?> name="synopsis-comment" id="synopsis-comment"><?php echo isset($eval["synopsis-comment"]) ? $eval["synopsis-comment"] : '';?></textarea>
            </div>
        </div>

        <div class="evaluation__tab" id="evaluation-notes">
            <div class="evaluation__score">
                <div><?php _e( 'Viability Score', 'historias' ); ?></div>
                <div class="score-box">
                    <label for="notes-score-1">1</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="notes-score" id="notes-score-1" value="1"<?php echo isset($eval['notes-score']) && $eval['notes-score'] == 1 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="notes-score-2">2</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="notes-score" id="notes-score-2" value="2"<?php echo isset($eval['notes-score']) && $eval['notes-score'] == 2 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="notes-score-3">3</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="notes-score" id="notes-score-3" value="3"<?php echo isset($eval['notes-score']) && $eval['notes-score'] == 3 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="notes-score-4">4</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="notes-score" id="notes-score-4" value="4"<?php echo isset($eval['notes-score']) && $eval['notes-score'] == 4 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="notes-score-5">5</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="notes-score" id="notes-score-5" value="5"<?php echo isset($eval['notes-score']) && $eval['notes-score'] == 5 ? ' checked':'';?>/>
                </div>
            </div>
            <div class="evaluation__comments">
                <label for="notes-comment"><?php _e( 'Comments on the Viability', 'historias' ); ?></label>
                <textarea<?php echo $form_disabled?' disabled':'';?> name="notes-comment" id="notes-comment"><?php echo isset($eval["notes-comment"]) ? $eval["notes-comment"] : '';?></textarea>
            </div>
        </div>

        <div class="evaluation__tab" id="evaluation-arguments">
            <div class="evaluation__score">
                <div><?php _e( 'Qualification Score', 'historias' ); ?></div>
                <div class="score-box">
                    <label for="arguments-score-1">1</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="arguments-score" id="arguments-score-1" value="1"<?php echo isset($eval['arguments-score']) && $eval['arguments-score'] == 1 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="arguments-score-2">2</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="arguments-score" id="arguments-score-2" value="2"<?php echo isset($eval['arguments-score']) && $eval['arguments-score'] == 2 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="arguments-score-3">3</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="arguments-score" id="arguments-score-3" value="3"<?php echo isset($eval['arguments-score']) && $eval['arguments-score'] == 3 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="arguments-score-4">4</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="arguments-score" id="arguments-score-4" value="4"<?php echo isset($eval['arguments-score']) && $eval['arguments-score'] == 4 ? ' checked':'';?>/>
                </div>
                <div class="score-box">
                    <label for="arguments-score-5">5</label>
                    <input<?php echo $form_disabled?' disabled':'';?> type="radio" name="arguments-score" id="arguments-score-5" value="5"<?php echo isset($eval['arguments-score']) && $eval['arguments-score'] == 5 ? ' checked':'';?>/>
                </div>
            </div>
            <div class="evaluation__comments">
                <label for="arguments-comment"><?php _e( 'Comments on the Qualification', 'historias' ); ?></label>
                <textarea<?php echo $form_disabled?' disabled':'';?> name="arguments-comment" id="arguments-comment"><?php echo isset($eval["arguments-comment"]) ? $eval["arguments-comment"] : '';?></textarea>
            </div>
        </div>

        <div class="evaluation__tab" id="evaluation-remarks">
            <div class="evaluation__comments">
                <label for="remarks-comment"><?php _e( 'General Remarks', 'historias' ); ?></label>
                <textarea<?php echo $form_disabled?' disabled':'';?> name="remarks-comment" id="remarks-comment"><?php echo isset($eval["remarks-comment"]) ? $eval["remarks-comment"] : '';?></textarea>
            </div>
        </div>

    </form>
</div>
