<?php
/*
Plugin Name: post2home
Plugin URI: http://github.com/eduardozulian/post2home
Description: A good and simple way to define featured posts.
Version: 1.0
Author: Hacklab, Eduardo Zulian
Author URI: http://hacklab.com.br
License: GPL2
*/

/* Copyright 2011-2012  Hacklab, Eduardo Zulian
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

add_filter( 'manage_posts_columns', 'post2home_add_column' );
add_action( 'manage_posts_custom_column', 'post2home_create_input', 10, 2 );
add_action( 'admin_enqueue_scripts', 'post2home_enqueue_scripts' );
add_action( 'wp_ajax_post2home_handle_post_meta', 'post2home_handle_post_meta' );

/**
 * Add a new column to post edit screen
 *
 * @param array $columns
 */
function post2home_add_column( $columns ) {
    global $post_type;

    if ( $post_type == 'post' )
        $columns['post2home-feature'] = __( 'Feature', 'post2home' );

    return $columns;
}

/**
 * Create the checkbox input
 *
 * @param string $column Custom column name
 * @param int   $post_id The post ID
 */
function post2home_create_input( $column, $post_id ) {

    if ( $column == 'post2home-feature' ) { ?>
        <input type="checkbox" class="post2home-button" id="post2home-<?php echo $post_id; ?>" <?php checked( get_post_meta( $post_id, '_post2home', true ), 1 ); ?>>
        <label for="post2home-<?php echo $post_id; ?>" title="<?php _e( 'Set / unset post feature', 'post2home' ); ?>" class="icon-star"><span class="screen-reader-text"><?php _e( 'Set / unset post feature', 'post2home' ); ?></span></label>
    <?php
    }

}

/**
 * Enqueue necessary scripts
 *
 * @param string $hook The current hook
 *
 * @global string $post_type The current post type
 */
function post2home_enqueue_scripts( $hook ) {

	global $post_type;

	if ( $hook == 'edit.php' && $post_type == 'post' ) {
		wp_enqueue_script( 'post2home', get_template_directory_uri() . '/includes/post2home/post2home.js', array( 'jquery' ) );

		wp_register_style( 'post2home', get_template_directory_uri() . '/includes/post2home/post2home.css', false );
		wp_enqueue_style( 'post2home' );

		wp_localize_script('post2home', 'historias', array('ajaxurl' => admin_url('admin-ajax.php') ));
	}

}

/**
 * Handle post meta action via Ajax
 *
 */
function post2home_handle_post_meta() {

	$meta_action = $_POST['meta_action'];
	$post_id = $_POST['post_id'];

	if ( $meta_action == 'update_meta' )
    	update_post_meta( $post_id, '_post2home', 1 );
    elseif ( $meta_action == 'delete_meta' )
    	delete_post_meta( $post_id, '_post2home' );

    die();

}
?>
