<?php

class WP_Mobile_Controls {

	public function __construct() {

	}

	private function _attributes_to_string( $attributes ) {
		$html = '';
		//$abortList = array( 'name', 'id', 'value', 'type', 'class' );
		$abort_list = array( 'name', 'id' );
		if ( is_object( $attributes ) && count( $attributes ) > 0 ) {
			$attributes = (array) $attributes;
		}
		if ( is_array( $attributes ) && count( $attributes ) ) {
			foreach ( $attributes as $key => $value ) {
				$key = strtolower( $key );
				if ( ! in_array( $key, $abort_list ) ) {
					$html .= ' ' . $key . '="' . esc_attr( $value ) . '"';
				}
			}
		}
		return $html;
	}
	public function input( $name, $type = 'text', $args = array() ) {
		if ( empty( $name ) ) {
			return false;
		}
		$html = '';
		//	set default values
		$allow_types = array( 'text', 'email', 'number', 'tel', 'password' );
		$type = in_array( $type, $allow_types, true ) ? $type : 'text';
		$args['id'] = ! empty( $args['id'] ) ? $args['id'] : $name;
		$args['placeholder'] = ! empty( $args['placeholder'] ) ? $args['placeholder'] : __( 'Please select option', 'wp-mobile' );
		$args['value'] = empty( $args['value'] ) || is_array( $args['value'] ) ? false : $args['value'];
		$args['label'] = ! empty( $args['label'] ) ? $args['label'] : false;
		$args['html_attr'] = isset( $args['html_attr'] ) && is_array( $args['html_attr'] ) ? $args['html_attr'] : array();
		$args['attr'] = isset( $args['attr'] ) && count( $args['attr'] ) ? $args['attr'] : array();
		$args['attr']['required'] = isset( $args['attr']['required'] ) ? $args['attr']['required'] : true;
		if ( false === $args['attr']['required'] ) {
			unset( $args['attr']['required'] );
		}
		$attr_string = $this->_attributes_to_string( $args['attr'] );

		//	render label
		if ( ! empty( $args['label'] ) ) {
			$html .= ! empty( $args['html_attr']['before_label'] ) ? $args['html_attr']['before_label'] : '';
				$html .= '<label for="' . $name . '">' . esc_html( $args['label'] ) . '</label>';
			$html .= ! empty( $args['html_attr']['after_label'] ) ? $args['html_attr']['after_label'] : '';
		}
		$html .= ! empty( $args['html_attr']['before_control'] ) ? $args['html_attr']['before_control'] : '';
		$html .= '<input type="' . $type . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $args['id'] ) . '" ' . $attr_string . ' value="' . esc_attr( $args['value'] ) . '">';
		$html .= ! empty( $args['html_attr']['after_control'] ) ? $args['html_attr']['after_control'] : '';
		return $html;
	}

	public function dropdown( $name, $list = array(), $args = array(), $is_multiple = false ) {
		if ( empty( $name ) ) {
			return false;
		}
		$html = '';
		//	set default values
		$args['id'] = ! empty( $args['id'] ) ? $args['id'] : $name;
		$args['placeholder'] = ! empty( $args['placeholder'] ) ? $args['placeholder'] : __( 'Please select option', 'wp-mobile' );
		$args['value'] = ! empty( $args['value'] ) ? $args['value'] : array();
		$args['value'] = is_array( $args['value'] ) ? $args['value'] : array( $args['value'] );
		$args['label'] = ! empty( $args['label'] ) ? $args['label'] : false;
		$args['html_attr'] = isset( $args['html_attr'] ) && is_array( $args['html_attr'] ) ? $args['html_attr'] : array();
		$args['attr'] = isset( $args['attr'] ) && count( $args['attr'] ) ? $args['attr'] : array();
		$args['attr']['required'] = isset( $args['attr']['required'] ) ? $args['attr']['required'] : true;
		if ( false === $args['attr']['required'] ) {
			unset( $args['attr']['required'] );
		}
		if ( $is_multiple ) {
			$name .= '[]';
			$args['attr']['multiple'] = true;
		} else {
			unset( $args['attr']['multiple'] );
		}
		$attr_string = $this->_attributes_to_string( $args['attr'] );
		//	render label
		if ( ! empty( $args['label'] ) ) {
			$html .= ! empty( $args['html_attr']['before_label'] ) ? $args['html_attr']['before_label'] : '';
				$html .= '<label for="' . $name . '">' . esc_html( $args['label'] ) . '</label>';
			$html .= ! empty( $args['html_attr']['after_label'] ) ? $args['html_attr']['after_label'] : '';
		}
		$html .= ! empty( $args['html_attr']['before_control'] ) ? $args['html_attr']['before_control'] : '';
		//	render control
		$html .= '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $args['id'] ) . '" ' . $attr_string . '>';
		$html .= '<option ' . selected( $is_multiple, false, false ) . ' disabled >' . $args['placeholder'] . '</option>';
		foreach ( $list as $value => $data ) {
			$data['label'] = ! empty( $data['label'] ) ? $data['label'] : '';
			$data['attr_string'] = '';
			if ( isset( $data['attr'] ) && count( $data['attr'] ) ) {
				$data['attr_string'] = $this->_attributes_to_string( $data['attr'] );
			}
			$html .= '<option value="' . $value . '" ' . selected( in_array( $value , $args['value'] ), true, false ) . ' ' . $data['attr_string'] . ' >' . esc_attr( $data['label'] ) . '</option>';
		}
		$html .= '</select>';
		$html .= ! empty( $args['html_attr']['after_control'] ) ? $args['html_attr']['after_control'] : '';
		return $html;
	}

	public function checkbox( $name, $list = array(), $args = array() ) {
		if ( empty( $name ) ) {
			return false;
		}
		$html = '';

		//	set default values
		$args['id'] = ! empty( $args['id'] ) ? $args['id'] : $name;
		$args['value'] = ! empty( $args['value'] ) ? $args['value'] : array();
		$args['value'] = is_array( $args['value'] ) ? $args['value'] : array( $args['value'] );

		//	render label
		if ( ! empty( $args['label'] ) ) {
			$html .= ! empty( $args['html_attr']['before_label'] ) ? $args['html_attr']['before_label'] : '';
				$html .= '<label for="' . $name . '">' . esc_html( $args['label'] ) . '</label>';
			$html .= ! empty( $args['html_attr']['after_label'] ) ? $args['html_attr']['after_label'] : '';
		}
		$html .= ! empty( $args['html_attr']['before_control'] ) ? $args['html_attr']['before_control'] : '';
		foreach ( $list as $value => $data ) {
			$data['label'] = ! empty( $data['label'] ) ? $data['label'] : '';
			$data['id_html'] = ! empty( $data['id'] ) ? 'id="' . $data['id'] . '"' : '';
			$data['attr_string'] = '';
			if ( isset( $data['attr'] ) && count( $data['attr'] ) ) {
				$data['attr_string'] = $this->_attributes_to_string( $data['attr'] );
			}
			$html .= ! empty( $args['html_attr']['before_element'] ) ? $args['html_attr']['before_element'] : '';
			$html .= '<label class="button-checkbox">';
			$html .= '<input type="checkbox" value="' . $value . '" ' . $data['id_html'] . ' name="' . $name . '[' . $value . ']" ' . $data['attr_string'] . ' ' . checked( in_array( $value, $args['value'] ), true, false ) . '>';
			$html .= '&nbsp;' . $data['label'] . '</label>';
			$html .= ! empty( $args['html_attr']['after_element'] ) ? $args['html_attr']['after_element'] : '';
		}
		$html .= ! empty( $args['html_attr']['after_control'] ) ? $args['html_attr']['after_control'] : '';
		return $html;
	}

	public function radio( $name, $list = array(), $args = array() ) {
		if ( empty( $name ) ) {
			return false;
		}
		$html = '';

		//	set default values
		$args['id'] = ! empty( $args['id'] ) ? $args['id'] : $name;
		$args['value'] = ! empty( $args['value'] ) ? $args['value'] : array();
		$args['value'] = empty( $args['value'] ) || is_array( $args['value'] ) ? false : $args['value'];

		//	render label
		if ( ! empty( $args['label'] ) ) {
			$html .= ! empty( $args['html_attr']['before_label'] ) ? $args['html_attr']['before_label'] : '';
				$html .= '<label for="' . $name . '">' . esc_html( $args['label'] ) . '</label>';
			$html .= ! empty( $args['html_attr']['after_label'] ) ? $args['html_attr']['after_label'] : '';
		}

		$html .= ! empty( $args['html_attr']['before_element'] ) ? $args['html_attr']['before_element'] : '';
		foreach ( $list as $value => $data ) {
			$data['label'] = ! empty( $data['label'] ) ? $data['label'] : '';
			$data['id_html'] = ! empty( $data['id'] ) ? 'id="' . $data['id'] . '"' : '';
			$data['attr_string'] = '';
			if ( isset( $data['attr'] ) && count( $data['attr'] ) ) {
				$data['attr_string'] = $this->_attributes_to_string( $data['attr'] );
			}
			$html .= ! empty( $args['html_attr']['before_element'] ) ? $args['html_attr']['before_element'] : '';
			$html .= '<label class="button-radio">';
			$html .= '<input type="radio" value="' . $value . '" ' . $data['id_html'] . ' name="' . $name . '" ' . $data['attr_string'] . ' ' . checked( ( $value == $args['value'] ), true, false ) . '>';
			$html .= '&nbsp;' . $data['label'] . '</label>';
			$html .= ! empty( $args['html_attr']['after_element'] ) ? $args['html_attr']['after_element'] : '';
		}
		$html .= ! empty( $args['html_attr']['after_control'] ) ? $args['html_attr']['after_control'] : '';
		return $html;
	}

}
