<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }


//add meta boxes
function wtr_add_metabox_page(){

	$current_screen = get_current_screen();

	if( 'page' != $current_screen->post_type ){
		return;
	}

	global $WTR_Opt;

	$wtr_SidebarPosition = new WTR_Radio_Img( array(
			'id' 			=> '_wtr_SidebarPosition',
			'title' 		=> __( 'Sidebar position', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_SidebarPositionOnSinglePage' ),
			'info' 			=> '',
			'allow' 		=> 'all',
			'checked' 		=> 'sideChecked',
			'class' 		=> 'sideSetter wtrPageFields',
			'option' 		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
		)
	);

	$wtr_Sidebar = new WTR_Select(array(
			'id' 			=> '_wtr_Sidebar',
			'title' 		=> __( 'Sidebar', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_SidebarPickOnSinglePage' ),
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> $WTR_Opt->getopt( 'wtr_SidebraManagement' ) ,
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyEvents wtrPageFields">' . __( 'To set sidebar use "Siedebar management". Go to: Apperance > Theme Options > General > Sidebar', 'wtr_framework' ) . '</div>',
			'mod' 			=> '',
			'class'			=> 'wtrOnlyEvents wtrPageFields'
			)
	);

	//wtr_nav_menu
	$nav_menus		= wp_get_nav_menus( array('orderby' => 'name') );
	$wtr_nav_menus	= array(
							'none'	=> __( 'None', 'wtr_framework' ),
							0		=> __( 'Default', 'wtr_framework' ),
							);

	foreach ( $nav_menus as  $nav_menu) {
		$wtr_nav_menus[ $nav_menu->term_id ] = $nav_menu->name;
	}

	$wtr_Boxed = new WTR_Radio( array(
			'id'			=> '_wtr_Boxed',
			'title'			=> __( 'Boxed style', 'wtr_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_GlobalBoxed' ),
			'info'			=> '',
			'allow'			=> 'int',
			'option' 	=> array( '1' => 'On' , '0' => 'Off' ),
		)
	);

	$wtr_clean_menu_mod = new WTR_Radio( array(
			'id'			=> '_wtr_clean_menu_mod',
			'title'			=> __( 'Enable clean menu mode', 'wtr_framework' ),
			'desc'			=> __( 'This option allows you to hide additional menu icons like: </br> Search icon, WooCommerce cart (if installed), WPML select (if installed)', 'wtr_framework' ),
			'value'			=> '',
			'default_value' => '0',
			'info'			=> '',
			'allow'			=> 'int',
			'option'		=> array( '1' => 'On' , '0' => 'Off' ),
		)
	);

	$wtr_transparent_mode = new WTR_Radio( array(
			'id'			=> '_wtr_transparent_mode',
			'title'			=> __( 'Enable transparent mode', 'wtr_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => '0',
			'info'			=> '',
			'allow'			=> 'int',
			'option'		=> array( '1' => 'On' , '0' => 'Off' ),
		)
	);

	$wtr_BackgroundImg = new WTR_Img_Sortable( array(
			'id'			=> '_wtr_BackgroundImg',
			'class'			=> '',
			'title'			=> __( 'Animated background  item', 'wtr_framework' ),
			'desc'			=> __( 'Select the photos to appear in the background of the page. If you select more than one photo will be used fade effect between them.', 'wtr_framework' ),
			'value'			=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_GlobalPageBackgroundImg' ),
			'info'			=> '',
			'allow'			=> 'all',
			'no_default'	=> 1,
			),
			array('target_type' => 'multi-img',
				  'title_modal' => __( 'Insert image url or select file from media library', 'wtr_framework' ) )
	);

	$wtr_page_nav_menu = new WTR_Select(array(
			'id' 			=> '_wtr_page_nav_menu',
			'title' 		=> __( 'Page menu', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => 0,
			'info' 			=> '',
			'allow' 		=> 'all',
			'option' 		=> $wtr_nav_menus,
			'mod' 			=> '',
			)
	);

	$wtr_HeaderSettings = new WTR_Select( array(
			'id'			=> '_wtr_HeaderSettings',
			'title'			=> __( 'Header settings', 'wtr_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_HeaderSettings' ),
			'info'			=> '',
			'allow'			=> 'int',
			'mod' 			=> '',
			'option'		=> array(
										'0' => __( 'Off', 'wtr_framework' ),
										'1' => __( 'Show menu', 'wtr_framework' ),
										'2' => __( 'Show menu &#43; socials', 'wtr_framework' ),
										'3' => __( 'Simplified menu', 'wtr_framework' )
										),
		)
	);

	$wtr_BreadCrumbsContainer = new WTR_Radio( array(
			'id' 			=> '_wtr_BreadCrumbsContainer',
			'title' 		=> __( 'Breadcrumbs container', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_BlogBreadCrumbsContainer' ),
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'class'			=> ''
		)
	);

	$wtr_BreadCrumbs = new WTR_Radio( array(
			'id' 			=> '_wtr_BreadCrumbs',
			'title' 		=> __( 'Breadcrumbs', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_BlogBreadCrumbs' ),
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'class'			=> ''
		)
	);

	$wtr_FooterSettings = new WTR_Select( array(
			'id'			=> '_wtr_FooterSettings',
			'title'			=> __( 'Footer Settings', 'wtr_framework' ),
			'desc'			=> '',
			'value'			=> '',
			'default_value' => $WTR_Opt->getopt( 'wtr_FooterSettings' ),
			'info'			=> '',
			'allow'			=> 'int',
			'mod' 			=> '',
			'option'		=> array(
										'0' => __( 'Off', 'wtr_framework' ),
										'1' => __( 'Show widget', 'wtr_framework' ),
										'2' => __( 'Show copyright', 'wtr_framework' ),
										'3' => __( 'Show copyright &#43; widget', 'wtr_framework' )
										),
		)
	);

	$wtr_SeoTitle = new WTR_Text(array(
			'id' 			=> '_wtr_SeoTitle',
			'class' 		=> '',
			'title' 		=> __( 'SEO tittle', 'wtr_framework' ),
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
			'title' 		=> __( 'SEO description', 'wtr_framework' ),
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
			'title' 		=> __( 'SEO keywords', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
			)
	);

	$wtr_NoRobot = new WTR_Radio( array(
			'id' 			=> '_wtr_NoRobot',
			'title' 		=> __( 'Robots meta tag', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '0',
			'info' 			=> '',
			'allow' 		=> 'int',
			'option' 		=> array( '1' => 'On' , '0' => 'Off' ),
			'mod' 			=> 'robot',
			'meta' 			=> '<div class="WtrNoneSidebarDataInfo wtrOnlyEvents wtrPageFields">' . __( 'Site has No Robot attribute ', 'wtr_framework' ) . '</div>',
		)
	);

	$wtr_CustomCssForPage = new WTR_Textarea( array(
			'id' 			=> '_wtr_CustomCssForPage',
			'class' 		=> '',
			'rows' 			=> 10,
			'title' 		=> __( 'Custom css for page', 'wtr_framework' ),
			'desc' 			=> '',
			'value' 		=> '',
			'default_value' => '',
			'info' 			=> '',
			'allow' 		=> 'all',
		)
	);

	require_once( WTR_ADMIN_CLASS_DIR . '/wtr_meta_box.php' );

	$wtr_LayoutSections = array(
		'id'		=> 'wtr_LayoutSections',
		'name' 		=>__( 'Layout', 'wtr_framework' ),
		'class'		=> 'Layout',
		'active_tab'=> true,
		'fields'	=> array(
							$wtr_Boxed,
							$wtr_clean_menu_mod,
							$wtr_transparent_mode,
							$wtr_BackgroundImg,
							$wtr_page_nav_menu,
							$wtr_HeaderSettings,
							$wtr_BreadCrumbsContainer,
							$wtr_BreadCrumbs,
							$wtr_FooterSettings
					)
	);

	$wtr_SidebarSections = array(
		'id'		=> 'wtr_SidebarSections',
		'name' 		=>__( 'Sidebar', 'wtr_framework' ),
		'class'		=> 'Sidebar',
		'exclusion'	=> 'wtrOnlyEventsTabs wtrOnlyOnePageTabs',
		'fields'	=> array(
							$wtr_SidebarPosition,
							$wtr_Sidebar,
					)
	);

	$wtr_CssSections = array(
		'id'		=> 'wtr_CssSections',
		'name' 		=>__( 'CSS', 'wtr_framework' ),
		'class'		=> 'CSS',
		'fields'	=> array(
							$wtr_CustomCssForPage
					)
	);


	$wtr_meta_settings =
					array(
						'id' 		=> 'wtr-meta-page',
						'title' 	=> __( 'Page Options', 'wtr_framework' ),
						'page' 		=> 'page',
						'context' 	=> 'normal',
						'priority' 	=> 'default',
						'sections' 	=> array(
											$wtr_LayoutSections,
											$wtr_SidebarSections,
											$wtr_CssSections,
										)
					);

	// Add seo fields
	if ( 1 ==  $WTR_Opt->getopt( 'wtr_SeoSwich' ) ) {
		$wtr_SEOSections = array(
			'id'		=> 'wtr_SEOSections',
			'name' 		=>__( 'SEO', 'wtr_framework' ),
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

	$wtr_meta_box = NEW wtr_meta_box( $wtr_meta_settings );
} // end wtr_add_metabox_page
add_action( 'load-post.php', 'wtr_add_metabox_page' );
add_action( 'load-post-new.php', 'wtr_add_metabox_page' );