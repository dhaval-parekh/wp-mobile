<?php

if ( ! function_exists( 'wp_mobile_encrypt' ) ) {

	/**
	 * encrypt content
	 *
	 * @access	public
	 * @since	1.0.0
	 * @param	string $decrypted decrypted content
	 * @return	mix
	 */
	function wp_mobile_encrypt( $decrypted ) {
		if ( empty( $decrypted ) ) {
			return false;
		}
		$crypto = new WP_Mobile_Crypto();
		if ( is_ssl() ) {
			$password = SECURE_AUTH_KEY;
			$salt = SECURE_AUTH_SALT;
		} else {
			$password = AUTH_KEY;
			$salt = AUTH_SALT;
		}
		return $crypto->encrypt( $decrypted, $password, $salt );
	}

}

if ( ! function_exists( 'wp_mobile_decrypt' ) ) {

	/**
	 * decrypt content
	 *
	 * @access	public
	 * @since	1.0.0
	 * @param	string $encrypted encrypted content
	 * @return	mix
	 */
	function wp_mobile_decrypt( $encrypted ) {
		if ( empty( $encrypted ) ) {
			return false;
		}
		$crypto = new WP_Mobile_Crypto();
		if ( is_ssl() ) {
			$password = SECURE_AUTH_KEY;
			$salt = SECURE_AUTH_SALT;
		} else {
			$password = AUTH_KEY;
			$salt = AUTH_SALT;
		}
		return $crypto->decrypt( $encrypted, $password, $salt );
	}

}
