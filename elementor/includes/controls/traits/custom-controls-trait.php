<?php
namespace SteelNova\Elementor\Controls;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

trait Custom_Controls_Trait {
    /**
     * Group Box Style 
     */
    protected function group_box_css( $args = [] ) {
        $prefix = $args['name'] ?? '';
        $selector = $args['selector'] ?? '';
        // Border
        $this->group_border([
            'name' => $prefix.'border',
            'selector' => $selector,
            'separator' => 'before',
        ]);
        // Box Shadow
        $this->group_box_shadow([
            'name' => $prefix.'box_shadow',
            'selector' => $selector,
            'separator' => 'before',
        ]);
        $this->number([
            'name' => $prefix.'backdrop_filter',
            'label' => __('Backdrop Filter', 'steelnova'),
            'selectors' => [
                $selector => 'backdrop-filter: blur({{VALUE}}px);'
            ]
        ]);
        // Border Radius
        $this->dimensions([
            'name' => $prefix.'border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Padding 
        $this->dimensions ([
            'name' => $prefix.'padding',
            'label' => __( 'Padding', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
    }

    protected function time( $args = [], $target = null ) {
        $defaults = [
            'type' => 'slider',
            'label' => __( 'Time', 'steelnova' ),
            'size_units' => ['s', 'ms'],
            'range' => [
                'ms' => [
                    'min' => 0,
                    'max' => 100000,
                    'step' => 10,
                ],
                's' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 0.01,
                ],
            ],
            'mobile_default' => [
                'unit' => 'ms',
            ],
            'mobile_extra_default' => [
                'unit' => 'ms',
            ],
            'tablet_default' => [
                'unit' => 'ms',
            ],
            'tablet_extra_default' => [
                'unit' => 'ms',
            ],
            'laptop_default' => [
                'unit' => 'ms',
            ],
            'widescreen_default' => [
                'unit' => 'ms',
            ],
            'default' => [
                'unit' => 'ms',
            ]
        ];
        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__,
            $target
        );
    }
    
    protected function size( $args = [], $target = null , $range = ['min' => 0, 'max' => 1000]) {
        $defaults = [
            'type' => 'slider',
            'label' => __( 'Time', 'steelnova' ),
            'size_units' => ['px', '%', 'custom'],
            'range' => [
                'px' => $range,
            ],
            'default' => [
                'unit' => 'px',
            ]
        ];
        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__,
            $target
        );
    }

    protected function opacity( $args = [], $target = null ) {
        $defaults = [
            'type' => 'slider',
            'label' => __( 'Opacity', 'steelnova' ),
            'size_units' => [''],
            'range' => [
                '' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.01,
                ],
            ],
            'mobile_default' => [
                'unit' => '',
            ],
            'mobile_extra_default' => [
                'unit' => '',
            ],
            'tablet_default' => [
                'unit' => '',
            ],
            'tablet_extra_default' => [
                'unit' => '',
            ],
            'laptop_default' => [
                'unit' => '',
            ],
            'widescreen_default' => [
                'unit' => '',
            ],
            'default' => [
                'unit' => '',
            ]
        ];
        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__,
            $target
        );
    }

    protected function register_grid_settings_controls() {

        $this->start_settings_section([
            'name' => 'section_grid_settings',
            'label' => __('Grid Settings', 'steelnova'), 
        ]);
        $this->_start_controls_tabs([
            'name' => 'grid_controls_tabs'
        ]);

        // 
        $this->_start_controls_tab([
            'name' => 'grid_controls_option_tab',
            'label' => __('Options', 'steelnova')
        ]);
        $this->select([
            'name' => 'grid_load_type',
            'label' => __('Load Type', 'steelnova'),
            'options' => [
                '' => __('None', 'steelnova'),
                'pagination' => __('Pagination', 'steelnova'),
                'load_more' => __('Load More', 'steelnova'),
            ],
            'default' => '',
        ]);
        $this->size([
            'name' => 'grid_pagination_spacing',
            'label' => __('Spacing Top', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'grid_load_type' => ['pagination']
            ]
        ]);
        $this->end_controls_tab();
        
        // 
        $this->_start_controls_tab([
            'name' => 'grid_controls_responsive_tab',
            'label' => __('Responsive', 'steelnova')
        ]);
        $this->number([
            'name' => 'grid_columns',
            'label' => __('Columns', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .grid .grid__item:not(.grid__item--fluid)' => '--cs-column: calc( 100% / {{VALUE}} );'
            ]
        ]);
        $this->gaps([
            'name' => 'grid_gaps',
            'selectors' => [
                '{{WRAPPER}} .grid' => '--cs-column-gap: {{COLUMN}}{{UNIT}}; --cs-row-gap: {{ROW}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function register_carousel_settings_controls() {
        $columns_options = [
            ''           => __('Default', 'steelnova'),
            '1'          => '1',
            '2'          => '2',
            '3'          => '3',
            '4'          => '4',
            '5'          => '5',
            '6'          => '6',
        ];
        $this->start_settings_section([ 
            'name' => 'section_carousel_settings', 
            'label' => __('Carousel', 'steelnova'),
        ]);
        $this->start_controls_tabs('swiper_controls_tabs');
        /**
         * TAB: Options
         */
        $this->_start_controls_tab([
            'name'  => 'swiper_tab_options',
            'label' => __('Options', 'steelnova'),
        ]);

        $this->heading([
            'name' => 'swiper_basic_settings',
            'label' => __('Basic Settings', 'steelnova'),
            'separator' => '',
        ]);

        $this->select([
            'name'    => 'slides_per_view_mode',
            'label'   => __('Slides Per View Mode', 'steelnova'),
            'options' => [
                ''               => __('Standard', 'steelnova'),
                'free-mode'      => __('Free Mode (Auto)', 'steelnova'),
            ],
            'default' => '',
        ]);

        $this->select([
            'name'    => 'swiper_direction',
            'label'   => __('Direction', 'steelnova'),
            'options' => [
                'horizontal' => __('Horizontal', 'steelnova'),
                'vertical'   => __('Vertical', 'steelnova'),
            ],
            'default' => 'horizontal',
        ]);

        $this->switcher([
            'name'  => 'centered_slides',
            'label' => __('Centered Slides', 'steelnova'),
        ]);

        $this->select([
            'name'  => 'swiper_boxshadow',
            'label' => __('Container Overflow', 'steelnova'),
            'description' => __('Use "Yes" if your slides have box-shadows that are being cut off.', 'steelnova'),
            'default' => '',
            'options' => [
                ''          => __('Default', 'steelnova'),
                'no'  => __('No', 'steelnova'),
                'yes' => __('Yes', 'steelnova'),
            ]
        ]);

        $this->switcher([
            'name'  => 'allow_touch_move',
            'label' => __('Allow Touch Move', 'steelnova'),
            'default' => 'yes'
        ]);

        // $this->slider([
        //     'name' => 'swiper_wrapper_height',
        //     'label' => __('Wrapper Height', 'steelnova'),
        //     'selectors' => [
        //         '{{WRAPPER}} .carousel .carousel-container.swiper-vertical' => 'height: {{SIZE}}{{UNIT}};',
        //     ],
        //     'condition' => [
        //         'swiper_direction' => ['vertical'],
        //     ]
        // ]);

        //  AUTOPLAY SETTINGS
        $this->heading([
            'name' => 'swiper_autoplay_heading',
            'label' => __('Autoplay', 'steelnova'),
            'separator' => 'before',
        ]);
        $this->switcher([
            'name'  => 'auto_play',
            'label' => __('Enable', 'steelnova'),
        ]);
        $this->number([
            'name'    => 'delay',
            'label'   => __('Delay (ms)', 'steelnova'),
            'default' => 5000,
            'condition' => [
                'auto_play' => 'yes',
            ],
        ]);
        $this->switcher([
            'name'  => 'disable_on_interaction',
            'label' => __('Disable On Interaction', 'steelnova'),
            'condition' => [
                'auto_play' => 'yes',
            ],
        ]);
        $this->switcher([
            'name'  => 'pause_on_mouse_enter',
            'label' => __('Pause On Mouse Enter', 'steelnova'),
            'condition' => [
                'auto_play' => 'yes',
            ],
        ]);
        $this->switcher([
            'name'  => 'reverse_direction',
            'label' => __('Reverse Direction', 'steelnova'),
            'condition' => [
                'auto_play' => 'yes',
            ],
        ]);

        // FREE MODE
        $this->heading([
            'name' => 'swiper_free_mode_heading',
            'label' => __('Free Mode', 'steelnova'),
            'separator' => 'before',
        ]);
        $this->switcher([
            'name'  => 'free_mode',
            'label' => __('Enable', 'steelnova'),
        ]);
        $this->switcher([
            'name'  => 'free_mode_sticky',
            'label' => __('Sticky', 'steelnova'),
            'condition' => [
                'free_mode' => 'yes'
            ]
        ]);
        $this->switcher([
            'name'  => 'momentum',
            'label' => __('Momentum', 'steelnova'),
            'condition' => [
                'free_mode' => 'yes'
            ]
        ]);
        
        // LOOP & INTERACTION
        $this->heading([
            'name' => 'swiper_interaction',
            'label' => __('Loop & Interaction', 'steelnova'),
            'separator' => 'before',
        ]);
        $this->switcher([
            'name'  => 'loop',
            'label' => __('Infinite Loop', 'steelnova'),
            'default' => ''
        ]);
        $this->number([
            'name'    => 'initial_slide',
            'label'   => __('Initial Slide', 'steelnova'),
            'default' => 0,
            'min' => 0,
            'method' => 'add_control',
        ]);
        $this->switcher([
            'name'  => 'mousewheel',
            'label' => __('Mousewheel', 'steelnova'),
        ]);

        // SPEED
        $this->heading([
            'name' => 'swiper_transition_heading',
            'label' => __('Transition', 'steelnova'),
            'separator' => 'before',
        ]);
        $this->select([
            'name' => 'swiper_transition',
            'label' => __('Transition Timing', 'steelnova'),
            'default' => '',
            'options' => [
                ''            => __('Ease', 'steelnova'),
                'linear'      => __('Linear', 'steelnova'),
                'ease-in'     => __('Ease In', 'steelnova'),
                'ease-out'    => __('Ease Out', 'steelnova'),
                'ease-in-out' => __('Ease In Out', 'steelnova'),
            ],
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper .swiper-wrapper' => 'transition-timing-function: {{VALUE}};'
            ]
        ]);
        $this->number([
            'name'    => 'speed',
            'label'   => __('Speed (ms)', 'steelnova'),
            'default' => 500,
            'method' => 'add_control',
        ]);

        // NAVIGATION ELEMENTS
        $this->heading([
            'name' => 'swiper_controls_and_nav',
            'label' => __('Controls & Navigation', 'steelnova'),
            'separator' => 'before',
        ]);
        $this->switcher([
            'name'  => 'swiper_nav',
            'label' => __('Naviagtion', 'steelnova'),
        ]);
        $this->text([
            'name'  => 'nav_widget_id',
            'label' => __('Navigation Widget ID', 'steelnova'),
            'placeholder' => __('Ex: nav-carousel-2526', 'steelnova'),
            'condition' => [
                'swiper_nav' => 'yes',
            ]
        ]);
        $this->select([
            'name'  => 'swiper_pagination',
            'label' => __('Pagination', 'steelnova'),
            'default' => '',
            'options' => [
                '' => __('None', 'steelnova'),
                'bullets' => __('Bullets', 'steelnova'),
                'progress' => __('Progress', 'steelnova'),
            ],
        ]);

        $this->switcher([
            'name'  => 'swiper_scrollbar',
            'label' => __('Scrollbar', 'steelnova'),
        ]);

        $this->end_controls_tab();

        /**
         * TAB: Responsive
         */
        $this->_start_controls_tab([
            'name'  => 'swiper_tab_responsive',
            'label' => __('Responsive', 'steelnova'),
        ]);
        $this->heading([
            'name' => 'swiper_responsive_xs_heading',
            'label' => __('XS (<= 576px)', 'steelnova'),
            'separator' => 'none'
        ]);
        $this->select([
            'name' => 'slides_per_view_xs',
            'label' => __('Slides Per View ', 'steelnova'),
            'options' => $columns_options,
            'default' => '',
        ]);
        $this->select([
            'name' => 'swiper_grid_rows_xs',
            'label' => __('Grid Rows', 'steelnova'),
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'default' => '1',
            'condition' => [
                'swiper_direction' => 'horizontal',
            ]   
        ]);
        $this->gaps([
            'name' => 'space_between_xs',
            'label' => __('Space Between(px)', 'steelnova'),
        ]);
        // SM
        $this->heading([
            'name' => 'swiper_responsive_sm_heading',
            'label' => __('SM (< 768px)', 'steelnova'),
        ]);
        $this->select([
            'name' => 'slides_per_view_sm',
            'label' => __('Slides Per View', 'steelnova'),
            'options' => $columns_options,
            'default' => '',
        ]);
        $this->select([
            'name' => 'swiper_grid_rows_sm',
            'label' => __('Grid Rows', 'steelnova'),
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'default' => '1',
            'condition' => [
                'swiper_direction' => 'horizontal',
            ]   
        ]);
        $this->gaps([
            'name' => 'space_between_sm',
            'label' => __('Space Between(px)', 'steelnova'),
        ]);

        // MD
        $this->heading([
            'name' => 'swiper_responsive_md_heading',
            'label' => __('MD (< 992px)', 'steelnova'),
        ]);
        $this->select([
            'name' => 'slides_per_view_md',
            'label' => __('Slides Per View', 'steelnova'),
            'options' => $columns_options,
            'default' => '',
        ]);
        $this->select([
            'name' => 'swiper_grid_rows_md',
            'label' => __('Grid Rows', 'steelnova'),
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'default' => '1',
            'condition' => [
                'swiper_direction' => 'horizontal',
            ]   
        ]);
        $this->gaps([
            'name' => 'space_between_md',
            'label' => __('Space Between(px)', 'steelnova'),
        ]);

        // LG
        $this->heading([
            'name' => 'swiper_responsive_lg_heading',
            'label' => __('LG (< 1200px)', 'steelnova'),
        ]);
        $this->select([
            'name' => 'slides_per_view_lg',
            'label' => __('Slides Per View', 'steelnova'),
            'options' => $columns_options,
            'default' => '',
        ]);
        $this->select([
            'name' => 'swiper_grid_rows_lg',
            'label' => __('Grid Rows', 'steelnova'),
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'default' => '1',
            'condition' => [
                'swiper_direction' => 'horizontal',
            ]   
        ]);
        $this->gaps([
            'name' => 'space_between_lg',
            'label' => __('Space Between(px)', 'steelnova'),
        ]);

        // XL
        $this->heading([
            'name' => 'swiper_responsive_xl_heading',
            'label' => __('XL (< 1400px)', 'steelnova'),
        ]);
        $this->select([
            'name' => 'slides_per_view_xl',
            'label' => __('Slides Per View', 'steelnova'),
            'options' => $columns_options,
            'default' => '',
        ]);
        $this->select([
            'name' => 'swiper_grid_rows_xl',
            'label' => __('Grid Rows', 'steelnova'),
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'default' => '1',
            'condition' => [
                'swiper_direction' => 'horizontal',
            ]   
        ]);
        $this->gaps([
            'name' => 'space_between_xl',
            'label' => __('Space Between(px)', 'steelnova'),
        ]);

        // XXL
        $this->heading([
            'name' => 'swiper_responsive_heading',
            'label' => __('XXL (>= 1400px)', 'steelnova'),
        ]);
        $this->select([
            'name' => 'slides_per_view',
            'label' => __('Slides Per View', 'steelnova'),
            'options' => $columns_options,
            'default' => '',
        ]);
        $this->select([
            'name' => 'swiper_grid_rows',
            'label' => __('Grid Rows', 'steelnova'),
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'default' => '1',
            'condition' => [
                'swiper_direction' => 'horizontal',
            ]   
        ]);
        $this->gaps([
            'name' => 'space_between',
            'label' => __('Space Between(px)', 'steelnova'),
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->register_swiper_bullet_style();
    }

    /**
     * Register Swiper Bullet Style Controls
     */
    protected function register_swiper_bullet_style( ) {
        $this->start_style_section([
            'name' => 'section_bullet_style',
            'label' => __( 'Bullet', 'steelnova' ),
            // 'condition' => [
            //     'swiper_pagination' => 'bullets'
            // ]
        ]);
        $this->size([
            'name' => 'bullets_spacing_top',
            'label' => __( 'Bullets Spacing Top', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper-pagination-bullets' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'bullets_gap',
            'label' => __( 'Bullets Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper-pagination-bullets' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'bullet_width',
            'label' => __( 'Bullet Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper-pagination-bullets .bullet' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'bullet_height',
            'label' => __( 'Bullet Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper-pagination-bullets .bullet' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->_start_controls_tabs([
            'name' => 'bullet_style_tabs',
        ]);
        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'bullet_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'bullet_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper-pagination-bullets .bullet' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'bullet_background',
            'selector' => '{{WRAPPER}} .carousel .swiper-pagination-bullets .bullet',
        ]);
        $this->group_box_css([
            'name' => 'bullet_box_css',
            'selector' => '{{WRAPPER}} .carousel .swiper-pagination-bullets .bullet',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'bullet_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'bullet_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper-pagination-bullets .bullet:hover, {{WRAPPER}} .carousel .swiper-pagination-bullets .bullet.swiper-pagination-bullet-active' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'bullet_background_hover',
            'selector' => '{{WRAPPER}} .carousel .swiper-pagination-bullets .bullet:hover, {{WRAPPER}} .carousel .swiper-pagination-bullets .bullet.swiper-pagination-bullet-active',
        ]);
        $this->group_box_css([
            'name' => 'bullet_box_css_hover',
            'selector' => '{{WRAPPER}} .carousel .swiper-pagination-bullets .bullet:hover, {{WRAPPER}} .carousel .swiper-pagination-bullets .bullet.swiper-pagination-bullet-active',
        ]);
        $this->time([
            'name' => 'bullet_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .carousel .swiper-pagination-bullets .bullet' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

        /**
     * Register Content Controls.
     */
    protected function register_entrance_animation_controls() {
        $this->start_content_section([
            'name' => 'section_items_animation_content',
            'label' => __( 'Entrance Animation', 'steelnova' ),
        ]);
        $repeater = new \Elementor\Repeater();

        $this->group_entrance_animation([
            'name' => 'item',
            'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}'
        ], $repeater);
        
        $this->repeater([
            'name'   => 'items_animation',
            'label'  => __('Items Animation', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }
}