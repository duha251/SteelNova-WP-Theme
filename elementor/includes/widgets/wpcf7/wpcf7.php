<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

use SteelNova\Inc\Helpers\Static_Options;

class Widget_WPCF7 extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-wpcf7',
            'title'      => __( 'CS WPCF7', 'steelnova' ),
            'icon'       => 'eicon-form-horizontal',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'wpcf7', 'contact form 7', 'form', 'contact form' ],
            'script'     => [],
            'style'      => ['steelnova-widget-wpcf7'],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    protected function register_controls() {
        // Content Controls
        $this->register_content_section();
        // Style Controls
        $this->register_label_style_controls();
        $this->register_input_style_controls();
        $this->register_textarea_style_controls();
        $this->register_select_style_controls();
        $this->register_error_message_style_controls();
        $this->register_error_note_style_controls();
        // Settings Controls
        $this->register_grid_settings_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_section() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Content', 'steelnova') 
        ]);
        $this->select([
            'name'  => 'wpcf7_form_id',
            'label' => __('WPCF7 Form', 'steelnova'),
            'options' => Static_Options::wpcf7_form_options(),
            'default' => '0',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register label style controls
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
                '{{WRAPPER}} .wpcf7 form.wpcf7-form label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->color([
            'name' => 'label_color',
            'label' => __('Text Color', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form label, {{WRAPPER}} .wpcf7 form.wpcf7-form .label' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_typography([
            'name' => 'label_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form label, {{WRAPPER}} .wpcf7 form.wpcf7-form .label',
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
                '{{WRAPPER}} .wpcf7 form.wpcf7-form input' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->group_typography([
            'name' => 'input_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input',
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
                '{{WRAPPER}} .wpcf7 form.wpcf7-form input' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'input_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input',
        ]);
        $this->group_box_css([
            'name' => 'input_',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input'
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
                '{{WRAPPER}} .wpcf7 form.wpcf7-form input:hover' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
			'name' => 'input_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input:hover',
		]);
        // Border Color 
        $this->color([
			'name' => 'input_hover_border_color',
			'label' => __( 'Border Color', 'steelnova' ),
			'selectors' => [
				'{{WRAPPER}} .wpcf7 form.wpcf7-form input:hover' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_box_css([
            'name' => 'input_hover',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input:hover'
        ]);
        $this->time([
            'name' => 'input_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form input' => 'transition-duration: {{SIZE}}{{UNIT}};'
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
                '{{WRAPPER}} .wpcf7 form.wpcf7-form input:focus' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
			'name' => 'input_focus_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input:focus',
		]);
        $this->color([
			'name' => 'input_focus_border_color',
			'label' => __( 'Border Color', 'steelnova' ),
			'selectors' => [
				'{{WRAPPER}} .wpcf7 form.wpcf7-form input:focus' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_box_css([
            'name' => 'input_focus',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input:focus'
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Textarea Style Controls
     */
    protected function register_textarea_style_controls() {
        $this->start_style_section([
            'name' => 'section_textarea_style', 
            'label' => __('Texarea', 'steelnova'),
        ]);
        $this->slider([
            'name' => 'textarea_height',
            'label' => __('Field Height', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->group_typography([
            'name' => 'textarea_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea',
        ]);
        $this->start_controls_tabs( 'textarea_tabs' );

        // Normal Tab Style
        $this->_start_controls_tab([
			'name' => 'textarea_normal_tab',
			'label' => __( 'Normal', 'steelnova' ),
		]);
        $this->color([
            'name' => 'textarea_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'textarea_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea',
        ]);
        $this->group_box_css([
            'name' => 'textarea_',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea'
        ]);
        $this->end_controls_tab();

        // Hover Tab Style
        $this->_start_controls_tab([
			'name' => 'textarea_hover_tab',
			'label' => __( 'Hover', 'steelnova' ),
		]);
        $this->color([
            'name' => 'textarea_hover_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:hover' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
			'name' => 'textarea_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:hover',
		]);
        // Border Color 
        $this->color([
			'name' => 'textarea_hover_border_color',
			'label' => __( 'Border Color', 'steelnova' ),
			'selectors' => [
				'{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:hover' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_box_css([
            'name' => 'textarea_hover',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:hover'
        ]);
        $this->time([
            'name' => 'textarea_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();

        // Focus Tab Style
        $this->_start_controls_tab([
			'name' => 'textarea_focus_tab',
			'label' => __( 'Focus', 'steelnova' ),
		]);
        $this->color([
            'name' => 'textarea_focus_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:focus' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
			'name' => 'textarea_focus_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:focus',
		]);
        // Border Color 
        $this->color([
			'name' => 'textarea_focus_border_color',
			'label' => __( 'Border Color', 'steelnova' ),
			'selectors' => [
				'{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:focus' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_box_css([
            'name' => 'textarea_focus',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:focus'
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Select Style Controls
     */
    protected function register_select_style_controls() {
        $this->start_style_section([
            'name' => 'section_select_style', 
            'label' => __('Select', 'steelnova'),
        ]);
        $this->slider([
            'name' => 'select_height',
            'label' => __('Field Height', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->group_typography([
            'name' => 'select_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select',
        ]);
        $this->start_controls_tabs( 'select_tabs' );

        // Normal Tab Style
        $this->_start_controls_tab([
			'name' => 'select_normal_tab',
			'label' => __( 'Normal', 'steelnova' ),
		]);
        $this->color([
            'name' => 'select_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'select_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select',
        ]);
        // Group Style
        $this->group_box_css([
            'name' => 'select_',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select'
        ]);
        $this->end_controls_tab();

        // Hover Tab Style
        $this->_start_controls_tab([
			'name' => 'select_hover_tab',
			'label' => __( 'Hover', 'steelnova' ),
		]);
        $this->color([
            'name' => 'select_hover_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form select:focus,
                {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select.open' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
			'name' => 'select_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form select:focus,
            {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select.open',
		]);
        // Border Color 
        $this->color([
			'name' => 'select_hover_border_color',
			'label' => __( 'Border Color', 'steelnova' ),
			'selectors' => [
				'{{WRAPPER}} .wpcf7 form.wpcf7-form select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form select:focus,
                {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select.open' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_box_css([
            'name' => 'select_hover',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form select:focus,
            {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select.open'
        ]);
        $this->time([
            'name' => 'select_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Error Mesagge Text Style
     */
    protected function register_error_message_style_controls() {
        $this->start_style_section([
            'name' => 'section_error_message_style',
            'label' => __('Error Message', 'steelnova'),
        ]);
        $this->color([
            'name' => 'error_message_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-not-valid-tip' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_typography([
            'name' => 'error_message_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-not-valid-tip',
        ]);
        $this->end_controls_section();
    }


    /**
     * Register Error Mesagge Text Style
     */
    protected function register_error_note_style_controls() {
        $this->start_style_section([
            'name' => 'section_error_note_style',
            'label' => __('Error Note', 'steelnova'),
        ]);
        $this->group_typography([
            'name' => 'error_note_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-response-output',
        ]);
        $this->color([
            'name' => 'error_note_color',
            'label' => __('Text Color', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-response-output' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
			'name' => 'error_note_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-response-output',
		]);
        $this->group_box_css([
            'name' => 'error_note_',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-response-output',
        ]);
        $this->end_controls_section();
    }
}