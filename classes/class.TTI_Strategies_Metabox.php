<?php
/**
 * Creates the Strategy metaboxes. Uses Advanced Custom Fields.
 *
 * A class that defined meta box fields for strategies.
 *
 * @link       https://github.com/AgriLife/agrilife-people/blob/master/ALP/class-alp-metabox.php
 * @since      1.5.15
 * @package    agrilife-people
 * @subpackage agrilife-people/ALP
 */

/**
 * The metabox plugin class
 *
 * @since 0.1.0
 * @return void
 */
class TTI_Strategies_Metabox {

	/**
	 * Construct the class.
	 */
	public function __construct() {

		// Register Field Groups.
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_571aa47247e08',
				'title' => 'Strategy Fields',
				'fields' => array(
					array(
						'key' => 'field_6102e39d0f128',
						'label' => 'Link to strategy document',
						'name' => 'link',
						'type' => 'url',
						'instructions' => 'Noticed most strategy docs reside in staticland.tti.tamu.edu, but homeless strats are always <a href="/wp-admin/upload.php?mode=list&attachment-filter=post_mime_type">welcome here</a>.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '<em>https://this.is.a/strategy/that-is-fire-:fireemoji:-and-is-lit-:anotherfireemojiprobably:-and-well-that-is-neat.pdf</em>',
					),
					array(
						'key' => 'field_571a742aaf838',
						'label' => 'Short Description',
						'name' => 'short_description',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
					),
					array(
						'key' => 'field_610067a751c98',
						'label' => 'Strategy Description',
						'name' => 'strategy_description',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'row',
						'button_label' => 'Add a Description Section',
						'sub_fields' => array(
							array(
								'key' => 'field_610072721bb07',
								'label' => 'Section Title',
								'name' => 'section_title',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'field_61006e742e8bb',
								'label' => 'Text Section',
								'name' => 'text_section',
								'type' => 'wysiwyg',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'tabs' => 'all',
								'toolbar' => 'full',
								'media_upload' => 1,
								'delay' => 0,
							),
						),
					),
					array(
						'key' => 'field_610072371bb04',
						'label' => 'Strategy Application',
						'name' => 'strategy_application',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'row',
						'button_label' => 'Add an Application Section',
						'sub_fields' => array(
							array(
								'key' => 'field_610072631bb06',
								'label' => 'Section Title',
								'name' => 'section_title',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'field_610072371bb05',
								'label' => 'Text Section',
								'name' => 'text_section',
								'type' => 'wysiwyg',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'tabs' => 'all',
								'toolbar' => 'full',
								'media_upload' => 1,
								'delay' => 0,
							),
						),
					),
					array(
						'key' => 'field_6100684251c9a',
						'label' => 'Success Stories',
						'name' => 'success_stories',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
					array(
						'key' => 'field_6100685c51c9b',
						'label' => 'Best Practices',
						'name' => 'best_practices',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
					array(
						'key' => 'field_610068b251c9d',
						'label' => 'For More Information',
						'name' => 'for_more_information',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'strategy',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'left',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
				'show_in_rest' => true,
			));
			
			endif;

	}

}