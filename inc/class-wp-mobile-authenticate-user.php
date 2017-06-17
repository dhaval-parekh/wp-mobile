<?php

class WP_Mobile_Authenticate_User {

	private function __construct() {
		add_filter( 'determine_current_user', array( $this, 'authenticate_handler' ), 15 );
		add_filter( 'json_authentication_errors', array( $this, 'authenticate_error' ) );
	}

	public static function get_instance() {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new WP_Mobile_Authenticate_User();
		}
		return $instance;
	}

	public function authenticate_handler( $user ) {
		//	Took reference from https://github.com/WP-API/Basic-Auth
		global $wp_json_basic_auth_error;

		$wp_json_basic_auth_error = null;

		// Don't authenticate twice
		if ( ! empty( $user ) ) {
			return $user;
		}

		// Check that we're trying to authenticate
		if ( ! isset( $_SERVER['HTTP_AUTH'] ) ) {
			return $user;
		}
		$access_token = $_SERVER['HTTP_AUTH'];
		$data = wp_mobile_decrypt( $access_token );
		$data = maybe_unserialize( $data );

		//	extract username and password
		$auth = base64_decode( $data['auth'], false );
		$auth = trim( $auth );
		$auth = explode( ':', $auth );
		$username = $auth[0];
		$password = $auth[1];

		/**
		 * In multi-site, wp_authenticate_spam_check filter is run on authentication. This filter calls
		 * get_currentuserinfo which in turn calls the determine_current_user filter. This leads to infinite
		 * recursion and a stack overflow unless the current function is removed from the determine_current_user
		 * filter during authentication.
		 */
		remove_filter( 'determine_current_user', array( $this, 'authenticate_handler' ), 15 );

		$user = wp_authenticate( $username, $password );

		add_filter( 'determine_current_user', array( $this, 'authenticate_handler' ), 15 );

		if ( is_wp_error( $user ) ) {
			$wp_json_basic_auth_error = $user;
			return null;
		}

		//	user id validation
		if ( $user->ID !== $data['user_id'] ) {
			$wp_json_basic_auth_error = new WP_Error( 'authentication_failed', __( 'Invalid access token provided.', 'wp-mobile' ) );
			return null;
		}

		//	Token validation
		$meta_key = 'wp_mobile_access_token';
		$token = get_user_meta( $user->ID, $meta_key, true );
		if ( $data['token'] !== $token ) {
			$wp_json_basic_auth_error = new WP_Error( 'authentication_failed', __( 'Invalid access token provided.', 'wp-mobile' ) );
			return null;
		}

		$wp_json_basic_auth_error = true;

		return $user->ID;
	}

	public function authenticate_error( $error ) {
		// Passthrough other errors
		if ( ! empty( $error ) ) {
			return $error;
		}
		global $wp_json_basic_auth_error;
		return $wp_json_basic_auth_error;
	}

}

if ( ! function_exists( 'wp_mobile_init_authenticate_user' ) ) {

	function wp_mobile_init_authenticate_user() {
		return WP_Mobile_Authenticate_User::get_instance();
	}

	add_action( 'plugins_loaded', 'wp_mobile_init_authenticate_user', 0 );
}
