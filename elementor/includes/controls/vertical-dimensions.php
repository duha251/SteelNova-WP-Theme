<?php
namespace SteelNova\Elementor\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Control_Dimensions;

/**
 * Elementor vertical dimensions control.
 *
 * A base control for creating a vertical dimensions control. Displays input fields for top and bottom values,
 * height/width and the option to link them together.
 *
 * @since 3.13.0
 */
class Control_Vertical_Dimensions extends Control_Dimensions {
	/**
	 * Get vertical dimensions control type.
	 *
	 * Retrieve the control type, in this case `vertical_dimensions`.
	 *
	 * @since 3.13.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'vertical_dimensions';
	}

	/**
	 * Get vertical dimensions control default values.
	 *
	 * Retrieve the default value of the vertical dimensions control. Used to return the default
	 * values while initializing the vertical dimensions control.
	 *
	 * @since 3.13.0
	 * @access public
	 *
	 * @return array Control default value.
	 */
	public function get_default_value() {
		return [
			'top' => '',
			'bottom' => '',
			'isLinked' => true,
			'unit' => 'px',
		];
	}

	public function get_singular_name() {
		return 'vertical dimension';
	}

	protected function get_dimensions() {
		return [
			'top' => esc_html__( 'Top', 'elementor' ),
			'bottom' => esc_html__( 'Bottom', 'elementor' ),
		];
	}

	public function get_value( $control, $settings ) {
		$value = parent::get_value( $control, $settings );

		// BC for any old Slider control values.
		if ( $this->should_update_gaps_values( $value ) ) {
			$value['top'] = strval( $value['size'] );
			$value['bottom'] = strval( $value['size'] );
		}

		return $value;
	}

	private function should_update_gaps_values( $value ) {
		return isset( $value['size'] ) && '' !== $value['size'] && '' === $value['top'];
	}
}
