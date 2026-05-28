<?php
namespace SteelNova\Elementor\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

class Group_Control_Flex_CSS extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'flex-css';
	}

	protected function init_fields() {
		$start = is_rtl() ? 'right' : 'left';
		$end = is_rtl() ? 'left' : 'right';

		$fields = [];

		$fields['direction'] = [
			'label' => esc_html__( 'Direction', 'steelnova' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'row' => [
					'title' => esc_html__( 'Row - horizontal', 'steelnova' ),
					'icon' => 'eicon-arrow-' . $end,
				],
				'column' => [
					'title' => esc_html__( 'Column - vertical', 'steelnova' ),
					'icon' => 'eicon-arrow-down',
				],
				'row-reverse' => [
					'title' => esc_html__( 'Row - reversed', 'steelnova' ),
					'icon' => 'eicon-arrow-' . $start,
				],
				'column-reverse' => [
					'title' => esc_html__( 'Column - reversed', 'steelnova' ),
					'icon' => 'eicon-arrow-up',
				],
			],
			'default' => '',
			'selectors' => [
				'{{SELECTOR}}' => 'flex-direction: {{VALUE}};',
			],
			'responsive' => true,
		];

		$fields['justify_content_vertical'] = [
			'label' => esc_html__( 'Justify Content', 'steelnova' ),
			'type' => Controls_Manager::CHOOSE,
			'label_block' => true,
			'default' => '',
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Start', 'steelnova' ),
					'icon' => 'eicon-justify-start-h',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'steelnova' ),
					'icon' => 'eicon-justify-center-h',
				],
				'flex-end' => [
					'title' => esc_html__( 'End', 'steelnova' ),
					'icon' => 'eicon-justify-end-h',
				],
				'space-between' => [
					'title' => esc_html__( 'Space Between', 'steelnova' ),
					'icon' => 'eicon-justify-space-between-h',
				],
				'space-around' => [
					'title' => esc_html__( 'Space Around', 'steelnova' ),
					'icon' => 'eicon-justify-space-around-h',
				],
				'space-evenly' => [
					'title' => esc_html__( 'Space Evenly', 'steelnova' ),
					'icon' => 'eicon-justify-space-evenly-h',
				],
			],
            'condition' => [
                'direction' => ['row', 'row-reverse', ''],
            ],
			'selectors' => [
				'{{SELECTOR}}' => 'justify-content: {{VALUE}};',
			],
			'responsive' => true,
		];

        $fields['justify_content_horizontal'] = [
			'label' => esc_html__( 'Justify Content', 'steelnova' ),
			'type' => Controls_Manager::CHOOSE,
			'label_block' => true,
			'default' => '',
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Start', 'steelnova' ),
					'icon' => 'eicon-justify-start-v',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'steelnova' ),
					'icon' => 'eicon-justify-center-v',
				],
				'flex-end' => [
					'title' => esc_html__( 'End', 'steelnova' ),
					'icon' => 'eicon-justify-end-v',
				],
				'space-between' => [
					'title' => esc_html__( 'Space Between', 'steelnova' ),
					'icon' => 'eicon-justify-space-between-v',
				],
				'space-around' => [
					'title' => esc_html__( 'Space Around', 'steelnova' ),
					'icon' => 'eicon-justify-space-around-v',
				],
				'space-evenly' => [
					'title' => esc_html__( 'Space Evenly', 'steelnova' ),
					'icon' => 'eicon-justify-space-evenly-v',
				],
			],
            'condition' => [
                'direction' => ['column', 'column-reverse'],
            ],
			'selectors' => [
				'{{SELECTOR}}' => 'justify-content: {{VALUE}};',
			],
			'responsive' => true,
		];

		$fields['align_items_horizontal'] = [
			'label' => esc_html__( 'Align Items', 'steelnova' ),
			'type' => Controls_Manager::CHOOSE,
			'default' => '',
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Start', 'steelnova' ),
					'icon' => 'eicon-align-start-v',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'steelnova' ),
					'icon' => 'eicon-align-center-v',
				],
				'flex-end' => [
					'title' => esc_html__( 'End', 'steelnova' ),
					'icon' => 'eicon-align-end-v',
				],
				'stretch' => [
					'title' => esc_html__( 'Stretch', 'steelnova' ),
					'icon' => 'eicon-align-stretch-v',
				],
			],
            'condition' => [
                'direction' => ['row', 'row-reverse', ''],
            ],
			'selectors' => [
				'{{SELECTOR}}' => 'align-items: {{VALUE}};',
			],
			'responsive' => true,
		];

        $fields['align_items_vertical'] = [
			'label' => esc_html__( 'Align Items', 'steelnova' ),
			'type' => Controls_Manager::CHOOSE,
			'default' => '',
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Start', 'steelnova' ),
					'icon' => 'eicon-align-start-h',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'steelnova' ),
					'icon' => 'eicon-align-center-h',
				],
				'flex-end' => [
					'title' => esc_html__( 'End', 'steelnova' ),
					'icon' => 'eicon-align-end-h',
				],
				'stretch' => [
					'title' => esc_html__( 'Stretch', 'steelnova' ),
					'icon' => 'eicon-align-stretch-h',
				],
			],
            'condition' => [
                'direction' => ['column', 'column-reverse'],
            ],
			'selectors' => [
				'{{SELECTOR}}' => 'align-items: {{VALUE}};',
			],
			'responsive' => true,
		];

		$fields['gap'] = [
			'label' => esc_html__( 'Gaps', 'steelnova' ),
			'type' => Controls_Manager::GAPS,
			'size_units' => [ 'px', 'custom' ],
			'default' => [
				'unit' => 'px',
			],
			'separator' => 'before',
			'selectors' => [
				'{{SELECTOR}}' => 'gap: {{ROW}}{{UNIT}} {{COLUMN}}{{UNIT}};',
			],
			'responsive' => true,
			'conversion_map' => [
				'old_key' => 'size',
				'new_key' => 'column',
			],
			'upgrade_conversion_map' => [
				'old_key' => 'size',
				'new_keys' => [ 'column', 'row' ],
			],
			'validators' => [
				'Number' => [
					'min' => 0,
				],
			],
		];

		$fields['wrap'] = [
			'label' => esc_html__( 'Wrap', 'steelnova' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'nowrap' => [
					'title' => esc_html__( 'No Wrap', 'steelnova' ),
					'icon' => 'eicon-nowrap',
				],
				'wrap' => [
					'title' => esc_html__( 'Wrap', 'steelnova' ),
					'icon' => 'eicon-wrap',
				],
			],
			'default' => '',
			'selectors' => [
				'{{SELECTOR}}' => 'flex-wrap: {{VALUE}};',
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
