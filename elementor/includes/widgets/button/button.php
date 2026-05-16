<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Button extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-button',
            'title'      => __( 'CS Button', 'steelnova' ),
            'icon'       => 'eicon-button',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'button', 'click', 'cta', 'call to action', 'link', 'steelnova', 'btn' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_style_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_style_controls() {
        $this->start_layout_section([
            'name' => 'section_layout_style',
            'label' => __( 'Layout Style', 'steelnova' ),
        ]);
        $this->visual_choice([
            'name' => 'btn_style',
            'label' => __('Choose Style', 'steelnova'),
            'options' => [
                '0' => [
                    'title' => __('Custom', 'steelnova'),
                    'image' => ''
                ],
                'primary'  => [
                    'title' => __('Primary', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/btn-primary.webp'),
                ]
            ],
            'default' => 'primary',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Button', 'steelnova' ),
        ]);
        // Button Content
        $this->text([
            'name' => 'text',
            'label' => __('Button Text', 'steelnova'),
            'default' => __('Click here', 'steelnova'),
        ]);
        $this->icons([
            'name' => 'icon',
            'label' => __('Button Icon', 'steelnova'),
            'condition' => [
                'btn_style!' => ['primary'],
            ]
        ]);
        $this->url([
            'name' => 'link',
            'label' => __('Button Link', 'steelnova'),
            'separator' => 'before',
            'default' => [
                'url' => '#'
            ],
            'condition' => [
                'btn_type!' => ['submit'],
            ]
        ]);
        $this->select([
            'name' => 'btn_type',
            'label' => __('Button Type', 'steelnova'),
            'default' => '',
            'options' => [
                ''        => __('Redirect', 'steelnova'),
                'toggle'  => __('Toggle', 'steelnova'),
                'submit'  => __('Submit', 'steelnova'),
                'play'    => __('Play', 'steelnova'),
                'anchor'  => __('Anchor', 'steelnova'),
            ]
        ]);
        $this->select([
            'name'  => 'wpcf7_form_id',
            'label' => __('Submit to WPCF7 Form', 'steelnova'),
            'default' => '0',
            'options' => Static_Options::get_wpcf7_options(),
            'condition' => [
                'btn_type' => ['submit'],
            ]
        ]);
        $this->text([
            'name' => 'target',
            'label' => __('Target ID or Class', 'steelnova'),
            'placeholder' => __('Eg: #id-name', 'steelnova'),
            'condition' => [
                'btn_type' => ['toggle', 'anchor'],
            ]
        ]);
        $this->number([
            'name' => 'offset',
            'label' => __('Offset(px)', 'steelnova'),
            'default' => 0,
            'min' => 0,
            'condition' => [
                'btn_type' => ['anchor'],
            ]
        ]);
        $this->end_controls_section();
    }


    /**
     * Register Button Style Controls
     */
    protected function register_style_controls( $args = [] ) {
        $this->start_style_section([
            'name' => 'section_nutton_style',
            'label' => __( 'Button', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'btn_gap',
            'label' => __( 'Button Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-button' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'btn_width',
            'label' => __( 'Button Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-button' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'btn_height',
            'label' => __( 'Button Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-button' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-button .cs-button__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-button .cs-button__icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->group_typography([
            'name' => 'btn_typography',
            'selector' => '{{WRAPPER}} .cs-button',
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
                '{{WRAPPER}} .cs-button' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'btn_background',
            'selector' => '{{WRAPPER}} .cs-button',
        ]);
        $this->group_box_css([
            'name' => 'btn_box_css',
            'selector' => '{{WRAPPER}} .cs-button',
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
                '{{WRAPPER}} .cs-button:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'btn_background_hover',
            'selector' => '{{WRAPPER}} .cs-button:not(.background-gradient):hover,
                           {{WRAPPER}} .cs-button:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'btn_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-button:hover',
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
                '{{WRAPPER}} .cs-button' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }


}