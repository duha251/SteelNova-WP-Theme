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


    protected function time( $args = [] ) {
        $defaults = [
            'type' => 'slider',
            'label' => __( 'Time', 'mindverse' ),
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
        );
    }

    protected function size( $args = [], $range = ['min' => 0, 'max' => 1000] ) {
        $defaults = [
            'type' => 'slider',
            'label' => __( 'Time', 'mindverse' ),
            'size_units' => ['px', 'custom'],
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
        );
    }
}