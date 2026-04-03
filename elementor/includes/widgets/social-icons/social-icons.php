<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Social_Icons extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-social-icons',
            'title'      => __( 'CS Social Icons', 'steelnova' ),
            'icon'       => 'eicon-social-icons',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'social', 'social icon', 'social icons', 'icon', 'icons', 'share', 'social share', 'network', 'social network', 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'steelnova' ],
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
        $this->register_box_style_controls();
        $this->register_icon_style_controls();
        $this->register_text_style_controls();
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
            'selector' => '{{WRAPPER}} .social-icons',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $repeater = new \Elementor\Repeater();

        $this->icons([
            'name' => 'icon',
            'label' => __( 'Icon', 'steelnova' ),
        ], $repeater);

        $this->url([
            'name' => 'link',
            'separator' => 'before',
            'default' => [
                'url' => '#'
            ]
        ], $repeater);
        
        $this->repeater([
            'name'   => 'items',
            'label'  => __('Social Icons', 'steelnova'),
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'icon' => [
                        'value' => [
                            'url' => content_url( '/uploads/2026/04/facebook.svg' ),
                            'id'  => 84,
                        ],
                        'library' => 'svg'
                    ],
                ],
                [
                    'icon' => [
                        'value' => [
                            'url' => content_url( '/uploads/2026/04/x.svg' ),
                            'id'  => 87,
                        ],
                        'library' => 'svg'
                    ],
                ],
                [
                    'icon' => [
                        'value' => [
                            'url' => content_url( '/uploads/2026/04/telegram.svg' ),
                            'id'  => 86,
                        ],
                        'library' => 'svg'
                    ],
                ],
                [
                    'icon' => [
                        'value' => [
                            'url' => content_url( '/uploads/2026/04/pinterest.svg' ),
                            'id'  => 85,
                        ],
                        'library' => 'svg'
                    ],
                ]
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Style Controls
     */
    protected function register_icon_style_controls( $args = [] ) {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .icon-text .icon-text__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .icon-text .icon-text__icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-text .icon-text__icon' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .icon-text .icon-text__icon' => 'height: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .icon-text .icon-text__icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'selector' => '{{WRAPPER}} .icon-text .icon-text__icon',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css',
            'selector' => '{{WRAPPER}} .icon-text .icon-text__icon',
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
            'selector' => '{{WRAPPER}} .icon-text .icon-text__icon:not(.background-gradient):hover,
                           {{WRAPPER}} .icon-text .icon-text__icon:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css_hover',
            'selector' => '{{WRAPPER}} .icon-text .icon-text__icon:not(.background-gradient):hover',
        ]);
        $this->time([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-text .icon-text__icon' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Text Style Controls
     */
    protected function register_text_style_controls( $args = [] ) {
        $this->start_style_section([
            'name' => 'section_text_style',
            'label' => __( 'Text', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .icon-text .icon-text__text',
        ]);

        $this->_start_controls_tabs([
            'name' => 'text_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'text_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'text_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .icon-text .icon-text__text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'text_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'text_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .icon-text:hover .icon-text__text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'text_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-text .icon-text__text' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}