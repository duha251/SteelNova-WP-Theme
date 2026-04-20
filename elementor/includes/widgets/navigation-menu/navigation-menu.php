<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Navigation_Menu extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-navigation-menu',
            'title'      => __( 'CS Navigation Menu', 'steelnova' ),
            'icon'       => 'eicon-nav-menu',
            'keywords'   => [ 'nav', 'menu', 'header', 'steelnova', 'navigation' ],
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
        // $this->register_style_controls();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_controls() {
        $this->start_layout_section([
            'name' => 'section_menu_layout',
            'label' => __( 'Menu Layout', 'steelnova' ),
        ]);
        $this->group_flex_css([
            'name' => 'flex_css',
            'selector' => '{{WRAPPER}} .navigation-menu',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Navigation Menu', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'nav_menu',
            'label' => __( 'Choose Menu', 'steelnova' ),
            'options' => Static_Options::get_navigation_menu_options(),
            'default' => '',
        ]);
        // $this->icons([
        //     'name' => 'menu_icon',
        //     'label' => __('Menu Has Child Icon', 'steelnova'),
        //     'default' => [],
        // ]);
        $this->end_controls_section();
    }


    /**
     * Register Menu Style Controls
     */
    protected function register_menu_style_controls( $args = [] ) {
        $this->start_style_section([
            'name' => 'section_menu_style',
            'label' => __( 'Menu', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'menu_link_height',
            'label' => __( 'Link Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .social-icons .social-icons__link' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->_start_controls_tabs([
            'name' => 'menu_style_tabs',
        ]);
        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'menu_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'menu_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .social-icons .social-icons__link' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'menu_background',
            'selector' => '{{WRAPPER}} .social-icons .social-icons__link',
        ]);
        $this->group_box_css([
            'name' => 'menu_box_css',
            'selector' => '{{WRAPPER}} .social-icons .social-icons__link',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'menu_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'menu_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .icon-text:hover .icon-text__icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'menu_background_hover',
            'selector' => '{{WRAPPER}} .social-icons .social-icons__link:not(.background-gradient):hover,
                           {{WRAPPER}} .social-icons .social-icons__link:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'menu_box_css_hover',
            'selector' => '{{WRAPPER}} .social-icons .social-icons__link:not(.background-gradient):hover',
        ]);
        $this->select([
            'name' => 'menu_hover_style',
            'label' => __('Hover Style', 'steelnova'),
            'separator' => 'before',
            'options' => [
                ''    => __('None', 'steelnova'),
            ],
        ]);
        $this->time([
            'name' => 'menu_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .social-icons .social-icons__link' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

}