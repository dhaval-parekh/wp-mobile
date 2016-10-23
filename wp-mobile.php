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
if ( ! defined( 'REST_NAMESPACE' ) ) {
	//define( 'REST_NAMESPACE', 'api' );
}

/**
 * WP_Mobile class
 *
 * @access public
 * @since  1.0.0
 */
class WP_Mobile {

	/**
	 * rest namespace
	 *
	 * @var	string
	 */
	private $namespace = 'wp/v2/';

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
	 * @return	bool
	 * @since	1.0.0
	 */
	public function __construct() {
		$this->setup();
		include_once( $this->inc_dir . 'debug.php' );
		if ( ! $this->is_required_plugin_installed() ) {
			include_once( $this->vendor_dir . 'class-tgm-plugin-activation.php' );
			include_once( $this->inc_dir . 'required_plugins.php' );
			return false;
		}
		if ( defined( 'REST_NAMESPACE' ) ) {
			$this->namespace = REST_NAMESPACE;
		}
		add_action( 'init', array( $this, 'init' ), 0 );
		return true;
	}

	/**
	 * initilization
	 *
	 * @access		public
	 * @since		1.0.0
	 * @return		bool
	 */
	public function init() {
		$this->includes();
		//$this->overwrite_rest_api();
		add_action( 'rest_api_init', array( $this, 'overwrite_rest_api' ), -1 );
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

	private function includes() {
		//	include inc
		require_once $this->inc_dir . 'rest-api/class-wp-mobile-posts-controller.php';
		require_once $this->inc_dir . 'rest-api/class-wp-mobile-users-controller.php';
		require_once $this->inc_dir . 'rest-api/class-wp-mobile-attachments-controller.php';
		require_once $this->inc_dir . 'rest-api/class-wp-mobile-taxonomies-controller.php';
		require_once $this->inc_dir . 'rest-api/class-wp-mobile-post-types-controller.php';
		require_once $this->inc_dir . 'rest-api/class-wp-mobile-post-statuses-controller.php';
		require_once $this->inc_dir . 'rest-api/class-wp-mobile-terms-controller.php';
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
			if ( ! is_plugin_active( $plugin ) ) {
				return false;
			}
		}
		return true;
	}

	public function overwrite_rest_api() {
		global $wp_post_types, $wp_taxonomies;
		add_filter( 'get_rest_namespace', array( $this, 'get_rest_namespace' ), 15 );

		$controller = new WP_Mobile_Users_Controller();
		$controller->register_routes();

		add_filter( 'get_users', array( $this, 'overwrite_rest_api_response' ), 15, 1 );
		add_filter( 'get_user', array( $this, 'overwrite_rest_api_response' ), 15, 1 );
		add_filter( 'create_user', array( $this, 'overwrite_rest_api_response' ), 15, 1 );
		add_filter( 'update_user', array( $this, 'overwrite_rest_api_response' ), 15, 1 );
		add_filter( 'delete_user', array( $this, 'overwrite_rest_api_response' ), 15, 1 );

		$controller = new WP_Mobile_Taxonomies_Controller();
		$controller->register_routes();

		add_filter( 'get_taxonomies', array( $this, 'overwrite_rest_api_response' ), 15, 1 );
		add_filter( 'get_taxonomy', array( $this, 'overwrite_rest_api_response' ), 15, 1 );

		$controller = new WP_Mobile_Post_Types_Controller();
		$controller->register_routes();

		add_filter( 'get_post_types', array( $this, 'overwrite_rest_api_response' ), 15, 1 );
		add_filter( 'get_post_type', array( $this, 'overwrite_rest_api_response' ), 15, 1 );

		$controller = new WP_Mobile_Post_Statuses_Controller();
		$controller->register_routes();

		add_filter( 'get_post_statuses', array( $this, 'overwrite_rest_api_response' ), 15, 1 );
		add_filter( 'get_post_status', array( $this, 'overwrite_rest_api_response' ), 15, 1 );

		$post_types = array( 'post', 'page', 'attachment' );
		$post_types = apply_filters( 'wp_mobile_post_type_to_overwrite', $post_types );
		$wp_post_types['attachment']->rest_controller_class = 'WP_Mobile_Attachments_Controller';

		foreach ( $post_types as $post_type ) {
			if ( isset( $wp_post_types[ $post_type ] ) ) {
				if ( ! isset( $wp_post_types[ $post_type ]->rest_controller_class ) || 'WP_REST_Posts_Controller' === $wp_post_types[ $post_type ]->rest_controller_class ) {
					$wp_post_types[ $post_type ]->rest_controller_class = 'WP_Mobile_Posts_Controller';
				}
			}
			add_filter( "get_{$post_type}_items", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
			add_filter( "get_{$post_type}_item", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
			add_filter( "create_{$post_type}_item", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
			add_filter( "update_{$post_type}_item", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
			add_filter( "delete_{$post_type}_item", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
		}

		$taxonomies = array( 'category', 'post_tag' );
		$taxonomies = apply_filters( 'wp_mobile_taxonomy_to_overwrite', $taxonomies );
		foreach ( $taxonomies as $taxonomy ) {
			if ( isset( $wp_taxonomies[ $taxonomy ] ) ) {
				if ( ! isset( $wp_taxonomies[ $taxonomy ]->rest_controller_class ) || 'WP_REST_Terms_Controller' === $wp_taxonomies[ $taxonomy ]->rest_controller_class ) {
					$wp_taxonomies[ $taxonomy ]->rest_controller_class = 'WP_Mobile_Terms_Controller';
				}
			}
			add_filter( "get_{$taxonomy}_items", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
			add_filter( "get_{$taxonomy}_item", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
			add_filter( "create_{$taxonomy}_item", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
			add_filter( "update_{$taxonomy}_item", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
			add_filter( "delete_{$taxonomy}_item", array( $this, 'overwrite_rest_api_response' ), 15, 1 );
		}
	}

	public function get_rest_namespace() {
		return trailingslashit( $this->namespace );
	}

	/**
	 * add wrapper in the rest api response
	 *
	 * @hooked
	 * @access	public
	 * @since	1.0.0
	 * @param	WP_REST_Response $response request object
	 * @return	WP_REST_Response response object
	 */
	public function overwrite_rest_api_response( $response ) {
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		$data = $response->data;
		if ( ! isset( $data['code'] ) ) {
			$response->data = array(
				'code'		 => 'rest_success',
				'message'	 => 'Rest Success',
				'data'		 => $data,
			);
		}
		unset( $data );
		return $response;
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
