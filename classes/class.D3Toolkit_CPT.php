<?php

/**
 * D3Toolkit_CPT class.
 */
class D3Toolkit_CPT
{

	/**
	 * The post type.
	 *
	 * @var string
	 * @access public
	 */
	var $post_type;

	/**
	 * The strategy post type.
	 *
	 * @var string
	 * @access public
	 */
	var $strategy;

	/**
	 * The indicator post type.
	 *
	 * @var string
	 * @access public
	 */
	var $indicator;

	/**
	 * The tool post type.
	 *
	 * @var string
	 * @access public
	 */
	var $tool;

	/**
	 * Heirarcical taxonomy for strategy Objectives.
	 *
	 * @var string
	 * @access public
	 */
	var $objective;

	/**
	 * The heirarcical taxonomy.
	 *
	 * @var string
	 * @access public
	 */
	var $phase;

	/**
	 * The non heirarcical taxonomy.
	 *
	 * @var string
	 * @access public
	 */
	var $theme;

	/**
	 * The non heirarcical taxonomy.
	 *
	 * @var string
	 * @access public
	 */
	var $who;
	/**
	 * The non heirarcical taxonomy.
	 *
	 * @var string
	 * @access public
	 */
	var $indicator_type;

	/**
	 * Action added on the init hook.
	 * Sets the global $D3Toolkit_CPT variable
	 * and instantiates the D3Toolkit_CPT object.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static public function init()
	{

		global $D3Toolkit_CPT;

		$D3Toolkit_CPT = new D3Toolkit_CPT;
	}

	/**
	 * Action on the after_setup_theme hook.
	 * Checks to see if the d3toolkit_archive image size exists
	 * then adds d3toolkit_archive image size if it isn't set.
	 * This allows the child theme or another plugin to override the image size.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static function maybe_add_image_size()
	{

		global $_wp_additional_image_sizes;

		if (!isset($_wp_additional_image_sizes['d3-toolkit-image'])) {

			add_image_size('d3-toolkit-image', 360, 570, TRUE);
		}
	}

	/**
	 * D3Toolkit_CPT constructor method.
	 * Sets the $post_type class variable
	 * Calls the register_post_type() method.
	 * Calls the register_taxonomy() method.
	 *
	 * @access public
	 * @return void
	 */
	function __construct()
	{

		$this->strategy 	= 'strategy';
		$this->indicator 	= 'indicator';
		$this->tool	     	= 'tool';
		$this->objective 	= 'objectives';
		$this->phase     	= 'phases';
		$this->theme     	= 'themes';
		$this->who	     	= 'who';
		$this->indicator_type 	= 'indicator_type';

		$this->register_post_type();
		$this->register_taxonomy();
	}

	/**
	 * Registers the Strategy post type.
	 *
	 * @access public
	 * @return void
	 */
	function register_post_type()
	{

		$labels = apply_filters('d3toolkit_cpt_labels', array(
			'name'               => _x('SMART Framework Strategies', 'post type general name', 'd3-toolkit'),
			'singular_name'      => _x('Strategy', 'post type singular name', 'd3-toolkit'),
			'add_new'            => _x('Add New Strategy', 'add_new_strategy', 'd3-toolkit'),
			'menu_name'          => __('SMART Strategies', 'd3-toolkit'),
			'add_new_item'       => __('Add New Strategy', 'd3-toolkit'),
			'edit_item'          => __('Edit Strategy', 'd3-toolkit'),
			'new_item'           => __('New Strategy', 'd3-toolkit'),
			'all_items'          => __('All Strategies', 'd3-toolkit'),
			'view_item'          => __('View Strategy', 'd3-toolkit'),
			'search_items'       => __('Search Strategies', 'd3-toolkit'),
			'not_found'          => __('No Strategies Found', 'd3-toolkit'),
			'not_found_in_trash' => __('No Strategies Found in Trash', 'd3-toolkit'),
		));

		$args = apply_filters('d3toolkit_cpt_args', array(
			'labels'             => $labels,
			'description'        => __('Custom post type item for strategies, a grouping of posts in the SMART Framework Infrastructure.', 'd3-toolkit'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'query_var'          => true,
			'rewrite'            => array('slug' => apply_filters('d3toolkit_strategy_slug', 'strategy'), 'feeds' => true, 'with_front' => true,),
			'capability_type'    => 'post',
			// 'has_archive'        => apply_filters( 'd3toolkit_archive_slug', 'strategies' ),
			'hierarchical'       => true,
			'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'genesis-seo', 'genesis-scripts', 'genesis-simple-menus', 'genesis-layouts', 'genesis-title-toggle', 'page-attributes', 'custom-fields', 'post-formats'),
			'menu_position'      => 22,
			'rest_base'          => 'strategies',
		));

		register_post_type($this->strategy, $args);

		$labels = apply_filters('d3toolkit_indicators_cpt_labels', array(
			'name'               => _x('SMART Framework Indicators', 'post type general name', 'd3-toolkit'),
			'singular_name'      => _x('Indicator', 'post type singular name', 'd3-toolkit'),
			'add_new'            => _x('Add New Indicator', 'add_new_strategy', 'd3-toolkit'),
			'menu_name'          => __('SMART Indicators', 'd3-toolkit'),
			'add_new_item'       => __('Add New Indicator', 'd3-toolkit'),
			'edit_item'          => __('Edit Indicator', 'd3-toolkit'),
			'new_item'           => __('New Indicator', 'd3-toolkit'),
			'all_items'          => __('All Indicators', 'd3-toolkit'),
			'view_item'          => __('View Indicator', 'd3-toolkit'),
			'search_items'       => __('Search Indicators', 'd3-toolkit'),
			'not_found'          => __('No Indicators Found', 'd3-toolkit'),
			'not_found_in_trash' => __('No Indicators Found in Trash', 'd3-toolkit'),
		));

		$args = apply_filters('d3toolkit_indicators_cpt_args', array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-welcome-learn', // invalid so it doesn't show anything
			'query_var'          => true,
			'rewrite'            => array('slug' => apply_filters('d3toolkit_indicator_slug', 'indicator'), 'feeds' => true, 'with_front' => true,),
			'capability_type'    => 'post',
			// 'has_archive'        => apply_filters( 'd3toolkit_indicators_archive_slug', 'indicators' ),
			'hierarchical'       => true,
			'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'genesis-seo', 'genesis-scripts', 'genesis-simple-menus', 'genesis-layouts', 'genesis-title-toggle', 'page-attributes', 'custom-fields', 'post-formats'),
			'menu_position'      => 22,
		));

		register_post_type($this->indicator, $args);

		$labels = apply_filters('d3toolkit_tools_cpt_labels', array(
			'name'               => _x('SMART Framework Tools', 'post type general name', 'd3-toolkit'),
			'singular_name'      => _x('Tool', 'post type singular name', 'd3-toolkit'),
			'add_new'            => _x('Add New Tool', 'add_new_strategy', 'd3-toolkit'),
			'menu_name'          => __('SMART Tools', 'd3-toolkit'),
			'add_new_item'       => __('Add New Tool', 'd3-toolkit'),
			'edit_item'          => __('Edit Tool', 'd3-toolkit'),
			'new_item'           => __('New Tool', 'd3-toolkit'),
			'all_items'          => __('All Tools', 'd3-toolkit'),
			'view_item'          => __('View Tool', 'd3-toolkit'),
			'search_items'       => __('Search Tools', 'd3-toolkit'),
			'not_found'          => __('No Tools Found', 'd3-toolkit'),
			'not_found_in_trash' => __('No Tools Found in Trash', 'd3-toolkit'),
		));

		$args = apply_filters('d3toolkit_tools_cpt_args', array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-welcome-learn', // invalid so it doesn't show anything
			'query_var'          => true,
			'rewrite'            => array('slug' => apply_filters('d3toolkit_tool_slug', 'tool'), 'feeds' => true, 'with_front' => true,),
			'capability_type'    => 'post',
			// 'has_archive'        => apply_filters( 'd3toolkit_tools_archive_slug', 'tools' ),
			'hierarchical'       => true,
			'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'genesis-seo', 'genesis-scripts', 'genesis-simple-menus', 'genesis-layouts', 'genesis-title-toggle', 'page-attributes', 'custom-fields', 'post-formats'),
			'menu_position'      => 22,
		));

		register_post_type($this->tool, $args);
	}

	/**
	 * Registers taxonomies for the SMART post types.
	 *
	 * @access public
	 * @return void
	 */
	function register_taxonomy()
	{

		$labels = array(
			'name'                       => _x('SMART Objectives', 'taxonomy general name', 'd3-toolkit'),
			'singular_name'              => _x('SMART Objective', 'taxonomy singular name', 'd3-toolkit'),
			'search_items'               => __('Search SMART Objectives', 'd3-toolkit'),
			'all_items'                  => __('All SMART Objectives', 'd3-toolkit'),
			'edit_item'                  => __('Edit SMART Objective', 'd3-toolkit'),
			'update_item'                => __('Update SMART Objective', 'd3-toolkit'),
			'add_new_item'               => __('Add New SMART Objective', 'd3-toolkit'),
			'new_item_name'              => __('New SMART Objective Name', 'd3-toolkit'),
			'add_or_remove_items'        => __('Add or remove SMART Objective', 'd3-toolkit'),
			'not_found'                  => __('No SMART Objectives found.', 'd3-toolkit'),
			'menu_name'                  => __('- Objectives', 'd3-toolkit'),
			'parent_item'                => null,
			'parent_item_colon'          => null,
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'		  => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => apply_filters('d3toolkit_objective_slug', 'objective')),
		);

		register_taxonomy($this->objective, array($this->strategy, $this->indicator, $this->tool), $args);

		$labels = array(
			'name'                       => _x('Project Phases', 'taxonomy general name', 'd3-toolkit'),
			'singular_name'              => _x('Project Phase', 'taxonomy singular name', 'd3-toolkit'),
			'search_items'               => __('Search Project Phases', 'd3-toolkit'),
			'all_items'                  => __('All Project Phases', 'd3-toolkit'),
			'edit_item'                  => __('Edit Project Phase', 'd3-toolkit'),
			'update_item'                => __('Update Project Phase', 'd3-toolkit'),
			'add_new_item'               => __('Add New Project Phase', 'd3-toolkit'),
			'new_item_name'              => __('New Project Phase Name', 'd3-toolkit'),
			'add_or_remove_items'        => __('Add or remove Project Phase', 'd3-toolkit'),
			'not_found'                  => __('No Project Phases found.', 'd3-toolkit'),
			'menu_name'                  => __('- Project Phases', 'd3-toolkit'),
			'parent_item'                => null,
			'parent_item_colon'          => null,
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'		  => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => apply_filters('d3toolkit_phase_slug', 'phase')),
		);

		register_taxonomy($this->phase, array($this->strategy), $args);

		$labels = array(
			'name'                       => _x('Strategy Themes', 'taxonomy general name', 'd3-toolkit'),
			'singular_name'              => _x('Strategy Theme', 'taxonomy singular name', 'd3-toolkit'),
			'search_items'               => __('Search Strategy Themes', 'd3-toolkit'),
			'all_items'                  => __('All Strategy Themes', 'd3-toolkit'),
			'edit_item'                  => __('Edit Strategy Theme', 'd3-toolkit'),
			'update_item'                => __('Update Strategy Theme', 'd3-toolkit'),
			'add_new_item'               => __('Add New Strategy Theme', 'd3-toolkit'),
			'new_item_name'              => __('New Strategy Theme Name', 'd3-toolkit'),
			'add_or_remove_items'        => __('Add or remove Strategy Theme', 'd3-toolkit'),
			'not_found'                  => __('No Strategy Themes found.', 'd3-toolkit'),
			'menu_name'                  => __('- Themes', 'd3-toolkit'),
			'parent_item'                => null,
			'parent_item_colon'          => null,
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'		  => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => apply_filters('d3toolkit_theme_slug', 'theme')),
		);

		register_taxonomy($this->theme, array($this->strategy), $args);

		$labels = array(
			'name'                       => _x('Who\'s Involved', 'taxonomy general name', 'd3-toolkit'),
			'singular_name'              => _x('Who', 'taxonomy singular name', 'd3-toolkit'),
			'search_items'               => __('Search Who\'s Involved', 'd3-toolkit'),
			'all_items'                  => __('All Those Involved', 'd3-toolkit'),
			'edit_item'                  => __('Edit Who\'s Involved', 'd3-toolkit'),
			'update_item'                => __('Update Who\'s Involved', 'd3-toolkit'),
			'add_new_item'               => __('Add New Who\'s Involved', 'd3-toolkit'),
			'new_item_name'              => __('New Who\'s Involved Name', 'd3-toolkit'),
			'add_or_remove_items'        => __('Add or remove Who\'s Involved',	'd3-toolkit'),
			'not_found'                  => __('None found', 'd3-toolkit'),
			'menu_name'                  => __('- Who\'s Involved', 'd3-toolkit'),
			'parent_item'                => null,
			'parent_item_colon'          => null,
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'		  => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => apply_filters('d3toolkit_who_slug', 'who')),
		);

		register_taxonomy($this->who, array($this->strategy), $args);

		$labels = array(
			'name'                       => _x('Types', 'taxonomy general name', 'd3-toolkit'),
			'singular_name'              => _x('Type', 'taxonomy singular name', 'd3-toolkit'),
			'search_items'               => __('Search Types', 'd3-toolkit'),
			'all_items'                  => __('All Types', 'd3-toolkit'),
			'edit_item'                  => __('Edit Type', 'd3-toolkit'),
			'update_item'                => __('Update Type', 'd3-toolkit'),
			'add_new_item'               => __('Add New Type', 'd3-toolkit'),
			'new_item_name'              => __('New Type Name', 'd3-toolkit'),
			'add_or_remove_items'        => __('Add or remove Type', 'd3-toolkit'),
			'not_found'                  => __('Types not found.', 'd3-toolkit'),
			'menu_name'                  => __('- Types', 'd3-toolkit'),
			'parent_item'                => null,
			'parent_item_colon'          => null,
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'		  => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => apply_filters('d3toolkit_indicator_type_slug', 'type')),
		);

		register_taxonomy($this->indicator_type, array($this->indicator), $args);
	}

	/**
	 * Remove Genesis Layout Options action from taxonomies.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	static function remove_genesis_layout_options()
	{
		$taxonomies = array('objectives', 'phases', 'themes', 'who', 'indicator-type');
		foreach ($taxonomies as $taxonomy) {
			remove_action($taxonomy . '_edit_form', 'genesis_taxonomy_layout_options', 10);
		}
	}

	/**
	 * Maybe remove Genesis Sidebar form
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	static function maybe_remove_genesis_sidebar_form()
	{
		if (class_exists('Genesis_Simple_Sidebars') && is_admin()) {
			$taxonomies = array('objectives', 'phases', 'themes', 'who', 'indicator-type');
			foreach ($taxonomies as $taxonomy) {
				remove_action($taxonomy . '_edit_form', array(Genesis_Simple_Sidebars()->term, 'term_sidebar_form'), 9);
			}
		}
	}
}
