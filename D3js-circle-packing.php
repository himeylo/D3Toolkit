<?php
/*
 * Plugin Name: TTI Strategies
 * Plugin URI: https://github.com/ttitamu/d3js-circle-packing
 * Description: Adds default Strategy CPT to Carteeh's genesis child theme.
 * Author: Jamie McKinnerney, TTI Communications
 * Author URI: https://github.com/ttitamu
 */

if ( !defined( 'ABSPATH' ) ) {
	die( "Sorry, you are not allowed to access this page directly." );
}

/**
 * Action on the plugins_loaded hook.
 * Invokes the load_plugin_textdomain() function to support i18 translation strings.
 *
 * @access public
 * @static
 * @return void
 */
function tti_strategies_text_domain() {
	load_plugin_textdomain( 'd3js-circle-packing', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'tti_strategies_text_domain' );

/**
 * Registered autoload function.
 * Used to load class files automatically if they are in the provided array.
 *
 * @access public
 * @param string $class
 * @return void
 */
function tti_autoloader($class) {

	$classes = array(
		'TTI_Strategies'               => 'class.TTI_Strategies.php',
		'TTI_Strategies_Activation'    => 'class.TTI_Strategies_Activation.php',
		'TTI_Strategies_Metabox'       => 'class.TTI_Strategies_Metabox.php',
		'TTI_Strategies_Messages'      => 'class.TTI_Strategies_Messages.php',
		'TTI_Strategies_Strategy_Meta' => 'class.TTI_Strategies_Strategy_Meta.php',
		'TTI_Strategies_CPT'           => 'class.TTI_Strategies_CPT.php',
		'TTI_Strategies_Save'          => 'class.TTI_Strategies_Save.php',
		'TTI_Strategies_Template'      => 'class.TTI_Strategies_Template.php',
		'TTI_Strategies_Widget'        => 'class.TTI_Strategies_Widget.php',
		'TTI_Strategies_Widget_Admin'  => 'class.TTI_Strategies_Widget_Admin.php',
		'TTI_Strategies_Widget_Output' => 'class.TTI_Strategies_Widget_Output.php'
	);

	if( isset( $classes[$class] ) ) {
		require_once( TTI_STRATEGIES_CLASSES_DIR . $classes[$class] );
	}

}
spl_autoload_register( 'tti_autoloader' );

register_activation_hook( __FILE__, array( 'TTI_Strategies_Activation', 'activate' ) );

define( 'TTI_STRATEGIES_CLASSES_DIR'  		, dirname( __FILE__ ) . '/classes/'   );
define( 'TTI_STRATEGIES_FUNCTIONS_DIR'		, dirname( __FILE__ ) . '/functions/'    );
define( 'TTI_STRATEGIES_TEMPLATES_DIR'		, dirname( __FILE__ ) . '/templates/' 	 );

define( 'TTI_STRATEGIES_FRAMEWORK_DIR', plugin_dir_url( __FILE__ ) . 'framework/' 	 );
define( 'TTI_INDICATORS_FRAMEWORK_DIR', plugin_dir_url( __FILE__ ) . 'framework-indicators/' 	 );
define( 'TTI_TOOLS_FRAMEWORK_DIR', plugin_dir_url( __FILE__ ) . 'framework-tools/' 	 );

define( 'TTI_STRATEGIES_RELATIONSHIP_DIR', plugin_dir_url( __FILE__ ) . 'relationship/' );
define( 'TTI_INDICATORS_RELATIONSHIP_DIR', plugin_dir_url( __FILE__ ) . 'relationship-indicators/' );
define( 'TTI_TOOLS_RELATIONSHIP_DIR', plugin_dir_url( __FILE__ ) . 'relationship-tools/' );

define( 'TTI_STRATEGIES_RESOURCES_URL', plugin_dir_url( __FILE__ ) . 'resources/'  );
// set version for enqueuing styles
define( 'TTI_PLUGIN_VERSION', '1.0.4' );

add_action( 'init', array( 'TTI_Strategies_CPT', 'init' ), 1 );

add_action( 'genesis_init', 'tti_strategies_init' );
/**
 * Action added on the genesis_init hook.
 * All actions except the init and activate hook are loaded through this function.
 * This ensures that Genesis is available for any Genesis functions that will be used.
 *
 * @access public
 * @return void
 */
function tti_strategies_init() {

	$archive_page_hook = sprintf( 'load-%1$s_page_genesis-cpt-archive-%1$s', 'strategies' );

	add_filter( 'template_include', array( 'TTI_Strategies_Template', 'maybe_include_template' ) );

	add_action( 'init'                      , array( 'TTI_Strategies_CPT', 'maybe_remove_genesis_sidebar_form' ), 11    );
	add_action( 'admin_init'                , array( 'TTI_Strategies_CPT', 'remove_genesis_layout_options'     ), 11    );
	// Display admin notifications.
	add_action( 'admin_notices'							, array( 'TTI_Strategies'		 , 'admin_notices' 										 ) );
	add_action( 'after_setup_theme'         , array( 'TTI_Strategies_CPT', 'maybe_add_image_size'              )        );
	add_action( 'load-post.php'             , array( 'TTI_Strategies'    , 'maybe_do_strategy_meta'            )        );
	add_action( 'load-post-new.php'         , array( 'TTI_Strategies'    , 'maybe_do_strategy_meta'            )        );
	add_action( 'load-edit-tags.php'        , array( 'TTI_Strategies'    , 'maybe_enqueue_scripts'             )        );
	add_action( $archive_page_hook          , array( 'TTI_Strategies'    , 'maybe_enqueue_scripts'             )        );
	add_filter( 'bulk_post_updated_messages', array( 'TTI_Strategies'    , 'bulk_updated_messages'             ), 10, 2 );
	add_action( 'save_post'                 , array( 'TTI_Strategies'    , 'maybe_do_save'                     ), 10, 2 );
	add_action( 'widgets_init'              , array( 'TTI_Strategies'    , 'widgets_init'                      )        );

}


/* function debug_to_console($data) {
	$output = $data;
	if (is_array($output))
			$output = implode(',', $output);

	echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
} */
