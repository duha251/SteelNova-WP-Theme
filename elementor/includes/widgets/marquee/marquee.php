<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Marquee extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'steelnova-marquee',
            'title'      => __( 'CS Marquee', 'steelnova' ),
            'icon'       => 'eicon-carousel',
            'style'     => ['steelnova-widget-marquee'],
            'keywords'   => [ 'sn', 'steelnova', 'img', 'image', 'marquee','slider', 'ma', 'quee' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_content_controls();
        $this->register_interactions_controls();
        // Style
        $this->register_box_style_controls();
        $this->register_image_style_controls();
        $this->register_icon_style_controls();
        $this->register_text_style_controls();
        // Settings
                // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __( 'Content', 'steelnova' )
        ]);
        $repeater = new \Elementor\Repeater();
        $this->select([
            'name'  => 'type',
            'label' => __('Type', 'steelnova'),
            'type'  => 'select',
            'default' => 'image',
            'options' => [
                'image' => __('Image', 'steelnova'),
                'icon'  => __('Icon', 'steelnova'),
                'text'  => __('Text', 'steelnova'),
            ],
        ], $repeater);
        $this->media([
            'name' => 'img',
            'label' => __('Image', 'steelnova'),
            'default' => [
                'id' => 0,
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                'type' => 'image',
            ],
        ], $repeater);
        $this->icons([
            'name' => 'icon',
            'label' => __('Icon', 'steelnova'),
            'condition' => [
                'type' => 'icon',
            ],
        ], $repeater);
        $this->wysiwyg([
            'name' => 'text',
            'label' => __('Text', 'steelnova'),
            'condition' => [
                'type' => 'text',
            ],
        ], $repeater);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'steelnova' ),
            'condition' => [
                'type' => 'image',
            ],
        ], $repeater);
        $this->size([
            'name' => 'img_width',
            'label' => __('Image Width', 'steelnova'),
            'condition' => [
                'type' => 'image',
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ], $repeater);
        $this->url([
            'name' => 'link',
            'label' => __("Link", 'steelnova'),
            'separator' => 'before',
            'condition' => [
                'type!' => 'text',
            ],
        ], $repeater);
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'steelnova'),
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /** Interactions */
    protected function register_interactions_controls() {
        $this->start_content_section([ 
            'name' => 'section_interactions', 
            'label' => __('Interactions', 'steelnova'), 
        ]);
        $this->select([
            'name' => 'direction',
            'label' => __('Direction', 'steelnova'),
            'default' => 'rtl',
            'options' => [
                'rtl' => __('Right to Left', 'steelnova'),
                'ltr' => __('Left to Right', 'steelnova'),
            ]
        ]);
        $this->switcher([
            'name' => 'pause_on_hover',
            'label' => __('Pause On Hover', 'steelnova'),
            'default' => '',
        ]);
        $this->number([
            'name' => 'marquee_anim_duration',
            'label' => __('Animation Duration(s)', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__inner' => '--cs-animation-duration: {{VALUE}}s;',
            ]
        ]);
        $this->slider([
            'name' => 'spacing',
            'label' => __('Spacing', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__inner' => '--cs-column-gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->end_controls_section();
    }

    /** Style Box */
    protected function register_box_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_box_style', 
            'label' => __('Box', 'steelnova'),
        ]);

        $this->start_controls_tabs( 'box_style_tabs' );
        // Normal Tab
        $this->_start_controls_tab([
            'name' => 'box_style_normal_tab', 
            'label' => __( 'Normal', 'steelnova' ) 
        ]);
        $this->group_background([
            'name' => 'box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item',
		]);
        $this->group_box_css([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([
            'name' => 'box_style_hover_tab', 
            'label' => __( 'Hover', 'steelnova' ) 
        ]);
        $this->group_background([
            'name' => 'box_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_box_css([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item:hover',
        ]);
        $this->time([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__item, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** Style Image Section */
    protected function register_image_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_image_style', 
            'label' => __('Image', 'steelnova'),
        ]);
        $this->select([
            'name' => 'img_width',
            'label' => __('Image Width', 'steelnova'),
            'separator' => 'before',
            'options' => [
                'auto' => __('Auto', 'steelnova'),
                '100%' => __('Full Width', 'steelnova'),
                ''     => __('Custom', 'steelnova'),
            ],
            'selectors' => [
                '{{WRAPPER}} .image-wrapper img' => 'width: {{VALUE}};',
            ],
        ]);
        $this->group_width([
            'name' => 'img_custom_width',
            'label' => __('Image Custom Width', 'steelnova'),
            'selector' => '{{WRAPPER}} .image-wrapper img',
            'condition' => [
                'img_width' => '',
            ],
        ]);
        $this->group_height([
            'name' => 'img_custom_height',
            'label' => __('Image Height', 'steelnova'),
            'selector' => '{{WRAPPER}} .image-wrapper img',
        ]);
        $this->group_width([
            'label' => __('Image Size', 'steelnova'),
            'name' => 'img',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item-image img',
        ]);
        $this->start_controls_tabs('img_styles');

        // Normal
        $this->_start_controls_tab([
            'name' => 'img_tab_normal',
            'label' => __('Normal', 'steelnova'),
        ]);
        $this->slider([
                'name' => 'img_opacity',
                'label' => __( 'Opacity', 'steelnova' ),
                'size_units' => [ '' ],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'unit' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .cs-marquee .cs-marquee__item-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item-image img'
        ]);
        $this->group_box_css([
            'name' => 'img_',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item-image'
        ]);
        $this->end_controls_tab();

        // Hover
        $this->_start_controls_tab([
            'name' => 'img_tab_hover',
            'label' => __('Hover', 'steelnova'),
        ]);
        $this->slider([
                'name' => 'img_hover_opacity',
                'label' => __( 'Opacity', 'steelnova' ),
                'size_units' => [ '' ],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'unit' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .cs-marquee .cs-marquee__item-image:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item-image:hover img'
        ]);
        $this->group_box_css([
            'name' => 'img_hover_',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item-image:hover'
        ]);
        $this->time([
            'name' => 'img_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__item-image' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->select([
            'name' => 'img_hover_style',
            'label' => __('Hover Style', 'steelnova'),
            'separator' => 'before',
            'default' => '',
            'options' => [
                ''         => __('None', 'steelnova'),
                'zoomIn'  => __('Zoom In', 'steelnova'),
                'parallax' => __('Parallax', 'steelnova'),
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** Style Icon Section */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __('Icon', 'steelnova'),
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__item-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-marquee .cs-marquee__item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->start_controls_tabs( 'icon_style_tabs' );
        // Normal Tab
        $this->_start_controls_tab([
            'name' => 'icon_style_normal_tab',
            'label' => __( 'Normal', 'steelnova' )
        ]);
        $this->color([
            'name' => 'icon_color',
            'label' => __('Icon Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__item-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item-icon',
		]);
        $this->group_box_css([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item-icon',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([
            'name' => 'icon_style_hover_tab',
            'label' => __( 'Hover', 'steelnova' )
        ]);
        $this->color([
            'name' => 'icon_hover_color',
            'label' => __('Icon Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__item-icon:hover' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item-icon:hover',
		]);
        $this->group_box_css([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item-icon:hover',
        ]);
        $this->time([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__item-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Style Text Section */
    protected function register_text_style_controls() {
        $this->start_style_section([
            'name' => 'section_text_style',
            'label' => __('Text', 'steelnova'),
        ]);
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item',
        ]);
        $this->group_text_shadow([
            'name' => 'text_text_shadow',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item',
        ]);
        $this->start_controls_tabs(
            'text_style_tabs'
        );
        // Tab Normal
        $this->_start_controls_tab([
            'name' => 'text_normal',
            'label' => __('Normal', 'steelnova'),
        ]);
        $this->color([
            'name' => 'text_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__item' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'text_stroke',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item'
        ]);
        $this->end_controls_tab();
        // Tab Hover
        $this->_start_controls_tab([
            'name' => 'text_hover',
            'label' => __('Hover', 'steelnova'),
        ]);
        $this->color([
            'name' => 'text_hover_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-marquee .cs-marquee__item:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'text_hover_stroke',
            'selector' => '{{WRAPPER}} .cs-marquee .cs-marquee__item:hover'
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
