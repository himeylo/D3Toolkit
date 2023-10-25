# D3.js Zoomable Circle Packing

![Main](https://github.com/himeylo/D3Toolkit/workflows/Main/badge.svg)

WordPress data visualization toolkit using D3.js data visualization, Select2 filtering, and WP custom post types and taxonomies. Sets up custom post types for strategies, indicators, and tools, and taxonomy terms for `objectives`, lifecycle `phases`, project `themes`, `who` is involved, and indicator `types`. Complements any Genesis child theme to display `strategy`, `indicator`, and `tool` details in single and interactive circle packing data visualization archive views with filtering by associated taxonomy terms.

Custom post types and taxonomies use Advanced Custom Fields, which are maintained in this repository and displayed when editing custom posts upon plugin activation. <!-- The D3 Toolkit WP Plugin Featured Strategy widget will allow you to select a strategy from the library and feature it in any widgeted area of the site. -->

Also included is a `/toolkit` landing page that acts as the top-level, parent page for the toolkit. This page utilizes GSAP ScrollTrigger animation for an interactive, scrollytelling user experience.

## Requirements

- Genesis theme
- Advanced Custom Fields plugin

## Installation

1. [Download the latest release](https://github.com/himeylo/D3Toolkit/releases/latest)
2. Upload `D3Toolkit` directory to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

## Build the Plugin pages

- Within your plugin directory, run `npm install`.
- Run `npm run build` or `npm run watch` for development and `npm run prod` for production
  Note: Uncomment the "for development" enqueue script in the Smart Framework [template](templates/page-toolkit.php) for development

### Building the D3.js data visualization archive pages

Sorry that it's a little redundant, but see respective README's for each component. Each uses `npm` and `grunt` independently.

- Strategies [framework](framework/README.md) and [relationship](relationship/README.md)
- Indicators [framework](framework-indicators/README.md) and [relationship](relationship-indicators/README.md)
- Tools [framework](framework-tools/README.md) and [relationship](relationship-tools/README.md)
