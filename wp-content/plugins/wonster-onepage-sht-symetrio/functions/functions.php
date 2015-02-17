<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }


// public style / script
function wtr_op_scripts_styles() {

	if( ! is_admin() ) {
		wp_enqueue_script('wtr-docs-sht', WTR_OP_PLUGIN_URI . 'assets/js/wtr-docs-sht.js', null, null, true );
		$post = get_post();
		if($post && preg_match('/wtr_one_page/', $post->post_content)) {
			wp_enqueue_style('js_composer_front');
		}
		wp_enqueue_style('js_composer_front');
	}
} // end wtr_scripts_styles

add_action( 'wp_enqueue_scripts', 'wtr_op_scripts_styles', 20 );