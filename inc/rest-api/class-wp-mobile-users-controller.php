<?php

class WP_Mobile_Users_Controller extends WP_REST_Users_Controller {

	public function __construct() {
		parent::__construct();
		$this->namespace = apply_filters( 'get_rest_namespace', $this->namespace );

		//	user auth endpoint
		register_rest_route( $this->namespace, '/' . $this->rest_base . '/auth', array(
			array(
				'methods'				 => WP_REST_Server::CREATABLE,
				'callback'				 => array( $this, 'auth_user' ),
				'permission_callback'	 => array( $this, 'auth_user_permissions_check' ),
				'args'					 => $this->get_endpoint_args_for_auth_user(),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
		) );

		//	register user endpoint
		register_rest_route( $this->namespace, '/' . $this->rest_base . '/register', array(
			array(
				'methods'				 => WP_REST_Server::CREATABLE,
				'callback'				 => array( $this, 'create_item' ),
				'permission_callback'	 => array( $this, 'register_user_permissions_check' ),
				'args'					 => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
		) );
	}

	/**
	 * Get a collection of users.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_items( $request ) {
		$response = parent::get_items( $request );
		return apply_filters( 'get_users', $response, $request );
	}

	/**
	 * Get a single user.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_item( $request ) {
		$response = parent::get_item( $request );
		return apply_filters( 'get_user', $response, $request );
	}

	/**
	 * Create a single user.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function create_item( $request ) {
		$response = parent::create_item( $request );
		return apply_filters( 'create_user', $response, $request );
	}

	/**
	 * Update a single user.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function update_item( $request ) {
		$response = parent::update_item( $request );
		return apply_filters( 'update_user', $response, $request );
	}

	/**
	 * Delete a single user.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function delete_item( $request ) {
		$response = parent::delete_item( $request );
		return apply_filters( 'delete_user', $response, $request );
	}

	/**
	 * permission check to register user
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	boolean
	 */
	public function register_user_permissions_check( $request ) {
		if ( is_user_logged_in() ) {
			return false;
		}
		$users_can_register = get_option( 'users_can_register', false );
		if ( ! $users_can_register ) {
			return false;
		}
		unset( $request['roles'] );
		return apply_filters( 'register_user_permissions_check', $request, true );
	}

	public function get_endpoint_args_for_auth_user() {
		$args = array();
		$user_args = $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE );
		$args['username'] = $user_args['username'];
		$args['password'] = $user_args['password'];
		return $args;
	}

	public function auth_user_permissions_check( $request ) {
		if ( is_user_logged_in() ) {
			return false;
		}
		$user = wp_authenticate( $request['username'], $request['password'] );
		return $user;
	}

	public function auth_user( $request ) {
		$user = wp_authenticate( $request['username'], $request['password'] );

		$data = array();
		$data['timestamp'] = current_time( 'mysql', 0 );
		$data['user_id'] = $user->ID;
		$data['token'] = md5( $user->data->user_pass . $data['timestamp'] );
		$data['auth'] = base64_encode( $request['username'] . ':' . $request['password'] );

		$string = maybe_serialize( $data );
		$access_token = wp_mobile_encrypt( $string );
		if ( ! $access_token ) {
			return flase;
		}
		$meta_key = 'wp_mobile_access_token';
		update_user_meta( $data['user_id'], $meta_key, $data['token'] );

		$user = $this->prepare_item_for_response( $user, $request );
		$user->data['access_token'] = $access_token;

		$response = rest_ensure_response( $user );
		$response = apply_filters( 'get_user', $response, $request );
		return apply_filters( 'auth_user', $response, $request );
	}

}
