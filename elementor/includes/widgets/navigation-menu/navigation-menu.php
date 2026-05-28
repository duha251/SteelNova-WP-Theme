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
        $this->register_mega_menu_style_controls();
        $this->register_submenu_style_controls();
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
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        // Text Color
        $this->color([
            'name' => 'main_menu_color',
            'label' => __( 'Text Color', 'steelnova' ),
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
            'label' => __( 'Hover/Active', 'steelnova' ),
        ]);
        // Text Color Hover
        $this->color([
            'name' => 'main_menu_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
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
            'label' => __( 'Border Color', 'steelnova' ),
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
        //     'label' => __( 'Hover Style', 'steelnova' ),
        //     'separator' => 'before',
        //     'default' => '',
        //     'groups' => [
        //         [
        //             'label' => __('None', 'steelnova'),
        //             'options' => [
        //                 '' => __('None', 'steelnova'),
        //             ]
        //         ],
        //         [
        //             'label' => __('Underline', 'steelnova'),
        //             'options' => [
        //                 'underline-ltr' => __('Underline LTR', 'steelnova'),
        //                 'underline-rtl' => __('Underline RTL', 'steelnova'),
        //                 'transition-fill-animation' => __('Transition Fill Animation', 'steelnova'),
        //                 'rotation-fill-animation' => __('Rotation Fill Animation', 'steelnova'),
        //             ]
        //         ],
        //     ],
        // ]);
        $this->slider([
            'name' => 'main_menu_link_line_thickness',
            'label' => __('Line Thickness', 'steelnova'),
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

        /**
     * Options submenu (depth > 0) style
     */
    protected function register_submenu_style_controls() {
        $this->start_style_section([
            'name' => 'style_section_submenu', 
            'label' => 'Submenu',
        ]);
        $this->group_typography([
            'name' => 'submenu_typography',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a',
        ]);
        $this->group_text_shadow([
            'name' => 'submenu_text_shadow',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a',
        ]);
        /** ============= Control Tabs Style ============= */
        $this->start_controls_tabs( 'submenu_tabs' );
        /** Box Tab Style */
        $this->_start_controls_tab([
            'name' => 'submenu_box_tab',
            'label' => __( 'Box', 'steelnova' ),
        ]);
        $this->group_background([
            'name' => 'submenu_box_background',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu',
        ]);

        $this->group_box_css([
            'name' => 'submenu_box_css',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu'
        ]);
        $this->end_controls_tab();
        /** Normal Tab Style */
        $this->_start_controls_tab([
            'name' => 'submenu_normal_tab',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        // Text Color
        $this->color([
            'name' => 'submenu_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a' => 'color: {{VALUE}}',
            ],
        ]);
        // Background 
        $this->group_background([
            'name' => 'submenu_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a',
            'exclude' => ['image']
        ]);
        $this->group_box_css([
            'name' => 'submenu_css',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a'
        ]);
        $this->end_controls_tab();

        /** Hover/Active Tab Style */
        $this->_start_controls_tab([
            'name' => 'submenu_normal_hover',
            'label' => __( 'Hover/Active', 'steelnova' ),
        ]);
        // Text Color Hover
        $this->color([
            'name' => 'submenu_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover' => 'color: {{VALUE}}',
            ],
        ]);
        // Background Hover
        $this->group_background([
            'name' => 'submenu_background_hover',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover',
            'exclude' => ['image']
        ]);
        // Border Hover 
        $this->color([
            'name' => '_submenu_border_color_hover',
            'label' => __( 'Border Color', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover' => 'border-color: {{VALUE}}',
            ],
        ]);
        $this->group_box_css([
            'name' => 'submenu_css_hover',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu > li > a:hover'
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    protected function register_mega_menu_style_controls() {
        $this->start_style_section([
            'name' => 'style_section_megamenu', 
            'label' => 'Mega Menu',
        ]);
        $this->select([
            'name' => 'mega_menu_overflow',
            'label' => __('Overflow', 'steelnova'),
            'options' => [
                '' => __('Default', 'steelnova'),
                'hidden' => __('Hidden', 'steelnova'),
                'auto' => __('Auto', 'steelnova'),
            ],
            'selectors' => [
                '{{WRAPPER}} .navigation-menu li > .sub-menu.pxl-mega-menu' => 'overflow: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'mega_menu_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu.pxl-mega-menu',
		]);
        $this->group_box_css([
            'name' => 'mega_menu_',
            'selector' => '{{WRAPPER}} .navigation-menu li > .sub-menu.pxl-mega-menu',
        ]);
        $this->end_controls_section();
    }

}