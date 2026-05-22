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
        $this->register_main_menu_style_controls();
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
        $this->end_controls_section();
    }

    /**
     * Options menu (depth == 0) style
     */
    protected function register_main_menu_style_controls() {
        $this->start_style_section([
            'name' => 'style_section_main_menu', 
            'label' => 'Main Menu',
        ]);
        $this->group_typography([
            'name' => 'main_menu_typography',
            'selector' => '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner',
        ]);
        $this->group_text_shadow([
            'name' => 'main_menu_text_shadow',
            'selector' => '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner',
        ]);
        /** ============= Control Tabs Style ============= */
        $this->start_controls_tabs( 'main_menu_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
            'name' => 'main_menu_normal_tab',
            'label' => __( 'Normal', 'mindverse' ),
        ]);
        // Text Color
        $this->color([
            'name' => 'main_menu_color',
            'label' => __( 'Text Color', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a' => 'color: {{VALUE}}',
            ],
        ]);
        // Background 
        $this->group_background([
            'name' => 'main_menu_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner',
        ]);
        $this->group_box_css([
            'name' => 'main_menu_',
            'selector' => '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner',
        ]);
        $this->end_controls_tab();

        /** Hover/Active Tab Style */
        $this->_start_controls_tab([
            'name' => 'main_menu_normal_hover',
            'label' => __( 'Hover/Active', 'mindverse' ),
        ]);
        // Text Color Hover
        $this->color([
            'name' => 'main_menu_color_hover',
            'label' => __( 'Text Color', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a:hover, 
                {{WRAPPER}} .navigation-menu > li:hover > a,
                {{WRAPPER}} .navigation-menu > li.current-menu-item > a, 
                {{WRAPPER}} .navigation-menu > li.current_page_item > a, 
                {{WRAPPER}} .navigation-menu > li.current-menu-ancestor > a, 
                {{WRAPPER}} .navigation-menu > li.current-menu-parent > a,
                {{WRAPPER}} .navigation-menu > li > a.pxl-onepage-active' => 'color: {{VALUE}}',
            ],
        ]);
        // Background Hover
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'main_menu_background_hover',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .navigation-menu > li > a:hover .menu-link-inner, 
                {{WRAPPER}} .navigation-menu > li.current-menu-item > a .menu-link-inner, 
                {{WRAPPER}} .navigation-menu > li.current_page_item > a .menu-link-inner, 
                {{WRAPPER}} .navigation-menu > li.current-menu-ancestor > a .menu-link-inner, 
                {{WRAPPER}} .navigation-menu > li.current-menu-parent > a .menu-link-inner,
                {{WRAPPER}} .navigation-menu > li > a.pxl-onepage-active .menu-link-inner'
			]
		);
        // Border Hover 
        $this->color([
            'name' => '_main_menu_border_color_hover',
            'label' => __( 'Border Color', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a:hover > .menu-link-inner' => 'border-color: {{VALUE}}',
            ],
        ]);
       $this->group_box_css([
            'name' => 'main_menu_hover_',
            'selector' => '{{WRAPPER}} .navigation-menu > li > a:hover > .menu-link-inner',
        ]);
        // $this->select([
        //     'name' => 'main_menu_hover_style',
        //     'label' => __( 'Hover Style', 'mindverse' ),
        //     'separator' => 'before',
        //     'default' => '',
        //     'groups' => [
        //         [
        //             'label' => __('None', 'mindverse'),
        //             'options' => [
        //                 '' => __('None', 'mindverse'),
        //             ]
        //         ],
        //         [
        //             'label' => __('Underline', 'mindverse'),
        //             'options' => [
        //                 'underline-ltr' => __('Underline LTR', 'mindverse'),
        //                 'underline-rtl' => __('Underline RTL', 'mindverse'),
        //                 'transition-fill-animation' => __('Transition Fill Animation', 'mindverse'),
        //                 'rotation-fill-animation' => __('Rotation Fill Animation', 'mindverse'),
        //             ]
        //         ],
        //     ],
        // ]);
        $this->slider([
            'name' => 'main_menu_link_line_thickness',
            'label' => __('Line Thickness', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a > .menu-link-inner:after' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'main_menu_hover_style' => [ 'underline-ltr', 'underline-rtl' ],
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

}