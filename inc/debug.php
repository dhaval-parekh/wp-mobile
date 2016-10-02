<?php

if ( ! function_exists( 'display' ) ) {

	/**
	 * show any object in readable format
	 * 
	 * @access public
	 * @param mix $object
	 * @since 1.0.0
	 */
	function display( $object ) {
		echo '<pre style="background:#FFF;max-height: 300px; overflow: auto; width:100%;" >';
		print_r( $object );
		echo '</pre>';
	}

}
