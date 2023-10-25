<?php
/*
 * Plugin Name: D3 Toolkit WP Plugin
 * Plugin URI: https://github.com/himeylo/d3-toolkit
 * Description: Sets up the D3 Toolkit WP plugin.
 * Author: Jamie Leigh
 * Author URI: https://github.com/himeylo
 */

if (!defined('ABSPATH')) {
	die("Sorry, you are not allowed to access this page directly.");
}

/**
 * Action on the plugins_loaded hook.
 * Invokes the load_plugin_textdomain() function to support i18 translation strings.
 *
 * @access public
 * @static
 * @return void
 */
function d3toolkit_text_domain()
{
	load_plugin_textdomain('d3-toolkit', false, basename(dirname(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'd3toolkit_text_domain');

/**
 * Registered autoload function.
 * Used to load class files automatically if they are in the provided array.
 *
 * @access public
 * @param string $class
 * @return void
 */
function d3toolkit_autoloader($class)
{

	$classes = array(
		'D3Toolkit'               => 'class.D3Toolkit.php',
		'D3Toolkit_Activation'    => 'class.D3Toolkit_Activation.php',
		'D3Toolkit_Metabox'       => 'class.D3Toolkit_Metabox.php',
		'D3Toolkit_Messages'      => 'class.D3Toolkit_Messages.php',
		'D3Toolkit_Strategy_Meta' => 'class.D3Toolkit_Strategy_Meta.php',
		'D3Toolkit_CPT'           => 'class.D3Toolkit_CPT.php',
		'D3Toolkit_Save'          => 'class.D3Toolkit_Save.php',
		'D3Toolkit_Template'      => 'class.D3Toolkit_Template.php',
		'D3Toolkit_Widget'        => 'class.D3Toolkit_Widget.php',
		'D3Toolkit_Widget_Admin'  => 'class.D3Toolkit_Widget_Admin.php',
		'D3Toolkit_Widget_Output' => 'class.D3Toolkit_Widget_Output.php'
	);

	if (isset($classes[$class])) {
		require_once(D3TOOLKIT_CLASSES_DIR . $classes[$class]);
	}
}
spl_autoload_register('d3toolkit_autoloader');

register_activation_hook(__FILE__, array('D3Toolkit_Activation', 'activate'));

define('D3TOOLKIT_CLASSES_DIR', dirname(__FILE__) . '/classes/');
define('D3TOOLKIT_FUNCTIONS_DIR', dirname(__FILE__) . '/functions/');
define('D3TOOLKIT_TEMPLATES_DIR', dirname(__FILE__) . '/templates/');

define('D3TOOLKIT_FRAMEWORK_DIR', plugin_dir_url(__FILE__) . 'framework/');
define('D3TOOL2_FRAMEWORK_DIR', plugin_dir_url(__FILE__) . 'framework-indicators/');
define('D3TOOL3_FRAMEWORK_DIR', plugin_dir_url(__FILE__) . 'framework-tools/');

define('D3TOOLKIT_RELATIONSHIP_DIR', plugin_dir_url(__FILE__) . 'relationship/');
define('D3TOOL2_RELATIONSHIP_DIR', plugin_dir_url(__FILE__) . 'relationship-indicators/');
define('D3TOOL3_RELATIONSHIP_DIR', plugin_dir_url(__FILE__) . 'relationship-tools/');

define('D3TOOLKIT_RESOURCES_URL', plugin_dir_url(__FILE__) . 'resources/');
// set version for enqueuing styles
define('D3TOOLS_PLUGIN_VERSION', '1.0.4');

add_action('init', array('D3Toolkit_CPT', 'init'), 1);

add_action('genesis_init', 'd3toolkit_init');
/**
 * Action added on the genesis_init hook.
 * All actions except the init and activate hook are loaded through this function.
 * This ensures that Genesis is available for any Genesis functions that will be used.
 *
 * @access public
 * @return void
 */
function d3toolkit_init()
{

	$archive_page_hook = sprintf('load-%1$s_page_genesis-cpt-archive-%1$s', 'strategies');

	add_filter('template_include', array('D3Toolkit_Template', 'maybe_include_template'));

	add_action('init', array('D3Toolkit_CPT', 'maybe_remove_genesis_sidebar_form'), 11);
	add_action('admin_init', array('D3Toolkit_CPT', 'remove_genesis_layout_options'), 11);
	// Display admin notifications.
	add_action('admin_notices', array('D3Toolkit', 'admin_notices'));
	add_action('after_setup_theme', array('D3Toolkit_CPT', 'maybe_add_image_size'));
	add_action('load-post.php', array('D3Toolkit', 'maybe_do_strategy_meta'));
	add_action('load-post-new.php', array('D3Toolkit', 'maybe_do_strategy_meta'));
	add_action('load-edit-tags.php', array('D3Toolkit', 'maybe_enqueue_scripts'));
	add_action($archive_page_hook, array('D3Toolkit', 'maybe_enqueue_scripts'));
	add_filter('bulk_post_updated_messages', array('D3Toolkit', 'bulk_updated_messages'), 10, 2);
	add_action('save_post', array('D3Toolkit', 'maybe_do_save'), 10, 2);
	add_action('widgets_init', array('D3Toolkit', 'widgets_init'));
}


/* function debug_to_console($data) {
	$output = $data;
	if (is_array($output))
			$output = implode(',', $output);

	echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
} */
