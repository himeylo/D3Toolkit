<?php

/**
 * D3Toolkit_Widget class.
 * Generates the D3 Toolkit WP Plugin Featured Strategy Widget.
 */
class D3Toolkit_Widget_Output
{

	private $_args;

	private $_instance;

	private $_widget_object;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct($args, $instance, $widget_object)
	{

		$this->_args          = $args;
		$this->_instance      = $instance;
		$this->_widget_object = $widget_object;

		require_once(D3TOOLKIT_FUNCTIONS_DIR . 'template.php');

		$this->widget_output();
	}

	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @global WP_Query $wp_query Query object.
	 * @global integer  $more
	 */
	function widget_output()
	{

		global $wp_query, $D3Toolkit_CPT;

		echo $this->_args['before_widget'];

		//* Set up the objective bio
		if (!empty($this->_instance['title']))
			echo $this->_args['before_title'] . apply_filters('widget_title', $this->_instance['title'], $this->_instance, $this->_widget_object->id_base) . $this->_args['after_title'];

		$wp_query = new WP_Query(array('post__in' => array($this->_instance['strategy_id']), 'post_type' => $D3Toolkit_CPT->post_type));

		if (have_posts()) : while (have_posts()) : the_post();

				genesis_markup(array(
					'html5'   => '<article %s>',
					'xhtml'   => sprintf('<div class="%s">', implode(' ', get_post_class())),
					'context' => 'entry',
				));

				$image = genesis_get_image(array(
					'format'  => 'html',
					'size'    => $this->_instance['image_size'],
					'context' => 'featured-page-widget',
					'attr'    => genesis_parse_attr('entry-image-widget'),
				));

				if ($this->_instance['show_image'] && $image) {

					$banner = ($this->_instance['show_featured_text'] && $text = d3 - toolkit_get_strategy_meta('featured_text')) ? sprintf('<div class="strategy-featured-text-banner">%s</div>', $text) : '';

					printf('<div class="d3-toolkit-featured-image image-%s"><a class="%s" href="%s" title="%s">%s %s</a></div>', esc_attr($this->_instance['image_alignment']), esc_attr($this->_instance['image_alignment']), get_permalink(), the_title_attribute('echo=0'), $image, $banner);
				}

				if (!empty($this->_instance['show_title']) || !empty($this->_instance['show_objective'])) {

					echo genesis_html5() ? '<header class="entry-header">' : '';

					if (!empty($this->_instance['show_title'])) {

						$title = get_the_title() ? get_the_title() : __('(no title)', 'd3-toolkit');

						/**
						 * Filter the featured strategy title.
						 *
						 *
						 * @param string $title    Featured strategy title.
						 * @param array  $this->_instance {
						 *     Widget settings for this instance.
						 *
						 *     @type string $title           Widget title.
						 *     @type int    $strategy_id         ID of the featured page.
						 *     @type bool   $show_image      True if featured image should be shown, false
						 *                                   otherwise.
						 *     @type string $image_alignment Image alignment: alignnone, alignleft,
						 *                                   aligncenter or alignright.
						 *     @type string $image_size      Name of the image size.
						 *     @type bool   $show_title      True if featured page title should be shown,
						 *                                   false otherwise.
						 *     @type bool   $show_content    True if featured page content should be shown,
						 *                                   false otherwise.
						 *     @type int    $content_limit   Amount of content to show, in characters.
						 *     @type int    $more_text       Text to use for More link.
						 * }
						 * @param array  $this->_args     {
						 *     Widget display arguments.
						 *
						 *     @type string $before_widget Markup or content to display before the widget.
						 *     @type string $before_title  Markup or content to display before the widget title.
						 *     @type string $after_title   Markup or content to display after the widget title.
						 *     @type string $after_widget  Markup or content to display after the widget.
						 * }
						 */
						$title = apply_filters('d3toolkit_featured_strategy_title', $title, $this->_instance, $this->_args);

						printf('<h2 class="entry-title"><a href="%s">%s</a></h2>', get_permalink(), $title);
					}

					//include the objective details if selected
					$this->_instance['show_objective'] ? d3 - toolkit_do_by_line() : '';

					echo genesis_html5() ? '</header>' : '';
				}

				//show the content, content limit, or excerpt as selected
				if (!empty($this->_instance['show_content']) || !empty($this->_instance['show_price']) || !empty($this->_instance['more_text'])) {

					echo genesis_html5() ? '<div class="entry-content">' : '';

					if (!empty($this->_instance['show_content'])) {

						if ('excerpt' == $this->_instance['show_content']) {
							the_excerpt();
						} elseif ('content-limit' == $this->_instance['show_content']) {

							add_filter('get_the_content_limit', array($this, 'content_limit_filter'));

							the_content_limit((int) $this->_instance['content_limit'], '');

							remove_filter('get_the_content_limit', array($this, 'content_limit_filter'));
						} else {

							global $more;

							$orig_more = $more;
							$more = 0;

							the_content('');

							$more = $orig_more;
						}
					}

					echo empty($this->_instance['show_price']) ? '' : sprintf('<p>%s</p>', d3 - toolkit_get_price());

					//show the link to view the single strategy page if selected
					echo empty($this->_instance['more_text'])  ? '' : sprintf('<p><a href="%s" class="button">%s</a></p>', get_permalink(), $this->_instance['more_text']);

					echo genesis_html5() ? '</div>' : '';
				}

				genesis_markup(array(
					'html5' => '</article>',
					'xhtml' => '</div>',
				));

			endwhile;
		endif;

		//* Restore original query
		wp_reset_query();

		echo $this->_args['after_widget'];
	}

	/**
	 * Filter on get_the_content_limit.
	 * Adds an ellipse inside the <p></p> of the returned text.
	 *
	 * @access public
	 * @static
	 * @param string $text
	 * @return string
	 */
	static public function content_limit_filter($text)
	{
		return str_replace('</p>', '&#x02026;</p>', $text);
	}
}
