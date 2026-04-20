<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Post_Tags extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-post-tags',
            'title'      => __( 'CS Post Tags', 'steelnova' ),
            'icon'       => 'eicon-tags',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'post tags', 'tags', 'post information', 'social', 'social icon', 'social icons', 'icon', 'icons', 'share', 'social share', 'network', 'social network', 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'pinterest', 'telegram', 'author', 'date', 'category', 'tags' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        // Style Controls
        $this->register_icon_style_controls();
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
            'selector' => '{{WRAPPER}} .post-tags',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Style Controls
     */
    protected function register_icon_style_controls( $args = [] ) {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __( 'Socials Icon', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .social-icons .social-icons__link' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .social-icons .social-icons__link svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .social-icons .social-icons__link' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .social-icons .social-icons__link' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->_start_controls_tabs([
            'name' => 'icon_style_tabs',
        ]);
        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'icon_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'icon_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .social-icons .social-icons__link' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'selector' => '{{WRAPPER}} .social-icons .social-icons__link',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css',
            'selector' => '{{WRAPPER}} .social-icons .social-icons__link',
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'icon_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'icon_color_hover',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .icon-text:hover .icon-text__icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background_hover',
            'selector' => '{{WRAPPER}} .social-icons .social-icons__link:not(.background-gradient):hover,
                           {{WRAPPER}} .social-icons .social-icons__link:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css_hover',
            'selector' => '{{WRAPPER}} .social-icons .social-icons__link:not(.background-gradient):hover',
        ]);
        $this->select([
            'name' => 'icon_hover_style',
            'label' => __('Hover Style', 'steelnova'),
            'separator' => 'before',
            'options' => [
                ''    => __('None', 'steelnova'),
                'fillScale'  => __('Fill Scale', 'steelnova'),
                'fillReveal' => __('Fill Reveal', 'steelnova'),
            ],
        ]);
        // $this->select([
        //     'name' => 'icon_before_transform_origin',
        //     'label' => __('Transform Origin', 'steelnova'),
        //     'options' => [
        //         ''       => __('Center', 'steelnova'),
        //         'top'    => __('Top', 'steelnova'),
        //         'right'  => __('Right', 'steelnova'),
        //         'bottom' => __('Bottom', 'steelnova'),
        //         'left'   => __('Left', 'steelnova'),
        //     ],
        //     'selectors' => [
        //         '{{WRAPPER}} .social-icons .social-icons__link:before' => 'transform-origin: {{VALUE}};'
        //     ]
        // ]);
        $this->time([
            'name' => 'icon_transition_duration',
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