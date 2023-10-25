<?php

/**
 * D3Toolkit class.
 * This class has static methods that conditionally load other objects to do the main work.
 */
class D3Toolkit
{

	/**
	 * Action on the load-post.php and load-post-new.php hooks.
	 * Checks to make sure the current post type is strategies
	 * then instantiates the D3Toolkit_Strategy_Meta object.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static public function maybe_do_strategy_meta()
	{

		global $typenow, $D3Toolkit_CPT, $D3Toolkit_Strategy_Meta;

		if ($D3Toolkit_CPT->post_type == $typenow) {

			$D3Toolkit_Strategy_Meta = new D3Toolkit_Strategy_Meta;
		}
	}

	/**
	 * Action on the save_post hook.
	 * Checks to make sure the _d3toolkit_nonce is set and correctly verified
	 * then instantiates the D3Toolkit_Save object.
	 *
	 * @access public
	 * @static
	 * @param mixed $post_id
	 * @param mixed $post
	 * @return void
	 */
	static public function maybe_do_save($post_id, $post)
	{

		if (isset($_POST['_d3toolkit_nonce']) && wp_verify_nonce($_POST['_d3toolkit_nonce'], D3TOOLKIT_CLASSES_DIR)) {

			/* Get the post type object. */
			$post_type = get_post_type_object($post->post_type);

			/* Check if the current user has permission to edit the post. */
			if (!current_user_can($post_type->cap->edit_post, $post_id)) {
				return;
			}

			new D3Toolkit_Save($post_id, $post);
		}
	}

	/**
	 * Action added on the dynamic load-edit-tags.php hook.
	 * Optionally enqueues the admin scripts if the current taxonomy matches the strategy-objective value.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static public function maybe_enqueue_scripts()
	{

		global $D3Toolkit_CPT;

		if (
			(isset($_GET['taxonomy']) && $D3Toolkit_CPT->objective === $_GET['taxonomy']) ||
			(isset($_GET['post_type']) && $D3Toolkit_CPT->post_type === $_GET['post_type'])
		) {
			add_action('admin_enqueue_scripts', array('D3Toolkit_Strategy_Meta', 'enqueue_scripts'));
		}
	}

	/**
	 * Action on the widgets_init hook.
	 * Registered the Featured Strategy Widget
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static public function widgets_init()
	{

		register_widget('D3Toolkit_Widget');
	}

	/**
	 * Filter our bulk updated/trashed messages so that it uses "strategy(s)" rather than "post".
	 *
	 * @access public
	 * @static
	 * @param array $bulk_messages
	 * @param array $bulk_counts
	 * @return void
	 */
	static public function bulk_updated_messages($bulk_messages, $bulk_counts)
	{

		global $D3Toolkit_CPT;

		$bulk_messages[$D3Toolkit_CPT->post_type] = array(
			'updated'   => _n('%s strategy updated.', '%s strategies updated.', $bulk_counts['updated'], 'd3-toolkit'),
			'locked'    => _n('%s strategy not updated, somebody is editing it.', '%s strategies not updated, somebody is editing them.', $bulk_counts['locked'], 'd3-toolkit'),
			'deleted'   => _n('%s strategy permanently deleted.', '%s strategies permanently deleted.', $bulk_counts['deleted'], 'd3-toolkit'),
			'trashed'   => _n('%s strategy moved to the Trash.', '%s strategies moved to the Trash.', $bulk_counts['trashed'], 'd3-toolkit'),
			'untrashed' => _n('%s strategy restored from the Trash.', '%s strategies restored from the Trash.', $bulk_counts['untrashed'], 'd3-toolkit'),
		);

		return $bulk_messages;
	}

	/**
	 * Displays admin notices
	 *
	 * @since 0.1.0
	 * @return void
	 */
	static public function admin_notices()
	{

		if (!class_exists('Acf')) {
			D3Toolkit_Message::install_plugin('Advanced Custom Fields');
		}
	}
}
