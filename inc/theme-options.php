<?php

/* Custom theme options */
function get_theme_option($option_name) {
  $option = get_option('theme_options');
  return isset($option[$option_name]) ? $option[$option_name] : false;
}

add_action('admin_init', 'theme_options_init');
add_action('admin_menu', 'theme_options_menu');

function theme_options_init() {
    register_setting('theme_options_options', 'theme_options', 'theme_options_validate_callback_function');
}

function theme_options_menu() {


    $topLevelMenuLabel = 'Histórias que Ficam';
    $page_title = 'Opções';
    $menu_title = 'Opções';

    /* Top level menu */
    add_submenu_page('theme_options', $page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'theme_options', 'theme_options_page_callback_function');


}

function theme_options_validate_callback_function($input) {

    //$input['slug_updates'] = sanitize_title($input['slug_updates']);
    $input['limite_orcamento'] = preg_replace('/\D/', '', $input['limite_orcamento']);
    return $input;

}



function theme_options_page_callback_function() {

?>
  <div class="wrap span-20">
    <h2>Oções</h2>

    <form action="options.php" method="post" class="clear prepend-top">
      <?php settings_fields('theme_options_options'); ?>
      <?php $options = get_option('theme_options'); if (!is_array($options)) $options = array(); ?>

      <div class="span-20 ">

        <h3>Textos da página de inscrição</h3>

        <div class="span-6 last">

          <!-- TEXTAREA -->
          <label for="txt_visitante"><strong>Para usuários não cadastrados, na lateral</strong></label><br/>
          <textarea id="txt_visitante" name="theme_options[txt_visitante]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_visitante']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato"><strong>Para candidatos, na lateral</strong></label><br/>
          <textarea id="txt_candidato" name="theme_options[txt_candidato]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step1"><strong>Para candidatos, Etapa 1</strong></label><br/>
          <textarea id="txt_candidato_step1" name="theme_options[txt_candidato_step1]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step1']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_topo"><strong>Para candidatos, Etapa 2</strong></label><br/>
          <textarea id="txt_candidato_topo" name="theme_options[txt_candidato_topo]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_topo']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step2"><strong>Para candidatos, Etapa 3</strong></label><br/>
          <textarea id="txt_candidato_step2" name="theme_options[txt_candidato_step2]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step2']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step3a"><strong>Para candidatos, Etapa 4, antes de clicar no "Conferir"</strong></label><br/>
          <textarea id="txt_candidato_step3a" name="theme_options[txt_candidato_step3a]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step3a']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step3"><strong>Para candidatos, Etapa 4, depois de clicar no "Conferir" (caixa amarela)</strong></label><br/>
          <textarea id="txt_candidato_step3" name="theme_options[txt_candidato_step3]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step3']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step4"><strong>Para candidatos, Etapa 4, quando aparece o número de inscrição</strong></label><br/>
          <textarea id="txt_candidato_step4" name="theme_options[txt_candidato_step4]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step4']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato"><strong>Para candidatos (entra no email aos candidatos que acabaram se inscrever)</strong></label><br/>
          <textarea id="txt_candidato" name="theme_options[txt_mail_candidato]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_mail_candidato']); ?></textarea>
          <br/><br/>

          <label for="txt_curador"><strong>Para curadores, na lateral</strong></label><br/>
          <textarea id="txt_curador" name="theme_options[txt_curador]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_curador']); ?></textarea>
          <br/><br/>

          <label for="txt_admin"><strong>Para administrador, na lateral</strong></label><br/>
          <textarea id="txt_admin" name="theme_options[txt_admin]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_admin']); ?></textarea>
          <br/><br/>
          
          <label for="link_modelo_orcamento"><strong>Link para modelo de orçamento</strong></label><br/>
          <input type="text" id="link_modelo_orcamento" name="theme_options[link_modelo_orcamento]" value="<?php echo htmlspecialchars($options['link_modelo_orcamento']); ?>">
          <br/><br/>

        <h3>Orçamento</h3>
        
          <label for="limite_orcamento"><strong>Valor máximo para os orçamentos (somente números)</strong></label><br/>
          <input type="text" id="limite_orcamento" name="theme_options[limite_orcamento]" value="<?php echo htmlspecialchars($options['limite_orcamento']); ?>">
          <br/><br/>
        
        <h3>Inscrições</h3>

          <!-- CHECKBOX -->
          <input type="checkbox" id="inscricoes_abertas" class="text" name="theme_options[inscricoes_abertas]" value="1" <?php checked(true, get_theme_option('inscricoes_abertas'), true); ?>/>
          <label for="inscricoes_abertas"><strong>Inscrições abertas</strong></label><br/>

          <input type="checkbox" id="avaliacoes_abertas" class="text" name="theme_options[avaliacoes_abertas]" value="1" <?php checked(true, get_theme_option('avaliacoes_abertas'), true); ?>/>
          <label for="avaliacoes_abertas"><strong>Avaliações abertas</strong></label><br/>

          <input type="checkbox" id="manutencao" class="text" name="theme_options[manutencao]" value="1" <?php checked(true, get_theme_option('manutencao'), true); ?>/>
          <label for="manutencao"><strong>Manutenção (esconde o site e mostra apenas uma página estática)</strong></label><br/>

          <label for="aviso"><strong>Aviso Home</strong></label><br/>
          <textarea id="aviso" name="theme_options[aviso]" rows="5" cols="60"><?php echo htmlspecialchars($options['aviso']); ?></textarea>
          <br/><br/>

        </div>
      </div>

      <p class="textright clear prepend-top">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
      </p>
    </form>
  </div>

<?php } ?>
