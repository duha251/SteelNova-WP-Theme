<?php
namespace SteelNova\Elementor\Widgets;

use SteelNova\Elementor\Base\SteelNova_Widget_Base;
use SteelNova\Inc\Helpers\Static_Options;


if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Products_Listing extends SteelNova_Widget_Base {
    /**
     * Get the widget information.
     */
    protected function widget_info() {
        return [
            'name'       => 'steelnova-products-listing',
            'title'      => __( 'CS Posts Listing', 'steelnova' ),
            'categories' => ['steelnova-woo'],
            'icon'       => 'eicon-post-list',
            'keywords'   => [ 'posts', 'grid', 'blog', 'news', 'steelnova', 'cs', 'casetheme' ],
            'script'     => [],
            'style'      => ['steelnova-widget-product'],
        ];
    }

    /**
     * Register all controls for the widget.
     */
    public function register_controls() {
        // Layout Controls
        // $this->register_layout_controls();
        // Content Controls
        $this->register_content_controls();
        // Style Controls
        $this->register_product_item_style_controls();
        $this->register_product_thumbnail_style_controls();
        $this->register_product_name_style_controls();
        // Settings Controls
                // Steelnova Controls
        $this->register_steelnova_extra_controls();
        $this->register_steelnova_animation_controls();
    }


    /**
     * Register Content Controls.
     */
    protected function register_content_controls() {
        $this->start_content_section([
            'name' => 'section_content',
            'label' => __( 'Source', 'steelnova' ),
        ]);
        $this->hidden([
            'name' => 'post_type',
            'default' => 'product',
        ]);

        $this->select([
            'name'    => 'query_type',
            'label'   => __('Query Type', 'steelnova'),
            'default' => '',
            'options' => [
                ''             => __('Default', 'steelnova'),
                'popular'      => __('Popular', 'steelnova'),
                'featured'     => __('Featured', 'steelnova'),
                'on_sale'      => __('On Sale', 'steelnova'),
                'best_selling' => __('Best Selling', 'steelnova'),
                'top_rated'    => __('Top Rated', 'steelnova'),
                'random'       => __('Random', 'steelnova'),
                'recent'       => __('Recent', 'steelnova'),
            ],
        ]);
        $this->select([
            'name' => 'source_type',
            'label' => __('Source Type', 'steelnova'),
            'default' => 'id' ,
            'options' => [
                'id'       => __('ID', 'steelnova'),
                'category' => __('Category', 'steelnova'),
            ]
        ]);
        $this->select2([
            'name' =>'ids',
            'label_block' => true,
            'label' => __('List Post', 'steelnova'),
            'options' => steelnova()->post_manager->get_cpt_post_list( 'product' ),
            'multiple' => true,
            'condition' => [
                'source_type' => 'id',
            ]
        ]);
        $this->select2([
            'name' =>'categories',
            'label_block' => true,
            'label' => __('Categories', 'steelnova'),
            'options' => steelnova()->post_manager->get_cpt_category_list( 'product_cat' ),
            'multiple' => true,
            'condition' => [
                'source_type' => 'category',
            ]
        ]);
        $this->select([
            'name' => 'orderby',
            'label' => __('Order By', 'steelnova'),
            'separator' => 'before',
            'options' => [
                'date'  => __('Date', 'steelnova'),
                'title' => __('Title', 'steelnova'),
                'author'=> __('Author', 'steelnova'),
                'id'    => __('ID', 'steelnova'),
                'rand'  => __('Random', 'steelnova'),
            ],
            'default' => 'date'
        ]);
        $this->select([
            'name' => 'order',
            'label' => __('Order', 'steelnova'),
            'options' => [
                'ASC'  => __('Ascending', 'steelnova'),
                'DESC' => __('Descending', 'steelnova'),
            ],
            'default' => 'DESC'
        ]);
        $this->number([
            'name' => 'posts_per_page',
            'label' => __('Posts Per Page', 'steelnova'),
            'min'   => -1,
            'default' => 6,
            'method' => 'add_control',
            'description' => __('To get all posts leave the value as -1', 'steelnova')
        ]);
        $this->end_controls_section();
    }

    /**
     * Product Item (.products-listing .product)
     * CSS: gap, align-items — list gap + item gap
     */
    protected function register_product_item_style_controls() {
        $this->start_style_section([
            'name'  => 'section_product_item_style',
            'label' => __( 'Product Item', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'products_list_gap',
            'label'     => __( 'List Gap', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'product_item_gap',
            'label'     => __( 'Item Gap (Thumbnail ↔ Content)', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'product_item_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'product_item_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'product_item_bg',
            'selector' => '{{WRAPPER}} .products-listing .product',
        ]);
        $this->group_box_css([
            'name'     => 'product_item_',
            'selector' => '{{WRAPPER}} .products-listing .product',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'product_item_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'product_item_bg_hover',
            'selector' => '{{WRAPPER}} .products-listing .product:hover',
        ]);
        $this->group_box_css([
            'name'     => 'product_item_hover_',
            'selector' => '{{WRAPPER}} .products-listing .product:hover',
        ]);
        $this->time([
            'name'      => 'product_item_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Product Thumbnail (.products-listing .product__thumbnail)
     * CSS: flex-basis, min-width, padding, min-height, border-radius, border
     */
    protected function register_product_thumbnail_style_controls() {
        $this->start_style_section([
            'name'  => 'section_product_thumbnail_style',
            'label' => __( 'Thumbnail', 'steelnova' ),
        ]);

        $this->size([
            'name'      => 'thumbnail_width',
            'label'     => __( 'Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product__thumbnail' => 'flex: 0 1 {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'thumbnail_min_width',
            'label'     => __( 'Min Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product__thumbnail' => 'min-width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'thumbnail_min_height',
            'label'     => __( 'Min Height', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product__thumbnail' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->size([
            'name'      => 'thumbnail_img_max_width',
            'label'     => __( 'Image Max Width', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product__thumbnail img' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'thumbnail_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'thumbnail_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'thumbnail_bg',
            'selector' => '{{WRAPPER}} .products-listing .product__thumbnail',
        ]);
        $this->group_box_css([
            'name'     => 'thumbnail_',
            'selector' => '{{WRAPPER}} .products-listing .product__thumbnail',
        ]);
        $this->group_css_filter([
            'name'     => 'thumbnail_img_filter',
            'selector' => '{{WRAPPER}} .products-listing .product__thumbnail img',
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'thumbnail_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->group_background([
            'name'     => 'thumbnail_bg_hover',
            'selector' => '{{WRAPPER}} .products-listing .product:hover .product__thumbnail',
        ]);
        $this->group_box_css([
            'name'     => 'thumbnail_hover_',
            'selector' => '{{WRAPPER}} .products-listing .product:hover .product__thumbnail',
        ]);
        $this->group_css_filter([
            'name'     => 'thumbnail_img_filter_hover',
            'selector' => '{{WRAPPER}} .products-listing .product:hover .product__thumbnail img',
        ]);
        $this->time([
            'name'      => 'thumbnail_transition',
            'label'     => __( 'Transition Duration', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product__thumbnail' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Product Name (.products-listing .product__name)
     * CSS: margin-top, color, hover color
     */
    protected function register_product_name_style_controls() {
        $this->start_style_section([
            'name'  => 'section_product_name_style',
            'label' => __( 'Product Name', 'steelnova' ),
        ]);

        $this->group_typography([
            'name'     => 'product_name_typography',
            'selector' => '{{WRAPPER}} .products-listing .product__name',
        ]);

        $this->size([
            'name'      => 'product_name_margin_top',
            'label'     => __( 'Margin Top', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product__name' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->_start_controls_tabs([ 'name' => 'product_name_tabs' ]);

        $this->_start_controls_tab([
            'name'  => 'product_name_tab_normal',
            'label' => __( 'Normal', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'product_name_color',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product__name,
                 {{WRAPPER}} .products-listing .product__name > a' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->_start_controls_tab([
            'name'  => 'product_name_tab_hover',
            'label' => __( 'Hover', 'steelnova' ),
        ]);
        $this->color([
            'name'      => 'product_name_color_hover',
            'label'     => __( 'Color', 'steelnova' ),
            'selectors' => [
                '{{WRAPPER}} .products-listing .product__name:hover,
                 {{WRAPPER}} .products-listing .product__name > a:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

}