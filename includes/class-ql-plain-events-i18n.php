<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    Ql_Plain_Events
 * @subpackage Ql_Plain_Events/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ql_Plain_Events
 * @subpackage Ql_Plain_Events/includes
 * @author     Bowo <hello@bowo.io>
 */
class Ql_Plain_Events_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ql-plain-events',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
