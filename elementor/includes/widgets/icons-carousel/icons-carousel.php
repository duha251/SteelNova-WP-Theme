<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Icons_Carousel extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-icons-carousel',
            'title'      => __( 'CS Icons Carousel', 'steelnova' ),
            'icon'       => 'eicon-carousel',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'logo', 'site logo', 'brand', 'branding', 'header logo', 'website logo', 'company logo', 'info', 'team', 'member', 'business logo', 'custom logo', 'responsive logo' ],
            'script'     => ['steelnova-carousel'],
            'style'      => ['swiper', 'steelnova-swiper', 'steelnova-widget-icon']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_icon_style_controls();
        // Settings Controls
        $this->register_carousel_settings_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'steelnova') 
        ]);
        $repeater = new \Elementor\Repeater();
        $this->icons([
            'name'  => 'icon',
            'label' => __('Icon', 'steelnova'),
        ], $repeater);
        $this->url([
            'name' => 'link',
            'label' => __('Link', 'steelnova')
        ], $repeater);
        $this->size([
            'name' => 'item_icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

      /**
     * Register Icon Style Controls
     */
    protected function register_icon_style_controls( $args = [] ) {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-wrapper' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-icon-wrapper svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-icon-wrapper' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-icon-wrapper' => 'height: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .cs-icon-wrapper' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'selector' => '{{WRAPPER}} .cs-icon-wrapper',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css',
            'selector' => '{{WRAPPER}} .cs-icon-wrapper',
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
                '{{WRAPPER}} .cs-icon-wrapper:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background_hover',
            'selector' => '{{WRAPPER}} .cs-icon-wrapper:not(.background-gradient):hover,
                           {{WRAPPER}} .cs-icon-wrapper:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-icon-wrapper:not(.background-gradient):hover',
        ]);
        $this->time([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-icon-wrapper' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}