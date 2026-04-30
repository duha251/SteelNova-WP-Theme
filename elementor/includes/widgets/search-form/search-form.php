<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Search_Form extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-search-form',
            'title'      => __( 'CS Search Form', 'steelnova' ),
            'icon'       => 'eicon-site-search',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'search', 'form', 'input', 'field' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    protected function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        // $this->register_label_style_controls();
        $this->register_input_style_controls();
        $this->register_button_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }
    

    /**
     * Register Layout Controls
     */
    protected function register_layout_controls() {
        $this->start_layout_section([
            'name' => 'section_layout',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->group_flex_css([
            'name' => 'flex_css',
            'selector' => '{{WRAPPER}} .cs-search-form',
        ]);

        // Button Position
        $this->group_position([
            'name' => 'button_position',
            'separator' => 'before',
            'selector' =>'{{WRAPPER}} .cs-search-form .cs-search-form__submit',
            'fields_options' => [
                'position' => [
                    'label' => __('Button Position', 'steelnova'),
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Search Form', 'steelnova') 
        ]);
        $this->text([
            'name' => 'placeholder',
            'label' => __('Placeholder', 'steelnova'),
            'default' => __('Search Here..', 'steelnova'),
        ]);
        $this->select([
            'name' => 'post_type',
            'label' => __('Search Post Type', 'steelnova'),
            'options' => [
                ''        => __('All', 'steelnova'),
                'post'    => __('Post', 'steelnova'),
                'service' => __('Service', 'steelnova'),
                'project' => __('Project', 'steelnova'),
                'product' => __('Product', 'steelnova'),
            ],
            'default' => 'post'
        ]);
        $this->text([
            'name' => 'btn_text',
            'label' => __('Button Text', 'steelnova'),
            'separator' => 'before',
            'default' => __('Click here', 'steelnova'),
        ]);
        $this->icons([
            'name' => 'btn_icon',
            'label' => __('Button Icon', 'steelnova'),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Label Style Controls
     */
    protected function register_label_style_controls() {
        $this->start_style_section([
            'name' => 'section_label_style',
            'label' => __('Label', 'steelnova'),
        ]);
        $this->slider([
            'name' => 'label_spacing',
            'label' => __('Label Spacing', 'steelnova'),
            'size_units' => [ 'px', 'custom' ],
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->group_typography([
            'name' => 'label_typography',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__label',
        ]);
        $this->color([
            'name' => 'label_color',
            'label' => __('Text Color', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__label' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Input Style Controls
     */
    protected function register_input_style_controls() {
        $this->start_style_section([
            'name' => 'section_input_style', 
            'label' => __('Input', 'steelnova'),
        ]);
        $this->slider([
            'name' => 'input_height',
            'label' => __('Field Height', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__field' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->group_typography([
            'name' => 'input_typography',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__field',
        ]);
        $this->start_controls_tabs( 'input_tabs' );

        // Normal Tab Style
        $this->_start_controls_tab([
			'name' => 'input_normal_tab',
			'label' => __( 'Normal', 'steelnova' ),
		]);
        $this->color([
            'name' => 'input_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__field' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'input_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__field',
        ]);
        $this->group_box_css([
            'name' => 'input_',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__field'
        ]);
        $this->end_controls_tab();

        // Hover Tab Style
        $this->_start_controls_tab([
			'name' => 'input_hover_tab',
			'label' => __( 'Hover', 'steelnova' ),
		]);
        $this->color([
            'name' => 'input_hover_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__field:hover' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
			'name' => 'input_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__field:hover',
		]);
        // Border Color 
        $this->color([
			'name' => 'input_hover_border_color',
			'label' => __( 'Border Color', 'steelnova' ),
			'selectors' => [
				'{{WRAPPER}} .cs-search-form .cs-search-form__field:hover' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_box_css([
            'name' => 'input_hover',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__field:hover'
        ]);
        $this->time([
            'name' => 'input_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__field' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();

        // Focus Tab Style
        $this->_start_controls_tab([
			'name' => 'input_focus_tab',
			'label' => __( 'Focus', 'steelnova' ),
		]);
        $this->color([
            'name' => 'input_focus_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__field:focus' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
			'name' => 'input_focus_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__field:focus',
		]);
        $this->color([
			'name' => 'input_focus_border_color',
			'label' => __( 'Border Color', 'steelnova' ),
			'selectors' => [
				'{{WRAPPER}} .cs-search-form .cs-search-form__field:focus' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_box_css([
            'name' => 'input_focus',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__field:focus'
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Button Style Controls
     */
    protected function register_button_style_controls( $args = [] ) {
        $this->start_style_section([
            'name' => 'section_button_style',
            'label' => __( 'Button', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'btn_width',
            'label' => __( 'Button Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__submit' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'btn_height',
            'label' => __( 'Button Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__submit' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__submit .cs-button__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-search-form .cs-search-form__submit .cs-button__icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->group_typography([
            'name' => 'btn_typography',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__submit',
            'separator' => 'before'
        ]);
        $this->_start_controls_tabs([
            'name' => 'btn_style_tabs',
        ]);
        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'btn_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'btn_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__submit' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'btn_background',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__submit',
        ]);
        $this->group_box_css([
            'name' => 'btn_box_css',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__submit',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'btn_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'btn_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__submit:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'btn_background_hover',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__submit:not(.background-gradient):hover,
                           {{WRAPPER}} .cs-search-form .cs-search-form__submit:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'btn_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-search-form .cs-search-form__submit:hover',
        ]);
        $this->select([
            'name' => 'btn_hover_style',
            'label' => __('Hover Style', 'steelnova'),
            'separator' => 'before',
            'options' => [
                ''    => __('None', 'steelnova'),
            ],
        ]);
        $this->time([
            'name' => 'btn_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-search-form .cs-search-form__submit' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}