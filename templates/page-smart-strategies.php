<?php
/**
 * Template Name: Smart data Framework
 *
 * @package Genesis\Templates
 * @author StudioPress
 * @license GPL-2.0+
 * @ link http://my.studipress.com/themes/genesis
 */

add_filter( 'body_class', 'data_bubbles_add_body_class' );
function data_bubbles_add_body_class( $classes ) {

	$classes[] = 'd3tool';

	return $classes;

}

add_filter( 'genesis_attr_content', 'd3js_data_id_attributes_data_content' );
function d3js_data_id_attributes_data_content( $attributes ) {
		$attributes['id'] = 'top';
		return $attributes;
}

add_filter( 'genesis_attr_content', 'data_bubbles_attributes' );
function data_bubbles_attributes( $attributes ) {
		$attributes['id'] = 'data-relationships';
		$attributes['class'] .= ' data-relationships toolkit-item-relationships';
		return $attributes;
}

//* Add d3js_data body class to the head
add_filter( 'body_class', 'd3js_data_add_body_class'   );
add_filter( 'post_class' , 'd3js_data_custom_post_class' );
add_action( 'wp_enqueue_scripts', 'd3js_data_load_default_styles' );

/* Full Width */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/**
 * Enqueue styles for framework app.
 */
function d3js_enqueue_data_relationships_styles() {
	wp_enqueue_style( 'genericons', '/wp-content/plugins/jetpack/_inc/genericons/genericons/genericons.css', d3js_PLUGIN_VERSION, false );
	wp_enqueue_style( 'select2-framework', d3js_data_FRAMEWORK_DIR . 'bower_components/select2/dist/css/select2.min.css', d3js_PLUGIN_VERSION, false );
	wp_enqueue_style( 'framework-data-style', d3js_data_FRAMEWORK_DIR . 'build/app.css', d3js_PLUGIN_VERSION, false );
	wp_enqueue_style( 'data-fonts', 'https://use.typekit.net/asf8jgz.css' );
}
add_action( 'wp_enqueue_scripts', 'd3js_enqueue_data_relationships_styles' );

/**
 * Enqueue scripts specific for the framework data app
 */
function d3js_enqueue_data_relationships_scripts() {
	wp_enqueue_script( 'd3-framework', d3js_data_FRAMEWORK_DIR . 'bower_components/d3/d3.min.js', array( 'jquery' ), d3js_PLUGIN_VERSION, false );
	wp_enqueue_script( 'select2-framework', d3js_data_FRAMEWORK_DIR . 'bower_components/select2/dist/js/select2.min.js', array( 'jquery' ), d3js_PLUGIN_VERSION, false );
	wp_enqueue_script( 'framework-data-script', d3js_data_RELATIONSHIP_DIR . 'build/data-relationships.js', array( 'jquery' ), d3js_PLUGIN_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'd3js_enqueue_data_relationships_scripts' );
add_action( 'wp_enqueue_style', 'd3js-circle-packing-css' );
add_action( 'wp_enqueue_script', 'd3js-circle-packing-css' );

/* Relocates breadcrumbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_entry', 'genesis_do_breadcrumbs' );

/* Remove standard loop */
// remove_action( 'genesis_loop', 'genesis_do_loop' );

/* Including browser notice because it was there before... may not be needed anymore */
add_action( 'genesis_before_loop', 'browser_notice' );
function browser_notice() {
?>
	<noscript>
		<div class="browser-notice text-center">This site requires JavaScript to be enabled. Here are <a href="http://www.enable-javascript.com" target="_blank">instructions how to enable JavaScript in your web browser</a>.</div>
	</noscript>
<?php
}



/* Add header, footer, sitewide styles and scripts */
add_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_after_entry', 'd3js_data_bubbles', 12 );
function d3js_data_bubbles() {
?>
	<div id="chart-part" class="chart-part">
		<div id="chart-filters" class="chart-filters">
			<div class="chart-filters-header">
				<h3>Filter for the data that are best for you.</h3>
				<p class="info">Questions are optional, but answering more will provide more specific data.</p>
			</div>
			<div id="filters" class="filters">
				<div class="filter phase-filter">
					<div class="filter-header"><h4>Select Lifecycle Phase(s)</h4></div>
					<div class="map-container" style="position: relative;">
						<a href="#chart-part" class="policy-and-planning" id="policy-and-planning" title="Policy and Planning"></a>
						<a href="#chart-part" class="project-development" id="project-development" title="Project Development"></a>
						<a href="#chart-part" class="material-selection" id="material-selection" title="Material Selection"></a>
						<a href="#chart-part" class="construction" id="construction" title="Construction"></a>
						<a href="#chart-part" class="operations" id="operations" title="Operations"></a>
						<a href="#chart-part" class="maintenance" id="maintenance" title="Maintenance"></a>
						<a href="#chart-part" class="end-of-life" id="end-of-life" title="End of life"></a>
					</div>
					<ul id="area" class="phase-filter button-group group-transect">
						<li data-value="policy-and-planning" id="policy-and-planning-button" class="button" role="button" aria-pressed="false">Policy and Planning</li>
						<li data-value="project-development" id="project-development-button" class="button" role="button" aria-pressed="false">Project Development</li>
						<li data-value="material-selection" id="material-selection-button" class="button" role="button" aria-pressed="false">Material Selection</li>
						<li data-value="construction" id="construction-button" class="button" role="button" aria-pressed="false">Construction</li>
						<li data-value="operations" id="operations-button" class="button" role="button" aria-pressed="false">Operations</li>
						<li data-value="maintenance" id="maintenance-button" class="button" role="button" aria-pressed="false">Maintenance</li>
						<li data-value="end-of-life" id="end-of-life-button" class="button" role="button" aria-pressed="false">End of Life</li>
					</ul>
				</div>
				<div class="filter theme-filter">
					<div class="filter-header"><h4>Select data Theme(s)</h4></div>
					<ul id="area" class="button-group group-transect">
						<a href="#chart-part"><li data-value="sustainability" id="sustainability-button" class="button" role="button" aria-pressed="false">Sustainability</li></a>
						<a href="#chart-part"><li data-value="smart-growth" id="smart-growth-button" class="button" role="button" aria-pressed="false">Smart Growth</li></a>
						<a href="#chart-part"><li data-value="equity" id="equity-button" class="button" role="button" aria-pressed="false">Equity</li></a>
						<a href="#chart-part"><li data-value="infrastructure-modification" id="infrastructure-modification-button" class="button" role="button" aria-pressed="false">Infrastructure Modification</li></a>
						<a href="#chart-part"><li data-value="transportation-demand-management" id="transportation-demand-management-button" class="button" role="button" aria-pressed="false">Transportation Demand Management</li></a>
						<a href="#chart-part"><li data-value="transportation-system-management" id="transportation-system-management-button" class="button" role="button" aria-pressed="false">Transportation System Management</li></a>
					</ul>
				</div>
				<div class="filter whos-involved-filter">
					<div class="filter-header"><h4>Who's Involved?</h4></div>
					<ul id="area"class="whos-involved-filter group-select">
						<li data-value="automakers" id="automakers-button" class="button" role="button" aria-pressed="false">Automakers</li>
						<li data-value="automobile-repair-shops" id="automobile-repair-shops-button" class="button" role="button" aria-pressed="false">Automobile repair shops</li>
						<li data-value="car-owners" id="car-owners-button" class="button" role="button" aria-pressed="false">Car owners</li>
						<li data-value="carsharing-and-ridesharing-apps" id="carsharing-and-ridesharing-apps-button" class="button" role="button" aria-pressed="false">Carsharing and ridesharing apps</li>
						<!-- <li data-value="community" id="community-button" class="button" role="button" aria-pressed="false">Local Community</li> -->
						<li data-value="construction-companies" id="construction-companies-button" class="button" role="button" aria-pressed="false">Construction companies</li>
						<li data-value="drainage-engineers" id="drainage-engineers-button" class="button" role="button" aria-pressed="false">Drainage engineers</li>
						<!-- <li data-value="employees" id="employees-button" class="button" role="button" aria-pressed="false">Employees</li> -->
						<li data-value="employers-and-employees" id="employers-and-employees-button" class="button" role="button" aria-pressed="false">Employers and employees</li>
						<li data-value="farmers" id="farmers-button" class="button" role="button" aria-pressed="false">Farmers</li>
						<!-- <li data-value="federal" id="federal-button" class="button" role="button" aria-pressed="false">Federal Government Authorities</li> -->
						<li data-value="federal-agencies" id="federal-agencies-button" class="button" role="button" aria-pressed="false">Federal agencies</li>
						<li data-value="fleet-managers" id="fleet-managers-button" class="button" role="button" aria-pressed="false">Fleet managers</li>
						<li data-value="healthcare-providers" id="healthcare-providers-button" class="button" role="button" aria-pressed="false">Healthcare providers</li>
						<li data-value="law-enforcement" id="law-enforcement-button" class="button" role="button" aria-pressed="false">Law enforcement</li>
						<li data-value="local-businesses" id="local-businesses-button" class="button" role="button" aria-pressed="false">Local businesses</li>
						<li data-value="local-governments" id="local-governments-button" class="button" role="button" aria-pressed="false">Local governments</li>
						<li data-value="local-health-departments" id="local-health-departments-button" class="button" role="button" aria-pressed="false">Local health departments</li>
						<li data-value="mpo" id="mpo-button" class="button" role="button" aria-pressed="false">MPOs</li>
						<li data-value="ngo" id="ngo-button" class="button" role="button" aria-pressed="false">NGOs</li>
						<li data-value="policymakers" id="policymakers-button" class="button" role="button" aria-pressed="false">Policymakers</li>
						<li data-value="private-developers" id="private-developers-button" class="button" role="button" aria-pressed="false">Private developers</li>
						<li data-value="school-boards" id="school-boards-button" class="button" role="button" aria-pressed="false">School boards</li>
						<li data-value="software-developers" id="software-developers-button" class="button" role="button" aria-pressed="false">Software developers</li>
						<!-- <li data-value="state-and-local" id="state-and-local-button" class="button" role="button" aria-pressed="false">State and Local Government Authorities</li> -->
						<li data-value="state-governments" id="state-governments-button" class="button" role="button" aria-pressed="false">State governments</li>
						<!-- <li data-value="suppliers" id="suppliers-button" class="button" role="button" aria-pressed="false">Suppliers</li> -->
						<li data-value="technology-companies" id="technology-companies-button" class="button" role="button" aria-pressed="false">Technology companies</li>
						<li data-value="transit-agencies" id="transit-agencies-button" class="button" role="button" aria-pressed="false">Transit agencies</li>
						<li data-value="vegetation-management-experts" id="vegetation-management-experts-button" class="button" role="button" aria-pressed="false">Vegetation management experts</li>
						<li data-value="vulnerable-road-users" id="vulnerable-road-users-button" class="button" role="button" aria-pressed="false">Vulnerable road users</li>
						<li data-value="waste-management-companies" id="waste-management-companies-button" class="button" role="button" aria-pressed="false">Waste management companies</li>
					</ul>
				</div>
			</div>
			<input type="button" id="reset" class="button" role="button" aria-pressed="false" value="Clear filters">
		</div>

		<div id="chart" class="relationship-chart-container last">
			<!-- <h3><span class="genericon genericon-previous xlarge"></span> Answer some of the questions!</h3> -->
			<div class="legend"></div>
			<input type="button" id="back" class="button hide" role="button" aria-pressed="false" value="Go back">
			<input type="button" id="zoom-out" class="button hide" role="button" aria-pressed="false" value="Zoom Out">
		</div>
	</div>
<?php
}

// get_footer();
genesis();
