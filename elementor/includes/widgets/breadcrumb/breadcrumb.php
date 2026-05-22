<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Breadcrumb extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-breadcrumb',
            'title'      => __( 'CS Breadcrumb', 'steelnova' ),
            'icon'       => 'eicon-ellipsis-h',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'breadcrumb', 'breadcrumbs', 'navigation', 'path', 'site breadcrumb', 'trail', 'breadcrumb trail', 'navigation breadcrumb', 'seo breadcrumb' ],
            'script'     => [],
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
        $this->register_box_style_controls();
        $this->register_text_style_controls();
        $this->register_link_style_controls();
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
            'selector' => '{{WRAPPER}} .steelnova-breadcrumb',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Breadcrumb', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'separator_type',
            'label' => __('Separator', 'steelnova'),
            'options' => [
                ''  => __('Default', 'steelnova'),
                '0' => __('Char', 'steelnova'),  
                '1' => __('Icon', 'steelnova') 
            ],
            'default' => ''
        ]);
        $this->text([
            'name' => 'separator_char',
            'label' => __( 'Separator Char', 'steelnova' ),
            'label_block' => false,
            'default' => '',
            'condition' => [
                'separator_type' => '0'
            ]
        ]);
        $this->icons([
            'name' => 'separator_icon',
            'label' => __( 'Separator Icon', 'steelnova' ),
            'default' => [],
            'condition' => [
                'separator_type' => '1'
            ]
        ]);

        $this->end_controls_section();
    }


    /**
     * Register Box Style Controls
     */
    protected function register_box_style_controls() {
        $this->start_style_section([
            'name' => 'section_box_style',
            'label' => __( 'Box', 'steelnova' ),
        ]);

        $this->size([
            'name' => 'box_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .steelnova-breadcrumb' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .steelnova-breadcrumb' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);


        $this->_start_controls_tabs([
            'name' => 'box_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name' => 'background',
            'selector' => '{{WRAPPER}} .steelnova-breadcrumb',
        ]);
        $this->group_box_css([
            'name' => 'box_css',
            'selector' => '{{WRAPPER}} .steelnova-breadcrumb',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name' => 'background_hover',
            'selector' => '{{WRAPPER}} .steelnova-breadcrumb:not(.background-gradient):hover,
                           {{WRAPPER}} .steelnova-breadcrumb:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'box_css_hover',
            'selector' => '{{WRAPPER}} .steelnova-breadcrumb:not(.background-gradient):hover',
        ]);
        $this->time([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .steelnova-breadcrumb' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Text Style Controls
     */
    protected function register_text_style_controls() {
        $this->start_style_section([
            'name' => 'section_text_style',
            'label' => __( 'Text', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'text_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .steelnova-breadcrumb' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .steelnova-breadcrumb',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Link Style Controls
     */
    protected function register_link_style_controls() {
        $this->start_style_section([
            'name' => 'section_link_style',
            'label' => __( 'Link', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'link_typography',
            'selector' => '{{WRAPPER}} .steelnova-breadcrumb',
        ]);

        $this->_start_controls_tabs([
            'name' => 'link_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'link_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'link_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .steelnova-breadcrumb > a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'link_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'link_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .steelnova-breadcrumb > a:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'link_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .steelnova-breadcrumb > a' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}