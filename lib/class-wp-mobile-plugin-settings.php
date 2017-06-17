<?php

class WP_Mobile_Plugin_Settings {

	/**
	 * list of plugin settings page
	 *
	 * @access	protected
	 * @since	1.0.0
	 * @var		array
	 */
	protected $setting_pages = false;

	/**
	 * default setting page
	 *
	 * @access	protected
	 * @since	1.0.0
	 * @var		array
	 */
	protected $default_page = false;

	/**
	 * current setting page
	 *
	 * @access	protected
	 * @since	1.0.0
	 * @var		array
	 */
	protected $current_page = false;

	/**
	 * containt the messages (notice, errors etc.)
	 *
	 * @access	protected
	 * @since	1.0.0
	 * @var		array
	 */
	protected $messages = false;

	/**
	 * construct method
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function __construct() {
		$this->setting_pages = array();
		$this->messages = array( 'success' => array(), 'warning' => array(), 'error' => array() );
		do_action( 'before_wp_mobile_plugin_setttings_init' );

		$this->setting_pages = apply_filters( 'wp_mobile_get_setting_pages', $this->setting_pages );

		$this->default_page = key( $this->setting_pages );
		$this->default_page = apply_filters( 'wp_mobile_get_default_page', $this->default_page );

		// add Messages
		$this->messages = apply_filters( 'wp_mobile_get_plugin_settings_message', $this->messages );

		$this->current_page = $this->default_page;
		if ( isset( $_GET['tab'], $this->setting_pages[ $_GET['tab'] ] ) ) {
			$this->current_page = sanitize_title( $_GET['tab'] );
		}
		$this->save_page_data();
		do_action( 'after_wp_mobile_plugin_setttings_init' );
	}

	/**
	 * return instance of \WP_Mobile_Plugin_Settings class
	 *
	 * @access	public
	 * @since		1.0.0
	 * @staticvar	\WP_Mobile_Plugin_Settings $instance
	 * @return		\WP_Mobile_Plugin_Settings
	 */
	public static function get_instance() {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new WP_Mobile_Plugin_Settings();
			$instance->add_role_capability();
			$instance->plugin_menus();
		}
		return $instance;
	}

	/**
	 * add capability to admin for access plugin setting page
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_role_capability() {
		// Add the roles you'd like to administer
		$roles = array( 'administrator' );

		// Loop through each role and assign capabilities
		foreach ( $roles as $the_role ) {
			$role = get_role( $the_role );
			$role->add_cap( 'edit_wp_mobile_settings', true );
		}
	}

	/**
	 * add plugin page in admin menu
	 *
	 * @access	public
	 * @since	1.0.0
	 * @return	void
	 */
	public function plugin_menus() {
		if ( count( $this->setting_pages ) ) {
			add_menu_page( 'WP Mobile', 'WP Mobile', 'edit_wp_mobile_settings', 'wp-mobile', array( $this, 'render_page' ), 'dashicons-smartphone', 60 );
		}
	}

	/**
	 * render html for plugin setting page
	 *
	 * @access	public
	 * @since	1.0.0
	 * @return	void
	 */
	public function render_page() {
		include( WP_MOBILE_TEMPLATE_PATH . 'plugin-settings/plugin-settings.php' );
	}

	/**
	 * save method for plugin settings
	 *
	 * @access	public
	 * @since	1.0.0
	 * @return	void
	 */
	private function save_page_data() {
		if ( ! count( $_POST ) ) {
			return false;
		}
		$post = $_POST;
		$setting_pages = array_keys( $this->setting_pages );
		if ( ! ( isset( $post, $post['current_page'] ) && in_array( $post['current_page'], $setting_pages, true ) ) ) {
			return false; // invalid page
		}
		$current_page = $post['current_page'];
		if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wp-mobile-settings-' . $current_page ) ) {
			return false; // invalid request
		}

		do_action( 'wp_mobile_settings_save_' . $current_page, $_POST );
	}

}

if ( ! function_exists( 'wp_mobile_init_plugin_settings' ) ) {

	/**
	 * initlize the plugin settings pages
	 *
	 * @access	public
	 * @since	1.0.0
	 * @return	\WP_Mobile_Plugin_Settings
	 */
	function wp_mobile_init_plugin_settings() {
		return WP_Mobile_Plugin_Settings::get_instance();
	}

	add_action( 'admin_menu', 'wp_mobile_init_plugin_settings', 15 );
}
