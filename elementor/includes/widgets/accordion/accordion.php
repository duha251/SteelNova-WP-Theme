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
        $this->register_item_style_controls();
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
        $this->end_controls_section();
    }


    /**  
     * Register Item Style Controls
     *
     * Layout 1 : no border/bg on item, padding-top 20px; active icon gets orange bg
     * Layout 2 : item has border (#DCDCDC) + border-radius 4px; active item bg #121512
     * Layout 3 : item has border-radius 14px + overflow hidden; active header bg #FF5B1B
    */
    protected function register_item_style_controls() {
        $this->start_style_section([
            'name'  => 'section_item_style',
            'label' => __( 'Item', 'steelnova' ),
        ]);

        $this->start_controls_tabs( 'item_style_tabs' );

        // ── Normal ──────────────────────────────────────────────────────────
        $this->start_controls_tab( 'item_style_normal_tab', [ 'label' => __( 'Normal', 'steelnova' ) ] );

        $this->group_background([
            'name'     => 'item_background',
            'types'    => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item',
        ]);
        $this->group_border([
            'name'     => 'item_border',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item',
        ]);
        $this->dimensions([
            'name'  => 'item_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->group_box_shadow([
            'name'     => 'item_box_shadow',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item',
        ]);
        $this->dimensions([
            'name'  => 'item_padding',
            'label' => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();

        // ── Active / Hover ───────────────────────────────────────────────────
        $this->start_controls_tab( 'item_style_hover_tab', [ 'label' => __( 'Active / Hover', 'steelnova' ) ] );

        $this->group_background([
            'name'     => 'item_hover_background',
            'types'    => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active',
        ]);
        $this->group_border([
            'name'     => 'item_hover_border',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active',
        ]);
        $this->group_box_shadow([
            'name'     => 'item_hover_box_shadow',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active',
        ]);
        $this->time([
            'name'  => 'item_transition_duration',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**  
     * Register Header Style Controls
     *
     * Layout 1 : header has bottom padding + optional divider border-bottom
     * Layout 2 : header has padding 16px 25px 16px 20px, border-bottom transparent → active #706F6F
     * Layout 3 : header has border + bg (#FAF5ED / #FAE6D9), active bg #FF5B1B, border-radius 14px
    */
    protected function register_header_style_controls() {
        $this->start_style_section([ 
            'name'  => 'style_header_section', 
            'label' => __( 'Header', 'steelnova' ),
        ]);

        $this->start_controls_tabs( 'header_style_tabs' );

        // ── Normal ──────────────────────────────────────────────────────────
        $this->start_controls_tab( 'header_style_normal_tab', [ 'label' => __( 'Normal', 'steelnova' ) ] );

        $this->group_background([
            'name'     => 'header_background',
            'types'    => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__header',
        ]);
        $this->group_border([
            'name'     => 'header_border',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__header',
        ]);
        $this->dimensions([
            'name'  => 'header_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->group_box_shadow([
            'name'     => 'header_box_shadow',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__header',
        ]);
        $this->dimensions([
            'name'  => 'header_padding',
            'label' => __( 'Padding', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();

        // ── Active / Hover ───────────────────────────────────────────────────
        $this->start_controls_tab( 'header_style_hover_tab', [ 'label' => __( 'Active / Hover', 'steelnova' ) ] );

        // Layout 3 active header bg (#FF5B1B) + border-radius
        $this->color([
            'name'  => 'header_active_bg_color',
            'label' => __( 'Active Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__header, {{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__header' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'header_active_border_color',
            'label' => __( 'Active Border Color', 'steelnova' ),
            'selectors' => [
                // Layout 2: active header border-bottom
                '{{WRAPPER}} .cs-accordion[data-layout="2"] .cs-accordion__item.is-active .cs-accordion__header' => 'border-bottom-color: {{VALUE}};',
                // Layout 3: active header border transparent
                '{{WRAPPER}} .cs-accordion[data-layout="3"] .cs-accordion__item.is-active .cs-accordion__header' => 'border-color: {{VALUE}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'header_active_border_radius',
            'label' => __( 'Active Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [ 'layout' => [ '3' ] ],
        ]);
        $this->group_background([
            'name'     => 'header_hover_background',
            'types'    => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__header',
        ]);
        $this->group_box_css([
            'name'     => 'header_hover_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__header, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__header',
        ]);
        $this->time([
            'name'  => 'header_transition_duration',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__header' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**  
     * Register Title Style Controls
     *
     * Layout 1 : default heading color
     * Layout 2 : heading font 16px/600, heading color; active → white
     * Layout 3 : heading font 16px/600, heading color; active → white
    */
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name'  => 'section_title_style',
            'label' => __( 'Title', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__title',
        ]);
        $this->group_text_shadow([
            'name'     => 'title_text_shadow',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__title',
        ]);

        $this->start_controls_tabs( 'title_style_tabs' );

        // ── Normal ──────────────────────────────────────────────────────────
        $this->start_controls_tab( 'title_style_normal_tab', [ 'label' => __( 'Normal', 'steelnova' ) ] );

        $this->color([
            'name'  => 'title_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_text_stroke([
            'name'     => 'title_text_stroke',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__title',
        ]);

        $this->end_controls_tab();

        // ── Active / Hover ───────────────────────────────────────────────────
        $this->start_controls_tab( 'title_style_hover_tab', [ 'label' => __( 'Active / Hover', 'steelnova' ) ] );

        $this->color([
            'name'  => 'title_hover_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__title,
                 {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_text_stroke([
            'name'     => 'title_hover_text_stroke',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__title, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__title',
        ]);
        $this->time([
            'name'  => 'title_transition_duration',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__title' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    /**  
     * Register Icon Style Controls
     *
     * Layout 1 : icon 30px box, #E7ECEB bg, 13×1px plus lines; active → #FF5B1B bg, white color
     * Layout 2 : icon heading color, 14×3px rounded plus lines; active → white color
     * Layout 3 : icon 30px box, #121512 bg, white color, border; active → transparent bg, white border, svg rotates 90°
    */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name'  => 'section_icon_style',
            'label' => __( 'Icon', 'steelnova' ),
        ]);

        // ── Plus line dimensions ─────────────────────────────────────────────
        $this->heading([
            'name'  => 'icon_plus_heading',
            'label' => __( 'Plus Lines', 'steelnova' ),
            'separator' => 'none',
        ]);
        $this->size([
            'name'  => 'icon_plus_width',
            'label' => __( 'Line Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .icon-plus::after,
                 {{WRAPPER}} .cs-accordion .icon-plus::before' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name'  => 'icon_plus_height',
            'label' => __( 'Line Height (thickness)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .icon-plus::after,
                 {{WRAPPER}} .cs-accordion .icon-plus::before' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name'  => 'icon_plus_border_radius',
            'label' => __( 'Line Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .icon-plus::after,
                 {{WRAPPER}} .cs-accordion .icon-plus::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // ── Icon box dimensions ──────────────────────────────────────────────
        $this->heading([
            'name'  => 'icon_box_heading',
            'label' => __( 'Icon Box', 'steelnova' ),
        ]);
        $this->size([
            'name'  => 'icon_box_size_width',
            'label' => __( 'Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__icon' => '--cs-box-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name'  => 'icon_box_size_height',
            'label' => __( 'Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__icon' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs( 'icon_style_tabs' );

        // ── Normal ──────────────────────────────────────────────────────────
        $this->start_controls_tab( 'icon_style_normal_tab', [ 'label' => __( 'Normal', 'steelnova' ) ] );

        $this->color([
            'name'  => 'icon_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'icon_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__icon' => 'background-color: {{VALUE}};',
            ],
            // Layout 1 & 3 have a bg on the icon box; layout 2 does not
            'condition' => [ 'layout' => [ '1', '3' ] ],
        ]);
        $this->group_border([
            'name'     => 'icon_border',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__icon',
        ]);
        $this->dimensions([
            'name'  => 'icon_border_radius',
            'label' => __( 'Border Radius', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();

        // ── Active / Hover ───────────────────────────────────────────────────
        $this->start_controls_tab( 'icon_style_hover_tab', [ 'label' => __( 'Active / Hover', 'steelnova' ) ] );

        $this->color([
            'name'  => 'icon_hover_color',
            'label' => __( 'Icon Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__icon,
                 {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__icon' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'icon_active_bg_color',
            'label' => __( 'Active Background Color', 'steelnova' ),
            'selectors' => [
                // Layout 1: active icon gets orange bg
                '{{WRAPPER}} .cs-accordion[data-layout="1"] .cs-accordion__item.is-active .cs-accordion__icon' => 'background-color: {{VALUE}};',
                // Layout 3: active icon gets transparent bg
                '{{WRAPPER}} .cs-accordion[data-layout="3"] .cs-accordion__item.is-active .cs-accordion__icon' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '1', '3' ] ],
        ]);
        $this->color([
            'name'  => 'icon_active_border_color',
            'label' => __( 'Active Border Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__icon' => 'border-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '3' ] ],
        ]);
        $this->group_box_css([
            'name'     => 'icon_hover_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__item:hover .cs-accordion__icon, {{WRAPPER}} .cs-accordion .cs-accordion__item.is-active .cs-accordion__icon',
        ]);
        $this->time([
            'name'  => 'icon_transition_duration',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__item .cs-accordion__icon' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**  
     * Register Content Style Controls
     *
     * Layout 1 : content p has padding-block 22px/16px, max-width 675px, default text color
     * Layout 2 : content white text, 14px, padding 18.5px 21px on p
     * Layout 3 : content white text on #121512 bg, 14px, padding 25px 20px 29px 23.5px on p
    */
    protected function register_content_style_controls() {
        $this->start_style_section([ 
            'name'  => 'section_content_style', 
            'label' => __( 'Content', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'content_typography',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__content p',
        ]);

        $this->color([
            'name'  => 'content_text_color',
            'label' => __( 'Text Color', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__content p' => 'color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name'  => 'content_link_color',
            'label' => __( 'Link Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__content a' => 'color: {{VALUE}};',
            ],
        ]);

        // Background — layout 2 & 3 have a dark bg on the content wrapper
        $this->color([
            'name'  => 'content_bg_color',
            'label' => __( 'Background Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__content' => 'background-color: {{VALUE}};',
            ],
            'condition' => [ 'layout' => [ '2', '3' ] ],
        ]);

        $this->dimensions([
            'name'  => 'content_padding',
            'label' => __( 'Content Padding', 'steelnova' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .cs-accordion .cs-accordion__content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->group_box_css([
            'name'     => 'content_',
            'selector' => '{{WRAPPER}} .cs-accordion .cs-accordion__content p',
        ]);

        $this->end_controls_section();
    }
}