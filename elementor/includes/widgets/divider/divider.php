<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Divider extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-divider',
            'title'      => __( 'CS Divider', 'steelnova' ),
            'icon'       => 'eicon-e-divider',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'divider', 'separator', 'line', 'horizontal', 'vertical', 'border', 'spacing', 'divider line', 'content divider' ],
            'script'     => [],
        ];

    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Divider', 'steelnova' ),
        ]);
        $this->select([
            'name' => 'divider_style',
            'label' => __('Divider Style', 'steelnova'),
            'options' => [
                'solid'  => __( 'Solid', 'steelnova' ),
                'dashed' => __( 'Dashed', 'steelnova' ),
                'dotted' => __( 'Dotted', 'steelnova' ),
                'double' => __( 'Double', 'steelnova' ),
                ''       => __( 'Custom', 'steelnova' ),
            ],
            'default' => 'solid',
            'selectors' => [
                '{{WRAPPER}} .cs-divider.cs-divider--horizontal' => 'border-top-style: {{VALUE}};',
                '{{WRAPPER}} .cs-divider.cs-divider--vertical' => 'border-left-style: {{VALUE}};',
            ]
        ]);      
        $this->select([
            'name' => 'divider_dir',
            'label' => __('Divider Direction', 'steelnova'),
            'options' => [
                'vertical'   => __( 'Vertical', 'steelnova' ),
                'horizontal' => __( 'Horizontal', 'steelnova' ),
            ],
            'default' => 'horizontal',
        ]);   
        $this->size([
            'name' => 'divider_height',
            'label' => __('Height', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-divider' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'divider_dir' => 'vertical'
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Style Controls.
     */
    protected function register_style_controls() {
        $this->start_style_section([
            'name' => 'section_style',
            'label' => __( 'Divider', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'divider_thickness',
            'label' => __('Thickness', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-divider.cs-divider--horizontal' => 'height: {{SIZE}}{{UNIT}}; border-top-width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-divider.cs-divider--vertical'   => 'width: {{SIZE}}{{UNIT}}; border-left-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->color([
            'name' => 'divider_color',
            'selectors' => [
                '{{WRAPPER}} .cs-divider' => 'border-color: {{VALUE}};'
            ]
        ]);
        $this->end_controls_section();
    }

}