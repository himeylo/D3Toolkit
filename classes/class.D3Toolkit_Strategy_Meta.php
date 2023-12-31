<?php

// use AC\Asset\Script;

/**
 * D3Toolkit_Strategy_Meta class.
 */
class D3Toolkit_Strategy_Meta
{

	/**
	 * The post object of the current strategy
	 *
	 * @var object
	 * @access public
	 */
	var $post;

	/**
	 * The post ID of the current strategy
	 *
	 * @var string
	 * @access public
	 */
	var $post_ID;

	/**
	 * The saved strategy meta values for the current strategy
	 *
	 * @var array
	 * @access private
	 */
	private $_meta_value;

	/**
	 * Fields to be output in the strategy editor custom meta fields.
	 *
	 * @var array
	 * @access private
	 */
	private $_fields;

	/**
	 * Prefix used for building the strategy meta name and IDs
	 *
	 * (default value: '_d3-toolkit')
	 *
	 * @var string
	 * @access private
	 */
	private $_prefix = '_d3-toolkit';

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	function __construct()
	{

		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'), 1);
		add_filter('post_updated_messages', array($this, 'updated_messages'));
	}

	/**
	 * Enqueues the script and css files for the strategies.
	 *
	 * @uses wp_enqueue_script
	 * @uses wp_enqueue_style
	 * @access public
	 * @static
	 * @return void
	 */
	static public function enqueue_scripts()
	{

		wp_enqueue_style('d3toolkit_admin_styles', D3TOOLKIT_RESOURCES_URL . 'css/admin.css', array(), D3TOOLS_PLUGIN_VERSION);
	}



	/**
	 * Action on the add_meta_boxes hook.
	 * Adds the strategy details metabox
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static public function add_meta_boxes()
	{

		global $D3Toolkit_CPT, $D3Toolkit_Strategy_Meta;

		add_meta_box(
			'd3toolkit_strategy_meta',
			__('Strategy Details', 'd3-toolkit'),
			array($D3Toolkit_Strategy_Meta, 'meta_box'),
			$D3Toolkit_CPT->post_type,
			'normal',
			'high'
		);
	}

	/**
	 * Callback function for the strategy details meta box.
	 * Builds the strategy details meta box output.
	 *
	 * @access public
	 * @static
	 * @param object $post
	 * @return void
	 */
	static public function meta_box($post)
	{

		global $D3Toolkit_Strategy_Meta;

		// Add an nonce field so we can check for it later.
		wp_nonce_field(D3TOOLKIT_CLASSES_DIR, '_d3toolkit_nonce');

		echo '<table class="form-table"><tbody>';

		$D3Toolkit_Strategy_Meta->set_post($post);
		$D3Toolkit_Strategy_Meta->set_meta_value();
		$D3Toolkit_Strategy_Meta->set_fields();
		$D3Toolkit_Strategy_Meta->meta_rows();

		echo '</tbody></table>';
	}

	/**
	 * Sets the post object and post ID class variables.
	 *
	 * @access public
	 * @param object $post
	 * @return void
	 */
	public function set_post($post)
	{

		$this->post    = $post;
		$this->post_id = $post->ID;
	}

	/**
	 * Gets the saved meta value and sets the private $_meta_value object variable.
	 *
	 * @access public
	 * @return void
	 */
	public function set_meta_value()
	{

		$this->_meta_value = get_post_meta($this->post_id, $this->_prefix, true);
	}

	/**
	 * Builds table row output for indicated fields.
	 * Uses the $_fields object variable if no $fields value is provided
	 * optionally echoes the output.
	 *
	 * @access public
	 * @param array $fields (default: array())
	 * @param bool $echo (default: true)
	 * @return string
	 */
	public function meta_rows($fields = array(), $echo = true)
	{

		$fields = $fields ? $fields : $this->_fields;

		$rows = '';

		foreach ($fields as $field) {

			$description = empty($field['description']) ? '' : sprintf('<p class="description">%s</p>', $field['description']);

			$rows .= sprintf(
				'<tr valign="top"><th scope="row"><label for="%s">%s</label></th><td>%s%s</td></tr>',
				$this->_get_field_id($field['name']),
				$field['label'],
				$this->_get_field($field),
				$description
			);
		}

		if ($echo) {
			echo $rows;
		}

		return $rows;
	}

	/**
	 * Sets the $_fields object variable.
	 * The fields are used to build the strategy details rows/inputs
	 *
	 * @access public
	 * @return void
	 */
	public function set_fields()
	{

		$this->_fields = array(
			array(
				'name'        => 'featured_text',
				'label'       => __('Featured Text', 'd3-toolkit'),
				'description' => __('This will be displayed as a banner along with the featured image. For best display, the text should be one word or a short two-word phrase.', 'd3-toolkit'),
				'type'        => 'text',
			),
			array(
				'name'        => 'price',
				'label'       => __('Price', 'd3-toolkit'),
				'description' => '',
				'type'        => 'text',
			),
			array(
				'name'        => 'impact',
				'label'       => __('Impact', 'd3-toolkit'),
				'description' => __('Describe how this strategy will help', 'd3-toolkit'),
				'type'        => 'text_area',
			),
			array(
				'name'        => 'implementation',
				'label'       => __('Guidance for Implementation', 'd3-toolkit'),
				'description' => '',
				'type'        => 'text_area',
			),
			array(
				'name'        => 'editor',
				'label'       => __('Editor', 'd3-toolkit'),
				'description' => '',
				'type'        => 'text',
			),
			array(
				'name'        => 'edition',
				'label'       => __('Edition', 'd3-toolkit'),
				'description' => __('Edition or version of the strategy', 'd3-toolkit'),
				'type'        => 'text',
			),
			array(
				'name'        => 'publication_date',
				'label'       => __('Publication Date', 'd3-toolkit'),
				'description' => __('Most common date formats will be automatically converted to machine readable format on save. The date will be displayed using the date format in the general settings.', 'd3-toolkit'),
				'type'        => 'text',
			),
			array(
				'name'        => 'available',
				'label'       => __('Available in', 'd3-toolkit'),
				'description' => __('A list of formats the strategy is available in. Example: Hardback, Paperback, PDF, and Kindle', 'd3-toolkit'),
				'type'        => 'text',
			),
			array(
				'name'        => 'reference',
				'label'       => __('Reference', 'd3-toolkit'),
				'description' => __('This is for the strategy\'s reference text and url', 'd3-toolkit'),
				'type'        => 'button',
			),
			array(
				'name'        => 'button_2',
				'label'       => __('Button 2', 'd3-toolkit'),
				'description' => __('This will create a button on the strategy page that can be used as a link for purchase, download, etc.', 'd3-toolkit'),
				'type'        => 'button',
			),
			array(
				'name'        => 'button_3',
				'label'       => __('Button 3', 'd3-toolkit'),
				'description' => __('This will create a button on the strategy page that can be used as a link for purchase, download, etc.', 'd3-toolkit'),
				'type'        => 'button',
			),
		);
	}

	/**
	 * Gets the individual field output.
	 * Uses a switch to check the type and return the appropriately formated output.
	 *
	 * @access private
	 * @param array $field
	 * @return string
	 */
	private function _get_field($field)
	{

		switch ($field['type']) {

			case 'button':
				return $this->_get_button_field($field);
				break;

			case 'text':
				return $this->_get_text_field($field);
				break;
		}
	}

	/**
	 * Builds the button field output.
	 * Calls the object meta_rows() method to build the text field output.
	 *
	 * @access private
	 * @param array $field
	 * @return sring
	 */
	private function _get_button_field($field)
	{

		$rows = array(
			array(
				'name'        => sprintf('%s_uri', $field['name']),
				'label'       => sprintf(__('%s URI', 'd3-toolkit'), $field['label']),
				'type'        => 'text',
			),
			array(
				'name'        => sprintf('%s_text', $field['name']),
				'label'       => sprintf(__('%s Text', 'd3-toolkit'), $field['label']),
				'type'        => 'text',
			),
		);

		return sprintf('<table class="form-table"><tbody>%s</tbody></table>', $this->meta_rows($rows, false));
	}

	/**
	 * Builds basic text field output.
	 *
	 * @access private
	 * @param array $field
	 * @return string
	 */
	private function _get_text_field($field)
	{

		$name  = $this->_get_field_name($field['name']);
		$id    = $this->_get_field_id($field['name']);
		$value = $this->_get_field_value($field['name']);

		return sprintf('<input type="text" class="widefat" name="%s" id="%s" value="%s" />', $name, $id, $value);
	}

	/**
	 * Builds the field name attribute using the object $_prefix variable.
	 *
	 * @access private
	 * @param string $name
	 * @return string
	 */
	private function _get_field_name($name)
	{

		return sprintf('%s[%s]', $this->_prefix, $name);
	}

	/**
	 * Builds the field ID attribute using the object $_prefix variable.
	 *
	 * @access private
	 * @param string $name
	 * @return string
	 */
	private function _get_field_id($name)
	{

		return sprintf('%s_%s', $this->_prefix, $name);
	}

	/**
	 * Gets the current value for the field.
	 *
	 * @access private
	 * @param string $name
	 * @return string
	 */
	private function _get_field_value($name)
	{

		$value = empty($this->_meta_value[$name]) ? '' : $this->_meta_value[$name];

		if ('publication_date' === $name && $value) {
			$value = date_i18n(get_option('date_format'), $value);
		}

		return $value;
	}

	/**
	 * Creates custom updated messages for strategies.
	 *
	 * @access public
	 * @static
	 * @param mixed $messages
	 * @return void
	 */
	static public function updated_messages($messages)
	{

		global $post, $post_ID, $D3Toolkit_CPT;

		$messages[$D3Toolkit_CPT->post_type] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __('Strategy updated.', 'd3-toolkit'),
			2  => __('Custom field updated.', 'd3-toolkit'),
			3  => __('Custom field deleted.', 'd3-toolkit'),
			4  => __('Strategy updated.', 'd3-toolkit'),
			/* translators: %s: date and time of the revision */
			5  => isset($_GET['revision']) ? sprintf(__('Strategy restored to revision from %s.', 'd3-toolkit'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
			6  => __('Strategy published.', 'd3-toolkit'),
			7  => __('Strategy saved.', 'd3-toolkit'),
			8  => __('Strategy submitted.', 'd3-toolkit'),
			9  => sprintf(__('Strategy scheduled for: %1$s.', 'd3-toolkit'), '<strong>' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($post->post_date)) . '</strong>'),
			10 => __('Strategy draft updated.', 'd3-toolkit'),
		);

		return $messages;
	}
}
