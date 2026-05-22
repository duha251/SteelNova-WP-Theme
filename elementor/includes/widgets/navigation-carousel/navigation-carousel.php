<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Navigation_Carousel extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'steelnova-navigation-carousel',
            'title'      => __( 'CS Navigation Carousel', 'steelnova' ),
            'icon'       => 'eicon-post-navigation',
            'keywords'   => [ 'cs', 'steelnova', 'nav', 'navigation', 'carousel' ],
            'script'     => []
        ];
    }

    protected function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Content Controls
        $this->register_content_section();
        // Style Controls
        $this->register_btn_style_controls();
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
            'selector' => '{{WRAPPER}} .cs-navigation-carousel',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_section() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'steelnova'),
        ]);
        $this->text([
            'name' => 'html_id',
            'label' => __('HTML ID', 'mindverse'),
            'default' => $this->get_id(),
        ]);
                
        $this->icons([
            'name' => 'nav_prev_icon',
            'label' => __('Previous Icon', 'steelnova'),
            'default' => [],
        ]);
        $this->icons([
            'name' => 'nav_next_icon',
            'label' => __('Next Icon', 'steelnova'),
            'default' => [],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Button Style Controls
     */
    protected function register_btn_style_controls() {
        $this->start_style_section([
            'name' => 'section_btn_style',
            'label' => __( 'Button', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'btn_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'btn_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button' => 'height: {{SIZE}}{{UNIT}};',
            ],
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
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'btn_background',
            'selector' => '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button',
        ]);
        $this->group_box_css([
            'name' => 'btn_box_css',
            'selector' => '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'btn_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'btn_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'btn_background_hover',
            'selector' => '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button:not(.background-gradient):hover,
                           {{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'btn_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button:not(.background-gradient):hover',
        ]);
        $this->time([
            'name' => 'btn_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-navigation-carousel .cs-navigation-carousel__button' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    
}