<?php

class congeladoform {
    var $forms = array();
    var $save = array();

    protected $nameClass;
    protected $nameGroup;
    protected $options;

    public function CongeladoForm() {
        $this->nameClass = 'congeladoform';
        $this->nameGroup = 'congeladoform_group';

        add_action('admin_init', array( $this, 'optionsInit' ) );
        add_action('admin_menu', array( $this, 'register_admin_page' ) );
    }

    public function optionsInit(){
        register_setting( $this->nameGroup, $this->nameClass, array( $this, 'optionsValidation' ) );
        
        if (isset($_GET['congeladoform_download'])) {
            $formID = $_GET['congeladoform_download'];
            $rows = get_option('congeladoform_saved_' . $formID);
            if (is_array($rows)) {
                
                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private",false);
                header("Content-Type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"" . $formID . ".csv\";" );
                header("Content-Transfer-Encoding: binary"); 
                
                foreach ($rows as $row) {
                    
                    foreach ($row as $field) {
                        echo '"', esc_attr($field), '";';
                    }
                    echo "\n";
                
                }
                
                die;
            }
            
        }
    }

    public function register_form($formId, $formfields, $save = false) {
        $this->forms[$formId] = $formfields;
        $this->save[$formId] = $save;
    }

    public function optionsValidation($input) {
        //TODO - validate
        return $input;
    }

    function register_admin_page() {
        //add_menu_page...
        add_submenu_page( 'options-general.php', 'Formulários', 'Formulários', 'manage_options', 'congeladoforms', array($this, 'admin_page') );
    }

    function admin_page() {
?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title();?></h2>

        <form action="options.php" method="post">
            <?php
                settings_fields( $this->nameGroup );
                $this->options = get_option( $this->nameClass );
            ?>
                <table class="form-table">
                    <tbody>
                        <?php foreach ($this->forms as $key => $form) { ?>
                            <tr>
                                <th colspan="2" style="margin: 0; padding: 0;">
                                    <h3><?php echo ucwords(str_replace('-', ' ', $key )); ?></h3>
                                    <?php if ($this->save[$key]): ?>
                                        <a target="_blank" href="?congeladoform_download=<?php echo $key; ?>">Download da planilha</a>
                                    <?php endif; ?>
                                </th>
                            </tr>
                            <tr>
                                <th scope="row"><label for="email-<?php echo $key;?>">Email de destino</label></th>
                                <td><input type="text" id="email-<?php echo $key;?>" class="text" name="<?php echo $this->nameClass.'['.$key.'][email]'; ?>" value="<?php echo htmlspecialchars($this->options[$key]['email']); ?>" /></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="assunto-<?php echo $key;?>">Assunto do email</label></th>
                                <td><input type="text" id="assunto-<?php echo $key;?>" class="text" name="<?php echo $this->nameClass.'['.$key.'][assunto]'; ?>" value="<?php echo htmlspecialchars($this->options[$key]['assunto']); ?>" /></td>
                            </tr>
                            
                            <input type="hidden" id="save-<?php echo $key;?>" name="<?php echo $this->nameClass.'['.$key.'][save]'; ?>" value="<?php echo $this->save[$key] ? '1' : '0'; ?>" />
                            
                            
                            
                        <?php }?>
                    </tbody>
                </table>
            <?php submit_button(); ?>
        </form>


    </div>
<?php
    }

};

global $congeladoForm;
$congeladoForm = new CongeladoForm();

function register_congelado_form($formId, $formfields, $save = false) {
    global $congeladoForm;
    $congeladoForm->register_form($formId, $formfields, $save);
}


?>
