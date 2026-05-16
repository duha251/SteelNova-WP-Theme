<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Accordion extends SteelNova_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'steelnova-accordion',
            'title'      => __( 'CS Accordion', 'steelnova' ),
            'icon'       => 'eicon-accordion',
            'keywords'   => [ 'accordion', 'faq', 'faqs', 'toggle', 'collapse', 'expand', 'steelnova', 'tabs', 'content' ],
            'script'     => ['steelnova-accordion'],
            'style'      => ['steelnova-widget-accordion'],
        ];
    }

    /**
     * Register Controls
     */
    protected function register_controls() {
        // Content
        $this->register_layout_controls();
        $this->register_css_layout_controls();
        $this->register_content_controls();
        $this->register_interactions_content_controls();
        // Style
        $this->register_header_style_controls();
        $this->register_title_style_controls();
        $this->register_content_style_controls();
        $this->register_icon_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
    }

    /**  
     * Register Layout Style Controls
    */
    protected function register_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_style_layout_style', 
            'label' => __('Layout', 'steelnova'),
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'steelnova'),
            'columns' => '1',
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Layout 1', 'steelnova' ),
                    'image' => content_url('/uploads/default-assets/layout/accordion_2.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Layout 2', 'steelnova' ),
                    'image' => content_url('/uploads/default-assets/layout/accordion_2.webp'),
                ],
                '3' => [
                    'title' => esc_attr__( 'Layout 3', 'steelnova' ),
                    'image' => content_url('/uploads/default-assets/layout/accordion_3.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**  
     * Register Layout Controls
    */
    protected function register_css_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_css_layout_style', 
            'label' => __('Layout CSS', 'steelnova'),
        ]);
        $this->size([
            'name' => 'desc_max_width',
            'label' => __('Description Max Width', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__content > p' => 'max-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->size([
            'name' => 'item_spacing',
            'label' => __('Item Spacing', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item + .cs-accordion__item' => 'margin-top: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /**  
     * Register Content Controls
    */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Content', 'steelnova')
        ]);
        $this->select([
            'name' => 'title_tag',
            'label' => __('Title Tag HTML', 'steelnova'),
            'options' => Static_Options::title_html_tag_options(),
            'default' => 'h6'
        ]);
        $this->switcher([
            'name' => 'show_index',
            'label' => __('Show Index', 'steelnova'),
            'default' => '',
        ]);
        $this->switcher([
            'name' => 'show_divider',
            'label' => __('Show Divider', 'steelnova'),
            'default' => '',
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->color([
            'name' => 'divider_color',
            'label' => __('Divider Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion.has-divider .cs-accordion__item .cs-accordion__header' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .cs-accordion.has-divider .cs-accordion__item:last-child .cs-accordion__header' => 'border-color: transparent;',
            ],
            'condition' => [
                'show_divider' => 'yes'
            ]
        ]);
        $this->text([
            'name' => 'index_prefix',
            'label' => __('Index Prefix', 'steelnova'),
            'label_block' => false,
            'condition' => [
                'show_index' => 'yes'
            ],
        ]);
        $this->text([
            'name' => 'index_suffix',
            'label' => __('Index Suffix', 'steelnova'),
            'label_block' => false,
            'condition' => [
                'show_index' => 'yes'
            ],
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'steelnova'),
            'title_field' => '{{{ title }}}',
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __('Title', 'steelnova'),
                    'type' => 'textarea',
                    'rows' => 3,
                    'default' => __('Your Title', 'steelnova'),
                ],
                [
                    'name' => 'content',
                    'label' => __('Content', 'steelnova'),
                    'type' => 'wysiwyg',
                    'default' => __('Accordion content. Click the edit to change this text.', 'steelnova')
                ],
            ],
            'default' => [
                [
                    'title' => __('Title #1', 'steelnova'),
                    'content' => __('Accordion content. Click the edit to change this text.', 'steelnova')
                ],
                [
                    'title' => __('Title #2', 'steelnova'),
                    'content' => __('Accordion content. Click the edit to change this text.', 'steelnova')
                ],
                [
                    'title' => __('Title #3', 'steelnova'),
                    'content' => __('Accordion content. Click the edit to change this text.', 'steelnova')
                ],
            ]
        ]);
        $this->end_controls_section();
    }

    /**  
     * Register Interactions Content Controls
    */
    protected function register_interactions_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_interactions_content', 
            'label' => __('Interactions', 'steelnova')
        ]);
        $this->number([
            'name' => 'default_active',
            'label' => __('Default Active', 'steelnova'),
            'min'  => -1,
            'default' => 1,
            'description' => __('No default item is activated if left blank.', 'steelnova'),
        ]);
        $this->select([
            'name' => 'mode',
            'label' => __('Mode', 'steelnova'),
            'default'  => 'one',
            'options' => [
                'one'      => __('One Item Active', 'steelnova'),
                'multiple' => __('Multiple Items Active', 'steelnova')
            ],
        ]);
        $this->select([
            'name' => 'toggle',
            'label' => __('Toggle', 'steelnova'),
            'default'  => 'one',
            'options' => [
                'on'      => __('On', 'steelnova'),
                'off' => __('Off', 'steelnova')
            ],
            'default' => 'on'
        ]);
        $this->select([
            'name' => 'hide_icon_item_actived',
            'label' => __('Hide Icon Item Actived', 'steelnova'),
            'default'  => 'no',
            'options' => [
                'no'    => __('No', 'steelnova'),
                'yes'   => __('Yes', 'steelnova')
            ],
            'selectors_dictionary' => [
                'no' => '',
                'yes' => '0',
            ],
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__icon' => 'scale: {{VALUE}};'
            ]
        ]);
        // $this->switcher([
        //     'name' => 'use_default_icon',
        //     'label' => __('Use Default Icon', 'steelnova'),
        //     'default' => 'yes',
        // ]);
        // $this->icons([
        //     'name' => 'close_icon',
        //     'label' => __('Close Icon', 'steelnova'),
        //     'condition' => [
        //         'use_default_icon!' => 'yes'
        //     ]
        // ]);
        // $this->icons([
        //     'name' => 'open_icon',
        //     'label' => __('Open Icon', 'steelnova'),
        //     'condition' => [
        //         'use_default_icon!' => 'yes'
        //     ]
        // ]);
        $this->end_controls_section();
    }

    /**  
     * Register Layout Style Controls
    */
    protected function register_layout_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_layout_style', 
            'label' => __('Layout', 'steelnova'),
        ]);
        $this->slider([
            'name' => 'desc_max_w',
            'label' => __('Description Max Width', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .accordion-content p' => 'max-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'item_spacing',
            'label' => __('Item Spacing', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item + .cs-accordion__item' => 'margin-top: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->dimensions([
            'name' => 'index_margin',
            'label' => __( 'Index Margin', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .accordion-index' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->group_background([
            'name' => 'box_gradient_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .box-border-gradient',
            'fields_options' => [			
				'color' => [
					'selectors' => [
						'{{WRAPPER}} .cs-accordion .box-border-gradient' => '--mv-background-color: {{VALUE}};',
					],
				],
                'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .cs-accordion .box-border-gradient' => '--mv-background-color-b: {{VALUE}};',
					],
				],
			],
            'condition' => [
                'layout_style' => ['2']
            ]
		]);
        $this->color([
            'name' => 'gradient_color_1',
            'label' => __('Gradient Color 1', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_2',
            'label' => __('Gradient Color 2', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-2: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_3',
            'label' => __('Gradient Color 3', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-3: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_4',
            'label' => __('Gradient Color 4', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-4: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_5',
            'label' => __('Gradient Color 5', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-5: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->color([
            'name' => 'gradient_color_6',
            'label' => __('Gradient Color 6', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}}' => '--gradient-color-6: {{VALUE}};',
            ],
            'condition' => [
                'layout_style' => ['2']
            ]
        ]);
        $this->end_controls_section();
    }

    /**  
     * Register Box Style Controls
    */
    protected function register_box_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_box_style', 
            'label' => __('Box', 'steelnova'),
        ]);

        $this->start_controls_tabs( 'box_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'box_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'steelnova' ) 
            ] 
        );
        $this->group_background([
            'name' => 'box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item',
		]);
        $this->group_box_css([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item, {{WRAPPER}} .accordion[data-layout_style="2"] .cs-accordion__item .box-border-gradient',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'box_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'steelnova' ) 
            ] 
        );
        $this->group_background([
            'name' => 'box_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:not(.box-gradient):hover, 
                            {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active:not(.box-gradient),
                            {{WRAPPER}} .cs-accordion .box-gradient:before, 
                            {{WRAPPER}} .cs-accordion .is-active.box-gradient:before',
		]);
        $this->group_box_css([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active, 
            {{WRAPPER}} .accordion[data-layout_style="2"] .cs-accordion__item:hover .box-border-gradient, {{WRAPPER}} .accordion[data-layout_style="2"] .cs-accordion__item.is-active .box-border-gradient',
        ]);
        $this->time([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item, {{WRAPPER}} .cs-accordion .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**  
     * Register Header Style Controls
    */
    protected function register_header_style_controls() {
        $this->start_style_section([ 
            'name' => 'style_header_section', 
            'label' => __('Header', 'steelnova'),
        ]);

        $this->start_controls_tabs( 'header_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'header_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'steelnova' ) 
            ] 
        );
        $this->group_background([
            'name' => 'header_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__header',
		]);
        $this->group_box_css([
            'name' => 'header_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__header',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'header_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'steelnova' ) 
            ] 
        );
        $this->group_background([
            'name' => 'header_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__header:not(.box-gradient), 
                            {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__header:not(.box-gradient),
                            {{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__header.box-gradient:before,
                            {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__header.box-gradient:before',
		]);
        $this->group_box_css([
            'name' => 'header_hover_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__header, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__header',
        ]);
        $this->time([
            'name' => 'header_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__header, {{WRAPPER}} .cs-accordion .cs-accordion__header.box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**  
     * Register Title Style Controls
    */
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name' => 'section_title_style',
            'label' => __('Title', 'steelnova'),
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__title',
        ]);
        $this->group_text_shadow([
            'name' => 'title_text_shadow',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__title',
        ]);
        $this->start_controls_tabs( 'title_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'title_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'steelnova' ) 
            ] 
        );
        $this->color([
			'name' => 'title_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__title' => 'color: {{VALUE}};',
            ],
		]);
        $this->group_text_stroke([
            'name' => 'title_text_stroke',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__title',
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'title_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'steelnova' ) 
            ] 
        );  
        $this->color([
			'name' => 'title_hover_color',
            'label' => __('Text Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__title, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__title' => 'color: {{VALUE}};',
            ],
		]);
        $this->group_text_stroke([
            'name' => 'title_hover_text_stroke',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__title, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__title',
        ]);
        $this->time([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    /**  
     * Register Icon Style Controls
    */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __('Icon', 'steelnova'),
        ]);
        $this->size([
            'name' => 'icon_plus_width',
            'label' => __('Icon Width', 'steelnova'),
            'size_units' => ['px', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .icon-plus:after, {{WRAPPER}} .cs-accordion .icon-plus:before' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->size([
            'name' => 'icon_plus_height',
            'label' => __('Icon Height', 'steelnova'),
            'size_units' => ['px', 'custom'],
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .icon-plus:after, {{WRAPPER}} .cs-accordion .icon-plus:before' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->size([
            'name' => 'icon_box_size_width',
            'separator' => 'before',
            'label' => __('Box width', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__icon' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->size([
            'name' => 'icon_box_size_height',
            'label' => __('Box Height', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__icon' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->start_controls_tabs( 'icon_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'icon_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'steelnova' ) 
            ] 
        );
        $this->color([
            'name' => 'icon_color',
            'label' => __('Icon Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__icon',
		]);
        $this->group_box_css([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__icon',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'icon_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'steelnova' ) 
            ] 
        );
        $this->color([
            'name' => 'icon_hover_color',
            'label' => __('Icon Color', 'steelnova'),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__icon, 
                {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__icon:not(.box-gradient), 
            {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__icon:not(.box-gradient),
            {{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__icon.box-gradient:before',
		]);
        $this->group_box_css([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__icon, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__icon',
        ]);
        $this->time([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**  
     * Register Content Style Controls
    */
    protected function register_content_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_content_style', 
            'label' => __('Content', 'steelnova'),
        ]);
        $this->group_typography([
            'name' => 'content_typography',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__content p',
        ]);
        $this->color([
            'name' => 'content_text_color',
            'label' => __('Text Color', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__content p' => 'color: {{VALUE}};'
            ],
        ]);
        $this->color([
            'name' => 'content_link_color',
            'label' => __('Link Color', 'steelnova'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__content a' => 'color: {{VALUE}};'
            ],
        ]);
        $this->group_background([
            'name' => 'content_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__content',
		]);
        $this->group_box_css([
            'name' => 'content_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__content p'
        ]);
        $this->end_controls_section();
    }
}