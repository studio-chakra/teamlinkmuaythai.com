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


function wtr_create_rooms() {

	global $WTR_Opt, $wtr_custom_posts_type, $wtr_custom_posts_taxonomy;
	$wtr_SlugsRooms_Slug		= $WTR_Opt->getopt('wtr_SlugsRooms_Slug');
	$wtr_custom_posts_type[]	= 'rooms';
	$wtr_custom_posts_taxonomy[]= 'rooms-category';

	$labels= array(
		'name' 					=> __( 'Rooms', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Rooms', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Rooms', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Room', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Room', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Room', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Room', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Rooms', 'wtr_ct_framework' ),
		'not_found' 			=> __( 'No Rooms found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Rooms found in Trash', 'wtr_ct_framework' )
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		"show_in_nav_menus" 	=> false,
		'exclude_from_search' 	=> false,
		'rewrite' 				=> array( 'slug' => $wtr_SlugsRooms_Slug, 'with_front' => true ),
		'supports' 				=> array( 'title', 'editor', 'thumbnail', 'page-attributes' )
	);
	register_post_type( 'rooms', $args );
	register_taxonomy(
		"rooms-category", array("rooms"), array(
			'public' 			=> false,
			'show_ui' 			=> true,
			'show_tagcloud'		=> false,
			"hierarchical" 		=> true,
			"show_in_nav_menus" => false,
			"rewrite" => true,
			'labels' 			=> array(
				'name' 				=> __( 'Rooms Categories', 'wtr_ct_framework' ),
				'singular_name' 	=> __( 'Room Category', 'wtr_ct_framework' ),
				'edit_item' 		=> __( 'Edit Room Category', 'wtr_ct_framework' ),
				'search_items'		=> __( 'Search Room Category' , 'wtr_ct_framework' ),
				'all_items'			=> __( 'All Rooms Categories' , 'wtr_ct_framework' ),
				'parent_item'		=> __( 'Parent Room Category' , 'wtr_ct_framework' ),
				'parent_item_colon'	=> __( 'Parent Room Category:' , 'wtr_ct_framework' ),
				'edit_item'			=> __( 'Edit Room Category' , 'wtr_ct_framework' ),
				'update_item'		=> __( 'Update Room Category' , 'wtr_ct_framework' ),
				'add_new_item'		=> __( 'Add New Room Category' , 'wtr_ct_framework' ),
				'new_item_name'		=> __( 'New Room Category Name' , 'wtr_ct_framework' ),
				'menu_name'			=> __( 'Rooms Categories' , 'wtr_ct_framework' )
				),
			)
		);
} // end wtr_create_rooms
add_action( 'init', 'wtr_create_rooms' );


function wtr_single_template_rooms( $single ) {
	global $post;

	if ( isset( $post->post_type ) AND "rooms" == $post->post_type ){
		$single =  WTR_CP_INCLUDES_DIR . '/single-rooms.php';
	}
	return $single;
} // end wtr_single_template_rooms
add_filter( 'single_template', 'wtr_single_template_rooms' );


// add table column in edit page
function wtr_rooms_column($columns){

	$columns = array(
		"cb" 				=> "<input type='checkbox' />",
		"title"				=> __( 'Title', 'wtr_ct_framework' ),
		"rooms_category"	=> __( 'Rooms category', 'wtr_ct_framework' ),
		"rooms_gym_location"=> __( 'Gym Location', 'wtr_ct_framework' ),
		"rooms_order"		=> __( 'Order', 'wtr_ct_framework'),
	);
	return $columns;
} // end wtr_rooms_column
add_filter("manage_edit-rooms_columns", "wtr_rooms_column");


// manage posts custom column
function wtr_rooms_custom_columns($column){

	global $post;

	switch ($column) {
		case "rooms_category":
			echo get_the_term_list( $post->ID, 'rooms-category', '', ', ','');
		break;

		case "rooms_gym_location":
			$gym_location		= get_post_meta( $post->ID, '_wtr_gym_location', false );
			$gym_location_names	= wtr_get_gym_location_metabox( $gym_location, true );
			echo implode( $gym_location_names, ', ' );
		break;

		case "rooms_order":
			echo $post->menu_order;
		break;
	}
} // end wtr_rooms_custom_columns
add_action("manage_posts_custom_column","wtr_rooms_custom_columns");


//add meta boxes
function wtr_add_metabox_rooms(){

	$current_screen = get_current_screen();

	if( 'rooms' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt;

	$wtr_SeoTitle = new WTR_Text(array(
			'id' 			=> '_wtr_SeoTitle',
			'class' 		=> '',
			'title' 		=> __( 'SEO tittle', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_SeoDesc = new WTR_Text(array(
			'id' 			=> '_wtr_SeoDesc',
			'class' 		=> '',
			'title' 		=> __( 'SEO description', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_SeoKey = new WTR_Text(array(
			'id' 			=> '_wtr_SeoKey',
			'class' 		=> '',
			'title' 		=> __( 'SEO keywords', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_NoRobot = new WTR_Radio( array(
			'id' 			=> '_wtr_NoRobot',
			'title' 		=> __( 'Robots meta tag', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '0',
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'mod' 			=> 'robot',
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyPortfolio wtrPageFields">' . __( 'Site has No Robot attribute ', 'wtr_ct_framework' ) . '</div>',
		)
	);

	$wtr_SidebarPosition = new WTR_Radio_Img( array(
			'id' 			=> '_wtr_SidebarPosition',
			'title' 		=> __( 'Sidebar position', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_SidebarPositionOnRooms' ),
			'info' 			=> '',
			'allow' 		=> 'all',
			'checked' 		=> 'sideChecked',
			'class' 		=> 'sideSetter wtrPageFields',
			'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
		)
	);

	$wtr_Sidebar = new WTR_Select(array(
			'id' 			=> '_wtr_Sidebar',
			'title' 		=> __( 'Sidebar', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_SidebarPickOnRooms' ),
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> $WTR_Opt->getopt( 'wtr_SidebraManagement' ) ,
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyPortfolio wtrPageFields">' . __( 'To set sidebar use "Siedebar management". Go to: Apperance > Theme Options > General > Sidebar', 'wtr_ct_framework' ) . '</div>',
			'mod' 			=> '',
			'class'			=> 'wtrOnlyPortfolio wtrPageFields'
			)
	);

	$wtr_CustomCssForPage = new WTR_Textarea( array(
			'id' 			=> '_wtr_CustomCssForPage',
			'class' 		=> '',
			'rows' 			=> 10,
			'title' 		=> __( 'Custom css for page', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	require_once( WTR_ADMIN_CLASS_DIR . '/wtr_meta_box.php' );

	$wtr_SidebarSections = array(
		'id'		=> 'wtr_SidebarSections',
		'name' 		=>__( 'Sidebar', 'wtr_ct_framework' ),
		'class'		=> 'Sidebar',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_SidebarPosition,
							$wtr_Sidebar,
					)
	);

	$wtr_CssSections = array(
		'id'		=> 'wtr_CssSections',
		'name' 		=>__( 'CSS', 'wtr_ct_framework' ),
		'class'		=> 'CSS',
		'fields'	=> array(
							$wtr_CustomCssForPage
					)
	);

	$wtr_meta_settings =
					array(
						'id' 		=> 'wtr-meta-post',
						'title' 	=> __('Room Options', 'wtr_ct_framework' ),
						'page' 		=> 'rooms',
						'context' 	=> 'normal',
						'priority' 	=> 'high',
						'sections' 	=> array(
											$wtr_SidebarSections,
											$wtr_CssSections
											)
					);


	// Add seo fields
	if ( 1 ==  $WTR_Opt->getopt( 'wtr_SeoSwich' ) ) {
		$wtr_SEOSections = array(
			'id'		=> 'wtr_SEOSections',
			'name' 		=>__( 'SEO', 'wtr_ct_framework' ),
			'class'		=> 'SEO',
			'fields'	=> array(
								$wtr_SeoTitle,
								$wtr_SeoDesc,
								$wtr_SeoKey,
								$wtr_NoRobot,
							)
		);
		$wtr_meta_settings['sections'][] = $wtr_SEOSections;
	}

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
						'page' 		=> 'rooms',
						'context' 	=> 'side',
						'priority' 	=> 'core',
						'callback'	=> 'render_right_meta_box_content',
						'sections' 	=> array(
											$wtr_GeneralSections,
										)
					);

	$wtr_meta_box						= NEW wtr_meta_box( $wtr_meta_settings );
	$wtr_gym_location_right_meta_box	= NEW wtr_meta_box( $wtr_gym_location_right_meta_settings );

} // end wtr_add_metabox_rooms
add_action( 'load-post.php', 'wtr_add_metabox_rooms' );
add_action( 'load-post-new.php', 'wtr_add_metabox_rooms' );
add_action( 'wtr_post_save_rooms' , 'wtr_save_metabox_gym_location' );




function wtr_post_settings_single_post_rooms( $post_settings_single ){

	$post_settings_single = array(
		'wtr_SidebarPosition'		=> '_wtr_SidebarPosition',
		'wtr_Sidebar'				=> '_wtr_Sidebar',
		'wtr_CustomCssForPage'		=> '_wtr_CustomCssForPage',
		'wtr_SeoTitle'				=> '_wtr_SeoTitle',
		'wtr_SeoDescription'		=> '_wtr_SeoDesc',
		'wtr_SeoKeywords'			=> '_wtr_SeoKey',
		'wtr_NoRobot'				=> '_wtr_NoRobot',
	);
	return $post_settings_single;

} // end wtr_post_settings_single_post_rooms
add_filter( 'wtr_post_settings_single_post_rooms', 'wtr_post_settings_single_post_rooms', 10, 2 );