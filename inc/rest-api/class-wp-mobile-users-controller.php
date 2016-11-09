<?php

class WP_Mobile_Users_Controller extends WP_REST_Users_Controller {

	public function __construct() {
		parent::__construct();
		$this->namespace = apply_filters( 'get_rest_namespace', $this->namespace );
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

}
