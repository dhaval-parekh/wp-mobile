<?php

class WP_Mobile_Terms_Controller extends WP_REST_Terms_Controller {

	/**
	 * construct method
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	string taxonomy
	 * @return	void
	 */
	public function __construct( $taxonomy ) {
		parent::__construct( $taxonomy );
		$this->namespace = apply_filters( 'get_rest_namespace', $this->namespace );
	}

	/**
	 * Get a collection of terms.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_items( $reuqest ) {
		$response = parent::get_items( $reuqest );
		return apply_filters( "get_{$this->taxonomy}_items", $response, $reuqest );
	}

	/**
	 * Get a single terms.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_item( $request ) {
		$response = parent::get_item( $request );
		return apply_filters( "get_{$this->taxonomy}_item", $response, $request );
	}

	/**
	 * Create a single term.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function create_item( $request ) {
		$response = parent::create_item( $request );
		return apply_filters( "create_{$this->taxonomy}_item", $response, $request );
	}

	/**
	 * Update a single term.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function update_item( $request ) {
		$response = parent::update_item( $request );
		return apply_filters( "update_{$this->taxonomy}_item", $response, $request );
	}

	/**
	 * Delete a single term.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function delete_item( $request ) {
		$response = parent::delete_item( $request );
		return apply_filters( "delete_{$this->taxonomy}_item", $response, $request );
	}

}
