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

		global $post_type;

		if ( 'event' != $post_type ) {

			return;

		} else {

			wp_enqueue_style( $this->plugin_name . '_datepicker_style', plugin_dir_url( __FILE__ ) . 'css/ql-plain-events-admin.css', array(), $this->version, 'all' );

		}

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

		global $post_type;

		if ( 'event' != $post_type ) {

			return;

		} else {

			wp_enqueue_script( $this->plugin_name . '_datepicker_script', plugin_dir_url( __FILE__ ) . 'js/ql-plain-events-admin.js', array( 'jquery', 'jquery-ui-datepicker' ), $this->version, false  );

		}

	}

	/**
	 * Register the 'Event' custom post type
	 *
	 * @since    1.1.0
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
	 *
	 * @since    1.1.0
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

	/**
	 * Register metabox for the 'Event' custom post type
	 *
	 * @since    1.2.0
	 */

	public function event_metabox() {

		add_meta_box(
			'event-metabox',
			'Event Details',
			array( $this, 'event_metabox_cb' ),
			'event',
			'normal',
			'high',
		);

	}

	/**
	 * Callback function for the 'Event' metabox
	 *
	 * @since    1.2.0
	 */

	public function event_metabox_cb( $post ) {

		// Generate a nonce field
		wp_nonce_field( 'event_metabox_nonce', 'event_metabox_nonce' );

		// Get previoiusly saved meta values (if any)

		$event_start_date = get_post_meta( $post->ID, 'event-start-date', true );

		$event_end_date = get_post_meta( $post->ID, 'event-end-date', true );

		$event_time = get_post_meta( $post->ID, 'event-time', true );

		$event_location = get_post_meta( $post->ID, 'event-location', true );

		$event_link = get_post_meta( $post->ID, 'event-link', true );

		// Metabox fields
		?>

		<p>
			<label for="event-start-date">Start date</label>
			<input class="widefat" id="event-start-date" type="text" name="event-start-date" required maxlength="40" placeholder="Use datepicker" value="<?php echo esc_attr( $event_end_date ); ?>" />
		</p>

		<p>
			<label for="event-end-date">End date</label>
			<input class="widefat" id="event-end-date" type="text" name="event-end-date" required maxlength="40" placeholder="Use datepicker" value="<?php echo esc_attr( $event_end_date ); ?>" />
		</p>

		<p>
			<label for="event-time">Time</label>
			<input class="widefat" id="" type="text" name="event-time" required maxlength="20" placeholder="Example: 19:00 - 21:00" value="<?php echo esc_attr( $event_time ); ?>" />
		</p>

		<p>
			<label for="event-location">Location</label>
			<input class="widefat" id="" type="text" name="event-location" required maxlength="100" placeholder="Example: Union Square " value="<?php echo esc_attr( $event_location ); ?>" />
		</p>

		<p>
			<label for="event-link">Link to more info</label>
			<input class="widefat" id="" type="text" name="event-link" maxlength="200" placeholder="Example: www.eventsite.com" value="<?php echo esc_attr( $event_link ); ?>" />
		</p>

		<?php

	}

	/**
	 * Function to save event meta data
	 *
	 * @since    1.2.0
	 */
	public function event_save_metadata( $post_id ) {

		// Check if nonce is set
		if ( ! isset( $_POST['event_metabox_nonce'] ) ) {
			return;
		}

		// Verify that nonce is valid
		if ( ! wp_verify_nonce( $_POST['event_metabox_nonce'], 'event_metabox_nonce' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so, do nothing
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check post type and user permission
		if ( ( get_post_type() != 'event' ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check values and save fields
		if ( isset( $_POST['event-start-date'] ) ) {

			update_post_meta( $post_id, 'event-start-date', sanitize_text_field( $_POST['event-start-date'] ) );

		}

		if ( isset( $_POST['event-end-date'] ) ) {
			
			update_post_meta( $post_id, 'event-end-date', sanitize_text_field( $_POST['event-end-date'] ) );

		}

		if ( isset( $_POST['event-time'] ) ) {
			
			update_post_meta( $post_id, 'event-time', sanitize_text_field( $_POST['event-time'] ) );

		}

		if ( isset( $_POST['event-location'] ) ) {
			
			update_post_meta( $post_id, 'event-location', sanitize_text_field( $_POST['event-location'] ) );

		}

		if ( isset( $_POST['event-link'] ) ) {
			
			update_post_meta( $post_id, 'event-link', sanitize_text_field( $_POST['event-link'] ) );

		}

	}

	/**
	 * Add dashboard event columns
	 *
	 * @since    1.4.0
	 */
	public function event_custom_columns( $defaults ) {

		unset( $defaults['date'] );

		$defaults['start_date_column'] = 'Start date';
		$defaults['end_date_column'] = 'End date';
		$defaults['time_column'] = 'Time';
		$defaults['location_column'] = 'Location';

		return $defaults;

	}

	/**
	 * Get data for the event columns
	 *
	 * @since    1.4.0
	 */
	public function event_custom_columns_content( $column_name, $post_id ) {

		if( 'start_date_column' == $column_name ) {

			$start_date = get_post_meta( $post_id, 'event-start-date', true );

			if ( ! empty( $start_date ) ) {

				echo $start_date;

			}

		}

		if( 'end_date_column' == $column_name ) {

			$end_date = get_post_meta( $post_id, 'event-end-date', true );

			if ( ! empty( $end_date ) ) {

				echo $end_date;

			}

		}

		if( 'time_column' == $column_name ) {

			$event_time = get_post_meta( $post_id, 'event-time', true );

			if ( ! empty( $event_time ) ) {

				echo $event_time;

			}

		}

		if( 'location_column' == $column_name ) {

			$event_location = get_post_meta( $post_id, 'event-location', true );

			if ( ! empty( $event_location ) ) {

				echo $event_location;

			}

		}


	}


}