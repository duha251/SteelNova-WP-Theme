<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Tabs extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-tabs',
            'title'      => __( 'CS Tabs', 'steelnova' ),
            'icon'       => 'eicon-post-info',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'tab', 'site tab', 'brand', 'branding', 'header tab', 'website tab', 'company tab', 'info', 'team', 'member', 'business logo', 'custom logo', 'responsive logo' ],
            'script'     => ['steelnova-tabs'],
            'style'      => ['steelnova-widget-tabs']
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
        $this->register_tabs_nav_style_controls();
        $this->register_tabs_nav_button_style_controls();
        $this->register_tabs_content_style_controls();
        // Settings Controls
        $this->register_display_settings_controls();
        $this->register_carousel_settings_controls();
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
        $this->visual_choice([
            'name' => 'layout',
            'label' => __( 'Choose Layout', 'steelnova' ),
            'options' => [
                '1' => [
                    'title' => __('Layout 1', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/tabs-1.webp'),
                ],
                '2' => [
                    'title' => __('Layout 2', 'steelnova'),
                    'image' => content_url('/uploads/widget-layout/tabs-2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'steelnova') 
        ]);
        $repeater = new \Elementor\Repeater();
        $this->text([
            'name'    => 'title',
            'label'   => __('Tab Title', 'steelnova'),
            'separator' => 'before',
            'default' => __('Tab Title', 'steelnova'),
        ], $repeater);
        $this->select([
            'name' => 'content',
            'label' => __('Tab Content', 'steelnova'),
            'options' => Static_Options::get_templates_by_type('tab'),
            'default' => ''
        ], $repeater);
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /**
     * Nav Container (.cs-tabs__nav)
     * Layout 1: border-bottom, gap
     * Layout 2: gap, flex-basis, sticky top
     */
    protected function register_tabs_nav_style_controls() {
        $this->start_style_section([
            'name'  => 'section_tabs_nav_style',
            'label' => __( 'Nav Container', 'steelnova' ),
        ]);

        // --- Layout 1 ---
        $this->size([
            'name'      => 'nav_gap_l1',
            'label'     => __( 'Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="1"] .cs-tabs__nav' => 'gap: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '1' ],
        ]);

        $this->color([
            'name'      => 'nav_border_color_l1',
            'label'     => __( 'Border Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="1"] .cs-tabs__nav' => 'border-bottom-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => '1' ],
        ]);

        // --- Layout 2 ---
        $this->size([
            'name'      => 'nav_gap_l2',
            'label'     => __( 'Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav' => 'gap: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->size([
            'name'      => 'nav_width_l2',
            'label'     => __( 'Nav Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav' => 'flex: 0 1 {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->size([
            'name'      => 'nav_sticky_top_l2',
            'label'     => __( 'Sticky Top Offset', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav' => 'top: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->size([
            'name'      => 'tabs_gap_l2',
            'label'     => __( 'Gap (Nav ↔ Content)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="2"]' => 'gap: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Nav Button (.cs-tabs__nav > button)
     * Layout 1: typography, padding-bottom, color — normal / hover / active
     *           underline indicator color
     * Layout 2: typography, padding, border-radius, border — normal / active
     */
    protected function register_tabs_nav_button_style_controls() {
        $this->start_style_section([
            'name'  => 'section_tabs_nav_btn_style',
            'label' => __( 'Nav Button', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'nav_btn_typography',
            'selector' => '{{WRAPPER}} .cs-tabs__nav > button',
        ]);

        $this->_start_controls_tabs([ 'name' => 'nav_btn_tabs_l2' ]);

        $this->_start_controls_tab([
            'name'  => 'nav_btn_l2_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'nav_btn_color_l2',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav > button' => 'color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);
        $this->group_background([
            'name'     => 'nav_btn_bg_l2',
            'selector' => '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav > button',
        ]);
        $this->group_box_css([
            'name'     => 'nav_btn_l2_',
            'selector' => '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav > button',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'nav_btn_l2_tab_active',
            'label' => __( 'Active', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'nav_btn_color_active_l2',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav > button.is-active' => 'color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);
        $this->color([
            'name'      => 'nav_btn_icon_color_active_l2',
            'label'     => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav > button.is-active .cs-button__icon' => 'color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);
        $this->group_background([
            'name'     => 'nav_btn_bg_active_l2',
            'selector' => '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav > button.is-active',
        ]);
        $this->group_box_css([
            'name'     => 'nav_btn_active_l2_',
            'selector' => '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav > button.is-active',
        ]);
        $this->time([
            'name'      => 'nav_btn_transition_l2',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__nav > button' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Tab Content (.cs-tabs__content)
     * Layout 2: flex-basis
     */
    protected function register_tabs_content_style_controls() {
        $this->start_style_section([
            'name'  => 'section_tabs_content_style',
            'label' => __( 'Content Area', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'content_width_l2',
            'label'     => __( 'Content Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-tabs[data-layout="2"] .cs-tabs__content' => 'flex: 0 1 {{SIZE}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => '2' ],
        ]);

        $this->group_background([
            'name'     => 'content_bg',
            'selector' => '{{WRAPPER}} .cs-tabs__content',
        ]);

        $this->group_box_css([
            'name'     => 'content_',
            'selector' => '{{WRAPPER}} .cs-tabs__content',
        ]);

        $this->end_controls_section();
    }

    /**
     * Register Grid Source Content Controls
     */
    protected function register_display_settings_controls() {        
        $this->start_settings_section([ 
            'name' => 'settings_archive_display', 
            'label' => __('Display', 'steelnova') 
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'title_tag',
            'label' => __('Title HTML Tag', 'steelnova'),
            'options' => Static_Options::title_html_tag_options(),
            'separator' => 'before',
            'default' => 'div'
        ]);
        $this->end_controls_section();
    }
}