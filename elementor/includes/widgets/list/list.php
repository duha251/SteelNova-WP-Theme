<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_List extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-list',
            'title'      => __( 'CS List', 'steelnova' ),
            'icon'       => 'eicon-bullet-list',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'list', 'social', 'social icon', 'social icons', 'icon', 'icons', 'share', 'social share', 'network', 'social network', 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'steelnova', 'links' ],
            'script'     => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        $this->register_item_layout_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_text_style_controls();
        $this->register_icon_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
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
            'selector' => '{{WRAPPER}} .cs-list',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Item Layout Controls.
     */
    protected function register_item_layout_controls() {
        $this->start_layout_section([
            'name' => 'section_item_layout',
            'label' => __( 'Item Layout', 'steelnova' ),
        ]);
        $this->group_flex_css([
            'name' => 'item_flex_css',
            'exclude' => ['align_items_vertical', 'justify_content_vertical', 'wrap'],
            'selector' => '{{WRAPPER}} .cs-list .cs-list__item',
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
        $this->switcher([
            'name' => 'has_divider',
            'label' => __('Show Divider', 'steelnova'),
            'default' => ''
        ]);
        $repeater = new \Elementor\Repeater();

        $this->text([
            'name' => 'text',
            'label' => __( 'Text', 'steelnova' ),
            'default' => __('#List Item', 'steelnova')
        ], $repeater);
        $this->icons([
            'name' => 'icon',
            'label' => __( 'Icon', 'steelnova' ),
            'default' => [
                'value' => [
                    'url' => content_url( '/uploads/2026/04/tick.svg' ),
                    'id'  => 229,
                ],
                'library' => 'svg'
            ]
        ], $repeater);

        $this->select([
            'name' => 'hover_style',
            'label' => __('Hover Style', 'steelnova'),
            'options' => [
                '' => __('None', 'steelnova'),
                'text-underline-slide' => __('Underline Slide', 'steelnova'),
            ],
            'default' => '',
        ], $repeater);

        $this->url([
            'name' => 'link',
        ], $repeater);

        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-list .cs-list__item{{CURRENT_ITEM}} .cs-list__item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-list .cs-list__item{{CURRENT_ITEM}} .cs-list__item-icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ], $repeater);

        $this->group_entrance_animation([
            'name' => 'item',
            'selector' => '{{WRAPPER}} .cs-list .cs-list__item{{CURRENT_ITEM}}'
        ], $repeater);
        
        $this->repeater([
            'name'   => 'items',
            'label'  => __('List', 'steelnova'),
            // 'title_field' => '{{{ text }}',
            'fields' => $repeater->get_controls(),
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
                '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon' => 'height: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'selector' => '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css',
            'selector' => '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon',
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
            'selector' => '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon:not(.background-gradient):hover,
                           {{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon:not(.background-gradient):hover',
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
        //         '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon:before' => 'transform-origin: {{VALUE}};'
        //     ]
        // ]);
        $this->time([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-icon' => 'transition-duration: {{SIZE}}{{UNIT}};',
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
            'selector' => '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-text, {{WRAPPER}} .cs-list .cs-list__item .cs-list__item-link',
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
                '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-text, {{WRAPPER}} .cs-list .cs-list__item .cs-list__item-link' => 'color: {{VALUE}};',
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
                '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-text:hover, {{WRAPPER}} .cs-list .cs-list__item .cs-list__item-link:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'text_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-list .cs-list__item .cs-list__item-text, {{WRAPPER}} .cs-list .cs-list__item .cs-list__item-link' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}