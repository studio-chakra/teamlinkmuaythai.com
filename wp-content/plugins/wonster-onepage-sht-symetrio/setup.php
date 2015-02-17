<?php

/*
Plugin Name: Wonster OnePage - Symetrio Edition
Plugin URI:
Description:
Version: 1.0
Author: Wonster
Author URI: http://wonster.co
*/

if (!defined('ABSPATH')) exit;

//====== basic wonster shortcode =========
define( 'WTR_OP_PLUGIN_FILE', __FILE__ );
define( 'WTR_OP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WTR_OP_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

define( 'WTR_OP_LANG_URI', WTR_OP_PLUGIN_URI . 'languages' );
define( 'WTR_OP_LANG_DIR', WTR_OP_PLUGIN_DIR . 'languages' );

define( 'WTR_OP_PLUGIN_ADMIN_URI', WTR_OP_PLUGIN_URI . 'wtr-admin' );
define( 'WTR_OP_PLUGIN_ADMIN_DIR', WTR_OP_PLUGIN_DIR . 'wtr-admin' );

define( 'WTR_OP_FN_URI', WTR_OP_PLUGIN_URI . 'functions' );
define( 'WTR_OP_FN_DIR', WTR_OP_PLUGIN_DIR . 'functions' );
// translations
load_theme_textdomain( 'WTR_OP_framework', WTR_OP_LANG_DIR );

require_once( WTR_OP_FN_DIR . '/functions.php' );
require_once( WTR_OP_FN_DIR . '/sht.php' );