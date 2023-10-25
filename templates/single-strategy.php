<?php
/**
 * This file adds the custom d3js_data post type single post template to be accessible by a genesis theme.
 *
 * @author TTI Communications
 * @package TTI data
 * @subpackage Template
 */

add_filter( 'body_class', 'd3js_data_add_body_class' );


//* Hook menu in header
// add_action( 'genesis_header', 'data_menu', 11 );

// add_action( 'genesis_entry_header', 'd3js_single_data_objectives', 8 );
add_action( 'genesis_entry_header', 'd3js_single_data_header_block_open', 9 );
function d3js_single_data_header_block_open() {
	// d3js_single_data_objectives_associated();
	echo '<div class="entry-header-block">';
	// echo '<p class="entry-header-block-title">data</p>';
	echo '<div class="title-block">';
	// d3js_single_data_side_title_area();
	echo '<div class="title-area">';
}

add_action( 'genesis_entry_header', 'd3js_single_data_title_area_description', 11 );
function d3js_single_data_title_area_description() {
	// if ( is_singular( 'data' ) && has_excerpt() ) {
	// 	the_excerpt();
	// }

	if ( is_singular( 'data' ) && get_field('toolkit_description') ) {
		echo '<div class="entry-description">';
		echo get_field('toolkit_description');
		echo '</div>';
	} 
	// elseif ( is_singular( 'data' ) && the_excerpt() ) {
	// 	echo '<div class="entry-description">';
	// 	echo the_excerpt();
	// 	echo '</div>';
	// }

	echo '<p class="single-header-style">Considering this data will help achieve the goal of the following objectives</p>';
	d3js_single_data_objectives();
	echo '</div>';

	// echo '<div class="chart-area">';
	// echo '<p class="return"><a href="/smart-data">Return to explore data</a></p>';
	// echo '<a class="chart" href="/smart-data#chart"></a>';
	// echo '</div>';

	echo '</div>';
}

add_action( 'genesis_entry_header', 'd3js_single_data_tax_content', 12 );
function d3js_single_data_tax_content() {
	echo '<div class="data-groups">';
	d3js_single_data_phases();
	d3js_single_data_whos_associated();
	d3js_single_data_side_title_area();
	echo '</div>';
}

add_action( 'genesis_entry_header', 'd3js_single_data_header_block_close', 13 );
function d3js_single_data_header_block_close() {
	echo '</div>';
}

function d3js_single_data_objectives() {

	$objectives = get_terms( array(
		'taxonomy' => 'objectives',
		'hide_empty' => false,
		'orderby' => 'id',
		'order' => 'ASC'
	));

	if ( $objectives ) : ?>
		<div class="objectives-container group">
			<ul class="set objectives circles">
				<?php foreach ( $objectives as $objective ) { ?>
					<!-- <a href="/smart-data/#chart"> -->
						<li data-tooltip="<?php echo $objective->name; ?>" class="objective <?php echo $objective->slug; ?>" id="<?php echo $objective->slug; ?>-objective">
						<span class="circle label"><?php echo $objective->name; ?></span>
					</li>
				<!-- </a> -->
				<?php } ?>
			</ul>
		</div>
	<?php endif;
}


function d3js_single_data_objectives_associated() {
	global $post;
	$objectives = get_the_terms( $post->ID, 'objectives' );

	if ( $objectives && ! is_wp_error( $objectives ) ) : ?>
		<div class="objectives-container groups">
			<p class="objectives-list"><span class="list-descriptor">Objectives:&nbsp;</span> 
				<?php $objectivesArray = array();
				foreach ( $objectives as $objective ) { 
					$objectiveItem = '<span class="objective ' . $objective->slug . '">' . $objective->name . '</span>';
					array_push($objectivesArray, $objectiveItem);
				}
				echo implode(",&nbsp;", $objectivesArray); ?>
				</p>
		</div>
	<?php endif;
}

function d3js_single_data_phases() {

	$phases = get_terms( array(
    'taxonomy' => 'phases',
    'hide_empty' => false
	));

	if ( $phases && ! is_wp_error( $phases ) ) : ?>
		<div class="phases-container group">
			<h4 class="phases-header">Transportation lifecycle phases</h4>
			<p>This data is associated with the following transportation lifecycle phases:</p>
			<ul class="set phases">
				<?php foreach ( $phases as $phase ) { ?>
					<li class="phase <?php echo $phase->slug; ?>" id="<?php echo $phase->slug; ?>-phase" ><?php echo $phase->name; ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php endif;
}

function d3js_single_data_themes() {

	$themes = get_terms( array(
		'taxonomy' => 'themes',
		'hide_empty' => false
	));

	if ( $themes && ! is_wp_error( $themes ) ) : ?>
		<div class="themes-container">
			<h4 class="themes-header">data themes</h4>
			<ul class="themes">
				<?php foreach ( $themes as $theme ) { ?>
					<li class="theme <?php echo $theme->slug; ?>" id="<?php echo $theme->slug; ?>-theme" ><?php echo $theme->name; ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php endif;
}

function d3js_single_data_whos_involved() {

	$whos = get_terms( array(
		'taxonomy' => 'who',
		'hide_empty' => false
	));

	if ( $whos && ! is_wp_error( $whos ) ) : ?>
		<div class="whos-container">
			<h4 class="whos-header">Who's involved</h4>
			<ul class="whos">
				<?php foreach ( $whos as $who ) { ?>
					<li class="who <?php echo $who->slug; ?>" id="<?php echo $who->slug; ?>-who" ><?php echo $who->name; ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php endif;
}

function d3js_single_data_whos_associated() {
	global $post;
	$whos = get_the_terms( $post->ID, 'who' );

	if ( $whos && ! is_wp_error( $whos ) ) : ?>
		<div class="whos-container group">
			<h4 class="whos-header">Who's involved</h4>
			<ul class="whos">
				<?php foreach ( $whos as $who ) { ?>
					<li class="who <?php echo $who->slug; ?>" id="<?php echo $who->slug; ?>-who" ><?php echo $who->name; ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php endif;
}

function d3js_single_data_side_title_area() {
	echo '<div class="side-title-area group">';
	echo '<ul class="pagenav"><h4>Jump to section</h4>';
	echo '<li><a href="#benefits">How it helps</a></li><li><a href="#implement">Implementing</a></li><li><a href="#examples">Examples</a></li><li><a href="#cmfSimpleFootnoteDefinitionBox">References</a></li>';
	echo '</ul>';
	// echo '<ul class="pagenav"><li><a href="/smart-data">Return to data</a></li></ul>';
	echo '</div>';
}


// add_action( 'genesis_entry_footer', 'd3js_single_data_footer', 13 );
function d3js_single_data_footer() {
	echo '<ul class="pagenav"><li><a href="/smart-data">Return to data</a></li><li><a href="/smart-framework">SMART Framework</a></li></ul>';
}