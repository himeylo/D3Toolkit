<?php
/**
 * This file contains functions used in the creation of the TTI Strategies template files.
 *
 * @author TTI Communications
 * @package TTI Strategies
 * @subpackage Template
 */

/**
 * Gets the strategy meta data value from the provided key.
 * If the value is not available it will return false
 *
 * @access public
 * @param string $key
 * @return mixed boolean/string
 */
function tti_strategies_get_strategy_meta( $key, $post_id = '' ){

	$post_id =  $post_id ? $post_id : get_the_ID();

	$tti_strategies_strategy_meta = get_post_meta( $post_id, '_tti_strategies', true );

	if( empty( $tti_strategies_strategy_meta[$key] ) ){
		return false;
	}

	return $tti_strategies_strategy_meta[$key];

}

/**
 * Wrapper function to echo tti_strategies_get_strategy_meta().
 * It will return the value if set or returns false if not set.
 *
 * @access public
 * @param string $key
 * @return mixed boolean/string
 */
function tti_strategies_strategy_meta( $key ){

	if( $value = tti_strategies_get_strategy_meta( $key ) ) {

		echo $value;

		return $value;

	}

	return false;

}

/**
 * Removes all the actions on the entry hooks.
 *
 * @access public
 * @return void
 */
function tti_strategies_remove_all_entry_actions(){

	$hooks = array(
		'genesis_before_entry',
		'genesis_entry_header',
		'genesis_before_entry_content',
		'genesis_entry_content',
		'genesis_after_entry_content',
		'genesis_entry_footer',
		'genesis_after_entry',
	);

	foreach( $hooks as $hook ){
		remove_all_actions( $hook );
	}

}

/**
 * Loads the default style sheets.
 *
 * @access public
 * @return void
 */
function tti_strategies_load_default_styles() {

	if( apply_filters( 'tti_strategies_load_default_styles', true ) ) {

		wp_register_style( 'd3js-circle-packing-css',
			TTI_STRATEGIES_RESOURCES_URL . 'css/style.css',
			array(),
			TTI_PLUGIN_VERSION
		);
		wp_enqueue_style( 'd3js-circle-packing-css' );

		wp_enqueue_style( 'strategies-fonts', 'https://use.typekit.net/asf8jgz.css' );
	}

}

// Loads and enqueues scripts

function tti_strategies_load_scripts() {

	if ( apply_filters( 'tti_strategies_load_scripts', true ) ) {
		wp_register_style( 'd3js-circle-packing-js',
			TTI_STRATEGIES_RESOURCES_URL . 'js/app.min.js',
			array( 'jquery' ),
			filemtime( TTI_STRATEGIES_RESOURCES_URL . 'js/app.min.js',
			true )
		);
	wp_enqueue_style( 'd3js-circle-packing-js' );

	}

}


/**
 * Removes all entry actions and setup the tti_strategies archive entry actions.
 *
 * @access public
 * @return void
 */
function tti_strategies_setup_archive_loop(){

	//remove all actions from the entry section to setup the loop
	tti_strategies_remove_all_entry_actions();

	add_action( 'genesis_entry_content'      , 'tti_strategies_grid'               );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_open' , 5  );
	add_action( 'genesis_after_entry_content', 'genesis_do_post_title'                 );
	add_action( 'genesis_after_entry_content', 'tti_strategies_do_by_line'    , 12 );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_close', 15 );

}

/**
 * Removes all entry actions and setup the tti_strategies archive single actions.
 *
 * @access public
 * @return void
 */
function tti_strategies_setup_single_loop(){

	//remove all actions from the entry section to setup the loop
	tti_strategies_remove_all_entry_actions();


	add_action( 'genesis_before_entry_content', 'genesis_entry_header_markup_open' , 5  );
	add_action( 'genesis_before_entry_content', 'genesis_do_post_title'                 );
	add_action( 'genesis_before_entry_content', 'tti_strategies_do_by_line'    , 12 );
	add_action( 'genesis_before_entry_content', 'genesis_entry_header_markup_close', 15 );
	add_action( 'genesis_entry_content'       , 'tti_strategies_single_content'     );
	add_action( 'genesis_entry_content'       , 'genesis_do_post_content_nav'      , 12 );
	add_action( 'genesis_after_entry_content' , 'tti_strategies_strategy_footer'        );

}

/**
 * Adds the 'd3js-circle-packing' body class.
 *
 * @access public
 * @param array $classes
 * @return array
 */
function tti_strategies_add_body_class( $classes ) {

	if ( is_singular('strategy') || is_singular('indicator') || is_singular('tool') ) {
		$classes[] = 'smart-single';
	}
	else {
		$classes[] = 'd3js-circle-packing smart-framework';
	}

	return $classes;

}

/**
 * Adds the 'tti-strategy' entry class.
 *
 * @access public
 * @param array $classes
 * @return array
 */
function tti_strategies_custom_post_class( $classes ) {

	if (is_main_query()) {
		$classes[] = 'tti-strategy smart-framework';
	}

	return $classes;

}

/**
 * Creates the grid output used on strategy archives.
 *
 * @access public
 * @return void
 */
function tti_strategies_grid() {

	if ( $image = genesis_get_image( 'format=url&size=tti-strategy-image' ) ) {

		$banner = ( $text = tti_strategies_get_strategy_meta( 'featured_text' ) ) ? sprintf( '<span class="strategy-featured-text-banner">%s</span>', $text ) : '';

		printf( '<div class="tti-strategy-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a>%s</div>', get_permalink(), $image, the_title_attribute( 'echo=0' ), $banner );

	}

}

/**
 * Outputs the single content markup.
 *
 * @uses tti_strategies_strategy_details()
 * @access public
 * @return void
 */
function tti_strategies_single_content(){

	echo '<div class="one-third d3js-circle-packing-strategy-details">';
	tti_strategies_strategy_details();
	echo '</div>';

	echo '<div class="two-thirds first d3js-circle-packing-strategy-description">';
	the_content();
	echo '</div>';

	echo '<br class="clear" />';

}

/**
 * Builds the strategy details.
 *
 * @access public
 * @param string $post_id (default: '')
 * @return string
 */
function tti_strategies_get_strategy_details( $post_id = '' ){

	$strategy_meta = array();

	$strategy_meta[] = ( $opt = tti_strategies_get_formated_meta( __( 'Guidance for Implementation'   , 'd3js-circle-packing' ), 'implementation', $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';
	$strategy_meta[] = ( $opt = tti_strategies_get_formated_meta( __( 'Editor'      , 'd3js-circle-packing' ), 'editor'   , $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';
	$strategy_meta[] = ( $opt = tti_strategies_get_formated_meta( __( 'Edition'     , 'd3js-circle-packing' ), 'edition'  , $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';
	$strategy_meta[] = ( $opt = tti_strategies_get_formated_meta( __( 'Available in', 'd3js-circle-packing' ), 'available', $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';
	$strategy_meta[] = ( $opt = tti_strategies_get_formated_meta( __( 'Impact'        , 'd3js-circle-packing' ), 'impact'     , $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';

	$strategy_meta[] = ( $opt = tti_strategies_get_publication_date( $post_id ) ) ? sprintf( '<li>%s</li>', $opt ) : '';

	foreach( $strategy_meta as $key => $value ){
		if( empty( $value ) ){
			unset( $strategy_meta[$key] );
		}
	}

	$details = '<div class="strategy-details">';

	$details .= tti_strategies_get_strategy_image( $post_id );

	$details .= tti_strategies_get_price( $post_id );

	if( ! empty( $strategy_meta ) ){

		$details .= sprintf( '<ul class="strategy-details-meta">%s</ul>', implode( '', $strategy_meta ) );

	}

	$details .= tti_strategies_get_buttons( $post_id );

	$details .= '</div>';

	return $details;

}

/**
 * Wrapper function to echo the strategy details.
 *
 * @uses tti_strategies_get_strategy_details()
 * @access public
 * @param string $post_id (default: '')
 * @return void
 */
function tti_strategies_strategy_details( $post_id = '' ) {

	echo tti_strategies_get_strategy_details( $post_id );

}

/**
 * Gets the strategy image if available and
 * wraps the image in standard markup for the strategy styling.
 * Also includes the featured text banner if set.
 *
 * @access public
 * @param string $post_id (default: '')
 * @return string
 */
function tti_strategies_get_strategy_image(){

	if ( $image = genesis_get_image( array( 'format' => 'url', 'size' => 'tti-strategy-image' ) ) ) {

		$banner = ( $text = tti_strategies_get_strategy_meta( 'featured_text' ) ) ? sprintf( '<div class="strategy-featured-text-banner">%s</div>', $text ) : '';

		$image = sprintf( '<div class="tti-strategy-featured-image"><img src="%s" alt="%s" />%s</div>', $image, the_title_attribute( 'echo=0' ), $banner );

	}

	return $image;
}

/**
 * Outputs the "by" with a link to the Author Archive.
 *
 * @access public
 * @return void
 */
function tti_strategies_do_by_line(){

	global $TTI_Strategies_CPT;

	$terms = wp_get_post_terms( get_the_ID(), $TTI_Strategies_CPT->objective );

	if( empty( $terms ) || is_wp_error( $terms ) ){
		return;
	}

	$objectives = array();

	foreach( $terms as $term ){

		$objectives[] = sprintf( '<a class="strategy-objective-link %s" href="%s">%s</a>', $term->slug, esc_url( get_term_link( $term ) ), $term->name );

	}

	/*
		This uses a couple of joins and array_slices to put the array together with commas and the word "and" without the oxford comma.
		It should make the list of objectives work grammatically with 1, 2 or 3+ objectives for most Western languages.
		This needs to be cleaned up for correct translation into non western languages.
	*/
	if( ! empty( $objectives ) ){
		printf(
			'<p class="strategy-objective">%s%s</p>',
			__( 'Objective: ', 'd3js-circle-packing' ),
			join(
				__( ' and ', 'd3js-circle-packing' ),
				array_filter(
					array_merge(
						array( join( __( ', ', 'd3js-circle-packing' ), array_slice( $objectives, 0, -1 ) ) ),
						array_slice( $objectives, -1 )
					)
				)
			)
		);
	}

}

/**
 * Outputs the entry <footer> for the strategy.
 * Includes Series and Tag terms
 *
 * @access public
 * @return void
 */
function tti_strategies_strategy_footer() {

	global $TTI_Strategies_CPT;

	$footer_meta = do_shortcode( apply_filters( 'tti_strategies_footer_meta', sprintf(
				'[post_terms taxonomy="%s" before="%s"][post_terms taxonomy="%s" before="<br> %s"]',
				$TTI_Strategies_CPT->phase,
				__( 'Project Lifecycle Phase: ', 'd3js-circle-packing'),
				$TTI_Strategies_CPT->theme,
				__( 'Themes: ', 'd3js-circle-packing' )
			) ) );

	if( $footer_meta ){
		printf( '<footer class="entry-footer"><p class="entry-meta">%s</p></footer>', $footer_meta );
	}

}

/**
 * Formats provided meta data into a standard HTML markup.
 *
 * @access public
 * @param string $label
 * @param string $meta
 * @param string $class
 * @return string
 */
function tti_strategies_format_meta( $label, $meta, $class ){

	return sprintf(
		'<span class="d3js-circle-packing-meta-detail %s"><span class="label">%s: </span><span class="meta">%s</span></span>',
		$class,
		$label,
		$meta
	);

}

/**
 * Gets the indicated meta and formats it if available.
 * Returns false if meta not set.
 *
 * @uses tti_strategies_get_formated_meta()
 * @access public
 * @param string $label
 * @param string $key
 * @param string $post_id (default: '')
 * @return mixed boolean/string
 */
function tti_strategies_get_formated_meta( $label, $key, $post_id = '' ){

	$meta  = tti_strategies_get_strategy_meta( $key, $post_id );
	$class = $key;

	return empty( $meta ) ? false : tti_strategies_format_meta( $label, $meta, $class );

}

/**
 * Builds the price output from strategy meta if available.
 * Returns false if meta is not available.
 * Wraps price in a span with class="strategy-price".
 *
 * @access public
 * @param string $post_id (default: '')
 * @return mixed boolean/string
 */
function tti_strategies_get_price( $post_id = '' ){

	$meta  = tti_strategies_get_strategy_meta( 'price', $post_id );

	return empty( $meta ) ? false : sprintf( '<span class="strategy-price">%s</span>', $meta );

}

/**
 * Builds the publication date from strategy meta if available.
 * Returns false if no meta available.
 * Checks the publication date against current time stamp and changes label from Available to Published if strategy has already been published.
 * Formats date using date_i18n() and the date_format option to match the settings for the site.
 *
 * @access public
 * @param string $post_id (default: '')
 * @return mixed boolean/string
 */
function tti_strategies_get_publication_date( $post_id = '' ){

	$key   = 'publication_date';
	$meta  = tti_strategies_get_strategy_meta( $key, $post_id );
	$class = $key;

	if( empty( $meta ) ){
		return false;
	}

	$label = time() < $meta ? __( 'Available', 'd3js-circle-packing' ) : __( 'Published', 'd3js-circle-packing' );

	return tti_strategies_format_meta( $label, date_i18n( get_option( 'date_format' ), $meta ), $class );

}

/**
 * Builds the buttons if available from the strategy meta.
 * returns false if no buttons available.
 *
 * @access public
 * @param string $post_id (default: '')
 * @return mixed boolean/string
 */
function tti_strategies_get_buttons( $post_id = '' ) {

	$buttons = array( 'button_1', 'button_2', 'button_3' );
	$values  = array();

	foreach( $buttons as $button ){

		$uri  = tti_strategies_get_strategy_meta( $button . '_uri' , $post_id );
		$text = tti_strategies_get_strategy_meta( $button . '_text', $post_id );

		if( empty( $uri ) || empty( $text ) ){
			continue;
		}

		$values[] = sprintf( '<a href="%s" class="button button-strategy" target="_blank">%s</a>', $uri, $text );

	}

	return empty( $values ) ? false : implode( '', $values );

}


function tti_add_class_to_body_tag( $classes ) {
	$classes[] = 'smart-framework d3tool';
	return $classes;
}


// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
// remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

//* Remove navigation
remove_action( 'genesis_header', 'genesis_do_nav' );
remove_action( 'genesis_header', 'genesis_do_subnav' );

//* Hook menu in header
function custom_menu() {
	printf( '<nav %s>', genesis_attr( 'smart-menu' ) );
	wp_nav_menu( array(
		'theme_location' => 'landing-menu',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',
	) );

	echo '</nav>';
}

function strategies_menu() {
	printf( '<nav %s>', genesis_attr( 'single-smart-menu' ) );
	wp_nav_menu( array(
		'theme_location' => 'smart-strategies',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',
	) );

	echo '</nav>';
}

function indicators_menu() {
	printf( '<nav %s>', genesis_attr( 'single-smart-menu' ) );
	wp_nav_menu( array(
		'theme_location' => 'smart-indicators',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',
	) );

	echo '</nav>';
}

function tools_menu() {
	printf( '<nav %s>', genesis_attr( 'single-smart-menu' ) );
	wp_nav_menu( array(
		'theme_location' => 'smart-tools',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',
	) );

	echo '</nav>';
}

function tti_header_markup_open() {
	echo '<header class="smart-header">';
	// echo '<div class="smart-header-inner">';
}

function tti_inner_header_markup_open() {
	// echo '<header class="smart-header">';
	echo '<div class="smart-header-inner">';
}

function tti_inner_header_markup_close() {
	echo '</div>';
	// echo '</header>';
}

function tti_header_markup_close() {
	// echo '</div>';
	echo '</header>';
}

add_action( 'genesis_header', 'tti_header_markup_open', 5 );
add_action( 'genesis_header', 'tti_inner_header_markup_open', 7 );
add_action( 'genesis_header', 'tti_inner_header_markup_close', 13 );
add_action( 'genesis_header', 'tti_header_markup_close', 15 );


// Remove footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );


// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

add_action( 'wp_enqueue_scripts', 'tti_strategies_load_default_styles' );
add_action( 'wp_enqueue_style', 'd3js-circle-packing-css' );
add_action( 'wp_enqueue_script', 'd3js-circle-packing-css' );


	if ( is_page( 'smart-strategies' ) || ( is_single() && 'strategy' === get_post_type() ) ) {
		add_action( 'genesis_header', 'strategies_menu', 11 );
	}
	elseif ( is_page( 'smart-indicators' ) || ( is_single() && 'indicator' === get_post_type() ) ) {
		add_action( 'genesis_header', 'indicators_menu', 11 );
	}
	elseif ( is_page( 'smart-tools' ) || ( is_single() && 'tool' === get_post_type() ) ) {
		add_action( 'genesis_header', 'tools_menu', 11 );
	}
	elseif ( is_page( 'smart-framework' ) ) {
		add_action( 'genesis_header', 'custom_menu', 12 );
	}


if ( 'strategy' === get_post_type() ) {
	include_once( TTI_STRATEGIES_TEMPLATES_DIR . 'single-strategy.php' );
}

if ( 'indicator' === get_post_type() ) {
	include_once( TTI_STRATEGIES_TEMPLATES_DIR . 'single-indicator.php' );
}

if ( 'tool' === get_post_type() ) {
	include_once( TTI_STRATEGIES_TEMPLATES_DIR . 'single-tool.php' );
}
