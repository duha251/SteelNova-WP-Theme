<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Icon_Box extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-icon-box',
            'title'      => __( 'CS Icon Box', 'steelnova' ),
            'icon'       => 'eicon-icon-box',
            'keywords'   => [],
            'script'     => [],
            'style'      => ['steelnova-widget-icon-box']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        $this->register_style_layout_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_icon_style_controls();
        $this->register_title_style_controls();
        $this->register_desc_style_controls();
        // $this->register_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
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
            'selector' => '{{WRAPPER}} .cs-icon-box',
        ]);
        $this->size([
            'name' => 'title_spacing_top',
            'label' => __('Title Spacing Top', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__title' => 'margin-top: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->size([
            'name' => 'title_spacing',
            'label' => __('Title Spacing Bottom', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box__content' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }


    /**
     * Register Style Layout Controls.
     */
    protected function register_style_layout_controls() {
        $this->start_layout_section([
            'name' => 'section_style_layout',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->visual_choice([
            'name' => 'layout_style',
            'label' => __( 'Layout Style', 'steelnova' ),
            'options' => [
                '1' => [
                    'title' => __('Layout 1', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/icon-box-1.webp'),
                ],
                '2' => [
                    'title' => __('Layout 2', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/icon-box-2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }


    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Icon Box', 'steelnova' ),
        ]);
        $this->icons([
            'name'  => 'icon',
            'label' => __('Icon', 'steelnova'),
        ]);
        $this->text([
            'name'    => 'title',
            'label'   => __('Title', 'steelnova'),
            'separator' => 'before',
            'default' => __('Your Title', 'steelnova'),
        ]);
        $this->select([
            'name' => 'title_tag',
            'label' => __('Title Tag HTML', 'steelnova'),
            'options' => Static_Options::title_html_tag_options(),
            'default' => 'h6'
        ]);
        $this->textarea([
            'name'  => 'description',
            'label' => __('Description', 'steelnova'),
            'separator' => 'before',
            'rows'  => 10,
            'default' => __('Lorem ipsum dolor sit amet', 'steelnova')
        ]);
        $this->url([
            'name' => 'link',
            'separator' => 'before'
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Style Controls
     */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->_start_controls_tabs([
            'name' => 'icon_style_tabs',
        ]);
        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'icon_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'icon_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'selector' => '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css',
            'selector' => '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'icon_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'icon_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box:hover .icon-text__icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background_hover',
            'selector' => '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon:not(.background-gradient):hover,
                           {{WRAPPER}} .cs-icon-box .cs-icon-box__icon:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon:not(.background-gradient):hover',
        ]);
        $this->time([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__icon' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Title Style Controls
     */
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name' => 'section_title_style',
            'label' => __( 'Title', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .cs-icon-box .cs-icon-box__title',
        ]);

        $this->_start_controls_tabs([
            'name' => 'title_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'title_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'title_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'title_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'title_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box:hover .cs-icon-box__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__title' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Description Style Controls
     */
    protected function register_desc_style_controls() {
        $this->start_style_section([
            'name' => 'section_desc_style',
            'label' => __( 'Description', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'desc_typography',
            'selector' => '{{WRAPPER}} .cs-icon-box .cs-icon-box__description',
        ]);

        $this->_start_controls_tabs([
            'name' => 'desc_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'desc_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'desc_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__description' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'desc_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'desc_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box:hover .cs-icon-box__description' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'desc_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-icon-box .cs-icon-box__description' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

}