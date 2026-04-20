<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Counter extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-counter',
            'title'      => __( 'CS Counter', 'steelnova' ),
            'icon'       => 'eicon-counter',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'counter', 'number', 'statistic' ],
            'script'     => ['steelnova-counter'],
            'style'      => ['steelnova-widget-counter']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_number_style_controls();
        $this->register_counter_prefix_style_controls();
        $this->register_counter_suffix_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_controls() {
        $this->start_layout_section([
            'name' => 'section_layout',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->group_flex_css([
            'name' => 'flex_css',
            'selector' => '{{WRAPPER}} .icon-text',
            'exclude' => ['align_items_vertical', 'justify_content_vertical', 'gaps', 'direction', 'wrap'],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Counter', 'steelnova' ),
        ]);
        $this->number([
            'name' => 'starting_number',
            'label' => esc_html__('Starting Number', 'steelnova'),
            'separator' => 'before',
            'min' => 1,
            'default' => 1,
        ]);
        $this->number([
            'name' => 'ending_number',
            'label' => esc_html__('Ending Number', 'steelnova'),
            'min' => 1,
            'default' => 100,
        ]);
        $this->text([
            'name' => 'number_prefix',
            'label' => esc_html__('Number Prefix', 'steelnova'),
            'label_block' => false,
            'separator' => 'before',
        ]);
        $this->text([
            'name' => 'number_suffix',
            'label_block' => false,
            'label' => esc_html__('Number Suffix', 'steelnova'),
        ]);
        $this->select([
            'name' => 'number_delimiter',
            'label' => esc_html__('Number Delimiter', 'steelnova'),
            'separator' => 'before',
            'options' => [
                ''  => esc_html__('None', 'steelnova'),
                '.' => esc_html__('Dot', 'steelnova'),
                ',' => esc_html__('Comma', 'steelnova'),
                ' ' => esc_html__('Space', 'steelnova'),
            ],
            'default' => '',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Counter Number Style Controls
     */
    protected function register_number_style_controls() {
        $this->start_style_section([
            'name' => 'section_number_style',
            'label' => __( 'Number', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'counter_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .counter' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'counter_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .counter' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->group_background([
            'name' => 'counter_background',
            'separator' => 'before',
            'selector' => '{{WRAPPER}} .counter',
        ]);
        $this->group_typography([
            'name' => 'counter_typography',
            'selector' => '{{WRAPPER}} .counter',
        ]);
        $this->group_background([
			'name' => 'counter_fill',
			'selector' => '{{WRAPPER}} .counter',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'steelnova' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'steelnova' ),
					'selectors' => [
						'{{WRAPPER}} .counter' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .counter' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .counter' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_box_css([
            'name' => 'counter_',
            'selector' => '{{WRAPPER}} .counter',
        ]);
        $this->end_controls_section();
    }


    /**
     * Register Counter Prefix Value Style Controls
     */
    protected function register_counter_prefix_style_controls() {
        $this->start_style_section([
            'name' => 'section_counter_prefix_style',
            'label' => __( 'Number Prefix', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'counter_prefix_typography',
            'selector' => '{{WRAPPER}} .counter .counter__value-prefix',
        ]);
        $this->color([
            'name' => 'counter_prefix_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .counter .counter__value-prefix' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Counter Suffix Value Style Controls
     */
    protected function register_counter_suffix_style_controls() {
        $this->start_style_section([
            'name' => 'section_counter_suffix_style',
            'label' => __( 'Number Suffix', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'counter_suffix_typography',
            'selector' => '{{WRAPPER}} .counter .counter__value-suffix',
        ]);
        $this->color([
            'name' => 'counter_suffix_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .counter .counter__value-suffix' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_section();
    }

}