# TTI Strategies
![Dev](https://github.com/ttitamu/d3js-circle-packing-plugin/workflows/Dev/badge.svg)

Adds a toolkit library to any Genesis child theme to tactfully display strategy, indicator, and tool details in single and data visualization archive views

## Description

The TTI Strategies plugin creates 3 custom post types -- strategies, indicators, and tools -- as tools within a toolkit of solutions for practitioners to utilize. The custom post types can have custom information added using advanced custom field groups, which are maintained in this repository and displayed when editing custom posts upon plugin activation.

In addition to the custom data that can be entered about the toolkit item type, there are custom taxonomies created for strategies -- including "Objectives," "Phases," "Themes," and "Who" -- and indicators -- "Type" -- which allow you to sort and organize the strategies and indicators which users can filter in the bubbles-type data visualization archives.

The TTI Strategies Featured Strategy widget will allow you to select a strategy from the library and feature it in any widgeted area of the site.

Also included is a landing page, utilized when a page slug matches "health-equity-framework," in this case. This page utilizes GSAP ScrollTrigger animation for an interactive, scrollytelling user experience.


## Requirements
* Genesis theme
* Advanced Custom Fields Pro plugin


## Installation
1.  [Download the latest release](https://github.com/ttitamu/d3js-circle-packing/releases/latest)
2.  Upload `d3js-circle-packing` directory to the `/wp-content/plugins/` directory
3.  Activate the plugin through the 'Plugins' menu in WordPress

## Build the Plugin pages
* Within your plugin directory, run `npm install`.
* Run `npm run build` or `npm run watch` for development and `npm run prod` for production
Note: Uncomment the "for development" enqueue script in the Smart Framework [template](templates/page-smart-framework.php) for development

### Building the D3.js data visualization archive pages

Sorry that it's a little redundant, but see respective README's for each component. Each uses `npm` and `grunt` independently.
* Strategies [framework](framework/README.md) and [relationship](relationship/README.md)
* Indicators [framework](framework-indicators/README.md) and [relationship](relationship-indicators/README.md)
* Tools [framework](framework-tools/README.md) and [relationship](relationship-tools/README.md)

<!-- ## Changelog -->
<!-- ### 1.0.2 * Cease use of a deprecated Genesis function. Use standard WordPress function instead. -->