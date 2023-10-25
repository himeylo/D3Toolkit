<?php

/**
 * TTI_Strategies_Activation class.
 */
class TTI_Strategies_Activation {

	/**
	 * Registered activation hook callback.
	 * When this plugin is activated, the method is run.
	 * Instantiates the TTI_Strategies_CPT class.
	 * Flushes the rewrite rules.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static public function activate() {

		new TTI_Strategies_CPT;

		flush_rewrite_rules();

	}

}
