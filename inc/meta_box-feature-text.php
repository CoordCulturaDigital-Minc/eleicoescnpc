<?php
/**
 * Custom meta box "Feature URL"
 *
 * Appears only on the "Capa/Inscricoes" Template
 *
 * @package forunssetoriaiscnpc
 */

class MetaBoxFeatureText {

    public static $custom_meta_fields;

    static function init() {

        $prefix = '_meta_';

        self::$custom_meta_fields = array(
            array(
                'label'         => __( 'Text', 'historias' ),
                'description'   => __( 'In the Inscricoes Template, this will be over the Featured Image; In the Divulgacao Template, it will be in the Selected Films box', 'historias' ),
                'id'            => $prefix . 'feature-text',
                'type'          => 'text'
            )
        );

        add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
        add_action( 'save_post', array( __CLASS__, 'save_postdata' ) );
    }


    /**
     * To appear on the Front Page
     */
    static function add_meta_box() {
        global $post_ID;

        // Get the Front Page's ID
        $front_page_id = get_option( 'page_on_front' );

        if( $post_ID == $front_page_id ) {
            add_meta_box(
                'feature-text',
                __( 'Feature Text', 'historias' ),
                array( __CLASS__,'meta_box_cb' ),
                'page',
                'normal'
            );
        }
    }


    /**
     * Meta box callback
     *
     */
    static function meta_box_cb( $post ) {

        // Cria o nonce para verificação
        wp_nonce_field( 'save_meta', 'meta_noncename' );


        foreach ( self::$custom_meta_fields as $field ) {

            // Recebe os metadados
            $meta_value =  get_post_meta( $post->ID, $field['id'], true );

            // Cria a estrutura
            echo '<p><label for="' . $field['id'] . '">' . $field['label'] . ':</label><br/>';

            switch ( $field['type'] ) {

                // Texto
                case 'text':
                    echo '<input type="text" id="' . $field['id'] . '" class="widefat" name="' . $field['id'] . '" value="' . esc_attr( $meta_value ) . '" size="25" />';
                break;

                // Dropdown
                case 'select':
                    echo '<select class="widefat" name="' . $field['id'] . '" id="' . $field['id'] . '">';
                    foreach ( $field['options'] as $option ) {
                        echo '<option value="' . $option['value'] . '"' , $meta_value == $option['value'] ? ' selected="selected"' : '' , '>' . $option['label'] . '</option>';
                    }
                    echo '</select>';
                break;

                // Upload
                case 'upload':
                    echo '<input type="text" id="' . $field['id'] . '" class="widefat custom-uploader" name="' . $field['id'] . '" value="' . esc_attr( $meta_value ) . '" size="25" />';
                    echo '<br/><br/>';
                    echo '<a href="#" id="set-default-image" class="custom-uploader-button button thickbox">Fazer upload</a>';
                break;

            }

            if ( $field['description'] )
                echo '<br/><br/><span class="description">' . $field['description'] . '</span>';

            echo '</p>';

        }

    }


    /**
     * Save custom fields
     *
     */
    function save_postdata( $post_id ) {

        global $post;

        if ( wp_is_post_revision( $post_id ) )
            return;

        // Verifica o autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
          return;

        // Não salva o campo caso seja uma revisão
        if ( $post->post_type == 'revision' )
            return;

        // Verifica o nonce
        if ( ! wp_verify_nonce( $_POST['meta_noncename'], 'save_meta' ) )
            return;



        foreach ( self::$custom_meta_fields as $field )
        {
            $old = get_post_meta( $post_id, $field['id'], true );
            $new = $_POST[$field['id']];

            if ( $new && $new != $old )
                update_post_meta( $post_id, $field['id'], $new );
            elseif ( $new == '' && $old )
                delete_post_meta( $post_id, $field['id'], $old );
        }
    }

}
MetaBoxFeatureText::init();


?>
