<?php

/**
 * Plugin Name: WP Mobile App
 * Plugin URI:  http://wpm.ciphersoul.com/
 * Description: Plugin let you allow to create mobile application in wordpress
 * Version:     1.0.0
 * Author:      Dhaval Parekh
 * Author URI:  https://about.me/Dmparekh/
 * Text Domain: wp-mobile
 * Domain Path: /languages
 *
 * Plugin let you allow to create mobile application in wordpress
 *
 * @package   wp-mobile
 * @version   1.0.0
 * @author    Dhaval Parekh <dmparekh007@gmail.com>
 * @copyright 
 * @link      http://wpm.ciphersoul.com/
 * @license   
 */

/**
 * WP_Mobile class
 * 
 * @access public
 * @since  1.0.0
 */
class WP_Mobile {

	/**
	 * plugin directory path
	 * 
	 * @access	private
	 * @var		string
	 * @since	1.0.0
	 */
	private $plugin_path = '';

	/**
	 * plugin directory URI
	 * 
	 * @access	private
	 * @var		string
	 * @since	1.0.0
	 */
	private $plugin_uri = '';

	/**
	 * vendor directory path
	 * 
	 * @access	private
	 * @var		string
	 * @since	1.0.0
	 */
	private $vendor_dir = '';

	/**
	 * library directory path
	 * 
	 * @access	private
	 * @var		string
	 * @since	1.0.0
	 */
	private $lib_dir = '';

	/**
	 * include directory path
	 * 
	 * @access	private
	 * @var		string 
	 * @since	1.0.0
	 */
	private $inc_dir = '';

	/**
	 * construct method
	 * 
	 * @access	private
	 * @return	void 
	 * @since	1.0.0
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * return instance of WP_Mobile
	 * 
	 * @access		public
	 * @since		1.0.0
	 * @staticvar	\WP_Mobile		$instance
	 * @return		\WP_Mobile|bool	
	 */
	public function init() {
		$this->setup();
		include_once( $this->inc_dir . 'debug.php' );
		if ( ! $this->is_required_plugin_installed() ) {
			//	wordpress
			include_once( $this->vendor_dir . 'class-tgm-plugin-activation.php' );
			include_once( $this->inc_dir . 'required_plugins.php' );
			return false;
		}
		return true;
	}

	/**
	 * setup plugin variable
	 * 
	 * @access	public
	 * @since	1.0.0
	 * @return	void 
	 */
	private function setup() {
		// Main plugin directory path and URI.
		$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->plugin_uri = trailingslashit( plugin_dir_url( __FILE__ ) );

		// Plugin directory path
		$this->vendor_dir = trailingslashit( $this->plugin_path . 'vendor' );
		$this->lib_dir = trailingslashit( $this->plugin_path . 'lib' );
		$this->inc_dir = trailingslashit( $this->plugin_path . 'inc' );
	}
	
	/**
	 * check requried plugin installed or not
	 * 
	 * @access	public
	 * @since	1.0.0
	 * @return	boolean
	 */
	private function is_required_plugin_installed() {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$requvired_plugin_list = array(
			'rest-api/plugin.php',
			'butterbean/butterbean.php',
		);
		foreach ( $requvired_plugin_list as $plugin ) {
			if ( !is_plugin_active( $plugin ) ) {
				return false;
			}
		}
		return true;
	}

}

if ( ! function_exists( 'wp_mobile_init' ) ) {

	/**
	 * initilized wp_mobile plugin
	 * 
	 * @access	public
	 * @since	1.0.0
	 * @return	void
	 */
	function wp_mobile_init() {
		new WP_Mobile();
	}
	wp_mobile_init();
}

