<?php

/**
 * Test the main plugin 
 * 
 * @since 1.0.0
 * @package wp-mobile
 */
class Test_WP_Mobile extends \PHPUnit_Framework_TestCase { // WP_UnitTestCase {

	public function __construct() {
	}
	/**
	 * @see Application_Passwords::add_hooks()
	 */
	function test_test() {
		$this->assertEquals( 10, 10 );
	}

}
