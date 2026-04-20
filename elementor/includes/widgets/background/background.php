<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Background extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-background',
            'title'      => __( 'CS Background', 'steelnova' ),
            'icon'       => 'eicon-background',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'background', 'text editor', 'text styling', 'content', 'typography', 'fill', 'gradient', 'overlay' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    protected function register_controls() {
        // Style Controls
        $this->register_background_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**
     * Register background style controls 
     */
    protected function register_background_style_controls() {
        $this->start_style_section([
            'name' => 'section_background_style',
            'label' => __( 'Background', 'steelnova' ),
        ]);
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __( 'Background', 'steelnova' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .steelnova-background',
            ]
        );

        $this->end_controls_section();
    }
}