<?php

class WP_Mobile_Users_Controller extends WP_REST_Users_Controller {

	public function __construct() {
		parent::__construct();
		$this->namespace = apply_filters( 'get_rest_namespace', $this->namespace );
	}

	/**
	 * Get a collection of posts.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_items( $reuqest ) {
		$response = parent::get_items( $reuqest );
		return apply_filters( 'get_users', $response, $reuqest );
	}

	/**
	 * Get a single post.
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
	 * Create a single post.
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
	 * Update a single post.
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
	 * Delete a single post.
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

}
