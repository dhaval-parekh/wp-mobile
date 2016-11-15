<?php

class WP_Mobile_Crypto {

	/**
	 * encrypt the content
	 *
	 * @access	public
	 * @since	1.0.0
	 * @param	string $decrypted decrypted content
	 * @param	string $password password which use for encryption
	 * @param	string $salt salt which use for encryption
	 * @return	mix encrypted content
	 */
	public function encrypt( $decrypted, $password, $salt = ']w!#D{x3#)s&*f@#$' ) {
		$key = hash( 'SHA256', $salt . $password, true );
		srand();
		$iv = mcrypt_create_iv( mcrypt_get_iv_size( MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC ), MCRYPT_RAND );
		if ( strlen( $iv_base64 = rtrim( base64_encode( $iv ), '=' ) ) != 22 ) {
			return false;
		}
		$encrypted = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_128, $key, $decrypted . md5( $decrypted ), MCRYPT_MODE_CBC, $iv ) );
		return $iv_base64 . $encrypted;
	}

	/**
	 * decrypt the encrypted content
	 *
	 * @access	public
	 * @since	1.0.0
	 * @param	string $encrypted encrypted content for decryption
	 * @param	string $password password which used at a time of encryption
	 * @param	string $salt salt which used at a time of encryption
	 * @return	mix	decrupted content
	 */
	public function decrypt( $encrypted, $password, $salt = ']w!#D{x3#)s&*f@#$' ) {
		$key = hash( 'SHA256', $salt . $password, true );
		$iv = base64_decode( substr( $encrypted, 0, 22 ) . '==' );
		$encrypted = substr( $encrypted, 22 );
		$decrypted = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_128, $key, base64_decode( $encrypted ), MCRYPT_MODE_CBC, $iv ), "\0\4" );
		$hash = substr( $decrypted, -32 );
		$decrypted = substr( $decrypted, 0, -32 );
		if ( md5( $decrypted ) != $hash ) {
			return false;
		}
		return $decrypted;
	}

}
