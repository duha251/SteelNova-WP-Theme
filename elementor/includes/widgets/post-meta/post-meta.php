<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Post_Meta extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-post-meta',
            'title'      => __( 'CS Post Meta', 'steelnova' ),
            'icon'       => 'eicon-meta-data',
            'keywords' => [ 'cs', 'casethemes', 'steelnova', 'post meta', 'meta', 'post information', 'social', 'social icon', 'social icons', 'icon', 'icons', 'share', 'social share', 'network', 'social network', 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'pinterest', 'telegram', 'author', 'date', 'category', 'tags' ],
            'script'     => [],
            'style'      => ['steelnova-widget-post-meta']
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        $this->register_layout_controls();
        $this->register_layout_style_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_icon_style_controls();
        $this->register_title_style_controls();
        $this->register_desc_style_controls();
                // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    } 

    protected function register_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_layout', 
            'label' => __('Layout', 'steelnova')
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'steelnova'),
            'columns' => '1',
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Post Meta 1', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/post-meta-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Post Meta 2', 'steelnova' ),
                    'image' => content_url('/uploads/widget-layout/post-meta-2.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Layout Controls.
     */
    protected function register_layout_style_controls() {
        $this->start_layout_section([
            'name' => 'section_layout_style',
            'label' => __( 'Layout', 'steelnova' ),
        ]);
        $this->group_flex_css([
            'name' => 'flex_css',
            'selector' => '{{WRAPPER}} .cs-post-meta',
        ]);
        $this->heading([
            'name' => 'item_layout_heading',
            'label' => __('Item Layout', 'steelnova'),
        ]);
        $this->group_flex_css([
            'name' => 'item_',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item',
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
            'condition' => [
                'meta_type!' => ['project_info']
            ]
        ], $repeater);

        $this->text([
            'name'  => 'label',
            'label' => __( 'Label', 'steelnova' ),
            'default' => __('Label', 'steelnova'),
            'condition' => [
                'meta_type!' => ['project_info']
            ]
        ], $repeater);

        $this->select([
            'name' => 'meta_type',
            'label' => __("Meta Type", 'steelnova'),
            'options' => [
                'categories' => __('Category', 'steelnova'),
                'tags'      => __('Tag', 'steelnova'),
                'author'   => __('Author', 'steelnova'),
                'date'     => __('Date', 'steelnova'),
                'project_info' => __('Project Info', 'steelnova')
            ],
            'default' => 'categories'
        ], $repeater);
        
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .post-meta .post-meta__item{{CURRENT_ITEM}}' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .post-meta .post-meta__item{{CURRENT_ITEM}} svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ], $repeater);
        
        $this->repeater([
            'name'   => 'items',
            'label'  => __('Post Meta', 'steelnova'),
            'title_field' => '{{{ meta_type }}}',
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Icon Style Controls
     */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);
        $this->size([
            'name' => 'icon_size',
            'label' => __( 'Icon Size', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_width',
            'label' => __( 'Box Width', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name' => 'box_icon_height',
            'label' => __( 'Box Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'height: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon',
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
                '{{WRAPPER}} .cs-post-meta .cs-post-meta:hover .cs-post-meta__item-icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name' => 'icon_background_hover',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon:not(.background-gradient):hover,
                           {{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon:not(.background-gradient):before',
        ]);
        $this->group_box_css([
            'name' => 'icon_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon:not(.background-gradient):hover',
        ]);
        $this->time([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-icon' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Label Style Controls
     */
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name' => 'section_title_style',
            'label' => __( 'Label', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-label',
        ]);

        $this->_start_controls_tabs([
            'name' => 'title_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'title_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'title_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'title_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'title_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item:hover .cs-post-meta__item-label' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item-label' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Description Style Controls
     */
    protected function register_desc_style_controls() {
        $this->start_style_section([
            'name' => 'section_desc_style',
            'label' => __( 'Description', 'steelnova' ),
        ]);
        $this->group_typography([
            'name' => 'desc_typography',
            'selector' => '{{WRAPPER}} .cs-post-meta .cs-post-meta__text',
        ]);

        $this->_start_controls_tabs([
            'name' => 'desc_style_tabs',
        ]);

        // Tab Normal Start
        $this->_start_controls_tab([
            'name' => 'desc_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'desc_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // Tab Hover Start
        $this->_start_controls_tab([
            'name' => 'desc_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name' => 'desc_color_hover',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__item:hover .cs-post-meta__text' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name' => 'desc_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-post-meta .cs-post-meta__text' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}