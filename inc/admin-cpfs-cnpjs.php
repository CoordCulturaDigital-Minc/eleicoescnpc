<?php

add_action('admin_init', 'admin_page_cpfs_init');
add_action('admin_menu', 'admin_page_cpfs_menu');

function admin_page_cpfs_init() {
    register_setting('admin_page_cpfs_options', 'admin_page_cpfs', 'admin_page_cpfs_validate_callback_function');
}

function admin_page_cpfs_menu() {


    $topLevelMenuLabel = 'CPFs e CNPJs';
    $page_title = 'CPFs e CNPJs';
    $menu_title = 'CPFs e CNPJs';

    /* Top level menu */
    add_submenu_page('admin_page_cpfs', $page_title, $menu_title, 'manage_options', 'admin_page_cpfs', 'admin_page_cpfs_page_callback_function');
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'admin_page_cpfs', 'admin_page_cpfs_page_callback_function');


}

function admin_page_cpfs_page_callback_function() {

    global $wpdb;
    $cpfs = $wpdb->get_results("select meta_value, post_id, post_author from $wpdb->postmeta INNER JOIN $wpdb->posts ON post_id = {$wpdb->posts}.ID where meta_key = 'director-cpf' ORDER BY meta_value");
    $cnpjs = $wpdb->get_results("select meta_value, post_id, post_author from $wpdb->postmeta INNER JOIN $wpdb->posts ON post_id = {$wpdb->posts}.ID where meta_key = 'company-cnpj' ORDER BY meta_value");
    
    $dados = array(
        'CPFs' => $cpfs,
        'CNPJs' => $cnpjs
    );
    
    function admin_page_cpfs_print_user($user_id) {
        $userinfo = get_userdata($user_id);
        ?>
        <a href="<?php echo get_edit_user_link($user_id); ?>"><?php echo $userinfo->user_email; ?></a>
        <?php
    }

?>
  <div class="wrap span-20">
    
        <?php foreach ($dados as $secao => $dado): ?>
            <h2><?php echo $secao; ?></h2>

            <table class="wp-list-table widefat">
                
                <thead>
                    <tr>
                    
                        <th><?php echo $secao; ?></th>
                        <th>Usuário</th>
                    
                    </tr>
                </thead>
                
                <tbody>
                
                    <?php foreach ($dado as $d): ?>
                    
                        <tr>
                        
                            <td><?php echo $d->meta_value; ?></td>
                            <td><?php admin_page_cpfs_print_user($d->post_author); ?></td>
                        
                        </tr>
                    
                    <?php endforeach; ?>
                
                </tbody>

            </table>
            
        <?php endforeach; ?>
  </div>

<?php } ?>
