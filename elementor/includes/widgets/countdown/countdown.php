<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Countdown extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-countdown',
            'title'      => __( 'CS Countdown', 'steelnova' ),
            'icon'       => 'eicon-countdown',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'countdown', 'timer', 'clock' ],
            'script'     => ['steelnova-countdown'],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    protected function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_timer_style_controls();
        $this->register_unit_style_controls();
        $this->register_separator_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register content controls 
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $this->date_time([
            'name' => 'date_time',
            'label' => __('Date Time', 'steelnova'),
            'default' => '',
        ]);
        $this->text([
            'name' => 'day_unit',
            'label' => __( 'Day Unit', 'komestic' ),
            'default' => 'Days',
        ]);
        $this->text([
            'name' => 'hours_unit',
            'label' => __( 'Hours Unit', 'komestic' ),
            'default' => 'Hours',
        ]);
        $this->text([
            'name' => 'minute_unit',
            'label' => __( 'Minute Unit', 'komestic' ),
            'default' => 'Minutes',
        ]);
        $this->text([
            'name' => 'second_unit',
            'label' => __( 'Second Unit', 'komestic' ),
            'default' => 'Seconds',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register timer style controls    
     */
    protected function register_timer_style_controls() {
        $this->start_style_section([
            'name' => 'section_timer_style',
            'label' => __( 'Timer', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'timer_typography',
            'selector' => '{{WRAPPER}} .cs-countdown .cs-countdown__timer .value',
        ]);
        $this->color([
            'name' => 'timer_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-countdown .cs-countdown__timer .value' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register unit style controls    
     */
    protected function register_unit_style_controls() {
        $this->start_style_section([
            'name' => 'section_unit_style',
            'label' => __( 'Unit', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'unit_typography',
            'selector' => '{{WRAPPER}} .cs-countdown .cs-countdown__timer .unit',
        ]);
        $this->color([
            'name' => 'unit_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-countdown .cs-countdown__timer .unit' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register separator style controls    
     */
    protected function register_separator_style_controls() {
        $this->start_style_section([
            'name' => 'section_separator_style',
            'label' => __( 'Separator', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'separator_typography',
            'selector' => '{{WRAPPER}} .cs-countdown .cs-countdown__separator',
        ]);
        $this->color([
            'name' => 'separator_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-countdown .cs-countdown__separator' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_section();
    }
}