<?php
namespace SteelNova\Elementor\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

class Group_Control_Height extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'height';
	}

	protected function init_fields() {
		$start = is_rtl() ? 'right' : 'left';
		$end = is_rtl() ? 'left' : 'right';

		$fields = [];

        $fields['steelnova_height'] = [
            'label' => __('Height', 'steelnova'),
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
                '{{SELECTOR}}' => 'height: {{SIZE}}{{UNIT}};',
            ],
			'responsive' => true,
        ];

        $fields['steelnova_min_height'] = [
            'label' => __('Min Height', 'steelnova'),
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
                '{{SELECTOR}}' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
			'responsive' => true,
        ];

        $fields['steelnova_max_height'] = [
            'label' => __('Max Height', 'steelnova'),
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
                '{{SELECTOR}}' => 'max-height: {{SIZE}}{{UNIT}};',
            ],
			'responsive' => true,
        ];


		return $fields;
	}

	protected function get_default_options() {
		return [
            'popover' => [
				'starter_name' => 'height',
				'starter_title' => esc_html__( 'Height', 'elementor' ),
				'settings' => [
					'render_type' => 'ui',
				],
			],
		];
	}
}
