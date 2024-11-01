<?php
/*
	Plugin Name: WP Share To Unlock Standard
	Plugin URI: http://www.wpsharetounlock.com/
	Description: With a single click you can lock certain part of the post/page content, which visitor can unlock by clicking Facebook LIKE button. Once people click the button, the content will be displayed. This will help you to engage your audience to take action on your website, will increase social proof via LIKE count and will generate viral traffic from Facebook.
	Version: 0.2.3.0
	Author: Peter Garety
	Author URI:  http://www.petergarety.com
*/

// <<<<<<<<<<<< includes --------------------------------------------------
require_once(dirname(__FILE__).'/shtu-config.php');
require_once(SHTU_PLUGIN_PATH.'/shtu-loader.php');
define('SHTU_PLUGIN_NAME',SHTU_PLUGIN_FOLDER.'/'.basename(__FILE__));

// define plugin name (path)
define('SHTU_PLUGIN_NAME',SHTU_PLUGIN_FOLDER.'/'.basename(__FILE__));

SHTU_Loader::includeMainClass();
$shtu = 'SHTU_MainClass';


// >>>>>>>>>>>> -----------------------------------------------------------      

// <<<<<<<<<<<< functions -------------------------------------------------
/**
 * Initialize plugin environment
 */ 
add_action('init', array($shtu, 'init'));
add_action('wp_print_scripts', array($shtu, 'printJsLanguage'));
add_filter('plugin_row_meta', array($shtu,'set_update_plugin_meta_links'), 10, 2 );
add_action('plugins_loaded', array($shtu,'onPluginLoaded'));
/**
 * Add plugin menu items
 */
add_action('admin_menu', array($shtu, 'addMenuItems'));


/**
 * On Plugin activation
 */ 
register_activation_hook(__FILE__, array($shtu, 'onActivation'));
/**
 * On Plugin deactivation
 */
register_deactivation_hook(__FILE__, array($shtu, 'onDeactivation'));
// >>>>>>>>>>>> -----------------------------------------------------------

add_shortcode('share-to-unlock', array($shtu,'shareToUnlockHandler'));

add_filter('the_content',  array($shtu,'postContentFilter'));

add_action( 'save_post', array($shtu, 'removeShortcodes'));

add_action('admin_init', array($shtu, 'registerShareButton'));

?>