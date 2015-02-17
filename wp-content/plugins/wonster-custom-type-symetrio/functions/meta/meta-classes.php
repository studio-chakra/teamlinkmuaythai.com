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


function wtr_create_classes() {

	global $WTR_Opt, $wtr_custom_posts_type, $wtr_custom_posts_taxonomy;
	$wtr_SlugsClasses_Slug		= $WTR_Opt->getopt('wtr_SlugsClasses_Slug');
	$wtr_custom_posts_type[]	= 'classes';
	$wtr_custom_posts_taxonomy[]= 'classes-category';

	$labels= array(
		'name' 					=> __( 'Classes', 'wtr_ct_framework' ),
		'all_items'				=> __( 'All Classes', 'wtr_ct_framework' ),
		'singular_name' 		=> __( 'Classes', 'wtr_ct_framework' ),
		'add_new' 				=> __( 'Add New', 'wtr_ct_framework' ),
		'add_new_item' 			=> __( 'Add New Classes', 'wtr_ct_framework' ),
		'edit_item' 			=> __( 'Edit Classes', 'wtr_ct_framework' ),
		'new_item' 				=> __( 'New Classes', 'wtr_ct_framework' ),
		'view_item' 			=> __( 'View Classes', 'wtr_ct_framework' ),
		'search_items' 			=> __( 'Search Classes', 'wtr_ct_framework' ),
		'not_found' 			=> __( 'No Classes found', 'wtr_ct_framework' ),
		'not_found_in_trash'	=> __( 'No Classes found in Trash', 'wtr_ct_framework' )
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
		'rewrite' 				=> array( 'slug' => $wtr_SlugsClasses_Slug, 'with_front' => true ),
		'supports' 				=> array( 'title', 'editor', 'thumbnail', 'thumbnail','page-attributes', 'excerpt' )
	);
	register_post_type( 'classes', $args );
	register_taxonomy(
		"classes-category", array("classes"), array(
			'public' 			=> true,
			'show_ui' 			=> true,
			'show_tagcloud'		=> true,
			"hierarchical" 		=> true,
			"show_in_nav_menus" => false,
			"rewrite" 			=> true,
			'labels' 			=> array(
				'name' 				=> __( 'Classes Categories', 'wtr_ct_framework' ),
				'singular_name' 	=> __( 'Classes Category', 'wtr_ct_framework' ),
				'edit_item' 		=> __( 'Edit Classes Category', 'wtr_ct_framework' ),
				'search_items'		=> __( 'Search Classes Category' , 'wtr_ct_framework' ),
				'all_items'			=> __( 'All Classes Categories' , 'wtr_ct_framework' ),
				'parent_item'		=> __( 'Parent Classes Category' , 'wtr_ct_framework' ),
				'parent_item_colon'	=> __( 'Parent Classes Category:' , 'wtr_ct_framework' ),
				'edit_item'			=> __( 'Edit Classes Category' , 'wtr_ct_framework' ),
				'update_item'		=> __( 'Update Classes Category' , 'wtr_ct_framework' ),
				'add_new_item'		=> __( 'Add New Classes Category' , 'wtr_ct_framework' ),
				'new_item_name'		=> __( 'New Classes Category Name' , 'wtr_ct_framework' ),
				'menu_name'			=> __( 'Classes Categories' , 'wtr_ct_framework' )
				)
			)
		);
} // end wtr_create_classes
add_action( 'init', 'wtr_create_classes' );


function wtr_single_template_classes( $single ) {
	global $post;

	if ( isset( $post->post_type ) AND "classes" == $post->post_type ){
		$single =  WTR_CP_INCLUDES_DIR . '/single-classes.php';
	}
	return $single;
} // end wtr_single_template_classes
add_filter( 'single_template', 'wtr_single_template_classes' );


// add table column in edit page
function wtr_classes_column($columns){

	$columns = array(
		"cb" 					=> "<input type='checkbox' />",
		"title"					=> __( 'Title', 'wtr_ct_framework' ),
		"classes_duration"		=> __( 'Duration', 'wtr_ct_framework' ),
		"classes_number"		=> __( 'Number of participants', 'wtr_ct_framework' ),
		"classes_trainers"		=> __( 'Trainers', 'wtr_ct_framework' ),
		"classes_gym_location"	=> __( 'Gym Location', 'wtr_ct_framework' ),
		"classes_order"			=> __( 'Order', 'wtr_ct_framework'),
	);
	return $columns;
} // end wtr_classes_column
add_filter("manage_edit-classes_columns", "wtr_classes_column");


//manage posts custom column
function wtr_classes_custom_columns($column){

	global $post;

	switch ($column) {
		case "classes_duration":
			echo get_post_meta( $post->ID, '_wtr_classes_duration', true );
		break;

		case "classes_number":
			echo get_post_meta( $post->ID, '_wtr_classes_number', true );
		break;

		case "classes_trainers":
			$trainers		= get_post_meta( $post->ID, '_wtr_trainers', false );
			$trainers_names	= wtr_get_trainers_metabox( $trainers, true );
			echo implode( $trainers_names, ', ' );
		break;

		case "classes_gym_location":
			$gym_location		= get_post_meta( $post->ID, '_wtr_gym_location', false );
			$gym_location_names	= wtr_get_gym_location_metabox( $gym_location, true );
			echo implode( $gym_location_names, ', ' );
		break;

		case "classes_order":
			echo $post->menu_order;
		break;
	}
} // end wtr_classes_custom_columns
add_action("manage_posts_custom_column", "wtr_classes_custom_columns");


//add meta boxes
function wtr_add_metabox_classes(){

	$current_screen = get_current_screen();

	if( 'classes' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt;

	$wtr_classes_covera_img = new WTR_Upload( array(
			'id'			=> '_wtr_classes_covera_img',
			'title'			=> __( 'Cover image ', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value'			=> '',
			'default_value' => '',
			'info'			=> '',
			'allow'			=> 'all'
		),
		array( 'title_modal' => __( 'Insert image', 'wtr_ct_framework' ) )
	);

	$wtr_classes_duration = new WTR_Text(array(
			'id' 			=> '_wtr_classes_duration',
			'class'			=> '',
			'title' 		=> __( 'Duration', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '60',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_classes_number = new WTR_Text(array(
			'id' 			=> '_wtr_classes_number',
			'class'			=> '',
			'title' 		=> __( 'Number of participants', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$wtr_classes_lvl = new WTR_Select(array(
			'id' 			=> '_wtr_classes_lvl',
			'title' 		=> __( 'Level of difficulty', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '50',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> array_combine( range( 1, 5 ), range( 1, 5)  ),
			'mod' 			=> '',
			)
	);

	$wtr_classes_calories_burned = new WTR_Text(array(
			'id' 			=> '_wtr_classes_calories_burned',
			'class'			=> '',
			'title' 		=> __( 'Calories burned', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	$args = array(
		'posts_per_page'	=> -1,
		'post_type'			=> 'rooms',
		'suppress_filters' => true
	);
	$posts_rooms = get_posts( $args );
	$wtr_posts_rooms = array();

	if( $posts_rooms ){

		foreach ( $posts_rooms as $room ) {
			$wtr_posts_rooms[ $room->ID ] = $room->post_title;
		}
	}

	$wtr_classes_room = new WTR_Select(array(
			'id' 			=> '_wtr_classes_room',
			'title' 		=> __( 'Room', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> $wtr_posts_rooms,
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyPortfolio wtrPageFields">' . __( 'To set class room add Rooms. Go to: Rooms > Add new', 'wtr_ct_framework' ) . '</div>',
			'mod' 			=> '',
			'class'			=> ''
			)
	);

	$wtr_classes_bg_color = new WTR_Color( array(
			'id' => '_wtr_classes_bg_color',
			'class'			=> '',
			'title'			=> 'Calendar entry background color',
			'desc'			=> '',
			'value'			=> 'eb4c4c',
			'default_value'	=> '',
			'info'			=> '',
			'allow'			=> 'color',
		)
	);

	$wtr_classes_font_color = new WTR_Color( array(
			'id' => '_wtr_classes_font_color',
			'class'			=> '',
			'title'			=> 'Calendar entry font color',
			'desc'			=> '',
			'value'			=> 'ffffff',
			'default_value'	=> '',
			'info'			=> '',
			'allow'			=> 'color',
		)
	);

	$wtr_classes_hide = new WTR_Radio( array(
			'id' 			=> '_wtr_classes_hide',
			'title' 		=> __( 'Hide class details in header section', 'wtr_ct_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '0',
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
		)
	);

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

	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_classes_covera_img,
							$wtr_classes_duration,
							$wtr_classes_number,
							$wtr_classes_calories_burned,
							$wtr_classes_lvl,
							$wtr_classes_room,
							$wtr_classes_bg_color,
							$wtr_classes_font_color,
							$wtr_classes_hide
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
						'title' 	=> __('Classes Options', 'wtr_ct_framework' ),
						'page' 		=> 'classes',
						'context' 	=> 'normal',
						'priority' 	=> 'high',
						'sections' 	=> array(
											$wtr_GeneralSections,
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

	//Trainers Right Metabox
	$wtr_trainers_options = wtr_get_trainers_metabox();

	$wtr_trainers = new WTR_Checkbox( array(
			'id'			=> '_wtr_trainers',
			'title'			=> __( 'Trainers', 'wtr_ct_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => '',
			'info'			=> '',
			'allow'			=> 'all',
			'option'		=> $wtr_trainers_options,
			'mod' 			=> 'simple'

		)
	);
	$wtr_GeneralSections = array(
		'id'		=> 'wtr_GeneralSections',
		'name' 		=>__( 'General', 'wtr_ct_framework' ),
		'class'		=> 'General',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_trainers,
					)
	);

	$wtr_trainers_right_meta_settings =
					array(
						'id' 		=> 'wtr-trainers-meta-right-post',
						'title' 	=> __( 'Trainers', 'wtr_ct_framework' ),
						'page' 		=> 'classes',
						'context' 	=> 'side',
						'priority' 	=> 'core',
						'callback'	=> 'render_right_meta_box_content',
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
						'page' 		=> 'classes',
						'context' 	=> 'side',
						'priority' 	=> 'core',
						'callback'	=> 'render_right_meta_box_content',
						'sections' 	=> array(
											$wtr_GeneralSections,
										)
					);

	$wtr_meta_box						= NEW wtr_meta_box( $wtr_meta_settings );
	$wtr_gym_location_right_meta_box	= NEW wtr_meta_box( $wtr_gym_location_right_meta_settings );
	$wtr_trainers_right_meta_box		= NEW wtr_meta_box( $wtr_trainers_right_meta_settings );

} // end wtr_add_metabox_classes
add_action( 'load-post.php', 'wtr_add_metabox_classes' );
add_action( 'load-post-new.php', 'wtr_add_metabox_classes' );
add_action( 'wtr_post_save_classes' , 'wtr_save_metabox_trainers' );
add_action( 'wtr_post_save_classes' , 'wtr_save_metabox_gym_location' );


function wtr_post_settings_single_post_classes( $post_settings_single ){

	$post_settings_single = array(
		'wtr_classes_bg_color'		=> '_wtr_classes_bg_color',
		'wtr_classes_font_color'	=> '_wtr_classes_font_color',
		'wtr_classes_hide'			=> '_wtr_classes_hide',
		'wtr_classes_covera_img'	=> '_wtr_classes_covera_img',
		'wtr_classes_duration'		=> '_wtr_classes_duration',
		'wtr_classes_number'		=> '_wtr_classes_number',
		'wtr_classes_kcal'			=> '_wtr_classes_calories_burned',
		'wtr_classes_lvl'			=> '_wtr_classes_lvl',
		'wtr_classes_room'			=> '_wtr_classes_room',
		'wtr_classes_desc'			=> '_wtr_classes_desc',
		'wtr_classes_trainers'		=> array( 'value' => '_wtr_trainers', 'single' => false ),
		'wtr_CustomCssForPage'		=> '_wtr_CustomCssForPage',
		'wtr_SeoTitle'				=> '_wtr_SeoTitle',
		'wtr_SeoDescription'		=> '_wtr_SeoDesc',
		'wtr_SeoKeywords'			=> '_wtr_SeoKey',
		'wtr_NoRobot'				=> '_wtr_NoRobot',
	);
	return $post_settings_single;

} // end wtr_post_settings_single_post_classes
add_filter( 'wtr_post_settings_single_post_classes', 'wtr_post_settings_single_post_classes', 10, 2 );