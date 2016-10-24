<?php

class WP_Mobile_Comments_Controller extends WP_REST_Comments_Controller {

	/**
	 * construct method
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	string post type
	 * @return	void
	 */
	public function __construct() {
		parent::__construct();
		$this->namespace = apply_filters( 'get_rest_namespace', $this->namespace );
	}

	/**
	 * Get a collection of comments.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_items( $reuqest ) {
		$response = parent::get_items( $reuqest );
		return apply_filters( 'get_comments', $response, $reuqest );
	}

	/**
	 * Get a single comment.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_item( $request ) {
		$response = parent::get_item( $request );
		return apply_filters( 'get_comment', $response, $request );
	}

	/**
	 * Create a single comment.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function create_item( $request ) {
		$response = parent::create_item( $request );
		return apply_filters( 'create_comment', $response, $request );
	}

	/**
	 * Update a single comment.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function update_item( $request ) {
		$response = parent::update_item( $request );
		return apply_filters( 'update_comment', $response, $request );
	}

	/**
	 * Delete a single comment.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function delete_item( $request ) {
		$response = parent::delete_item( $request );
		return apply_filters( 'delete_comment', $response, $request );
	}

}
