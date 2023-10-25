<?php
/**
 * Contains the TTI_Strategies_Template class.
 * Conditionally changes the template files.
 *
 * @author TTI Communications
 * @package TTI Strategies
 * @subpackage Template
 */

/**
 * TTI_Strategies_Template class.
 */
class TTI_Strategies_Template {

	/**
	 * The template file
	 *
	 * @var string
	 * @access public
	 */
	public $template;

	/**
	 * TTI_Strategies_Template constructor.
	 * Sets the initial object $template variable.
	 * Calls the set_template method with the appropriate template type.
	 *
	 * @access public
	 * @param string $template
	 * @return void
	 */
	public function __construct( $template ){

		global $TTI_Strategies_CPT;

		$this->template = $template;

		if ( is_page( 'smart-framework' ) ) { // landing page
			$this->set_template( 'page-smart-framework' );
		}

		if ( is_page( 'smart-strategies' ) || is_page( 'strategies' ) ) { // strategies bubble page
			$this->set_template( 'page-smart-strategies' );
		}

		if ( is_page( 'smart-indicators' ) || is_page( 'indicators' ) ) { // indicators bubble page
			$this->set_template( 'page-smart-indicators' );
		}

		if ( is_page( 'smart-tools' ) || is_page( 'tools' ) ) { // tools bubble page
			$this->set_template( 'page-smart-tools' );
		}

		if ( is_single( 'strategy' ) ) {
			$this->set_template( 'single-strategy' );
		}

		elseif ( is_single( 'indicator' ) ) {
			$this->set_template( 'single-indicator' );
		}

		elseif ( is_single( 'tool' ) ) {
			$this->set_template( 'single-tool' );
		}

		// elseif( is_post_type_archive( $TTI_Strategies_CPT->tool ) ){
		// 	$this->set_template( 'archive-tools' );
		// }

		// elseif( is_post_type_archive( $TTI_Strategies_CPT->indicator ) ){
		// 	$this->set_template( 'archive-indicators' );
		// }

		// elseif( is_post_type_archive( $TTI_Strategies_CPT->post_type ) ){
		// 	$this->set_template( 'archive' );
		// }

		elseif( is_tax() ) {
			global $wp_query;
			$this->set_template( 'taxonomy-' . $wp_query->query_vars['taxonomy'] );
		}

	}

	/**
	 * Sets the object $template variable to use the appropriate template file.
	 * Checks to see if the theme has the template file and uses that file if available
	 * Otherwise it uses the file from the plugin template directory.
	 *
	 * @access public
	 * @param string $template
	 * @return void
	 */
	public function set_template( $template ){

		// Get the template slug
		$template_slug = rtrim( $template, '.php' );
		$template = $template_slug . '.php';

		// Check if a custom template exists in the theme folder, if not, load the plugin template file
		if ( $theme_file = locate_template( array( $template ) ) ) {
			$file = $theme_file;
		}
		else {
			$file = TTI_STRATEGIES_TEMPLATES_DIR . $template;
		}

		$this->template = apply_filters( 'tti_strategies_repl_template_' . $template, $file );

	}

	/**
	 * Filter applied to the template_includes filters.
	 * Verifies the current view is a post_type, archive, or taxonomy associated with the Author Pro plugin
	 * then instantiates the TTI_Strategies_Template class to retrieve the correct template file location
	 * before returning the template file location.
	 *
	 * @access public
	 * @static
	 * @param string $template
	 * @return string
	 */
	static public function maybe_include_template( $template ){

		if( is_front_page() ) {
			return $template;
		}

		global $TTI_Strategies_CPT;

		if(
			( is_page( 'smart-framework' ) ) ||
			// ( is_page( 'smart-strategies-framework' ) ) ||
			( is_page( 'smart-strategies' ) ) ||
			( is_page( 'strategies' ) ) ||
			( is_page( 'smart-indicators' ) ) ||
			( is_page( 'indicators' ) ) ||
			( is_page( 'smart-tools' ) ) ||
			( is_page( 'tools' ) ) ||
			( is_single() && $TTI_Strategies_CPT->strategy == get_post_type( get_the_ID() ) ) ||
			( is_single() && $TTI_Strategies_CPT->tool == get_post_type( get_the_ID() ) ) ||
			( is_single() && $TTI_Strategies_CPT->indicator == get_post_type( get_the_ID() ) ) ||
				is_tax( array(
						$TTI_Strategies_CPT->objective,
						$TTI_Strategies_CPT->phase,
						$TTI_Strategies_CPT->theme,
						$TTI_Strategies_CPT->who,
					) 
				)
		) {

			require_once( TTI_STRATEGIES_FUNCTIONS_DIR . 'template.php' );

			// add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

			$TTI_Strategies_Template = new TTI_Strategies_Template( $template );

			$template = $TTI_Strategies_Template->template;

		}

		return $template;

	}

}
