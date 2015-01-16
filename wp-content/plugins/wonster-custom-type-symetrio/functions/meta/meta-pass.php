<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */


function wtr_create_pass() {

	global $WTR_Opt, $wtr_custom_posts_type, $wtr_custom_posts_taxonomy;
	$wtr_custom_posts_type[]	= 'pass';
	$wtr_custom_posts_taxonomy[]= 'pass-category';

	$labels= array(
		'name' 					=> __( 'Pass', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Pass', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Pass', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Pass', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Pass', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Pass', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Pass', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Pass', 'wtr_ct_framework' ),
		'not_found' 			=> __( 'No passes  found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No passes  found in Trash', 'wtr_ct_framework' )
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> false,
		'publicly_queryable'	=> false,
		'show_ui' 				=> true,
		'query_var' 			=> false,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'rewrite' 				=> true,
		'supports' 				=> array( 'title', 'page-attributes' ),
		"show_in_nav_menus" 	=> false,
		'exclude_from_search'	=> true,
	);
	register_post_type( 'pass', $args );
	register_taxonomy(
		"pass-category", array("pass"), array(
			'public' 			=> false,
			'show_ui' 			=> true,
			'show_tagcloud'		=> false,
			"hierarchical" 		=> true,
			"show_in_nav_menus" => false,
			"rewrite" => true,
			'labels' 			=> array(
				'name' 				=> __( 'Pass Categories', 'wtr_ct_framework' ),
				'singular_name' 	=> __( 'Pass Category', 'wtr_ct_framework' ),
				'edit_item' 		=> __( 'Edit Pass Category', 'wtr_ct_framework' ),
				'search_items'		=> __( 'Search Pass Category' , 'wtr_ct_framework' ),
				'all_items'			=> __( 'All Pass Categories' , 'wtr_ct_framework' ),
				'parent_item'		=> __( 'Parent Pass Category' , 'wtr_ct_framework' ),
				'parent_item_colon'	=> __( 'Parent Pass Category:' , 'wtr_ct_framework' ),
				'edit_item'			=> __( 'Edit Pass Category' , 'wtr_ct_framework' ),
				'update_item'		=> __( 'Update Pass Category' , 'wtr_ct_framework' ),
				'add_new_item'		=> __( 'Add New Pass Category' , 'wtr_ct_framework' ),
				'new_item_name'		=> __( 'New Pass Category Name' , 'wtr_ct_framework' ),
				'menu_name'			=> __( 'Pass Categories' , 'wtr_ct_framework' )
				),
			)
		);
} // end wtr_create_pass
add_action( 'init', 'wtr_create_pass' );


// add table column in edit page
function wtr_pass_column($columns){

	$columns = array(
		"cb" 				=> "<input type='checkbox' />",
		"title"				=> __( 'Title', 'wtr_ct_framework' ),
		"pass_price"		=> __( 'Price', 'wtr_ct_framework' ),
		"pass_category"		=> __( 'Pass Categories', 'wtr_ct_framework' ),
		"pass_gym_location"	=> __( 'Gym Location', 'wtr_ct_framework' ),
		"pass_order"		=> __( 'Order', 'wtr_ct_framework'),
	);
	return $columns;
} // end wtr_pass_column
add_filter("manage_edit-pass_columns", "wtr_pass_column");


//manage posts custom column
function wtr_pass_custom_columns($column){

	global $post;

	switch ($column) {

		case "pass_price":
			echo get_post_meta( $post->ID, '_wtr_pass_price', true );
		break;

		case "pass_category":
			echo get_the_term_list($post->ID, 'pass-category', '', ', ','');
		break;

		case "pass_gym_location":
			$gym_location		= get_post_meta( $post->ID, '_wtr_gym_location', false );
			$gym_location_names	= wtr_get_gym_location_metabox( $gym_location, true );
			echo implode( $gym_location_names, ', ' );
		break;

		case "pass_order":
			echo $post->menu_order;
		break;
	}
} // end wtr_pass_custom_columns
add_action("manage_posts_custom_column","wtr_pass_custom_columns");


//add meta boxes
function wtr_add_metabox_pass(){

	$current_screen = get_current_screen();

	if( 'pass' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt;

	$wtr_pass_price = new WTR_Text( array(
			'id' 			=> '_wtr_pass_price',
			'class'			=> '',
			'title' 		=> __( 'Price', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_pass_membership_type = new WTR_Text( array(
			'id' 			=> '_wtr_pass_membership_type',
			'class'			=> '',
			'title' 		=> __( 'Membership type', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);


	$wtr_pass_desc = new WTR_Textarea( array(
			'id' 			=> '_wtr_pass_desc',
			'class' 		=> '',
			'rows' 			=> 10,
			'title' 		=> __( 'Description', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_pass_status = new WTR_Radio_List( array(
			'id'			=> '_wtr_pass_status',
			'title'			=> __( 'Status', 'wtr_ct_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => '1',
			'info'			=> '',
			'allow'			=> 'int',
			'mod' 			=> '',
			'checked'		=> '0',
			'option'		=> array( '0' => 'Promotion' , '1' => 'New' , '2' => 'Featured' ),
		)
	);

	require_once( WTR_ADMIN_CLASS_DIR . '/wtr_meta_box.php' );

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_pass_price,
							$wtr_pass_membership_type,
							$wtr_pass_desc,
							$wtr_pass_status
					)
	);


	$wtr_meta_settings =
					array(
						'id' 		=> 'wtr-meta-post',
						'title' 	=> __('Pass Options', 'wtr_ct_framework' ),
						'page' 		=> 'pass',
						'context' 	=> 'normal',
						'priority' 	=> 'high',
						'sections' 	=> array(
											$wtr_GeneralSections,
										)
					);

	//Gym location Right Metabox
	$wtr_gym_location_options = wtr_get_gym_location_metabox();

	$wtr_gym_location = new WTR_Checkbox( array(
			'id'			=> '_wtr_gym_location',
			'title'			=> __( 'Gym Location', 'wtr_ct_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => array(),
			'info'			=> '',
			'allow'			=> 'all',
			'option'		=> $wtr_gym_location_options,
			'mod' 			=> 'simple'

		)
	);

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_gym_location,
					)
	);

	$wtr_gym_location_right_meta_settings =
					array(
						'id' 		=> 'wtr-gym_location-meta-right-post',
						'title' 	=> __( 'Gym Location', 'wtr_ct_framework' ),
						'page' 		=> 'pass',
						'context' 	=> 'side',
						'priority' 	=> 'core',
						'callback'	=> 'render_right_meta_box_content',
						'sections' 	=> array(
											$wtr_GeneralSections,
										)
					);

	$wtr_meta_box						= NEW wtr_meta_box( $wtr_meta_settings );
	$wtr_gym_location_right_meta_box	= NEW wtr_meta_box( $wtr_gym_location_right_meta_settings );

}// end wtr_add_metabox_pass
add_action( 'load-post.php', 'wtr_add_metabox_pass' );
add_action( 'load-post-new.php', 'wtr_add_metabox_pass' );
add_action( 'wtr_post_save_pass' , 'wtr_save_metabox_gym_location' );