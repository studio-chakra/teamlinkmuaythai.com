<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('1'); }

add_shortcode( 'wtr_one_page', 'wtr_one_page_shortcode' );
function wtr_one_page_shortcode( $atts ) {

	extract(shortcode_atts(array(
		'page'		=> '',
		), $atts));

	global $post_settings;
	$pages = explode( ',', $page );

	if( empty( $pages ) ){
		return;
	}

	$output	= '';
	foreach ( $pages as $key => $value ) {
		$output	.= apply_filters('the_content', get_post_field( 'post_content', $value ) );
	}

	return $output;
} // end wtr_one_page_shortcode