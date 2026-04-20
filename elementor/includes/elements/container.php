<?php
namespace SteelNova\Elementor\Elements;

use SteelNova\Elementor\Controls\Controls_Trait;
use SteelNova\Elementor\Controls\Custom_Controls_Trait;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SteelNova_Container {
    use Controls_Trait, Custom_Controls_Trait;

	public function __construct() {
        add_action('elementor/element/container/section_layout/after_section_end', [ $this, 'register_controls' ] , 10, 2);
        // add_action('elementor/frontend/container/before_render', [ $this, 'before_render' ]);
    }

    public function register_controls($element, $args) {
        $this->register_steelnova_extra_controls($element, $args);
        $this->register_steelnova_background_overlay_controls($element, $args);
    }

    public function register_steelnova_extra_controls( $element, $args ) {
        $this->start_steelnova_section([
            'name' => 'section_steelnova_extra',
            'label'   => __( 'Extra Options', 'steelnova' ),
        ], $element);

        // $this->size([
        //     'name'  => '_container_max_width',
        //     'label' => __( 'Max Width', 'steelnova' ),
        //     'selectors' => [
        //         '{{WRAPPER}}' => 'max-width: {{SIZE}}{{UNIT}};'
        //     ]
        // ], $element);

        $this->group_width([
            'name' => '_width',
            'label' => __( 'CSS Width', 'steelnova' ),
            'selector' => '{{WRAPPER}}',
            'fields_options' => [
                'steelnova_max_width' => [
                    'selectors' => [
                        '{{SELECTOR}}' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                    ],
                ],
            ],
        ], $element);
        $this->group_height([
            'name' => '_height',
            'label' => __( 'CSS Height', 'steelnova' ),
            'selector' => '{{WRAPPER}}',
        ], $element);

        $this->size([
            'name'  => '_backdrop_filter_blur',
            'label' => __( 'Backdrop Filter Blur', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}}' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});'
            ]
        ], $element);

        $element->end_controls_section();
    }
    
    public function register_steelnova_background_overlay_controls( $element, $args ) {
        $this->start_steelnova_section([
            'name'  => 'steelnova_bg_section',
            'label' => __( 'Background Overlay', 'steelnova' ),
        ], $element);

        $this->_start_controls_tabs([
            'name' => 'steelnova_bg_overlay_controls_tabs'
        ], $element);

        // Background Overlay Tab Normal
        $this->_start_controls_tab([
            'name' => 'steelnova_bg_overlay_normal_controls_tab',
            'label' => __('Normal', 'steelnova')
        ], $element);
        $this->group_background([
            'name' => 'steelnova_bg_overlay',
            'selector' => '{{WRAPPER}} .steelnova-background-overlay'
        ], $element);
        $this->opacity([
            'name' => 'steelnova_bg_overlay_opacity',
            'selectors' => [
                '{{WRAPPER}} .steelnova-background-overlay' => 'opacity: {{SIZE}}{{UNIT}};'
            ]
        ], $element);
        $this->group_css_filter([
            'name' => 'steelnova_bg_overlay_css_filter',
            'selector' =>  '{{WRAPPER}} .steelnova-background-overlay'
        ], $element);
        $element->end_controls_tab();

        // Background Overlay Tab Hover
        $this->_start_controls_tab([
            'name' => 'steelnova_bg_overlay_hover_controls_tab',
            'label' => __('Hover', 'steelnova')
        ], $element);
        $this->group_background([
            'name' => 'steelnova_bg_overlay_hover',
            'selector' => '{{WRAPPER}}:hover .steelnova-background-overlay'
        ], $element);
        $this->opacity([
            'name' => 'steelnova_bg_overlay_opacity_hover',
            'selectors' => [
                '{{WRAPPER}}:hover .steelnova-background-overlay' => 'opacity: {{SIZE}}{{UNIT}};'
            ]
        ], $element);
        $this->group_css_filter([
            'name' => 'steelnova_bg_overlay_css_filter_hover',
            'selector' =>  '{{WRAPPER}}:hover .steelnova-background-overlay'
        ], $element);
        $element->end_controls_tab();

        $element->end_controls_tabs();
        $element->end_controls_section();
    }

    // public function before_render( $settings ) {
    //     if(  !empty( $settings['steelnova_bg_overlay_background'] ) ) {

    //     }
    // }
}