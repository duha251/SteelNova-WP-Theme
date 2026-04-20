<?php
namespace SteelNova\Elementor\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

class Group_Control_Position extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'position';
	}

	protected function init_fields() {
		$start = is_rtl() ? 'right' : 'left';
		$end = is_rtl() ? 'left' : 'right';

		$fields = [];

		$fields['position'] = [
            'type'  => Controls_Manager::SELECT,
            'label'  => __('Position', 'steelnova'),
            'separator' => 'before',
            'default' => '',
            'options' => [
                ''         => __('Default', 'steelnova'),
                'absolute' => __('Absolute', 'steelnova'),
                'fixed'    => __('Fixed', 'steelnova'),
                'relative' => __('Relative', 'steelnova'),
                'static'   => __('Static', 'steelnova'),
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'position: {{VALUE}} !important;',
            ],
			'responsive' => true,
		];

        $fields['orientation_horizontal'] = [
            'label' => __('Horizontal Orientation', 'steelnova'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'left',
            'toggle' => false,
            'options' => [
                'left' => [
                    'title' => __('Left', 'steelnova'),
                    'icon'  => 'eicon-arrow-left',
                ],
                'right' => [
                    'title' => __('Right', 'steelnova'),
                    'icon'  => 'eicon-arrow-right',
                ]
            ],
            'condition' => [
                'position' => ['absolute', 'fixed', 'sticky']
            ],
			'responsive' => true,
        ];

        $fields['offset_left'] = [
            'label' => __('Offset Left', 'steelnova'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'custom' ],
            'range' => [
                'px' => [ 'min' => 0 ],
                '%'  => [ 'min' => 0 ],
            ],
            'default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
            ],
            'condition' => [
                'position' => ['absolute', 'fixed', 'sticky'],
                'orientation_horizontal' => 'left'
            ],
			'responsive' => true,
        ];

        $fields['offset_right'] = [
            'label' => __('Offset Right', 'steelnova'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'custom' ],
            'range' => [
                'px' => [ 'min' => 0 ],
                '%'  => [ 'min' => 0 ],
            ],
            'default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
            ],
            'condition' => [
                'position' => ['absolute', 'fixed', 'sticky'],
                'orientation_horizontal' => 'right'
            ],
			'responsive' => true,
        ];  

         $fields['orientation_vertical'] = [
            'label' => __('Vertical Orientation', 'steelnova'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'top',
            'toggle' => false,
            'options' => [
                'top' => [
                    'title' => __('Top', 'steelnova'),
                    'icon'  => 'eicon-arrow-up',
                ],
                'bottom' => [
                    'title' => __('Bottom', 'steelnova'),
                    'icon'  => 'eicon-arrow-down',
                ]
            ],
            'condition' => [
                'position' => ['absolute', 'fixed', 'sticky']
            ],
			'responsive' => true,
        ];

        $fields['offset_top'] = [
            'label' => __('Offset Top', 'steelnova'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'custom' ],
            'range' => [
                'px' => [ 'min' => 0 ],
                '%'  => [ 'min' => 0 ],
            ],
            'default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
            ],
            'condition' => [
                'position' => ['absolute', 'fixed', 'sticky'],
                'orientation_vertical' => 'top'
            ],
			'responsive' => true,
        ];

        $fields['offset_bottom'] = [
            'label' => __('Offset Bottom', 'steelnova'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'custom' ],
            'range' => [
                'px' => [ 'min' => 0 ],
                '%'  => [ 'min' => 0 ],
            ],
            'default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{SELECTOR}}' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
            ],
            'condition' => [
                'position' => ['absolute', 'fixed', 'sticky'],
                'orientation_vertical' => 'bottom'
            ],
			'responsive' => true,
        ];

		return $fields;
	}

	protected function get_default_options() {
		return [
			'popover' => false,
		];
	}
}
