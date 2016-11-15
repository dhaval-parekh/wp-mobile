<?php

class WP_Mobile_General_Settings {

	/**
	 * setting page slug
	 *
	 * @access	protected
	 * @since	1.0.0
	 * @var	string
	 */
	protected $page_slug = '';

	/**
	 * construct method
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function __construct() {
		$this->page_slug = 'general';
	}

	/**
	 * get instance
	 *
	 * @access		public
	 * @since		1.0.0
	 * @staticvar	\WP_Mobile_General_Settings $instance
	 * @return		\WP_Mobile_General_Settings
	 */
	public static function get_instance() {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new WP_Mobile_General_Settings();
			add_filter( 'wp_mobile_get_setting_pages', array( $instance, 'add_setting_page' ), 15, 1 );
			add_action( "wp_mobile_settings_content_{$instance->page_slug}", array( $instance, 'page_content' ), 15, 1 );
			add_action( "wp_mobile_settings_save_{$instance->page_slug}", array( $instance, 'save' ), 15, 1 );
		}
		return $instance;
	}

	/**
	 * construct method
	 *
	 * @access	public
	 * @since	1.0.0
	 * @return	void
	 */
	public function add_setting_page( $pages ) {
		$pages[ $this->page_slug ] = array(
			'title' => __( 'Genaral Settings', 'wp-mobile' ),
		);
		return $pages;
	}

	/**
	 * content of page
	 *
	 * @access	public
	 * @since	1.0.0
	 * @return	void
	 */
	public function page_content() {
	}

	/**
	 * callback method to save data of page
	 *
	 * @access	public
	 * @since	1.0.0
	 * @param	array post back data
	 * @return	void
	 */
	public function save( $post ) {
	}

}

if ( ! function_exists( 'wp_mobile_init_genaral_settings' ) ) {

	/**
	 * initlize the
	 *
	 * @access	public
	 * @since	1.0.0
	 * @return	\WP_Mobile_General_Settings
	 */
	function wp_mobile_init_genaral_settings() {
		return WP_Mobile_General_Settings::get_instance();
	}

	add_action( 'before_wp_mobile_plugin_setttings_init', 'wp_mobile_init_genaral_settings', 5 );
}
