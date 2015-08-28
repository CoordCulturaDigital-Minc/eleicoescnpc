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


    $topLevelMenuLabel = 'Eleições CNPC';
    $page_title = 'Opções';
    $menu_title = 'Opções';

    /* Top level menu */
    add_submenu_page('theme_options', $page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
   $theme_options = add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'theme_options', 'theme_options_page_callback_function');

    add_action( "admin_print_scripts-{$theme_options}", "addScripts" );
}

function addScripts() { 
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_script('theme_options_js', get_template_directory_uri() . '/js/theme-options.js', array('jquery', 'jquery-ui-datepicker'));
  wp_enqueue_style('jquery-ui-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');

}

function theme_options_validate_callback_function($input) {

    //$input['slug_updates'] = sanitize_title($input['slug_updates']);
    $input['candidatos_blacklist']  = explode(',', $input['candidatos_blacklist']);
    $input['delegates_two_years']   = explode(',', $input['delegates_two_years']);
    $input['data_inicio_votacao']   = convert_format_date($input['data_inicio_votacao']);
    $input['data_fim_votacao']      = convert_format_date($input['data_fim_votacao']);
    $input['data_inicio_da_troca']  = convert_format_date($input['data_inicio_da_troca']);

    // $input['limite_orcamento'] = preg_replace('/\D/', '', $input['limite_orcamento']);
    return $input;

}



function theme_options_page_callback_function() {

?>
  <div class="wrap span-20">
    <h2>Opções</h2>

    <form action="options.php" method="post" class="clear prepend-top">
      <?php settings_fields('theme_options_options'); ?>
      <?php $options = get_option('theme_options'); if (!is_array($options)) $options = array(); ?>

      <div class="span-20 ">

        
        <div class="span-6 last">

          <h3>Textos da página de registro</h3>

          <!-- TEXTAREA -->
          <label for="txt_visitante"><strong>Para usuários não cadastrados, formulário inicial</strong></label><br/>
          <textarea id="txt_visitante" name="theme_options[txt_visitante]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_visitante']); ?></textarea>
          <br/><br/>

          <h3>Textos da inscrição do candidato</h3>

          <label for="txt_candidato"><strong>Para candidatos, no topo do formúlário</strong></label><br/>
          <textarea id="txt_candidato" name="theme_options[txt_candidato]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_topo"><strong>Para candidatos, Topo</strong></label><br/>
          <textarea id="txt_candidato_topo" name="theme_options[txt_candidato_topo]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_topo']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step1"><strong>Cabeçalho para candidatos, Etapa 1</strong></label><br/>
          <textarea id="txt_candidato_step1" name="theme_options[txt_candidato_step1]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step1']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step2"><strong>Cabeçalho para candidatos, Etapa 2</strong></label><br/>
          <textarea id="txt_candidato_step2" name="theme_options[txt_candidato_step2]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step2']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step3a"><strong>Cabeçalho para candidatos, Etapa 3</strong></label><br/>
          <textarea id="txt_candidato_step3a" name="theme_options[txt_candidato_step3a]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step3a']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step3"><strong>Para candidatos, Etapa 3, antes de finalizar candidatura (caixa amarela)</strong></label><br/>
          <textarea id="txt_candidato_step3" name="theme_options[txt_candidato_step3]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step3']); ?></textarea>
          <br/><br/>

          <label for="txt_candidato_step4"><strong>Conteúdo para candidatos, Etapa 3, finalizada a inscrição</strong></label><br/>
          <textarea id="txt_candidato_step4" name="theme_options[txt_candidato_step4]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_candidato_step4']); ?></textarea>
          <br/><br/>

        <h3>Texto para E-mail</h3>

          <label for="txt_candidato"><strong>Para candidatos (entra no e-mail aos candidatos que acabaram se inscrever)</strong></label><br/>
          <textarea id="txt_candidato" name="theme_options[txt_mail_candidato]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_mail_candidato']); ?></textarea>
          <br/><br/>

        <h3>Textos dos fóruns</h3>
          
            <label for="txt_forum_is_voter"><strong>Para eleitor que é da Setorial e UF</strong></label><br/>
            <textarea id="txt_forum_is_voter" name="theme_options[txt_forum_is_voter]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_forum_is_voter']); ?></textarea>
            <br/><br/>

            <label for="txt_forum_is_not_voter"><strong>Para não eleitor da Setorial e UF</strong></label><br/>
            <textarea id="txt_forum_is_not_voter" name="theme_options[txt_forum_is_not_voter]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_forum_is_not_voter']); ?></textarea>
            <br/><br/>

            <label for="txt_forum"><strong>Para qualquer usuário</strong></label><br/>
            <textarea id="txt_forum" name="theme_options[txt_forum]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_forum']); ?></textarea>
            <br/><br/>

        <h3>Textos para curadores</h3>
        
          <label for="txt_curador"><strong>Para curadores, na lateral</strong></label><br/>
          <textarea id="txt_curador" name="theme_options[txt_curador]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_curador']); ?></textarea>
          <br/><br/>

          <!-- <label for="txt_admin"><strong>Para administrador, na lateral</strong></label><br/>
          <textarea id="txt_admin" name="theme_options[txt_admin]" rows="5" cols="60"><?php echo htmlspecialchars($options['txt_admin']); ?></textarea>
          <br/><br/> -->

        <h3>Delegados Natos</h3>
        
          <label for="candidatos_blacklist"><strong>Informe o CPF dos delegados natos, separados por vírgula. Exemplo: (999.9999.999-99, 888.888.888-88)</strong></label><br/>
          <textarea id="candidatos_blacklist" name="theme_options[candidatos_blacklist]" rows="5" cols="60" ><?php echo htmlspecialchars(implode(",", $options['candidatos_blacklist'])); ?></textarea>
          <br/><br/>

        <h3>Lista de delegados eleitos por 2 vezes nos últimos anos</h3>
        
          <label for="delegates_two_years"><strong>Informe o CPF dos delegados, separados por vírgula. Exemplo: (999.9999.999-99, 888.888.888-88)</strong></label><br/>
          <textarea id="delegates_two_years" name="theme_options[delegates_two_years]" rows="5" cols="60" ><?php echo htmlspecialchars(implode(",", $options['delegates_two_years'])); ?></textarea>
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
          
          <h3>Cronograma Votação</h3>

          <!-- CHECKBOX -->
        <!--   <input type="checkbox" id="votacoes_abertas" class="text" name="theme_options[votacoes_abertas]" value="1" <?php checked(true, get_theme_option('votacoes_abertas'), true); ?>/>
          <label for="votacoes_abertas"><strong>Votações abertas</strong></label><br/> -->

          <label for="data_inicio_da_votacao"><strong>Data início da votação</strong></label><br/>
          <input type="text" id="data_inicio_da_votacao" class="text select_date" name="theme_options[data_inicio_votacao]" value="<?php echo restore_format_date(htmlspecialchars($options['data_inicio_votacao'])); ?>">

          <br><br>
          <label for="data_fim_da_votacao"><strong>Data fim da votação</strong></label><br/>
          <input type="text" id="data_fim_da_votacao" class="text select_date" name="theme_options[data_fim_votacao]" value="<?php echo restore_format_date(htmlspecialchars($options['data_fim_votacao'])); ?>">
          
          <br><br>
          <label for="data_inicio_da_troca"><strong>Data início da troca de votos</strong></label><br/>
          <input type="text" id="data_inicio_da_troca" class="text select_date" name="theme_options[data_inicio_da_troca]" value="<?php echo restore_format_date(htmlspecialchars($options['data_inicio_da_troca'])); ?>">

          <br><br>
          <label for="vezes_que_pode_mudar_voto"><strong>Quantidade de vezes que pode trocar o voto</strong></label><br/>
          <input type="text" id="vezes_que_pode_mudar_voto" class="text" name="theme_options[vezes_que_pode_mudar_voto]" value="<?php echo htmlspecialchars($options['vezes_que_pode_mudar_voto']); ?>">
          
        </div>
      </div>

      <p class="textright clear prepend-top">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
      </p>
    </form>
  </div>

<?php } ?>
