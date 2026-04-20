<?php
namespace SteelNova\Elementor\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

class Group_Control_Width extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'width';
	}

	protected function init_fields() {
		$start = is_rtl() ? 'right' : 'left';
		$end = is_rtl() ? 'left' : 'right';

		$fields = [];

        $fields['steelnova_width'] = [
            'label' => __('Width', 'steelnova'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'custom' ],
            'range' => [
                'px' => [ 'min' => -3000, 'max' => 3000 ],
                '%'  => [ 'min' => -100, 'max' => 100 ],
            ],
            'default' => [
                'unit' => 'px',
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'width: {{SIZE}}{{UNIT}};',
            ],
			'responsive' => true,
        ];

        $fields['steelnova_min_width'] = [
            'label' => __('Min Width', 'steelnova'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'custom' ],
            'range' => [
                'px' => [ 'min' => -3000, 'max' => 3000 ],
                '%'  => [ 'min' => -100, 'max' => 100 ],
            ],
            'default' => [
                'unit' => 'px',
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'min-width: {{SIZE}}{{UNIT}};',
            ],
			'responsive' => true,
        ];

        $fields['steelnova_max_width'] = [
            'label' => __('Max Width', 'steelnova'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'custom' ],
            'range' => [
                'px' => [ 'min' => -3000, 'max' => 3000 ],
                '%'  => [ 'min' => -100, 'max' => 100 ],
            ],
            'default' => [
                'unit' => 'px',
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
			'responsive' => true,
        ];


		return $fields;
	}

	protected function get_default_options() {
		return [
            'popover' => [
				'starter_name' => 'width',
				'starter_title' => esc_html__( 'Width', 'elementor' ),
				'settings' => [
					'render_type' => 'ui',
				],
			],
		];
	}
}
