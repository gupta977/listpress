<?php

add_action('init', 'listpress_post_types');
add_shortcode("listpress", "listpress_button");
add_action('wp_enqueue_scripts', 'listpress_enqueue_scripts');
add_action('admin_enqueue_scripts', 'listpress_admin_enqueue_scripts');
if (is_admin()) 
{
	add_action( 'admin_menu', 'listpress_add_admin_menu' );
	add_action( 'admin_init', 'listpress_settings_init' );
	add_action( 'plugins_loaded', array( 'listpress_FormEntries', 'init' ));

}
?>