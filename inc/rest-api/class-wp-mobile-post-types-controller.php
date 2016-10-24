<?php

class WP_Mobile_Post_Types_Controller extends WP_REST_Post_Types_Controller {

	public function __construct() {
		parent::__construct();
		$this->namespace = apply_filters( 'get_rest_namespace', $this->namespace );
	}

	/**
	 * Get a collection of post types.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_items( $request ) {
		$response = parent::get_items( $request );
		return apply_filters( 'get_post_types', $response, $request );
	}

	/**
	 * Get a single posttype.
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	WP_REST_Request $request Full details about the request.
	 * @return	WP_REST_Response|WP_Error
	 */
	public function get_item( $request ) {
		$response = parent::get_item( $request );
		return apply_filters( 'get_post_type', $response, $request );
	}
}
