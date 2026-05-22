<?php
namespace SteelNova\Elementor\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;
use SteelNova\Inc\Helpers\Static_Options;

class Group_Control_Entrance_Animation extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'entrance-animation';
	}

	protected function init_fields() {
		$start = is_rtl() ? 'right' : 'left';
		$end = is_rtl() ? 'left' : 'right';

		$fields = [];

		$fields['entrance_anim'] = [
			'label' => esc_html__( 'Entrance Animation', 'elementor' ),
			'type' => Controls_Manager::SELECT,
			'groups' => Static_Options::entrance_animation_options(),
			'default' => '',
		];

        $fields['entrance_anim_duration'] = [
            'name' => 'subtitle_entrance_anim_duration',
            'label' => __('Animation Duration', 'steelnova'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['s', 'ms'],
            'range' => [
                'ms' => [
                    'min' => 0,
                    'max' => 100000,
                    'step' => 10,
                ],
                's' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 0.01,
                ],
            ],
            'mobile_default' => [
                'unit' => 'ms',
            ],
            'mobile_extra_default' => [
                'unit' => 'ms',
            ],
            'tablet_default' => [
                'unit' => 'ms',
            ],
            'tablet_extra_default' => [
                'unit' => 'ms',
            ],
            'laptop_default' => [
                'unit' => 'ms',
            ],
            'widescreen_default' => [
                'unit' => 'ms',
            ],
            'default' => [
                'unit' => 'ms',
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'entrance_anim!' => ''
            ],
            'responsive' => true
        ];

        $fields['entrance_anim_delay'] = [
            'name' => 'subtitle_entrance_anim_delay',
            'label' => __('Animation Delay', 'steelnova'),
            'size_units' => ['s', 'ms'],
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'ms' => [
                    'min' => 0,
                    'max' => 100000,
                    'step' => 10,
                ],
                's' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 0.01,
                ],
            ],
            'mobile_default' => [
                'unit' => 'ms',
            ],
            'mobile_extra_default' => [
                'unit' => 'ms',
            ],
            'tablet_default' => [
                'unit' => 'ms',
            ],
            'tablet_extra_default' => [
                'unit' => 'ms',
            ],
            'laptop_default' => [
                'unit' => 'ms',
            ],
            'widescreen_default' => [
                'unit' => 'ms',
            ],
            'default' => [
                'unit' => 'ms',
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'entrance_anim!' => ''
            ],
            'responsive' => true
        ];

		return $fields;
	}

	protected function get_default_options() {
		return [
			'popover' => false,
		];
	}
}
