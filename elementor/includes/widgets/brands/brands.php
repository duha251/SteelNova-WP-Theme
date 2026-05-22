<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Brands extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-brands',
            'title'      => __( 'CS Brands', 'steelnova' ),
            'categories' => ['steelnova-woo'],
            'icon'       => 'eicon-filter',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'woocommerce', 'shop', 'product', 'brands', 'filter', 'product brand' ],
            'script'     => [],
            'style'      => [],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_item_style_controls();
        $this->register_link_style_controls();
        $this->register_name_style_controls();
        $this->register_count_style_controls();
        $this->register_checkbox_style_controls();
        $this->register_divider_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name'  => 'section_content',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $this->switcher([
            'name'    => 'show_divider',
            'label'   => __( 'Show Divider', 'steelnova' ),
            'default' => 'yes',
        ]);
        $this->end_controls_section();
    }

    // =========================================================================
    // STYLE CONTROLS
    // =========================================================================

    /**
     * Register Item (li) Style Controls.
     *
     * .cs-brands li        — each brand row: flex, gap 8px, align-items center
     * --cs-row-gap          — controls padding-block on the link (default 10px)
     */
    protected function register_item_style_controls() {
        $this->start_style_section([
            'name'  => 'section_item_style',
            'label' => __( 'Item', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'item_gap',
            'label' => __( 'Gap (checkbox ↔ link)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands li' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name'  => 'item_row_gap',
            'label' => __( 'Row Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands' => '--cs-row-gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'item_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'item_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'item_background',
            'selector' => '{{WRAPPER}} .cs-brands li',
        ]);
        $this->group_box_css([
            'name'     => 'item_box_css',
            'selector' => '{{WRAPPER}} .cs-brands li',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'item_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'item_background_hover',
            'selector' => '{{WRAPPER}} .cs-brands li:hover',
        ]);
        $this->group_box_css([
            'name'     => 'item_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-brands li:hover',
        ]);
        $this->time([
            'name'  => 'item_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands li' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Link Style Controls.
     *
     * .brand__link — flex row, space-between, font 17px, heading color, padding-block via --cs-row-gap
     */
    protected function register_link_style_controls() {
        $this->start_style_section([
            'name'  => 'section_link_style',
            'label' => __( 'Link', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'link_typography',
            'selector' => '{{WRAPPER}} .cs-brands li a.brand__link',
        ]);
        $this->size([
            'name'  => 'link_inner_gap',
            'label' => __( 'Inner Gap (name ↔ count)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands li a.brand__link' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'link_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'link_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'link_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands li a.brand__link' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'link_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'link_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands li:hover a.brand__link' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'link_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands li a.brand__link' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Brand Name Style Controls.
     *
     * .brand__name — the brand label text inside the link
     */
    protected function register_name_style_controls() {
        $this->start_style_section([
            'name'  => 'section_name_style',
            'label' => __( 'Brand Name', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'name_typography',
            'selector' => '{{WRAPPER}} .cs-brands .brand__name',
        ]);

        $this->_start_controls_tabs([ 'name' => 'name_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'name_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'name_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands .brand__name' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'name_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'name_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands li:hover .brand__name' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'name_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands .brand__name' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Brand Count Style Controls.
     *
     * .brand__count — the "(count)" text, default color #4B535D
     */
    protected function register_count_style_controls() {
        $this->start_style_section([
            'name'  => 'section_count_style',
            'label' => __( 'Count', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'count_typography',
            'selector' => '{{WRAPPER}} .cs-brands .brand__count',
        ]);

        $this->_start_controls_tabs([ 'name' => 'count_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'count_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'count_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands .brand__count' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'count_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'count_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands li:hover .brand__count' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'count_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands .brand__count' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Checkbox Style Controls.
     *
     * .check-box — the custom checkbox element beside each brand link
     */
    protected function register_checkbox_style_controls() {
        $this->start_style_section([
            'name'  => 'section_checkbox_style',
            'label' => __( 'Checkbox', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'checkbox_width',
            'label' => __( 'Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands .check-box' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->size([
            'name'  => 'checkbox_height',
            'label' => __( 'Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands .check-box' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'checkbox_style_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'checkbox_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'checkbox_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands .check-box' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name'     => 'checkbox_background',
            'selector' => '{{WRAPPER}} .cs-brands .check-box',
        ]);
        $this->group_box_css([
            'name'     => 'checkbox_box_css',
            'selector' => '{{WRAPPER}} .cs-brands .check-box',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'checkbox_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'checkbox_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands li:hover .check-box' => 'color: {{VALUE}};',
            ],
        ]);
        $this->group_background([
            'name'     => 'checkbox_background_hover',
            'selector' => '{{WRAPPER}} .cs-brands li:hover .check-box',
        ]);
        $this->group_box_css([
            'name'     => 'checkbox_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-brands li:hover .check-box',
        ]);
        $this->time([
            'name'  => 'checkbox_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands .check-box' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Divider Style Controls.
     *
     * .cs-brands.has-divider li + li — dotted border-top #4B535D between items
     * Only visible when show_divider = yes
     */
    protected function register_divider_style_controls() {
        $this->start_style_section([
            'name'      => 'section_divider_style',
            'label'     => __( 'Divider', 'steelnova' ),
            'condition' => [ 'show_divider' => 'yes' ],
        ]);

        $this->select([
            'name'    => 'divider_style',
            'label'   => __( 'Style', 'steelnova' ),
            'options' => [
                'dotted' => __( 'Dotted', 'steelnova' ),
                'dashed' => __( 'Dashed', 'steelnova' ),
                'solid'  => __( 'Solid', 'steelnova' ),
            ],
            'default' => 'dotted',
            'selectors' => [
                '{{WRAPPER}} .cs-brands.has-divider li + li' => 'border-top-style: {{VALUE}};',
            ],
        ]);
        $this->size([
            'name'  => 'divider_weight',
            'label' => __( 'Weight', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands.has-divider li + li' => 'border-top-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->color([
            'name'  => 'divider_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-brands.has-divider li + li' => 'border-top-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }
}
