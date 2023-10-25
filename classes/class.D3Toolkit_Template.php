<?php

/**
 * Contains the D3Toolkit_Template class.
 * Conditionally changes the template files.
 *
 * @author Jamie Leigh
 * @package D3 Toolkit WP Plugin
 * @subpackage Template
 */

/**
 * D3Toolkit_Template class.
 */
class D3Toolkit_Template
{

	/**
	 * The template file
	 *
	 * @var string
	 * @access public
	 */
	public $template;

	/**
	 * D3Toolkit_Template constructor.
	 * Sets the initial object $template variable.
	 * Calls the set_template method with the appropriate template type.
	 *
	 * @access public
	 * @param string $template
	 * @return void
	 */
	public function __construct($template)
	{

		global $D3Toolkit_CPT;

		$this->template = $template;

		if (is_page('smart-framework')) { // landing page
			$this->set_template('page-smart-framework');
		}

		if (is_page('smart-strategies') || is_page('strategies')) { // strategies bubble page
			$this->set_template('page-smart-strategies');
		}

		if (is_page('smart-indicators') || is_page('indicators')) { // indicators bubble page
			$this->set_template('page-smart-indicators');
		}

		if (is_page('smart-tools') || is_page('tools')) { // tools bubble page
			$this->set_template('page-smart-tools');
		}

		if (is_single('strategy')) {
			$this->set_template('single-strategy');
		} elseif (is_single('indicator')) {
			$this->set_template('single-indicator');
		} elseif (is_single('tool')) {
			$this->set_template('single-tool');
		}

		// elseif( is_post_type_archive( $D3Toolkit_CPT->tool ) ){
		// 	$this->set_template( 'archive-tools' );
		// }

		// elseif( is_post_type_archive( $D3Toolkit_CPT->indicator ) ){
		// 	$this->set_template( 'archive-indicators' );
		// }

		// elseif( is_post_type_archive( $D3Toolkit_CPT->post_type ) ){
		// 	$this->set_template( 'archive' );
		// }

		elseif (is_tax()) {
			global $wp_query;
			$this->set_template('taxonomy-' . $wp_query->query_vars['taxonomy']);
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
	public function set_template($template)
	{

		// Get the template slug
		$template_slug = rtrim($template, '.php');
		$template = $template_slug . '.php';

		// Check if a custom template exists in the theme folder, if not, load the plugin template file
		if ($theme_file = locate_template(array($template))) {
			$file = $theme_file;
		} else {
			$file = D3TOOLKIT_TEMPLATES_DIR . $template;
		}

		$this->template = apply_filters('d3toolkit_repl_template_' . $template, $file);
	}

	/**
	 * Filter applied to the template_includes filters.
	 * Verifies the current view is a post_type, archive, or taxonomy associated with the Author Pro plugin
	 * then instantiates the D3Toolkit_Template class to retrieve the correct template file location
	 * before returning the template file location.
	 *
	 * @access public
	 * @static
	 * @param string $template
	 * @return string
	 */
	static public function maybe_include_template($template)
	{

		if (is_front_page()) {
			return $template;
		}

		global $D3Toolkit_CPT;

		if (
			(is_page('smart-framework')) ||
			// ( is_page( 'smart-strategies-framework' ) ) ||
			(is_page('smart-strategies')) ||
			(is_page('strategies')) ||
			(is_page('smart-indicators')) ||
			(is_page('indicators')) ||
			(is_page('smart-tools')) ||
			(is_page('tools')) ||
			(is_single() && $D3Toolkit_CPT->strategy == get_post_type(get_the_ID())) ||
			(is_single() && $D3Toolkit_CPT->tool == get_post_type(get_the_ID())) ||
			(is_single() && $D3Toolkit_CPT->indicator == get_post_type(get_the_ID())) ||
			is_tax(
				array(
					$D3Toolkit_CPT->objective,
					$D3Toolkit_CPT->phase,
					$D3Toolkit_CPT->theme,
					$D3Toolkit_CPT->who,
				)
			)
		) {

			require_once(D3TOOLKIT_FUNCTIONS_DIR . 'template.php');

			// add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

			$D3Toolkit_Template = new D3Toolkit_Template($template);

			$template = $D3Toolkit_Template->template;
		}

		return $template;
	}
}
