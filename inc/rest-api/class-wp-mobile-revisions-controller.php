<?php

class WP_Mobile_Revisions_Controller extends WP_REST_Revisions_Controller {

	public function __construct( $parent_post_type ) {
		parent::__construct( $parent_post_type );
		$this->namespace = apply_filters( 'get_rest_namespace', $this->namespace );
	}

	/**
	 * Get a collection of revisions.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_items( $request ) {
		$response = parent::get_items( $request );
		return apply_filters( 'get_revisions', $response, $request );
	}

	/**
	 * Get a single revision.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_item( $request ) {
		$response = parent::get_item( $request );
		return apply_filters( 'get_revision', $response, $request );
	}

	/**
	 * Delete a revision.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function delete_item( $request ) {
		$response = parent::delete_item( $request );
		return apply_filters( 'delete_revision', $response, $request );
	}

}
