<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    Ql_Plain_Events
 * @subpackage Ql_Plain_Events/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ql_Plain_Events
 * @subpackage Ql_Plain_Events/public
 * @author     Bowo <hello@bowo.io>
 */
class Ql_Plain_Events_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ql-plain-events-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ql-plain-events-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Shortcode to display upcoming events
	 *
	 * @since    1.7.0
	 */
	public function upcoming_events_shortcode( $atts ) {

		$atts = shortcode_atts( array(
			'class' => 'events-listing',
			'display' => '0',
			'order' => 'asc',
			'no_events_text' => 'There are no upcoming events.',
			), 
			$atts
		);

		$today = strtotime( 'today' );

		$events_query_args = array(
			'post_type' => 'event',
			'post_status' => 'publish',
			'meta_key' => 'event-start-date',
			'meta_value' => $today,
			'meta_compare' => '>=',
			'orderby' => 'meta_value_num',
			'order' => $atts['order'],
			'posts_per_page' => $atts['display'],
		);

		$events_query = new WP_Query( $events_query_args );

		$output = '<div class="'. $atts['class'] .'">';

		if ( $events_query->have_posts() ) :

			while( $events_query->have_posts() ) :

				$events_query->the_post();

				$event_title = get_the_title();

				$event_start_date = get_post_meta( get_the_ID(), 'event-start-date', true );

				$event_start_date_year_formatted = date_i18n ( 'Y', $event_start_date );

				$event_end_date = get_post_meta( get_the_ID(), 'event-end-date', true );

				if ( ! empty( $event_end_date ) ) {

					$event_end_date_year_formatted = date_i18n ( 'Y', $event_end_date );

				}

				if ( ! empty( $event_end_date ) && ( $event_start_date_year_formatted == $event_end_date_year_formatted ) ) {

					$event_start_date_formatted = date_i18n ( 'F j', $event_start_date );

				} else {

					$event_start_date_formatted = date_i18n ( 'F j, Y', $event_start_date );

				}

				if ( ! empty( $event_end_date ) ) {

					$event_end_date_formatted = ' - ' .date_i18n ( 'F j, Y', $event_end_date );

				}

				$event_time = get_post_meta( get_the_ID(), 'event-time', true );

				$event_location = get_post_meta( get_the_ID(), 'event-location', true );

				$event_excerpt = wp_trim_words( get_the_content(), 70 );

				$event_image = get_the_post_thumbnail( get_the_ID(), 'medium', array( 'class' => 'alignright' ) );

				$output .= '<h4>'.$event_title.'</h4>';
				
				$output .= '<div class="event-meta">'.$event_image.'<strong>Date</strong>: '.$event_start_date_formatted.''.$event_end_date_formatted.'<br /> <strong>Time</strong>: '.$event_time.'<br /> <strong>Location</strong>: '.$event_location.'</div>';

				$output .= '<p>'.$event_excerpt.'</p>';

				unset( $event_start_date );
				unset( $event_start_date_formatted );
				unset( $event_end_date );
				unset( $event_end_date_formatted );

			endwhile;

		else:

			$output .= '<p>' . $atts['no_events_text'] . '</p>';

		endif;

		$output .= '</div>';

		return $output;

	}

	/**
	 * Register all shortcodes
	 *
	 * @since 1.7.0
	 */
	public function register_shortcodes() {

		add_shortcode( 'upcoming_events', array( $this, 'upcoming_events_shortcode' ) );

	}


}
