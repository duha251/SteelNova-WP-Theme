<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Categories extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-categories',
            'title'      => __( 'CS Categories', 'steelnova' ),
            'icon'       => 'eicon-filter',
            'keywords'   => [ 'cs', 'casethemes', 'steelnova', 'categories', 'category', 'filter', 'post', 'product', 'taxonomy' ],
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
        $this->register_divider_style_controls();
        // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }

    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $post_types = [
            'post'    => __( 'Post', 'steelnova' ),
            'service' => __( 'Service', 'steelnova' ),
            'project' => __( 'Project', 'steelnova' ),
            'product' => __( 'Product', 'steelnova' ),
        ];

        $this->start_content_section([
            'name'  => 'section_content',
            'label' => __( 'Content', 'steelnova' ),
        ]);
        $this->switcher([
            'name'    => 'show_divider',
            'label'   => __( 'Show Divider', 'steelnova' ),
            'default' => 'yes',
        ]);
        $this->select([
            'name'    => 'post_type',
            'label'   => __( 'Post Type', 'steelnova' ),
            'options' => $post_types,
            'default' => 'post',
        ]);
        foreach ( $post_types as $key => $value ) {
            if ( $key === 'post' ) {
                $taxonomy = 'category';
            } elseif ( $key === 'product' ) {
                $taxonomy = 'product_cat';
            } else {
                $taxonomy = $key . '_category';
            }
            $this->select2([
                'name'        => $key . '_categories',
                'label_block' => true,
                'label'       => $value . __( ' Categories', 'steelnova' ),
                'options'     => steelnova()->post_manager->get_cpt_category_list( $taxonomy ),
                'multiple'    => true,
                'condition'   => [
                    'post_type' => $key,
                ],
            ]);
        }
        $this->end_controls_section();
    }

    // =========================================================================
    // STYLE CONTROLS
    // =========================================================================

    /**
     * Register Item (li) Style Controls.
     *
     * .cs-categories li     — each category row
     * --cs-row-gap           — controls padding-block on the link (default 10px)
     */
    protected function register_item_style_controls() {
        $this->start_style_section([
            'name'  => 'section_item_style',
            'label' => __( 'Item', 'steelnova' ),
        ]);

        $this->size([
            'name'  => 'item_row_gap',
            'label' => __( 'Row Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-categories' => '--cs-row-gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'item_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'item_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'item_background',
            'selector' => '{{WRAPPER}} .cs-categories li',
        ]);
        $this->group_box_css([
            'name'     => 'item_box_css',
            'selector' => '{{WRAPPER}} .cs-categories li',
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'item_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'item_background_hover',
            'selector' => '{{WRAPPER}} .cs-categories a:hover',
        ]);
        $this->group_box_css([
            'name'     => 'item_box_css_hover',
            'selector' => '{{WRAPPER}} .cs-categories a:hover',
        ]);
        $this->time([
            'name'  => 'item_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-categories li' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Link Style Controls.
     *
     * .category__link — flex row, space-between, font 17px, heading color, padding-block via --cs-row-gap
     */
    protected function register_link_style_controls() {
        $this->start_style_section([
            'name'  => 'section_link_style',
            'label' => __( 'Link', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'link_typography',
            'selector' => '{{WRAPPER}} .cs-categories li a.category__link',
        ]);

        $this->_start_controls_tabs([ 'name' => 'link_style_tabs' ]);

        // ── Normal ──────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'link_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'link_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-categories a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        // ── Hover ────────────────────────────────────────────────────────────
        $this->_start_controls_tab([
            'name'  => 'link_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'  => 'link_color_hover',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-categories a:hover, {{WRAPPER}} .cs-categories a[aria-current="page"]' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'link_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-categories a.category__link' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Category Name Style Controls.
     *
     * .category__name — the category label text inside the link
     */
    protected function register_name_style_controls() {
        $this->start_style_section([
            'name'  => 'section_name_style',
            'label' => __( 'Category Name', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'name_typography',
            'selector' => '{{WRAPPER}} .cs-categories .category__name',
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
                '{{WRAPPER}} .cs-categories .category__name' => 'color: {{VALUE}};',
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
                '{{WRAPPER}} .cs-categories a:hover .category__name' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'name_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-categories .category__name' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Category Count Style Controls.
     *
     * .category__count — the "(count)" text, default color #4B535D
     */
    protected function register_count_style_controls() {
        $this->start_style_section([
            'name'  => 'section_count_style',
            'label' => __( 'Count', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'count_typography',
            'selector' => '{{WRAPPER}} .cs-categories .category__count',
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
                '{{WRAPPER}} .cs-categories .category__count' => 'color: {{VALUE}};',
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
                '{{WRAPPER}} .cs-categories a:hover .category__count' => 'color: {{VALUE}};',
            ],
        ]);
        $this->time([
            'name'  => 'count_transition',
            'label' => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-categories .category__count' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Divider Style Controls.
     *
     * .cs-categories.has-divider li + li — dotted border-top #4B535D between items
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
                '{{WRAPPER}} .cs-categories.has-divider li + li' => 'border-top-style: {{VALUE}};',
            ],
        ]);
        $this->size([
            'name'  => 'divider_weight',
            'label' => __( 'Weight', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-categories.has-divider li + li' => 'border-top-width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->color([
            'name'  => 'divider_color',
            'label' => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .cs-categories.has-divider li + li' => 'border-top-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }
}
