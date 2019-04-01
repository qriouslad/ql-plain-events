<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    Ql_Plain_Events
 * @subpackage Ql_Plain_Events/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ql_Plain_Events
 * @subpackage Ql_Plain_Events/admin
 * @author     Bowo <hello@bowo.io>
 */
class Ql_Plain_Events_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ql_Plain_Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ql_Plain_Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ql-plain-events-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ql_Plain_Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ql_Plain_Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ql-plain-events-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the 'Event' custom post type
	 */

	public function event_custom_posttype() {

		$event_labels = array(
			'name'               => 'Events',
			'singular_name'      => 'Event',
			'all_items'          => 'All Events',
			'add_new_item'       => 'Add New Event',
			'add_new'            => 'New Event',
			'new_item'           => 'New Event',
			'edit_item'          => 'Edit Event',
			'view_item'          => 'View Event',
			'search_items'       => 'Search Events',
			'not_found'          => 'No events found',
			'not_found_in_trash' => 'No events found in Trash',
		);

		$event_args = array(
			'labels'             => $event_labels,
			'menu_icon'          => 'dashicons-calendar-alt',
			'public'             => true,
			'can_export'         => true,
			'show_in_nav_menus'  => true,
			'has_archive'        => true,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'capability_type'    => 'post',
			'taxonomies'         => array( 'event_cat' ),
			'rewrite'            => array( 'slug' => 'event' ),
			'supports'           => array( 'title', 'thumbnail', 'editor' ),
		);

		register_post_type( 'event', $event_args );

	}

	/**
	 * Register the 'Event Categories' taxonomy
	 */

	public function event_categories() {


		$event_cat_args = array(
			'label'         => 'Event Categories',
			'hierarchical'  => true,
			'show_in_rest'  => true,
			'rewrite'       => array( 'slug' => 'event_category' ),
		);

		register_taxonomy( 'event_category', 'event', $event_cat_args );

	}


}
