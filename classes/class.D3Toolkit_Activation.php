<?php

/**
 * D3Toolkit_Activation class.
 */
class D3Toolkit_Activation
{

	/**
	 * Registered activation hook callback.
	 * When this plugin is activated, the method is run.
	 * Instantiates the D3Toolkit_CPT class.
	 * Flushes the rewrite rules.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static public function activate()
	{

		new D3Toolkit_CPT;

		flush_rewrite_rules();
	}
}
